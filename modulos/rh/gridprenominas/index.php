<?php 
include_once ('../prenominas/index.php');
$em=base64_decode($_GET['em']);
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$query = "SELECT * from vw_prenominas";
$result = pg_query($conexion,$query) or die("Error en la consulta SQL");
do{
$renglonesloquesea .='
  <tr>  
  <td> '.$mostrar['nombrecompleto'].'</td>
  <td> '.$mostrar['nom_t_percepciones'].'</td>
  <td> '.$mostrar['nom_t_deducciones'].'</td>
  <td> '.$mostrar['nom_t_sueldo'].'</td> 
  <td><button>Abrir Sobrerecibo</button></td> 
</tr> ';
}while($mostrar=pg_fetch_array($result))
?>

<!DOCTYPE html>
<html>
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
        <body>
            <div>
                <button class="button disabled">Autorizar Nómina</button>
                <button class="button">Editar Nómina</button>
                <button class="button">Exportar a Excel</button>
            </div> 

            <div id="sailorTableArea">
                <table>
                        <tr id="titletable">
                            <td>Nombre Completo</td>
                            <td>Percepciones</td>
                            <td>Deducciones</td>
                            <td>Sueldo</td>
                            <td>Sobrerecibo</td>
                        </tr>
                <?php echo $renglonesloquesea; ?>
                </table> 
              </div>  
            
        </body>  
    </html>
</table>




