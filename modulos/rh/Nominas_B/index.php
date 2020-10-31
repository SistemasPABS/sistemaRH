<?php
include ('../../../config/cookie.php');
session_start();
$usid=$_SESSION['us_id'];
$em=base64_decode($_GET['em']);//estructura menu

echo '<html>';
    include_once ('./nominasMenu.php');
    $nominas = new nominasMenu($usid,$em);
    $nominas->abre_conexion("0");
    $nominas->librerias();
    $nominas->interfaz();
    $nominas->cierra_conexion("0");
echo '</html>';

?>