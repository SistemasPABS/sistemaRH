<?php 
    //Cookie para validar permisos de usuario
    require '../../../../config/cookie.php';
?>
<?php
    //REcupera sesion de usuario
    session_start();
    $usid=$_SESSION['us_id'];
    //Recibe estructura del menu
    $estid = base64_decode($_GET['em']);
    //Recibe el nombre y registro de la persona para editar 
    $prs=base64_decode($_GET['prs']);
    
    include_once('./ver_ausencias.php');
    $admin_aus = new ver_ausencias($usid, $estid); 
    $admin_aus->librerias();
    $admin_aus->abre_conexion("0");
    //Validar si se esta agregando o editando persona
    $admin_aus->interfaz($prs);
    $admin_aus->cierra_conexion("0");
     
?>
       