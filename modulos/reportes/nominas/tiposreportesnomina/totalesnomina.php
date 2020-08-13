<?php 
include ('../../../../config/cookie.php');
include ('../../../../config/conectasql.php');
$idnom=base64_decode($_GET['idnom']);
$exporta = new conectasql();
$exporta->abre_conexion("0");
/** Se manda llamar la libreria de phpExcel para la ejecucion del reporte */
require_once ('../../../../librerias/phpexcel/Classes/PHPExcel.php');
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Mexico_City');
if (PHP_SAPI == 'cli')
die('This example should only be run from a Web Browser');
/** Se recibe el ID de Nomina para ejecucion del reporte */

/** Se determina el documento */
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
            ->setCreator("Jaime Nieto")
            ->setLastModifiedBy("Jaime Nieto")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

/*   ---------------------------------------------------------- */
//           SE OBTIENE LA INFORMACION DE LA BASE NOMINA        //
/*   ---------------------------------------------------------- */

$sqlbasenomina = "SELECT * FROM base_nom WHERE nom_id = $idnom";
//echo $sqlbasenomina;
$resultsqlbasenomina = pg_query($exporta->conexion,$sqlbasenomina);
$mostrarinformacionbasenomina = pg_fetch_array($resultsqlbasenomina);

/*   ---------------------------------------------------------------- */
//         SE GUARDA EN VARIABLES EL RESULTADO DE LA BASE NOMINA      //
/*   ---------------------------------------------------------------- */

$fechacreacionnomina = $mostrarinformacionbasenomina['fecha'];
//echo $fechacreacionnomina;
$horacreacionnomina = $mostrarinformacionbasenomina['hora'];
//echo $horacreacionnomina;
$plazaid = $mostrarinformacionbasenomina['plaza_id'];
//echo $plazaid;
$numventas = $mostrarinformacionbasenomina['num_ventas'];
//echo $$numventas;
$ventadirecta = $mostrarinformacionbasenomina['venta_directa'];
//echo $ventadirecta;
$cobros = $mostrarinformacionbasenomina['cobros'];
//echo $cobros;
$saldo = $mostrarinformacionbasenomina['saldo'];
//echo $saldo;
$cobrosperant = $mostrarinformacionbasenomina['cobros_per_ant'];
//echo $cobrosperant;
$observacionesbasenomina = $mostrarinformacionbasenomina['observaciones'];
//echo $observacionesbasenomina;
$empresaid = $mostrarinformacionbasenomina['emp_id'];
//echo $empresaid;
$saltipoid = $mostrarinformacionbasenomina['sal_tipo_id'];
//echo $saltipoid;
$fechainicio = $mostrarinformacionbasenomina['fecha_inicio'];
//echo $fechainicio;
$fechafin = $mostrarinformacionbasenomina['fecha_fin'];
//echo $fechafin;
$ingresos = $mostrarinformacionbasenomina['ingresos'];
//echo $ingresos;
$recibototal = $mostrarinformacionbasenomina['recibototal'];
//echo $recibototal;

/*   ---------------------------------------------------------- */
//           SE OBTIENE LA INFORMACION DE LA NOMINA             //
/*   ---------------------------------------------------------- */

$sqlnomina = "SELECT * FROM nomina WHERE nom_id = $idnom";
//echo $sqlnomina;
$resultsqlnomina = pg_query($exporta->conexion,$sqlnomina);
$mostrarinformacionnomina = pg_fetch_array($resultsqlnomina);

/*   ---------------------------------------------------------------- */
//         SE GUARDA EN VARIABLES EL RESULTADO DE LA NOMINA           //
/*   ---------------------------------------------------------------- */

$totalnomina = $mostrarinformacionnomina['nom_total'];
//echo $totalnomina;
$nominaautorizada = $mostrarinformacionnomina['nom_autorizada'];
//echo $nominaautorizada;
$usergeneradordenomina = $mostrarinformacionnomina['us_id'];
//echo $usergeneradordenomina;

/*   ---------------------------------------------------------------- */
//           SE OBTIENE LA INFORMACION DE VW_SUELDOS_NOMINA           //
/*   ---------------------------------------------------------------- */

$sqlsueldosnomina = "SELECT * FROM vw_sueldos_nomina WHERE nom_id = $idnom";
//echo $sqlsueldosnomina;
$resultsqlsueldosnomina = pg_query($exporta->conexion,$sqlsueldosnomina);
$mostrarinformacionsueldosnomina = pg_fetch_array($resultsqlsueldosnomina);

/* -------------------------------------------------------   */
//      OBTENER LAS PERSONAS QUE HAY EN LA NOMINA            //
/* -------------------------------------------------------   */
$personas = array();
$ids = "";
    do{
        $ids .= "".$mostrarinformacionsueldosnomina['persona_id'].",";
        $personas[] = $mostrarinformacionsueldosnomina['persona_id'];
    }while($mostrarinformacionsueldosnomina = pg_fetch_array($resultsqlsueldosnomina));
$ids = substr($ids,0,-1);
//echo $ids;

/* -----------------------------------------------------------------------------   */
//      OBTENER LOS JEFES DIRECTOS DE LAS PERSONAS QUE HAY EN LA NOMINA            //
/* -----------------------------------------------------------------------------   */

$sqljefesdirectos = "SELECT DISTINCT con_jefe_inmediato FROM contratos WHERE persona_id IN (".$ids.") order by con_jefe_inmediato";
//echo $sqljefesdirectos;
$resultsqljefesdirectos = pg_query($exporta->conexion,$sqljefesdirectos);
$mostrarinformacionjefesdirectos = pg_fetch_array($resultsqljefesdirectos);
$jefedirectos = "";
do{
    $jefedirectos .= "'".$mostrarinformacionjefesdirectos['con_jefe_inmediato']."'";
}while($mostrarinformacionjefesdirectos = pg_fetch_array($resultsqljefesdirectos));
//echo $jefedirectos;

/* -------------------------------------------------------   */
//       SE OBTIENE EL SDI Y EL SUELDO DE LA PERSONA         //
/* -------------------------------------------------------   */

$largepersonas=count($personas);
//echo $largepersonas;
for($y=0; $y < $largepersonas; $y++){
    $sqlsdisalario = "SELECT con_sdi, sal_monto_con FROM vw_sueldos_nomina WHERE nom_id = $idnom and persona_id = ".$personas[$y]."";
    $resultsqlsdisalario = pg_query($exporta->conexion,$sqlsdisalario);
    $mostrarinformacionsdisalariodiario = pg_fetch_array($resultsqlsdisalario);
    //$consdi = $mostrarinformacionsdisalariodiario['con_sdi'];
    //$salmontocon = $mostrarinformacionsdisalariodiario['sal_monto_con'];
//echo $sqlsdisalario;
//echo $consdi;
//echo $salmontocon;
}

/* --------------------------------------------------------------   */
//       SE OBTIENEN LAS COMISIONES QUE EXISTEN EN LA NOMINA        //
/* --------------------------------------------------------------   */
$sqlcomisionesdelanomina = "SELECT DISTINCT co_id FROM vw_comnom where nom_id = $idnom order by co_id";
$resultsqlcomisionesdelanomina = pg_query($exporta->conexion,$sqlcomisionesdelanomina);
$mostrarinformacioncomisionesdelanomina = pg_fetch_array($resultsqlcomisionesdelanomina);
$comisionesdisponibles=array();
    do{

        /* ------------------------------------------------------------------------------   */
        //       SE OBTIENEN LOS NOMBRES DE LAS COMISIONES QUE EXISTEN EN LA NOMINA         //
        /* ------------------------------------------------------------------------------   */
        $idcomisiones = $mostrarinformacioncomisionesdelanomina['co_id'];
        $comisionesdisponibles[] = $mostrarinformacioncomisionesdelanomina['co_id'];
        $sqlnombrescomisiones = "SELECT co_nombre FROM vw_comnom where co_id = $idcomisiones";
        $resultnombrescomisiones = pg_query($sqlnombrescomisiones);
        $mostrarinformacionnombrescomisiones = pg_fetch_array($resultnombrescomisiones);
        $nombrecomision = $mostrarinformacionnombrescomisiones['co_nombre'];
        //echo $comisiones.'--';
        //echo $nombrecomision;
    }while($mostrarinformacioncomisionesdelanomina = pg_fetch_array($resultsqlcomisionesdelanomina));


/* --------------------------------------------------------------   */
//       SE OBTIENEN LAS COMISIONES POR PERSONA                     //
/* --------------------------------------------------------------   */
$largecomisiones = count($comisionesdisponibles);
for($y=0; $y < $largepersonas; $y++){

    for($c=0; $c < $largecomisiones; $c++){

        $sqlcomisionesporpersona = "SELECT co_monto FROM vw_comnom WHERE nom_id = $idnom and persona_id = ".$personas[$y]." and co_id = ".$comisionesdisponibles[$c]." ";
        $resultcomisionesporpersona = pg_query($exporta->conexion,$sqlcomisionesporpersona);
        $mostrarinformacioncomisionesporpersona = pg_fetch_array($resultcomisionesporpersona);
        $montocomision = $mostrarinformacioncomisionesporpersona['co_monto'];
        //echo $sqlcomisionesporpersona.'=>'.'  ';
        //echo $montocomision;
        
    }
    
}

/* ----------------------------------------------------------------   */
//       SE OBTIENEN LAS PERCEPCIONES QUE EXISTEN EN LA NOMINA        //
/* ----------------------------------------------------------------   */
$sqlpercepcionesdelanomina = "SELECT DISTINCT tp_id FROM vw_percepciones where nom_id = $idnom order by tp_id";
//echo $sqlpercepcionesdelanomina;
$resultsqlpercepcionesdelanomina = pg_query($exporta->conexion,$sqlpercepcionesdelanomina);
$mostrarinformacionpercepcionesdelanomina = pg_fetch_array($resultsqlpercepcionesdelanomina);
$percepcionesdisponibles=array();
    do{

        /* --------------------------------------------------------------------------------   */
        //       SE OBTIENEN LOS NOMBRES DE LAS PERCEPCIONES QUE EXISTEN EN LA NOMINA         //
        /* --------------------------------------------------------------------------------   */
        $idpercepciones = $mostrarinformacionpercepcionesdelanomina['tp_id'];
        $percepcionesdisponibles[] = $mostrarinformacionpercepcionesdelanomina['tp_id'];
        $sqlnombrespercepciones = "SELECT tp_nombre FROM tipos_percepciones WHERE tp_id = $idpercepciones";
        //echo $sqlnombrespercepciones;
        $resultnombrespercepciones = pg_query($sqlnombrespercepciones);
        $mostrarinformacionnombrespercepciones = pg_fetch_array($resultnombrespercepciones);
        $nombrepercepcion = $mostrarinformacionnombrespercepciones['tp_nombre'];
        //echo $idpercepciones.'--';
        //echo $nombrepercepcion;
    }while($mostrarinformacionpercepcionesdelanomina = pg_fetch_array($resultsqlpercepcionesdelanomina));




/* ---------------------------------------------------------------------   */
//           SE OBTIENEN LAS PERCEPCIONES POR PERSONA                      //
/* --------------------------------------------------------------------   */
$largepercepciones = count($percepcionesdisponibles);
for($y=0; $y < $largepersonas; $y++){

    for($p=0; $p < $largepercepciones; $p++){

        $sqlpercepcionesporpersona = "SELECT tp_monto FROM vw_percepciones WHERE nom_id = $idnom and persona_id = ".$personas[$y]." and tp_id = ".$percepcionesdisponibles[$p]." ";
        $resultpercepcionesporpersona = pg_query($exporta->conexion,$sqlpercepcionesporpersona);
        $mostrarinformacionpercepcionesporpersona = pg_fetch_array($resultpercepcionesporpersona);
        $montopercepcion = $mostrarinformacionpercepcionesporpersona['tp_monto'];
        //echo $sqlpercepcionesporpersona.'=>'.'  ';
        //echo $montopercepcion;
        
    }
    
}


/* ----------------------------------------------------------------   */
//       SE OBTIENEN LAS DEDUCCIONES QUE EXISTEN EN LA NOMINA        //
/* ----------------------------------------------------------------   */
$sqldeduccionesdelanomina = "SELECT DISTINCT td_id FROM vw_deducciones where nom_id = $idnom order by td_id";
//echo $sqldeduccionesdelanomina;
$resultsqldeduccionesdelanomina = pg_query($exporta->conexion,$sqldeduccionesdelanomina);
$mostrarinformaciondeduccionesdelanomina = pg_fetch_array($resultsqldeduccionesdelanomina);
$deduccionesdisponibles=array();
    do{

        /* --------------------------------------------------------------------------------   */
        //       SE OBTIENEN LOS NOMBRES DE LAS DEDUCCIONES QUE EXISTEN EN LA NOMINA         //
        /* --------------------------------------------------------------------------------   */
        $iddeducciones = $mostrarinformaciondeduccionesdelanomina['td_id'];
        $deduccionesdisponibles[] = $mostrarinformaciondeduccionesdelanomina['td_id'];
        $sqlnombresdeducciones = "SELECT td_nombre FROM tipos_deducciones WHERE td_id = $iddeducciones";
        //echo $sqlnombresdeducciones;
        $resultnombresdeducciones = pg_query($sqlnombresdeducciones);
        $mostrarinformacionnombresdeducciones = pg_fetch_array($resultnombresdeducciones);
        $nombrededuccion = $mostrarinformacionnombresdeducciones['td_nombre'];
        //echo $iddeducciones.'--';
        //echo $nombrededuccion;
    }while($mostrarinformaciondeduccionesdelanomina = pg_fetch_array($resultsqldeduccionesdelanomina));


/* ---------------------------------------------------------------------   */
//           SE OBTIENEN LAS DEDUCCIONES POR PERSONA                      //
/* --------------------------------------------------------------------   */
$largededucciones = count($deduccionesdisponibles);
for($y=0; $y < $largepersonas; $y++){

    for($d=0; $d < $largededucciones; $d++){

        $sqldeduccionesporpersona = "SELECT td_monto FROM vw_deducciones WHERE nom_id = $idnom and persona_id = ".$personas[$y]." and td_id = ".$deduccionesdisponibles[$d]." ";
        $resultdeduccionesporpersona = pg_query($exporta->conexion,$sqldeduccionesporpersona);
        $mostrarinformaciondeduccionesporpersona = pg_fetch_array($resultdeduccionesporpersona);
        $montodeduccion = $mostrarinformaciondeduccionesporpersona['td_monto'];
        //echo $sqldeduccionesporpersona.'=>'.'  ';
        //echo $montodeduccion;
        
    }
    
}

// Renombrando hoja de trabajo*/
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