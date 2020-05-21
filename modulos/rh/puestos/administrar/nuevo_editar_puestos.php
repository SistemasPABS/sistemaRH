<?php 
    require '../../../../config/cookie.php';
?>
<?php

    session_start();
    $usid=$_SESSION['us_id'];
    $estid = base64_decode($_GET['em']);
    $op= base64_decode($_GET['op']);
    if(isset($_GET['psto'])){
        $psto=base64_decode($_GET['psto']);
    }else{
        $psto=false;
    }
//    echo "id".$com;
    include_once('./creanuevoeditar.php');
    $plaza = new creanuevoeditar($usid, $estid);
    $plaza->librerias();
    $plaza->abre_conexion("0");
    $plaza->formulario($op,$psto);
    $plaza->cierra_conexion("0");
    
?>