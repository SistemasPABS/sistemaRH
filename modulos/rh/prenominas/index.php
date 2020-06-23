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
<?php 
if(@$_POST['saveImage']){
  $query="INSERT into tmp_base_nom (us_id,fecha,hora,plaza_id,num_ventas,venta_directa,cobros,saldo,cobros_per_ant,observaciones)
    VALUES (2,'2020/06/23','15:30:00',3,'$_POST[numservicios]','$_POST[numventas]','$_POST[cobros]','$_POST[saldo]','$_POST[cobranzaperanterior]','$_POST[observaciones]')";
}  
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="../prenominas/styles/navbar.css" rel="stylesheet" type="text/css">
        <script src="../prenominas/styles/navbar2.js"></script>
        <script src="../prenominas/styles/jquery.js"></script>  
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">   
    </head>


    <body>
    <div>
    <!-- Second navbar for categories -->
    <nav>
      <div>
        <div>
          <button data-toggle="modal" data-target="#squarespaceModal">Nueva nómina</button>
          <button data-toggle="modal" data-target="#prenomina">Prenómina</button>
          <button data-toggle="modal" data-target="#sobrerecibo">Sobrerecibo</button>
          <button data-toggle="modal" data-target="#comparador">Comparador CONTPAQi® vs Sistema RH</button>
          <button data-toggle="modal" data-target="#reporteador">Reporteador</button>
          <button data-toggle="modal" data-target="#historico">Histórico</button>
          <button data-toggle="modal" data-target="#importador">Importador</button>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>


<!-- line modal -->
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>
			<h3 class="modal-title" id="lineModalLabel">Carga base de incidencias para cálculo de prenómina</h3>
		</div>
		<div class="modal-body">	
            <!-- content goes here -->
			<form action="index.php" method="post">
              <div class="form-group">
                <label for="exampleInputEmail1">Selecciona una plaza</label>
                  <select>
                    <!---<option value="1">GUADALAJARA</option>
                    <option value="2">CHIHUAHA</option>-->
                    <option value="3">AGUASCALIENTES</option>
                  </select>

                  <select>
                    <option value="17">PABS ADM</option>
                    <option value="13">PABS</option>
                    <option value="3">FABRICA DE ATAUDES</option>
                    <option value="3">RECINTO</option>
                  </select>
                  <label>Selecciona un tipo de periodo</label>
                  <select>
                  <option value="1">SEMANAL</option>
                  <option value="4">EXTRAORDINARIO O DE AJUSTE</option>
                </select>
              </div>

              <div class="w3-row-padding">
                <div class="w3-half">
                  <label>Fecha Inicio</label>
                  <input class="w3-input w3-border" type="date" placeholder="Fecha de inicio de nomina" height="20%">
                </div>
                <div class="w3-half">
                  <label>Fecha Fin</label>
                  <input class="w3-input w3-border" type="date" placeholder="Fecha de fin de nomina">
                </div>
              </div>

              <div class="form-group">
               
              </div>

              <div class="w3-row-padding">
                <div class="w3-half">
                  <label>Numero de servicios</label>
                  <input class="w3-input w3-border" name="numservicios" type="number" placeholder="Numero de servicios" width="20%">
                </div>
                <div class="w3-half">
                  <label>Ventas directas</label>
                  <input class="w3-input w3-border" name="numventas" type="number" placeholder="Ventas directas">
                </div>
                <div class="w3-half">
                  <label>Cobros por ventas</label>
                  <input class="w3-input w3-border" type="number" name="cobros" placeholder="Cobros por ventas">
                </div>
                <div class="w3-half">
                  <label>Saldo</label>
                  <input class="w3-input w3-border" type="number" placeholder="Saldo" name="saldo">
                </div>
                <div class="w3-half">
                  <label>Cobranza periodos anteriores</label>
                  <input class="w3-input w3-border" type="number" placeholder="Cobranza del periodo anterior" name="cobranzaperanterior">
                </div>
              </div>
      </form>
    </div>

		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar Nómina</button>
				</div>
				<div class="btn-group" role="group">
					<button type="button" name="saveImage" class="btn btn-default btn-hover-green" data-action="save" role="button">Comenzar Nomina</button>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>


    <?php 
      include_once('../gridprenomina/index.php');
    ?>



</body>
</html>


