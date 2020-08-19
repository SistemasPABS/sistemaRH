<?php
include ('../../../../../config/cookie.php');
?>
<?php
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
session_start();
$usid=$_SESSION['us_id'];
$ausid= base64_decode($_POST['aus']);  

//echo 'valor a eliminar: '.$idpersona;
include '../../../../../config/conectasql.php';
$autoriza = new conectasql();
$autoriza->abre_conexion("0");
$autoriza->consulta_aus($ausid);
//si ya fue autorizado el salario se mandara mensaje avisando que esta autorizado
if($autoriza->consulta['aus_autorizado'] == 1){
    echo '1';
}else{
    echo '0';
    
}
?>