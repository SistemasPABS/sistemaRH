<?php
include('../../../../../conexiones/config2.php');
$eliminar=$_POST['var1'];

$conexion="host=$servidor port=$port dbname=$database user=$usuariodb password=$pasdb";
$conectando= pg_connect($conexion) or die ("Error de conexion ".pg_last_error());

$sqlid="select us_login from vw_usuarios where us_id = $eliminar ";
$resultid=  pg_query($conectando,$sqlid);
$rowid=  pg_fetch_array($resultid);
$id=$rowid['us_login'];
$sqlelimina="select eliminar_usuario_func($eliminar)";
$resultelimina= pg_query($conectando,$sqlelimina)or die(pg_last_error());
echo 'Se ha eliminado al empleado "'.$id.'" de la base de datos';

?>

