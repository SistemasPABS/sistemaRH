<?php
//$dato= utf8_decode($_GET['oc']); //valor a buscar
$param= base64_decode($_GET['oc2']);//buscar por(nombre o numero)
$dato= base64_decode($_GET['oc1']);//valor a buscar
$fecha=date("Ymd");
//echo $fecha;
$nuevafecha = strtotime ( '-2 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date( 'Ymd' , $nuevafecha );
//echo $nuevafecha;
if($dato != NULL){
    switch ($param) {
        case 'nom':
            $condicion='nombrecompleto';
            break;
        case 'cve':
            $condicion='persona_cve';
            break;
        case 'are':
            $condicion='suc_nombre';
            break;
    }
    $where="where $condicion like '%$dato%'";
}else{
    $where="";
}
    include ('../../../config/conectasql.php');
    $con= new conectasql();
    $con->abre_conexion("0");
    $conexion=$con->conexion;
    $query = "select persona_id,persona_cve,nombrecompleto,persona_correo,persona_status,plaza_nombre,suc_nombre,con_fecha_inicio from vw_contratos $where order by persona_id desc;";
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
         $users[$i]['con_fecha_inicio'] = $row['con_fecha_inicio'];
         $users[$i]['nombrecompleto'] = $row['nombrecompleto'];
         $users[$i]['plaza_nombre'] = $row['plaza_nombre'];
         $users[$i]['suc_nombre'] = $row['suc_nombre'];
         $users[$i]['persona_correo'] = $row['persona_correo'];
         if($row['persona_status'] == 1 )
         {
             $status='<img src="../../../images/palomaicon.png" width="14" height="14">';
         }else{
             $status='<img src="../../../images/eliminaricon.png" width="14" height="14">';
         }
         $users[$i]['persona_status'] = $status;
         //icono para descargar expediente de la persona seleccionada
        // $users = '<img src="../../../images/eliminaricon.png" width="14" height="14">';
         $i++ ;
    }
    $con->cierra_conexion("0");
    echo json_encode($users);

?>