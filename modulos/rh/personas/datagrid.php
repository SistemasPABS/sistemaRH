<?php
//$dato= utf8_decode($_GET['oc']); //valor a buscar
$param= base64_decode($_GET['oc2']);//buscar por(nombre o numero)
$dato= base64_decode($_GET['oc1']);//valor a buscar
$fecha=date("Ymd");
session_start();
$usid=$_SESSION['us_id'];
//echo $fecha;
$nuevafecha = strtotime ( '-2 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date( 'Ymd' , $nuevafecha );
include ('../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
//se obtienen las plazas a las cuales tiene derecho el usuario  
$con->user_plazas_sucursales($usid);  
$plazas=$con->pplazas;
//echo $nuevafecha;
if($dato != NULL){
    switch ($param) {
        case 'nom':
            $condicion="nombrecompleto like '%$dato%' and plaza_id in ($plazas)";
            break;
        case 'cve':
            $condicion="persona_cve like '%$dato%' and plaza_id in ($plazas)";
            break;
        case 'may':
            $condicion="persona_id > $dato and plaza_id in ($plazas)";
            break;
        case 'men':
            $condicion="persona_id < $dato and plaza_id in ($plazas)";
            break;
        case 'est':
            $condicion="persona_status = $dato and plaza_id in ($plazas)";
            break;
    }
    $where="where $condicion";
}else{
    $where="where plaza_id in ($plazas)";
}
    
    $query = "select * from vw_personas2 $where order by persona_cve desc;";
    $result = pg_query($conexion,$query);
//    if ($row = odbc_fetch_row($result)){
//        do{
//            for($i=1;$i<=odbc_num_fields($result);$i++){
//            echo "---".odbc_result($result,$i);
//            if($i == odbc_num_fields($result)){echo '<br>';}
//            }
//        }
//        while($row = odbc_fetch_row($result));
//    }
    $users = array();
    $i = 0;
    while($row = pg_fetch_array($result)){
         $users[$i] = array();
         $users[$i]['persona_id'] = $row['persona_id'];
         $users[$i]['persona_cve'] = $row['persona_cve'];
         $users[$i]['nombrecompleto'] = $row['nombrecompleto'];
         $users[$i]['persona_correo'] = $row['persona_correo'];
         $users[$i]['numtel'] = $row['numtel'];
         if($row['persona_status'] == 1 ){$status='<img src="../../../images/palomaicon.png" width="14" height="14">';}else{$status='<img src="../../../images/eliminaricon.png" width="14" height="14">';}
         $users[$i]['persona_status'] = $status;
         //validacion para indicar el status con un icono
         //if($row['us_habilitado'] == 't'){$activo='<img src="../../../imagenes/palomaicon.png" width="14" height="14">';}else{$activo='<img src="../../../imagenes/eliminaricon.png" width="14" height="14">';}
         //$users[$i]['us_habilitado'] = $activo;
         $i++ ;
    }
    $con->cierra_conexion("0");
    echo json_encode($users);

?>