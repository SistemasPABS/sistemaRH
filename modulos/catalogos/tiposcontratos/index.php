<?php
include ('../../../config/cookie.php');
session_start();
//variable de usuario de variables de sesion
$usid=$_SESSION['us_id'];
//estructura menu
$em=base64_decode($_GET['em']);

echo '<html class="fondotrabajo">';
    include_once ('./tipo_cont.php');
    $tipocont = new tipo_cont($usid,$em);
    $tipocont->abre_conexion("0");
    $tipocont->librerias();
    $tipocont->interfaz();
echo '</html>';

?>