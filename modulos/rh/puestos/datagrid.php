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
        case 'nom':
            $condicion="where puesto_nombre like '%$dato%'";
            break;
        case 'cve':
            $condicion="where puesto_cve like '%$dato%'";
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
    $query = "select * from vw_puestos $condicion order by puesto_id desc;";
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
    $puestos = array();
    $i = 0;
    while($row = pg_fetch_array($result)){
         $puestos[$i] = array();
         $puestos[$i]['puesto_id'] = $row['puesto_id'];
         $puestos[$i]['grupo'] = $row['grupo'];
         $puestos[$i]['puesto_cve'] = $row['puesto_cve'];
         $puestos[$i]['puesto_nombre'] = $row['puesto_nombre'];
         $puestos[$i]['puesto_descripcion'] = $row['puesto_descripcion'];
         $puestos[$i]['plaza_nombre'] = $row['plaza_nombre'];
         $puestos[$i]['suc_nombre'] = $row['suc_nombre'];
         $puestos[$i]['sal_nombre'] = $row['sal_nombre'];
         $puestos[$i]['puesto_fecha'] = $row['puesto_fecha'];
         $puestos[$i]['puesto_hora'] = $row['puesto_hora'];
         $puestos[$i]['us_login'] = $row['us_login'];
         $puestos[$i]['nombre_jefe'] = $row['nombre_jefe'];
         $i++ ;
    }
    $con->cierra_conexion("0");
    echo json_encode($puestos);

?>