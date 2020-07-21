<?php
session_start();
include('../../../../../conexiones/cookie.php');
$dato=$_GET['var'];
$dir='../nuevo/';

echo '<link rel="stylesheet" type="text/css" href="../../../../../estilo.css">';
echo '<link rel="stylesheet" type="text/css" href="../../../../../estiloarbol.css">';
echo '<link rel="stylesheet" type="text/css" href="../../../../../librerias/jscalendario/calendar-green.css" >';
echo '<link rel="stylesheet" href="../../../../../autocomplete.css" type="text/css" media="screen">';

if(!isset($_POST['usnombre'])){
    include_once (''.$dir.'creanuevouser.php');
    $busqueda = new creanuevouser();
    $busqueda->modificauser($dato);
    $busqueda->direccion($dir);
    $busqueda->javascript();
    $busqueda->titulo('Editar Usuario');
    $busqueda->pestanas('edita.php');
}else{
     if(isset($_POST['usadmin'])){$admin='true';}else{$admin='false';}
    if(isset($_POST['ushabilitado'])){$habilitado='true';}else{$habilitado='false';}
    if($_POST['uscentro'] == 0){$centro='null';}else{$centro=$_POST['uscentro'];}
    include_once (''.$dir.'creanuevouser.php');
    $busqueda = new creanuevouser();
    $busqueda->editauser(
            $_POST['usnombre'],
            $_POST['uspaterno'],
            $_POST['usmaterno'],
            $admin,
            $habilitado,
            $_POST['uspassword'],
            $_POST['usemail'],
            $_POST['ustelefono'],
            $_POST['uslogin'],
            $_POST['usfechacaducidad'],
            $centro,
            $_POST['marca'],
            $_POST['asignacion'],
            $dato
            );
}

?>
