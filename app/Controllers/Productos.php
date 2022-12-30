<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;
use App\Models\ConfiguracionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;


class Productos extends BaseController
{
    protected $productos, $configuracion;
    protected $reglas;

    public function __construct()
    {
        $this->productos  = new ProductosModel();
        $this->unidades   = new UnidadesModel();
        $this->categorias = new CategoriasModel();
        $this->configuracion = new ConfiguracionModel();

        helper(['form']);
        $this->reglas = [
            'codigo' => [
                'rules' => 'required|is_unique[productos.codigo]', 
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'is_unique' => 'El campo {field} es unico'
                ]
            ],

            'nombre' => [
                'rules' => 'required', 
                'errors' => [
                    'required' => 'El campo {field} es obligatorio'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $productos = $this->productos->where('activo',$activo)->findAll();
        $data = ['titulo' => 'PRODUCTOS', 'datos' => $productos];

        echo view('header');
        echo view('productos/productos', $data);
        echo view('footer');
    }

    //Parar Crear
    public function nuevo()
    {
        $unidades = $this->unidades->where('activo',1)->findAll();
        $categorias = $this->categorias->where('activo',1)->findAll();

        $data = ['titulo' => 'Agregar Producto', 'unidades' => $unidades, 'categorias' => $categorias];

        echo view('header');
        echo view('productos/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        //Validacion Insertar            
        if($this->request->getMethod() == "post" & $this->validate( $this->reglas) ){
                //Normal Insertar
                $this->productos -> save([
                    'codigo' => $this->request->getPost('codigo'),
                    'nombre' => $this->request->getPost('nombre'),
                    'precio_venta' => $this->request->getPost('precio_venta'),
                    'precio_compra' => $this->request->getPost('precio_compra'),
                    'stock_minimo' => $this->request->getPost('stock_minimo'),
                    'inventariable' => $this->request->getPost('inventariable'),
                    'id_unidad' => $this->request->getPost('id_unidad'),
                    'id_categoria' => $this->request->getPost('id_categoria')
                ]);

                $id = $this->productos->insertID();
                
                $validacion = $this->validate([
                    'img_producto' => [
                        'uploaded[img_producto]',
                        'max_size[img_producto, 4096]',
                    ]
                ]);
    
                if($validacion){
                    $img = $this->request->getFile('img_producto');
                    $img -> move('./images/productos', $id.'.png');
                }
                
                return redirect()->to(base_url().'/productos');
            }

        else{
            $unidades = $this->unidades->where('activo',1)->findAll();
            $categorias = $this->categorias->where('activo',1)->findAll();

            $data = ['titulo' => 'Agregar Producto', 'unidades' => $unidades, 'categorias' => $categorias, 'validation' => $this->validator];

            echo view('header');
            echo view('productos/nuevo', $data);
            echo view('footer');
        }

    }

    //Para Editar
    public function editar($id)
    {
        $unidades = $this->unidades->where('activo',1)->findAll();
        $categorias = $this->categorias->where('activo',1)->findAll();
        $productos = $this->productos->where('id' , $id)->first();

        $data = ['titulo' => 'Editar Producto', 'unidades' => $unidades, 'categorias' => $categorias, 'productos' => $productos];

        echo view('header');
        echo view('productos/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        $this->productos -> update($this->request->getPost('id'),
        [
            'codigo'        => $this->request->getPost('codigo'),
            'nombre'        => $this->request->getPost('nombre'),
            'precio_venta'  => $this->request->getPost('precio_venta'),
            'precio_compra' => $this->request->getPost('precio_compra'),
            'stock_minimo'  => $this->request->getPost('stock_minimo'),
            'inventariable' => $this->request->getPost('inventariable'),
            'id_unidad'     => $this->request->getPost('id_unidad'),
            'id_categoria'  => $this->request->getPost('id_categoria'),
        ]);

        $id = 'id';

        $validacion = $this->validate([
            'img_producto' => [
                'uploaded[img_producto]',
                'max_size[img_producto, 4096]',
            ]
        ]);
    
        if($validacion){

            $ruta_logo = 'images/productos/'.$id.'.png';

            if(file_exists($ruta_logo)){
                unlink($ruta_logo);
            }

            $img = $this->request->getFile('img_producto');
            $img -> move('./images/productos', $id.'.png');
        }

        return redirect()->to(base_url().'/productos');
    }

    //Para Eliminar (valor 0)
    public function eliminar($id)
    {
        $this->productos->update($id, ['activo' => 0]);
        return redirect()->to(base_url().'/productos');
    }

    // VISUAL ELIMINADOS
    public function eliminados($activo = 0)
    {
        $productos = $this->productos->where('activo',$activo)->findAll();
        $data = ['titulo' => 'Productos agotados', 'datos' => $productos];

        echo view('header');
        echo view('productos/eliminados', $data);
        echo view('footer');
    }

    //Para reestablecer (valor 0)
    public function reingresar($id)
    {
        $this->productos->update($id, ['activo' => 1]);
        return redirect()->to(base_url().'/productos');
    }

    //AYAX BUSCAR
    public function buscarPorCodigo($codigo)
    {
        $this->productos->select('*');
        $this->productos->where('codigo', $codigo);
        $this->productos->where('activo', 1);

        $datos = $this->productos->get()->getRow();

        $res['existe'] = false;
        $res['datos'] = '';
        $res['error'] = '';

        if($datos){
            $res['datos'] = $datos;
            $res['existe'] = true;
        }
        else{
            $res['error'] = 'Codigo de producto no encontrado';
            $res['existe'] = false;
        }

        echo json_encode($res);
    }

    //NOMBRE JQUERY AUTOCOMPLETE
    public function autocompleteData(){

        $returnData = array();

        $valor = $this->request->getGet('term');

        $productos = $this->productos->like('codigo', $valor)->where('activo', 1)->findAll();
        if(!empty($productos)){
            foreach ($productos as $row) {
                $data['id']     = $row['id'];
                $data['value']  = $row['codigo'];
                $data['label']  = $row['codigo'].  ' - '.$row['nombre'];
                array_push($returnData, $data);
            }
        }

        echo json_encode($returnData);
    }

    //CODIGO DE BARRAS

    public function generaBarras(){

        $pdf = new \FPDF('P', 'mm', 'letter');
        $pdf -> AddPage();
        $pdf -> SetTitle("Codigos de barras");

        $productos = $this->productos->where('activo', 1)->findAll();
        foreach($productos as $producto){
            $codigo = $producto['codigo'];
        

            $generaBarcode = new \barcode_genera();
            $generaBarcode ->barcode($codigo.".png", $codigo, 20, "horizontal", "code128", true);  

            $pdf -> Image($codigo.".png");
        }
        $this -> response -> setHeader('Content-Type', 'application/pdf');
        $pdf -> Output('Codigo.pdf', 'I');
    }


    //REPORTE PDF
    function muestraProductosPdf($activo = 1){

        $productos = $this->productos->where('activo',$activo)->findAll();
        $data = ['datos' => $productos];
        
        echo view('header');
        echo view('productos/ver_productos_pdf', $data);
        echo view('footer');

    }

    function generaProductosPdf($activo = 1){
        
        $productos = $this->productos->where('activo',$activo)->findAll();
    
        $nombreTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
        $direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;
        
        $pdf = new \FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle("Compra");
        $pdf->SetFont('Arial', 'B', 20);

        //titulo
        $pdf->Cell(195, 5, "Registro de productos", 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->image(base_url() . '/images/logo.jpg', 180, 10, 25, 25, 'JPG');

        $pdf->Ln();
        $pdf->Ln();

        //NOMBRE
        $pdf->Cell(50, 5, $nombreTienda, 0, 1, 'L');
        //DIRECCION
        $pdf->Cell(20, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(50, 5, $direccionTienda, 0, 1, 'L');
        
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
        $pdf -> Cell(35, 6, 'Codigo', 1, 0, "C", 1);
        $pdf -> Cell(90, 6, "Nombre", 1, 0, "C", 1);
        $pdf -> Cell(30, 6, "Precio", 1, 0, "C", 1);
        $pdf -> Cell(25, 6, "Existencias", 1, 1, "C", 1);

        $pdf->SetFont('Arial', '', 10);
        
        //PRODUCTOS
        $contador = 1;

        foreach($productos as $row){
            $pdf -> Cell(15, 6, $contador, 1, 0, "C");
            $pdf -> Cell(35, 6, $row['codigo'], 1, 0, "C");
            $pdf -> Cell(90, 6, $row['nombre'], 1, 0, "C");
            $pdf -> Cell(30, 6, $row['precio_venta'], 1, 0, "C");
            $pdf -> Cell(25, 6, $row['existencias'], 1, 1, "C");
            $contador++;
        }

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("compra_pdf.pdf", "I");

    }

    //EXCEL
    function muestraProductosExcel($activo = 1){

        $phpExcel = new Spreadsheet();

        $phpExcel->getProperties()->setCreator("Ryusney AP")->setTitle("Reporte Productos");
        $hoja = $phpExcel->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo');
        $drawing->setPath('images/logo.png');
        $drawing->setHeight(80);
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($hoja);

        //TITULO STILOS
        $hoja->mergeCells("A3:E3");
        $hoja->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $hoja->getStyle('A3')->getFont()->setSize(15);
        $hoja->getStyle('A3')->getFont()->setName('Arial');

        $hoja->setCellValue('A3', 'Reporte de productos');

        $hoja->setCellValue('A5', 'N°');

        $hoja->setCellValue('B5', 'Codigo');
        $hoja->getColumnDimension('B')->setWidth(20);
        $hoja->getStyle('B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
        $hoja->setCellValue('C5', 'Nombre');
        $hoja->getColumnDimension('C')->setWidth(40);
        $hoja->getStyle('C5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $hoja->setCellValue('D5', 'Precio');
        $hoja->getColumnDimension('D')->setWidth(20);
        $hoja->getStyle('D5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $hoja->setCellValue('E5', 'Existencias');
        $hoja->getColumnDimension('E')->setWidth(10);
        $hoja->getStyle('E5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $hoja->getStyle('A5:E5')->getFont()->setBold(true);

        $productos = $this->productos->where('activo',$activo)->findAll();

        $fila = 6;
        $contador = 1;

        foreach($productos as $row){

            $hoja->setCellValue('A'.$fila, $contador);
            $hoja->setCellValue('B'.$fila, $row['codigo']);
            $hoja->setCellValue('C'.$fila, $row['nombre']);
            $hoja->setCellValue('D'.$fila, $row['precio_venta']);
            $hoja->setCellValue('E'.$fila, $row['existencias']);

            $contador++;
            $fila++;
        }

        $ultimaFila = $fila - 1;

        $styleArray = [ 
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ]
            ]
        ];
            
        $hoja->getStyle('A5:E'.$ultimaFila)->applyFromArray($styleArray);

        $hoja->setCellValueExplicit('E'.$fila, '=SUMA(E5:E'.$ultimaFila.')', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_FORMULA);

        header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_producto.xlsx"');
        header('Cache-Control: max-age=5');
        $writer = IOFactory::createWriter($phpExcel, 'Xlsx');
        $writer -> save('php://output');
        exit;
    }

}