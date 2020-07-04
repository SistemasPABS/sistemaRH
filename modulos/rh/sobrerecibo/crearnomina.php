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
$empid=$_POST['empid'];
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
    
    
    //////////////////////////////////////////////////////////////////////////////////
    ////////////////////SE GENERAN LAS TABLAS TEMPORALES//////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    
    //COMIENZA FOREACH PARA GUARDAR TEMPORALES SUELDO 
    foreach($cp as $p){
        $psueldo=$_POST[$p.'sueldo'];
        $cantidadsueldo=$_POST[$p.'cantidadsueldo'];
        $observacionessueldo=$_POST[$p.'observacionessueldo'];
        $largo = count($psueldo);
        for($i=0; $i < $largo; $i++){
            $sql="INSERT into tmp_sueldos_nomina (us_id,persona_id,sal_monto_con,tmp_observaciones,pc,fecha_inicio,fecha_fin,plaza_id) values ($us_id, $p, $cantidadsueldo[$i],'$observacionessueldo[$i]','$pc','$fechainicio','$fechafinal',$plaza)";
            $result= pg_query($conexion,$sql) or die("Error insertando tmp_comisiones - ". pg_last_error());
        }
    }
    
    //COMIENZA FOREACH PARA GUARDAR TEMPORALES COMISIONES 
    foreach($cp as $p){
        $coid=$_POST[$p.'comision'];
        if($coid != NULL){
           $cantidadcom=$_POST[$p.'cantidadcom'];
            $observacionescom=$_POST[$p.'observacionescom'];

            $largo= count($coid);

            for($i=0; $i < $largo; $i++){
                $sql="INSERT into tmp_comnom (co_id,persona_id,co_cantidad,co_observaciones,pc,fecha_inicio,fecha_fin,us_id,plaza_id) values ($coid[$i], $p, $cantidadcom[$i], '$observacionescom[$i]','$pc','$fechainicio','$fechafinal',$us_id,$plaza)";
                //echo $sql;
                $result= pg_query($conexion,$sql) or die("Error insertando tmp_comisiones - ". pg_last_error());
            } 
        }
    }
    
    
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
    }
    
    
    //comienza foreach para guardar deducciones temporales
    foreach ($cp as $p){
        $dedid = $_POST[$p.'ded'];//select id tipo percepcion
        if($dedid != NULL){
        $monto = $_POST[$p.'cantidadded'];//cantidad con el tipo se juntan y lo unico que varia es el id de la persona
        $observaciones = $_POST[$p.'motivoded']; //la observacion es identificada por el id de la persona 

            $largo= count($dedid);

            for($i=0; $i < $largo; $i++){
                $sql="INSERT into tmp_deducciones (us_id,persona_id,td_id,td_monto,td_observaciones,pc,fecha_inicio,fecha_fin,plaza_id) values ($us_id, $p,$dedid[$i],$monto[$i],'$observaciones[$i]','$pc','$fechainicio','$fechafinal',$plaza)";
                //echo $sql;
                $result= pg_query($conexion,$sql) or die("Error insertando tmp_deducciones". pg_last_error());
            } 
        }
    }
    
   
    //////////////////////////////////////////////////////////////////////////////////
    ////SE OBTIENEN LOS TOTALES POR PERSONA PARA SUMARLO AL TOTAL DE LA NOMINA ///////
    //////////////////////////////////////////////////////////////////////////////////
    
    
    $totalnomina=0;  
    foreach ($cp AS $p){

        //Consulta para obtener el sueldo de la persona 
        $querysueldo = "SELECT * from tmp_sueldos_nomina WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p";
        $resultsueldo = pg_query($conexion,$querysueldo) or die ('Error al consultar los sueldos');
        $mostrarsueldo = pg_fetch_array($resultsueldo);
        $montosueldo = $mostrarsueldo['sal_monto_con'];

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
        $neto=$montosueldo + $montosumacomisionespersona + $montosumapercepcionespersona - $montosumadeduccionespersona;//tododesmadredesumasyrestasdelostemporales
        $totalnomina=$totalnomina+$neto;
    }


    //////////////////////////////////////////////////////////////////////////////////
    ////SE GENERA LA NOMINA EN LA TABLA NOMINA Y DESPUES SE CONSULTA//////////////////
    //////////////////////////////////////////////////////////////////////////////////

    //Se genera ID de la nomina
    $insertarnomina = "insert into nomina (fecha_inicio,fecha_fin,nom_total,nom_autorizada,plaza_id,sal_tipo_id,fechageneracion,horageneracion,us_id,pc) values ('$fechainicio','$fechafinal',$totalnomina,'false',$plaza,$tipoperiodo,'$fecha','$hora',$us_id,'$pc')";
    $result = pg_query($conexion,$insertarnomina) or die ('Error al insertar nomina');

    //se consulta la nomina generada
    $querynomina="SELECT * from nomina where us_id = $us_id and pc = '$pc' and fecha_inicio='$fechainicio'and fecha_fin = '$fechafinal' and plaza_id = $plaza and fechageneracion = '$fecha' ORDER BY nom_id DESC;";
    $result= pg_query($conexion,$querynomina);
    $mostrar= pg_fetch_array($result);
    $nominaid=$mostrar['nom_id'];

    
    //////////////////////////////////////////////////////////////////////////////////
    ////COMIENZA EL VOLCADO DE LA INFORMACION DE LAS TABLAS TEMPORALES A LAS//////////
    /////////////////////HISTORICAS DEL PROCESO DE LA NOMINA//////////////////////////

    

    //VOLCADO A LA TABLA HISTORICA DE BASE NOMINA
    $selectbn = "select * from tmp_base_nom where us_id = $us_id and fecha = '$fecha' and plaza_id  = $plaza and emp_id = $empid and sal_tipo_id = $tipoperiodo and pc = '$pc';";
    $resultbn = pg_query($conexion,$selectbn);
    $rowbn = pg_fetch_array($resultbn);
    if($rowbn != NULL){
        do{    
            $sqlibn = "INSERT into base_nom(nom_id,us_id,fecha,hora,plaza_id,num_ventas,venta_directa,cobros,saldo,cobros_per_ant,observaciones,emp_id,sal_tipo_id,fecha_inicio,fecha_fin,pc)
                       values ($nominaid,".$rowbn['us_id'].",'".$rowbn['fecha']."','".$rowbn['hora']."',".$rowbn['plaza_id'].",".$rowbn['num_ventas'].",".$rowbn['venta_directa'].",".$rowbn['cobros'].",".$rowbn['saldo'].",".$rowbn['cobros_per_ant'].",'".$rowbn['observaciones']."',".$rowbn['emp_id'].",".$rowbn['sal_tipo_id'].",'".$rowbn['fecha_inicio']."','".$rowbn['fecha_fin']."','".$rowbn['pc']."');";
            $resultibn=pg_query($conexion,$sqlibn) or die ('ERROR ibn:'. pg_last_error());
            //echo $insertcomnom;
        }while($rowbn = pg_fetch_array($resultbn));
    }

    //VOLCADO A LA TABLA HISTORIA DE LOS SUELDOS
    $selectsueldos = "SELECT * FROM tmp_sueldos_nomina WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
    $resultselectsueldos = pg_query($conexion,$selectsueldos);
    $mostrarresultsueldos = pg_fetch_array($resultselectsueldos);
    if($mostrarresultsueldos != NULL){
        do{
            $sqlinsertsueldosnomina = "INSERT into sueldos_nomina (nom_id,us_id,persona_id,sal_monto_con,tmp_observaciones,pc,fecha_inicio,fecha_fin,plaza_id)
                                       values ($nominaid,".$mostrarresultsueldos['us_id'].",".$mostrarresultsueldos['persona_id'].",".$mostrarresultsueldos['sal_monto_con'].",'".$mostrarresultsueldos['tmp_observaciones']."','".$mostrarresultsueldos['pc']."','".$mostrarresultsueldos['fecha_inicio']."','".$mostrarresultsueldos['fecha_fin']."',".$mostrarresultsueldos['plaza_id'].");";
            $resultinsertsueldosnomina =pg_query($conexion,$sqlinsertsueldosnomina) or die ('Error Insertando Sueldos Nomina: '. pg_last_error());
        }while($mostrarresultsueldos =  pg_fetch_array($resultselectsueldos));
    } 
    
    //VOLCADO A LA TABLA HISTORICA DE LAS COMISIONES
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

    //VOLCADO A LA TABLA HISTORICA DE LAS PERCEPCIONES
    $selecttmp_percepciones = "SELECT * from tmp_percepciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
    $result = pg_query($conexion,$selecttmp_percepciones);
    $campostmppercepciones = pg_fetch_array($result);
    if($campostmppercepciones != NULL){
        do{    
           $insertpercepciones = "INSERT into percepciones (nom_id,us_id,fecha,hora,persona_id,tp_id,tp_monto,tmp_observaciones,fecha_inicio,fecha_fin,pc) values ($nominaid,$us_id,'$fecha','$hora',".$campostmppercepciones['persona_id'].",".$campostmppercepciones['tp_id'].",".$campostmppercepciones['tp_monto'].",'".$campostmppercepciones['tmp_observaciones']."','".$campostmppercepciones['fecha_inicio']."','".$campostmppercepciones['fecha_fin']."','$pc');";
           $resultinsertpercepciones=pg_query($conexion,$insertpercepciones) or die ('ERROR AL INSERTAR EN LA TABLA CHIDA DE LAS PERCEPCIONES');
           //echo $insertpercepciones;  
        }while($campostmppercepciones = pg_fetch_array($result));
    }
   
    //VOLCADO A LA TABLA HISTORICA DE LAS DEDUCCIONES
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

   
//    //////////////////////////////////////////////////////////////////////////////////
//    ////COMIENZA EL PROCESO PARA EL BORRADO DE LAS TABLAS TEMPORALES//////////////////
//    //////////////////////////////////////////////////////////////////////////////////
//  
//    
//    //se obtiene la cantidad de datos en la tabla temporal de base de nomina
    $selecttmpbasenom = "SELECT count(*) as cuentatmpbasenom from tmp_base_nom where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
    $selecttmpbasenom;
    $result = pg_query($conexion,$selecttmpbasenom);
    $valorarreglotmpbasenom = pg_fetch_array($result);

    //se obtiene la cantidad de datos en la tabla historico de base de nomina
    $selectbasenom = "SELECT count (*) as cuentabasenom from base_nom where us_id = $us_id and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id=$nominaid and pc = '$pc'";
    //echo $selectbasenom;
    $result = pg_query($conexion,$selectbasenom);
    $valorarreglobasenom = pg_fetch_array($result);
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($valorarreglotmpbasenom['cuentatmpbasenom']==$valorarreglobasenom['cuentabasenom']){
       $borradotmpbasenom="DELETE from tmp_base_nom WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmpbasenom) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL BASE NOMINA ';
    } 
//

    //se obtiene la cantidad de percepciones en la tabla tmp para el peiodo
    $selecttmp_comnom = "SELECT count(*) as cuentatmpcomnom from tmp_comnom where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
    //echo $selecttmp_percepciones;
    $result = pg_query($conexion,$selecttmp_comnom);
    $campostmp_comnom = pg_fetch_array($result);
    //se obtiene la cantidad de percepciones en la tabla historico para el peiodo
    $selectcomnom = "SELECT count(*) as cuentacomnom from comnom where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id = $nominaid";
    //echo $selectpercepciones;
    $result = pg_query($conexion,$selectcomnom);
    $camposcomnom = pg_fetch_array($result);
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmp_comnom['cuentatmpcomnom']==$camposcomnom['cuentacomnom']){
        $borradotmp_comnom="DELETE from tmp_comnom WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmp_comnom) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL COMISIONES';
    } 
//

    //se obtiene la cantidad de percepciones en la tabla tmp para el peiodo
    $selecttmp_percepciones = "SELECT count(*) as cuentatmppercepciones from tmp_percepciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
    //echo $selecttmp_percepciones;
    $result = pg_query($conexion,$selecttmp_percepciones);
    $campostmppercepciones = pg_fetch_array($result);
    //se obtiene la cantidad de percepciones en la tabla historico para el peiodo
    $selectpercepciones = "SELECT count(*) as cuentapercepciones from percepciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id = $nominaid";
    //echo $selectpercepciones;
    $result = pg_query($conexion,$selectpercepciones);
    $campospercepciones = pg_fetch_array($result);
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmppercepciones['cuentatmppercepciones']==$campospercepciones['cuentapercepciones']){
        $borradotmp_percepciones="DELETE from tmp_percepciones WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmp_percepciones) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL PERCEPCIONES';
    } 
//
//    
//    //se obtiene la cantidad de deducciones en la tabla tmp para el peiodo
    $selecttmp_deducciones = "SELECT count(*) as cuentatmpdeducciones from tmp_deducciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
    $result = pg_query($conexion,$selecttmp_deducciones);
    $campostmpdeducciones = pg_fetch_array($result);
    //se obtiene la cantidad de deducciones en la tabla historico para el peiodo
    $selectdeducciones = "SELECT count(*) as cuentadeducciones from deducciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id = $nominaid";
    $result = pg_query($conexion,$selectdeducciones);
    $camposdeducciones = pg_fetch_array($result);
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmpdeducciones['cuentatmpdeducciones']==$camposdeducciones['cuentadeducciones']){
        $borradotmp_deducciones="DELETE from tmp_deducciones WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmp_deducciones) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL DEDUCCIONES';
    } 

    
    //////////////////////////////////////////////////////////////////////////////////
    ////SE ENVIA EL MENSAJE DE NOMINA GENERADA Y SE ENTREGA EL FOLIO//////////////////
    //////////////////////////////////////////////////////////////////////////////////
    
    
    $letreritosuccesfully.='<div>
                                Nomina generada con exito, ID: '.$nominaid.'
                            </div>';
    echo $letreritosuccesfully;
    

}



















































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