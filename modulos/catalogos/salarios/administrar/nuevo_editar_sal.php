<?php 
    require '../../../../config/cookie.php';
?>
<?php
    session_start();
    $usid=$_SESSION['us_id'];
    $estid = base64_decode($_GET['em']);
    $op= base64_decode($_GET['op']);
    if(isset($_GET['sl'])){
        $sal=base64_decode($_GET['sl']);
    }else{
        $sal=false;
    }
//    echo "id".$sal;
    include_once('./creanuevoeditarsal.php');
    $plaza = new creanuevoeditar($usid, $estid);
    $plaza->librerias();
    $plaza->abre_conexion("0");
    $plaza->formulario($op,$sal);
    $plaza->cierra_conexion("0");
?>