<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\TemporalCompraModel;
use App\Models\DetalleCompraModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;

class Compras extends BaseController
{
    protected $compras, $temporal_compra, $detalle_compra, $productos, $configuracion;
    protected $reglas;

    public function __construct()
    {
        $this->compras = new ComprasModel();
        $this->detalle_compra = new DetalleCompraModel();
        $this->configuracion = new ConfiguracionModel();
        helper(['form']);
    }

    public function index($activo = 1)
    {
        $compras = $this->compras->where('activo',$activo)->findAll();
        $data = ['titulo' => 'Compras', 'compras' => $compras];

        echo view('header');
        echo view('compras/compras', $data);
        echo view('footer');
    }

    //Parar Crear
    public function nuevo()
    {
        $data = ['titulo' => 'Agregar Unidad'];

        echo view('header');
        echo view('compras/nuevo');
        echo view('footer');
    }

    public function guarda()
    {
        $id_compra = $this->request->getPost('id_compra');
        $total = preg_replace('/[\$,]/', '', $this->request->getPost('total'));

        $session = session();

        $resultadoId = $this->compras->insertaCompra($id_compra, $total, $session->id_usuario);

        $this->temporal_compra = new TemporalCompraModel();

        if($resultadoId){
            $resultadoCompra = $this->temporal_compra->porCompra($id_compra);

            foreach($resultadoCompra as $row){
                $this->detalle_compra->save([
                    'id_compra'     => $resultadoId,
                    'id_producto'   => $row['id_producto'],
                    'nombre'        => $row['nombre'],
                    'cantidad'      => $row['cantidad'],
                    'precio'        => $row['precio'],
                ]);

                $this->productos = new ProductosModel();
                $this->productos->actualizarStock($row['id_producto'], $row['cantidad']);
            }
            $this->temporal_compra->eliminarCompra($id_compra);
        }
        //return redirect()->to(base_url()."/productos");
        return redirect()->to(base_url()."/compras/muestraCompraPdf/" . $resultadoId);
    }

    function muestraCompraPdf($id_compra){
        
        $data['id_compra'] = $id_compra;
        echo view('header');
        echo view('compras/ver_compra_pdf', $data);
        echo view('footer');

    }

    function generaCompraPdf($id_compra){
        
        $datosCompra = $this->compras->where('id', $id_compra)->first();
        $detalleCompra = $this->detalle_compra->select('*')->where('id_compra', $id_compra)->findAll();
    
        $nombreTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
        $direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;
        
        $pdf = new \FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle("Compra");
        $pdf->SetFont('Arial', 'B', 20);

        //titulo
        $pdf->Cell(195, 5, "Entrada de productos", 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->image(base_url() . '/images/logo.png', 180, 10, 25, 25, 'PNG');
        //NOMBRE
        $pdf->Cell(50, 5, $nombreTienda, 0, 1, 'L');
        //DIRECCION
        $pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, $direccionTienda, 0, 1, 'L');
        //FECHA
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(25, 5, utf8_decode('Fecha y hora: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, $datosCompra['fecha_alta'], 0, 1, 'L');

        $pdf->Ln();
        $pdf->Ln();

        //TABLA-------------------------------------------------------------   

        $pdf->SetFont('Arial', 'B', 12);
        //ENCABEZADO COMPRA 1RA LINEA 
        $pdf -> SetFillColor(128, 186, 219);
        $pdf -> SetTextColor(0, 0, 0);
        $pdf -> Cell(195, 6, 'Detalle de productos', 1, 1, 'C', 1);
        // Encabezados de la tabla
        $pdf -> SetFillColor(249, 247, 193);
        $pdf -> Cell(15, 6, utf8_decode('N°'), 1, 0, "C", 1);
        $pdf -> Cell(30, 6, 'Codigo', 1, 0, "C", 1);
        $pdf -> Cell(70, 6, "Nombre", 1, 0, "C", 1);
        $pdf -> Cell(25, 6, "Precio", 1, 0, "C", 1);
        $pdf -> Cell(25, 6, "Cantidad", 1, 0, "C", 1);
        $pdf -> Cell(30, 6, "Importe", 1, 1, "C", 1);

        $pdf->SetFont('Arial', '', 10);
        
        //PRODUCTOS
        $contador = 1;

        foreach($detalleCompra as $row){
            $pdf -> Cell(15, 6, $contador, 1, 0, "C");
            $pdf -> Cell(30, 6, $row['id_producto'], 1, 0, "C");
            $pdf -> Cell(70, 6, $row['nombre'], 1, 0, "C");
            $pdf -> Cell(25, 6, $row['precio'], 1, 0, "C");
            $pdf -> Cell(25, 6, $row['cantidad'], 1, 0, "C");
            $importe = number_format($row['precio'] *  $row['cantidad'], 2, '.', ',');
            $pdf -> Cell(30, 6, 'S/.' . $importe, 1, 1, "C");
            $contador++;
        }

        //TOTAL
        $pdf->SetFont('Arial', 'B', 10);
        $pdf -> SetFillColor(248, 181, 95);
        $pdf->Cell(165, 5, '', 0, 0, 'R');
        $pdf->Cell(30, 5, 'Total: S/.' . number_format($datosCompra['total'], 2, '.', ',') , 1, 1, 'L', 1);


        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("compra_pdf.pdf", "I");

    }

}