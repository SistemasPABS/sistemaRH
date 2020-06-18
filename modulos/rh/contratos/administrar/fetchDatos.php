<?php
//Cookie para validar que el usuario tenga permisos
require '../../../../config/cookie.php';
?>
<?php
//Opcion del campo que se esta buscando
session_start();
$usid=$_SESSION['us_id'];
$op=base64_decode($_POST['op']);
//Valor del campo a buscar 
$search=$_POST['search'];
    include ('../../../../config/conectasql.php');
    $campos = new conectasql();
    $campos->abre_conexion("0");
    //Consulta y llenado de array para la funcion de autocompletar.
    if($op == 'per'){
        $sql="select * from vw_personas where nombrecompleto like '%$search%' and persona_status = 1";
        $result = pg_query($campos->conexion,$sql) or die("Error cds: ". pg_last_error());//creador de selects
            while($row = pg_fetch_array($result) ){
                //Asignacion de valores dentro del Array
                $response[] = array("value"=>$row['persona_id'],
                                    "label"=>$row['nombrecompleto'],
                                    "dir"=>$row['direccion'],
                                    "genero"=>$row['persona_genero'],
                                    "rfc"=>$row['persona_rfc'],
                                    "curp"=>$row['persona_curp'],
                                    "nss"=>$row['persona_nss'],
                                    "nac"=>$row['nacionalidad_nombre']                                    
                                );
            //Agreagar el campo de nacionalidad en la vista de personas 
            }
        //Regresa el array en formato Json para la manupulacion de la funcion ajax    
        echo json_encode($response);
    }else if($op=='cont'){
        $sql="select * from vw_tipos_contratos where tipoc_nombre like '%$search%'";
        $result = pg_query($campos->conexion,$sql) or die("Error cds: ". pg_last_error());//creador de selects
            while($row = pg_fetch_array($result) ){
                //Asignacion de valores dentro del Array
                $response[] = array("value"=>$row['tipoc_id'],
                                    "label"=>$row['tipoc_nombre'],                                 
                                );
            //Agreagar el campo de nacionalidad en la vista de personas 
            }
        //Regresa el array en formato Json para la manupulacion de la funcion ajax    
        echo json_encode($response);
    }else if($op=='pues'){
        //se consultan las sucursales a las que el usuario tiene permiso de ver
        $campos->user_plazas_sucursales($usid);
        //se realiza consulta de puestos
        $sql="select * from vw_puestos where puesto_nombre like '%$search%' and plaza_id in($campos->pplazas);";
        $result = pg_query($campos->conexion,$sql) or die("Error cds: ". pg_last_error());//creador de selects
            while($row = pg_fetch_array($result) ){
                //Asignacion de valores dentro del Array
                $response[] = array("value"=>$row['puesto_id'],
                                    "label"=>$row['puesto_nombre'],
                                    "plaza"=>$row['plaza_nombre']                                 
                                );
            }
        //Regresa el array en formato Json para la manupulacion de la funcion ajax    
        echo json_encode($response);
    }else if($op=='raz'){
        $sql="select * from vw_razones where raz_nombre like '%$search%'";
        $result = pg_query($campos->conexion,$sql) or die("Error cds: ". pg_last_error());//creador de selects
            while($row = pg_fetch_array($result) ){
                //Asignacion de valores dentro del Array
                $response[] = array("value"=>$row['raz_id'],
                                    "label"=>$row['raz_nombre'],                                 
                                );
            }
        //Regresa el array en formato Json para la manupulacion de la funcion ajax    
        echo json_encode($response);
    }else if($op=='sal'){
        $sql="select * from vw_salarios where sal_nombre like '%$search%'";
        $result = pg_query($campos->conexion,$sql) or die("Error cds: ". pg_last_error());//creador de selects
            while($row = pg_fetch_array($result) ){
                //Asignacion de valores dentro del Array
                $response[] = array("value"=>$row['sal_id'],
                                    "label"=>$row['sal_nombre'],
                                    "pago"=>$row['sal_tipo']                                 
                                );
            }
        //Regresa el array en formato Json para la manupulacion de la funcion ajax    
        echo json_encode($response);
    }
    $campos->cierra_conexion("0");
?>
