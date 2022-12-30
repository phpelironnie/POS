<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\TemporalCompraModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;
use App\Models\CajasModel;

class Ventas extends BaseController
{
    protected $ventas, $temporal_compra, $detalle_venta, $productos;

    public function __construct()
    {
        $this->ventas           = new VentasModel();
        $this->detalle_venta    = new DetalleVentaModel();
        $this->productos        = new ProductosModel();
        $this->configuracion    = new ConfiguracionModel();
        $this->cajas            = new CajasModel();

        helper(['form']);
    }

    public function index()
    {
        $datos = $this->ventas->obtener(1);
        $data = ['titulo' => 'Ventas', 'datos' => $datos];

        echo view('header');
        echo view('ventas/ventas', $data);
        echo view('footer');
    }

    public function eliminados()
    {
        $datos = $this->ventas->obtener(0);
        $data = ['titulo' => 'Ventas canceladas', 'datos' => $datos];

        echo view('header');
        echo view('ventas/eliminados', $data);
        echo view('footer');
    }

    //Parar Crear
    public function venta()
    {
        echo view('header');
        echo view('ventas/caja');
        echo view('footer');
    }

    public function guarda()
    {
        $id_venta   = $this->request->getPost('id_venta');
        $id_cliente = $this->request->getPost('id_cliente');
        $forma_pago = $this->request->getPost('forma_pago');

        $total = preg_replace('/[\$,]/', '', $this->request->getPost('total'));

        $session = session();
        
        $caja = $this->cajas->where('id',$session->id_caja)->first();
        $folio = $caja['folio'];


        $resultadoId = $this->ventas->insertaVenta($id_venta, $total, $session->id_usuario, $session->id_caja, $id_cliente, $forma_pago);

        $this->temporal_compra = new TemporalCompraModel();

        if($resultadoId){
            $resultadoCompra = $this->temporal_compra->porCompra($id_venta);

            foreach($resultadoCompra as $row){                $this->detalle_venta->save([
                    'id_venta'     => $resultadoId,
                    'id_producto'   => $row['id_producto'],
                    'nombre'        => $row['nombre'],
                    'cantidad'      => $row['cantidad'],
                    'precio'        => $row['precio'],
                ]);

                $this->productos = new ProductosModel();
                $this->productos->actualizarStock($row['id_producto'], $row['cantidad'], '-');
                $this->productos->actualizarVenta($row['id_producto'], $row['cantidad'], '+');
            }
            $this->temporal_compra->eliminarCompra($id_venta);
        }
        return redirect()->to(base_url()."/ventas/muestraTicket/" . $resultadoId);
    }

    public function eliminar($id){

        $productos = $this->detalle_venta->where('id_venta', $id)->findAll();

        foreach($productos as $producto){
            $this->productos->actualizarStock($producto['id_producto'], $producto['cantidad'], '+');
            $this->productos->actualizarVenta($producto['id_producto'], $producto['cantidad'], '-');
        }

        $this->ventas->update($id, ['activo' => 0]);

        return redirect()->to(base_url(). '/ventas');
    }

    function muestraTicket($id_venta){
        
        $data['id_venta'] = $id_venta;
        echo view('header');
        echo view('ventas/ver_ticket_pdf', $data);
        echo view('footer');

    }

    function generaTicket($id_venta){
        
        $datosVenta = $this->ventas->where('id', $id_venta)->first();
        $detalleVenta = $this->detalle_venta->select('*')->where('id_venta', $id_venta)->findAll();
    
        $nombreTienda    = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
        $direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;
        $leyendaTicket   = $this->configuracion->select('valor')->where('nombre', 'ticket_leyenda')->get()->getRow()->valor;
        
        $pdf = new \FPDF('P', 'mm', array(80, 200));
        $pdf->AddPage();
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetFont('Arial', 'B', 15);
        
        //DIRECCION
        $pdf->Cell(60, 5,  $nombreTienda, 0, 1, 'C');

        //LEYENDA
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(70, 5, $leyendaTicket, 0, 1, 'C');

        $pdf->Ln();
        $pdf->Ln();

        //logo subido
        $pdf->image(base_url() . '/images/logo.png', 30, 20, 20, 20, 'PNG');
        //$pdf->image(base_url() . '/images/LUFFYOP.jpg', 30, 20, 20, 20, 'JPG');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        //$pdf->Ln();

        //FOLIO
        $pdf->SetFont('Arial', 'B',8);
        $pdf->Cell(25, 5, utf8_decode('Ticket: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 5, $datosVenta['folio'], 0, 1, 'L');
        //FECHA
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(25, 5, utf8_decode('Fecha y hora: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 5, $datosVenta['fecha_alta'], 0, 1, 'L');
        //DIRECCION
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(25, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(50, 5, $direccionTienda, 0, 1, 'L');
        
        $pdf->Ln();
        //$pdf->Ln();

        //TABLA-------------------------------------------------------------   

        $pdf->SetFont('Arial', 'B', 8);
        // Encabezados de la tabla
        $pdf -> SetFillColor(249, 247, 193);
        $pdf -> Cell(10, 6, 'Cant.', 0, 0, "L", 1);
        $pdf -> Cell(35, 6, "Nombre", 0, 0, "L", 1);
        $pdf -> Cell(10, 6, "Precio", 0, 0, "L", 1);
        $pdf -> Cell(15, 6, "Importe", 0, 1, "L", 1);

        $pdf->SetFont('Arial', '', 6);
        
        //PRODUCTOS

        foreach($detalleVenta as $row){
            $pdf -> Cell(10, 6, $row['cantidad'], 0, 0, "L");
            $pdf -> Cell(35, 6, $row['nombre'], 0, 0, "L");
            $pdf -> Cell(10, 6, $row['precio'], 0, 0, "L");
            $importe = number_format($row['precio'] *  $row['cantidad'], 2, '.', ',');
            $pdf -> Cell(15, 6, 'S/.' . $importe, 0, 1, "L");
        }

        //TOTAL
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Ln();
        $pdf->Cell(45, 5, '', 0, 0, 'R');        
        $pdf->Cell(25, 5, 'Total: S/.' . number_format($datosVenta['total'], 2, '.', ',') , 0, 1, 'L');

        //LEYENDA
        //$pdf->SetFont('Arial', '', 10);
        //$pdf->Multicell(70, 5, $leyendaTicket, 0, 1, 'C');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("ticket.pdf", "I");

    }

}