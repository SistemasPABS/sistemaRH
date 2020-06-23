<?php 
include ('../../../../config/cookie.php');
include ('../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
session_start();
$usid=$_SESSION['us_id'];
$query="SELECT * FROM vw_users_plazas_sucursales";
$result = pg_query($conexion,$query) or die("Error en la consulta SQL");
?>
<!--- Sección HTML !-->
<!DOCTYPE HTML>
<html>
    <head>
	<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    </head>

    <body>
    <?php    
      include_once('../principal/componentes/select.php');
    ?>

		
	<!--<div id="contenedor">
		<select id="plazas">
		<option value="">- Seleccione -</option>
		<?php while($mostrar=pg_fetch_array($result))
			{
				echo '<option value="' .$mostrar["plaza_id"]. '">' .$mostrar["plaza_nombre"]. '</option>';
			}
		?>
		</select>
		<select id="discos" disabled="">
      	<option value="">- Seleccione -</option>
    	</select>
	</div>

	 Agregamos la libreria Jquery 
	 <script type="text/javascript" src="jquery-3.2.0.min.js"></script>
    
     Iniciamos el segmento de codigo javascript 
    <script type="text/javascript">
      $(document).ready(function(){
        var sucursales = $('#sucursales');
        var sucursal_sel = $('#sucursal_sel');
        
        //Ejecutar accion al cambiar de opcion en el select de las bandas
        $('#plazas').change(function(){
          var plaza_id = $(this).val(); //obtener el id seleccionado
          
          if(plaza_id !== ''){ //verificar haber seleccionado una opcion valida
            
            /*Inicio de llamada ajax*/
            $.ajax({
              data: {plaza_id:plaza_id}, //variables o parametros a enviar, formato => nombre_de_variable:contenido
              dataType: 'html', //tipo de datos que esperamos de regreso
              type: 'POST', //mandar variables como post o get
              url: 'ajaxData.php' //url que recibe las variables
            }).done(function(data){ //metodo que se ejecuta cuando ajax ha completado su ejecucion             
              
              sucursales.html(data); //establecemos el contenido html de discos con la informacion que regresa ajax             
              sucursales.prop('disabled', false); //habilitar el select
            });
            /*fin de llamada ajax*/
            
          }else{ //en caso de seleccionar una opcion no valida
            sucursales.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
            sucursales.prop('disabled', true); //deshabilitar el select
          }    
        });
        
        
        //mostrar una leyenda con el disco seleccionado
        $('#sucursales').change(function(){
          $('#sucursales').html($(this).val() + ' - ' + $('#sucursales option:selected').text());
        });
        
      });
    </script> -->
	

</body>
</html>
