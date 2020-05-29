<?php
//$dato= utf8_decode($_GET['oc']); //valor a buscar
$param= base64_decode($_GET['oc2']);//buscar por(nombre o numero)
$dato= base64_decode($_GET['oc1']);//valor a buscar
$fecha=date("Ymd");

if($dato != NULL){
    //Switch para la busqueda desde el datagrid
    switch ($param) {
        case 'nom':
            $condicion="where nombrecompleto like '%$dato%'";
            break;
        case 'pza':
            $condicion="where plaza_nombre like '%$dato%'";
            break;
        case 'cto':
            $condicion="where con_nombre like '%$dato%'";
            break;
       
    }
}else{
    //Busqueda sin filtro
    $condicion="";
}
    include ('../../../config/conectasql.php');
    $con= new conectasql();
    $con->abre_conexion("0");
    $conexion=$con->conexion;
    $query = "select * from vw_contratos $condicion order by con_id desc;";
    $result = pg_query($conexion,$query);

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