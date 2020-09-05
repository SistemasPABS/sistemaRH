<?php 
include ('../../../../config/cookie.php');
include ('../../../../config/conectasql.php');
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
session_start();
$fecha=date("Ymd");
$hora=date("H:i:s");
$usid=$_SESSION['us_id'];
$oc1=$_GET["idnom"];

//Verificar si la nomina esta autorizada o no 
$querynominahabilitadaparaeditar = "SELECT * FROM nomina where nom_id = $oc1";
$resultquerynominahabilitadaparaeditar = pg_query($conexion,$querynominahabilitadaparaeditar);
$mostrarnominaporautorizar = pg_fetch_array($resultquerynominahabilitadaparaeditar);
$nominaporautorizar = $mostrarnominaporautorizar['nom_autorizada'];

if($nominaporautorizar != 't'){


  //Insertar en tabla temporal de edicion de nomina para evitar la edicion de la misma nomina por mas de un usuario al mismo tiempo
  $queryedicion="SELECT * FROM controlador_nomina WHERE idnom = $oc1";
  $resultqueryedicion = pg_query($conexion,$queryedicion) or die("Error en la consulta SQL".pg_last_error());
  $obtenerresult = pg_fetch_array($resultqueryedicion);
  $idnominaenproceso = $obtenerresult['idnom'];


    $query="SELECT * FROM vw_nomina_basenom WHERE nom_id = $oc1";
    $result = pg_query($conexion,$query) or die("Error en la consulta SQL");
    $mostrar = pg_fetch_array($result);
    
    //Obtener informacion de la empresa 
    $idempresa = $mostrar['emp_id'];
    $queryidempresa="SELECT * FROM empresas where emp_id = $idempresa";
    $resultqueryidempresa = pg_query($conexion,$queryidempresa) or die("Error en la consulta SQL".pg_last_error());
    $mostrarempresa = pg_fetch_array($resultqueryidempresa);
    
    //Obtener informacion de las plazas
    $idplaza = $mostrar['plaza_id'];
    $queryidplaza="SELECT * FROM plazas where plaza_id = $idplaza";
    $resultqueryidplaza = pg_query($conexion,$queryidplaza) or die("Error en la consulta SQL".pg_last_error());
    $mostrarplaza = pg_fetch_array($resultqueryidplaza);
    
    //Obtener informacion de los salarios
    $idtiposalarios = $mostrar['sal_tipo_id'];
    $queryidtiposalarios="SELECT * FROM tipos_salarios where sal_tipo_id = $idtiposalarios";
    $resultqueryidtiposalarios = pg_query($conexion,$queryidtiposalarios) or die("Error en la consulta SQL".pg_last_error());
    $mostrartiposalarios = pg_fetch_array($resultqueryidtiposalarios);

    //Se obtienen empleados de la nomina
    $sqlsueldosnomina = "SELECT * FROM vw_sueldos_nomina WHERE nom_id = $oc1";
    //echo $sqlsueldosnomina;
    $resultsqlsueldosnomina = pg_query($conexion,$sqlsueldosnomina);
    $mostrarinformacionsueldosnomina = pg_fetch_array($resultsqlsueldosnomina);

    /* -------------------------------------------------------   */
    //      OBTENER LAS PERSONAS QUE HAY EN LA NOMINA            //
    /* -------------------------------------------------------   */
    $personas = array();
    $ids = "";
        do{
            $ids .= "".$mostrarinformacionsueldosnomina['persona_id'].",";
            $personas[] = $mostrarinformacionsueldosnomina['persona_id'];
        }while($mostrarinformacionsueldosnomina = pg_fetch_array($resultsqlsueldosnomina));
    $ids = substr($ids,0,-1);
    //echo $ids.'  ';

    //SE OBTIENEN LOS EMPLEADOS QUE SON DE LA EMPRESA, DEL PERIODO Y DE LA PLAZA
    $sql3="select * from vw_contratos where con_status = 1 and sal_tipo_id = $idtiposalarios and emp_id = '$idempresa' and plaza_id = $idplaza";
    //echo $sql3.'  ';
    $result3= pg_query($conexion,$sql3);
    $mostrarinformacioncontratos = pg_fetch_array($result3);

    $personasfaltantes = array();
    $idspersonasfaltantes = "";
    do{
      $idspersonasfaltantes .= "".$mostrarinformacioncontratos['persona_id'].",";
      $personasfaltantes[] = $mostrarinformacioncontratos['persona_id'];
    }while($mostrarinformacioncontratos = pg_fetch_array($result3));
    $idspersonasfaltantes = substr($idspersonasfaltantes,0,-1);
    //echo $idspersonasfaltantes.' < ---- >';


  $largepersonas=count($personas);
  $largepersonasfaltantes=count($personasfaltantes);

  //echo $largepersonas.' -- ';
  //echo $largepersonasfaltantes;


    if($largepersonas != $largepersonasfaltantes){
      $agregarpersonas .= '
        <button id="agregarpersonas" name="agregarpersonas"  onclick="href=seleccionarpersonasextras.php">Agregar Personas</button>
      ';
    }else{
      $agregarpersonas .= '
        <button id="agregarpersonas" name="agregarpersonas"  disabled>Agregar personas</button>
      ';
    }
    
    $resumen.= '
    <div>
      <div>
        <div>
          <div>
            <h3>Editar Carga base de incidencias</h3>
          </div>
          
          <div>	
            <!-- content goes here -->
              <form action="updatebasenom.php" method="post" name="modalnomina" id="modalnomina" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
              <div>
                <img class="logo" src="../../../images/logo.png"></img>
              </div>
                <div>
                  <div>
                    <label>  Folio de nomina:  </label>
                    <input class="w3-input" id="idnom" name="idnom" readonly value="'.$mostrar['nom_id'].'" ></input>
                  </div>
                  
                  <div>
                    <label>  Plaza:  </label>
                    <input hidden id="plazas" name="plazas" type="text" readonly value="'.$mostrar['plaza_id'].'"></input>
                    <input class="w3-input" readonly value="'.$mostrarplaza['plaza_nombre'].'"></input>
                  </div>
    
                  <div>
                    <label>  Empresa:  </label>
                    <input hidden id="empresa" name="empresa" type="text" readonly value="'.$mostrar['emp_id'].'"></input>
                    <input class="w3-input" readonly value="'.$mostrarempresa['emp_nombre'].'"></label>
                  </div>
    
                  <div>
                    <label>  Tipo de Salario:  </label>
                    <input hidden id="tipoperiodo" name="tipoperiodo" type="number" readonly value="'.$mostrar['sal_tipo_id'].'"></input>
                    <input class="w3-input" readonly value="'.$mostrartiposalarios['sal_tipo_nombre'].'"></input>            
    
                  </div>
    
                  <div>
                    <label> Fechas del periodo </label>
                    <input hidden name="fechaperiodo" id="fechaperiodo" value="'.$mostrar['idperiodo'].'"></input>
                    <input class="w3-input" readonly value="'.$mostrar['fecha_inicio'].' -- '.$mostrar['fecha_fin'].'"></input>  
                  </div>
    
    
                  <div><label>--------------------------------------------------------------------------------------------------------------------------------------</label></div>
                    <div class="w3-row-padding">
                        <div class="w3-third"> 
                          <label>Saldo Plan</label>
                          <input class="w3-input w3-animate-input" id="saldoplan" onkeyup="this.value=Numeros(this.value)" step="0.01" value="'.$mostrar['num_ventas'].'" name="saldoplan" type="number" placeholder="Numero de servicios" width="20%" required> 
                        </div>
    
                        <div class="w3-third">
                          <label>Adicionales</label>
                          <input class="w3-input w3-animate-input" id="adicionales" value="'.$mostrar['venta_directa'].'" name="adicionales" type="number" step="0.01" placeholder="Adicionales" required onkeyup="this.value=Numeros(this.value)">
                        </div>
                        
                        <div class="w3-third">
                          <label>Servicios Directos</label>
                          <input class="w3-input w3-animate-input" id="serviciosdirectos" value="'.$mostrar['cobros'].'" type="number" step="0.01" name="serviciosdirectos" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)">
                        </div>
    
                        <div class="w3-third">
                          <label>Abono</label>
                          <input class="w3-input w3-animate-input" id="abono" value="'.$mostrar['saldo'].'" type="number" step="0.01" placeholder="Abono" name="abono" required onkeyup="this.value=Numeros(this.value)">
                        </div>

                        <div class="w3-half">
                          <label>Ingresos</label>
                          <input id="ingresos" class="w3-input w3-border" name="ingresos" type="number" value="'.$mostrar['ingresos'].'">
                        </div>

                        <div class="w3-half">
                          <label>Cobranza periodos anteriores</label>
                          <input id="cobrosanteriores" class="w3-input w3-border" type="number" name="cobranzaperanterior" value="'.$mostrar['cobros_per_ant'].'" required>
                        </div>

                        <div class="w3-half">
                          <label>Recibo total</label>
                          <input id="recibototal" class="w3-input w3-border" type="number" value="'.$mostrar['recibototal'].'" name="recibototal" required>
                        </div>
    
                        <div class="w3-third">
                          <label>Observaciones</label>
                          <input class="w3-input w3-animate-input" type="text" value="'.$mostrar['observaciones'].'" placeholder="Observaciones" id="observaciones" maxlength="150" onkeyup="this.value=NumText(this.value)"></input> 
                        </div>
                    </div>
                  </div>
                <div class="btn-group" role="group">
                  <input hidden value="<?php echo $oc1?>"></input>
                  <input type="button" name="saveImage" class="btn btn-default btn-hover-green" onclick="editarnomina()" value="comenzar">
                </div>
              </form>
            <!---Aqui se acaba el form--->
          </div>  
        </div>  
      </div>
    </div>';
echo $agregarpersonas;
}else{
  echo 'Esta nomina ya está autorizada, no puedes editarla.. Si deseas ver la información de ella puedes ejecutar un reporte';
}

?>

<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <script src="../gridprenominas/editarnomina.js"></script>
    </head>

    <body>
      <?php 
        if($idnominaenproceso == $oc1){
          echo 'La nomina está siendo editada, deberás esperar a que se termine el proceso';
        }else{
          $queryinsert="INSERT INTO controlador_nomina (us_id,fecha,hora,idnom) values ($usid,'$fecha','$hora',$oc1)";
          $result=pg_query($conexion,$queryinsert) or die ("Error al insertar en la tabla temporal en el controlador de nomina".pg_last_error());
          echo $resumen;
          $boton .='
          <div class="btn-group" role="group">
            <input hidden value="<?php echo $oc1?>"></input>
            <input type="button" name="saveImage" class="btn btn-default btn-hover-green" onclick="editarnomina()" value="comenzar">
          </div>
          ';
        }
        //echo $boton;
      ?>
      
    </body>

</html>

  

<style>
  .logo{
    margin-left:400px;
    margin-top:5px;
    width: 200px;
    height: 50px;
  }
</style>


        
                


