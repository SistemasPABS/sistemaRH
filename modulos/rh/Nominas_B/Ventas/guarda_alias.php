<?php

    $error = array(); //ARRAY PARA ALMACENAR ERRORES       
    //Validaciones de campos seteados y no vacios 
    if(!isset($_POST['id_persona']) || empty($_POST['id_persona'])){
        $error[] = "id_persona";
    }else if (isset($_POST['id_persona']) || !empty($_POST['id_persona'])) {
        $id = $_POST['id_persona'];
    }
    //Variable id del contrato
    if(!isset($_POST['alias']) || empty($_POST['alias'])){
        $error[] = "alias";
    }else if (isset($_POST['alias']) || !empty($_POST['alias'])) {
        $alias = $_POST['alias'];
    }

        include '../sql.php';
        $insert = new sqlad();
        $insert->abre_conexion("0");
        $conexion=$insert->conexion;
        
        $sql = "insert into alias_personas (persona_id, alias) VALUES ('$id', '$alias');";
        $rs = pg_query($conexion, $sql) or die("Error db: ".pg_last_error());

        if ($rs!=0) {
            $insert->exito('../../../../estilos/personasStyles.css');
        }else{
            echo 'error'.pg_last_error();
        }
   
    $insert->cierra_conexion("0");
  //  $insert->exito('../../../../estilos/personasStyles.css');
   
?>