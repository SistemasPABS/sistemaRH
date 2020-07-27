<?php
include ('../../../../../conexiones/config2.php');
$login=$_GET['var'];
if($login != NULL){
$where="where us_login = '$login' or us_nombrecompleto like '%$login%' ";
}
    $conexion="host=$servidor port=$port dbname=$database user=$usuariodb password=$pasdb";
    $conectando= pg_connect($conexion) or die ("Error de conexion ".pg_last_error());
    $query = "select nombrecompleto from vw_empleados $where";
    $result = pg_query($conectando,$query);
    while ($row = pg_fetch_assoc($result)) {
                    $nombres[]=$row['nombrecompleto'];
    }
    pg_free_result($result);
    pg_close($conectando);

    // check the parameter
    if(isset($_GET['part']) and $_GET['part'] != '')
    {
            // initialize the results array
            $results = array();

            // search colors
            foreach($nombres as $nombre)
            {
                    // if it starts with 'part' add to results
                    if( strpos($nombre, $_GET['part']) !== FALSE){
                            $results[] = $nombre;
                    }
            }

            // return the array as json with PHP 5.2
            echo json_encode($results);
    }
    
  
?>