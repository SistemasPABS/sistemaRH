<?php 
    //Cookei de permisos del usuario
    require '../../../../../config/cookie.php';
?>
<?php    
    //Recupera la sesion del usuario
    session_start();
    $usid=$_SESSION['us_id'];//id del usuario
    $estid = base64_decode($_GET['em']);//variable del menu o ermiso 
    $op= base64_decode($_GET['op']); //opcion nuevo o editar
    $prs = base64_decode($_GET['prs']);//id del registro de la persona
    if(isset($_GET['exp'])){ //id del regsitro del expediente
        $exp=base64_decode($_GET['exp']);
    }else{
        $exp=false;
    }      
    
//    echo 'Usuario'.$usid.'<br>';
//    echo 'Menu'.$estid.'<br>';
//    echo 'Persona'.$prs.'<br>';
    
    include_once('./creanuevo_editar.php');
    $creanuevo_editar = new creanuevo_editar($usid, $estid); 
    $creanuevo_editar->abre_conexion("0");
    $creanuevo_editar->librerias();
    //Validar si se esta agregando o editando persona
    $creanuevo_editar->formulario($op,$prs,$exp);
    $creanuevo_editar->cierra_conexion("0");
     
?>
       