<?php
include_once('../../../config/cookie.php');
include_once ('../../../config/conectasql.php');
session_start();
$us_id=$_SESSION['us_id'];
$idempresa= base64_decode($_POST['idempresa']);
$idtipoperiodo = base64_decode($_POST['idtp']);
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
if(($idempresa==2)&&($idtipoperiodo!=4)){
    echo '
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
    </head>
    <body>
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
    </body>';
}else{

}
?>