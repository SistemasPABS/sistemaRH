<?php 
include ('../../../config/conectasql.php');
include_once ('../prenominas/index.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$query = "SELECT * FROM nomina";
$result = pg_query($conexion,$query);
$prenomina = array();
$i = 0;
while($row = pg_fetch_array($result)){
     $prenomina[$i] = array();
     $prenomina[$i]['nom_id'] = $row['nom_id'];
     $prenomina[$i]['persona_id'] = $row['persona_id'];
     $prenomina[$i]['nom_fecha'] = $row['nom_fecha'];
     $prenomina[$i]['nom_hora'] = $row['nom_hora'];
     $prenomina[$i]['nom_periodo'] = $row['nom_periodo'];
     $prenomina[$i]['nom_t_sueldo'] = $row['nom_t_sueldo'];
     $prenomina[$i]['nom_t_percepciones'] = $row['nom_t_percepciones'];
     $prenomina[$i]['nom_t_deducciones'] = $row['nom_t_deducciones'];
     $prenomina[$i]['nom_t_incidencias'] = $row['nom_t_incidencias'];
     $i++ ;
}
$con->cierra_conexion("0");
echo json_encode($prenomina);
?>

<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>

    </body>
</html>
