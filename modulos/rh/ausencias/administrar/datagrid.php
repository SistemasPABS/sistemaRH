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
    $query = "select * from vw_doc_expedientes $where order by exp_id desc;";
    $result = pg_query($conexion,$query);
    $users = array();
    $i = 0;
    while($row = pg_fetch_array($result)){
         $exps[$i] = array();
         $exps[$i]['exp_id'] = $row['exp_id'];
         $exps[$i]['exp_desc'] = $row['exp_desc'];
         $exps[$i]['exp_fecha'] = $row['exp_fecha'];
         $exps[$i]['exp_hora'] = $row['exp_hora'];
         $exps[$i]['txp_nombre'] = $row['txp_nombre'];
         if($row['exp_ruta'] != '' )
         {
             $status='<a href="../../../../formatos/expedientes/'.$row['exp_ruta'].'"><img src="../../../../images/download.png" width="14" height="14"></a>';
         }else{
             $status='<img src="../../../../images/eliminaricon.png" width="14" height="14">';
         }
         $exps[$i]['exp_ruta'] = $status;
         $i++ ;
    }
    $con->cierra_conexion("0");
    echo json_encode($exps);
?>