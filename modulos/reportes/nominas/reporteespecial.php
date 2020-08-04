<?php 
include_once ('../../../config/cookie.php');
include_once ('../../../config/conectasql.php');
$us_id=$_SESSION['us_id'];
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;

$idnom=base64_decode($_GET['idnom']);//idnom
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=nombre_archivo.xls');
$queryreportearturoescamilla = "SELECT * FROM vw_general_personas_por_nomina_scpd where nom_id_suel = $idnom";
$result = pg_query($conexion,$queryreportearturoescamilla);
$mostrar = pg_fetch_array($result);

do{
    echo'
        <table cellpadding="2" cellspacing="0" width="100%">
            <caption>Reporte detallado - '.$mostrar['nom_id_suel'].'</caption>
            <td>'.$mostrar['nombrecompleto'].'  --- SUELDO ---  '.$mostrar['sal_monto_con'].'</td>
            <tr>
                <th>'.$mostrar['tp_nombre'].'</th>
                <th>'.$mostrar['co_nombre'].'</th>
                <th>'.$mostrar['td_nombre'].'</th>
            </tr>
           <tr>
                <th>'.$mostrar['tp_monto'].'</th>
                <th>'.$mostrar['co_cantidad'].'</th>
                <tr>'.$mostrar['td_monto'].'</tr>
           </tr> 
        </table>';
}while($mostrar = pg_fetch_array($result));   
?>
