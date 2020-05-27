<?php
    include ('../../../config/cookie.php');
?>
<?php
require_once '../../../librerias/PHPWord-master/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();
use PhpOffice\PhpWord\TemplateProcessor;

$reg = base64_decode($_GET['ct']);

include_once('./creanuevoeditarsal.php');
$contrato = new creanuevoeditar($usid, $estid);
$contrato->abre_conexion("0");
$contrato->consulta_cto($reg);

    $templateWord = new TemplateProcessor('../../../formatos/contratos/'.$this->consulta['tipoc_plantilla']);

    $razonsocial  = ;
    $direccion = "Mi direccion";
    $municipio = "Mrd";
    $provincia = "Bdj";
    $cp = "02541";
    $telefono = "24536784";


    // --- Asignamos valores a la plantilla
    $templateWord->setValue('nombre_empresa',$nombre);
    $templateWord->setValue('direccion_empresa',$direccion);
    $templateWord->setValue('municipio_empresa',$municipio);
    $templateWord->setValue('provincia_empresa',$provincia);
    $templateWord->setValue('cp_empresa',$cp);
    $templateWord->setValue('telefono_empresa',$telefono);

    // --- Guardamos el documento
    $templateWord->saveAs('Documento.doc');

    header('Content-Disposition: attachment;filename="Documento.doc"');
    echo file_get_contents('Documento.doc');      

$contrato->cierra_conexion("0");
        
?>