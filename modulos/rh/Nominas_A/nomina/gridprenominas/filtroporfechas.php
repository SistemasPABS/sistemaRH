<?php 
include_once ('../../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
session_start();
$us_id=$_SESSION['us_id'];

$filtroinicio= base64_decode($_POST['filtroinicio']);
$filtrofin= base64_decode($_POST['filtrofin']);

$query = "SELECT * from vw_nomina_tiposalario_usuarios WHERE fechageneracion BETWEEN $filtroinicio AND $filtrofin";
$result=pg_query($conexion,$query) or die ('Error al consultar con esas fechas'.pg_last_error());
$mostrar=pg_fetch_array($result);

if($mostrar=pg_fetch_array($result)){

}else{
    echo 'No hay resultados con estos filtros';
}

?>