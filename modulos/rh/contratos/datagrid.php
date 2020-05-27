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
            $condicion="where nombrecompleto like '%$dato%'";
            break;
        case 'cve':
            $condicion="where con_id like '%$dato%'";
            break;
       
    }
}else{
    $condicion="";
}
    include ('../../../config/conectasql.php');
    $con= new conectasql();
    $con->abre_conexion("0");
    $conexion=$con->conexion;
    $query = "select * from vw_contratos $condicion order by con_id desc;";
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
         $puestos[$i]['con_id'] = $row['con_id'];
         $puestos[$i]['nombrecompleto'] = $row['nombrecompleto'];
         $puestos[$i]['tipoc_nombre'] = $row['tipoc_nombre'];
         $puestos[$i]['tipoc_plantilla'] = $row['tipoc_plantilla'];
         $puestos[$i]['plaza_nombre'] = $row['plaza_nombre'];
         $puestos[$i]['raz_nombre'] = $row['raz_nombre'];
         $puestos[$i]['puesto_nombre'] = $row['puesto_nombre'];
         $puestos[$i]['con_fecha_inicio'] = $row['con_fecha_inicio'];
         $puestos[$i]['con_fecha_fin'] = $row['con_fecha_fin'];
         $puestos[$i]['con_status'] = $row['con_status'];
         $i++ ;
    }
    $con->cierra_conexion("0");
    echo json_encode($puestos);

?>