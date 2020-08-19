<?php
require '../../../../config/cookie.php';
?>
<?php
$pid= base64_decode($_POST['pid']);
$cst= base64_decode($_POST['con']);

include ('../../../../config/conectasql.php');
$cactivo = new conectasql();
$cactivo->abre_conexion("0");
$cactivo->valida_c_activos($pid,$cst);
//echo $txt.' '.$op;
echo $cactivo->msj;
$cactivo->cierra_conexion("0");

?>