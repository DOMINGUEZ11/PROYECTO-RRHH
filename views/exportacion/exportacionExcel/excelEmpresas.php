<?php
//verifica si hay sesiones iniciadas
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include "../config/conexionAPI.php";
date_default_timezone_set("America/Tegucigalpa");
require_once "../librerias/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

$documento = new Spreadsheet();
$documento
->getProperties()
->setCreator("ADMIN")
->setLastModifiedBy('ADMIN')
->setTitle('Archivo generado desde MySQL')
->setDescription('Reporte de Empresas');

$hojaDeProductos = $documento->getActiveSheet();
$documento->getActiveSheet()->getDefaultColumnDimension()->setWidth(35); 
$documento->getActiveSheet()->getStyle('A1:D4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    
$hojaDeProductos->setCellValue('C1','Reporte de Empresas');
$hojaDeProductos->setCellValue('B2','Fecha: '.date('Y-m-d H:i:s'));
$hojaDeProductos->setCellValue('B3','Generado por: '.$_SESSION['usuario_login']);
$hojaDeProductos->getStyle('C1')->getFont()->setSize(20);
$documento->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$hojaDeProductos->getStyle('B2')->getFont()->setSize(12);
$documento->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$hojaDeProductos->getStyle('B3')->getFont()->setSize(12);
$documento->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);

$hojaDeProductos->setTitle("Reporte de Empresas");
$hojaDeProductos->setCellValue('A5','Nombre');
$hojaDeProductos->setCellValue('B5','Direccion');
$hojaDeProductos->setCellValue('C5','Telefono');
$hojaDeProductos->setCellValue('D5','Correo');


$query = "SELECT * from empresas";
$resultado = mysqli_query($conexion,$query);
# Comenzamos en la fila 2
$numeroDeFila = 6;
while ($fila = mysqli_fetch_array($resultado)) {
# Obtener registros de MySQL
$nombre = $fila['nombre_empresa'];
$direccion = $fila['direccion'];
$telefono = $fila['telefono'];
$correo = $fila['correo_electronico'];
# Escribir registros en el documento
    $hojaDeProductos->setCellValue('A'. $numeroDeFila, $nombre);
    $hojaDeProductos->setCellValue('B'. $numeroDeFila, $direccion);
    $hojaDeProductos->setCellValue('C'. $numeroDeFila, $telefono);
    $hojaDeProductos->setCellValue('D'. $numeroDeFila, $correo);
     $numeroDeFila++;
}

//Bordes de tabla
$documento->getActiveSheet()->getStyle('A5:A'.$numeroDeFila)->getBorders()->getLeft()->
setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$documento->getActiveSheet()->getStyle('B5:B'.$numeroDeFila)->getBorders()->getLeft()->
setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$documento->getActiveSheet()->getStyle('C5:C'.$numeroDeFila)->getBorders()->getLeft()->
setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$documento->getActiveSheet()->getStyle('D5:D'.$numeroDeFila)->getBorders()->getLeft()->
setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

$documento->getActiveSheet()->getStyle('A5:D5')->getBorders()->getTop()->
setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$documento->getActiveSheet()->getStyle('A6:D6')->getBorders()->getTop()->
setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

$documento->getActiveSheet()->getStyle('D5:D'.$numeroDeFila)->getBorders()->getRight()->
setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

$documento->getActiveSheet()->getStyle('A'.$numeroDeFila.':D'.$numeroDeFila)->getBorders()->getBottom()->
setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

$documento->getActiveSheet()->getStyle('A5:D'.$numeroDeFila)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$documento->getActiveSheet()->getStyle('A5:D5')->getFont()->setBold(true);
$documento->getActiveSheet()->getStyle('A5:D5')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFCB27');
/* Here there will be some code where you create $spreadsheet */

$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawing->setName('Paid');
$drawing->setDescription('Paid');
$drawing->setPath('../vistas/assets/img/logo-compania.png');
$drawing->setCoordinates('B15');
$drawing->setOffsetX(110);
$drawing->setRotation(25);
$drawing->getShadow()->setVisible(true);
$drawing->getShadow()->setDirection(45);

// redirect output to client browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte de Empresas '.date('Y-m-d H:i:s').'.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($documento, 'Xlsx');
$writer->save('php://output');