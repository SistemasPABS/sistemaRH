<?php 
include_once('../../../../config/cookie.php');
include_once('../../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$em=base64_decode($_GET['em']);
session_start();
$usid=$_SESSION['us_id'];
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
$plaza=base64_decode($_GET['oc1']);//plaza
$empid=base64_decode($_GET['oc2']); //empid
$tipoperiodo=base64_decode($_GET['oc3']);//tipoperiodo
$fechaperiodo=base64_decode($_GET['oc4']); //fechaperiodo
$numservicios=base64_decode($_GET['oc5']);//numservicios
$ventasdirectas=base64_decode($_GET['oc6']);//ventasdirectas
$cobrosporventa=base64_decode($_GET['oc7']);//cobrosporventa
$saldo=base64_decode($_GET['oc8']);//saldo
$ingresos=base64_decode($_GET['oc9']);//ingresos
$observaciones=base64_decode($_GET['oc10']);//observaciones
$em=base64_decode($_GET['oc11']);//estructura menu
$cobrosanteriores=base64_decode($_GET['oc12']);//cobrosanteriores
$recibototal=base64_decode($_GET['oc13']);//recibototal
$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);//computadora de donde se hace

$sqlfechas="SELECT * FROM periodos WHERE idperiodo=$fechaperiodo";
$resultsqlfechas = pg_query($conexion,$sqlfechas) or die("Error al obtener los periodos");
$rowsqlfechas = pg_fetch_array($resultsqlfechas);

$sql1="SELECT * FROM vw_nominasautorizadas WHERE idperiodo=$fechaperiodo";
$result1 = pg_query($conexion,$sql1) or die("Error al obtener la informacion de la nomina autorizada");
$row1 = pg_fetch_array($result1);
$idnomina = $row1['nom_id'];

$sql2="INSERT into tmp_base_nom_ajuste (us_id,fecha,hora,plaza_id,num_ventas,venta_directa,cobros,saldo,cobros_per_ant,observaciones,emp_id,sal_tipo_id,fecha_inicio,fecha_fin,pc,ingresos,recibototal,idnomina) values ($usid,'$fecha','$hora',$plaza,$numservicios,$ventasdirectas,$cobrosporventa,$saldo,$cobrosanteriores,'$observaciones','$empid',$tipoperiodo,'".$rowsqlfechas['fecha_inicio']."','".$rowsqlfechas['fecha_final']."','$pc',$ingresos,$recibototal,$idnomina)";
$result2 = pg_query($conexion,$sql2) or die("Error en la insercion de datos temporales de base nom".pg_last_error());

$sql3="SELECT * FROM vw_contratos WHERE con_status = 1 AND emp_id = '$empid' AND plaza_id = $plaza";
$result3= pg_query($conexion,$sql3);
$row3=pg_fetch_array($result3);
do{
    $personas.='
        
                <div class="container">
                    <input type="checkbox" value="'.$row3['persona_id'].'" name="personaid[]">'.$row3['nombrecompleto'].'</input>
                </div>
       
    ';
}while($row3=pg_fetch_array($result3));
?>

<html>
    <head>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="validador.js"></script>
    </head>

    <body>
    
        <div>SELECCIONA LAS PERSONAS A LAS QUE LES QUIERES AJUSTAR LA NOMINA</div>
            <form name="personas" action="ajustador.php" method="post">
            <input hidden value="<?php echo $idnomina?>" name="nomid"></input>
            <input hidden value="<?php echo $plaza?>" name="plaza"></input>
            <input hidden value="<?php echo $empid?>" name="empid"></input>
            <input hidden value="<?php echo $tipoperiodo?>" name="tipoperiodo"></input>
            <input hidden value="<?php echo $fechaperiodo?>" name="fechaperiodo"></input>
            <input hidden value="<?php echo $hora?>" name="hbn"></input>
                <?php echo $personas?>
            </form>
        <div>
            <button id="submit" type="submit" onclick="ajustarnomina()">HACER AJUSTES</button>
        </div>
    </body>
</html>