<?php
    include ('../../../config/cookie.php');
    session_start();
    $usid=$_SESSION['us_id'];//id del usuario variables de sesion
    $em=base64_decode($_GET['em']);//estructura menu

    echo '<html class="fondotrabajo">';
        include_once ('./expedientes.php');
        //Instancia del datagrid de personas para expedientes 
        $datagrid_exp = new expedientes($usid,$em);
        $datagrid_exp->abre_conexion("0");
        //Importa librerias de estilos, gquiery y javascript
        $datagrid_exp->librerias();
        //Interfaz del datagrid.
        $datagrid_exp->interfaz();
        $datagrid_exp->cierra_conexion("0");
    echo '</html>';

?>