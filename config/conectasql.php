<?php

class conectasql{
    public $conexion;
    public $msj;
    public $acceso;
    public $id;
    public $login;
    public $p1;
    public $p2;
    public $p3;
    public $p4;
    public $pplazas;
    public $psucursales;
    public $select;
    public $html;
    public $inserts;
    public $update;
    public $npid;
    public $generales;
    public $bancarios;
    public $documentos;
    public $plazas;
    public $autoriza;
    public $flag1;
    public $flag2;
    public $consulta;
    public $consulta2;
    public $consulta3;
    public $consulta4;

    public function abre_conexion($perfil) {
        include 'config.php';
        
        switch ($perfil) {
            case 0:
                //postgres
                //$this->conexion = $server0.' '.$dbname0.' '.$user0.' '.$passwd0.' '.$port0;
                $this->conexion = pg_connect("host=$server0 port=$port0 dbname=$dbname0 user=$user0 password=$passwd0") or die ("Error de conexion. ". pg_last_error());;                
            break;
            
            case 1:
                //mssql
                //echo $server1.$dbname1.$user1.$password1;
                //$this->conexion = odbc_connect ("Driver={ODBC Driver 13 for SQL Server};Server=$server1;Database=$dbname1;", "$user1", "$passwd1");                                               
            break;

            case 2:
                //mysql
                //$this->conexion = odbc_connect ("Driver={ODBC Driver 13 for SQL Server};Server=$server2;Database=$dbname2;", "$user2", "$passwd2");
            break;
        
            case 3:
                //maria_db
                //$this->conexion = new mysqli($server3, $user3, $passwd3, $dbname3);
            break;

            default:
            break;
        }
    }
    
    public function cierra_conexion($perfil) {
        
        switch ($perfil) {
            case 0:
                //postgres
                pg_close($this->conexion);
            break;
            
            case 1:
                //mssql
                
            break;

            case 2:
                //mysql
                
            break;
        
            case 3:
                //maria_db
                
            break;

            default:
            break;
        }
    }
    
    ////////////////////////////////////////////////////////////////////////
    //enseguida se listan las multiples consultas que se han de utilizar////
    //////////////a lo largo de la aplicacion///////////////////////////////
    ////////////////////////////////////////////////////////////////////////
    
    
    //se graba el acceso fallido a la aplicacion
    public function historico_af($fecha,$hora,$equipo,$navegador,$evento) {
        $sqlaf = "insert into acceso_fallido(af_fecha,af_hora,pc_name,pc_navegador,af_evento) values('$fecha','$hora','$equipo','$navegador','$evento')";
        $resultaf = pg_query($this->conexion,$sqlaf) or die("Error haf: ". pg_last_error());//historico acceso fallido
        
    }
    
    //se consulta si el equipo esta autorizado para poder acceder a la aplicacion
    public function valida_pc($equipo) {
        $sqlvpc = "select * from pcs where pc_ip = '$equipo'";
        $resultvpc = pg_query($this->conexion,$sqlvpc) or die("Error vpc: ". pg_last_error());//valida pc
        if($rowvpc = pg_fetch_array($resultvpc)){
            $this->msj='autorizado';
        }else{
            $this->msj='no autorizado';
        }        
    }
    
    //se valida el usuario que esta intentando acceder a la aplicacion
    public function valida_usuario($usuario,$passwd) {
        $sqlvu = "select us_id,us_login,us_passwd from users where us_login = '$usuario' and us_passwd = '$passwd' and us_activo = 1";
        $resultvu = pg_query($this->conexion,$sqlvu) or die("Error vu: ". pg_last_error());//valida usuario
        if($rowvu = pg_fetch_array($resultvu)){
            if($usuario == $rowvu['us_login'] && $passwd == $rowvu['us_passwd']){
                $this->acceso='autorizado';
                $this->id = $rowvu['us_id'];
            }else{
                $this->acceso='no autorizado';
            }
        }else{
            $this->acceso='no autorizado';
        }
    }
    
    //se guarda el registro del usuario autentificado que accedio a la aplicacion
    public function registro_login($usid,$fecha,$hora,$pc) {
        $sqlrl = "insert into historico_login_pcs(us_id,pc_login_day,pc_login_time,pc_name) values($usid,'$fecha','$hora','$pc')";
        $resultrl = pg_query($this->conexion, $sqlrl) or die("Error rl: ". pg_last_error());//registro login
    }
    
    //se consulta el us_login para colocarlo en el menu
    public function uslogin($usid) {
        $sqlcu = "select us_login from users where us_id = $usid";
        $resultcu = pg_query($this->conexion,$sqlcu) or die("Error cu: ". pg_last_error());//consulta usuario
        if($rowcu = pg_fetch_array($resultcu)){
            $this->login=$rowcu['us_login'];
            
        }
    }
    
    //se consulta los permisos del usuario en cuestion para cualquier parte de la aplicacion
    public function permisos($tipop,$peridpadre,$usid) {
        //contenido de los arreglos para los permisos
        //[0]=valor ''
        //[1]=per_id
        //[2]=per_idpadre
        //[3]=per_nombre
        //[4]=per_ruta
        $permisos1=array();
        $permisos2=array();
        $permisos3=array();
        $permisos4=array();
        
        /*el primer tipo de validacion es para los menus*/
        if($tipop == 'menu'){
            //echo $tipop.' '.$peridpadre.' '.$usid;
            //consulta
            $sqlm = "select * from vw_usuarios_permisos where per_idpadre = $peridpadre and us_id = $usid and per_tipo = 'menu' order by per_id";
            $resultm = pg_query($this->conexion,$sqlm) or die("Error pm: ". pg_last_error());//permisos menu
            if($rowm= pg_fetch_array($resultm)){
                do{
                   $permisos1[]=','.$rowm['per_id'].','.$rowm['per_idpadre'].','.$rowm['per_nombre'].','.$rowm['per_ruta'];
                }
                while ($rowm= pg_fetch_array($resultm));
            }
            //termina la consulta y el llenado del arreglo
            //$this->p1=$sql;
            $this->p1=$permisos1;
        }
        
        if($tipop == 'submenu'){
            $sqlsm = "select * from vw_usuarios_permisos where per_idpadre = $peridpadre and us_id = $usid and per_tipo = 'submenu' order by per_id";
            $resultsm = pg_query($this->conexion,$sqlsm)or die("Error sm: ". pg_last_error());//sub menu
            if($rowsm = pg_fetch_array($resultsm)){
                do{
                        $permisos2[]=','.$rowsm['per_id'].','.$rowsm['per_idpadre'].','.$rowsm['per_nombre'].','.$rowsm['per_ruta'];
                }
                while ($rowsm= pg_fetch_array($resultsm));
            }
            //termina la consulta y el llenado del arreglo
            $this->p2=$permisos2;
        }
        
        if($tipop == 'papp'){
            $sqlpapp="select * from vw_usuarios_permisos where per_idpadre = $peridpadre and us_id = $usid and per_tipo = 'papp'";
            $resultpapp= pg_query($this->conexion,$sqlpapp) or die("Error papp: ". pg_last_error());//permiso app
            if($rowpapp= pg_fetch_array($resultpapp)){
                do{
                   $permisos3[]=$rowpapp['per_id'];
                }
                while ($rowpapp= pg_fetch_array($resultpapp));
            }
            //termina la consulta y el llenado del arreglo
            $this->p3=$permisos3;
        }
        
       
    }
    
    //consulta plazas y sucursales a las que tiene derecho de acceder un usuario
    //regresa valores como complemento para poder incluirlas en otras consultas
    public function user_plazas_sucursales($usid) {
        $sqlp="select distinct plaza_id from users_plazas_sucursales where us_id = $usid;";
        $resultp= pg_query($this->conexion, $sqlp);
        if($rowp = pg_fetch_array($resultp)){
            do{
                $this->pplazas.=','.$rowp['plaza_id'];
            }
            while($rowp = pg_fetch_array($resultp));
        }
        $this->pplazas = substr($this->pplazas,1);
        
        $sqlp="select distinct suc_id from users_plazas_sucursales where us_id = $usid;";
        $resultp= pg_query($this->conexion, $sqlp);
        if($rowp = pg_fetch_array($resultp)){
            do{
                $this->psucursales.=','.$rowp['suc_id'];
            }
            while($rowp = pg_fetch_array($resultp));
        }
        $this->psucursales = substr($this->psucursales,1);
    }
    
    // CONSULTAS ALTAS Y MODIFICACIONES DE PERSONAS
    //funcion para crear selects con registros leidos de la base de datos
    public function selects_creator($sql,$nombre,$valor,$texto,$apartado,$change,$default) {
        $resultcds = pg_query($this->conexion,$sql) or die("Error cds: ". pg_last_error());//creador de selects
        $this->select = ' <select class="input0" id="'.$nombre.'" name='.$nombre.' '.$change.'>';
        $this->select.='<option value="1000"> --- Selecciona '.$apartado.' --- </option>';
        if($rowcds = pg_fetch_array($resultcds)){
            do{
                if($rowcds[$valor] == $default){$vd='selected';}else{$vd='';}
                $this->select.='<option value="'.$rowcds[$valor].'" '.$vd.'>'.$rowcds[$texto].'</option>';
            }
            while($rowcds = pg_fetch_array($resultcds));
        }
        $this->select.='</select>';
                   
    }
    
    public function select_multiple($sql,$nombre,$valor,$texto,$apartado,$change,$default) {
        $resultcds = pg_query($this->conexion,$sql) or die("Error cds: ". pg_last_error());//creador de selects
        $this->select = ' <select class="input0" name='.$nombre.' '.$change.' size="5" multiple>';
        $this->select.='<option value="1000"> --- Selecciona '.$apartado.' --- </option>';
        if($rowcds = pg_fetch_array($resultcds)){
            do{
                if($rowcds[$valor] == $default){$vd='selected';}else{$vd='';}
                $this->select.='<option value="'.$rowcds[$valor].'" '.$vd.'>'.$rowcds[$texto].'</option>';
            }
            while($rowcds = pg_fetch_array($resultcds));
        }
        $this->select.='</select>';
    }

    public function limpia_cadena($cadena) {
        $caracteres = 'À Â Ã Ä Å Æ Ç È Ê Ë Ì Î Ï Ð Ò Ô Õ Ö Ø Ù Û Ü Ý Þ ß à â ã ä å æ ç è ê ë ì î ï ð ò ô õ ö ø ù û ü ý þ ÿ ¡ ¢ £ ¤ ¥ ¦ § ¨ © ª « ¬  ® ¯ ° ± ² ³´ µ ¶ · ¸ ¹ º » ¼ ½ ¾ ¿ × ÷ " \' \ & < >';
        $caracteres = explode(' ',$caracteres);
        $nchar      = count($caracteres);
        $base       = 0;
        while($base<$nchar){
            $cadena = str_replace($caracteres[$base],'',$cadena);
            $base++;
        }
        if(strlen($cadena) == 0){
            $cadena='101010';
        }
        return $cadena;
    }
    
    //consulta si existe la nueva clave de persona ingresada
    public function valida_nueva_persona($clave) {
        $sqlvnp="select * from vw_personas where persona_cve = '$clave';";
        $resultvnp = pg_query($this->conexion,$sqlvnp) or die("Error vnp: ". pg_last_error());//valida nueva persona
        if($rowvnp=pg_fetch_array($resultvnp)){
            if($rowvnp['persona_cve'] == $clave){
                $this->msj = 1;
            }else{
                $this->msj = 0;
            }
        }else{
            $this->msj = 0;
        }
    }
    
    //consulta si el nombre completo dado existe en la base de datos
    public function valida_nueva_persona_nombre($nombre) {
        $sqlvnp="select * from vw_personas where nombrecompleto like '%$nombre%';";
        $resultvnp = pg_query($this->conexion,$sqlvnp) or die("Error vnc: ". pg_last_error());//valida nueva persona
        if($rowvnp=pg_fetch_array($resultvnp)){
            if($rowvnp['nombrecompleto'] == $nombre){
                $this->msj = 1;
            }else{
                $this->msj = 0;
            }
        }else{
            $this->msj = 0;
        }
    }
    
    public function exito($css) {
        echo '<script type="text/javascript">window.opener.genera();</script>';
        echo '<script type="text/javascript">
                setTimeout("self.close();",4000);
              </script>'; 
        echo '<link href="'.$css.'" type="text/css" rel="stylesheet">';
        echo '<div class="padre">
                <div class="hijo">
                    <img class="icono" src="../../../../images/guardado2.png" alt="icono2" srcset="">
                    <h2 class="texto5">Registro Guardado!!</h2>
                    <h4 class="texto5">La ventana se cerrarra en automaico!</h4>
                </div>
             </div>';
    }
     
    //Funcion para insertar nuevas personas
    public function generales_personas($clave,$nombre,$paterno,$materno,$calle,$numero,$colonia,$cp,$pais,$estado,$municipio,$nacionalidad,$rfc,$nss,$curp,$genero,$correo,$telefono,$celular,$fecha_nac,$fecha,$hora,$status, $edad, $civil,$usid,$fechaedicion,$horaedicion,$usidedito,$afore,$creinfo,$pensionado) {
        $sqli = "insert into personas (persona_cve,persona_nombre,persona_paterno ,persona_materno,persona_calle,persona_calle_numero,persona_colonia,persona_cp,pais_id,est_id,mcp_id,nacionalidad_id,persona_rfc ,persona_nss ,persona_curp, persona_genero,persona_correo, persona_tel_fijo, persona_tel_movil, persona_fecnac, persona_registro_dia, persona_registro_hora, persona_status, persona_edad, persona_edo_civil, us_id,persona_edicion_dia, persona_edicion_hora, us_id_edito, persona_afore, persona_credito_infonavit,persona_pensionado) "
                ."values ('$clave','$nombre','$paterno','$materno','$calle','$numero','$colonia','$cp','$pais','$estado','$municipio','$nacionalidad','$rfc','$nss','$curp', '$genero','$correo', '$telefono', '$celular','$fecha_nac', '$fecha', '$hora', '$status', '$edad','$civil',$usid,'$fechaedicion','$horaedicion',$usidedito,'$afore','$creinfo',$pensionado);";
        $resulti = pg_query($this->conexion, $sqli) or die("Error pn: ". pg_last_error());//persona nueva
        $this->inserts='1';
        
        $sqlnpid="select * from vw_personas where persona_cve = '$clave'";
        $resultnpid=pg_query($this->conexion,$sqlnpid) or die("Error npid: ". pg_last_error());//nueva persona id
        $rownpid= pg_fetch_array($resultnpid);
        $this->npid=$rownpid['persona_id'];
    }
    
    //funcion para insertar los datos bancarios de los empleados
    public function banco_personas($banco_id,$persona_id,$db_cve,$db_cuenta) {
        $sqlb = "insert into data_bank(banco_id, persona_id, db_cve, db_cuenta) "
               . "values($banco_id,$persona_id,'$db_cve', '$db_cuenta');";
        $resultb= pg_query($this->conexion, $sqlb) or die("Error db: ". pg_last_error());//datos bancarios
        $this->inserts.='1';       
    }
    
    //funcion para registrar los documentos entregados por los empleados
    public function docs_personas($_p_id,$_comprobante,$_ine,$_lic_manejo,$_acta_nac,$_rfc,$_nss,$_curp,$_estudio,$_recomendacion,$_policia,$_fonacot,$_infonavit) {
        //echo 'id:'.$_p_id.' comprobante:'.$_comprobante.' ine:'.$_ine.' licencia:'.$_lic_manejo.' acta:'.$_acta_nac.' rfc:'.$_rfc.' nss:'.$_nss.' curp:'.$_curp.' estudio:'.$_estudio.' recomendacion:'.$_recomendacion.' policia:'.$_policia.' fonacot:'.$_fonacot.' infonavit:'.$_infonavit;
        $sqld="insert into doc_personas (persona_id,doc_comprobante,doc_ine,doc_lic_manejo,doc_acta_nac,doc_rfc,doc_nss,doc_curp,doc_estudio,doc_recomendacion,doc_policia,doc_fonacot,doc_infonavit)"
             . "values($_p_id,$_comprobante,$_ine,$_lic_manejo,$_acta_nac,$_rfc,$_nss,$_curp,$_estudio,$_recomendacion,$_policia,$_fonacot,$_infonavit)";
        $resultd= pg_query($this->conexion, $sqld) or die("Error dp: ". pg_last_error());//documentos persona
        $this->inserts.='1';    
    }
    
    //consulta datos de persona para mostrarlos en el formulario para su edicion
    public function consulta_persona($prs) {
        $sqlprs="select * from personas where persona_id = '$prs'";
        $resultprs=pg_query($this->conexion,$sqlprs) or die("Error prs: ". pg_last_error());//consulta datos de la persona seleccionada
        $rowprs= pg_fetch_array($resultprs);
        $this->generales=$rowprs;
        
        $sqlbnk="select * from data_bank where persona_id = '$prs'";
        $resultbnk=pg_query($this->conexion,$sqlbnk) or die("Error prs: ". pg_last_error());//consulta datos de la persona seleccionada
        $rowbnk= pg_fetch_array($resultbnk);
        $this->bancarios=$rowbnk;
        
        $sqldoc="select * from doc_personas where persona_id = '$prs'";
        $resultdoc=pg_query($this->conexion,$sqldoc) or die("Error prs: ". pg_last_error());//consulta datos de la persona seleccionada
        $rowdoc= pg_fetch_array($resultdoc);
        $this->documentos=$rowdoc;
    }
    
    //Actualizar datos generales de personas
    public function update_personas_generales($id,$clave,$nombre,$paterno,$materno,$calle,$numero,$colonia,$cp,$pais,$estado,$municipio,$nacionalidad,$rfc,$nss,$curp,$genero,$correo,$telefono,$celular,$fecha_nac,$fecha,$hora,$status,$edad,$civil,$usid,$afore,$creinfo,$pensionado) {
        $sqlud="update personas set persona_cve ='$clave', persona_nombre='$nombre', persona_paterno='$paterno', persona_materno='$materno', persona_calle='$calle', persona_calle_numero='$numero',persona_colonia='$colonia',persona_cp='$cp',pais_id='$pais',est_id='$estado',mcp_id='$municipio',nacionalidad_id='$nacionalidad', persona_rfc ='$rfc', persona_nss='$nss', persona_curp='$curp',persona_genero ='$genero', persona_correo='$correo', persona_tel_fijo ='$telefono', persona_tel_movil ='$celular',persona_fecnac ='$fecha_nac', persona_edicion_dia='$fecha', persona_edicion_hora='$hora', persona_status='$status', persona_edad=$edad, persona_edo_civil='$civil', us_id_edito=$usid, persona_afore='$afore', persona_credito_infonavit='$creinfo',persona_pensionado=$pensionado where persona_id ='$id';";
        $resultud= pg_query($this->conexion, $sqlud) or die("Error updg: ". pg_last_error());//update personas datos generales
        $this->update='1';    
    }
    
    //actualiza datos bancarios de personas
    public function update_personas_bancos($id, $banco_id,$db_cve,$db_cuenta) {
        $sqlb = "update data_bank set banco_id=$banco_id, db_cve='$db_cve', db_cuenta='$db_cuenta'where persona_id=$id;";
         $resultb= pg_query($this->conexion, $sqlb) or die("Error updb: ". pg_last_error());//update de datos bancarios
        $this->update.='1';       
    }
    
    //funcion para actualizar los documentos entregados por las personas
    public function update_personas_docs($id,$_comprobante,$_ine,$_lic_manejo,$_acta_nac,$_rfc,$_nss,$_curp,$_estudio,$_recomendacion,$_policia,$_fonacot,$_infonavit) {
        //echo 'id:'.$_p_id.' comprobante:'.$_comprobante.' ine:'.$_ine.' licencia:'.$_lic_manejo.' acta:'.$_acta_nac.' rfc:'.$_rfc.' nss:'.$_nss.' curp:'.$_curp.' estudio:'.$_estudio.' recomendacion:'.$_recomendacion.' policia:'.$_policia.' fonacot:'.$_fonacot.' infonavit:'.$_infonavit;
        $sqld="update doc_personas set doc_comprobante=$_comprobante,doc_ine=$_ine,doc_lic_manejo=$_lic_manejo,doc_acta_nac=$_acta_nac,doc_rfc=$_rfc,doc_nss=$_nss,doc_curp=$_curp,doc_estudio=$_estudio, doc_recomendacion=$_recomendacion,doc_policia=$_policia,doc_fonacot=$_fonacot,doc_infonavit=$_infonavit where persona_id=$id;";
        $resultd= pg_query($this->conexion, $sqld) or die("Error updoc: ". pg_last_error());//update de documentos persona
        $this->update.='1';    
    }
    
    //funcion para eliminar el registro de una persona
    public function elimina_persona($id) {
        //Elimina registro de personas
        $sqlelp="delete from personas where persona_id=$id;";
        $resultelp= pg_query($this->conexion, $sqlelp) or die("Error elp: ".pg_last_error());//elimina registro de persona
        //Elimina registro de data_bak
        $sqlelb="delete from data_bank where persona_id=$id;";
        $resultelb= pg_query($this->conexion, $sqlelb) or die("Error elb: ".pg_last_error());//elimina datos bancarios de la persona
        //Elimina registros de doc_personas        
        $sqleld="delete from doc_personas where persona_id=$id;";
        $resulteld= pg_query($this->conexion, $sqleld) or die("Error eld: ".pg_last_error());//elimina el checklist de documentos entregados por la persona
    }
    
    //FUNCIONES APARTADO PUESTOS
    //Agreagar nueva plaza
    public function nuevaplaza($nombre, $status ) {
        $sqlnp="insert into plazas (plaza_nombre, plaza_activo) values ('$nombre','$status');";
        $resultnp= pg_query($this->conexion, $sqlnp) or die("Error npz: ". pg_last_error());//inserta nueva plaza
        $this->inserts='1';
    }
    
    //consultar datos de plaza existente para su edicion
    public function consulta_plaza($plz) {
        $sqlplz="select * from plazas where plaza_id = $plz;";
        $resultplz= pg_query($this->conexion, $sqlplz) or die("Error cpz: ". pg_last_error());//consulta plaza
        $rowplz= pg_fetch_array($resultplz);
        $this->plazas=$rowplz;
    }
    
    //editar plaza
    public function edita_plaza($idplz,$nombre,$status) {
        $slquplz="update plazas set plaza_nombre = '$nombre', plaza_activo = $status where plaza_id = $idplz;";
        $resultuplz= pg_query($this->conexion,$slquplz) or die("Error epz: ". pg_last_error());//edita plaza
        $this->update='1'; 
    }
    
    public function consulta_plaza_contratos($plaza) {
        $sql="select * from vw_contratos where plaza_id = $plaza and con_status = 1 order by con_id desc";
        $result= pg_query($this->conexion,$sql) or die("Error cpc:". pg_last_error());//error consultando los contratos activos de la plaza
        if($row= pg_fetch_array($result)){
            $this->consulta=0;
        }else{
            $this->consulta=1;
        }
    }
    
    //funcion para eliminar plaza
    public function elimina_plaza($plaza) {
       $sql="delete from plazas where plaza_id = $plaza"; 
       $result= pg_query($this->conexion,$sql) or die("Error bplz:". pg_last_error());//error borrando plaza
    }
    
    //Consulta de sucursales
    public function consulta_sucursal($id) {
        $sqlsuc="select * from sucursales where suc_id=$id";
        $resultsuc= pg_query($this->conexion,$sqlsuc) or die ("Error slcsuc: ".pg_last_error());//consulta sucursales
        $rows= pg_fetch_array($resultsuc);
        $this->consulta=$rows;
    }
    
    //Agrega Sucursales
    public function agrega_sucursal($nombre, $plaza, $status) {
        $sql="insert into sucursales ( suc_nombre, plaza_id, suc_activo) values ('$nombre', $plaza, $status)";
        $results= pg_query($this->conexion,$sql) or die("Error nsuc: ". pg_last_error());//nueva sucursal
        $this->inserts='1';
    }
    
    //Actualiza Sucursal
    public function actualiza_suc($id, $nombre, $plaza, $status) {
        $sql="update sucursales set suc_nombre='$nombre', plaza_id=$plaza, suc_activo=$status where suc_id=$id";
        $results= pg_query($this->conexion, $sql) or die ("Error actsuc: ". pg_last_error());//actualiza sucursal
        $this->update='1';
    }
    
    //Agrega Comisiones
    public function agrega_com($nombre, $monto, $porcentaje, $grupo, $status) {
        $sql="insert into comisiones (co_nombre, co_monto, co_porcentaje, emp_id, co_activo ) "
            . "values ('$nombre', $monto, $porcentaje, $grupo, $status)";
        $results= pg_query($this->conexion,$sql) or die("Error nco: ". pg_last_error());//nueva comision
        $this->inserts='1';
    }
    
    //Actualiza Comisiones
    public function actualiza_com($id, $nombre, $monto, $porcentaje, $grupo, $status) {
        $sql="update comisiones set co_nombre='$nombre', co_monto=$monto, co_porcentaje='$porcentaje', emp_id=$grupo, co_activo=$status where co_id = $id";
        $results= pg_query($this->conexion,$sql) or die("Error uco: ". pg_last_error());//actualiza comision
        $this->update='1';
    }
    
    //Consulta comisiones
     public function consulta_com($id) {
        $sqlsuc="select * from vw_comisiones where co_id=$id";
        $resultsuc= pg_query($this->conexion,$sqlsuc) or die ("Error cco: ".pg_last_error());//consulta comision
        $rows= pg_fetch_array($resultsuc);
        $this->consulta=$rows;
    }
    
    //Autoriza salario
    public function autoriza_salario($usid,$salario) {
        $sqlas="update salarios set sal_aprovado=1,us_id=$usid where sal_id=$salario";
        $resultas= pg_query($this->conexion,$sqlas) or die("Error as: ". pg_last_error());//autoriza salario
        $this->autoriza='1';
    }
    
    //Agrega Salarios
    public function agrega_sal($nombre,$descripcion,$monto,$tiposal,$plaza,$sucursal,$status) {
        $sql="insert into salarios (sal_nombre, sal_descripcion, plaza_id, suc_id, sal_monto, sal_tipo_id, sal_aprovado, us_id, sal_activo)"
            ."values ('$nombre', '$descripcion', $plaza, $sucursal, $monto, $tiposal, 0, 0, $status)";
        $results= pg_query($this->conexion,$sql) or die("Error agsal: ". pg_last_error());//nuevo salario
        $this->inserts='1';
    }
    
    //Actualiza datos generales salarios
    public function actualiza_sal($id,$nombre,$descripcion,$monto,$tiposal,$plaza,$sucursal,$status) {
        $sql="update salarios set sal_nombre='$nombre',sal_descripcion='$descripcion',sal_monto='$monto',sal_tipo_id=$tiposal,plaza_id=$plaza,suc_id=$sucursal,sal_activo=$status where sal_id=$id";
        $results= pg_query($this->conexion,$sql) or die("Error actsl: ". pg_last_error());//actualiza salario
        $this->update='1';
    }
    
    //consulta salarios
    public function consulta_sal($registro) {
        $sql="select * from vw_salarios where sal_id = $registro";
        $resultsal= pg_query($this->conexion,$sql) or die ("Error csl: ".pg_last_error());//consulta salarios
        $rows= pg_fetch_array($resultsal);
        $this->consulta=$rows;
    }
    
    //CONSULTAS PARA PUESTOS
    //autoriza el puesto
    public function autoriza_puesto($usid,$puesto,$fecha,$hora) {
        $sqlap="update puestos set puesto_aprovado=1,us_id=$usid,puesto_fecha='$fecha',puesto_hora='$hora' where puesto_id=$puesto";
        $resultap= pg_query($this->conexion,$sqlap) or die("Error ap: ". pg_last_error());//autoriza puesto
        $this->autoriza='1';
    }
        
    //Agrega puestos
    public function agrega_puesto($clave, $nombre, $desc, $aut, $uss, $fecha, $hora, $plaza, $sucursal, $salario, $jefe,$grupo) {
        $sql="insert into puestos (puesto_cve, puesto_nombre, puesto_descripcion, puesto_aprovado,us_id,puesto_fecha, puesto_hora, plaza_id, suc_id, sal_id, puesto_idjefe, emp_id) "
            . "values ('$clave', '$nombre', '$desc', $aut, $uss, '$fecha', '$hora', $plaza, $sucursal, $salario, $jefe, $grupo);";
        $result= pg_query($this->conexion,$sql) or die("Error apto: ". pg_last_error());
        $this->inserts='1';
    }
    
    //consulta el puesto que se ha sido agregado recientemente
    public function consulta_puesto_agregado($clave) {
        $sql="select puesto_id from puestos where puesto_cve = '$clave'";
        $result= pg_query($this->conexion, $sql) or die ("Error cons". pg_last_error());
        $rowp= pg_fetch_array($result);
        $this->consulta=$rowp;
    }
    
    //ingresa las comisiones del puesto
    public function agrega_com_puesto($puesto,$comision){
        $sql="insert into puestos_comisiones (puesto_id, co_id) values ($puesto, $comision);";
        $result= pg_query($this->conexion,$sql) or die("Error altcom: ". pg_last_error());
    }
    
    //consulta puestos
    public function consulta_puesto($registro) {
        $sqlp="select * from vw_puestos where puesto_id=$registro";
        $resultp= pg_query($this->conexion,$sqlp) or die ("Error cpue: ".pg_last_error());//consulta puestos
        $rowp= pg_fetch_array($resultp);
        $this->consulta=$rowp;
    }
    
    public function consulta_com_puesto($puesto) {
        $sql="select co_id,co_nombre from vw_puestos_comisiones where puesto_id = $puesto";
        $result = pg_query($this->conexion, $sql) or die ("Error ccpp: ". pg_last_error());
        if($row = pg_fetch_array($result)){
            do{
                $this->html.='<li class="licom"><input type="text" value="'.$row['co_id'].'" name="com[]" hidden> '.$row['co_nombre'].' <input type="button" class="delrow" onClick="eliminar(this);" value="eliminar"></li>';
            }
            while($row = pg_fetch_array($result));
        }
    }
    
    //Edita Puestos
    public function edita_puesto($registro,$clave,$nombre,$plaza,$sucursal,$salario,$jefe,$desc,$grupo) {
        $sql="update puestos set puesto_cve='$clave', puesto_nombre ='$nombre', puesto_descripcion='$desc', plaza_id=$plaza, suc_id=$sucursal, sal_id=$salario, puesto_idjefe=$jefe, emp_id=$grupo where puesto_id=$registro ";
        $result= pg_query($this-> conexion, $sql) or die("Error edpto: ". pg_last_error());
        $this->update='1';
    }
    
    //borra comisiones del puesto
    public function elimina_comision_puesto($idpuesto){
        $sql="delete from puestos_comisiones where puesto_id = $idpuesto";
        $result= pg_query($this->conexion,$sql) or die("Error bpc: ". pg_last_error());//borra puestos comisiones
        $this->flag1='1';
    }
    
    //Consulta si existe la clave del puesto
    public function valida_nuevo_puesto($clave){
        $sql="select * from vw_puestos where puesto_cve = '$clave';";
        $result = pg_query($this->conexion,$sql) or die("Error vnp: ". pg_last_error());//valida nuevo puesto
        if($row=pg_fetch_array($result)){
            if($row['puesto_cve'] == $clave){
                $this->msj = 1;
            }else{
                $this->msj = 0;
            }
        }else{
            $this->msj = 0;
        }
     }
     
     //Operaciones para las razones sociales
     //Inserta nueva razon scial
     public function agrega_razon($nombre, $dir, $repre) {
        $sql = "insert into razones (raz_nombre, raz_direccion, raz_legal)"
              . "values ('".$nombre."','".$dir."','".$repre."')";
        $result= pg_query($this->conexion,$sql) or die("Error altrzn: ". pg_last_error());
        $this->inserts.="1"; 
     }
     
     //Consulta razon social
     public function consulta_razon($registro) {
        $sql="select * from vw_razones where raz_id = $registro";
        $result = pg_query($this->conexion, $sql) or die ("Error crz: ". pg_last_error());
        $row= pg_fetch_array($result);
        $this->consulta=$row;
    }
    
    //Edita Puestos
    public function edita_razon($registro, $nombre, $dir, $repre) {
        $sql="update razones set raz_nombre='$nombre', raz_direccion='$dir', raz_legal='$repre' where raz_id=$registro";
        $result= pg_query($this-> conexion, $sql) or die("Error edraz: ". pg_last_error());
        $this->update='1';
    }
    
    public function agrega_tipoc($clave, $nombre, $plantilla) {
        $sql = "insert into tipos_contratos (tipoc_cve, tipoc_nombre, tipoc_plantilla)"
              . "values ('$clave','$nombre','$plantilla')";
        $result= pg_query($this->conexion,$sql) or die("Error alttc: ". pg_last_error());
        $this->inserts.="1"; 
    }
 
    public function consulta_tipoc($registro) {
        $sql="select * from vw_tipos_contratos where tipoc_id = $registro";
        $result = pg_query($this->conexion, $sql) or die ("Error ctc: ". pg_last_error());
        $row= pg_fetch_array($result);
        $this->consulta=$row;
    }
    
    //Edita Puestos
    public function edita_tipoc($registro, $clave, $nombre, $plantilla) {
        $sql="update tipos_contratos set tipoc_cve='$clave', tipoc_nombre='$nombre', tipoc_plantilla='$plantilla' where tipoc_id=$registro";
        $result= pg_query($this-> conexion, $sql) or die("Error edtc: ". pg_last_error());
        $this->update='1';
    }
    
    //Consulta clave de tipo de contrato
    public function valida_clave_tc($clave) {
        $sql="select * from vw_tipos_contratos where tipoc_cve= '$clave';";
        $result = pg_query($this->conexion,$sql) or die("Error vnp: ". pg_last_error());//valida nuevo puesto
        if($row=pg_fetch_array($result)){
            if($row['tipoc_cve'] == $clave){
                $this->msj = 1;
            }else{
                $this->msj = 0;
            }
        }else{
            $this->msj = 0;
        }
    }
    
    //consulta personalizada para el datagrid de contratos
    public function suc_user_aprov($usid){
        $sql="select suc_id from vw_users_plazas_sucursales where us_id = $usid";
        $result = pg_query($this->conexion,$sql) or die("Error cspu: ". pg_last_error());//consulta sucursales por usuario
        if($row = pg_fetch_array($result)){
            do{
                $this->consulta.=','.$row['suc_id'];
            }
            while($row = pg_fetch_array($result));
        }
    }
    
    //Agrega un nuevo contrato
    public function agrega_contrato($id_persona, $id_contrato, $id_razon, $id_puesto, $salario, $horario, $prueba, $adic, $fecha_ini,$fecha_fin, $status, $aimss, $bimss, $cfir, $jefe, $sdi){
        $sql = "insert into contratos (persona_id, tipoc_id, raz_id, puesto_id, sal_monto_con, con_horario, con_periodo, con_adic, con_fecha_inicio, con_fecha_fin, con_status, con_alta_imss, con_baja_imss, con_firmado, con_jefe_inmediato, sdi)
                values ($id_persona, $id_contrato, $id_razon, $id_puesto, $salario, '$horario', '$prueba', $adic, '$fecha_ini',$fecha_fin, $status, $aimss, $bimss, $cfir, $jefe, $sdi);";       
        $result = pg_query($this->conexion,$sql) or die("Error inscon: ". pg_last_error());
        $this->inserts.="1"; 
    }
    
    //Consulta si existe la clave del puesto
    public function valida_tope_salario($pid,$sal){
        $sql="select sal_monto from vw_puestos where puesto_id = $pid";
        $result = pg_query($this->conexion,$sql) or die("Error vnp: ". pg_last_error());//valida nuevo puesto
        if($row=pg_fetch_array($result)){
            if($sal <= $row['sal_monto']){
                $this->msj = 1;
            }else if($sal >= $row['sal_monto']){
                $this->msj = 0;
            }
        }else{
            $this->msj = 0;
        }
    }
    
    //Edita un contrato existente
    public function edita_contrato($registro,$id_persona, $id_contrato, $id_razon, $id_puesto, $salario, $horario, $prueba, $fecha_ini,$fecha_fin, $status, $adic, $aimss, $bimss, $cfir, $jefe, $sdi){
        $sql = "update contratos set persona_id=$id_persona, tipoc_id=$id_contrato, raz_id=$id_razon, puesto_id=$id_puesto, sal_monto_con=$salario, con_horario='$horario', con_periodo='$prueba', con_fecha_inicio='$fecha_ini', con_fecha_fin=$fecha_fin, con_adic=$adic, con_status=$status, con_alta_imss=$aimss, con_baja_imss=$bimss, con_firmado=$cfir, con_jefe_inmediato=$jefe, con_sdi=$sdi where con_id = $registro;";
        //echo $sql;
        $result= pg_query($this->conexion, $sql) or die("Error edtcon: ". pg_last_error());
        $this->update='1';
    }
    
    //Consulta un contrato
    public function consulta_cto($reg){
        $sql="select * from vw_contratos where con_id=$reg;";
        $result = pg_query($this->conexion, $sql) or die ("Error ctc: ". pg_last_error());
        $row= pg_fetch_array($result);
        $this->consulta=$row;
    }
    
    //Consulta persona para cto
    public function consulta_per_cto($reg){
        $sql="select * from personas where persona_id=$reg;";
        $result = pg_query($this->conexion, $sql) or die ("Error ctc: ". pg_last_error());
        $row= pg_fetch_array($result);
        $this->consulta2=$row;
    }
    
    //Consulta puesto para cto
    public function consulta_per_pto($reg){
        $sql="select * from vw_puestos where puesto_id=$reg;";
        $result = pg_query($this->conexion, $sql) or die ("Error ctc: ". pg_last_error());
        $row= pg_fetch_array($result);
        $this->consulta3=$row;
    }
    
    //Consulta puesto para cto
    public function consulta_sueldo_cto($reg){
        $sql="select * from vw_salarios where sal_id=$reg;";
        $result = pg_query($this->conexion, $sql) or die ("Error ctc: ". pg_last_error());
        $row= pg_fetch_array($result);
        $this->consulta4=$row;
    }
    
    //validaciones extras para contratos
    public function valida_datos_contrato($txt,$op) {
        if($op == 'pipol'){
            $sql="select * from vw_personas where nombrecompleto like '%$txt%';";
            $result= pg_query($this->conexion,$sql);
            if($row= pg_fetch_array($result)){
                $this->msj=1;
            }else{
                $this->msj=0;
            }
        }
        if($op == 'tcon'){
            $sql="select * from vw_tipos_contratos where tipoc_nombre like '%$txt%'";
            $result= pg_query($this->conexion,$sql);
            if($row= pg_fetch_array($result)){
                $this->msj=1;
            }else{
                $this->msj=0;
            }
        }
        if($op == 'pst'){
            $sql="select * from vw_puestos where puesto_nombre like '%$txt%'";
            $result= pg_query($this->conexion,$sql);
            if($row= pg_fetch_array($result)){
                $this->msj=1;
            }else{
                $this->msj=0;
            }
        }
        if($op == 'rzn'){
            $sql="select * from vw_razones where raz_nombre like '%$txt%'";
            $result= pg_query($this->conexion,$sql);
            if($row= pg_fetch_array($result)){
                $this->msj=1;
            }else{
                $this->msj=0;
            }
        }
    }
    
    public function valida_c_activos($pid,$con) {
        $sql="select count(con_status) as num_contratos_activos from vw_contratos where persona_id = $pid and con_status = 1";
        $result= pg_query($this->conexion,$sql);
        $row= pg_fetch_array($result);
        //$this->msj=$sql;
        $this->msj=$row['num_contratos_activos'];
        
    }
    
    public function consulta_exp_per($registro){
        $sql="select * from vw_personas where persona_id=$registro;";
        $result = pg_query($this->conexion, $sql) or die ("Error ctexp: ". pg_last_error());
        $row= pg_fetch_array($result);
        $this->consulta=$row;
    }
    
    public function consulta_doc_exp($exp) {
        $sql="select * from vw_doc_expedientes where exp_id= $exp;";
        $result = pg_query($this->conexion, $sql) or die ("Error ctexp: ". pg_last_error());
        $row= pg_fetch_array($result);
        $this->consulta=$row;
    }
    
    //Funiones de expedientes en la base de datos
    public function agrega_expediente($persona, $desc, $doc, $fecha, $hora, $tipo_doc) {
        $sql="insert into doc_expedientes (persona_id, exp_desc, exp_ruta, exp_fecha, exp_hora, txp_id) values ($persona,'$desc','$doc','$fecha','$hora',$tipo_doc);";
        $result = pg_query($this->conexion,$sql) or die("Error insexp: ". pg_last_error());
        $this->inserts.="1"; 
    }
    
    public function edita_expediente($registro, $desc, $doc,$fecha, $hora, $tipo_exp) {
        $sql="update doc_expedientes set exp_desc='$desc', exp_ruta='$doc', exp_fecha='$fecha', exp_hora='$hora', txp_id=$tipo_exp where exp_id=$registro";
        $result = pg_query($this->conexion,$sql) or die("Error udexp: ". pg_last_error());
        $this->update.="1"; 
    }
    
    public function consulta_permisos_actuales($nivel) {
        if($nivel == 0){
            $sql="select * from permisos where per_idpadre = 0";
            $result= pg_query($this->conexion,$sql);
            $row= pg_fetch_array($result);
            $this->consulta=$row;
        }
        if($nivel == 1){
            $sql="select * from permisos where per_idpadre = 0";
            $result= pg_query($this->conexion,$sql);
            $row= pg_fetch_array($result);
            $this->consulta1=$row;
        }
        if($nivel == 2){
            $sql="select * from permisos where per_idpadre = 0";
            $result= pg_query($this->conexion,$sql);
            $row= pg_fetch_array($result);
            $this->consulta2=$row;
        }
    }
    
    public function agrega_ausencia($persona,$tipoaus,$year,$derecho,$tomados,$disp,$vac,$rest,$diasa,$finicio,$ffin,$obs,$autorizado,$fecha,$hora,$usid,$autorizo) {
        $sql="insert into ausencias(persona_id,ta_id,aus_vac_years,aus_correspondientes,aus_tomados,aus_disponibles,aus_dias_vac,aus_restantes,aus_dias,aus_fecha_inicio,aus_fecha_fin,aus_observaciones,aus_autorizado,aus_fecha_registro,aus_hora_registro,us_id,us_id_autorizo) "
            ."values($persona,$tipoaus,$year,$derecho,$tomados,$disp,$vac,$rest,$diasa,'$finicio','$ffin','$obs',$autorizado,'$fecha','$hora',$usid,$autorizo);";
        $result = pg_query($this->conexion,$sql) or die("Error insaus: ". pg_last_error());//inserta ausencias
        $this->inserts.="1"; 
    }
    
    //consulta ausencias
    public function consulta_aus($registro) {
        $sql="select * from vw_ausencias where aus_id = $registro";
        $resultsal= pg_query($this->conexion,$sql) or die ("Error csl: ".pg_last_error());//consulta salarios
        $rows= pg_fetch_array($resultsal);
        $this->consulta=$rows;
    }
    
    //Autoriza ausencia
    public function autoriza_ausencia($usid,$ausid) {
        $sqlaus="update ausencias set aus_autorizado=1,us_id_autorizo=$usid where aus_id=$ausid";
        $resultaus= pg_query($this->conexion,$sqlaus) or die("Error aus: ". pg_last_error());//autoriza ausencia
        $this->autoriza='1';
    }
    
    //consulta datos de la ausencia registrada
    public function consulta_aus_per($registro){
        $sql="select * from vw_ausencias where aus_id = $registro;";
        $result = pg_query($this->conexion, $sql) or die ("Error ctexp: ". pg_last_error());
        $row= pg_fetch_array($result);
        $this->consulta=$row;
    }
    
    //edita los valores de la ausencia
    public function edita_ausencia($registro,$year,$derecho,$tomados,$disp,$vac,$rest,$diasa,$finicio,$ffin,$obs,$fecha,$hora,$usid) {
        $sql="update ausencias set aus_vac_years=$year, aus_correspondientes=$derecho, aus_tomados=$tomados,aus_disponibles=$disp, aus_dias_vac=$vac, aus_restantes=$rest, aus_dias=$diasa, aus_fecha_inicio='$finicio', aus_fecha_fin='$ffin', aus_observaciones='$obs', aus_fecha_registro='$fecha', aus_hora_registro='$hora', us_id=$usid  where aus_id=$registro";
        $result = pg_query($this->conexion,$sql) or die("Error udexp: ". pg_last_error());
        $this->update.="1"; 
    }
}

?>