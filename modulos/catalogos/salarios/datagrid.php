<?php
//$dato= utf8_decode($_GET['oc']); //valor a buscar
$param= base64_decode($_GET['oc2']);//buscar por(nombre o numero)
$dato= base64_decode($_GET['oc1']);//valor a buscar
$fecha=date("Ymd");
//echo $fecha;
//$nuevafecha = strtotime ( '-2 day' , strtotime ( $fecha ) ) ;
//$nuevafecha = date( 'Ymd' , $nuevafecha );
//echo $nuevafecha;
if($dato != NULL){
    switch ($param) {
        case 'desc':
            $condicion="where sal_descripcion like '%$dato%'";
            break;
        case 'suc':
            $condicion="where suc_nombre like '%$dato%'";
            break;
        case 'plz':
            $condicion="where plaza_nombre like '%$dato%'";
            break;
    }
}else{
    $condicion="";
}
    include ('../../../config/conectasql.php');
    $con= new conectasql();
    $con->abre_conexion("0");
    $conexion=$con->conexion;
    $query = "select * from vw_salarios $condicion order by sal_id desc;";
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
    $suc = array();
    $i = 0;
    while($row = pg_fetch_array($result)){
         $suc[$i] = array();
         $suc[$i]['sal_id'] = $row['sal_id'];
         $suc[$i]['sal_nombre'] = $row['sal_nombre'];
         $suc[$i]['sal_descripcion'] = $row['sal_descripcion'];
         $suc[$i]['plaza_nombre'] = $row['plaza_nombre'];
         $suc[$i]['suc_nombre'] = $row['suc_nombre'];
         $suc[$i]['sal_monto'] = $row['sal_monto'];
         $suc[$i]['sal_tipo'] = $row['sal_tipo'];
         $suc[$i]['us_login'] = $row['us_login'];
         if($row['sal_activo'] == 1 ){$status='<img src="../../../images/palomaicon.png" width="14" height="14">';}else{$status='<img src="../../../images/eliminaricon.png" width="14" height="14">';}
         $suc[$i]['sal_activo'] = $status;
         //validacion para indicar el status con un icono
         //if($row['us_habilitado'] == 't'){$activo='<img src="../../../imagenes/palomaicon.png" width="14" height="14">';}else{$activo='<img src="../../../imagenes/eliminaricon.png" width="14" height="14">';}
         //$users[$i]['us_habilitado'] = $activo;
         $i++ ;
    }
    $con->cierra_conexion("0");
    echo json_encode($suc);

?>