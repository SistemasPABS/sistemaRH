<?php 
include_once ('../prenominas/index.php');
include_once ('../../../config/conectasql.php');
session_start();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
$us_id=$_SESSION['us_id'];
$plaza=base64_decode($_GET['oc1']);//plaza
$empid=base64_decode($_GET['oc2']); //empid
$tipoperiodo=base64_decode($_GET['oc3']);//tipoperiodo
$fechaperiodo=base64_decode($_GET['oc4']); //fechaperiodo
$numservicios=base64_decode($_GET['oc5']);//numservicios
$ventasdirectas=base64_decode($_GET['oc6']);//ventasdirectas
$cobrosporventa=base64_decode($_GET['oc7']);//cobrosporventa
$saldo=base64_decode($_GET['oc8']);//saldo
$cobrosanteriores=base64_decode($_GET['oc9']);//cobrosanteriores
$observaciones=base64_decode($_GET['oc10']);//observaciones
$em=base64_decode($_GET['oc11']);//estructura menu
$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);//computadora de donde se hace
/*echo $oc1,$oc2,$oc3,$oc4,$oc5,$oc6,$oc7,$oc8,$oc9,$oc10;*/
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;

$sql1="SELECT * FROM periodos WHERE idperiodo=$fechaperiodo";
$result1 = pg_query($conexion,$sql1) or die("Error al obtener los periodos");
$row1 = pg_fetch_array($result1);

$sql2="INSERT into tmp_base_nom (us_id,fecha,hora,plaza_id,num_ventas,venta_directa,cobros,saldo,cobros_per_ant,observaciones,emp_id,sal_tipo_id,fecha_inicio,fecha_fin,pc) values ($us_id,'$fecha','$hora',$plaza,$numservicios,$ventasdirectas,$cobrosporventa,$saldo,$cobrosanteriores,'$observaciones',$empid,$tipoperiodo,'".$row1['fecha_inicio']."','".$row1['fecha_final']."','$pc')";
$result2 = pg_query($conexion,$sql2) or die("Error en la insercion de datos temporales de base nom");

$sql3="select * from vw_contratos where con_status = 1 and sal_tipo_id = $tipoperiodo and emp_id  = $empid and plaza_id = $plaza";
$result3= pg_query($conexion,$sql3);
if($row3= pg_fetch_array($result3)){
    do{
        $monos.= '
        <tbody>
                <tr>
                    <td colspan="20" class="page-header">
                        <input hidden value="'.$row3['persona_id'].'" name="persona[]"></input>
                        <button type="button" class="tbtn"><i class="fa fa-plus-circle fa-minus-circle"></i>'.$row3['nombrecompleto'].'</button>
                        <button type="button"  onclick="traerpercepcionesdeducciones(\'percepcion\',this)">Agregar percepcion</button>   
                        <button type="button"  onclick="traerpercepcionesdeducciones(\'deduccion\',this)">Agregar deduccion</button>
                    </td>
                    
                </tr>
                <tr class="toggler toggler1">
                    <td rowspan="9999"></td>
                        <td>SUELDO DE LA PERSONA</td>
                        <td></td>
                        <td></td>
                        <td><input type=number  name="'.$row3['persona_id'].'cantidadsueldo[]" value="'.$row3['sal_monto_con'].'" readonly></input></td>
                        <td><input type="text" name="'.$row3['persona_id'].'observacionessueldo[]" value="---" onkeyup="this.value=NumText(this.value)"></input></td>
                  </tr>
                </tbody>
        ';
        //$monos.= $row3['persona_id'].'--'.$row3['nombrecompleto'].'<br>';
        
        $sql4="select * from vw_puestos_comisiones where persona_id = ".$row3['persona_id']." and co_activo = 1;";
        $result4= pg_query($conexion,$sql4);
        if($row4= pg_fetch_array($result4)){
            do{
            $monos .='
                      <tr class="toggler toggler1">
                        <td rowspan="9999"></td>
                            <td><input value="'.$row4['co_id'].'" name="'.$row3['persona_id'].'comision[]" hidden>'.$row4['co_nombre'].'</td>
                            <td>'.$row4['co_monto'].'</td>
                            <td>'.$row4['co_porcentaje'].'</td>
                            <td><input type="number" onkeyup="this.value=Numeros(this.value)" step="0.01" name="'.$row3['persona_id'].'cantidadcom[]" value="0" ></input></td>
                            <td><input type="text" name="'.$row3['persona_id'].'observacionescom[]" value="---" onkeyup="this.value=NumText(this.value)"></input></td>
                      </tr>
                    </tbody>';
                //$monos.='*'.$row4['co_id'].'--'.$row4['co_nombre'].'<br>';
                
            }while ($row4 = pg_fetch_array($result4));
         //$monos.='</tbody>';  
        }
        
    }while($row3= pg_fetch_array($result3));
    
}else{
    echo 'No hubo personas que cumplan con los criterios capturados';
}


?>

<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
        <script src="../prenominas/styles/navbar2.js"></script>
        <script src="../prenominas/styles/jquery.js"></script> 
        <script src="validador.js"></script>
    </head>
    
    
    <style>
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
            .page-header{background-color: #416db0;}

            .sueldo{
                color: "#FFFFF";
            }
            .logo{
                
                    margin-left:300px;
                    margin-top: 20px;
                    margin-bottom: 20px;
        
            }
    </style>
    
    <script>
            $(document).ready(function () {
                $(".tbtn").click(function () {
                    $(this).parents(".custom-table").find(".toggler1").removeClass("toggler1");
                    $(this).parents("tbody").find(".toggler").addClass("toggler1");
                    $(this).parents(".custom-table").find(".fa-minus-circle").removeClass("fa-minus-circle");
                    $(this).parents("tbody").find(".fa-plus-circle").addClass("fa-minus-circle");
                    
                });
            });
    </script>
    
    <form name="todalanomina" method="POST" action="crearnomina.php">

    <body>
        <div class="container" id="contenedor"></div>
        <input hidden id="cantpersonas" name="cantpersonas" value=""></input>
        <table class="custom-table">
            <thead>
                <tr> <input hidden value="<?php echo $pc?>" name="pc"></input>
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
</div>
</body>
</html>