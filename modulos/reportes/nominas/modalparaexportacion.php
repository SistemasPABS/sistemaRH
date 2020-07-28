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
                <label>Selecciona una nomina</label>
                <select id="idnomina">
                    <?php 
                        $query="SELECT DISTINCT nom_id FROM vw_reporte_estado_financiero";
                        $result = pg_query($conexion,$query);
                        $mostrar= pg_fetch_array($result);
                            do{
                                echo'<option name="idnomina" value="'.$mostrar['nom_id'].'">'.$mostrar['nom_id'].'</option>';  
                            }while($mostrar= pg_fetch_array($result));
                    ?> 
                </select>
            </div>
    </form>
    <div class="btn-group" role="group">
          <input type="button" name="saveImage" class="btn btn-default btn-hover-green" onclick="ejecutarreporte()" value="exportar">
	</div>
    </body>
</html>