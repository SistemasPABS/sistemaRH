<?php 
    require '../../../../config/cookie.php';
?>
<?php

    session_start();
    $usid=$_SESSION['us_id'];
    $estid = base64_decode($_GET['em']);
    $op= base64_decode($_GET['op']);
    if(isset($_GET['rzn'])){
        $rzn=base64_decode($_GET['rzn']);
    }else{
        $rzn=false;
    }
    
    include_once('./creanuevoeditar.php');
    $razon = new creanuevoeditar($usid, $estid);
    $razon->librerias();
    $razon->abre_conexion("0");
    $razon->formulario($op,$rzn);
    $razon->cierra_conexion("0");
    
?>