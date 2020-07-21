<?php
include ('../../../../config/cookie.php');
?>
<?php
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
session_start();
$usid=$_SESSION['us_id'];
$plaza= base64_decode($_POST['plz']);  

//echo 'valor a eliminar: '.$idpersona;
include ('../../../../config/conectasql.php');
$elimina = new conectasql();
$elimina->abre_conexion("0");
$elimina->consulta_plaza_contratos($plaza);
//echo $elimina->consulta;
//si la consulta es igual a 0 no se puede eliminar
if($elimina->consulta == 0){
    echo 'La plaza no se puede eliminar por que hay contratos activos ligados';
}else if($elimina->consulta == 1){
    //si la consulta es igual a 1 se puede eliminar la plaza
    //$elimina->elimina_plaza($plaza);
    echo 'La plaza ha sido eliminada';
}
?>