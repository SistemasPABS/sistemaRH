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
$tipoperiodo=$_POST['tipoperiodo'];
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;

        
//se cuenta la cantidad de personas recibidas        
foreach($cp AS $p) {
    //condicion para el foreach
    $p=$p++;
    //este es el contador perron
    $cantpersonas2=$cantpersonas2+1;
}

//se compara la cantidad de personas recibidas con la cantidad de personas enviadas
//si el numero es igual se inicia el proceso de generacion de nomina
if ($cantpersonas == $cantpersonas2 ){
    //se consulta fecha inicio y fecha fin
    $queryfechainiciofin = "select fecha_inicio, fecha_final from periodos where idperiodo = $idperiodo ";
    $result = pg_query($conexion,$queryfechainiciofin);
    //echo $queryfechainiciofin;
    $mostrar = pg_fetch_array($result);
    $fechainicio = $mostrar['fecha_inicio'];
    $fechafinal = $mostrar['fecha_final'];
    
    
    //COMIENZA FOREACH PARA GUARDAR TEMPORALES COMISIONES 
    foreach($cp as $p)
    {
            $coid=$_POST[$p.'comision'];
            if($coid != NULL){
                
               $cantidadcom=$_POST[$p.'cantidadcom'];
                $observacionescom=$_POST[$p.'observacionescom'];

                $largo= count($coid);

                for($i=0; $i < $largo; $i++){
                    $sql="INSERT into tmp_comnom (co_id,persona_id,co_cantidad,co_observaciones,pc,fecha_inicio,fecha_fin,us_id,plaza_id) values ($coid[$i], $p, $cantidadcom[$i], '$observacionescom[$i]','$pc','$fechainicio','$fechafinal',$us_id,$plaza)";
                    //echo $sql;
                    $result= pg_query($conexion,$sql) or die("Error insertando tmp_comisiones". pg_last_error());
                } 
            }
                
              
        
    }//TERMINA FOREACH PARA GUARDAR COMISIONES temporales
    
    
    //COMIENZA FOREACH PARA GUARDAR TEMPORALES PERCEPCIONES
    foreach ($cp as $p){
            $perid = $_POST[$p.'per'];//select id tipo percepcion
            
           if($perid != NULL){
               $monto = $_POST[$p.'cantidadper'];//cantidad con el tipo se juntan y lo unico que varia es el id de la persona
               $observaciones = $_POST[$p.'motivoper']; //la observacion es identificada por el id de la persona 

                $largo= count($perid);

                for($i=0; $i < $largo; $i++){
                     $sql="INSERT into tmp_percepciones (us_id,persona_id,tp_id,tp_monto,tmp_observaciones,pc,fecha_inicio,fecha_fin,plaza_id) values ($us_id, $p,$perid[$i],$monto[$i],'$observaciones[$i]','$pc','$fechainicio','$fechafinal',$plaza)";
                     //echo $sql;
                     $result= pg_query($conexion,$sql) or die("Error insertando tmp_percepciones". pg_last_error());
                }
            
            }
        
    }//TERMINA FOREACH PARA GUARDAR PERCEPCIONES temporales
    
    
    //comienza foreach para guardar deducciones temporales
    foreach ($cp as $p){
        
            $dedid = $_POST[$p.'ded'];//select id tipo percepcion
        if($deid != NULL){
            $monto = $_POST[$p.'cantidadded'];//cantidad con el tipo se juntan y lo unico que varia es el id de la persona
            $observaciones = $_POST[$p.'motivoded']; //la observacion es identificada por el id de la persona 

                $largo= count($dedid);

                for($i=0; $i < $largo; $i++){
                    $sql="INSERT into tmp_deducciones (us_id,persona_id,td_id,td_monto,td_observaciones,pc,fecha_inicio,fecha_fin,plaza_id) values ($us_id, $p,$dedid[$i],$monto[$i],'$observaciones[$i]','$pc','$fechainicio','$fechafinal',$plaza)";
                    //echo $sql;
                    $result= pg_query($conexion,$sql) or die("Error insertando tmp_deducciones". pg_last_error());
                } 
        }
            
       
    }//TERMINA FOREACH PARA GUARDAR deducciones en las tablas temporales
    
   
    
/////////////////////////////SE OBTIENEN TOTALES PARA INGRESAR EN LA NOMINA ///////////////////////////   
    
   
$totalnomina=0;  
foreach ($cp AS $p){//AQUI SE INICIA FOREACH PARA SACAR LOS TOTALES DE COMISIONES, PERCEPCIONES 
//Y DEDUCCIONES POR MONO
        
     
   //inicia proceso para obtener el monto total de la suma de comisiones por persona
    $querycomisiones = "SELECT * from tmp_comnom WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p ";
    $resultsuma = pg_query($conexion,$querycomisiones) or die ('Error al consultar las comisiones');
    $mostrarsuma = pg_fetch_array($resultsuma);
    $montosumacomisionespersona= 0;
    do{
    $montosumacomisionespersona=$montosumacomisionespersona+$mostrarsuma['co_cantidad'];    
    }while ($mostrarsuma = pg_fetch_array($resultsuma));

   //inicia proceso para obtener el monto total de la suma de percepciones por persona
    $querypercepciones = "SELECT * from tmp_percepciones WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p ";
    $resultsuma = pg_query($conexion,$querypercepciones) or die ('Error al consultar percepciones');
    $mostrarsuma = pg_fetch_array($resultsuma);
    $montosumapercepcionespersona= 0;
    do{
    $montosumapercepcionespersona=$montosumacomisionespersona+$mostrarsuma['tp_monto'];    
    }while ($mostrarsuma = pg_fetch_array($resultsuma));
    
    //inicia proceso para obtener el monto total de la suma de deducciones por persona
    $querydeducciones = "SELECT * from tmp_deducciones WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p ";
    $resultsuma = pg_query($conexion,$querydeducciones) or die ('Error al consultar deducciones');
    $mostrarsuma = pg_fetch_array($resultsuma);
    $montosumadeduccionespersona= 0;
    do{
    $montosumadeduccionespersona=$montosumadeduccionespersona+$mostrarsuma['td_monto'];    
    }while ($mostrarsuma = pg_fetch_array($resultsuma));
     
            
    //se obtiene el neto de la persona
    $neto=$montosumacomisionespersona + $montosumapercepcionespersona - $montosumadeduccionespersona;//tododesmadredesumasyrestasdelostemporales
    $totalnomina=$totalnomina+$neto;
    
}/*AQUI SE TERMINA EL FOR EACH DE LA SUMA DE PERCEPCIONES Y COMISIONES Y RESTA DE LAS DEDUCCIONES
POR MONO */

//Se termina la insercion de la nomina y se genera el ID de nomina
$insertarnomina = "insert into nomina (fecha_inicio,fecha_fin,nom_total,nom_autorizada,plaza_id,sal_tipo_id,fechageneracion,horageneracion,us_id,pc) values ('$fechainicio','$fechafinal',$totalnomina,'false',$plaza,$tipoperiodo,'$fecha','$hora',$us_id,'$pc')";
$result = pg_query($conexion,$insertarnomina) or die ('Error al insertar nomina');
$mostrar = pg_fetch_array($result);



//Empieza proceso para el vaciado de informacion a las tablas chidas
$querynomina="SELECT * from nomina where us_id = $us_id and pc = '$pc' and fecha_inicio='$fechainicio'and fecha_fin = '$fechafinal' and plaza_id = $plaza and fechageneracion = '$fecha'";
$result= pg_query($conexion,$querynomina);
$mostrar= pg_fetch_array($result);
$nominaid=$mostrar['nom_id'];



///////******** AQUI EMPIEZA EL VACIADO A LA TABLA CHIDA DE LAS COMISIONES*******/////
$selecttmpcomnom = "SELECT * from tmp_comnom where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
$result = pg_query($conexion,$selecttmpcomnom);
$campostmpcomnom = pg_fetch_array($result);
    if($campostmpcomnom != NULL){
        do{    

            $insertcomnom = "INSERT into comnom (co_id,persona_id,co_cantidad,co_observaciones,fecha_inicio,fecha_fin,us_id,nom_id,fecha,hora,pc) values (".$campostmpcomnom['co_id'].",".$campostmpcomnom['persona_id'].",".$campostmpcomnom['co_cantidad'].",'".$campostmpcomnom['co_observaciones']."','".$campostmpcomnom['fecha_inicio']."','".$campostmpcomnom['fecha_fin']."',".$campostmpcomnom['us_id'].",$nominaid,'$fecha','$hora','$pc');";
            $resultinsertcomnom=pg_query($conexion,$insertcomnom) or die ('ERROR AL INSERTAR EN LA TABLA CHIDA DE LAS COMISIONES');
            //echo $insertcomnom;

        }while($campostmpcomnom = pg_fetch_array($result));
    }
    
    
//////////////*****AQUI TERMINA EL VACIADO A LA TABLA CHIDA DE LAS COMISIONES*********/////


/////////******** AQUI EMPIEZA EL VACIADO A LA TABLA CHIDA DE LAS PERCEPCIONES*******/////
$selecttmp_percepciones = "SELECT * from tmp_percepciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
$result = pg_query($conexion,$selecttmp_percepciones);
$campostmppercepciones = pg_fetch_array($result);
    if($campostmppercepciones != NULL){
        
        do{    
      
           $insertpercepciones = "INSERT into percepciones (nom_id,us_id,fecha,hora,persona_id,tp_id,tp_monto,tmp_observaciones,fecha_inicio,fecha_fin,pc) values ($nominaid,$us_id,'$fecha','$hora',".$campostmppercepciones['persona_id'].",".$campostmppercepciones['tp_id'].",".$campostmppercepciones['tp_monto'].",'".$campostmppercepciones['tmp_observaciones']."','".$campostmppercepciones['fecha_inicio']."','".$campostmppercepciones['fecha_fin']."','$pc');";
           $resultinsertpercepciones=pg_query($conexion,$insertpercepciones) or die ('ERROR AL INSERTAR EN LA TABLA CHIDA DE LAS PERCEPCIONES');
           //echo $insertpercepciones;  
            
        }while($campostmppercepciones = pg_fetch_array($result));
//    
    }
   
////////////////*****AQUI TERMINA EL VACIADO A LA TABLA CHIDA DE LAS PERCEPCIONES*********/////

    
    
/////////******** AQUI EMPIEZA EL VACIADO A LA TABLA CHIDA DE LAS DEDUCCIONES*******/////
$selecttmp_deducciones = "SELECT * from tmp_deducciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
$result = pg_query($conexion,$selecttmp_deducciones);
$campostmpdeducciones = pg_fetch_array($result);
    if($campostmpdeducciones != NULL){
        do{    
            $insertdeducciones = "INSERT into deducciones (nom_id,us_id,fecha,hora,persona_id,td_id,td_monto,td_observaciones,fecha_inicio,fecha_fin,pc) values ($nominaid,$us_id,'$fecha','$hora',".$campostmpdeducciones['persona_id'].",".$campostmpdeducciones['td_id'].",".$campostmpdeducciones['td_monto'].",'".$campostmpdeducciones['td_observaciones']."','".$campostmpdeducciones['fecha_inicio']."','".$campostmpdeducciones['fecha_fin']."','$pc');";
            $resultinsertdeducciones=pg_query($conexion,$insertdeducciones) or die ('ERROR AL INSERTAR EN LA TABLA CHIDA DE LAS DEDUCCIONES');
            //echo $insertdeducciones;
        }while($campostmpdeducciones = pg_fetch_array($result));
    }
   

////////////////*****AQUI TERMINA EL VACIADO A LA TABLA CHIDA DE LAS COMISIONES*********/////   


    
    
 /////////*** EMPIEZA PROCESO PARA EL BORRADO DE LAS TABLAS TEMPORALES ****************///
  

  
  
  
//  *********** AQUI EMPIEZA EL BORRADO DE LA TABLA TEMPORAL DE COMISIONES *******   //
$selecttmpcomnom = "SELECT count(*) as cuentatmpcomnom from tmp_comnom where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
//echo $selecttmpcomnom;
$result = pg_query($conexion,$selecttmpcomnom);
$valorarreglotmpcomnom = pg_fetch_array($result);
 
  
$selectcomnom = "SELECT count (*) as cuentacomnom from comnom where us_id = $us_id and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id=$nominaid and pc = '$pc'";
//echo $selectcomnom;
$result = pg_query($conexion,$selectcomnom);
$valorarreglocomnom = pg_fetch_array($result);




 //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($valorarreglotmpcomnom['cuentatmpcomnom']==$valorarreglocomnom['cuentacomnom']){

      $borradotmpcomnom="DELETE from tmp_comnom WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
      //echo $borradotmpcomnom;
       $result = pg_query($conexion,$borradotmpcomnom) or die ("Verifica la sentencia SQL". pg_last_error());

    }else{
        echo 'No son iguales';
    } 


//  *********** AQUI TERMINA EL BORRADO DE LA TABLA TEMPORAL DE COMISIONES *******   //








//  *********** AQUI EMPIEZA EL BORRADO DE LA TABLA TEMPORAL DE PERCEPCIONES *******   //
$selecttmp_percepciones = "SELECT count(*) as cuentatmppercepciones from tmp_percepciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
//echo $selecttmp_percepciones;
$result = pg_query($conexion,$selecttmp_percepciones);
$campostmppercepciones = pg_fetch_array($result);

$selectpercepciones = "SELECT count(*) as cuentapercepciones from percepciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id = $nominaid";
//echo $selectpercepciones;
$result = pg_query($conexion,$selectpercepciones);
$campospercepciones = pg_fetch_array($result);


// SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmppercepciones['cuentatmppercepciones']==$campospercepciones['cuentapercepciones']){

      $borradotmp_percepciones="DELETE from tmp_percepciones WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
      //echo $borradotmpcomnom;
      $result = pg_query($conexion,$borradotmp_percepciones) or die ("Verifica la sentencia SQL". pg_last_error());

    }else{
        echo 'No son iguales';
    } 

//  *********** AQUI TERMINA EL BORRADO DE LA TABLA TEMPORAL DE PERCEPCIONES *******   //




//  *********** AQUI EMPIEZA EL BORRADO DE LA TABLA TEMPORAL DE DEDUCCIONES *******   //
$selecttmp_deducciones = "SELECT count(*) as cuentatmpdeducciones from tmp_deducciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
$result = pg_query($conexion,$selecttmp_deducciones);
$campostmpdeducciones = pg_fetch_array($result);

$selectdeducciones = "SELECT count(*) as cuentadeducciones from deducciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id = $nominaid";
$result = pg_query($conexion,$selectdeducciones);
$camposdeducciones = pg_fetch_array($result);


 //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmpdeducciones['cuentatmpdeducciones']==$camposdeducciones['cuentadeducciones']){

      $borradotmp_deducciones="DELETE from tmp_deducciones WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
      //echo $borradotmpcomnom;
      $result = pg_query($conexion,$borradotmp_deducciones) or die ("Verifica la sentencia SQL". pg_last_error());

    }else{
        echo 'No son iguales';
    } 

//  *********** AQUI TERMINA EL BORRADO DE LA TABLA TEMPORAL DE DEDUCCIONES *******   //
   
    
    
//Se termina el proceso para el vaciado de informacion a las tablas chidas
    
    
    //Aqui va el letrero de que se genero la nomina con exito y el id de la nomina
    $letreritosuccesfully.='<div>
                                Se genero tu nomina folio: '.$nominaid.' con exito
                            </div>';
    echo $letreritosuccesfully;
    //mandar el correo a los usuarios de los que tienen el permiso de autorizar la nomina sobre esa plaza
    

}//SE TERMINA EL PROCESO DE GENERACION DE NOMINA



















































//░░░░░░░░░░▓▓▓███████████████████████▓▓▓░░░░░░░░░░░
//░░░░░░░░░▓▓▓░█░░░░░░░░▓░░░░░▓░░░░░░░░█░▓▓▓░░░░░░░░░
//░░░░░░░▓▓▓░██░░░░░░░░▓░░░░░░░▓░░░░░░░░██░▓▓▓░░░░░░░
//░░░░░░░▓░░█░░░░░░░░░▓▓░░░░░░░▓▓░░░░░░░░░█░░▓░░░░░░░
//░░░░░░▓░░█░░░░░░░░░▓▓░░░░░░░░░▓▓░░░░░░░░░█░░▓░░░░░░
//░░░░░▓▓▓█░░░░░░░░░▓▓░░░░░░░░░░░▓▓░░░░░░░░░█▓▓▓░░░░░
//░░░░░▓░░█░░░░░░░░▓▓▓░░░░░░░░░░░▓▓▓░░░░░░░░█░░▓░░░░░
//░░░░░▓░█████████████████████████████████████░▓░░░░░
//░░░░▓░██░█░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░█░██░▓░░░░
//░░░░▓░░█░█░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░█░█░░▓░░░░
//░░░░▓░░█░█░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░█░█░░▓░░░░
//░░░░▓█░█▓░█░░░░░MADE BY: JAIME░░░░░░░░░░░█░▓█░█▓░░░░
//░░░▓░██░░░█░░░░░░░░Y OTROS░░░░░░░░░░░░░░░█░░░██░▓░░░
//░░░▓█░█░░░░█░░░░░░░░░░░░░░░░░░░░░░░░░░░█░░░░█░█▓░░░
//░░░▓█░█░░░░░█░░░░░░░░░░░░░░░░░░░░░░░░░█░░░░░█░█▓░░░
//░░░░▓█░▓▓░░░░█░░░░░░░░▓▓▓▓▓▓▓░░░░░░░░█░░░░▓▓░█▓░░░░
//░░░░░░█░░▓░░░░▓█████████████████████▓░░░░▓░░█░░░░░░
//░░░░░░░█▓▓▓░░░░░░░░█░░▓▓▓▓▓▓▓░░█░░░░░░░░▓▓▓█░░░░░░░
//░░░░░░░░░█▓▓▓░░░░░░▓█░░░░░░░░░█▓░░░░░░▓▓▓█░░░░░░░░░
//░░░░░░░░░░░█▓▓░░▓▓▓░█░░░░░░░░░█░▓▓▓░░▓▓█░░░░░░░░░░░
//░░░░░░░░░░░░░█▓▓░░░░█░░░░░░░░░█░░░░▓▓█░░░░░░░░░░░░░
//░░░░░░░░░░░░░░░█░░░░█░░░░░░░░░█░░░░█░░░░░░░░░░░░░░░
//░░░░░░░░░░░░░░░░██████▓▓▓▓▓▓▓██████░
?>