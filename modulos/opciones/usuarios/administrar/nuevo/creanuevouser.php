<?php
include ('../../../../../conexiones/conectasql.php');
class creanuevouser extends conectasql {
    protected $revisado;
    protected $validaradmin;


    public function javascript() {
        echo '<script type="text/javascript" src="'.$this->dir.'lanzaderanuevouser.js"></script>';
        echo '<script type="text/javascript" src="../../../../../librerias/jscalendario/calendar.js" ></script>';
        echo '<script type="text/javascript" src="../../../../../librerias/jscalendario/lang/calendar-es.js"></script>';
        echo '<script type="text/javascript" src="../../../../../librerias/jscalendario/calendar-setup.js"></script>';
        echo '<script type="text/javascript" src="../../../../../librerias/menuarbolaccesible.js"></script>'; 
        echo '<script type="text/javascript" src="../../../../../librerias/jquery.js"></script>';
        echo '<script type="text/javascript" src="../../../../../librerias/dimensions.js"></script>';
        echo '<script type="text/javascript" src="../../../../../librerias/autocomplete.js"></script>';
    }
    
    public function pestanas($ruta) {
        echo '<div class="contpestanas">';
        echo '<dt class="pestaña on" id="pgeneral"><a id="_general" href="#general" onclick="mostrarPestaña(pestañas,this); return false;">
                <img src="../../../../../imagenes/usericon.png" height="12" width="12">
                Generales
              </a></dt>';
        echo '<dt class="pestaña off" id="ppermisos"><a id="_permisos" href="#permisos" onclick="mostrarPestaña(pestañas,this); return false;">
                <img src="../../../../../imagenes/shieldicon.png" height="12" width="13">
                Permisos
              </a></dt>';
       echo '<dt class="pestaña off" id="pempleados"><a id="_empleados" href="#empleados" onclick="mostrarPestaña(pestañas,this); return false;">
                <img src="../../../../../imagenes/usersicon.png" height="12" width="13">
                Empleados
              </a></dt>';
        echo '<form id="nuevouser" name="nuevouser" method="post" action="'.$ruta.'?var='.$this->modifica.'" >';
        echo '<dd id="general" class="carpeta" style="display: block;">';
        $this->dgenerales();
        echo '</dd>';
        echo '<dd id="permisos" class="carpeta" style="display: none;">';
        $this->dpermisos();
        echo '</dd>';
        echo '<dd id="empleados" class="carpeta" style="display: none;">';
        $this->dempleados();
        echo '</dd>';
        echo '<input type="button" id="agregauser" name="agregauser" class="index2" value="Aceptar" onclick="valida_nuevouser();">';
        echo '<input type="button" id="cancelauser" name="cancelauser" class="index2" value="Cancelar" onclick="self.close();">';
        echo '</form>';
        echo '</div>';
    }
    
    public function dgenerales(){
        if($this->modifica != NULL){
        include ('../../../../../conexiones/config2.php');
        $this->conectasql($rdb, $tipodb, $servidor, $port, $usuariodb, $pasdb, $database);
        $sqleditar="select * from usuarios where us_id = $this->modifica;";
        $resulteditar=  pg_query($this->rdb,$sqleditar);
        $roweditar=  pg_fetch_array($resulteditar);
        $this->validaradmin = $roweditar['us_admin'];}
        echo '<div class="anombre" name="cnombrecompleto" id="cnombrecompleto">Nombre completo</div>'; 
        echo '<div class="cid">Id: <input type="text" class="campobuscarid" id="usid" name="usid" readonly="yes" value="'.$roweditar['us_id'].'" disabled></div>';
        echo '<div class="cnombre" >Nombre: <input type="text" class="campobuscar" id="usnombre" name="usnombre" value="'.$roweditar['us_nombre'].'" onkeypress="return sololetras(event);"></div>';
        echo '<div class="cpaterno">Apellido Paterno: <input type="text" class="campobuscar" id="uspaterno" name="uspaterno" value="'.$roweditar['us_apellidopaterno'].'" onkeypress="return sololetras(event);"></div>';
        echo '<div class="cmaterno">Apellido Materno: <input type="text" class="campobuscar" id="usmaterno" name="usmaterno" value="'.$roweditar['us_apellidomaterno'].'" onkeypress="return sololetras(event);"></div>';
        if($roweditar['us_admin'] == 't'){$admin ='checked';}
        echo '<div class="cadmin"><input type="checkbox" class="campobuscaradmin" id="usadmin" name="usadmin" onclick="estado();" '.$admin.'> Administrador</div>';
        if($roweditar['us_habilitado'] == 't'){$activo ='checked';}
        echo '<div class="chabilitado"><input type="checkbox" id="ushabilitado" name="ushabilitado" '.$activo.'> Habilitado</div>';
        echo '<div class="apasguord" name="addpasguord" id="addpasguord">Contraseña</div>'; 
        echo '<div class="cpasguord" >Contraseña: <input type="password" class="campobuscar" id="uspassword" name="uspassword" value="'.$roweditar['us_password'].'"></div>';
        echo '<div class="acontacto" name="acontacto" id="acontacto">Contacto</div>'; 
        echo '<div class="cemail" >Correo: <input type="text" class="campobuscar" id="usemail" name="usemail" value="'.$roweditar['us_email'].'"></div>';
        echo '<div class="ctelefono" >Telefono: <input type="text" class="campobuscar" id="ustelefono" name="ustelefono" onKeyPress="return solonumeros(event);" value="'.$roweditar['us_numtelefono'].'"></div>';
        echo '<div class="alogin" name="alogin" id="alogin">Clave de usuario</div>'; 
        echo '<div class="clogin" >Login: <input type="text" class="campobuscar" id="uslogin" name="uslogin" align="absmidle" onblur="asigna(event,\''.$this->dir.'\');" value="'.$roweditar['us_login'].'"></div>';
        echo '<div class="afechacaducidad" name="afechacaducidad" id="afechacaducidad">Fecha de caducidad</div>'; 
        echo '<div class="cfechacaducidad" >Fecha: <input type="text" class="campobuscar" id="usfechacaducidad" name="usfechacaducidad" readonly="readonly" value="'.$roweditar['us_fechacaducidad'].'">';
        echo '<img src="../../../../../imagenes/calendario.png" height="25" width="25" name="icono" id="icono" align="absmiddle" class="fecha"></div>';
        echo '<script type="text/javascript">
             Calendar.setup({
             inputField: "usfechacaducidad",
             ifFormat:   "%d-%m-%Y",
             weekNumbers: false,
             displayArea: "icono",
             daFormat:    "%A, %d de %B de %Y"
              });
             </script>';
        echo '<div class="alaboral" id="alaboral" name="aloboral">Centro laboral</div>';
        echo '<div class="claboral" id="claboral" name="claboral">Centro: ';
        echo '<select class="selectbuscar" name="uscentro" style="width:100px;">';
        echo '<option value="0">--- opcion ---</option>';
        include ('../../../../../conexiones/config2.php');
        $this->conectasql($rdb, $tipodb, $servidor, $port, $usuariodb, $pasdb, $database);
        $sqlcentros="select * from centrolaboral order by centrolab_id";
        $resultcentro=  pg_query($this->rdb,$sqlcentros);
        if($rowcentros=  pg_fetch_array($resultcentro)){
            do{
                if($roweditar['centrolab_id'] == $rowcentros['centrolab_id']){$centro='selected';}
                echo '<option value="'.$rowcentros['centrolab_id'].'" '.$centro.'>'.$rowcentros['centrolab_nombre'].'</option>';
                unset($centro);
            }
            while ($rowcentros=  pg_fetch_array($resultcentro));
        }
        echo '</select>';
        echo '</div>';
        
    }
    
    public function dpermisos(){
        include ('../../../../../conexiones/config2.php');
        $this->conectasql($rdb, $tipodb, $servidor, $port, $usuariodb, $pasdb, $database);
        $sqlpermisos="select per_id,estmenu_descripcion,estmenu_id,estmenu_idpadre from vw_permisos where estmenu_idpadre = 0 order by estmenu_nombre";
        $resultp=  pg_query($this->rdb,$sqlpermisos);
        if($rowp=  pg_fetch_array($resultp)){
            echo '<div id="arbolpermisos">';
                echo '<ul id="menu1">';
                    do{
                    if($this->modifica != NUll){$this->bpermiso($this->modifica,$rowp['per_id']);}
                    echo '<li>'.$rowp['estmenu_descripcion'].'.....<input type="checkbox" onclick="marcar(this.parentNode,this)" id="tpermiso[]" name="marca[]" value="'.$rowp['per_id'].'" '.$this->revisado.'>';
                            $subcarpetas="select per_id,estmenu_descripcion,estmenu_id,estmenu_idpadre from vw_permisos where estmenu_idpadre =".$rowp['estmenu_id']." order by estmenu_nombre";
                            $resultsubc=  pg_query($this->rdb,$subcarpetas);
                            if($rowsubc=  pg_fetch_array($resultsubc)){
                                echo '<ul>';
                                    do{
                                        if($this->modifica != NUll){$this->bpermiso($this->modifica,$rowsubc['per_id']);}
                                        echo '<li>'.$rowsubc['estmenu_descripcion'].'.....<input type="checkbox" id="tpermiso[]" name="marca[]" value="'.$rowsubc['per_id'].'" '.$this->revisado.'>';
                                                $subpermisos="select per_id,estmenu_descripcion,estmenu_id,estmenu_idpadre from vw_permisos where estmenu_idpadre =".$rowsubc['estmenu_id']." order by estmenu_nombre";
                                                $resultsubp=  pg_query($this->rdb,$subpermisos);
                                                if($resultsubp != NULL){
                                                    if($rowsubp=  pg_fetch_array($resultsubp)){
                                                        echo '<ul>';
                                                            do{
                                                            if($this->modifica != NUll){$this->bpermiso($this->modifica,$rowsubp['per_id']);}
                                                            echo '<li>'.$rowsubp['estmenu_descripcion'].'.....<input type="checkbox" id="tpermiso[]" name="marca[]" value="'.$rowsubp['per_id'].'" '.$this->revisado.'>';
                                                            echo '</li>';
                                                            }
                                                            while ($rowsubp=  pg_fetch_array($resultsubp));
                                                        echo '</ul>';
                                                    }
                                                }
                                        echo '</li>';
                                    }
                                    while ($rowsubc=  pg_fetch_array($resultsubc));
                                echo '</ul>';
                            }

                    echo '</li>';    
                    }
                    while ($rowp=  pg_fetch_array($resultp));
                echo '</ul>';
                echo '<script type="text/javascript">iniciaMenu(\'menu1\')</script>';
            echo '</div>';
            if($this->validaradmin == 't'){$evitaredicion = 'display:block;';}else{$evitaredicion ='';}
            echo '<div id="ocontroles" name="ocontroles" style="'.$evitaredicion.'"></div>';
        }
        
    }
    
    public function bpermiso($userid,$perid) {
        include ('../../../../../conexiones/config2.php');
        $this->conectasql($rdb, $tipodb, $servidor, $port, $usuariodb, $pasdb, $database);  
        $sqlbpermiso="select * from vw_usuarios_permisos where per_id = $perid and us_id = $userid ";
        $resultbpermiso=  pg_query($this->rdb,$sqlbpermiso);
        $rowbpermiso=  pg_fetch_array($resultbpermiso);
            if($rowbpermiso['per_id'] != NULL){
                $this->revisado = 'checked';
            }else{
                $this->revisado = '';
            }
    }
    
    public function dempleados() {
       echo '<script type="text/javascript">
                    $(function(){
                        setAutoComplete("asignarempleado", "results", "'.$this->dir.'data.php?part=");
                    });
            </script>';
     echo '<div class="empleado">';
     echo '<div class="bempleado" align="absmiddle">';
     echo '<p id="auto">Empleado: <input type="text" id="asignarempleado" style="background-color:white;" placeholder="  Ej: Jose Cardenas" class="campobuscar" onkeypress="return sololetras(event);"></p> 
           <div style="margin-top:-18px;margin-left:223px;width:40px;"><a onclick="addRow(\'datatable\');"><img id="plus" src="../../../../../imagenes/plusicon.png" width="16" height="16"></a>
           <a onclick="deleteRow(\'datatable\');"><img id="minus" src="../../../../../imagenes/minusicon.png" width="16" height="16"></a></div>';
     echo '</div>';
     
     echo '<div class="empleadoasignado">'; 
     echo '<div class="buscaasignado">';
     echo '<div style="margin-left:5px;margin-top:2px;">Filtrar: <input id="contenidotabla" type="text" class="campobuscar" onkeyup="dosearch();"></div>';
     echo '</div>';
     echo '<div class="verasignados" scrolling="auto">';   
        echo '<table class="datatable" id="datatable">';
            echo '<tr><td style="color:white;"><img id="space" src="../../../../../imagenes/cuadroicon.png"></td><td width="240px" style="font-weight:bold;">Nombre</td></tr>';
            //echo '<tr><td><input type="checkbox"></td><td>hola '.$this->modifica.'</td><td><input type="checkbox" value="hola" hidden="hidden"></td></tr>';
            include ('../../../../../conexiones/config2.php');
            $this->conectasql($rdb, $tipodb, $servidor, $port, $usuariodb, $pasdb, $database);
            $sqlempleado="select * from usuarios_empleados where us_id = $this->modifica ";
            $resultempleado=  pg_query($this->rdb,$sqlempleado);
            if($rowempleado= pg_fetch_array($resultempleado)){
                do{
                    $a = $rowempleado['empleado_id'];
                    $sql="select * from vw_empleados where empleado_id = $a";
                    $result=  pg_query($this->rdb,$sql);
                    if($row=  pg_fetch_array($result)){
                        do{
                        echo '<tr><td><input type="checkbox"></td><td>'.$row['nombrecompleto'].'</td><td><input type="checkbox" name="asignacion[]" class="aoculto" value="'.$row['nombrecompleto'].'" hidden="hidden" checked="checked"></td></tr>';
                    
                        }
                        while ($row=  pg_fetch_array($result));
                    }
                }
                while ($rowempleado= pg_fetch_array($resultempleado));
            }
        echo '</table>';
     echo '</div>';
     echo '</div>';
     
     echo '</div>';
    }
    
    public function agregausuario($nombre,$paterno,$materno,$admin,$habilitado,$pasguord,$correo,$tel,$login,$fecha,$centro,$permisos,$empleados) {
        include ('../../../../../conexiones/config2.php');
        $this->conectasql($rdb, $tipodb, $servidor, $port, $usuariodb, $pasdb, $database);
        //esta parte agrega los datos del usuario
        if($nombre != null && $paterno != NULL && $materno != NULL && $pasguord != NULL && $correo != NULL && $tel != NULL && $login != NULL && $fecha != NULL){
        $sqlagrega="select agregar_usuarios_func('$nombre','$paterno','$materno',md5('$pasguord'),'$login','$fecha','$correo','$tel','$admin','$habilitado',$centro)";
        $resultagrega=  pg_query($this->rdb,$sqlagrega);
        }
        $user="select us_id from vw_usuarios where us_login = '$login'";
        $resultuser=  pg_query($this->rdb,$user);
        $rowuser=  pg_fetch_array($resultuser);
        $id=$rowuser['us_id'];
        //esta parte agrega los permisos para el usuario nuevo
        if($admin == 'false'){
            foreach ($permisos as $llave) {
               $sqlpermiso="select agregar_usuarios_permisos_func($id,$llave)";
               $resultpermiso=  pg_query($this->rdb,$sqlpermiso);
               unset($sqlpermiso);
               unset($resultpermiso);
            }
        }
        //esta parte agrega los empleados que tendra a su cargo el usuario nuevo
        foreach ($empleados as $asignado) {
            $nombrecompleto=$nombre.' '.$paterno.' '.$materno;
            if($nombrecompleto != $asignado){
            $sqlempleado="select * from vw_empleados where nombrecompleto = '$asignado'";
            $resultempleado=  pg_query($this->rdb,$sqlempleado);
            $rowempleado=  pg_fetch_array($resultempleado);
            $idempleado=$rowempleado['serial'];
            $usuarioempleado="select agregar_usuarios_empleados_func($id,$idempleado)";
            $resultusuarioempleado=  pg_query($this->rdb,$usuarioempleado);
            unset($sqlempleado);
            unset($resultempleado);
            unset($rowempleado);
            unset($idempleado);
            unset($usuarioempleado);
            unset($resultusuarioempleado);
            unset($nombrecompleto);
            }
        }
        echo '<script>window.close();</script>';
    }
    
    public function editauser($nombre,$paterno,$materno,$admin,$habilitado,$pasguord,$correo,$tel,$login,$fecha,$centro,$permisos,$empleados,$dato) {
        include ('../../../../../conexiones/config2.php');
        $this->conectasql($rdb, $tipodb, $servidor, $port, $usuariodb, $pasdb, $database);
        $sqlid="select * from usuarios where us_id = $dato";
        $resultid=  pg_query($this->rdb,$sqlid);
        $rowid=  pg_fetch_array($resultid);
        if($nombre != $rowid['us_nombre']){
            $sqlupdate="update usuarios set us_nombre = '$nombre' where us_id = $dato";
            $resultupdate=  pg_query($this->rdb,$sqlupdate);
        }
        if($paterno != $rowid['us_apellidopaterno']){
            $sqlupdate="update usuarios set us_apellidopaterno = '$paterno' where us_id = $dato";
            $resultupdate=  pg_query($this->rdb,$sqlupdate);
        }
        if($materno != $rowid['us_apellidomaterno']){
            $sqlupdate="update usuarios set us_apellidomaterno = '$materno' where us_id = $dato";
            $resultupdate=  pg_query($this->rdb,$sqlupdate);
        }
        if($admin != NULL){
            if($admin == 'true'){$p='t';}else{$p='f';}
            if($p != $rowid['us_admin']){
                $sqlupdate="update usuarios set us_admin = '$admin' where us_id = $dato";
                $resultupdate=  pg_query($this->rdb,$sqlupdate);
            }
        }
        if($habilitado != NULL){
            if($habilitado == 'true'){$p='t';}else{$p='f';}
            if($p != $rowid['us_habilitado']){
                $sqlupdate="update usuarios set us_habilitado = '$habilitado' where us_id = $dato";
                $resultupdate=  pg_query($this->rdb,$sqlupdate);
            }
        }
        if($pasguord != $rowid['us_password']){
            if(md5($pasguord) != $rowid['us_password']){
                $sqlupdate="update usuarios set us_password = $pasguord' where us_id = $dato";
                $resultupdate=  pg_query($this->rdb,$sqlupdate);
            }
        }
        if($correo != $rowid['us_email']){
            $sqlupdate="update usuarios set us_email = '$correo' where us_id = $dato";
            $resultupdate=  pg_query($this->rdb,$sqlupdate);
        }
        if($tel != $rowid['us_numtelefono']){
            $sqlupdate="update usuarios set us_numtelefono = $tel where us_id = $dato";
            $resultupdate=  pg_query($this->rdb,$sqlupdate);
        }
        if($login != $rowid['us_login']){
            $sqlupdate="update usuarios set us_login = '$login' where us_id = $dato";
            $resultupdate=  pg_query($this->rdb,$sqlupdate);
        }
        if($fecha != $rowid['us_fechacaducidad']){
            $sqlupdate="update usuarios set us_fechacaducidad = '$fecha' where us_id = $dato";
            $resultupdate=  pg_query($this->rdb,$sqlupdate);
        }
        if($centro != $rowid['centrolab_id']){
            $sqlupdate="update usuarios set centrolab_id = $centro where us_id = $dato";
            $resultupdate=  pg_query($this->rdb,$sqlupdate);
        }
        if($admin == 'false' && $permisos != NULL){
            $p="delete from usuarios_permisos where us_id = $dato";
            $resultp=  pg_query($this->rdb,$p);
            foreach ($permisos as $llave) {
               $sqlpermiso="select agregar_usuarios_permisos_func($dato,$llave)";
               $resultpermiso=  pg_query($this->rdb,$sqlpermiso);
               unset($sqlpermiso);
               unset($resultpermiso);
            }
        }
        if($empleados != NULL){
            $p="delete from usuarios_empleados where us_id = $dato";
            $rowp=  pg_query($this->rdb,$p);
            foreach ($empleados as $asignado) {
            $nombrecompleto=$nombre.' '.$paterno.' '.$materno;
                if($nombrecompleto != $asignado){
                    $sqlempleado="select * from vw_empleados where nombrecompleto = '$asignado'";
                    $resultempleado=  pg_query($this->rdb,$sqlempleado);
                    $rowempleado=  pg_fetch_array($resultempleado);
                    $idempleado=$rowempleado['serial'];
                    $usuarioempleado="select agregar_usuarios_empleados_func($dato,$idempleado)";
                    $resultusuarioempleado=  pg_query($this->rdb,$usuarioempleado);
                    unset($sqlempleado);
                    unset($resultempleado);
                    unset($rowempleado);
                    unset($idempleado);
                    unset($usuarioempleado);
                    unset($resultusuarioempleado);
                    unset($nombrecompleto);
                }
            }
        }
        echo '<script>self.close();</script>'; 
    }
    
}
?>

