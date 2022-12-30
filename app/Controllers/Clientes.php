<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientesModel;
use App\Models\ConfiguracionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;

class Clientes extends BaseController
{
    protected $clientes, $configuracion;
    protected $reglas;

    public function __construct()
    {
        $this->clientes  = new ClientesModel();
        $this->configuracion = new ConfiguracionModel();

        helper(['form']);
        $this->reglas = [
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
        $clientes = $this->clientes->where('activo',$activo)->findAll();
        $data = ['titulo' => 'Clientes', 'datos' => $clientes];

        echo view('header');
        echo view('clientes/clientes', $data);
        echo view('footer');
    }

    //Parar Crear
    public function nuevo()
    {
        $data = ['titulo' => 'Agregar Cliente'];

        echo view('header');
        echo view('clientes/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        //Validacion Insertar            
        if($this->request->getMethod() == "post" & $this->validate( $this->reglas) ){
                //Normal Insertar
                $this->clientes -> save([
                    'nombre'    => $this->request->getPost('nombre'),
                    'direccion' => $this->request->getPost('direccion'),
                    'telefono'  => $this->request->getPost('telefono'),
                    'correo'    => $this->request->getPost('correo'),
                ]);
                
                return redirect()->to(base_url().'/clientes');
            }

        else{
            $data = ['titulo' => 'Agregar Cliente', 'validation' => $this->validator];

            echo view('header');
            echo view('clientes/nuevo', $data);
            echo view('footer');
        }

    }

    //Para Editar
    public function editar($id)
    {
        $clientes = $this->clientes->where('id' , $id)->first();

        $data = ['titulo' => 'Editar Cliente', 'clientes' => $clientes];

        echo view('header');
        echo view('clientes/editar', $data);
        echo view('footer');
    }

    public function actualizar()
    {
        $this->clientes -> update($this->request->getPost('id'),
        [
            'nombre'    => $this->request->getPost('nombre'),
            'direccion' => $this->request->getPost('direccion'),
            'telefono'  => $this->request->getPost('telefono'),
            'correo'    => $this->request->getPost('correo'),
        ]);

        return redirect()->to(base_url().'/clientes');
    }

    //Para Eliminar (valor 0)
    public function eliminar($id)
    {
        $this->clientes->update($id, ['activo' => 0]);
        return redirect()->to(base_url().'/clientes');
    }

    // VISUAL ELIMINADOS
    public function eliminados($activo = 0)
    {
        $clientes = $this->clientes->where('activo',$activo)->findAll();
        $data = ['titulo' => 'Clientes eliminadas', 'datos' => $clientes];

        echo view('header');
        echo view('clientes/eliminados', $data);
        echo view('footer');
    }

    //Para reestablecer (valor 0)
    public function reingresar($id)
    {
        $this->clientes->update($id, ['activo' => 1]);
        return redirect()->to(base_url().'/clientes');
    }

    //NOMBRE JQUERY AUTOCOM´PLETE
    public function autocompleteData(){

        $returnData = array();

        $valor = $this->request->getGet('term');

        $clientes = $this->clientes->like('nombre', $valor)->where('activo', 1)->findAll();
        if(!empty($clientes)){
            foreach ($clientes as $row) {
                $data['id']     = $row['id'];
                $data['value']  = $row['nombre'];
                array_push($returnData, $data);
            }
        }

        echo json_encode($returnData);
    }

    //REPORTE PDF
    function muestraClientesPdf($activo = 1){

        $clientes = $this->clientes->where('activo',$activo)->findAll();
        $data = ['datos' => $clientes];
        
        echo view('header');
        echo view('clientes/ver_clientes_pdf', $data);
        echo view('footer');

    }

    function generaClientesPdf($activo = 1){
        
        $clientes = $this->clientes->where('activo',$activo)->findAll();
        $eliminados = $this->clientes->where('activo',0)->findAll();
    
        $nombreTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
        $direccionTienda = $this->configuracion->select('valor')->where('nombre', 'tienda_direccion')->get()->getRow()->valor;
        
        $pdf = new \FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle("Compra");
        $pdf->SetFont('Arial', 'B', 20);

        //titulo
        $pdf->Cell(195, 5, "Registro de clientes", 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->image(base_url() . '/images/LUFFYOP.jpg', 180, 10, 25, 25, 'JPG');

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

        //Activos
        $pdf->SetFont('Arial', 'B', 12); 
        $pdf -> SetFillColor(128, 186, 219);
        $pdf -> SetTextColor(0, 0, 0);
        $pdf -> Cell(195, 6, 'Informacion de los clientes con estado activo', 1, 1, 'C', 1);
        // Encabezados de la tabla
        $pdf -> SetFillColor(249, 247, 193);
        $pdf -> Cell(10, 6, utf8_decode('N°'), 1, 0, "C", 1);
        $pdf -> Cell(10, 6, "ID", 1, 0, "C", 1);
        $pdf -> Cell(65, 6, "Nombre", 1, 0, "C", 1);
        $pdf -> Cell(35, 6, 'Direccion', 1, 0, "C", 1);
        $pdf -> Cell(30, 6, "Telefono", 1, 0, "C", 1);
        $pdf -> Cell(45, 6, "Correo", 1, 1, "C", 1);

        $pdf->SetFont('Arial', '', 10);
        $contador = 1;

        foreach($clientes as $row){
            $pdf -> Cell(10, 6, $contador, 1, 0, "C");
            $pdf -> Cell(10, 6, $row['id'], 1, 0, "C");
            $pdf -> Cell(65, 6, $row['nombre'], 1, 0, "C");
            $pdf -> Cell(35, 6, $row['direccion'], 1, 0, "C");
            $pdf -> Cell(30, 6, $row['telefono'], 1, 0, "C");
            $pdf -> Cell(45, 6, $row['correo'], 1, 1, "C");
            $contador++;
        }

        $pdf->Ln();
        $pdf->Ln();

        //Eliminados
        $pdf->SetFont('Arial', 'B', 12); 
        $pdf -> SetFillColor(128, 186, 219);
        $pdf -> SetTextColor(0, 0, 0);
        $pdf -> Cell(195, 6, 'Informacion de los clientes con estado eliminado', 1, 1, 'C', 1);
        // Encabezados de la tabla
        $pdf -> SetFillColor(249, 247, 193);
        $pdf -> Cell(10, 6, utf8_decode('N°'), 1, 0, "C", 1);
        $pdf -> Cell(10, 6, "ID", 1, 0, "C", 1);
        $pdf -> Cell(65, 6, "Nombre", 1, 0, "C", 1);
        $pdf -> Cell(35, 6, 'Direccion', 1, 0, "C", 1);
        $pdf -> Cell(30, 6, "Telefono", 1, 0, "C", 1);
        $pdf -> Cell(45, 6, "Correo", 1, 1, "C", 1);

        $pdf->SetFont('Arial', '', 10);
        $cont = 1;

        foreach($eliminados as $row){
            $pdf -> Cell(10, 6, $contador, 1, 0, "C");
            $pdf -> Cell(10, 6, $row['id'], 1, 0, "C");
            $pdf -> Cell(65, 6, $row['nombre'], 1, 0, "C");
            $pdf -> Cell(35, 6, $row['direccion'], 1, 0, "C");
            $pdf -> Cell(30, 6, $row['telefono'], 1, 0, "C");
            $pdf -> Cell(45, 6, $row['correo'], 1, 1, "C");
            $cont++;
        }

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("compra_pdf.pdf", "I");

    }

    //EXCEL
    function muestraClientesExcel($activo = 1){

        $phpExcel = new Spreadsheet();

        $phpExcel->getProperties()->setCreator("Ryusney AP")->setTitle("Reporte Clientes");
        $hoja = $phpExcel->getActiveSheet();

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo');
        $drawing->setPath('images/logotipo.png');
        $drawing->setHeight(80);
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($hoja);

        //TITULO STILOS
        $hoja->mergeCells("A3:F3");
        $hoja->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $hoja->getStyle('A3')->getFont()->setSize(15);
        $hoja->getStyle('A3')->getFont()->setName('Arial');

        $hoja->setCellValue('A3', 'Reporte de clientes');

        $hoja->setCellValue('A5', 'N°');
        $hoja->setCellValue('B5', 'ID');
        $hoja->getStyle('B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $hoja->setCellValue('C5', 'Nombre');
        $hoja->getColumnDimension('C')->setWidth(30);
        $hoja->getStyle('C5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $hoja->setCellValue('D5', 'Direccion');
        $hoja->getColumnDimension('D')->setWidth(25);
        $hoja->getStyle('D5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $hoja->setCellValue('E5', 'Telefono');
        $hoja->getColumnDimension('E')->setWidth(25);
        $hoja->getStyle('E5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $hoja->setCellValue('F5', 'Correo');
        $hoja->getColumnDimension('F')->setWidth(25);
        $hoja->getStyle('F5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $hoja->getStyle('A5:F5')->getFont()->setBold(true);

        $clientes = $this->clientes->where('activo',$activo)->findAll();

        $fila = 6;
        $contador = 1;

        foreach($clientes as $row){

            $hoja->setCellValue('A'.$fila, $contador);
            $hoja->setCellValue('B'.$fila, $row['id']);
            $hoja->setCellValue('C'.$fila, $row['nombre']);
            $hoja->setCellValue('D'.$fila, $row['direccion']);
            $hoja->setCellValue('E'.$fila, $row['telefono']);
            $hoja->setCellValue('F'.$fila, $row['correo']);

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
            
        $hoja->getStyle('A5:F'.$ultimaFila)->applyFromArray($styleArray);

        header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_clientes.xlsx"');
        header('Cache-Control: max-age=5');
        $writer = IOFactory::createWriter($phpExcel, 'Xlsx');
        $writer -> save('php://output');
        exit;

    }

}