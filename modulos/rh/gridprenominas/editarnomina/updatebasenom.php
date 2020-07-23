<?php 
//include_once ('../prenominas/index.php');
include_once ('../../../../config/cookie.php');
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
$fechaperiodo=base64_decode($_GET['oc4']); //el id del periodo y a forma de consulta se muestran las fechas
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

$sqlfechas="SELECT * from periodos where idperiodo = $fechaperiodo";
$resultsqlfechas=pg_query($conexion,$sqlfechas);
$fechas=pg_fetch_array($resultsqlfechas);
$fechainicio=$fechas['fecha_inicio'];
$fechafinal=$fechas['fecha_final'];

$sql2="UPDATE base_nom SET nom_id=$idnom, us_id=$us_id,fecha='$fecha',hora='$hora',plaza_id=$plaza,num_ventas=$numservicios,venta_directa=$ventasdirectas,cobros=$cobrosporventa,saldo=$saldo,cobros_per_ant=$cobrosanteriores,observaciones='$observaciones',emp_id=$empid,sal_tipo_id=$tipoperiodo,fecha_inicio='$fechainicio',fecha_fin='$fechafinal',pc='$pc' WHERE nom_id = $idnom";
$result2 = pg_query($conexion,$sql2) or die("Error en la insercion de datos temporales de base nom");

$sql3="select * from vw_sueldos_nomina where nom_id = $idnom";
//echo $sql3;
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
                        <td></td>
                        <td><input type="number" name="'.$row3['persona_id'].'cantidadsueldo[]" value="'.$row3['sal_monto_con'].'" readonly></input></td>
                        <td><input type="text" onkeyup="this.value=NumText(this.value)" name="'.$row3['persona_id'].'observacionessueldo[]" value="'.$row3['tmp_observaciones'].'"></input></td>
                  </tr>
                </tbody>
        ';
        //$monos.= $row3['persona_id'].'--'.$row3['nombrecompleto'].'<br>';
        
        $sql4="select * from vw_comnom where persona_id = ".$row3['persona_id']." and nom_id = $idnom;";
        $result4= pg_query($conexion,$sql4);
        if($row4= pg_fetch_array($result4)){
            do{
            $monos .='
                      <tr class="toggler toggler1">
                        <td rowspan="9999"></td>
                            <td><input value="'.$row4['co_id'].'" name="'.$row3['persona_id'].'comision[]" hidden>'.$row4['co_nombre'].'</td>
                            <td>'.$row4['co_monto'].'</td>
                            <td>'.$row4['co_porcentaje'].'</td>
                            <td><input type="number" onkeyup="this.value=Numeros(this.value)" step="0.01" name="'.$row3['persona_id'].'cuantos[]" value="'.$row4['co_cuantos'].'"></td>
                            <td><input type="number"onkeyup="this.value=Numeros(this.value)" step="0.01" name="'.$row3['persona_id'].'cantidadcom[]" value="'.$row4['co_cantidad'].'"></input></td>
                            <td><input type="text" onkeyup="this.value=NumText(this.value)" name="'.$row3['persona_id'].'observacionescom[]" value="'.$row4['co_observaciones'].'"></input></td>
                      </tr>
                    </tbody>';
                //$monos.='*'.$row4['co_id'].'--'.$row4['co_nombre'].'<br>';
                
            }while ($row4 = pg_fetch_array($result4));
         //$monos.='</tbody>';  
        }

        

        $sql5="select * from vw_percepciones where persona_id = ".$row3['persona_id']." and nom_id = $idnom";
        $result5= pg_query($conexion,$sql5);
        if($row5= pg_fetch_array($result5)){
            do{

            $tipospercepcionesquery="SELECT * FROM tipos_percepciones";
            $resulttipospercepcionesquery=pg_query($conexion,$tipospercepcionesquery);
            $rowquerytipospercepciones=pg_fetch_array($resulttipospercepcionesquery);

            $select ='<select name="'.$row3['persona_id'].'per[]">';
                do{
                    if($rowquerytipospercepciones['tp_id'] == $row5['tp_id']){
                        $default='selected';
                    }else{
                        $default='';
                    }
                $select .='<option value="'.$rowquerytipospercepciones['tp_id'].'"  '.$default.'>'.$rowquerytipospercepciones['tp_nombre'].'</option>';
            }while($rowquerytipospercepciones=pg_fetch_array($resulttipospercepcionesquery));
            $select .='<select>';


            $monos .='
                      <tr class="toggler toggler1">
                        <td rowspan="9999"></td>
                            <td><a class="delete" title="Delete" data-toggle="tooltip"><i class="fa fa-plus-circle fa-minus-circle"></i></a>'.$select.'</td>
                            <td></td>
                            <td></td>
                            <td><input name="'.$row3['persona_id'].'cuantosper[]" type="number" value="'.$row5['tp_cuantos'].'" onkeyup="this.value=Numeros(this.value)" step="0.01"></input></td>
                            <td><input type="number"  onkeyup="this.value=Numeros(this.value)" step="0.01" name="'.$row3['persona_id'].'cantidadper[]" value="'.$row5['tp_monto'].'"></input></td>
                            <td><input type="text" onkeyup="this.value=NumText(this.value)" name="'.$row3['persona_id'].'motivoper[]" value="'.$row5['tmp_observaciones'].'"></input></td>
                      </tr>
                    </tbody>';
                //$monos.='*'.$row4['co_id'].'--'.$row4['co_nombre'].'<br>';
                
            }while ($row5= pg_fetch_array($result5));
         //$monos.='</tbody>';  
        }

        $sql6="select * from vw_deducciones where persona_id = ".$row3['persona_id']." and nom_id = $idnom";
        $result6= pg_query($conexion,$sql6);
        if($row6= pg_fetch_array($result6)){
            do{
            $tiposdeduccionesquery="SELECT * FROM tipos_deducciones";
            $resulttiposdeduccionesquery=pg_query($conexion,$tiposdeduccionesquery);
            $rowquerytiposdeducciones=pg_fetch_array($resulttiposdeduccionesquery);

            $select ='<select name="'.$row3['persona_id'].'ded[]">';
                do{
                    if($rowquerytiposdeducciones['td_id'] == $row6['td_id']){
                        $default='selected';
                    }else{
                        $default='';
                    }
                $select .='<option value="'.$rowquerytiposdeducciones['td_id'].'"  '.$default.'>'.$rowquerytiposdeducciones['td_nombre'].'</option>';
            }while($rowquerytiposdeducciones=pg_fetch_array($resulttiposdeduccionesquery));
            $select .='<select>';


            $monos .='
                      <tr class="toggler toggler1">
                        <td rowspan="9999"></td>
                            <td><a class="delete" title="Delete" data-toggle="tooltip"><i class="fa fa-plus-circle fa-minus-circle"></i></a>'.$select.'</td>
                            <td></td>
                            <td></td>
                            <td><input name="'.$row3['persona_id'].'cuantosded[]" type="number" value="'.$row6['td_cuantos'].'" onkeyup="this.value=Numeros(this.value)" step="0.01"></input></td>
                            <td><input type="number" onkeyup="this.value=Numeros(this.value)" step="0.01" name="'.$row3['persona_id'].'cantidadded[]" value="'.$row6['td_monto'].'"></input></td>
                            <td><input type="text" onkeyup="this.value=NumText(this.value)" name="'.$row3['persona_id'].'motivoded[]" value="'.$row6['td_observaciones'].'"></input></td>
                      </tr>
                    </tbody>';
                //$monos.='*'.$row4['co_id'].'--'.$row4['co_nombre'].'<br>';
                
            }while ($row6=pg_fetch_array($result6));
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
        <script src="../editarnomina/updatevalidador.js"></script>
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
            table.table td a.delete {color: #E34724;}
            table.table td i {font-size: 19px;}

            .sueldo{
                color: "#FFFFF";
            }
            .logo{
                
                    margin-left:300px;
                    margin-top: 20px;
                    margin-bottom: 20px;
        
            }
    </style>

        <script type="text/javascript">
            $(document).on("click", ".delete", function(){
                $(this).parents("tr").remove();
		        $(".add-new").removeAttr("disabled");
            });
        </script>

<form name="todalanomina" method="POST" action="updatenuevanomina.php">
    <body>
        <div>
            <img src="../../../../images/logo.png" class="logo">
        </div>
        <div class="container" id="contenedor"></div>
        <input hidden id="cantpersonas" name="cantpersonas" value=""></input>
        <table class="custom-table">
            <thead>
                <tr> <input hidden value="<?php echo $pc?>" name="pc"></input>
                    <input hidden value="<?php echo $fechaperiodo?>" name="fechaperiodo"></input>
                    <input hidden value="<?php echo $plaza?>" name="plaza"></input>
                    <input hidden value="<?php echo $tipoperiodo?>" name="tipoperiodo"></input>
                    <input hidden value="<?php echo $empid?>" name="empid"></input>
                    <input hidden value="<?php echo $idnom ?>" name="nominaedit" id="nominaedit"></input>
                    <th>Persona</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Porcentaje</th>
                    <th>Cantidad</th> 
                    <th>Cantidad en pesos($$)</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <?php echo $monos ?>
            
        </table>
        
        <button id="submit" type="submit" onclick="editnomina()">GUARDAR NOMINA</button>
    </form>    
</div>
</body>
</html>


    
    
    
    