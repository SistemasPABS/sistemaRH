<?php 
    require '../../../../config/cookie.php';
?>
<?php

    session_start();
    $usid=$_SESSION['us_id'];
    $estid = base64_decode($_GET['em']);
    $op= base64_decode($_GET['op']);
    if(isset($_GET['usr'])){
        $usr=base64_decode($_GET['usr']);
    }else{
        $usr=false;
    }
    
    include_once('creanuevoeditar.php');
    $user = new creanuevoeditar($usid, $estid);
    $user->librerias();
    $user->abre_conexion("0");
    $user->formulario($op,$usr);
    $user->cierra_conexion("0");
    
?>