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
    
    include_once('ver_exp.php');
    $admin_exp = new ver_exp($usid, $estid); 
    $admin_exp->librerias();
    $admin_exp->abre_conexion("0");
    //Validar si se esta agregando o editando persona
    $admin_exp->interfaz($prs);
    $admin_exp->cierra_conexion("0");
     
?>
       