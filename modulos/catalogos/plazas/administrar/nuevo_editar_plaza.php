<?php 
    require '../../../../config/cookie.php';
?>
<?php

    session_start();
    $usid=$_SESSION['us_id'];
    $estid = base64_decode($_GET['em']);
    $op= base64_decode($_GET['op']);
    if(isset($_GET['plz'])){
        $plz=base64_decode($_GET['plz']);
    }else{
        $plz=false;
    }
    
    include_once('./creanuevoeditar.php');
    $plaza = new creanuevoeditar($usid, $estid);
    $plaza->librerias();
    $plaza->abre_conexion("0");
    $plaza->formulario($op,$plz);
    $plaza->cierra_conexion("0");
    
?>