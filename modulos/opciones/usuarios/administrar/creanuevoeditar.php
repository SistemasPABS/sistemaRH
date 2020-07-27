<?php
include ('../../../../config/conectasql.php');

class creanuevoeditar extends conectasql{
    protected   $usid;
    protected   $estid;
    protected   $option;






    public function _construct($usid, $estid) {
        $this->usid = $usid;
        $this->estid = $estid;
    }
    
    public function librerias() {
        echo '<link href="../../../../estilos/personasStyles.css" type="text/css" rel="stylesheet">';
        echo '<link href="../../../../estilos/estilos.css" type="text/css" rel="stylesheet">';
        echo '<link href="../../../../estilos/estiloarbol.css" type="text/css" rel="stylesheet" >';
        echo '<script type="text/javascript" src="../../../../librerias/jquery-1.10.2.min.js"></script>';
        echo '<script type="text/javascript" src="lanzaderauser.js"></script>';
        echo '<script type="text/javascript" src="../../../../librerias/menuarbolaccesible.js"></script>'; 
        echo '<script type="text/javascript" src="../../../../librerias/jquery.js"></script>';
        echo '<script type="text/javascript" src="../../../../librerias/dimensions.js"></script>';

    }
    
    public function formulario($op,$usr) {
        $this->option=$op;
        if($op == 'editar'){
            $titulo='Edita usuario';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->consulta_plaza($usr);
        }else if($op == 'nuevo'){
            $titulo='Nuevo usuario';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
        }
        
        echo '<head><title> '.$titulo.' </title></head>';
        echo '<div class="contpestanas">';
        echo '<dt class="pestaña on" id="pgeneral"><a id="_general" href="#general" onclick="mostrarPestaña(pestañas,this); return false;">
                <img src="../../../../images/usericon.png" height="12" width="12">
                Generales
              </a></dt>';
        echo '<dt class="pestaña off" id="ppermisos"><a id="_permisos" href="#permisos" onclick="mostrarPestaña(pestañas,this); return false;">
                <img src="../../../../images/shieldicon.png" height="12" width="13">
                Permisos
              </a></dt>';
       
        echo '<form id="nuevouser" name="nuevouser" method="post" action="agregausuario.php" >';
        echo '<dd id="general" class="carpeta" style="display: block;">';
        $this->dgenerales();
        echo '</dd>';
        echo '<dd id="permisos" class="carpeta" style="display: none;">';
        $this->dpermisos();
        echo '</dd>';
        echo '<input type="button" id="agregauser" name="agregauser" class="index2" style="margin-top:10px;" value="Aceptar" onclick="valida_nuevouser();">';
        echo '<input type="button" id="cancelauser" name="cancelauser" class="index2" style="margin-left:5px;" value="Cancelar" onclick="self.close();">';
        echo '</form>';
        echo '</div>';
    }
    
    public function dgenerales(){
        if($this->option == 'nuevo'){
            $selectsuc='<select class="input0" name="sucursales" id="sucursales" value="0">
                            <option value="1000">Seleccione una plaza</option>
                        </select>';
        }else if($this->option == 'editar'){
            $selectsuc='';
        }
        
        echo '<div class="row">';
                echo '<div class="col-2"';
                    echo '<h2>Datos generales</h2>';
                echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="col-4"><br><label>Status</label><input type="checkbox" name="estatus" id="estatus" ></div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="col-4"><label>Nombre</label><br><input class="input0" type="text" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="" placeholder="Nombre" required><input name="registro" id="registro" value="" hidden></div>';
            echo '<div class="col-4"><label>Apellido Paterno</label><br><input class="input0" type="text" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="" placeholder="Nombre" required></div>';
            echo '<div class="col-4"><label>Apellido Materno</label><br><input class="input0" type="text" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="" placeholder="Nombre" required></div>';
            echo '<div class="col-4"><label>Login</label><br><input class="input0" type="text" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="" placeholder="Nombre" required></div>';
            echo '<div class="col-4"><label>Password</label><br><input class="input0" type="password" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="" placeholder="Nombre" required></div>';
            echo '<div class="col-4"><label>Correo</label><br><input class="input0" type="text" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="" placeholder="Nombre" required></div>';
        echo '</div>';
        
        echo '<div class="row" style="margin-top:10px;">';
                echo '<div class="col-4"';
                    echo '<h2>Plazas y sucursales</h2>';
                echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<label>Plaza</label><br>';
                $this->selects_creator('select * from plazas order by plaza_id','plazas','plaza_id','plaza_nombre','plazas','onChange= "ver_sucursales();"',$selectdefault);
                echo $this->select; 
                echo '<br>';
            echo '<label>Sucursales</label><br>';
            echo '<div id="cont_se">';
                echo $selectsuc;
            echo '</div>';
            echo '<div class="col-4" style="margin-top:0px;">';
                    echo '<a class="btnadd2" onclick="myFunction();"> Agregar ></a>';
            echo '</div>';
            echo '<div class="col-5" style="margin-left:55px;margin-top:5px;">';
                echo '<ul id="myList">';
                    //echo '<li><input type="text" value="" name="com[]" hidden> bla bla bla <input type="button" onclick="eliminar(this)" value="eliminar"></li>';
                    echo $this->html;
                echo '</ul>';
            echo '</div>';
        echo '</div>';
        
        echo '<div class="row" style="margin-top:10px;">';
               echo '<div class="col-4"';
                   echo '<h2>Perfiles</h2>';
               echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<label>Perfiles disponibles</label><br>';
            $this->selects_creator('select * from perfiles where perf_activo = 1 order by perf_id','perfiles','perf_id','perf_nombre','perfiles','onChange= ""',$selectdefault);
            echo $this->select; 
            echo '<br>';
        echo '</div>';
    }
    
    public function dpermisos(){
        $sqlp0="select * from permisos where per_idpadre = 0 order by per_id";
        $resultp0= pg_query($this->conexion,$sqlp0);
        if($rowp0=  pg_fetch_array($resultp0)){
            echo '<div id="arbolpermisos">';
                echo '<ul id="menu1">';
                    do{
                    echo '<li>'.$rowp0['per_nombre'].'.....<input type="checkbox" onclick="marcar(this.parentNode,this)" id="tpermiso[]" name="marca[]" value="'.$rowp0['per_id'].'">';
                            $sqlp1="select * from permisos where per_idpadre = ".$rowp0['per_id']." order by per_id desc";
                            $resultp1=  pg_query($this->conexion,$sqlp1);
                            if($rowp1=  pg_fetch_array($resultp1)){
                                echo '<ul>';
                                    do{
                                        echo '<li>'.$rowp1['per_nombre'].'.....<input type="checkbox" id="tpermiso[]" name="marca[]" value="'.$rowp1['per_id'].'" >';
                                                $sqlp2="select * from permisos where per_idpadre = ".$rowp1['per_id']." order by per_id desc";
                                                $resultp2=  pg_query($this->conexion,$sqlp2);
                                                if($rowp2=  pg_fetch_array($resultp2)){
                                                        echo '<ul>';
                                                            do{
                                                                echo '<li>'.$rowp2['per_nombre'].'.....<input type="checkbox" id="tpermiso[]" name="marca[]" value="'.$rowp2['per_id'].'">';
                                                                echo '</li>';
                                                            }
                                                            while ($rowp2=  pg_fetch_array($resultp2));
                                                        echo '</ul>';
                                                }
                                        echo '</li>';
                                    }
                                    while ($rowp1=  pg_fetch_array($resultp1));
                                echo '</ul>';
                            }

                    echo '</li>';    
                    }
                    while ($rowp0=  pg_fetch_array($resultp0));
                echo '</ul>';
                echo '<script type="text/javascript">iniciaMenu(\'menu1\')</script>';
            echo '</div>';
            echo '<div id="ocontroles" name="ocontroles" style="'.$evitaredicion.'"></div>';
        }
        
    }
}
?>