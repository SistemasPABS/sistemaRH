<?php
require '../../../../config/cookie.php';
?>
<?php
$pid= base64_decode($_POST['pid']);
$sal= base64_decode($_POST['sal']);

include ('../../../../config/conectasql.php');
$tope = new conectasql();
$tope->abre_conexion("0");
$tope->valida_tope_salario($pid, $sal);
$msj=$tope->msj;
echo $msj;
$tope->cierra_conexion("0");

?>
