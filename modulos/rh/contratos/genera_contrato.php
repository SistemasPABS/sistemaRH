<?php
$reg = base64_decode($_GET['ct']);

include_once ('../../../config/cookie.php');

include_once ('../../../config/conectasql.php');
$contrato = new conectasql();
$contrato->abre_conexion("0");
$contrato->consulta_cto($reg);//Consulta datos de vw_contratos
$contrato->consulta_per_cto($contrato->consulta['persona_id']);//Consulta datos de personas
$contrato->consulta_per_pto($contrato->consulta['puesto_id']);//Consulta datos de Puestos 
//$contrato->consulta_sueldo_cto($contrato->consulta['sal_id']);//Consulta datos de vw_salarios
$contrato->cierra_conexion("0");

//Asigna valores a las variables de los resultados de las busquedas
$razonsocial  = $contrato->consulta['raz_nombre'];
$representante = $contrato->consulta['raz_legal'];
$nombreper = $contrato->consulta2['persona_nombre'];
$erapellidoper = $contrato->consulta2['persona_paterno'];
$doapellidoper = $contrato->consulta2['persona_materno'];
$domrazonsocial = $contrato->consulta['raz_direccion'];
$edadper = $contrato->consulta2['persona_edad'];
$estcivilper = $contrato->consulta2['persona_edo_civil'];
$generoper = $contrato->consulta2['persona_genero'];
$rfcper = $contrato->consulta2['persona_rfc'];
$curpper = $contrato->consulta2['persona_curp'];
$domicilioper = $contrato->consulta2['persona_calle'];
$dommicilionumeroper = $contrato->consulta2['persona_calle_numero'];
$coloniaper = $contrato->consulta2['persona_colonia'];
$nombrepuestocontrato = $contrato->consulta['puesto_nombre'];
$plazacontrato = $contrato->consulta3['plaza_nombre'];
$fechainiciocontrato = $contrato->consulta['con_fecha_inicio'];
$periododepruebacontrato = $contrato->consulta['con_periodo'];
$tiponominacontrato = $contrato->consulta['sal_tipo'];
$salarionumerocontrato = $contrato->consulta['sal_monto_con'];
//Funcion que convierte el salario de formato numerico a Texto
$f = new \NumberFormatter("es", NumberFormatter::SPELLOUT);
$salarioletracontrato = $f->format($salarionumerocontrato).' pesos';
$horariosemanalcontrato = $contrato->consulta['con_horario'];

require_once '../../../librerias/PHPWord-master/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\TemplateProcessor;
$templateWord = new TemplateProcessor('../../../formatos/contratos/'.$contrato->consulta['tipoc_plantilla']);

// --- Asignamos valores a la plantilla
    $templateWord->setValue('razonsocial',$razonsocial ); //
    $templateWord->setValue('representante',$representante );
    $templateWord->setValue('nombreper', $nombreper );
    $templateWord->setValue('1erapellidoper',$erapellidoper );
    $templateWord->setValue('2doapellidoper',$doapellidoper );
    $templateWord->setValue('domrazonsocial',$domrazonsocial );
    $templateWord->setValue('edadper',$edadper );
    $templateWord->setValue('estcivilper',$estcivilper );
    $templateWord->setValue('generoper', $generoper );
    $templateWord->setValue('rfcper',$rfcper );
    $templateWord->setValue('curpper',$curpper );
    $templateWord->setValue('domicilioper',$domicilioper );
    $templateWord->setValue('dommicilionumeroper',$dommicilionumeroper );
    $templateWord->setValue('coloniaper',$coloniaper );
    $templateWord->setValue('nombrepuestocontrato',$nombrepuestocontrato );
    $templateWord->setValue('plazacontrato',$plazacontrato );
    $templateWord->setValue('fechainiciocontrato',$fechainiciocontrato );
    $templateWord->setValue('periododepruebacontrato',$periododepruebacontrato );
    $templateWord->setValue('tiponominacontrato',$tiponominacontrato );
    $templateWord->setValue('salarionumerocontrato',$salarionumerocontrato );
    $templateWord->setValue('salarioletracontrato',$salarioletracontrato );
    $templateWord->setValue('horariosemanalcontrato',$horariosemanalcontrato );

// --- Guardamos el documento
$templateWord->saveAs($nombreper.'.doc');

header("Content-Disposition: attachment; filename=\"$nombreper.doc\"; charset=iso-8859-1");
echo file_get_contents($nombreper.'.doc');
//Se elimina el contrato generado para evitar duplicidad de archivos con contenido diferente
unlink($nombreper.'.doc');      
//se cierra conexion

?>


