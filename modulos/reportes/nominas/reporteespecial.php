<?php
include_once ('../../../config/cookie.php');
include_once ('../../../config/conectasql.php');
$us_id=$_SESSION['us_id'];
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$idnom=base64_decode($_GET['idnom']);//idnom

?>
