<?php 
include ('../../../config/cookie.php');
include ('../../../config/conectasql.php');
session_start();
$usid=$_SESSION['us_id'];
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$em=base64_decode($_GET['em']);
$filtroinicio= base64_decode($_GET['fechacreacioninicio']);
$filtrofin= base64_decode($_GET['fechacreacionfin']);
//echo $em.'-'.$filtroinicio.'--'.$filtrofin;
//SE VAN A CONSULTAR SI EL USUARIO TIENE LOS PERMISOS PARA EDITAR Y/O AUTORIZAR LA NOMINA
$con->permisos('papp',$em,$usid);
if(in_array(59,$con->p3)){
    $permisobotoneditar = 1;
}
if(in_array(60,$con->p3)){
    $permisobotonautorizar = 1;
}

if($filtroinicio != NULL && $filtrofin != NULL){
    //QUERY CON FILTROS
    $query = "SELECT * from vw_nomina_tiposalario_usuarios  WHERE fechageneracion BETWEEN '$filtroinicio' AND '$filtrofin' limit 200";
}else{
    //QUERY SIN FILTROS
    $query = "SELECT * from vw_nomina_tiposalario_usuarios ORDER BY nom_id desc";
}
$result = pg_query($conexion,$query) or die('Error en la consulta sql'.pg_last_error());
$mostrar = pg_fetch_array($result);



do{
$renglonesloquesea .='
  <tr>  

  <td> '.$mostrar['nom_id'].'<input hidden value="'.$mostrar['nom_id'].'" name="'.$mostrar['nom_id'].'" id="'.$mostrar['nom_id'].'">
  <td> '.$mostrar['sal_tipo_nombre'].' 
  <td> '.$mostrar['fecha_inicio'].'</td>
  <td> '.$mostrar['fecha_fin'].'</td>
  <td> '.$mostrar['fechageneracion'].'</td>
  <td> '.$mostrar['us_login'].'</td>
  <td> '.$mostrar['nombreautorizador'].'</td>
  <td> '.$mostrar['nom_total'].'</td>';
  if($permisobotoneditar==1){
      $botoneditar='<a></a><input onclick="location.href=\'editarnomina.php?idnom='.$mostrar['nom_id'].'\'" type="button" value="Editar"></input>';
  }else{
    $botoneditar='';
  }
  $renglonesloquesea .='<td>'.$botoneditar.'</td>';
  
  
  if($permisobotonautorizar==1){
      $botonautorizar='<input type="button" name="autorizar" id="autorizar" value="Autorizar" onclick="autorizarnomina(this)"></input>';
  }else{
      $botonautorizar='';
  }
  $renglonesloquesea .='<td>'.$botonautorizar.'</td>';
$renglonesloquesea .='</tr>';
}while($mostrar=pg_fetch_array($result))
?>


<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="../gridprenominas/editarnomina.js"></script>
        <script src="../gridprenominas/autorizarnomina/autorizarnomina.js"></script>
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
                        <div>
                            <input hidden value="<?php echo $em?>" id="em" name="em"></input>
                            <label>Filtrar por fecha de creación de Nómina</label>
                            <input type="date" id="fechacreacioninicio" name="fechacreacioninicio"></input>
                            <input type="date" id="fechacreacionfin" name="fechacreacionfin"></input>
                            <button onclick=filtrarporfechas()>filtrar</button>
                        </div>
                        <tr class="warning">
                            <button class="btn" onclick=reload()><i class="fa fa-home"></i></button>
                            <th width="5%" class="text-center" scope="col">Folio de Nomina</th>
                            <th width="20%" class="text-center" scope="col">Tipo de periodo</th>
                            <th width="20%" class="text-center" scope="col">Fecha Inicio</th>
                            <th width="20%" class="text-center" scope="col">Fecha Fin</th>
                            <th width="35%" class="text-center" scope="col">Fecha de creacion de nomina</th>
                            <th width="35%" class="text-center" scope="col">Quien realizo nomina</th>
                            <th width="35%" class="text-center" scope="col">Autorizada por</th>
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


