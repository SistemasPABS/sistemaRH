<?php 
include ('../../../../config/cookie.php');
include ('../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
session_start();
$usid=$_SESSION['us_id'];
$oc1=$_GET["idnom"];

$query="SELECT * FROM vw_nomina_basenom WHERE nom_id = $oc1";
$result = pg_query($conexion,$query) or die("Error en la consulta SQL");
$mostrar = pg_fetch_array($result);
$resumen.= '
<form action="updatebasenom.php" method="post" name="modalnomina" id="modalnomina">
<label>  Folio de nomina:  </label>
<input id="idnom" name="idnom" type="number" readonly value="'.$mostrar['nom_id'].'"> '.$mostrar['nom_id'].' </input>
<label>  Plaza:  </label>
<input id="plazas" name="plazas" type="text" readonly value="'.$mostrar['plaza_id'].'"> '.$mostrar['plaza_nombre'].' </input>
<label>  Empresa:  </label>
<input id="empresa" name="empresa" type="text" readonly value="'.$mostrar['emp_id'].'"> '.$mostrar['emp_nombre'].' </input><label> '.$mostrar['emp_nombre'].' </label>
<label>  Tipo de Salario:  </label>
<input id="tipoperiodo" name="tipoperiodo" type="number" readonly value="'.$mostrar['sal_tipo_id'].'"> '.$mostrar['sal_tipo_nombre'].' </input>
<label>  Fecha Periodo Inicio  </label>
<input id="fechaperiodoinicio" name="fechaperiodoinicio" type="text" readonly value="'.$mostrar['fecha_inicio'].'"> '.$mostrar['fecha_inicio'].' </input>
<label>  Fecha Periodo Fin  </label>
<input id="fechaperiodofin" name="fechaperiodofin" type="text" readonly value="'.$mostrar['fecha_fin'].'"> '.$mostrar['fecha_fin'].' </input>


  <div>
    <label>Numero de servicios</label>
      <input id="numservicios" value="'.$mostrar['num_ventas'].'" name="numservicios" type="number" placeholder="Numero de servicios" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
  </div>

  <div>
    <label>Ventas directas</label>
      <input id="ventasdirectas" value="'.$mostrar['venta_directa'].'" name="numventas" type="number" placeholder="Ventas directas" required onkeyup="this.value=Numeros(this.value)">
  </div>

  <div>
    <label>Cobros por ventas</label>
      <input id="cobrosporventa" value="'.$mostrar['cobros'].'" type="number" name="cobros" placeholder="Cobros por ventas" required onkeyup="this.value=Numeros(this.value)">
  </div>

  <div>
    <label>Saldo</label>
      <input id="saldo" value="'.$mostrar['saldo'].'" type="number" placeholder="Saldo" name="saldo" required onkeyup="this.value=Numeros(this.value)">
  </div>

  <div>
    <label>Cobranza periodos anteriores</label>
      <input id="cobrosanteriores" value="'.$mostrar['cobros_per_ant'].'" type="number" placeholder="Cobranza del periodo anterior" name="cobranzaperanterior" required onkeyup="this.value=Numeros(this.value)">
  </div>

  <div>
    <label>Observaciones</label>
      <input type="text" value="'.$mostrar['observaciones'].'" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
  </div>
</form>';



?>

<html>
    <head>
      <script src="./editarnomina.js"></script>
    </head>

    <body>
      <?php 
        echo $resumen;
      ?>
      <div class="btn-group" role="group">
        <input type="button" name="saveImage" class="btn btn-default btn-hover-green" onclick="editarnomina()" value="comenzar">
	    </div>
    </body>

</html>


        
                


