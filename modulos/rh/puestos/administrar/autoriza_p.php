<?php
include ('../../../../config/cookie.php');
?>
<?php
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
session_start();
$usid=$_SESSION['us_id'];
$puestoid= base64_decode($_POST['pue']);  

//echo 'valor a eliminar: '.$idpersona;
include ('../../../../config/conectasql.php');
$autoriza = new conectasql();
$autoriza->abre_conexion("0");
$autoriza->consulta_puesto($puestoid);
//si ya fue autorizado el puesto se mandara mensaje avisando que esta autorizado
if($autoriza->consulta['puesto_aprovado'] == 1){
    echo 'El puesto ha sido autorizado previamente';
}else{
    $autoriza->autoriza_puesto($usid,$puestoid,$fecha,$hora);
    $autoriza->cierra_conexion("0");
    if($autoriza->autoriza == '1'){
        echo 'Autorizacion realizada';
    }else{
        echo 'Error durante autorizacion!!!';
    }
}
?>