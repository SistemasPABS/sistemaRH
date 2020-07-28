<?php
require '../../../../config/cookie.php';
?>
<?php
$nombre= base64_decode($_POST['nc']);

include ('../../../../config/conectasql.php');
$persona = new conectasql();
$persona->abre_conexion("0");
$persona->valida_nueva_persona_nombre($nombre);
$msj=$persona->msj;
if($msj == 1){
    echo 'La persona '.$nombre.' ya existe';
}
$persona->cierra_conexion("0");

?>