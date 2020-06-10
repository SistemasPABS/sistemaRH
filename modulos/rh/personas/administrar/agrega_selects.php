<?php
require '../../../../config/cookie.php';
?>
<?php
    $ns = base64_decode($_POST['ns']);
    $op = base64_decode($_POST['op']);
    //echo $ns;
    include ('../../../../config/conectasql.php');
    $nuevoselect = new conectasql();
    $nuevoselect->abre_conexion("0");
    if($op == 'est'){
        $nuevoselect->selects_creator('select * from estados where pais_id='.$ns.' order by est_id', 'estados', 'est_id', 'est_nombre', 'estado', 'onChange="ver_municipios();"','');
        echo $nuevoselect->select;
    }else if($op == 'mcp'){
        $nuevoselect->selects_creator('select * from municipios where est_id='.$ns.' order by mcp_nombre', 'municipios', 'mcp_id', 'mcp_nombre', 'municipio', 'onChange=""','');
        echo $nuevoselect->select;
    }
    $nuevoselect->cierra_conexion("0");
?>
