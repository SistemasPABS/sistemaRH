<?php 
include ('../../../config/conectasql.php');
include_once ('../prenominas/index.php');
$em=base64_decode($_GET['em']);
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$query = "SELECT * from vw_nomina_periodo_saltipo";
$result = pg_query($conexion,$query);
while($mostrar=pg_fetch_array($result)){
?>
<!DOCTYPE html>
<html>
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
        <body>
            <div>
                <button class="button">Nueva Nómina</button>
                <button class="button disabled">Autorizar Nómina</button>
                <button class="button">Editar Nómina</button>
                <button class="button">Exportar a Excel</button>
            </div>   

            <div id="sailorTableArea">
                <table id="sailorTable" class="table table-striped table-bordered">
                        <tr id="titletable">
                            <td>Num. de Periodo</td>
                            <td>Nom. Fecha</td>
                            <td>Percepciones</td>
                            <td>Deducciones</td>
                            <td>Incidencias</td>
                            <td>Sueldo</td>
                            <td>Periodo de Pago</td>
                            <td>Id De Persona</td>
                        </tr>
                
                        <tr>
                            <td><?php echo $mostrar['num_periodo']?></td>
                            <td><?php echo $mostrar['nom_fecha']?></td>
                            <td><?php echo $mostrar['nom_t_percepciones']?></td>
                            <td><?php echo $mostrar['nom_t_deducciones']?></td>
                            <td><?php echo $mostrar['nom_t_incidencias']?></td>
                            <td><?php echo $mostrar['nom_t_sueldo']?></td>
                            <td><?php echo $mostrar['sal_tipo_nombre']?></td>
                            <td><?php echo $mostrar['persona_id']?></td>
                        </tr> 
                </table> 
                <?php
                    }
                ?> 
            </div>  
        </body>  
    </html>
</table>

<style>
#sailorTableArea{
    overflow-x: auto;
    overflow-y: auto;
}
#sailorTable{
    white-space: normal;
}
tbody {
    display:block;
    height:200px;
    overflow:auto;
}
thead, tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;
}
#titletable{
font-size:10px;
}
.button {
  background-color: #02284F;
  border: none;
  color: white;
  padding: 2px 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 12px;

}

.disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
#myInput {
  background-image: url('/css/searchicon.png'); /* Add a search icon to input */
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}

#myTable {
  border-collapse: collapse; /* Collapse borders */
  width: 100%; /* Full-width */
  border: 1px solid #ddd; /* Add a grey border */
  font-size: 18px; /* Increase font-size */
}

#myTable th, #myTable td {
  text-align: left; /* Left-align text */
  padding: 12px; /* Add padding */
}

#myTable tr {
  /* Add a bottom border to all table rows */
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  /* Add a grey background color to the table header and on hover */
  background-color: #f1f1f1;
}
</style>




