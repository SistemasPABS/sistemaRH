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
            $condicion="where tipoc_nombre like '%$dato%'";
            break;
        case 'cve':
            $condicion="where tipoc_cve like '%$dato%'";
            break;
    }
}else{
    $condicion="";
}
    include ('../../../config/conectasql.php');
    $con= new conectasql();
    $con->abre_conexion("0");
    $conexion=$con->conexion;
    $query = "select * from vw_tipos_contratos $condicion order by tipoc_id desc;";
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
         $tipo_con[$i] = array();
         $tipo_con[$i]['tipoc_id'] = $row['tipoc_id'];
         $tipo_con[$i]['tipoc_cve'] = $row['tipoc_cve'];
         $tipo_con[$i]['tipoc_nombre'] = $row['tipoc_nombre'];
         if(!empty($row['tipoc_plantilla'])){
             $cont='<a href="../../../formatos/contratos/'.$row['tipoc_plantilla'].'"><img src="../../../images/download.png" width="18" height="18"></a>';
         }else{
             $cont='<img src="../../../images/eliminaricon.png" width="14" height="14">';
         }
         $tipo_con[$i]['tipoc_plantilla'] = $cont;
         $i++ ;
    }
    $con->cierra_conexion("0");
    echo json_encode($tipo_con);

?>