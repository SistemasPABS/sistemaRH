<?php 
    require '../../../../config/cookie.php';
?>
<?php

    session_start();
    
    $usid=$_SESSION['us_id'];
    $estid = base64_decode($_GET['em']);
    $op= base64_decode($_GET['op']);
    
    if(isset($_GET['prs'])){
        $prs=base64_decode($_GET['prs']);
    }
    else{
        $prs=false;
    }

    include_once('./nominaC.php');
    $nominaC = new nominaC($usid, $estid); 
    $nominaC->librerias();
    $nominaC->abre_conexion("0");
    $nominaC->interfaz($op,$prs);
    $nominaC->cierra_conexion("0");

?>