<?php
include ('../../../config/cookie.php');
session_start();
$usid=$_SESSION['us_id'];
$em=base64_decode($_GET['em']);//estructura menu

echo '<html class="fondotrabajo">';
    include_once ('./creapuestos.php');

    $suc = new creapuestos($usid,$em);
    $suc->abre_conexion("0");
    $suc->librerias();
    $suc->interfaz();
    $suc->cierra_conexion("0");
    
echo '</html>';


?>

    