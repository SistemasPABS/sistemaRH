<?php
$plaza= base64_decode($_GET['oc1']);//buscar por(nombre o numero)
$txt= base64_decode($_GET['oc2']);//valor a buscar
$fecha=date("Ymd");
session_start();
$usid=$_SESSION['us_id'];

include ('../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$con->user_plazas_sucursales($usid);

if($txt != NULL){
    if($plaza == 1000){
        $where="where nombrecompleto like '%$txt%' and plaza_id in ($con->pplazas)";
    }
    if($plaza != 1000){
        $where="where nombrecompleto like '%$txt%' and plaza_id = $plaza";
    }
}else if($txt == NULL){
    if($plaza == 1000){
        $where="where plaza_id in ($con->pplazas)";
    }
    if($plaza != 1000){
        $where="where plaza_id = $plaza";
    }
}
    
    $query = "select * from vw_contratos $where order by con_id desc;";
    $result = pg_query($con->conexion,$query);

    $contratos = array();
    $i = 0;
    //Asignacion de resultados al data grid
    while($row = pg_fetch_array($result)){
        $contratos[$i] = array();
        $contratos[$i]['con_id'] = $row['con_id'];
        $contratos[$i]['nombrecompleto'] = $row['nombrecompleto'];
        $contratos[$i]['tipoc_nombre'] = $row['tipoc_nombre'];
        $contratos[$i]['tipoc_plantilla'] = $row['tipoc_plantilla'];
        $contratos[$i]['plaza_nombre'] = $row['plaza_nombre'];
        $contratos[$i]['raz_nombre'] = $row['raz_nombre'];
        $contratos[$i]['puesto_nombre'] = $row['puesto_nombre'];
        $contratos[$i]['con_fecha_inicio'] = $row['con_fecha_inicio'];
        $contratos[$i]['con_fecha_fin'] = $row['con_fecha_fin'];
        if($row['con_firmado'] == 1 ){$firma='<img src="../../../images/palomaicon.png" width="14" height="14">';}else{$firma='<img src="../../../images/eliminaricon.png" width="14" height="14">';}
        $contratos[$i]['con_firmado'] = $firma;
        if($row['con_status'] == 1 ){$status='<img src="../../../images/palomaicon.png" width="14" height="14">';}else{$status='<img src="../../../images/eliminaricon.png" width="14" height="14">';}
        $contratos[$i]['con_status'] = $status;      
        $i++ ;
    }
    $con->cierra_conexion("0");
    //Respuesta del array en formato json
    echo json_encode($contratos);

?>