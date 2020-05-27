<?php
include ('../../../../config/cookie.php');
?>
<?php
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
$idpersona= base64_decode($_POST['prs']);  

//echo 'valor a eliminar: '.$idpersona;
include '../../../../config/conectasql.php';
$elimina = new conectasql();
$elimina->abre_conexion("0");
$elimina->elimina_persona($idpersona);
$elimina->cierra_conexion("0");

?>