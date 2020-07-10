<?php 
include ('../../../../config/cookie.php');
include ('../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
session_start();
$usid=$_SESSION['us_id'];
$oc1=$_GET["idnom"];
$query="SELECT * FROM vw_nomina_basenom WHERE nom_id = $oc1";
$result = pg_query($conexion,$query) or die("Error en la consulta SQL");
$mostrar = pg_fetch_array($result);
$resumen.= '
<label>  Plaza:  </label>
<label> '.$mostrar['plaza_nombre'].' </label>
<label>  Empresa:  </label>
<label> '.$mostrar['emp_nombre'].' </label>
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


        
                


