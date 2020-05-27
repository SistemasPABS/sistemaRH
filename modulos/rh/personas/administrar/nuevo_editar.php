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
    }else{
        $prs=false;
    }
    
    include_once('./creanuevo_editar.php');
    $creanuevo_editar = new creanuevo_editar($usid, $estid); 
    $creanuevo_editar->librerias();
    $creanuevo_editar->abre_conexion("0");
    //Validar si se esta agregando o editando persona
    $creanuevo_editar->formulario($op,$prs);
    $creanuevo_editar->cierra_conexion("0");
     
?>
       