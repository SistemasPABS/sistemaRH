<?php 
include ('../../../../config/cookie.php');
include ('../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
session_start();
$usid=$_SESSION['us_id'];
$nom_id=base64_decode($_GET['oc1']);
$query="SELECT * FROM vw_basenomina_nomina WHERE nom_id = $nom_id";
$result = pg_query($conexion,$query) or die("Error en la consulta SQL");
$mostrar = pg_fetch_array($result);
$resumen.= '
<label>  Plaza:  </label>
<label> '.$mostrar['plaza_nombre'].' </label>

<label>  Plaza:  </label>
<label> '.$mostrar['plaza_nombre'].' </label>



';
?>

<html>
    <head>
    
    </head>

    <body>
      <?php 
        echo $resumen;
      ?>
    </body>

</html>


        
                


