<?php
include ('../../../../config/cookie.php');
include ('../../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
session_start();
$usid=$_SESSION['us_id']; 
$idnomautorizar= base64_decode($_POST['idnomautorizar']);

/*echo 'Hola';*/

$querynomina="SELECT * from nomina WHERE nom_id=$idnomautorizar";
$result=pg_query($conexion,$querynomina);
$mostrar=pg_fetch_array($result);
$autorizada=$mostrar['nom_autorizada'];

if($autorizada == 'f'){
    $query="UPDATE nomina set nom_autorizada = TRUE, nom_autorizo = $usid WHERE nom_id=$idnomautorizar";
    $result=pg_query($conexion,$query);
    echo "Listo, nomina $idnomautorizar Autorizada";
}else{
    echo 'Tu nomina ya está autorizada, ya no la puedes autorizar';
}

?>