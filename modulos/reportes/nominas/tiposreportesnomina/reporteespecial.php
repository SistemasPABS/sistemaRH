<?php
include ('../../../../config/cookie.php');
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
include ('../../../../config/conectasql.php');
$exporta = new conectasql();
$exporta->abre_conexion("0");
$sqlxls="SELECT * FROM vw_sueldos_nomina WHERE nom_id = $idnom";
 /** Include PHPExcel */
require_once ('../../../../librerias/phpexcel/Classes/PHPExcel.php');
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
    
//se ejecuta la consulta
    $resultxls=pg_query($exporta->conexion,$sqlxls);
    $a=8;
    if($rowxls=pg_fetch_array($resultxls)){
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('D7', 'Persona')
        ->setCellValue('E7', 'Sueldo Nomina');
        do{
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D'.$a, $rowxls['nombrecompleto'])
                    ->setCellValue('E'.$a, $rowxls['sal_monto_con']);
                    
                    $a++;
        }while ($rowxls=pg_fetch_array($resultxls));



    //Bucle para las comisiones 

    $querycomisiones = "SELECT DISTINCT persona_id, nombrecompleto, co_monto,  from vw_comnom where nom_id = $idnom";
    $resultquerycomisiones = pg_query($exporta->conexion,$querycomisiones);
    $rowcomisiones = pg_fetch_array($resultquerycomisiones);
    
    for($x='G'; $x != 'IW'; $x++) { 
        do{
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($x . '7', $rowcomisiones['co_nombre'])
            ->setCellValue($x . '8', $rowmontocomisiones['co_monto']);
            //->setCellValue($x . '9', $rowcomisiones[''] ;
            $x++;
        }while($rowcomisiones = pg_fetch_array($resultquerycomisiones));
        
    }
    
   

    }         
   
    // Rename worksheet*/
    $objPHPExcel->getActiveSheet()->setTitle('Detallado de nomina');


    // Set active sheet index to the first sheet, so Excel opens this as the first sheet*/
    $objPHPExcel->setActiveSheetIndex(0);


    // Redirect output to a client’s web browser (Excel5)*/
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Detallado_de_nomina.xls"');
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