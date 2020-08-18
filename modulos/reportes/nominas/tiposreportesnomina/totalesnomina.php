<?php 

header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=nombre_archivo.xls');
include ('../../../../config/cookie.php');
include ('../../../../config/conectasql.php');
$idnom=base64_decode($_GET['idnom']);
$exporta = new conectasql();
$exporta->abre_conexion("0");


/*   ---------------------------------------------------------- */
//           SE OBTIENE LA INFORMACION DE LA BASE NOMINA        //
/*   ---------------------------------------------------------- */

$sqlbasenomina = "SELECT * FROM base_nom WHERE nom_id = $idnom";
//echo $sqlbasenomina;
$resultsqlbasenomina = pg_query($exporta->conexion,$sqlbasenomina);
$mostrarinformacionbasenomina = pg_fetch_array($resultsqlbasenomina);

/*   ---------------------------------------------------------------- */
//         SE GUARDA EN VARIABLES EL RESULTADO DE LA BASE NOMINA      //
/*   ---------------------------------------------------------------- */

$fechacreacionnomina = $mostrarinformacionbasenomina['fecha'];
//echo $fechacreacionnomina;
$horacreacionnomina = $mostrarinformacionbasenomina['hora'];
//echo $horacreacionnomina;
$plazaid = $mostrarinformacionbasenomina['plaza_id'];
//echo $plazaid;
$numventas = $mostrarinformacionbasenomina['num_ventas'];
//echo $$numventas;
$ventadirecta = $mostrarinformacionbasenomina['venta_directa'];
//echo $ventadirecta;
$cobros = $mostrarinformacionbasenomina['cobros'];
//echo $cobros;
$saldo = $mostrarinformacionbasenomina['saldo'];
//echo $saldo;
$cobrosperant = $mostrarinformacionbasenomina['cobros_per_ant'];
//echo $cobrosperant;
$observacionesbasenomina = $mostrarinformacionbasenomina['observaciones'];
//echo $observacionesbasenomina;
$empresaid = $mostrarinformacionbasenomina['emp_id'];
//echo $empresaid;
$saltipoid = $mostrarinformacionbasenomina['sal_tipo_id'];
//echo $saltipoid;
$fechainicio = $mostrarinformacionbasenomina['fecha_inicio'];
//echo $fechainicio;
$fechafin = $mostrarinformacionbasenomina['fecha_fin'];
//echo $fechafin;
$ingresos = $mostrarinformacionbasenomina['ingresos'];
//echo $ingresos;
$recibototal = $mostrarinformacionbasenomina['recibototal'];
//echo $recibototal;

/*   ---------------------------------------------------------- */
//           SE OBTIENE LA INFORMACION DE LA NOMINA             //
/*   ---------------------------------------------------------- */

$sqlnomina = "SELECT * FROM nomina WHERE nom_id = $idnom";
//echo $sqlnomina;
$resultsqlnomina = pg_query($exporta->conexion,$sqlnomina);
$mostrarinformacionnomina = pg_fetch_array($resultsqlnomina);

/*   ---------------------------------------------------------------- */
//         SE GUARDA EN VARIABLES EL RESULTADO DE LA NOMINA           //
/*   ---------------------------------------------------------------- */

$totalnomina = $mostrarinformacionnomina['nom_total'];
//echo $totalnomina;
$nominaautorizada = $mostrarinformacionnomina['nom_autorizada'];
//echo $nominaautorizada;
$usergeneradordenomina = $mostrarinformacionnomina['us_id'];
//echo $usergeneradordenomina;

/*   --------------------------------- */
//         NOMBRE DE USUARIO          //
/*   ------------------------------- */
$sqlusuario = "SELECT us_id , us_login, nombrecompleto from vw_users where us_id = $usergeneradordenomina";
$resultsqlusuario = pg_query($sqlusuario);
$mostrarinformaciondeusuario = pg_fetch_array($resultsqlusuario);

$idusuario = $mostrarinformaciondeusuario['us_id'];
$loginusuario = $mostrarinformaciondeusuario['us_login'];
$usuario = $mostrarinformaciondeusuario['nombrecompleto'];

/*   ----------------------------------------- */
//         NOMBRE DE TIPO DE PERIODO          //
/*   --------------------------------------- */
$sqltipoperiodo = "SELECT sal_tipo_nombre FROM tipos_salarios WHERE sal_tipo_id = $saltipoid";
$resultsqltipoperiodo = pg_query($sqltipoperiodo);
$mostrarinformaciontipoperiodo = pg_fetch_array($resultsqltipoperiodo);
$nombretipoperiodo = $mostrarinformaciontipoperiodo['sal_tipo_nombre'];

/*   ------------------------------ */
//         NOMBRE DE EMPRESA        //
/*   ------------------------------ */
$sqlnombreempresa="SELECT emp_nombre FROM empresas WHERE emp_id = $empresaid";
$resultnombreempresa = pg_query($sqlnombreempresa);
$mostrarinformacionnombreempresa = pg_fetch_array($resultnombreempresa);
$nombreempresa = $mostrarinformacionnombreempresa['emp_nombre'];

/*   ---------------------------------------------------------------- */
//           SE OBTIENE LA INFORMACION DE VW_SUELDOS_NOMINA           //
/*   ---------------------------------------------------------------- */

$sqlsueldosnomina = "SELECT * FROM vw_sueldos_nomina WHERE nom_id = $idnom";
//echo $sqlsueldosnomina;
$resultsqlsueldosnomina = pg_query($exporta->conexion,$sqlsueldosnomina);
$mostrarinformacionsueldosnomina = pg_fetch_array($resultsqlsueldosnomina);

/* -------------------------------------------------------   */
//      OBTENER LAS PERSONAS QUE HAY EN LA NOMINA            //
/* -------------------------------------------------------   */
$personas = array();
$ids = "";
    do{
        $ids .= "".$mostrarinformacionsueldosnomina['persona_id'].",";
        $personas[] = $mostrarinformacionsueldosnomina['persona_id'];
    }while($mostrarinformacionsueldosnomina = pg_fetch_array($resultsqlsueldosnomina));
$ids = substr($ids,0,-1);
//echo $ids;




/* -----------------------------------------------------------------------------   */
//      OBTENER LOS JEFES DIRECTOS DE LAS PERSONAS QUE HAY EN LA NOMINA            //
/* -----------------------------------------------------------------------------   */

$sqljefesdirectos = "SELECT DISTINCT con_jefe_inmediato FROM contratos WHERE persona_id IN (".$ids.") order by con_jefe_inmediato";
//echo $sqljefesdirectos;
$resultsqljefesdirectos = pg_query($exporta->conexion,$sqljefesdirectos);
$mostrarinformacionjefesdirectos = pg_fetch_array($resultsqljefesdirectos);
$jefesdirectos = "";
do{
    $jefesdirectos .= "".$mostrarinformacionjefesdirectos['con_jefe_inmediato'].",";
}while($mostrarinformacionjefesdirectos = pg_fetch_array($resultsqljefesdirectos));
$jefesdirectos = substr($jefesdirectos,0,-2);
//echo $jefesdirectos;



/* -------------------------------------------------------   */
//       SE OBTIENE EL SDI Y EL SUELDO DE LA PERSONA         //
/* -------------------------------------------------------   */

$largepersonas=count($personas);
//echo $largepersonas;
for($y=0; $y < $largepersonas; $y++){
    
//echo $sqlsdisalario;
//echo $consdi;
//echo $salmontocon;
}

/* --------------------------------------------------------------   */
//       SE OBTIENEN LAS COMISIONES QUE EXISTEN EN LA NOMINA        //
/* --------------------------------------------------------------   */
$sqlcomisionesdelanomina = "SELECT DISTINCT co_id FROM vw_comnom where nom_id = $idnom order by co_id";
$resultsqlcomisionesdelanomina = pg_query($exporta->conexion,$sqlcomisionesdelanomina);
$mostrarinformacioncomisionesdelanomina = pg_fetch_array($resultsqlcomisionesdelanomina);
$comisionesdisponibles=array();

/* ----------------------------------------------------------------   */
//       SE OBTIENEN LAS PERCEPCIONES QUE EXISTEN EN LA NOMINA        //
/* ----------------------------------------------------------------   */
$sqlpercepcionesdelanomina = "SELECT DISTINCT tp_id FROM vw_percepciones where nom_id = $idnom order by tp_id";
//echo $sqlpercepcionesdelanomina;
$resultsqlpercepcionesdelanomina = pg_query($exporta->conexion,$sqlpercepcionesdelanomina);
$mostrarinformacionpercepcionesdelanomina = pg_fetch_array($resultsqlpercepcionesdelanomina);
$percepcionesdisponibles=array();
   

/* ----------------------------------------------------------------   */
//       SE OBTIENEN LAS DEDUCCIONES QUE EXISTEN EN LA NOMINA        //
/* ----------------------------------------------------------------   */
$sqldeduccionesdelanomina = "SELECT DISTINCT td_id FROM vw_deducciones where nom_id = $idnom order by td_id";
//echo $sqldeduccionesdelanomina;
$resultsqldeduccionesdelanomina = pg_query($exporta->conexion,$sqldeduccionesdelanomina);
$mostrarinformaciondeduccionesdelanomina = pg_fetch_array($resultsqldeduccionesdelanomina);
$deduccionesdisponibles=array();
   

                                    /* -------------------------------------   */
                                    //       SE INICIA DISEÑO DE REPORTE       //
                                    /* -------------------------------------   */

        
        /* -----------------------------------------------------------------------------------------   */
        //                                  LLENADO HORIZONTAL                                         //
        /* -----------------------------------------------------------------------------------------   */

        if($empresaid != 2){
            $sqlnombresjefesdirectos = "SELECT DISTINCT nombrecompleto from vw_personas where persona_id IN (".$jefesdirectos.")";
            //echo $sqlnombresjefesdirectos;
            $resultsqlnombresjefesdirectos = pg_query($exporta->conexion,$sqlnombresjefesdirectos);
            $mostrarinformacionnombresjefesdirectos = pg_fetch_array($resultsqlnombresjefesdirectos);
            do{
                $conjefes .= '
                <thead>'.$mostrarinformacionnombresjefesdirectos['nombrecompleto'].'</thead>';
            }while($mostrarinformacionnombresjefesdirectos = pg_fetch_array($resultsqlnombresjefesdirectos));    
        }else{
            $conjefes .='';
        }
      
    
        do{

            /* ------------------------------------------------------------------------------   */
            //       SE OBTIENEN LOS NOMBRES DE LAS COMISIONES QUE EXISTEN EN LA NOMINA         //
            /* ------------------------------------------------------------------------------   */
            $idcomisiones = $mostrarinformacioncomisionesdelanomina['co_id'];
            $comisionesdisponibles[] = $mostrarinformacioncomisionesdelanomina['co_id'];

            $sqlnombrescomisiones = "SELECT co_id, co_nombre FROM vw_comnom where co_id = $idcomisiones order by co_id";
            $resultnombrescomisiones = pg_query($sqlnombrescomisiones);
            $mostrarinformacionnombrescomisiones = pg_fetch_array($resultnombrescomisiones);

            $nombrescomisiones.='
                <td>'.$mostrarinformacionnombrescomisiones['co_nombre'].'</td>
            ';

        }while($mostrarinformacioncomisionesdelanomina = pg_fetch_array($resultsqlcomisionesdelanomina));


        do{

            /* --------------------------------------------------------------------------------   */
            //       SE OBTIENEN LOS NOMBRES DE LAS PERCEPCIONES QUE EXISTEN EN LA NOMINA         //
            /* --------------------------------------------------------------------------------   */
            $idpercepciones = $mostrarinformacionpercepcionesdelanomina['tp_id'];
            $percepcionesdisponibles[] = $mostrarinformacionpercepcionesdelanomina['tp_id'];
            $sqlnombrespercepciones = "SELECT tp_id, tp_nombre FROM tipos_percepciones WHERE tp_id = $idpercepciones order by tp_id";
            //echo $sqlnombrespercepciones;
            $resultnombrespercepciones = pg_query($sqlnombrespercepciones);
            $mostrarinformacionnombrespercepciones = pg_fetch_array($resultnombrespercepciones);
            $nombrepercepcion = $mostrarinformacionnombrespercepciones['tp_nombre'];
            //echo $idpercepciones.'--';
            //echo $nombrepercepcion;

            $nombrespercepciones.='
                <td>'.$mostrarinformacionnombrespercepciones['tp_nombre'].'</td>
            ';
        }while($mostrarinformacionpercepcionesdelanomina = pg_fetch_array($resultsqlpercepcionesdelanomina));



        do{

            /* --------------------------------------------------------------------------------   */
            //       SE OBTIENEN LOS NOMBRES DE LAS DEDUCCIONES QUE EXISTEN EN LA NOMINA         //
            /* --------------------------------------------------------------------------------   */
            $iddeducciones = $mostrarinformaciondeduccionesdelanomina['td_id'];
            $deduccionesdisponibles[] = $mostrarinformaciondeduccionesdelanomina['td_id'];
            $sqlnombresdeducciones = "SELECT td_id, td_nombre FROM tipos_deducciones WHERE td_id = $iddeducciones order by td_id";
            //echo $sqlnombresdeducciones;
            $resultnombresdeducciones = pg_query($sqlnombresdeducciones);
            $mostrarinformacionnombresdeducciones = pg_fetch_array($resultnombresdeducciones);
            $nombrededucadcion = $mostrarinformacionnombresdeducciones['td_nombre'];
            //echo $iddeducciones.'--';
            //echo $nombrededuccion;
            $nombresdeducciones.='
                <td>'.$mostrarinformacionnombresdeducciones['td_nombre'].'</td>
            ';
        }while($mostrarinformaciondeduccionesdelanomina = pg_fetch_array($resultsqldeduccionesdelanomina));












        /* -----------------------------------------------------------------------------------------   */
        //                                  LLENADO HORIZONTAL POR PERSONA                             //
        /* -----------------------------------------------------------------------------------------   */
       


        $largepersonas=count($personas);
        $largecomisiones=count($comisionesdisponibles);
        $largepercepciones=count($percepcionesdisponibles);
        $largededucciones=count($deduccionesdisponibles);
            for($y=0; $y < $largepersonas; $y++){

                $sqlfechasdeingreso = "SELECT DISTINCT nombrecompleto, con_fecha_inicio from vw_sueldos_nomina where nom_id = $idnom and persona_id = ".$personas[$y]."";
                //echo $sqlfechasdeingreso;
                $resultsqlfechasdeingreso = pg_query($exporta->conexion,$sqlfechasdeingreso);
                $mostrarinformacionfechasdeingreso = pg_fetch_array($resultsqlfechasdeingreso);
                $monos .= '
                
                        <tr>
                            <td>'.$mostrarinformacionfechasdeingreso['con_fecha_inicio'].'</td>
                            <td>'.$mostrarinformacionfechasdeingreso['nombrecompleto'].'</td>
                        ';

                $sqlasistencias = "SELECT dias FROM asistencias WHERE nom_id = $idnom and persona_id = ".$personas[$y]."";
                $resultsqlasistencias = pg_query($exporta->$sqlasistencias);
                $mostrarinformacionasistencias = pg_fetch_array($resultsqlasistencias);
                $monos.='
                    
                        <td>'.$mostrarinformacionasistencias['dias'].'</td>';
                
                
                $sqlsdisalario = "SELECT con_sdi, sal_monto_con FROM vw_sueldos_nomina WHERE nom_id = $idnom and persona_id = ".$personas[$y]."";
                $resultsqlsdisalario = pg_query($exporta->conexion,$sqlsdisalario);
                $mostrarinformacionsdisalariodiario = pg_fetch_array($resultsqlsdisalario);
                $monos .= '
                        <td>'.$mostrarinformacionsdisalariodiario['con_sdi'].'</td>
                        <td>'.$mostrarinformacionsdisalariodiario['sal_monto_con'].'</td>
                        
                    ';

                    //Comisiones
                for($c=0; $c < $largecomisiones; $c++){

                    $sqlcomisionesporpersona = "SELECT co_monto FROM vw_comnom WHERE nom_id = $idnom and persona_id = ".$personas[$y]." and co_id = ".$comisionesdisponibles[$c]." ";
                    $resultcomisionesporpersona = pg_query($exporta->conexion,$sqlcomisionesporpersona);
                    //echo $sqlcomisionesporpersona;

                    if($mostrarinformacioncomisionesporpersona = pg_fetch_array($resultcomisionesporpersona)){
                            do{
                                $monos.='
                                    <td>'.$mostrarinformacioncomisionesporpersona['co_monto'].'</td>
                                ';
                            }while($mostrarinformacioncomisionesporpersona = pg_fetch_array($resultcomisionesporpersona));
                    }else if($mostrarinformacioncomisionesporpersona = pg_fetch_array($resultcomisionesporpersona) == NULL){
                        $monos .= '
                            <td>0</td>
                        ';
                    }

                }
                
                    for($p=0; $p < $largepercepciones; $p++){
                
                        $sqlpercepcionesporpersona = "SELECT tp_monto FROM vw_percepciones WHERE nom_id = $idnom and persona_id = ".$personas[$y]." and tp_id = ".$percepcionesdisponibles[$p]." ";
                        $resultpercepcionesporpersona = pg_query($exporta->conexion,$sqlpercepcionesporpersona);
                        if($mostrarinformacionpercepcionesporpersona = pg_fetch_array($resultpercepcionesporpersona)){
                            do{
                                $monos .= '
                                    <td>'.$mostrarinformacionpercepcionesporpersona['tp_monto'].'</td>
                                ';
                            }while($mostrarinformacionpercepcionesporpersona = pg_fetch_array($resultpercepcionesporpersona));

                        }else if($mostrarinformacionpercepcionesporpersona = pg_fetch_array($resultpercepcionesporpersona) == NULL){
                            $monos .= '<td>0</td>';
                        }
                        
                    }  
                    
                    for($d=0; $d < $largededucciones; $d++){

                        $sqldeduccionesporpersona = "SELECT td_monto FROM vw_deducciones WHERE nom_id = $idnom and persona_id = ".$personas[$y]." and td_id = ".$deduccionesdisponibles[$d]." ";
                        $resultdeduccionesporpersona = pg_query($exporta->conexion,$sqldeduccionesporpersona);
                        if($mostrarinformaciondeduccionesporpersona = pg_fetch_array($resultdeduccionesporpersona)){
                            do{
                                $monos .= '
                                    <td>'.$mostrarinformaciondeduccionesporpersona['td_monto'].'</td>
                                ';
                            }while($mostrarinformaciondeduccionesporpersona = pg_fetch_array($resultdeduccionesporpersona));
                        }else
                        if($mostrarinformaciondeduccionesporpersona = pg_fetch_array($resultdeduccionesporpersona) == NULL){
                            $monos .= '<td>0</td>';
                        }
                    
                    }
            }

                
            
        


        /* ---------------------------------------------------------------------   */
        //           SE OBTIENEN LAS PERCEPCIONES POR PERSONA                      //
        /* --------------------------------------------------------------------  
        $largepercepciones = count($percepcionesdisponibles);



        /* ---------------------------------------------------------------------   */
        //           SE OBTIENEN LAS DEDUCCIONES POR PERSONA                      //
        /* --------------------------------------------------------------------   
        $largededucciones = count($deduccionesdisponibles);
        for($y=0; $y < $largepersonas; $y++){

            
            
        }*/



?>

<html>
    <head>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
            padding: 5px;
            }
            th {
            text-align: left;
            }
            .fechaCreacion{
                text-align: right;
            }
            .usuario{
                text-align: right;
            }
            .idnomina{
                text-align: left;
            }
            .tipoperiodo{
                text-align: right;
            }
            .empresa{
                text-align: left;
            }
            .tablebasenom{
                text-align: center;
            }
        </style>
        <table>
            <tr>
                <td>Fecha de Creacion de Nomina</td>
                <td>Usuario creador de nomina</td>
                <td>Nomina:  </td>
                <td>Tipo de periodo:  </td>
                <td>Empresa:   </td>
            </tr>

            <tr>
                <td><?php echo $fechacreacionnomina?></td>
                <td><?php echo $idusuario.'---'; echo $loginusuario.'   '; echo $usuario?></td>
                <td><?php echo $idnom?></td>
                <td><?php echo $nombretipoperiodo.'   '.'Del '.$fechainicio.'   '.'Al '.$fechafin;?></td>
                <td><?php echo $nombreempresa?></td>
            </tr>
        
        </table>
        </br>
        </br>
        
        <div class="tablebasenom">
            <table>
                <tr>
                    <td>Saldo Plan</td>
                    <td>Adicionales</td>
                    <td>Servicios Directos</td>
                    <td>Abono</td>
                    <td>Ingresos</td>
                    <td>Cobros Anteriores</td>
                    <td>Recibo Total</td>
                    <td>Observaciones</td>
                </tr>
                <tr>
                    <td><?php echo $numventas?></td>
                    <td><?php echo $ventadirecta?></td>
                    <td><?php echo $cobros?></td>
                    <td><?php echo $saldo?></td>
                    <td><?php echo $ingresos?></td>
                    <td><?php echo $cobrosperant?></td>
                    <td><?php echo $recibototal?></td>
                    <td><?php echo $observacionesbasenomina?></td>
                
            </table>
            </br>
            </br>
        </div>
       
    </head>

    <body>
        <div class="jefesdirectos">
            <label>Jefe directo:   </label>
        </div>
        <table>
       
            <tr>
                <td>Fecha de Ingreso</td>
                <td>Persona</td>
                <td>Asistencias</td>
                <td>SDI</td>
                <td>Salario Diario</td> 
                <?php echo $nombrescomisiones;?>
                <?php echo $nombrespercepciones;?>
                <?php echo $nombresdeducciones;?>
            </tr>
            <tr>
                <?php 
                echo $conjefes;
                echo $monos;
                ?>
            </tr>
        </table>
    </body>
</html>