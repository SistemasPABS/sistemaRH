<?php
require '../../../config/cookie.php';
?>
<?php
    session_start();
    $usid=$_SESSION['us_id'];
    $ns = base64_decode($_POST['ns']);
    $op = base64_decode($_POST['op']);
    //echo $ns;
    include ('../../../config/conectasql.php');
    $nuevoselect = new conectasql();
    $nuevoselect->abre_conexion("0");
    $nuevoselect->selects_creator('select * from vw_users_plazas_sucursales where us_id = '. $usid.' and plaza_id = '.$ns.' order by plaza_id', 'sucursales', 'suc_id', 'suc_nombre', 'sucursales', 'onChange= ""', '');
    echo $nuevoselect->select;
    $nuevoselect->cierra_conexion("0");
?>
