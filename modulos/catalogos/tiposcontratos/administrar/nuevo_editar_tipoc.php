<?php 
    require '../../../../config/cookie.php';
?>
<?php

    session_start();
    $usid=$_SESSION['us_id'];
    $estid = base64_decode($_GET['em']);
    $op= base64_decode($_GET['op']);
    if(isset($_GET['$tipc'])){
        $tipc=base64_decode($_GET['$tipc']);
    }else{
        $tipc=false;
    }
    
    include_once('./creanuevoeditar.php');
    $razon = new creanuevoeditar($usid, $estid);
    $razon->librerias();
    $razon->abre_conexion("0");
    $razon->formulario($op,$tipc);
    $razon->cierra_conexion("0");
    
?>