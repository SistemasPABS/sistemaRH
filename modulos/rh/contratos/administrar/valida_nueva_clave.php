<?php
require '../../../../config/cookie.php';
?>
<?php
$clave= base64_decode($_POST['cve']);

include ('../../../../config/conectasql.php');
$persona = new conectasql();
$persona->abre_conexion("0");
$persona->valida_nuevo_puesto($clave);
$msj=$persona->msj;
if($msj == 1){
    echo 'La clave '.$clave.' ya esta asignada';
}
$persona->cierra_conexion("0");

?>