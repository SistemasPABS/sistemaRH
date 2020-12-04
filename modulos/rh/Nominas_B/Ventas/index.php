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
    
    include_once('./nominaV.php');
    $nominaV = new nominaV($usid, $estid); 
    $nominaV->librerias();
    $nominaV->abre_conexion("0");
    $nominaV->interfaz($op,$prs);
    $nominaV->cierra_conexion("0");

?>