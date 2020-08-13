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
require_once ('../../../../librerias/phpexcel/Classes/PHPExcel.php');
$objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()
            ->setCreator("Jaime Nieto")
            ->setLastModifiedBy("Jaime Nieto")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
    
// ----------------- DATOS DE BASE NOMINA --------------------------- //
$basenom = "SELECT * from base_nom where nom_id = $idnom";
$resultbasenom = pg_query($exporta->conexion,$basenom);
$mostrarbasenom = pg_fetch_array($resultbasenom);

$empresa = $mostrarbasenom ['emp_id'];
$plaza = $mostrarbasenom['plaza_id'];
$tipoperiodo = $mostrarbasenom['sal_tipo_id'];


$consultarempresa = "SELECT * from empresas where emp_id = $empresa";
$resultconsultaempresa = pg_query($exporta->conexion,$consultarempresa);
$mostrarempresa = pg_fetch_array($resultconsultaempresa);
$nombreempresa = $mostrarempresa['emp_nombre'];

$consultaplaza = "SELECT * from plazas where plaza_id = $plaza";
$resultconsultaplaza = pg_query($exporta->conexion,$consultaplaza);
$mostrarplaza = pg_fetch_array($resultconsultaplaza);
$nombreplaza = $mostrarplaza['plaza_nombre'];

$consultatipoperiodo = "SELECT * FROM tipos_salarios where sal_tipo_id = $tipoperiodo";
$resultconsultatipoperiodo = pg_query($exporta->conexion,$consultatipoperiodo);
$mostrartipoperiodo = pg_fetch_array($resultconsultatipoperiodo);
$nombretipoperiodo = $mostrartipoperiodo['sal_tipo_nombre'];


$objPHPExcel->setActiveSheetIndex(0)    
                ->setCellValue('C1', $nombreplaza)
                ->setCellValue('C2', $nombretipoperiodo)
                ->setCellValue('D2', $mostrarbasenom['fecha_inicio'])
                ->setCellValue('D3', $mostrarbasenom['fecha_fin'])
                ->setCellValue('D6', $nombreempresa);

// --------------------- se ejecuta la consulta de los sueldos ---------------------------- //
    $sqlxls="SELECT * FROM vw_sueldos_nomina WHERE nom_id = $idnom order by persona_id";
    $resultxls=pg_query($exporta->conexion,$sqlxls);
    $a=8;

    $personas=array();
    if($rowxls=pg_fetch_array($resultxls)){
        $idpersona = $rowxls['persona_id'];
        $personas[]= $rowxls['persona_id'];

        $sqlingreso="SELECT * from vw_contratos where persona_id = $idpersona";
        $resultsqlingreso = pg_query($exporta->conexion,$sqlingreso);
        $mostraringreso = pg_fetch_array($resultsqlingreso);
        $fechaingreso = $mostraringreso['con_fecha_inicio'];

        $objPHPExcel->setActiveSheetIndex(0)    
                ->setCellValue('C6', 'Ingreso')
                ->setCellValue('D7', 'Persona')
                ->setCellValue('E7', 'Sueldo pagado');

        do{
           
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$a, $rowxls['persona_id'])
                    ->setCellValue('C'.$a, $rowxls['con_fecha_inicio'])
                    ->setCellValue('D'.$a, $rowxls['nombrecompleto'])
                    ->setCellValue('E'.$a, $rowxls['sal_monto_con']);
                    $a++;
        }while ($rowxls=pg_fetch_array($resultxls));
    }

// ---------- Se obtiene la columna maxima para saber donde empezar el siguiente bucle ------------- //
    
    
$highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();  
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumm);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('F7','SDI');
$letradelacolumnadondevoyaempezarmisiguienteciclo = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('F1',$letradelacolumnadondevoyaempezarmisiguienteciclo);

// ----------------- SE INICIA CONSULTA PARA LAS COMISIONES -------------------- //


$sqlcom="SELECT DISTINCT co_nombre, co_id from vw_comnom WHERE nom_id = $idnom order by co_id";
$resultcomisiones = pg_query($exporta->conexion,$sqlcom);
$mostrarcomisiones=pg_fetch_array($resultcomisiones);

$comisionesdisponibles=array();

for($x='G'; $x != 'IW'; $x++) {
    do{
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($x . '7', $mostrarcomisiones['co_nombre']);
        $comisionesdisponibles[] = $mostrarcomisiones['co_id'];
        $x++;
    }while($mostrarcomisiones = pg_fetch_array($resultcomisiones));
 }
$cantidades=8;
//$valores=array();
$largepersonas=count($personas);
$large=count($comisionesdisponibles);

for($y=0; $y < $largepersonas; $y++){
    
    for($i=0; $i < $large; $i++){

        $sqlcomisionporpersona="select co_monto from vw_comnom where nom_id = $idnom and persona_id = ".$personas[$y]." and co_id = ".$comisionesdisponibles[$i]." ";
        $resultcomisionesporpersona = pg_query($exporta->conexion,$sqlcomisionporpersona);
        $mostrarcomisionesporpersona=pg_fetch_array($resultcomisionesporpersona);
        //$valores=$resultcomisionesporpersona['co_monto'];
        for($x='G'; $x != 'IW'; $x++) {
            do{
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($x.$cantidades, $mostrarcomisionesporpersona['co_monto']);
                $x++;
            }while($mostrarcomisionesporpersona=pg_fetch_array($resultcomisionesporpersona));
        }
    }
    $cantidades++;
}
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue($x . '7', $mostrarcomisiones['co_nombre']);





// ---------------- FINALIZA CONSULTA PARA LAS COMISIONES ---------------------- //



// ---------------- SE INICIA CONSULTA PARA LAS PERCEPCIONES ------------- //


$sqlper="SELECT DISTINCT tp_nombre from vw_percepciones WHERE nom_id = $idnom";
$resultpercepciones = pg_query($exporta->conexion,$sqlper);
$mostrarpercepciones = pg_fetch_array($resultpercepciones);
for($x='P'; $x != 'IW'; $x++) { 
    
   

    do{
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($x . '7', $mostrarpercepciones['tp_nombre']);
        $x++;
        
    }while($mostrarpercepciones = pg_fetch_array($resultpercepciones));

}


// ----------------- FINALIZA CONSULTA PARA LAS PERCEPCIONES --------------- //
            

// ---------------- SE INICIA CONSULTA PARA LAS DEDUCCIONES ------------- //


$sqlded="SELECT DISTINCT td_nombre from vw_deducciones WHERE nom_id = $idnom";
$resultdeducciones = pg_query($exporta->conexion,$sqlded);
$mostrardeducciones = pg_fetch_array($resultdeducciones);
for($x='R'; $x != 'IW'; $x++) { 
    
   

    do{
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($x . '7', $mostrardeducciones['td_nombre']);
        $x++;
        
    }while($mostrardeducciones = pg_fetch_array($resultdeducciones));

}


// ----------------- FINALIZA CONSULTA PARA LAS DEDUCCIONES --------------- //
            









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