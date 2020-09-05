<?php 
include ('../../../../config/cookie.php');
include ('../../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$em=base64_decode($_GET['em']);
session_start();
$usid=$_SESSION['us_id'];
$tipoperiodo=base64_decode($_GET['oc3']);//tipoperiodo
$query="SELECT * FROM vw_users_plazas_sucursales";
$result = pg_query($conexion,$query) or die("Error en la consulta SQL");
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
        <script src="../gridprenominas/funcionesprenomina.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <link href="jquery.multiselect.css" rel="stylesheet" type="text/css">
        <script src="jquery.min.js"></script>
        <script src="jquery.multiselect.js"></script>

    </head>


    <body>
    <div>
    <!-- Second navbar for categories -->
    <nav>
      <div>
        <div>
          <button data-toggle="modal" data-target="#squarespaceModal" class="btn" style="vertical-align:middle">Crear nómina</button>
          <button onclick="location.href='../gridprenominas/index.php?em=<?php echo base64_encode($em)?>'" class="btn" style="vertical-align:middle">Listado de nóminas</button>
          <!--<button data-toggle="modal" data-target="#sobrerecibo">Sobrerecibo</button>
          <button data-toggle="modal" data-target="#comparador">Comparador CONTPAQi® vs Sistema RH</button>
          <button data-toggle="modal" data-target="#historico">Histórico</button>
          <button data-toggle="modal" data-target="#importador">Importador</button>-->
        </div><!-- /.navbar-collapse -->
        <div class="logo">
          <img src="../../../../images/logo.png"></img>
        </div>
      </div><!-- /.container -->
    </nav>


<input hidden id="em" name="em" value="<?php echo $em?>"></input>
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>
      <h3 class="modal-title" id="lineModalLabel" >Carga base de incidencias para cálculo de prenómina</h3>
		</div>
		<div class="modal-body">	
            <!-- content goes here -->
		<form action="index.php" method="post" name="modalnomina" id="modalnomina">
              <div class="form-group">
                <div>
                  <label for="exampleInputEmail1">Selecciona una plaza</label>
                    <select id="plazas" name="plazas">
                        <?php 
                          $query="SELECT DISTINCT plaza_nombre, plaza_id FROM vw_users_plazas_sucursales WHERE us_id = $usid";
                          $result = pg_query($conexion,$query);
                          do{
                            echo'<option  value="'.$mostrar["plaza_id"].'">'.$mostrar["plaza_nombre"].'</option>';  
                          }while($mostrar= pg_fetch_array($result));
                        ?>
                    </select>
                  </div>
                  
                  <div>
                      <label>Selecciona las diferentes empresas</label>
                              <select id="empresa">
                                <?php 
                                  $query="SELECT emp_nombre, emp_id FROM empresas";
                                  $result = pg_query($conexion,$query);
                                  do{
                                    echo'<option name="empresa" value="'.$mostrar["emp_id"].'">'.$mostrar["emp_nombre"].'</option>';  
                                  }while($mostrar= pg_fetch_array($result));
                                 
                                ?>
                              </select>
                    </div>       

                    <div>
                      <label>Selecciona un tipo de periodo</label>
                        <select id="tipoperiodo" onchange="cargarperiodos()">
                            <?php 
                              $query="SELECT * FROM tipos_salarios";
                              $result = pg_query($conexion,$query);
                              do{
                                echo'<option name="tipoperiodo" value="'.$mostrar["sal_tipo_id"].'">'.$mostrar["sal_tipo_nombre"].'</option>';  
                              }while($mostrar= pg_fetch_array($result));
          
                            ?>
                        </select>
                    </div>           
              </div>
                    

              <div class="w3-row-padding">
                <div id="fechas" class="w3-half">
                      
                </div>
              </div>

              <!---<div class="form-group">
                <div id="informacionadicional" class="w3-half">
                
                </div>--->


                <!---<div class="w3-row-padding">
                
                  <div class="w3-half">
                    <label>Saldo Plan</label>
                    <input id="saldoplan" class="w3-input w3-border" name="saldoplan" type="number" placeholder="Saldo del plan" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
                  </div>

                  <div class="w3-half">
                    <label>Adicionales</label>
                    <input id="adicionales" class="w3-input w3-border" name="adicionales" type="number" placeholder="Adicionales" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
                  </div>

                  <div class="w3-half">
                    <label>Servicios Directos</label>
                    <input id="serviciosdirectos" class="w3-input w3-border" name="serviciosdirectos" type="number" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)" step="0.01">
                  </div>

                  <div class="w3-half">
                    <label>Abono</label>
                    <input id="abono" class="w3-input w3-border" type="number" placeholder="Abono"  name="abono" required onkeyup="this.value=Numeros(this.value)" step="0.01">
                  </div>
                  
                  
                  <div class="form-group">
                      <div class="w3-half">
                        <label>Ingresos</label>
                        <input id="ingresos" class="w3-input w3-border" name="ingresos" type="number">
                      </div>

                      <div class="w3-half">
                        <label>Cobranza periodos anteriores</label>
                        <input id="cobrosanteriores" class="w3-input w3-border" type="number" name="cobranzaperanterior" required>
                      </div>

                      <div class="w3-half">
                        <label>Recibo total</label>
                        <input id="recibototal" class="w3-input w3-border" type="number" name="recibototal" required>
                      </div>
                  </div>
                  <div class="w3-half">
                    <label>Observaciones</label>
                    <input type="text" class="form-control" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
                  </div>
                  </div>
                </div> 


              </div> --->

          
              <div>
                <label>Importar archivo XP - Examinar</label>
                <input id="importador" type="checkbox" name="importador" onChange="comprobar(this);">
                <input type="file" id="archivoimportador" name="archivoimportador" id="archivoimportador" readonly style="display:none"></input>
              </div>

          </form>

            <div class="modal-footer">
			      <div class="btn-group btn-group-justified" role="group" aria-label="group button">
				    <div class="btn-group" role="group">
              <button type="button" class="btn btn-default" data-dismiss="modal" role="button">Cancelar Nómina</button>
				    </div>


           

				    <div class="btn-group" role="group">
              <input type="button" name="saveImage" class="btn btn-default btn-hover-green" onclick="comenzarnomina()" value="comenzar">
				    </div>

			        </div>
		        </div>
          </div>
	      </div>
      </div>
    </div>
  </body>
</html>

<style>
  .logo{
    margin-left:300px;
    margin-top: 250px;
  }
  .btn{
    border-radius:12px;
    transition-duration: 0.4s;
    display: inline-block;
    text-align: center;
    padding:5px;
    width:190px;
    transition:all 0.5s;
    cursor:pointer;
    margin:5px;
  }
  .btn:hover{
    background-color: grey;
    color: white;
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
  }
  
 
</style>

