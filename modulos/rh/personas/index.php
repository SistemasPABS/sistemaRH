<?php
include ('../../../config/cookie.php');
session_start();
$usid=$_SESSION['us_id'];
$em=base64_decode($_GET['em']);//estructura menu

echo '<html class="fondotrabajo">';
    include_once ('./creapersonas.php');
    $busqueda = new creapersonas($usid,$em);
    $busqueda->abre_conexion("0");
    $busqueda->librerias();
    $busqueda->interfaz();
    $busqueda->cierra_conexion("0");
echo '</html>';


?>