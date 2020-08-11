<?php
//$dato= utf8_decode($_GET['oc']); //valor a buscar
$param= base64_decode($_GET['oc2']);//buscar por(nombre o numero)
$dato= base64_decode($_GET['oc1']);//valor a buscar
$persona=base64_decode($_GET['oc3']);//id persona
$fecha=date("Ymd");
$hora=date("HH:i:s");

if($dato != NULL){
    switch ($param) {
        case 'tip':
            $condicion=" and txp_nombre like '%$dato%'";
            break;
        case 'des':
            $condicion=" and exp_desc like '%$dato%'";
            break;
    }
    $where="where persona_id = $persona $condicion";
}else{
    $where="where persona_id = $persona";
}
    include ('../../../../config/conectasql.php');
    $con= new conectasql();
    $con->abre_conexion("0");
    $conexion=$con->conexion;
    $query = "select * from vw_ausencias $where order by aus_id desc;";
    $result = pg_query($conexion,$query);
    $aus = array();
    $i = 0;
    while($row = pg_fetch_array($result)){
         $aus[$i]['aus_id'] = $row['aus_id'];
         $aus[$i]['ta_nombre'] = $row['ta_nombre'];
         $aus[$i]['aus_vac_years'] = $row['aus_vac_years'];
         $aus[$i]['aus_correspondientes'] = $row['aus_correspondientes'];
         $aus[$i]['aus_tomados'] = $row['aus_tomados'];
         $aus[$i]['aus_disponibles'] = $row['aus_disponibles'];
         $aus[$i]['aus_dias_vac'] = $row['aus_dias_vac'];
         $aus[$i]['aus_restantes'] = $row['aus_restantes'];
         $aus[$i]['aus_dias'] = $row['aus_dias'];
         $aus[$i]['aus_fecha_inicio'] = $row['aus_fecha_inicio'];
         $aus[$i]['aus_fecha_fin'] = $row['aus_fecha_fin'];
         $aus[$i]['aus_observaciones'] = $row['aus_observaciones'];
         $aus[$i]['aus_autorizado_login'] = $row['aus_autorizado_login'];
         $i++ ;
    }
    $con->cierra_conexion("0");
    echo json_encode($aus);
?>