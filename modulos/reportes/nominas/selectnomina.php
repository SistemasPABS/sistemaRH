<?php
include_once ('../../../config/cookie.php');
include_once ('../../../config/conectasql.php');
session_start();
$us_id=$_SESSION['us_id'];
$nomid= base64_decode($_POST['idnomina']);
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
//echo $oc1;
$query="SELECT * from vw_reporte_estado_financiero WHERE nom_id = $nomid order by nom_id";
$result= pg_query($conexion,$query);
$mostrar= pg_fetch_array($result);
echo'<div id=opcion>'
. '<select id="fechasnomina">';
do{
    echo '<option value="'.$mostrar['nom_id'].'">'.$mostrar['nom_id'].'-'.$mostrar['fecha_inicio'].'--'.$mostrar['fecha_fin'].'</option>';
}while($mostrar= pg_fetch_array($result));
echo'</select>';
echo'</div>';
?>


