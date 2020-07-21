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

$idtipoperiodo=base64_decode($_GET['idtipoperiodo']);
$fechaperiodo=base64_decode($_GET['idperiodo']);
$plaza=base64_decode($_GET['plaza']);
$empresa=base64_decode($_GET['empresa']);

include ('../../../../config/conectasql.php');
$exporta = new conectasql();
$exporta->abre_conexion("0");
/** Include PHPExcel */
require_once('../../../../librerias/phpexcel/Classes/PHPExcel');
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
    $periodos = "SELECT * from periodos where idperiodo = $fechaperiodo";
    $result=pg_query($exporta,$periodos);
    $rowperiodos = pg_fetch_array($result);
    $fechainicio = $rowperiodos['fecha_inicio'];
    $fechafin=$rowperiodos['fecha_fin'];
    $cantpersonas2=0;


    $sqlxls="SELECT * from vw_comisiones_por_nomina where idperiodo = $fechaperiodo and fecha_inicio = '$fechainicio' and fecha_fin = '$fechafin' and plaza_id = $plaza";
    $resultxls=pg_query($exporta->conexion,$sqlxls);
    $rowxls=pg_fetch_array($resultxls);
    $cp=$rowxls['persona_id'];

    if($rowxls=pg_fetch_array($resultxls)){
        foreach($cp as $p){
            //condicion para el foreach
                $p=$p++;
                //este es el contador perron
                $cantpersonas2=$cantpersonas2+1;
        }
    if($cantpersonas == $cantpersonas2){
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1'.$p,$rowxls['nombrecompleto'])
                ->setCellValue('A2','Comision')
                ->setCellValue('B2', 'Cantidad');
        do{
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$a, $rowxls['co_nombre'])
                    ->setCellValue('B'.$a, $rowxls['co_cantidad']);
                    $a++;
        }
        while ($rowxls=pg_fetch_array($resultxls));
    }

    }         
   
    // Rename worksheet*/
    $objPHPExcel->getActiveSheet()->setTitle('Plazas');


    // Set active sheet index to the first sheet, so Excel opens this as the first sheet*/
    $objPHPExcel->setActiveSheetIndex(0);


    // Redirect output to a client’s web browser (Excel5)*/
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Reporte-plazas.xls"');
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