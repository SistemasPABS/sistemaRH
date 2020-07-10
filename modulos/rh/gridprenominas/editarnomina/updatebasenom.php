<?php 
//include_once ('../prenominas/index.php');
include_once ('../../../../config/conectasql.php');
session_start();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
$us_id=$_SESSION['us_id'];
$idnom=base64_decode($_GET['oc0']);//idnom
$plaza=base64_decode($_GET['oc1']);//plaza
$empid=base64_decode($_GET['oc2']); //empid
$tipoperiodo=base64_decode($_GET['oc3']);//tipoperiodo
$fechaperiodoinicio=base64_decode($_GET['oc4']); //fechaperiodoinicio
$fechaperiodofin=base64_decode($_GET['oc5']); //fechaperiodofin
$numservicios=base64_decode($_GET['oc6']);//numservicios
$ventasdirectas=base64_decode($_GET['oc7']);//ventasdirectas
$cobrosporventa=base64_decode($_GET['oc8']);//cobrosporventa
$saldo=base64_decode($_GET['oc9']);//saldo
$cobrosanteriores=base64_decode($_GET['oc10']);//cobrosanteriores
$observaciones=base64_decode($_GET['oc11']);//observaciones
$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);//computadora de donde se hace
/*echo $oc1,$oc2,$oc3,$oc4,$oc5,$oc6,$oc7,$oc8,$oc9,$oc10;*/
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;

$sql2="UPDATE base_nom SET nom_id=$idnom,us_id=$us_id,fecha='$fecha',hora='$hora',plaza_id=$plaza,num_ventas=$numservicios,venta_directa=$ventasdirectas,cobros=$cobrosporventa,saldo=$saldo,cobros_per_ant=$cobrosanteriores,observaciones='$observaciones',emp_id=$empid,sal_tipo_id=$tipoperiodo,fecha_inicio='$fechaperiodoinicio',fecha_fin='$fechaperiodofin',pc='$pc' WHERE nom_id = $idnom;";
$result2 = pg_query($conexion,$sql2) or die("Error en la insercion de datos temporales de base nom");

$sql3="select * from vw_sueldos_nomina where nom_id = $idnom";
$result3= pg_query($conexion,$sql3);
if($row3= pg_fetch_array($result3)){
    do{
        $monos.= '
        <tbody>
                <tr>
                    <td>
                        <input hidden value="'.$row3['persona_id'].'" name="persona[]"></input>
                        <label>'.$row3['nombrecompleto'].'</label>
                        <div>
                            <button type="button" class="botonesadd" onclick="traerpercepcionesdeducciones(\'percepcion\',this)">Agregar percepcion</button>
                            <button type="button"  class="botonesadd" onclick="traerpercepcionesdeducciones(\'deduccion\',this)">Agregar deduccion</button>
                        </div>
                    </td>
                    
                </tr>
                <tr class="tabla">
                    <td rowspan="9999"></td> 
                    <td>SUELDO DE LA PERSONA</td>
                    <td><input  class="sueldo" value="'.$row3['persona_id'].'"  name="'.$row3['persona_id'].'sueldo[]" hidden></input></td>
                    <td></td>
                    <td><input type="number" name="'.$row3['persona_id'].'cantidadsueldo[]" value="'.$row3['sal_monto_con'].'" readonly></input></td>
                    <td><input type="text" name="'.$row3['persona_id'].'observacionessueldo[]"></input></td>
                </tr>
            </tbody>
                
                
        ';
        //$monos.= $row3['persona_id'].'--'.$row3['nombrecompleto'].'<br>';
        
        $sql4="select * from vw_comnom where persona_id = ".$row3['persona_id']." and nom_id = $idnom";
        $result4= pg_query($conexion,$sql4);
        if($row4= pg_fetch_array($result4)){
            do{
            $monos .='
                      <tr>
                        <td rowspan="9999"></td>
                            <td><input value="'.$row4['co_id'].'" name="'.$row3['persona_id'].'comision[]" hidden>'.$row4['co_nombre'].'</td>
                            <td>'.$row4['co_monto'].'</td>
                            <td>'.$row4['co_porcentaje'].'</td>
                            <td><input type="number" name="'.$row3['persona_id'].'cantidadcom[]"></input></td>
                            <td><input type="text" name="'.$row3['persona_id'].'observacionescom[]"></input></td>
                      </tr>
                    </tbody>';
                //$monos.='*'.$row4['co_id'].'--'.$row4['co_nombre'].'<br>';
                
            }while ($row4 = pg_fetch_array($result4));
         //$monos.='</tbody>';  
        }
        
        
    }while($row3= pg_fetch_array($result3));

    $sql5="select * from vw_percepciones where persona_id = ".$row3['persona_id']." and nom_id = $idnom";
    $result5= pg_query($conexion,$sql5);
    if($row5= pg_fetch_array($result5)){
            do{
            $monos .='
                      <tr>
                        <td rowspan="9999"></td>
                            <td><input value="'.$row5['tp_monto'].'" name="'.$perid.'cantidad'.'per'.'[]" hidden>'.$row4['tp_nombre'].'</td>
                            <td></td>
                            <td></td>
                            <td><input value="'.$row5['tp_monto'].'" type="number" name="'.$row3['persona_id'].'cantidadper[]"></input></td>
                            <td><input value="'.$row5['tmp_observaciones'].'" type="text" name="'.$row3['persona_id'].'observacionesper[]"></input></td>
                      </tr>
                    </tbody>';
                //$monos.='*'.$row4['co_id'].'--'.$row4['co_nombre'].'<br>';
                
            }while ($row4 = pg_fetch_array($result4));
         //$monos.='</tbody>';  
    }while($row3= pg_fetch_array($result3));

}else{
    echo 'No hubo personas que cumplan con los criterios capturados';
}
?>

<html>
    <head>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
        <script src="./updatevalidador.js"></script>

        <script type="text/javascript">
             $(document).ready(function () {
                $(".tbtn").click(function () {
                    $(this).parents(".custom-table").find(".toggler1").removeClass("toggler1");
                    $(this).parents("tbody").find(".toggler").addClass("toggler1");
                    $(this).parents(".custom-table").find(".fa-minus-circle").removeClass("fa-minus-circle");
                    $(this).parents("tbody").find(".fa-plus-circle").addClass("fa-minus-circle");
                });
            });
        </script>
    </head>
    
    <form name="todalanomina" method="POST" action="crearnomina.php">
    <body>
        <div>
            <img src="../../../../images/logo.png" class="logo">
        </div>
        <div id="contenedor" class="container"></div>
        <input hidden id="cantpersonas" name="cantpersonas" value=""></input>
        <table class="custom-table">
            <thead>
                <tr class="encabezados">
                    <input hidden value="<?php echo $pc?>" name="pc"></input>
                    <input hidden value="<?php echo $fechaperiodo?>" name="idperiodo"></input>
                    <input hidden value="<?php echo $plaza?>" name="plaza"></input>
                    <input hidden value="<?php echo $tipoperiodo?>" name="tipoperiodo"></input>
                    <input hidden value="<?php echo $empid?>" name="empid"></input>
                    <th>Persona</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Porcentaje</th>
                    <th>Cantidad</th> 
                    <th>Observaciones</th>
                </tr>
            </thead>
            <?php echo $monos ?>
        </table>
        
        <button id="submit" type="submit" onclick="enviarnomina()">GUARDAR NOMINA</button>
    </form>    

<div>


</div>




</body>
</html>


<style>
  .logo{
    margin-left:300px;
    margin-top: 20px;
    margin-bottom: 20px;
  }
  .custom-table{border-collapse:collapse;width:100%;border:solid 1px #c0c0c0;font-family:open sans;font-size:11px}
            .custom-table th,.custom-table td{text-align:left;padding:8px;border:solid 1px #c0c0c0}
            .custom-table th{color:#000080}
            .custom-table tr:nth-child(odd){background-color:#f7f7ff}
            .custom-table>thead>tr{background-color:#dde8f7!important}
            .tbtn{border:0;outline:0;background-color:transparent;font-size:13px;cursor:pointer}
            .toggler{display:none}
            .toggler1{display:table-row;}
            .custom-table a{color: #0033cc;}
            .custom-table a:hover{color: #f00;}
            .page-header{background-color: #eee;}
</style>



    
    
    
    