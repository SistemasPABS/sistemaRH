<?php
require __DIR__ . "/vendor/autoload.php";
include_once ('../../../config/cookie.php');
include_once ('../../../config/conectasql.php');
$us_id=$_SESSION['us_id'];
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$idnom=base64_decode($_GET['idnom']);//idnom

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');

$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');

exit;
?>
