<?php 
    require '../../../../config/cookie.php';
?>
<?php

    session_start();
    $usid=$_SESSION['us_id'];
    $estid = base64_decode($_GET['em']);
    $op= base64_decode($_GET['op']);
    if(isset($_GET['cto'])){
        $cto=base64_decode($_GET['cto']);
    }else{
        $cto=false;
    }
//    echo "id".$com;
    include_once('./creanuevoeditar.php');
    $contrato = new creanuevoeditar($usid, $estid);
    $contrato->librerias();
    $contrato->abre_conexion("0");
    $contrato->formulario($op,$cto);
    $contrato->cierra_conexion("0");
    
?>