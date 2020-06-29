<?php
include_once ('../../../config/conectasql.php');
session_start();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
$plaza=$_POST['plaza'];
$us_id=$_SESSION['us_id'];
$cantpersonas = $_POST['cantpersonas'];
$cantpersonas2=0;
$cp=$_POST['persona'];
$pc=$_POST['pc'];//computadora de donde se hace
$idperiodo=$_POST['idperiodo'];//id de lo seleccionado de fecha inicio y fecha fin 
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;

        
        
foreach($cp AS $p) {
    //no mas pa que no este chingando el foreach
    $p=$p++;
    //este es el contador perron
    $cantpersonas2=$cantpersonas2+1;
}
//echo $cantpersonas .' -VS- '.$cantpersonas2;

//este if me valida que sea la misma cantidad de datos que recibo a los que envio si se cumple, 
//inicia con el proceso.
if ($cantpersonas == $cantpersonas2 ){
    //se consulta fecha inicio y fecha fin
    $queryfechainiciofin = "select fecha_inicio, fecha_final from periodos where idperiodo = $idperiodo ";
    $result = pg_query($conexion,$queryfechainiciofin);
    $mostrar = pg_fetch_array($result);
    $fechainicio = $mostrar['fecha_inicio'];
    $fechafinal = $mostrar['fecha_final'];
    
    
    //COMIENZA FOREACH PARA GUARDAR TEMPORALES COMISIONES 
    foreach($cp as $p)
    {
        $coid=$_POST[$p.'comision'];
        $cantidadcom=$_POST[$p.'cantidadcom'];
        $observacionescom=$_POST[$p.'observacionescom'];
        
        
        $largo= count($coid);
        
        for($i=0; $i < $largo; $i++){
            $sql="INSERT into tmp_comnom (co_id,persona_id,co_cantidad,co_observaciones,pc,fecha_inicio,fecha_fin,us_id,plaza_id) values ($coid[$i], $p, $cantidadcom[$i], $observacionescom[$i],$pc,$fechainicio,$fechafinal,$us_id,$plaza)";
            $result= pg_query($conexion,$sql) or die("Error insertando tmp_comisiones". pg_last_error());
        }
        
    }//TERMINA FOREACH PARA GUARDAR COMISIONES temporales
    
    
    
    
    
    
    //COMIENZA FOREACH PARA GUARDAR TEMPORALES PERCEPCIONES
    foreach ($cp as $p){
        $perid = $_POST[$p.'per'];//select id tipo percepcion
        $monto = $_POST[$p.'cantidadper'];//cantidad con el tipo se juntan y lo unico que varia es el id de la persona
        $observaciones = $_POST[$p.'motivoper']; //la observacion es identificada por el id de la persona 
        
       $largo= count($perid);
        
        for($i=0; $i < $largo; $i++){
            $sql="INSERT into tmp_percepciones (us_id,persona_id,tp_id,tp_monto,tmp_observaciones,pc,fecha_inicio,fecha_fin,plaza_id) values ($us_id, $p,$perid[$i],$monto[$i], $observaciones[$i],$pc,$fechainicio,$fechafinal,$plaza)";
            $result= pg_query($conexion,$sql) or die("Error insertando tmp_percepciones". pg_last_error());
        } 
        
    }//TERMINA FOREACH PARA GUARDAR PERCEPCIONES temporales
    
    
    
    //comienza foreach para guardar deducciones temporales
    
    foreach ($cp as $p){
        
        $dedid = $_POST[$p.'ded'];//select id tipo percepcion
        $monto = $_POST[$p.'cantidadded'];//cantidad con el tipo se juntan y lo unico que varia es el id de la persona
        $observaciones = $_POST[$p.'motivoded']; //la observacion es identificada por el id de la persona 
        
       $largo= count($dedid);
        
        for($i=0; $i < $largo; $i++){
            $sql="INSERT into tmp_deducciones (us_id,persona_id,td_id,td_monto,td_observaciones,pc,fecha_inicio,fecha_fin,plaza_id) values ($us_id, $p,$dedid[$i],$monto[$i], $observaciones[$i],$pc,$fechainicio,$fechafinal,$plaza)";
            $result= pg_query($conexion,$sql) or die("Error insertando tmp_deducciones". pg_last_error());
        } 
        
    }//TERMINA FOREACH PARA GUARDAR deducciones temporales
    
   
    
/////////////////////////////SE OBTIENEN TOTALES PARA INGRESAR EN LA NOMINA ///////////////////////////   
    
   
//$totalnomina=0;  
//foreach ($cp AS $p){//AQUI SE INICIA FOREACH PARA SACAR LOS TOTALES DE COMISIONES, PERCEPCIONES 
////Y DEDUCCIONES POR MONO
//        
//        
//        
//     
//   //inicia proceso para obtener el monto total de la suma de comisiones por persona
//    $querycomisiones = "SELECT * from tmp_comnom WHERE us_id = $us_id and pc = $pc and plaza_id = $plaza and persona_id = $p ";
//    $resultsuma = pg_query($conexion,$querycomisiones) or die ('Error al consultar las comisiones');
//    $mostrarsuma = pg_fetch_array($resultsuma);
//    $montosumacomisionespersona= 0;
//    do{
//    $montosumacomisionespersona=$montosumacomisionespersona+$mostrarsuma['co_cantidad'];    
//    }while ($mostrarsuma = pg_fetch_array($resultsuma));
//
//   //inicia proceso para obtener el monto total de la suma de percepciones por persona
//    $querypercepciones = "SELECT * from tmp_percepciones WHERE us_id = $us_id and pc = $pc and plaza_id = $plaza and persona_id = $p ";
//    $resultsuma = pg_query($conexion,$querypercepciones) or die ('Error al consultar percepciones');
//    $mostrarsuma = pg_fetch_array($resultsuma);
//    $montosumapercepcionespersona= 0;
//    do{
//    $montosumapercepcionespersona=$montosumacomisionespersona+$mostrarsuma['tp_monto'];    
//    }while ($mostrarsuma = pg_fetch_array($resultsuma));
//    
//    //inicia proceso para obtener el monto total de la suma de deducciones por persona
//    $querydeducciones = "SELECT * from tmp_deducciones WHERE us_id = $us_id and pc = $pc and plaza_id = $plaza and persona_id = $p ";
//    $resultsuma = pg_query($conexion,$querydeducciones) or die ('Error al consultar deducciones');
//    $mostrarsuma = pg_fetch_array($resultsuma);
//    $montosumadeduccionespersona= 0;
//    do{
//    $montosumadeduccionespersona=$montosumadeduccionespersona+$mostrarsuma['td_monto'];    
//    }while ($mostrarsuma = pg_fetch_array($resultsuma));
//     
//            
//    //se obtiene el neto de la persona
//    $neto=$montosumacomisionespersona + $montosumapercepcionespersona - $montosumadeduccionespersona;//tododesmadredesumasyrestasdelostemporales
//    $totalnomina=$totalnomina+$neto;
//    
//}/*AQUI SE TERMINA EL FOR EACH DE LA SUMA DE PERCEPCIONES Y COMISIONES Y RESTA DE LAS DEDUCCIONES
//POR MONO */
//
//$insertarnomina = "insert into nomina (fecha_inicio,fecha_fin,nom_total,nom_autorizada,id_plaza) values ($fechainicio,$fechafinal,$totalnomina,0,$plaza)";
//$result = pg_query($conexion,$insertarnomina) or die ('Error al insertar nomina');
//$mostrar = pg_fetch_array($result);

}//SE TERMINA EL PROCESO DE GENERACION DE NOMINA
?>