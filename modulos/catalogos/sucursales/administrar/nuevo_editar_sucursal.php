<?php 
    require '../../../../config/cookie.php';
?>
<?php

    session_start();
    $usid=$_SESSION['us_id'];
    $estid = base64_decode($_GET['em']);
    $op= base64_decode($_GET['op']);
    if(isset($_GET['suc'])){
        $suc=base64_decode($_GET['suc']);
    }else{
        $suc=false;
    }
   
    include_once('./creanuevoeditar.php');
    $plaza = new creanuevoeditar($usid, $estid);
    $plaza->librerias();
    $plaza->abre_conexion("0");
    $plaza->formulario($op,$suc);
    $plaza->cierra_conexion("0");
    
?>