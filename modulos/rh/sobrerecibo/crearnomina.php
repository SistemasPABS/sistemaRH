<?php
include_once ('../../../config/conectasql.php');
session_start();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
$us_id=$_SESSION['us_id'];
$cantpersonas = $_POST['cantpersonas'];
$cantpersonas2=0;
$cp=$_POST['persona'];
$pc=$_POST['pc'];//computadora de donde se hace
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

    //COMIENZA FOREACH PARA GUARDAR COMISIONES 
    foreach($cp as $p)
    {
        
        $sql="INSERT into tmp_comnom (co_id,persona_id,co_monto,co_porcentaje,co_cantidad,co_observaciones,pc) values ($co_id, $persona_id, $co_monto, $co_porcentaje, $co_cantidad, $co_observaciones)";
        
  
    }//TERMINA FOREACH PARA GUARDAR COMISIONES  
    
    //COMIENZA FOREACH PARA GUARDAR PERCEPCIONES
    foreach ($cp as $p){
        
        $sql ="INSERT into tmp_percepciones (us_id, fecha, hora,persona_id,tp_id,tp_monto,tmp_observaciones,pc,fecha_inicio,fecha_fin) values ($us_id,$fecha,$hora,$tp_id,$tp_monto,$tmp_observaciones,$pc,$fecha_inicio,$fecha_fin)";
        
    }//TERMINA FOREACH PARA GUARDAR PERCEPCIONES
    
    
    //COMIENZA FOREACH PARA GUARDAR PERCEPCIONES
    foreach ($cp as $p){
        
        $sql ="INSERT into tmp_deducciones (us_id,fecha,hora,persona_id,td_id,td_monto,td_observaciones,pc,fecha_inicio,fecha_fin values ($us_id,$fecha,$hora,$persona_id,$td_id,$td_monto,$td_observaciones,$pc,$fecha_inicio,$fecha_fin)";
        
    }//TERMINA FOREACH PARA GUARDAR PERCEPCIONES
    
    foreach ($cp AS $p){//AQUI SE INICIA FOREACH PARA SACAR LOS TOTALES DE COMISIONES, PERCEPCIONES 
        //Y DEDUCCIONES POR MONO
        
        foreach($cp AS $p){//INICIA FOR EACH PARA SACAR LA SUMA DE SUS PERCEPCIONES POR MONO 
            //query para obtener las percepciones
            $querypercepciones = "SELECT * from tmp_percepciones WHERE us_id = $us_id and pc = $pc and id_plaza = $plaza_id and persona_id = $persona_id";
            $resultsuma = pg_query($conexion,$querysuma);
            $mostrarsuma = pg_fetch_array($resultsuma);
            $totalpercepciones = 0;
            $percepciones = $mostrarsuma['tp_monto']; 
            $totalpercepciones = $totalpercepciones + $percepciones;
            echo $totalpercepciones;
            
            
        }//TERMINA FOR EACH PARA SACAR LA SUMA DE SUS PERCEPCIONES POR MONO 
           
        
        foreach($cp as $p){//INICIA FOR EACH PARA SACAR LA SUMA DE SUS DEDUCCIONES POR MONO
            //query para obtener las deducciones
            $querydeducciones = "SELECT * from tmp_deducciones WHERE us_id = $us_id and pc = $pc and id_plaza = $plaza_id and persona_id = $persona_id";
            $resultdeducciones = pg_query($conexion,$querydeducciones);
            $mostrardeducciones = pg_fetch_array($resultdeducciones);
        }//TERMINA FOR EACH PARA SACAR LA SUMA DE SUS DEDUCCIONES POR MONO 
        
        
            
        foreach($cp as $p){//INICIA FOR EACH PARA SACAR LA SUMA DE SUS COMISIONES POR MONO
            $querycomisiones = "SELECT * from tmp_comnom WHERE us_id = $us_id and pc = $pc and id_plaza = $plaza_id and persona_id = $persona_id";
            $resultcomisiones = pg_query($conexion,$querycomisiones);
            $mostrarcomisiones = pg_fetch_array($resultcomisiones);
        }//TERMINA FOR EACH PARA SACAR LA SUMA DE LAS COMISIONES POR MONO   
            

    }/*AQUI SE TERMINA EL FOR EACH DE LA SUMA DE PERCEPCIONES Y COMISIONES Y RESTA DE LAS DEDUCCIONES
    POR MONO */
           
}//AQUI SE TERMINA EL PROCESO GENERAL

?>