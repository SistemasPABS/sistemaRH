<?php
//Armado de la vista de contratos
include ('../../../config/cookie.php');
session_start();
$usid=$_SESSION['us_id'];
//estructura menu
$em=base64_decode($_GET['em']);

echo '<html class="fondotrabajo">';
    include_once ('./contratos.php');
    $contratos = new contratos($usid,$em);
    $contratos->abre_conexion("0");
    $contratos->librerias();
    $contratos->interfaz();
    $contratos->cierra_conexion("0");
    
echo '</html>';


?>

    