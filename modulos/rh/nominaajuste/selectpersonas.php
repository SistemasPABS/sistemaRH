<?php 
include_once('../../../config/cookie.php');
include_once('../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$em=base64_decode($_GET['em']);
session_start();
$usid=$_SESSION['us_id'];
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
$plaza=base64_decode($_GET['oc1']);//plaza
$empid=base64_decode($_GET['oc2']); //empid
$tipoperiodo=base64_decode($_GET['oc3']);//tipoperiodo
$fechaperiodo=base64_decode($_GET['oc4']); //fechaperiodo
$numservicios=base64_decode($_GET['oc5']);//numservicios
$ventasdirectas=base64_decode($_GET['oc6']);//ventasdirectas
$cobrosporventa=base64_decode($_GET['oc7']);//cobrosporventa
$saldo=base64_decode($_GET['oc8']);//saldo
$ingresos=base64_decode($_GET['oc9']);//ingresos
$observaciones=base64_decode($_GET['oc10']);//observaciones
$em=base64_decode($_GET['oc11']);//estructura menu
$cobrosanteriores=base64_decode($_GET['oc12']);//cobrosanteriores
$recibototal=base64_decode($_GET['oc13']);//recibototal
$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);//computadora de donde se hace

$sql1="SELECT * FROM vw_nominasautorizadas WHERE idperiodo=$fechaperiodo";
$result1 = pg_query($conexion,$sql1) or die("Error al obtener la informacion de la nomina autorizada");
$row1 = pg_fetch_array($result1);
$idnomina = $row1['nom_id'];

$sql2="INSERT into tmp_base_nom_ajuste (us_id,fecha,hora,plaza_id,num_ventas,venta_directa,cobros,saldo,cobros_per_ant,observaciones,emp_id,sal_tipo_id,fecha_inicio,fecha_fin,pc,ingresos,recibototal,idnomina) values ($us_id,'$fecha','$hora',$plaza,$numservicios,$ventasdirectas,$cobrosporventa,$saldo,$cobrosanteriores,'$observaciones','$empid',$tipoperiodo,'".$row1['fecha_inicio']."','".$row1['fecha_final']."','$pc',$ingresos,$recibototal,$idnomina)";
$result2 = pg_query($conexion,$sql2) or die("Error en la insercion de datos temporales de base nom".pg_last_error());



?>