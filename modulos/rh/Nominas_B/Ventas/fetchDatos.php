<?php

$op=base64_decode($_POST['op']);
//Valor del campo a buscar 
$search=$_POST['search'];
    include ('../sql.php');
    $campos = new sqlad();
    $campos->abre_conexion("0");
    //Consulta y llenado de array para la funcion de autocompletar.
    if($op == 'per'){
        $sql = "select * from vw_personas where nombrecompleto like '%$search%'";
        $result = pg_query($campos->conexion,$sql) or die("Error cds: ". pg_last_error());//creador de selects
            while($row = pg_fetch_array($result) ){
                //Asignacion de valores dentro del Array
                $response[] = array("value"=>$row['persona_id'],
                                    "label"=>$row['nombrecompleto'],
                                    "clave"=>$row['persona_cve']
                                );
            //Agreagar el campo de nacionalidad en la vista de personas 
            }
        //Regresa el array en formato Json para la manupulacion de la funcion ajax    
        echo json_encode($response);
    }
    $campos->cierra_conexion("0");
?>
