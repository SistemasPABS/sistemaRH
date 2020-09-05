<?php
include_once('../../../../config/cookie.php');
include_once ('../../../../config/conectasql.php');
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
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <div>
        <table>
            <td>Hola
                <tr>Julieta Parra</tr>
                <tr>Ana Victoria Parra</tr>
            </td>
        </table>
            <div>
                <label>Saldo Plan</label>
                <input id="saldoplan" class="form-control" name="saldoplan" type="number" placeholder="Saldo del plan" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
            </div>

            <div class="w3-half">
                <label>Adicionalessss</label>
                <input id="adicionales" class="form-control" name="adicionales" type="number" placeholder="Adicionales" width="20%" required onkeyup="this.value=Numeros(this.value)"> 
            </div>
            <div class="w3-half">
                <label>Servicios Directos</label>
                input id="serviciosdirectos" class="form-control" name="serviciosdirectos" type="number" placeholder="Servicios Directos" required onkeyup="this.value=Numeros(this.value)" step="0.01">
            </div>
            <div class="w3-half">
                <label>Abono</label>
                <input id="abono" class="form-control" type="number" placeholder="Abono"  name="abono" required onkeyup="this.value=Numeros(this.value)" step="0.01">
            </div>
                
            <div class="w3-half">
                <label>Ingresos</label>
                <input id="ingresos" class="form-control" name="ingresos" type="number">
            </div>
            <div class="w3-half">
                <label>Cobranza periodos anteriores</label>
                <input id="cobrosanteriores" class="form-control" type="number" name="cobranzaperanterior" required>
            </div>
            <div class="w3-half">
                <label>Recibo total</label>
                <input id="recibototal" class="form-control" type="number" name="recibototal" required>
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