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
            $condicion="where raz_nombre like '%$dato%'";
            break;
        case 'cve':
            $condicion="where raz_id = $dato";
            break;
    }
}else{
    $condicion="";
}
    include ('../../../config/conectasql.php');
    $con= new conectasql();
    $con->abre_conexion("0");
    $conexion=$con->conexion;
    $query = "select * from vw_razones $condicion order by raz_id desc;";
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
    $plazas = array();
    $i = 0;
    while($row = pg_fetch_array($result)){
         $razones[$i] = array();
         $razones[$i]['raz_id'] = $row['raz_id'];
         $razones[$i]['raz_nombre'] = $row['raz_nombre'];
         $razones[$i]['raz_direccion'] = $row['raz_direccion'];
         $razones[$i]['raz_legal'] = $row['raz_legal'];
         $i++ ;
    }
    $con->cierra_conexion("0");
    echo json_encode($razones);

?>