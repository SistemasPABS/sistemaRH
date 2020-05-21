<?php
include ('../../../config/cookie.php');
session_start();
$usid=$_SESSION['us_id'];
$em=base64_decode($_GET['em']);//estructura menu

echo '<html class="fondotrabajo">';
    include_once ('./empresas.php');
    $presa = new empresas($usid,$em);
    $presa->abre_conexion("0");
    $presa->librerias();
    $presa->interfaz();
echo '</html>';

?>