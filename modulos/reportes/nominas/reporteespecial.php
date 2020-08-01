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

$idnom=base64_decode($_GET['idnom']);

include ('../../../config/conectasql.php');
$exporta = new conectasql();
$exporta->abre_conexion("0");
$sqlxls="SELECT * FROM vw_reporte_estado_financiero WHERE nom_id = $idnom";
$sqlsueldo="SELECT sum(sal_monto_con) FROM vw_reporte_estado_financiero where nom_id = $idnom";
 /** Include PHPExcel */
require_once ('../../../librerias/phpexcel/Classes/PHPExcel.php');

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
    $resultsumsueldo=pg_query($exporta->conexion,$sqlsueldo);
    if($rowxls=pg_fetch_array($resultxls)){
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Sucursal')
                ->setCellValue('B1', 'Plaza')
                ->setCellValue('C1', 'Percepciones')
                ->setCellValue('D1', 'Deducciones')
                ->setCellValue('E1', 'Bonos')
                ->setCellValue('F1', 'Comisiones')
                ->setCellValue('G1', 'Total');
        do{
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$a, $rowxls['emp_id'])
                    ->setCellValue('B'.$a, $rowxls['plaza_id'])
                    ->setCellValue('C'.$a, $rowxls['nom_total'])
                    ->setCellValue('D'.$a, $rowxls['nom_total'])
                    ->setCellValue('E'.$a, $rowxls['nom_total'])
                    ->setCellValue('F'.$a, $resultsumsueldo)
                    ->setCellValue('G'.$a, $rowxls['nom_total']);
                    $a++;
        }
        while ($rowxls=pg_fetch_array($resultxls));
    }         

    // Rename worksheet*/
    $objPHPExcel->getActiveSheet()->setTitle('Reporte_Financiero');


    // Set active sheet index to the first sheet, so Excel opens this as the first sheet*/
    $objPHPExcel->setActiveSheetIndex(0);


    // Redirect output to a client’s web browser (Excel5)*/
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Reporte-Financiero.xls"');
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

?>