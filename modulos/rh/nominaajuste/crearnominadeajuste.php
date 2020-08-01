<?php
include_once ('../../../config/cookie.php');
include_once ('../../../config/conectasql.php');
session_start();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
$hbn=$_POST['hbn'];
$us_id=$_SESSION['us_id'];
$cantpersonas = $_POST['cantpersonas'];
$cantpersonas2=0;
$cp=$_POST['persona'];
$pc=$_POST['pc'];//computadora de donde se hace
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$idnom=$_POST['nomid'];
$querynominaoriginal = "SELECT * from nomina WHERE nom_id = $idnom";
//echo $querynominaoriginal;
$resultquerynominaoriginal = pg_query($conexion,$querynominaoriginal);
$mostrar = pg_fetch_array($resultquerynominaoriginal);
$fechainicio = $mostrar['fecha_inicio'];
$fechafinal = $mostrar['fecha_fin'];
$plaza = $_POST['plaza'];
$empid = $_POST['empid'];
$tipoperiodo = $_POST['tipoperiodo'];
    
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
    //se consulta la informacion de la nomina original 
    
    
    //////////////////////////////////////////////////////////////////////////////////
    ////////////////////SE GENERAN LAS TABLAS TEMPORALES//////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    
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
                $sql="INSERT into tmp_comnom_ajuste (co_id,persona_id,co_cantidad,co_observaciones,pc,fecha_inicio,fecha_fin,us_id,plaza_id,co_cuantos,fecha,hora,nom_id) values ($coid[$i], $p, $cantidadcom[$i], '$observacionescom[$i]','$pc','$fechainicio','$fechafinal',$us_id,$plaza,$cuantos[$i],'$fecha','$hora',$idnom)";
                //echo $sql;
            
                $result= pg_query($conexion,$sql) or die("Error insertando tmp_comisiones_ajuste - ". pg_last_error());
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
                 $sql="INSERT into tmp_percepciones_ajuste (us_id,persona_id,tp_id,tp_monto,tmp_observaciones,pc,fecha_inicio,fecha_fin,plaza_id,tp_cuantos,fecha,hora,nom_id) values ($us_id, $p,$perid[$i],$monto[$i],'$observaciones[$i]','$pc','$fechainicio','$fechafinal',$plaza,$cuantos[$i],'$fecha','$hora',$idnom)";
                 //echo $sql;
                 $result= pg_query($conexion,$sql) or die("Error insertando tmp_percepciones_ajustes". pg_last_error());
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
                $sql="INSERT into tmp_deducciones_ajuste (us_id,persona_id,td_id,td_monto,td_observaciones,pc,fecha_inicio,fecha_fin,plaza_id,td_cuantos,fecha,hora,nom_id) values ($us_id, $p,$dedid[$i],$monto[$i],'$observaciones[$i]','$pc','$fechainicio','$fechafinal',$plaza,$cuantos[$i],'$fecha','$hora',$idnom)";
                //echo $sql;
                $result= pg_query($conexion,$sql) or die("Error insertando tmp_deducciones_ajustes". pg_last_error());
            } 
        }
    }
    
   
    //////////////////////////////////////////////////////////////////////////////////
    ////SE OBTIENEN LOS TOTALES POR PERSONA PARA SUMARLO AL TOTAL DE LA NOMINA ///////
    //////////////////////////////////////////////////////////////////////////////////
    
    $totalnomina=0;  
    foreach ($cp AS $p){

        //inicia proceso para obtener el monto total de la suma de comisiones por persona
        $querycomisiones = "SELECT * from tmp_comnom_ajuste WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p and fecha='$fecha' and hora='$hora'";
        $resultsuma = pg_query($conexion,$querycomisiones) or die ('Error al consultar las comisiones de la tabla temporal de comisiones en nomina de ajuste'.pg_last_error());
        $mostrarsuma = pg_fetch_array($resultsuma);
        $montosumacomisionespersona= 0;
        do{
            $montosumacomisionespersona=$montosumacomisionespersona+$mostrarsuma['co_cantidad'];    
        }while ($mostrarsuma = pg_fetch_array($resultsuma));

        //inicia proceso para obtener el monto total de la suma de percepciones por persona
        $querypercepciones = "SELECT * from tmp_percepciones_ajuste WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p and fecha='$fecha' and hora='$hora'";
        $resultsuma = pg_query($conexion,$querypercepciones) or die ('Error al consultar percepciones'.pg_last_error());
        $mostrarsuma = pg_fetch_array($resultsuma);
        $montosumapercepcionespersona= 0;
        do{
            $montosumapercepcionespersona=$montosumapercepcionespersona+$mostrarsuma['tp_monto'];    
        }while ($mostrarsuma = pg_fetch_array($resultsuma));

        //inicia proceso para obtener el monto total de la suma de deducciones por persona
        $querydeducciones = "SELECT * from tmp_deducciones_ajuste WHERE us_id = $us_id and pc = '$pc' and plaza_id = $plaza and persona_id = $p and fecha='$fecha' and hora='$hora'";
        $resultsuma = pg_query($conexion,$querydeducciones) or die ('Error al consultar deducciones'.pg_last_error());
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
    $insertarnominaajuste = "INSERT INTO nomina_ajuste (fecha_inicio,fecha_fin,nom_total,nom_autorizada,plaza_id,sal_tipo_id,fechageneracion,horageneracion,us_id,pc,idperiodo,nom_autorizo,nom_id_original) values ('$fechainicio','$fechafinal',$totalnomina,'false',$plaza,$tipoperiodo,'$fecha','$hora',$us_id,'$pc',4,0,$idnom)";
    $result = pg_query($conexion,$insertarnominaajuste) or die ('Error al insertar nomina de ajuste'.pg_last_error());



    //se consulta la nomina generada
    $querynomina="SELECT * from nomina_ajuste where us_id = $us_id and pc = '$pc' and fecha_inicio='$fechainicio'and fecha_fin = '$fechafinal' and plaza_id = $plaza and fechageneracion = '$fecha' and horageneracion = '$hora' ORDER BY nom_id DESC;";
    $result= pg_query($conexion,$querynomina);
    $mostrar= pg_fetch_array($result);
    $nominadeajusteid=$mostrar['nom_id'];

    
    //////////////////////////////////////////////////////////////////////////////////
    ////COMIENZA EL VOLCADO DE LA INFORMACION DE LAS TABLAS TEMPORALES A LAS//////////
    /////////////////////HISTORICAS DEL PROCESO DE LA NOMINA//////////////////////////

    //VOLCADO A LA TABLA HISTORICA DE BASE NOMINA
    $selectbn = "SELECT * FROM tmp_base_nom_ajuste where us_id = $us_id and fecha = '$fecha' and plaza_id  = $plaza and emp_id = $empid and sal_tipo_id = $tipoperiodo and pc = '$pc' and hora='$hbn' and idnomina = $idnom;";
    //echo $selectbn;
    $resultbn = pg_query($conexion,$selectbn);

    $rowbn = pg_fetch_array($resultbn);
    if($rowbn != NULL){
        do{    
            $sqlibn = "INSERT into base_nom_ajuste (nom_id,us_id,fecha,hora,plaza_id,num_ventas,venta_directa,cobros,saldo,cobros_per_ant,observaciones,emp_id,sal_tipo_id,fecha_inicio,fecha_fin,pc,ingresos,recibototal,nom_id_original)
                       values ($nominadeajusteid,".$rowbn['us_id'].",'".$rowbn['fecha']."','".$rowbn['hora']."',".$rowbn['plaza_id'].",".$rowbn['num_ventas'].",".$rowbn['venta_directa'].",".$rowbn['cobros'].",".$rowbn['saldo'].",".$rowbn['cobros_per_ant'].",'".$rowbn['observaciones']."','".$rowbn['emp_id']."',".$rowbn['sal_tipo_id'].",'".$rowbn['fecha_inicio']."','".$rowbn['fecha_fin']."','".$rowbn['pc']."',".$rowbn['ingresos'].",".$rowbn['recibototal'].",$idnom);";
            $resultibn=pg_query($conexion,$sqlibn) or die ('ERROR insertando base_nom_ajuste:'. pg_last_error());
            //echo $insertcomnom;
        }while($rowbn = pg_fetch_array($resultbn));
    }
    
    //VOLCADO A LA TABLA HISTORICA DE LAS COMISIONES
    $selecttmpcomnom = "SELECT * from tmp_comnom_ajuste where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora' and nom_id = $idnom";
    $result = pg_query($conexion,$selecttmpcomnom);
    $campostmpcomnom = pg_fetch_array($result);
    if($campostmpcomnom != NULL){
        do{    
            $insertcomnom = "INSERT into comnom_ajuste (co_id,persona_id,co_cantidad,co_observaciones,fecha_inicio,fecha_fin,us_id,nom_id,fecha,hora,pc,co_cuantos,nom_id_original) values (".$campostmpcomnom['co_id'].",".$campostmpcomnom['persona_id'].",".$campostmpcomnom['co_cantidad'].",'".$campostmpcomnom['co_observaciones']."','".$campostmpcomnom['fecha_inicio']."','".$campostmpcomnom['fecha_fin']."',".$campostmpcomnom['us_id'].",$nominadeajusteid,'".$campostmpcomnom['fecha']."','".$campostmpcomnom['hora']."','$pc',".$campostmpcomnom['co_cuantos'].",$idnom);";
            $resultinsertcomnom=pg_query($conexion,$insertcomnom) or die ('ERROR AL INSERTAR EN LA TABLA ORIGINAL DE LAS COMISIONES DE AJUSTE'.pg_last_error());
            //echo $insertcomnom;
        }while($campostmpcomnom = pg_fetch_array($result));
    }

    //VOLCADO A LA TABLA HISTORICA DE LAS PERCEPCIONES
    $selecttmp_percepciones = "SELECT * from tmp_percepciones_ajuste where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora' and nom_id=$idnom";
    $result = pg_query($conexion,$selecttmp_percepciones);
    $campostmppercepciones = pg_fetch_array($result);
    if($campostmppercepciones != NULL){
        do{    
           $insertpercepciones = "INSERT into percepciones_ajuste (nom_id,us_id,fecha,hora,persona_id,tp_id,tp_monto,tmp_observaciones,fecha_inicio,fecha_fin,pc,tp_cuantos,nom_id_original) values ($nominadeajusteid,$us_id,'".$campostmppercepciones['fecha']."','".$campostmppercepciones['hora']."',".$campostmppercepciones['persona_id'].",".$campostmppercepciones['tp_id'].",".$campostmppercepciones['tp_monto'].",'".$campostmppercepciones['tmp_observaciones']."','".$campostmppercepciones['fecha_inicio']."','".$campostmppercepciones['fecha_fin']."','$pc',".$campostmppercepciones['tp_cuantos'].",".$idnom.");";
           $resultinsertpercepciones=pg_query($conexion,$insertpercepciones) or die ('ERROR AL INSERTAR EN LA TABLA CHIDA DE LAS PERCEPCIONES'.pg_last_error());
           //echo $insertpercepciones;  
        }while($campostmppercepciones = pg_fetch_array($result));
    }
   
    /*//VOLCADO A LA TABLA HISTORICA DE LAS DEDUCCIONES
    $selecttmp_deducciones = "SELECT * from tmp_deducciones_ajuste where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    $result = pg_query($conexion,$selecttmp_deducciones);
    $campostmpdeducciones = pg_fetch_array($result);
    if($campostmpdeducciones != NULL){
        do{    
            $insertdeducciones = "INSERT into deducciones_ajuste (nom_id,us_id,fecha,hora,persona_id,td_id,td_monto,td_observaciones,fecha_inicio,fecha_fin,pc,td_cuantos,nom_id_original) values ($nominadeajusteid,$us_id,'".$campostmpdeducciones['fecha']."','".$campostmpdeducciones['hora']."',".$campostmpdeducciones['persona_id'].",".$campostmpdeducciones['td_id'].",".$campostmpdeducciones['td_monto'].",'".$campostmpdeducciones['td_observaciones']."','".$campostmpdeducciones['fecha_inicio']."','".$campostmpdeducciones['fecha_fin']."','$pc',".$campostmpdeducciones['td_cuantos'].",".$idnom.");";
            $resultinsertdeducciones=pg_query($conexion,$insertdeducciones) or die ('ERROR AL INSERTAR EN LA TABLA CHIDA DE LAS DEDUCCIONES');
            //echo $insertdeducciones;
        }while($campostmpdeducciones = pg_fetch_array($result));
    }

   
    //////////////////////////////////////////////////////////////////////////////////
    ////COMIENZA EL PROCESO PARA EL BORRADO DE LAS TABLAS TEMPORALES//////////////////
    //////////////////////////////////////////////////////////////////////////////////
  
    
    //se obtiene la cantidad de datos en la tabla temporal de base de nomina
    $selecttmpbasenom = "SELECT count(*) as cuentatmpbasenom from tmp_base_nom_ajuste where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hbn'";
    $selecttmpbasenom;
    $result = pg_query($conexion,$selecttmpbasenom);
    $valorarreglotmpbasenom = pg_fetch_array($result);

    //se obtiene la cantidad de datos en la tabla historico de base de nomina
    $selectbasenom = "SELECT count (*) as cuentabasenom from base_nom_ajuste where us_id = $us_id and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and nom_id=$nominaid and pc = '$pc'";
    //echo $selectbasenom;
    $result = pg_query($conexion,$selectbasenom);
    $valorarreglobasenom = pg_fetch_array($result);
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($valorarreglotmpbasenom['cuentatmpbasenom']==$valorarreglobasenom['cuentabasenom']){
       $borradotmpbasenom="DELETE from tmp_base_nom_ajuste WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hbn' and nom_id = $idnom";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmpbasenom) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL BASE NOMINA DE AJUSTE ';
    } 

    
    //se obtiene la cantidad de comisiones en la tabla tmp para el periodo
    $selecttmp_comnom = "SELECT count(*) as cuentatmpcomnom from tmp_comnom_ajuste where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    //echo $selecttmp_percepciones;
    $result = pg_query($conexion,$selecttmp_comnom);
    $campostmp_comnom = pg_fetch_array($result);
    
    //se obtiene la cantidad de comisiones en la tabla historico para el periodo
    $selectcomnom = "SELECT count(*) as cuentacomnom from comnom_ajuste where nom_id = $nominaid and us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' ";
    //echo $selectpercepciones;
    $result = pg_query($conexion,$selectcomnom);
    $camposcomnom = pg_fetch_array($result);
    
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmp_comnom['cuentatmpcomnom']==$camposcomnom['cuentacomnom']){
        $borradotmp_comnom="DELETE from tmp_comnom_ajuste WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora' and nom_id = $idnom";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmp_comnom) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL COMISIONES';
    } 


    //se obtiene la cantidad de percepciones en la tabla tmp para el peiodo
    $selecttmp_percepciones = "SELECT count(*) as cuentatmppercepciones from tmp_percepciones_ajuste where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    //echo $selecttmp_percepciones;
    $result = pg_query($conexion,$selecttmp_percepciones);
    $campostmppercepciones = pg_fetch_array($result);
    
    //se obtiene la cantidad de percepciones en la tabla historico para el peiodo
    $selectpercepciones = "SELECT count(*) as cuentapercepciones from percepciones_ajuste where nom_id = $nominaid and us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal'";
    //echo $selectpercepciones;
    $result = pg_query($conexion,$selectpercepciones);
    $campospercepciones = pg_fetch_array($result);
    
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmppercepciones['cuentatmppercepciones']==$campospercepciones['cuentapercepciones']){
        $borradotmp_percepciones="DELETE from tmp_percepciones_ajuste WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora' and nom_id = $idnom";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmp_percepciones) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL PERCEPCIONES';
    } 

    
    //se obtiene la cantidad de deducciones en la tabla tmp para el peiodo
    $selecttmp_deducciones = "SELECT count(*) as cuentatmpdeducciones from tmp_deducciones_ajuste where us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora'";
    $result = pg_query($conexion,$selecttmp_deducciones);
    $campostmpdeducciones = pg_fetch_array($result);
    
    //se obtiene la cantidad de deducciones en la tabla historico para el peiodo
    $selectdeducciones = "SELECT count(*) as cuentadeducciones from deducciones_ajuste where nom_id = $nominaid and us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal'";
    $result = pg_query($conexion,$selectdeducciones);
    $camposdeducciones = pg_fetch_array($result);
    
    //SE ESTAN COMPARANDO QUE LO QUE SE MANDO SEA IGUAL PARA QUE SE PUEDA BORRAR  
    if($campostmpdeducciones['cuentatmpdeducciones']==$camposdeducciones['cuentadeducciones']){
        $borradotmp_deducciones="DELETE from tmp_deducciones_ajuste WHERE us_id = $us_id and pc = '$pc' and fecha_inicio = '$fechainicio' and fecha_fin='$fechafinal' and plaza_id =$plaza and fecha='$fecha' and hora='$hora' and nom_id = $idnom";
        //echo $borradotmpcomnom;
        $result = pg_query($conexion,$borradotmp_deducciones) or die ("Verifica la sentencia SQL". pg_last_error());
    }else{
        echo 'No son iguales - TEMPORAL DEDUCCIONES';
    } */

    
    //////////////////////////////////////////////////////////////////////////////////
    ////SE ENVIA EL MENSAJE DE NOMINA GENERADA Y SE ENTREGA EL FOLIO//////////////////
    //////////////////////////////////////////////////////////////////////////////////
    
    $letreritosuccesfully.='<div>
                                Nomina generada con exito, ID: '.$nominadeajusteid.'
                            </div>
                            ';
    echo $letreritosuccesfully;

    include_once('correonomina.php');
   
}

?>