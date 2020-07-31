<?php
include_once('../../../config/cookie.php');
include_once ('../../../config/conectasql.php');
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
        <div class="w3-row-padding">
                
        <div class="w3-half">
          <label>Saldo Plan</label>
          <input id="saldoplan" class="w3-input w3-border" name="saldoplan" type="number" placeholder="Saldo del plan" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
        </div>

        <div class="w3-half">
          <label>Adicionales</label>
          <input id="adicionales" class="w3-input w3-border" name="adicionales" type="number" placeholder="Adicionales" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
        </div>

        <div class="w3-half">
          <label>Servicios Directos</label>
          <input id="serviciosdirectos" class="w3-input w3-border" name="serviciosdirectos" type="number" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)" step="0.01">
        </div>

        <div class="w3-half">
          <label>Abono</label>
          <input id="abono" class="w3-input w3-border" type="number" placeholder="Abono"  name="abono" required onkeyup="this.value=Numeros(this.value)" step="0.01">
        </div>
        
        
        <div class="form-group">
            <div class="w3-half">
              <label>Ingresos</label>
              <input id="ingresos" class="w3-input w3-border" name="ingresos" type="number">
            </div>

            <div class="w3-half">
              <label>Cobranza periodos anteriores</label>
              <input id="cobrosanteriores" class="w3-input w3-border" type="number" name="cobranzaperanterior" required>
            </div>

            <div class="w3-half">
              <label>Recibo total</label>
              <input id="recibototal" class="w3-input w3-border" type="number" name="recibototal" required>
            </div>
        </div>
        <div class="w3-half">
          <label>Observaciones</label>
          <input type="text" class="form-control" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
        </div>
        </div>
      </div>
        ';
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
        <div class="w3-row-padding">
                
        <div class="w3-half">
          <label>Saldo Plan</label>
          <input id="saldoplan" class="w3-input w3-border" name="saldoplan" type="number" placeholder="Saldo del plan" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
        </div>

        <div class="w3-half">
          <label>Adicionales</label>
          <input id="adicionales" class="w3-input w3-border" name="adicionales" type="number" placeholder="Adicionales" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
        </div>

        <div class="w3-half">
          <label>Servicios Directos</label>
          <input id="serviciosdirectos" class="w3-input w3-border" name="serviciosdirectos" type="number" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)" step="0.01">
        </div>

        <div class="w3-half">
          <label>Abono</label>
          <input id="abono" class="w3-input w3-border" type="number" placeholder="Abono"  name="abono" required onkeyup="this.value=Numeros(this.value)" step="0.01">
        </div>
        
        
        <div class="form-group">
            <div>
              <label>Ingresos</label>
              <input id="ingresos" class="w3-input w3-border" name="ingresos" type="number">
            </div>

            <div class="w3-half">
              <label>Cobranza periodos anteriores</label>
              <input id="cobrosanteriores" class="w3-input w3-border" type="number" name="cobranzaperanterior" required>
            </div>

            <div class="w3-half">
              <label>Recibo total</label>
              <input id="recibototal" class="w3-input w3-border" type="number" name="recibototal" required>
            </div>
        </div>
        <div class="w3-half">
          <label>Observaciones</label>
          <input type="text" class="form-control" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
        </div>
        </div>
      </div>';
        
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
        <div class="w3-row-padding">
                
        <div class="w3-half">
          <label>Saldo Plan</label>
          <input id="saldoplan" class="w3-input w3-border" name="saldoplan" type="number" placeholder="Saldo del plan" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
        </div>

        <div class="w3-half">
          <label>Adicionales</label>
          <input id="adicionales" class="w3-input w3-border" name="adicionales" type="number" placeholder="Adicionales" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
        </div>

        <div class="w3-half">
          <label>Servicios Directos</label>
          <input id="serviciosdirectos" class="w3-input w3-border" name="serviciosdirectos" type="number" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)" step="0.01">
        </div>

        <div class="w3-half">
          <label>Abono</label>
          <input id="abono" class="w3-input w3-border" type="number" placeholder="Abono"  name="abono" required onkeyup="this.value=Numeros(this.value)" step="0.01">
        </div>
        
        
        <div class="form-group">
            <div class="w3-half">
              <label>Ingresos</label>
              <input id="ingresos" class="w3-input w3-border" name="ingresos" type="number">
            </div>

            <div class="w3-half">
              <label>Cobranza periodos anteriores</label>
              <input id="cobrosanteriores" class="w3-input w3-border" type="number" name="cobranzaperanterior" required>
            </div>

            <div class="w3-half">
              <label>Recibo total</label>
              <input id="recibototal" class="w3-input w3-border" type="number" name="recibototal" required>
            </div>
        </div>
        <div class="w3-half">
          <label>Observaciones</label>
          <input type="text" class="form-control" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
        </div>
        </div>
      </div>';
        
    }
else
    if($oc1==4){
        $query="SELECT idperiodo, num_periodo, fecha_inicio, fecha_final from vw_periodonomina WHERE autorizada = true order by num_periodo";
        $result= pg_query($conexion,$query);
    $mostrar= pg_fetch_array($result);
        echo'<div id=opcion>'
        . '<select id="fechaperiodo">';
            do{
                echo '<option value="'.$mostrar['idperiodo'].'">AJUS-'.$mostrar['num_periodo'].' DEL '.$mostrar['fecha_inicio'].' - AL - '.$mostrar['fecha_final'].'</option>';
            }while($mostrar= pg_fetch_array($result));
        echo'</select>';
        echo'</div>';
        echo'
        <input hidden value="0" id="saldoplan" class="w3-input w3-border" name="saldoplan" type="number" placeholder="Saldo del plan" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
        <input hidden value="0" id="adicionales" class="w3-input w3-border" name="adicionales" type="number" placeholder="Adicionales" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
        <input hidden value="0" id="serviciosdirectos" class="w3-input w3-border" name="serviciosdirectos" type="number" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)" step="0.01">
        <input hidden value="0" id="abono" class="w3-input w3-border" type="number" placeholder="Abono"  name="abono" required onkeyup="this.value=Numeros(this.value)" step="0.01">
        <input hidden value="0" id="ingresos" class="w3-input w3-border" name="ingresos" type="number">
        <input hidden value="0" id="cobrosanteriores" class="w3-input w3-border" type="number" name="cobranzaperanterior" required>
        <input hidden value="0" id="recibototal" class="w3-input w3-border" type="number" name="recibototal" required>
        <input hidden value="----" type="text" class="form-control" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
        ';

    }
else{
        echo 'Opcion no valida, escoge una!!!';
}

?>


