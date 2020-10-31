<?php
include_once('../../../../config/cookie.php');
include_once ('../../../../config/conectasql.php');
session_start();
$us_id=$_SESSION['us_id'];
$oc1= base64_decode($_POST['idtp']);
$idempresa = base64_decode($_POST['idempresa']);
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
//echo $oc1;
if ($oc1==1){
    $query="SELECT idperiodo, num_periodo, fecha_inicio, fecha_final from periodos WHERE id_sal_tipo = 1 order by num_periodo";
    $result= pg_query($conexion,$query);
    $mostrar= pg_fetch_array($result);
        echo'<div id=opcion>'
        . '<select id="fechaperiodo">';
            do{
                echo '<option value="'.$mostrar['idperiodo'].'">Sem-'.$mostrar['num_periodo'].' DEL '.$mostrar['fecha_inicio'].' - AL - '.$mostrar['fecha_final'].'</option>';
            }while($mostrar= pg_fetch_array($result));
        echo'</select>';
        echo'</div>';
        echo'
          <head>
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">   
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
            <link href="jquery.multiselect.css" rel="stylesheet" type="text/css">
            <script src="jquery.min.js"></script>
            <script src="jquery.multiselect.js"></script>
          </head>

          <body>
            <table>
              <tr>
                <td>
                  <label>Saldo Plan</label>
                  <input id="saldoplan" name="saldoplan" type="number" placeholder="Saldo del plan" width="20%" required onkeyup="this.value=Numeros(this.value)">
                </td>

                <td>
                  <label>Adicionales</label>
                  <input id="adicionales" name="adicionales" type="number" placeholder="Adicionales" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
                </td>
              </tr>

              <tr>
                <td>
                  <label>Servicios Directos</label>
                  <input id="serviciosdirectos" name="serviciosdirectos" type="number" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)" step="0.01">
                </td>
                <td>
                  <label>Abono</label>
                  <input id="abono" type="number" placeholder="Abono"  name="abono" required onkeyup="this.value=Numeros(this.value)" step="0.01">
                </td>
              </tr>

              <tr>
                <td>
                  <label>Ingresos</label>
                  <input id="ingresos" name="ingresos" type="number">
                </td>

                <td>
                  <label>Cobranza periodos anteriores</label>
                  <input id="cobrosanteriores" type="number" name="cobranzaperanterior" required>
                </td>
              </tr>

              <tr>
                <td>
                  <label>Recibo total</label>
                  <input id="recibototal"  type="number" name="recibototal" required>
                </td>

                <td>
                  <label>Observaciones</label>
                  <input type="text" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
                </td>
              </tr>
            </table>
          </body>';
}else 
    if($oc1==2){
        $query="SELECT idperiodo, num_periodo, fecha_inicio, fecha_final from periodos WHERE id_sal_tipo = 2 order by num_periodo";
        $result= pg_query($conexion,$query);
        $mostrar= pg_fetch_array($result);
        echo'<div id=opcion>'
        . '<select id="fechaperiodo">';
            do{
                echo '<option value="'.$mostrar['idperiodo'].'">Quin-'.$mostrar['num_periodo'].' DEL '.$mostrar['fecha_inicio'].' - AL - '.$mostrar['fecha_final'].'</option>';
            }while($mostrar= pg_fetch_array($result));
        echo'</select>';
        echo'</div>';
        echo'
        <head>
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
            <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">   
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
            <link href="jquery.multiselect.css" rel="stylesheet" type="text/css">
            <script src="jquery.min.js"></script>
            <script src="jquery.multiselect.js"></script>
          </head>

          <body>
            <table>
              <tr>
                <td>
                  <label>Saldo Plan</label>
                  <input id="saldoplan" name="saldoplan" type="number" placeholder="Saldo del plan" width="20%" required onkeyup="this.value=Numeros(this.value)">
                </td>

                <td>
                  <label>Adicionales</label>
                  <input id="adicionales" name="adicionales" type="number" placeholder="Adicionales" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
                </td>
              </tr>

              <tr>
                <td>
                  <label>Servicios Directos</label>
                  <input id="serviciosdirectos" name="serviciosdirectos" type="number" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)" step="0.01">
                </td>
                <td>
                  <label>Abono</label>
                  <input id="abono" type="number" placeholder="Abono"  name="abono" required onkeyup="this.value=Numeros(this.value)" step="0.01">
                </td>
              </tr>

              <tr>
                <td>
                  <label>Ingresos</label>
                  <input id="ingresos" name="ingresos" type="number">
                </td>

                <td>
                  <label>Cobranza periodos anteriores</label>
                  <input id="cobrosanteriores" type="number" name="cobranzaperanterior" required>
                </td>
              </tr>

              <tr>
                <td>
                  <label>Recibo total</label>
                  <input id="recibototal"  type="number" name="recibototal" required>
                </td>

                <td>
                  <label>Observaciones</label>
                  <input type="text" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
                </td>
              </tr>
            </table>
          </body>';
    }
else
    if($oc1==3){
        $query="SELECT idperiodo, num_periodo, fecha_inicio, fecha_final from periodos WHERE id_sal_tipo = 3 order by num_periodo";
        $result= pg_query($conexion,$query);
    $mostrar= pg_fetch_array($result);
        echo'<div id=opcion>'
        . '<select id="fechaperiodo">';
            do{
                echo '<option value="'.$mostrar['idperiodo'].'">Mens-'.$mostrar['num_periodo'].' DEL '.$mostrar['fecha_inicio'].' - AL - '.$mostrar['fecha_final'].'</option>';
            }while($mostrar= pg_fetch_array($result));
        echo'</select>';
        echo'</div>';
        echo'
        <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">   
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <link href="jquery.multiselect.css" rel="stylesheet" type="text/css">
        <script src="jquery.min.js"></script>
        <script src="jquery.multiselect.js"></script>
      </head>

      <body>
        <table>
          <tr>
            <td>
              <label>Saldo Plan</label>
              <input id="saldoplan" name="saldoplan" type="number" placeholder="Saldo del plan" width="20%" required onkeyup="this.value=Numeros(this.value)">
            </td>

            <td>
              <label>Adicionales</label>
              <input id="adicionales" name="adicionales" type="number" placeholder="Adicionales" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
            </td>
          </tr>

          <tr>
            <td>
              <label>Servicios Directos</label>
              <input id="serviciosdirectos" name="serviciosdirectos" type="number" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)" step="0.01">
            </td>
            <td>
              <label>Abono</label>
              <input id="abono" type="number" placeholder="Abono"  name="abono" required onkeyup="this.value=Numeros(this.value)" step="0.01">
            </td>
          </tr>

          <tr>
            <td>
              <label>Ingresos</label>
              <input id="ingresos" name="ingresos" type="number">
            </td>

            <td>
              <label>Cobranza periodos anteriores</label>
              <input id="cobrosanteriores" type="number" name="cobranzaperanterior" required>
            </td>
          </tr>

          <tr>
            <td>
              <label>Recibo total</label>
              <input id="recibototal"  type="number" name="recibototal" required>
            </td>

            <td>
              <label>Observaciones</label>
              <input type="text" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
            </td>
          </tr>
        </table>
      </body>';
    }
else
    if($oc1==4){
        $query="SELECT idperiodo, num_periodo, fecha_inicio, fecha_fin from vw_nominasautorizadas order by num_periodo";
        $result= pg_query($conexion,$query);
    $mostrar= pg_fetch_array($result);
        echo'<div id=opcion>'
        . '<select id="fechaperiodo">';
            do{
                echo '<option value="'.$mostrar['idperiodo'].'">AJUS-'.$mostrar['num_periodo'].' DEL '.$mostrar['fecha_inicio'].' - AL - '.$mostrar['fecha_fin'].'</option>';
            }while($mostrar= pg_fetch_array($result));
        echo'</select>';
        echo'</div>';
        echo'
        <input hidden value="0" id="saldoplan" name="saldoplan" type="number" placeholder="Saldo del plan" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
        <input hidden value="0" id="adicionales"  name="adicionales" type="number" placeholder="Adicionales" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
        <input hidden value="0" id="serviciosdirectos"  name="serviciosdirectos" type="number" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)" step="0.01">
        <input hidden value="0" id="abono"  type="number" placeholder="Abono"  name="abono" required onkeyup="this.value=Numeros(this.value)" step="0.01">
        <input hidden value="0" id="ingresos"  name="ingresos" type="number">
        <input hidden value="0" id="cobrosanteriores"  type="number" name="cobranzaperanterior" required>
        <input hidden value="0" id="recibototal"  type="number" name="recibototal" required>
        <input hidden value="----" type="text" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
        ';

    }
else{
        echo 'Opcion no valida, escoge una!!!';
}

?>


