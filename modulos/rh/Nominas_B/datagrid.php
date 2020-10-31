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
            $condicion="no_nomina like '%$dato%'";
            break;
        case 'plz':
            $condicion="plaza_nombre like '%$dato%'";
            break;
        case 'area':
            $condicion="area like '%$dato%'";
            break;
    }
    $where="where $condicion";
}else{
    $where="";
}
    include ('../../../config/conectasql.php');
    $con= new conectasql();
    $con->abre_conexion("0");
    $conexion=$con->conexion;
    $query = "select * from vw_b_nominas $where order by nomina_id desc;";
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
    $nominas = array();
    $i = 0;
    while($row = pg_fetch_array($result)){
        $nominas[$i] = array();
        $nominas[$i]['nomina_id'] = $row['nomina_id'];
        $nominas[$i]['no_nomina'] = $row['no_nomina'];
        $nominas[$i]['plaza_nombre'] = $row['plaza_nombre'];
        $nominas[$i]['area'] = $row['area'];
        $nominas[$i]['nombre_u'] = $row['nombre_u'];
        $nominas[$i]['observaciones'] = $row['observaciones'];
        $nominas[$i]['xp_id'] = $row['xp_id'];
         //validacion para indicar el status con un icono
         //if($row['us_habilitado'] == 't'){$activo='<img src="../../../imagenes/palomaicon.png" width="14" height="14">';}else{$activo='<img src="../../../imagenes/eliminaricon.png" width="14" height="14">';}
         //$users[$i]['us_habilitado'] = $activo;
        $i++ ;
    }
    $con->cierra_conexion("0");
    echo json_encode($nominas);

?>