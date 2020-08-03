<?php
include_once ('../../../config/cookie.php');
include_once ('../../../config/conectasql.php');
session_start();
$fecha=date("Ymd");
$hora=date("H:i:s");
$hbn=$_POST['hbn'];
$us_id=$_SESSION['us_id'];
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$personaid=$_POST['personaid'];
$plaza = $_POST['plaza'];
$empid = $_POST['empid'];
$tipoperiodo = $_POST['tipoperiodo'];
$fechaperiodo = $_POST['fechaperiodo'];
$nomid = $_POST['nomid'];

$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);//computadora de donde se hace
foreach($personaid AS $p){
//condicion para el foreach
$p=$p++;
$sql3="SELECT * from vw_contratos where con_status = 1 and persona_id = $p";
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
                                <td><input value="'.$row4['co_id'].'" name="'.$row3['persona_id'].'comision[]" hidden >'.$row4['co_nombre'].'</td>
                                <td><input value="'.$row4['co_monto'].'" readonly></td>
                                <td><input value="'.$row4['co_porcentaje'].'" readonly></td>
                                <td><input type="number" onkeyup="this.value=Numeros(this.value)" step="0.01" name="'.$row3['persona_id'].'cuantos[]" value="0"></td>
                                <td><input type="number" onkeyup="this.value=Numeros(this.value)" step="0.01" name="'.$row3['persona_id'].'cantidadcom[]" value="0" ></td>
                                <td><input type="text" name="'.$row3['persona_id'].'observacionescom[]" value="---" onkeyup="this.value=NumText(this.value)"></td>
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
        <script src="nominadeajuste.js"></script>
        <script src="../gridprenominas/calculadoracomisiones.js"></script>
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
    
    

    <body>
        <div class="container" id="contenedor" style="overflow-x:auto;">
        <form name="todalanominadeajuste" method="POST" action="crearnominadeajuste.php">
        <input hidden id="cantpersonas" name="cantpersonas" value=""></input>
        <table class="custom-table">
            <thead>
                <tr>
                    <input hidden value="<?php echo $pc?>" name="pc"></input>
                    <input hidden value="<?php echo $hbn?>" name="hbn"></input>
                    <input hidden value="<?php echo $nomid ?>" name="nomid"></input>
                    <input hidden value="<?php echo $plaza ?>" name="plaza"></input>
                    <input hidden value="<?php echo $empid ?>" name="empid"></input>
                    <input hidden value="<?php echo $fechaperiodo ?>" name="fechaperiodo"></input>
                    <input hidden value="<?php echo $tipoperiodo ?>" name="tipoperiodo"></input>
                    <th>Persona</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Porcentaje</th>
                    <th>Cantidad</th>
                    <th>Cantidad en pesos ($$)</th>  
                    <th>Observaciones</th>
                </tr>
            </thead>
            
            <?php echo $monos?>
            <?php echo $autorizadores?>
            
        </table>
        
        <button id="submit" type="submit" onclick="enviarnominadeajuste()">GUARDAR NOMINA DE AJUSTE</button>
        
    </form>    
</div>
</body>
</html>



