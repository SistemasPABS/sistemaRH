<?php 
include ('../../../config/cookie.php');
include ('../../../config/conectasql.php');
session_start();
$usid=$_SESSION['us_id'];
$em=base64_decode($_GET['em']);//estructura menu
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
?>
 
<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="lanzaderareportes.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    </head>

    <body>
    <form> 
        <div>
            <img src="../../../images/logo.png"></img>
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

            <div class="w3-row-padding">
                <label>Selecciona un rango de fechas</label>
                <div id="fechas" class="w3-half">
                
                </div>
            </div>

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

            <!---<div>
                <label>Selecciona una empresa</label>
                <select id="empresa">
                    <?php 
                        $query="SELECT emp_nombre, emp_id FROM empresas";
                        $result = pg_query($conexion,$query);
                        do{
                            echo'<option name="empresa" value="'.$mostrar["emp_id"].'">'.$mostrar["emp_nombre"].'</option>';  
                        }while($mostrar= pg_fetch_array($result));
                    ?>
                </select>
            </div>--->
    </form>
    <div class="btn-group" role="group">
          <input type="button" name="saveImage" class="btn btn-default btn-hover-green" onclick="ejecutarreporte()" value="exportar">
	</div>
    </body>
</html>