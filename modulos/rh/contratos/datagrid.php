<?php
$plaza  = base64_decode($_GET['oc1']);//valor a buscar
$suc    = base64_decode($_GET['oc2']);//buscar por(nombre o numero)
$nombre = utf8_decode(base64_decode($_GET['oc3']));//valor a buscar
$fecha  = date("Ymd");
session_start();
$usid=$_SESSION['us_id'];

include ('../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");

//se validan los datos recogido de la forma de busqueda
if($plaza == 1000 && $suc == 1000 && $nombre == null){
    //si no se ha seleccionado ningun campo se configura la consulta default
    $con->suc_user_aprov($usid);
    $sucaprov= substr($con->consulta,1);
    $condicion='where suc_id in('.$sucaprov.')';
}else{
    if( $plaza != 1000){
        $cplaza=' and plaza_id = '.$plaza;
    }else{
        $cplaza='';
    }
    if( $suc != 1000){
        $csuc=' and suc_id = '.$suc;
    }else{
        $csuc='';
    }
    if( $nombre != null){
        $cnombre=' and tipoc_nombre like \'%'.$nombre.'%\'';
    }else{
        $cnombre='';
    }
    //se crea la condicion
    $condicion=$cplaza.$csuc.$cnombre;
    $condicion= substr($condicion,4);
    $condicion='where'.$condicion;
}
    
    $query = "select * from vw_contratos $condicion order by con_id desc;";
    $result = pg_query($con->conexion,$query);

    $puestos = array();
    $i = 0;
    //Asignacion de resultados al data grid
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
         if($row['con_status'] == 1 ){$status='<img src="../../../images/palomaicon.png" width="14" height="14">';}else{$status='<img src="../../../images/eliminaricon.png" width="14" height="14">';}
         $puestos[$i]['con_status'] = $status;      
         $i++ ;
    }
    $con->cierra_conexion("0");
    //Respuesta del array en formato json
    echo json_encode($puestos);

?>