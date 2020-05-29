<?php 
    require '../../../../config/cookie.php';
?>
<?php
    //Recupera la sesion del uruario
    session_start();
    //Obtiene el id del usuario de las variables de session 
    $usid=$_SESSION['us_id'];
    $estid = base64_decode($_GET['em']);
    $op= base64_decode($_GET['op']);
    //envia el registro del datagrid para las opciones de edicion
    if(isset($_GET['cto'])){
        $cto=base64_decode($_GET['cto']);
    }else{
        $cto=false;
    }
//  //Crea instancia para agregar o editar registros de contratos
    include_once('./creanuevoeditar.php');
    $contrato = new creanuevoeditar($usid, $estid);
    $contrato->librerias();
    $contrato->abre_conexion("0");
    $contrato->formulario($op,$cto);
    $contrato->cierra_conexion("0");
    
?>