<?php
include_once('../../../config/cookie.php');
include_once ('../../../config/conectasql.php');
session_start();
$us_id=$_SESSION['us_id'];
$oc1= base64_decode($_POST['idtp']);
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
//echo $oc1;
if ($oc1==1){
    $query="SELECT idperiodo, num_periodo, fecha_inicio, fecha_final from periodos WHERE id_sal_tipo = 1 order by num_periodo";
    
}else 
    if($oc1==2){
        $query="SELECT idperiodo, num_periodo, fecha_inicio, fecha_final from periodos WHERE id_sal_tipo = 2 order by num_periodo";
    }
else
    if($oc1==3){
        $query="SELECT idperiodo, num_periodo, fecha_inicio, fecha_final from periodos WHERE id_sal_tipo = 3 order by num_periodo";
    }
else
    if($oc1==4){
        $query="SELECT idperiodo, num_periodo, fecha_inicio, fecha_final from vw_periodonomina WHERE autorizada = true order by num_periodo";
    }
else{
        echo 'Opcion no valida, escoge una!!!';
}
$result= pg_query($conexion,$query);
$mostrar= pg_fetch_array($result);
echo'<div id=opcion>'
. '<select id="fechaperiodo">';
do{
    echo '<option value="'.$mostrar['idperiodo'].'">'.$mostrar['num_periodo'].'-'.$mostrar['fecha_inicio'].'--'.$mostrar['fecha_final'].'</option>';
}while($mostrar= pg_fetch_array($result));
echo'</select>';
echo'</div>';
?>


