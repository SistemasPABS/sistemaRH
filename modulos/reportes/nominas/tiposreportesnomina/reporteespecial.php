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
$sqlxls="SELECT DISTINCT nombrecompleto FROM vw_general_personas_por_nomina_scpd WHERE nom_id = $idnom";
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
        $objPHPExcel->setActiveSheetIndex(0);

        do{
           
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D'.$a, $rowxls['nombrecompleto'])
                    ->setCellValue('E'.$a, $rowxls['sal_monto_con']);
                    $a++;
        }while ($rowxls=pg_fetch_array($resultxls));
        
    }

    //Obteniendo la columna con el ultimo registro
    $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('M7',$highestColumm);

    $fila = 1;
    $columnamaxima = $highestColumm;

    $objPHPExcel->setActiveSheetIndex(0);
    for($column = $columnamaxima; $column != 'IW'; $column++){ 
    $objPHPExcel->setActiveSheetIndex(0) ->setCellValue('O1',$column);}


    //Iniciando bucle para llenar desde la columna "G" y consulta para llenar las comisiones

    $querycomisiones = "SELECT DISTINCT co_nombre from vw_comnom where nom_id = $idnom";
    $resultcomisiones = pg_query($exporta->conexion,$querycomisiones);
    if($mostrarcomisiones = pg_fetch_array($resultcomisiones)){
        do{
            for($x='F'; $x != 'IW'; $x++) { 
                $objPHPExcel->setActiveSheetIndex(0) 
                ->setCellValue($x . '7', $mostrarcomisiones); 
            }
        }while($mostrarcomisiones = pg_fetch_array($resultcomisiones));
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