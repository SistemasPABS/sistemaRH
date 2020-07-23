<?php
session_start();
include ('../../../../../conexiones/cookie.php');

echo '<link rel="stylesheet" type="text/css" href="../../../../../estilo.css">';
echo '<link rel="stylesheet" type="text/css" href="../../../../../estiloarbol.css">';
echo '<link rel="stylesheet" type="text/css" href="../../../../../librerias/jscalendario/calendar-green.css" >';
echo '<link rel="stylesheet" href="../../../../../autocomplete.css" type="text/css" media="screen">';

if(!isset($_POST['usnombre'])){
    include_once ('creanuevouser.php');
    $busqueda = new creanuevouser();
    $busqueda->javascript();
    $busqueda->titulo('Nuevo Usuario');
    $busqueda->pestanas('nuevouser.php');
}else{
    include_once ('creanuevouser.php');
    if(isset($_POST['usadmin'])){$administrador='true';}else{$administrador='false';}
    if(isset($_POST['ushabilitado'])){$habilitado='true';}else{$habilitado='false';}
    if($_POST['uscentro'] == 0){$centro='null';}else{$centro=$_POST['uscentro'];}
    $busqueda = new creanuevouser();
    $busqueda->agregausuario(
            $_POST['usnombre'],
            $_POST['uspaterno'],
            $_POST['usmaterno'],
            $administrador,
            $habilitado,
            $_POST['uspassword'],
            $_POST['usemail'],
            $_POST['ustelefono'],
            $_POST['uslogin'],
            $_POST['usfechacaducidad'],
            $centro,
            $_POST['marca'],
            $_POST['asignacion']
            );
}

?>
