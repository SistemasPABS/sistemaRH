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
        case 'nom':
            $where="where puesto_nombre like '%$campo%'";
            break;
        case 'cve':
            $where="where puesto_cve like '%$campo%'";
            break;
        case 'suc':
            $where="where suc_nombre like '%$campo%'";
            break;
        case 'plz':
            $where="where plaza_nombre like '%$campo%'";
            break;
    }
}else{
    $where=" ";
}

include ('../../../config/conectasql.php');
$exporta = new conectasql();
$exporta->abre_conexion("0");
$sqlxls="select * from vw_puestos $where order by puesto_id desc";

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
                ->setCellValue('B1', 'Clave')
                ->setCellValue('C1', 'Nombre')
                ->setCellValue('D1', 'Descripcion')
                ->setCellValue('E1', 'Plaza')
                ->setCellValue('F1', 'Sucursal')
                ->setCellValue('G1', 'Salario')
                ->setCellValue('H1', 'Fecha')
                ->setCellValue('I1', 'Hora')
                ->setCellValue('J1', 'Autorizado')
                ->setCellValue('K1', 'Jefe inmediato');
        do{
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$a, $rowxls['puesto_id'])
                    ->setCellValue('B'.$a, $rowxls['puesto_cve'])                    
                    ->setCellValue('C'.$a, $rowxls['puesto_nombre'])
                    ->setCellValue('D'.$a, $rowxls['puesto_descripcion'])
                    ->setCellValue('E'.$a, $rowxls['plaza_nombre'])
                    ->setCellValue('F'.$a, $rowxls['suc_nombre'])
                    ->setCellValue('G'.$a, $rowxls['sal_nombre'])
                    ->setCellValue('H'.$a, $rowxls['puesto_fecha'])
                    ->setCellValue('I'.$a, $rowxls['puesto_hora'])
                    ->setCellValue('J'.$a, $rowxls['us_login'])
                    ->setCellValue('K'.$a, $rowxls['nombre_jefe']);
                    $a++;
        }
        while ($rowxls=  pg_fetch_array($resultxls));
    }         
   
    // Rename worksheet*/
    $objPHPExcel->getActiveSheet()->setTitle('Puestos');


    // Set active sheet index to the first sheet, so Excel opens this as the first sheet*/
    $objPHPExcel->setActiveSheetIndex(0);


    // Redirect output to a client’s web browser (Excel5)*/
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Reporte-puestos.xls"');
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