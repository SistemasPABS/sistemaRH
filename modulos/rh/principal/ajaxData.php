<?php
include ('../../../../config/cookie.php');
include ('../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$plazas = base64_decode($_POST["plaza_id"]);
$plaza_id = filter_input(INPUT_POST, 'plaza_id'); //obtenemos el parametro que viene de ajax
if($plaza_id != ''){ //verificamos nuevamente que sea una opcion valida
	$con = conDb();
	if(!$con){
	  die("<br/>Sin conexi&oacute;n.");
	}
	
	/*Obtenemos los discos de la banda seleccionada*/
	$sql = "SELECT suc_id, suc_nombre from vw_users_plazas_sucursales where plaza_id = "".$plaza_id";  
	$result = pg_query($conexion,$query) or die("Error en la consulta SQL");
  }

?>
<html>
<head>
</head>
<body>
<option value="">- Seleccione -</option>
<?php 
	while($mostrar=pg_fetch_array($result))
			{
				echo '<option value="' .$mostrar["suc_id"]. '">' .$mostrar["suc_nombre"]. '</option>';
			}
	?>
</body>
</html>

