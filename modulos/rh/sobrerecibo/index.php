<?php 
//include_once ('../prenominas/index.php');
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

$sql3="select * from vw_contratos where con_status = 1 and sal_tipo_id = $tipoperiodo and emp_id  = $empid and plaza_id = $plaza ORDER BY nombrecompleto ASC";
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
        
        $sql4="select * from vw_puestos_comisiones where persona_id = ".$row3['persona_id']." and co_activo = 1;";
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
    
}else{
    echo 'No hubo personas que cumplan con los criterios capturados';
}


?>




<html>
    <head>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  
        <script src="../prenominas/styles/navbar2.js"></script>
        <script src="../prenominas/styles/jquery.js"></script> 
        <script src="validador.js"></script>
    </head>
    
    <form name="todalanomina" method="POST" action="crearnomina.php">
    <body>
        <div>
            <img src="../../../images/logo.png" class="logo">
        </div>
        <div id="contenedor"></div>
        <input hidden id="cantpersonas" name="cantpersonas" value=""></input>
        <table class="tabla">
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
</div>
</body>
</html>


<style>
  .logo{
    margin-left:300px;
    margin-top: 20px;
    margin-bottom: 20px;
  }
  .encabezados{
    background-image: linear-gradient(#02528A,#0000);
    color:#3D3F41;
    font-family:"Proxima nova";
    font-size:20px;
    width:10px;
    height:45px;
    border:solid 1px;
  }
  .botonesadd{
    position:right;
    margin-left:15px;
    font-size:15px;
    border-radius:4px;
    transition-duration: 0.4s;
    
  }
  .botonesadd:hover{
    background-color: white;
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
  }
  .tabla{
      border:solid 1px;
  }
  
  
</style>



    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    