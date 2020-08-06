<?php
include_once ('../../../../config/cookie.php');
include_once ('../../../../config/conectasql.php');
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
$fechaperiodo=$_POST['fechaperiodo'];//id de lo seleccionado de fecha inicio y fecha fin 
$tipoperiodo=$_POST['tipoperiodo'];
$empid=$_POST['empid'];
$oficina = $_POST['oficina'];
$cargorrecurrente = $_POST['cargorecurrente'];
$depositoenbanco = $_POST['depositoenbanco'];
$retencionvianomina = $_POST['retencionennomina'];
$robogestor = $_POST['robogestor'];
$extrasolicitudes = $_POST['extrasolicitudes'];
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$nominaid=$_POST['nominaedit'];

        
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
    $queryfechainiciofin = "select fecha_inicio, fecha_final from periodos where idperiodo = $fechaperiodo ";
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
        $cantidadsueldo=$_POST[$p.'cantidadsueldo'];
        if($cantidadsueldo != NULL){
            $observacionessueldo=$_POST[$p.'observacionessueldo'];
            $largo = count($cantidadsueldo);
            for($i=0; $i < $largo; $i++){
                $sql="INSERT into tmp_sueldos_nomina (us_id,persona_id,sal_monto_con,tmp_observaciones,pc,fecha_inicio,fecha_fin,plaza_id,fecha,hora) values($us_id, $p, $cantidadsueldo[$i],'$observacionessueldo[$i]','$pc','$fechainicio','$fechafinal',$plaza,'$fecha','$hora')";
                $result= pg_query($conexion,$sql) or die("Error itsn:". pg_last_error());
            }
        }
    }
    
    //COMIENZA FOREACH PARA GUARDAR TEMPORALES COMISIONES 
    foreach($cp as $p){
        $coid=$_POST[$p.'comision'];
        if($coid != NULL){
                if(isset($_POST[$p.'cantidadcom']) && empty($_POST[$p.'cantidadcom'])){
                    $cantidadcom = 0;
                }else{
                    $cantidadcom=$_POST[$p.'cantidadcom'];
                }
                if(isset($_POST[$p.'cuantos']) && empty($_POST[$p.'cuantos'])){
                    $cantidadcompesos = 0;
                }else{
                    $cantidadcompesos=$_POST[$p.'cuantos'];
                }
            $observacionescom=$_POST[$p.'observacionescom'];
            $cuantos = $_POST[$p.'cuantos'];
            $largo= count($coid);

            for($i=0; $i < $largo; $i++){
                $sql="INSERT into tmp_comnom (co_id,persona_id,co_cantidad,co_observaciones,pc,fecha_inicio,fecha_fin,us_id,plaza_id,co_cuantos,fecha,hora) values($coid[$i], $p, $cantidadcom[$i], '$observacionescom[$i]','$pc','$fechainicio','$fechafinal',$us_id,$plaza,$cuantos[$i],'$fecha','$hora')";
                //echo $sql;
                $result= pg_query($conexion,$sql) or die("Error insertando tmp_comisiones - ". pg_last_error());
            } 
        }
    }
    
    
    //COMIENZA FOREACH PARA GUARDAR TEMPORALES PERCEPCIONES
    foreach ($cp as $p){
        $perid = $_POST[$p.'per'];//select id tipo percepcion
        if($perid != NULL){
            if(isset($_POST[$p.'cantidadper']) && empty($_POST[$p.'cantidadper'])){
                $cantidadcom = 0;
            }else{
                $cantidadcom=$_POST[$p.'cantidadper'];
            }
            if(isset($_POST[$p.'cuantosper']) && empty($_POST[$p.'cuantosper'])){
                $cuantos = 0;
            }else{
                $cuantos=$_POST[$p.'cuantosper'];
            }
           $monto = $_POST[$p.'cantidadper'];//cantidad con el tipo se juntan y lo unico que varia es el id de la persona
           $observaciones = $_POST[$p.'motivoper']; //la observacion es identificada por el id de la persona 
           $cuantos = $_POST[$p.'cuantosper']; //cuantos de la percepcion
           $largo= count($perid);

            for($i=0; $i < $largo; $i++){
                 $sql="INSERT into tmp_percepciones (us_id,persona_id,tp_id,tp_monto,tmp_observaciones,pc,fecha_inicio,fecha_fin,plaza_id,tp_cuantos,fecha,hora) values($us_id, $p,$perid[$i],$monto[$i],'$observaciones[$i]','$pc','$fechainicio','$fechafinal',$plaza,$cuantos[$i],'$fecha','$hora')";
                 //echo $sql;
                 $result= pg_query($conexion,$sql) or die("Error insertando tmp_percepciones". pg_last_error());
            }

        }
    }
    
    
    //comienza foreach para guardar deducciones temporales
    foreach ($cp as $p){
        $dedid = $_POST[$p.'ded'];//select id tipo percepcion
        if($dedid != NULL){
            if(isset($_POST[$p.'cantidadded']) && empty($_POST[$p.'cantidadded'])){
                $cantidadcom = 0;
            }else{
                $cantidadcom=$_POST[$p.'cantidadded'];
            }
            if(isset($_POST[$p.'cuantosded']) && empty($_POST[$p.'cuantosded'])){
                $cuantos = 0;
            }else{
                $cuantos=$_POST[$p.'cuantosded'];
            }
        $monto = $_POST[$p.'cantidadded'];//cantidad con el tipo se juntan y lo unico que varia es el id de la persona
        $observaciones = $_POST[$p.'motivoded']; //la observacion es identificada por el id de la persona 
        $cuantos = $_POST[$p.'cuantosded']; //cuantos de la percepcion
            $largo= count($dedid);

            for($i=0; $i < $largo; $i++){
                $sql="INSERT into tmp_deducciones (us_id,persona_id,td_id,td_monto,td_observaciones,pc,fecha_inicio,fecha_fin,plaza_id,td_cuantos,fecha,hora) values ($us_id, $p,$dedid[$i],$monto[$i],'$observaciones[$i]','$pc','$fechainicio','$fechafinal',$plaza,$cuantos[$i],'$fecha','$hora')";
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
        $querysueldo = "SELECT * from tmp_sueldos_nomina WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p and fecha='$fecha' and hora='$hora'";
        $resultsueldo = pg_query($conexion,$querysueldo) or die ('Error al consultar los sueldos');
        $mostrarsueldo = pg_fetch_array($resultsueldo);
        $montosueldo = $mostrarsueldo['sal_monto_con'];

        //inicia proceso para obtener el monto total de la suma de comisiones por persona
        $querycomisiones = "SELECT * from tmp_comnom WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p and fecha='$fecha' and hora='$hora'";
        $resultsuma = pg_query($conexion,$querycomisiones) or die ('Error al consultar las comisiones');
        $mostrarsuma = pg_fetch_array($resultsuma);
        $montosumacomisionespersona= 0;
        do{
            $montosumacomisionespersona=$montosumacomisionespersona+$mostrarsuma['co_cantidad'];    
        }while ($mostrarsuma = pg_fetch_array($resultsuma));

        //inicia proceso para obtener el monto total de la suma de percepciones por persona
        $querypercepciones = "SELECT * from tmp_percepciones WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p and fecha='$fecha' and hora='$hora'";
        $resultsuma = pg_query($conexion,$querypercepciones) or die ('Error al consultar percepciones');
        $mostrarsuma = pg_fetch_array($resultsuma);
        $montosumapercepcionespersona= 0;
        do{
            $montosumapercepcionespersona=$montosumapercepcionespersona+$mostrarsuma['tp_monto'];    
        }while ($mostrarsuma = pg_fetch_array($resultsuma));

        //inicia proceso para obtener el monto total de la suma de deducciones por persona
        $querydeducciones = "SELECT * from tmp_deducciones WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p and fecha='$fecha' and hora='$hora'";
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
    ////SE ACTUALIZA LA NOMINA////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////

    $insertarnomina = "UPDATE nomina SET fecha_inicio = '$fechainicio', fecha_fin = '$fechafinal', nom_total = $totalnomina,nom_autorizada = 'false',plaza_id = $plaza,sal_tipo_id = $tipoperiodo,fechageneracion = '$fecha',horageneracion = '$hora', us_id = $us_id, pc='$pc' WHERE nom_id=$nominaid";
    $result = pg_query($conexion,$insertarnomina) or die ('Error al actualizar nomina'.pg_last_error());

    /*SE HACE LA INSERCION A LA TABLA DE ASISTENCIAS POR CADA MONO*/
    foreach($cp as $p){
        $cantidadasistencias=$_POST[$p.'asistencias'];
        if($cantidadasistencias != NULL){
            $observacionesasistencias =$_POST[$p.'observacionesasistencias'];
            $largo = count($cantidadasistencias);
            for($i=0; $i < $largo; $i++){
                $sql="UPDATE asistencias SET dias = $cantidadasistencias[$i], observaciones = '$observacionesasistencias[$i]' where nom_id = $nominaid and persona_id = $p";
                $result= pg_query($conexion,$sql) or die("Error itsn:". pg_last_error());
            }
        }
    }

    
    //////////////////////////////////////////////////////////////////////////////////
    ////COMIENZA EL VOLCADO DE LA INFORMACION DE LAS TABLAS TEMPORALES A LAS//////////
    /////////////////////HISTORICAS DEL PROCESO DE LA NOMINA//////////////////////////

    

    /*VOLCADO A LA TABLA HISTORICA DE BASE NOMINA*/
    
//    $selectbn = "select * from tmp_base_nom where us_id = $us_id and fecha = '$fecha' and plaza_id  = $plaza and emp_id = $empid and sal_tipo_id = $tipoperiodo and pc = '$pc' and fecha='$fecha' and hora='$hora'" ;
//    $resultbn = pg_query($conexion,$selectbn);
//    $rowbn = pg_fetch_array($resultbn);
//    if($rowbn != NULL){
//        do{    
//            $sqlibn = "INSERT into base_nom(nom_id,us_id,fecha,hora,plaza_id,num_ventas,venta_directa,cobros,saldo,cobros_per_ant,observaciones,emp_id,sal_tipo_id,fecha_inicio,fecha_fin,pc)
//                       values ($nominaid,".$rowbn['us_id'].",'".$rowbn['fecha']."','".$rowbn['hora']."',".$rowbn['plaza_id'].",".$rowbn['num_ventas'].",".$rowbn['venta_directa'].",".$rowbn['cobros'].",".$rowbn['saldo'].",".$rowbn['cobros_per_ant'].",'".$rowbn['observaciones']."',".$rowbn['emp_id'].",".$rowbn['sal_tipo_id'].",'".$rowbn['fecha_inicio']."','".$rowbn['fecha_fin']."','".$rowbn['pc']."');";
//            $resultibn=pg_query($conexion,$sqlibn) or die ('ERROR ibn:'. pg_last_error());
//            //echo $insertcomnom;
//        }while($rowbn = pg_fetch_array($resultbn));
//    }

    //EDICION DE COBRANZA_ADICIONAL
    //INSERCION A LA TABLA DE COBRANZA ADICIONAL 
    $insertcobranzaadicional = "UPDATE cobranza_adicional SET nom_id = $nominaid, oficina = $oficina, cargo_recurrente = $cargorrecurrente, deposito_en_banco = $depositoenbanco, retencion_via_nomina = $retencionvianomina, robo_gestor = $robogestor,extra_solicitudes = $extrasolicitudes WHERE nom_id = $nominaid";
    $resultinsert = pg_query($conexion,$insertcobranzaadicional)or die('Error al actualizar en la tabla de cobranza adicional'. pg_last_error());

    //VOLCADO A LA TABLA HISTORIA DE LOS SUELDOS
    $sqldeletesueldosnomina= "DELETE FROM sueldos_nomina WHERE nom_id_suel = $nominaid";
    $resultdeletesueldosnomina = pg_query($conexion,$sqldeletesueldosnomina) or die ('Error al eliminar el registro anterior de los sueldos de la nomina'.pg_last_error());
    
    $selectsueldos = "SELECT * FROM tmp_sueldos_nomina WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    $resultselectsueldos = pg_query($conexion,$selectsueldos);
    $mostrarresultsueldos = pg_fetch_array($resultselectsueldos);
    if($mostrarresultsueldos != NULL){
        do{
            $sqlinsertsueldosnomina = "INSERT into sueldos_nomina (nom_id_suel,us_id,persona_id,sal_monto_con,tmp_observaciones,pc,fecha_inicio,fecha_fin,plaza_id,fecha,hora)
                                       values ($nominaid,".$mostrarresultsueldos['us_id'].",".$mostrarresultsueldos['persona_id'].",".$mostrarresultsueldos['sal_monto_con'].",'".$mostrarresultsueldos['tmp_observaciones']."','".$mostrarresultsueldos['pc']."','".$mostrarresultsueldos['fecha_inicio']."','".$mostrarresultsueldos['fecha_fin']."',".$mostrarresultsueldos['plaza_id'].",'".$mostrarresultsueldos['fecha']."','".$mostrarresultsueldos['hora']."');";
            $resultinsertsueldosnomina =pg_query($conexion,$sqlinsertsueldosnomina) or die ('Error Insertando Sueldos Nomina: '. pg_last_error());
        }while($mostrarresultsueldos =  pg_fetch_array($resultselectsueldos));
    } 
    
    //VOLCADO A LA TABLA HISTORICA DE LAS COMISIONES
    $sqldeletecomisionesnomina= "DELETE FROM comnom WHERE nom_id_com = $nominaid";
    $resultdeletecomisionesnomina = pg_query($conexion,$sqldeletecomisionesnomina) or die ('Error al eliminar el registro anterior de las comisiones');  
    
    $selecttmpcomnom = "SELECT * from tmp_comnom where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    $result = pg_query($conexion,$selecttmpcomnom);
    $campostmpcomnom = pg_fetch_array($result);
    if($campostmpcomnom != NULL){
        do{    
            $insertcomnom = "INSERT into comnom (co_id,persona_id,co_cantidad,co_observaciones,fecha_inicio,fecha_fin,us_id,nom_id_com,fecha,hora,pc,co_cuantos) values (".$campostmpcomnom['co_id'].",".$campostmpcomnom['persona_id'].",".$campostmpcomnom['co_cantidad'].",'".$campostmpcomnom['co_observaciones']."','".$campostmpcomnom['fecha_inicio']."','".$campostmpcomnom['fecha_fin']."',".$campostmpcomnom['us_id'].",$nominaid,'".$campostmpcomnom['fecha']."','".$campostmpcomnom['hora']."','$pc',".$campostmpcomnom['co_cuantos'].");";
            $resultinsertcomnom=pg_query($conexion,$insertcomnom) or die ('ERROR AL INSERTAR EN LA TABLA CHIDA DE LAS COMISIONES');
            //echo $insertcomnom;
        }while($campostmpcomnom = pg_fetch_array($result));
    }

    //VOLCADO A LA TABLA HISTORICA DE LAS PERCEPCIONES
    $sqldeletepercepciones= "DELETE FROM percepciones WHERE nom_id_per = $nominaid";
    $resultdeletepercepciones = pg_query($conexion,$sqldeletepercepciones) or die ('Error al eliminar el registro anterior de las percepciones');    
    
    $selecttmp_percepciones = "SELECT * from tmp_percepciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    $result = pg_query($conexion,$selecttmp_percepciones);
    $campostmppercepciones = pg_fetch_array($result);
    if($campostmppercepciones != NULL){
        do{    
           $insertpercepciones = "INSERT into percepciones (nom_id_per,us_id,fecha,hora,persona_id,tp_id,tp_monto,tmp_observaciones,fecha_inicio,fecha_fin,pc,tp_cuantos) values ($nominaid,$us_id,'".$campostmppercepciones['fecha']."','".$campostmppercepciones['hora']."',".$campostmppercepciones['persona_id'].",".$campostmppercepciones['tp_id'].",".$campostmppercepciones['tp_monto'].",'".$campostmppercepciones['tmp_observaciones']."','".$campostmppercepciones['fecha_inicio']."','".$campostmppercepciones['fecha_fin']."','$pc',".$campostmppercepciones['tp_cuantos'].");";
           $resultinsertpercepciones=pg_query($conexion,$insertpercepciones) or die ('ERROR AL INSERTAR EN LA TABLA CHIDA DE LAS PERCEPCIONES'.pg_last_error());
           //echo $insertpercepciones;  
        }while($campostmppercepciones = pg_fetch_array($result));
    }
   
    //VOLCADO A LA TABLA HISTORICA DE LAS DEDUCCIONES
    $sqldeletededucciones= "DELETE FROM deducciones WHERE nom_id_ded = $nominaid";
    $resultdeletededucciones = pg_query($conexion,$sqldeletededucciones) or die ('Error al eliminar el registro anterior de las deducciones');
    
    $selecttmp_deducciones = "SELECT * from tmp_deducciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    $result = pg_query($conexion,$selecttmp_deducciones);
    $campostmpdeducciones = pg_fetch_array($result);
    if($campostmpdeducciones != NULL){
        do{    
            $insertdeducciones = "INSERT into deducciones (nom_id_ded,us_id,fecha,hora,persona_id,td_id,td_monto,td_observaciones,fecha_inicio,fecha_fin,pc,td_cuantos) values ($nominaid,$us_id,'".$campostmpdeducciones['fecha']."','".$campostmpdeducciones['hora']."',".$campostmpdeducciones['persona_id'].",".$campostmpdeducciones['td_id'].",".$campostmpdeducciones['td_monto'].",'".$campostmpdeducciones['td_observaciones']."','".$campostmpdeducciones['fecha_inicio']."','".$campostmpdeducciones['fecha_fin']."','$pc',".$campostmpdeducciones['td_cuantos'].");";
            $resultinsertdeducciones=pg_query($conexion,$insertdeducciones) or die ('ERROR AL INSERTAR EN LA TABLA CHIDA DE LAS DEDUCCIONES');
            //echo $insertdeducciones;
        }while($campostmpdeducciones = pg_fetch_array($result));
    }

   
    //////////////////////////////////////////////////////////////////////////////////
    ////COMIENZA EL PROCESO PARA EL BORRADO DE LAS TABLAS TEMPORALES//////////////////
    //////////////////////////////////////////////////////////////////////////////////
  
    
    //se obtiene la cantidad de datos en la tabla temporal de base de nomina
    /*$selecttmpbasenom = "SELECT count(*) as cuentatmpbasenom from tmp_base_nom where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza";
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
    }*/ 
//

    //se obtiene la cantidad de sueldos en la tabla tmp para el periodo
    $selecttmpsueldosnomina = "SELECT count (*) as cuentatmpsueldosnomina from tmp_sueldos_nomina where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    //echo $selecttmpsueldosnomina;
    $resulttmpsueldosnomina = pg_query($conexion,$selecttmpsueldosnomina);
    $campostmpsueldosnomina = pg_fetch_array($resulttmpsueldosnomina);

    //se obtiene la cantidad de sueldos en la tabla historico para el periodo
    $selectsueldosnominahistorico = "SELECT count (*) as cuentasueldosnomina from sueldos_nomina where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and nom_id_suel = $nominaid";
    //echo $selectsueldosnominahistorico;
    $resultsueldosnominahistorico = pg_query($conexion,$selectsueldosnominahistorico);
    $campossueldosnominahistorico = pg_fetch_array($resultsueldosnominahistorico);

    //SE ESTAN COMPARANDO LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR
    if($campostmpsueldosnomina['cuentatmpsueldosnomina'] == $campossueldosnominahistorico['cuentasueldosnomina']){
        $borrado_tmpsueldosnomina="DELETE from tmp_sueldos_nomina WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
        //echo $borrado_tmpsueldosnomina;
        $result = pg_query($conexion,$borrado_tmpsueldosnomina) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'NO SON IGUALES - SUELDOS NOMINA';
    }

    
    //se obtiene la cantidad de comisiones en la tabla tmp para el periodo
    $selecttmp_comnom = "SELECT count(*) as cuentatmpcomnom from tmp_comnom where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    //echo $selecttmp_percepciones;
    $result = pg_query($conexion,$selecttmp_comnom);
    $campostmp_comnom = pg_fetch_array($result);
    
    //se obtiene la cantidad de comisiones en la tabla historico para el periodo
    $selectcomnom = "SELECT count(*) as cuentacomnom from comnom where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id_com = $nominaid ";
    //echo $selectpercepciones;
    $result = pg_query($conexion,$selectcomnom);
    $camposcomnom = pg_fetch_array($result);
    
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmp_comnom['cuentatmpcomnom']==$camposcomnom['cuentacomnom']){
        $borradotmp_comnom="DELETE from tmp_comnom WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmp_comnom) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL COMISIONES';
    } 


    //se obtiene la cantidad de percepciones en la tabla tmp para el peiodo
    $selecttmp_percepciones = "SELECT count(*) as cuentatmppercepciones from tmp_percepciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    //echo $selecttmp_percepciones;
    $result = pg_query($conexion,$selecttmp_percepciones);
    $campostmppercepciones = pg_fetch_array($result);
    
    //se obtiene la cantidad de percepciones en la tabla historico para el peiodo
    $selectpercepciones = "SELECT count(*) as cuentapercepciones from percepciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id_per = $nominaid";
    //echo $selectpercepciones;
    $result = pg_query($conexion,$selectpercepciones);
    
    $campospercepciones = pg_fetch_array($result);
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmppercepciones['cuentatmppercepciones']==$campospercepciones['cuentapercepciones']){
        $borradotmp_percepciones="DELETE from tmp_percepciones WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmp_percepciones) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL PERCEPCIONES';
    } 

    
    //se obtiene la cantidad de deducciones en la tabla tmp para el peiodo
    $selecttmp_deducciones = "SELECT count(*) as cuentatmpdeducciones from tmp_deducciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    $result = pg_query($conexion,$selecttmp_deducciones);
    $campostmpdeducciones = pg_fetch_array($result);
    
    //se obtiene la cantidad de deducciones en la tabla historico para el peiodo
    $selectdeducciones = "SELECT count(*) as cuentadeducciones from deducciones where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id_ded = $nominaid";
    $result = pg_query($conexion,$selectdeducciones);
    $camposdeducciones = pg_fetch_array($result);
    
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmpdeducciones['cuentatmpdeducciones']==$camposdeducciones['cuentadeducciones']){
        $borradotmp_deducciones="DELETE from tmp_deducciones WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmp_deducciones) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL DEDUCCIONES';
    } 

    
    //////////////////////////////////////////////////////////////////////////////////
    ////SE ENVIA EL MENSAJE DE NOMINA GENERADA Y SE ENTREGA EL FOLIO//////////////////
    //////////////////////////////////////////////////////////////////////////////////
    
    
    $letreritosuccesfully.='<head>
                                <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
                                <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
                                <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
                            </head>
                            <body>
                                <div class="container">
                                    <div class="row text-center">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <br><br> <h2 style="color:#0fad00">Nomina editada No:'.$nominaid.'</h2>
                                            <img src="../../../../images/logo.png">
                                            <h3>¡EXITO!</h3>
                                            <p style="font-size:20px;color:#5C5C5C;">Gracias por haber utilizado nuestro sistema de RH para la edición de nomina. Hemos enviado un correo notificando la edicion de la misma y puedan hacer sus observaciones y/o autorizarla.</p>
                                            <a href="../../prenominas/index.php" class="btn btn-success">    OK     </a>
                                            <br><br>
                                        </div>
                                    </div>
                                </div>
                            </body>';
    echo $letreritosuccesfully;

    $deleteedicion = "DELETE from controlador_nomina where idnom = $nominaid";
    $resultdelete=pg_query($conexion,$deleteedicion) or die ('Error al eliminar el block de edicion de nomina'.pg_last_error());
    

}

?>