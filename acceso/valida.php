<?php
date_default_timezone_set('America/Mexico_City');

$fecha=date("Ymd");
$hora=date("H:i:s");
$navegador= base64_decode($_POST['chk1']);
$equipo= base64_decode($_POST['chk2']);

//se selecciona la base en la que se va a trabajar y se abre conexion
include_once ('../config/conectasql.php');
$valida = new conectasql();
$valida->abre_conexion("0");
//echo $valida->conexion;

//se valida si se esta usando firefox
if(stristr($navegador, 'firefox') === FALSE) {
    //se guarda fecha, hora, nombre y navegador del intento de acceso
    $valida->historico_af($fecha,$hora,$equipo,$navegador,'navegador no soportado');
    $valida->cierra_conexion("0");
    //se avisa que la maquina cliente no esta usando el navegador soportado
    //echo 'Necesita un navegador WEB Firefox para poder usar la aplicacion';
    echo 'acceso/af_navegador.php';
    
}else{
    //echo $equipo;
    //se valida si el equipo esta autorizado para el uso de la aplicacion
    $valida->valida_pc($equipo);
    $msj=$valida->msj;
    if($msj == 'autorizado'){
        //si esta autorizado se redirige a pantalla de login y se crea variale de sesion para derecho a login
        //echo $msj;
        session_start();
        $_SESSION['plogin'] = true; //permiso login
        echo 'login/login.php';
    }else if($msj == 'no autorizado'){
        //si no esta autorizado, se manda mensaje y se graba el acceso fallido
        $valida->historico_af($fecha, $hora, $equipo, $navegador, 'equipo no autorizado');
        //echo $msj;
        echo 'acceso/af_pc.php';
    }
}

//se cierra la conexion despues de realizar la consulta
$valida->cierra_conexion("0");

?>