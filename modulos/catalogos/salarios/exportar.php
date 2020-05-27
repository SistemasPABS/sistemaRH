<?php
include ('../../../config/cookie.php');
?>
<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Mexico_City');
if (PHP_SAPI == 'cli')
die('This example should only be run from a Web Browser');

$parametro= base64_decode($_GET['chk1']);
$campo= base64_decode($_GET['chk2']);
$extension= base64_decode($_GET['chk3']);
if($campo != NULL){
    switch ($parametro){
        case 'desc':
            $where = "where sal_descripcion like '%$campo%'";
            break;
        case 'suc':
            $where = "where suc_nombre like '%$campo%'";
            break;
        case 'plz':
            $where = "where plaza_nombre like '%$campo%'";
            break;
    }
}else{
    $where=" ";
}

include ('../../../config/conectasql.php');
$exporta = new conectasql();
$exporta->abre_conexion("0");
$sqlxls="select * from vw_salarios $where order by sal_id desc";

if($extension == 'xls'){
    /** Include PHPExcel */
    require_once '../../../librerias/phpexcel/Classes/PHPExcel.php';

    // Create new PHPExcel object*/
    $objPHPExcel = new PHPExcel();

    // Set document properties*/
    $objPHPExcel->getProperties()
            ->setCreator("Jaime Nieto")
            ->setLastModifiedBy("Jaime Nieto")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

    // Add some data*/
    $a=2;
    //se ejecuta la consulta
    $resultxls=pg_query($exporta->conexion,$sqlxls);
    if($rowxls=pg_fetch_array($resultxls)){
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Registro')
                ->setCellValue('B1', 'Nombre')
                ->setCellValue('C1', 'Descripcion')
                ->setCellValue('D1', 'Plaza')
                ->setCellValue('E1', 'Sucursal')
                ->setCellValue('F1', 'Monto')
                ->setCellValue('G1', 'Tipo salario')
                ->setCellValue('H1', 'Autorizado')
                ->setCellValue('I1', 'Activo');
        do{
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$a, $rowxls['sal_id'])
                    ->setCellValue('B'.$a, $rowxls['sal_nombre'])
                    ->setCellValue('C'.$a, $rowxls['sal_descripcion'])
                    ->setCellValue('D'.$a, $rowxls['plaza_nombre'])
                    ->setCellValue('E'.$a, $rowxls['suc_nombre'])
                    ->setCellValue('F'.$a, $rowxls['sal_monto'])
                    ->setCellValue('G'.$a, $rowxls['sal_tipo'])
                    ->setCellValue('H'.$a, $rowxls['us_login'])
                    ->setCellValue('I'.$a, $rowxls['sal_activo']);
                    $a++;
        }
        while ($rowxls=  pg_fetch_array($resultxls));
    }         
   
    // Rename worksheet*/
    $objPHPExcel->getActiveSheet()->setTitle('Salarios');


    // Set active sheet index to the first sheet, so Excel opens this as the first sheet*/
    $objPHPExcel->setActiveSheetIndex(0);


    // Redirect output to a client’s web browser (Excel5)*/
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Reporte-salarios.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed*/
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed*/
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past*/
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified*/
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1*/
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}else {
    
}
?>