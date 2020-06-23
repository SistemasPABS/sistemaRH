<?php
require '../../../../config/cookie.php';
?>
<?php
$txt= utf8_encode(base64_decode($_POST['dt1']));
$op= base64_decode($_POST['dt2']);

include ('../../../../config/conectasql.php');
$persona = new conectasql();
$persona->abre_conexion("0");
$persona->valida_datos_contrato($txt,$op);
//echo $txt.' '.$op;
echo $persona->msj;
$persona->cierra_conexion("0");

?>