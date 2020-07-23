<?php
//echo 'hola';
include_once ('../../../config/conectasql.php');
session_start();
$us_id=$_SESSION['us_id'];
$opc= base64_decode($_POST['opc']);
$perid = base64_decode($_POST['perid']);
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
//echo $opc;

if($opc == 'percepcion'){
    $query="SELECT * from tipos_percepciones";
    $vopc='tp_id';
    $nombre='tp_nombre';
    $equis='per';
}
else{
    $query="SELECT * from tipos_deducciones";
    $vopc='td_id';
    $nombre='td_nombre';
    $equis='ded';
}

$result= pg_query($conexion,$query);
$mostrar= pg_fetch_array($result);

$select .='<select name="'.$perid.$equis.'[]">';
    do{
        $select .='<option value="'.$mostrar[$vopc].'" >'.$mostrar[$nombre].'</option>';
    }while($mostrar= pg_fetch_array($result));
    
$select .='<select>';
$contenidofila .='<td>'.$select.'</td>
                  <td></td>
                  <td></td>
                  <td><input name="'.$perid.'cuantos'.$equis.'[]" type="number" value="0" onkeyup="this.value=Numeros(this.value)" step="0.01"></input></td>
                  <td><input name="'.$perid.'cantidad'.$equis.'[]" type="number" value="0" onkeyup="this.value=Numeros(this.value)" step="0.01"></input></td>
                  <td><input name="'.$perid.'motivo'.$equis.'[]" type="text" value="--" onkeyup="this.value=NumText(this.value)"></input></td>';
echo $contenidofila;
        
?>