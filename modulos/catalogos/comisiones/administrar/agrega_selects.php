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
    $nuevoselect->selects_creator('select * from sucursales where plaza_id='.$ns.' order by suc_id', 'sucursales', 'suc_id', 'suc_nombre', 'sucursal', 'onChange=""');
    echo $nuevoselect->select;
    $nuevoselect->cierra_conexion("0");
?>
