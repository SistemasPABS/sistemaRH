<?php 
include ('../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$query = "SELECT * from vw_nomina_tiposalario_usuarios";
$result = pg_query($conexion,$query) or die('Error en la consulta sql');
$mostrar = pg_fetch_array($result);
do{
$renglonesloquesea .='
  <tr>  
  <td> '.$mostrar['sal_tipo_nombre'].'
  <td> '.$mostrar['fecha_inicio'].'</td>
  <td> '.$mostrar['fecha_fin'].'</td>
  <td> '.$mostrar['fechageneracion'].'</td>
  <td> '.$mostrar['us_login'].'</td>
  <td> '.$mostrar['nom_autorizada'].'</td>
  <td> '.$mostrar['nom_total'].'</td>
  <td><a href="./editarnomina.php?idnom='.$mostrar['nom_id'].'"><input type="button" value="Editar Nomina"></input>
  <td><a onclick="autorizar('.$mostrar['nom_id'].')">Autorizar</a></td>
  
</tr> ';
}while($mostrar=pg_fetch_array($result))
?>
<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="../gridprenominas/editarnomina.js"></script>
    </head>
    
    <style>
        body {
        font-family: "Microsoft JhengHei", "Open Sans", sans-serif;
        line-height: 1.25;
        }

@media screen and (max-width: 600px) {
    .table-wrap table thead {
        border: none;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
    }
    .table-wrap table tr {
        border-bottom: 3px solid #ddd;
        display: block;
        margin-bottom: .625em;
    }
    .table-wrap table td {
        border-bottom: 1px solid #ddd;
        display: block;
        font-size: .8em;
        text-align: right;
    }
    .table-wrap table td::before {
        /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
        margin-right: 5px;
    }
    .table-wrap table td:last-child {
        border-bottom: 0;
    }
}
        
    </style>
    
  
    
    <body>
        
        <div class="container">
            <div class="row">
        <div class="col-xs-12 col-md-12">
           
            <div class="table-wrap">
                <table id="sponsorTable" class="table table-condensed table-striped table-hover">
                    <thead>
                        <tr class="warning">
                            
                            <th width="20%" class="text-center" scope="col">Tipo de periodo</th>
                            <th width="20%" class="text-center" scope="col">Fecha Inicio</th>
                            <th width="20%" class="text-center" scope="col">Fecha Fin</th>
                            <th width="35%" class="text-center" scope="col">Fecha de creacion de nomina</th>
                            <th width="35%" class="text-center" scope="col">Quien realizo nomina</th>
                            <th width="35%" class="text-center" scope="col">Autorizada</th>
                            <th width="35%" class="text-center" scope="col">Total de la nomina</th>
                            <th width="35%" class="text-center" >Editar</th>
                            <th width="35%" class="text-center" >Autorizar</th>
                            
                            <?php echo $renglonesloquesea;?>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-center">
                                <!---<img src="../../../images/logo.png"></img>--->
                            </td>  
                        
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
</body>   
</html>


