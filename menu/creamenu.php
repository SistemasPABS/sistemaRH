<?php
include '../config/conectasql.php';

class creamenu extends conectasql{
    protected $usid;

    public function __construct($usid) {
     $this->usid = $usid;
    }
    
    public function librerias() {
        echo '<link href="../estilos/estilo_menu.css" type="text/css" rel="stylesheet">';
        echo '<script type="text/javascript" src="lanzadera_menu.js"></script>';
    }
    
    public function interfaz() {
        echo '<div class="marco2">';
        /*contenedor donde se estaran actualizando las pantallas*/
        echo '<iframe src="" class="contenedor" name="contenedor" id="contenedor" scrolling="yes"></iframe>';
        echo '<div class="control">';
            echo '<div class="opcionesmenu">';
            
            $this->abre_conexion("0");
            $this->permisos("menu",0,$this->usid);
            //se recorre el arreglo $this->p1 para pintar las opciones de menu para el usuario en cuestion
            for($i = 0; $i < count($this->p1); $i++){
                
                $menu1 = explode(',',$this->p1[$i]);
                echo '<ul class="nav">';
                    echo '<li class="nav2"> <a>'.$menu1[3].'</a>';
                        
                        //se llama la funcion permisos para saber a que submenus tiene derecho cada usuario
                        $this->permisos('submenu',$menu1[1],$this->usid);
                        if($this->p2 != ''){echo '<ul>';}   
                            //se recorre el arreglo $this->p2 para agregar las opciones de submenu que existen para el menu en custion que tiene el usuario
                            for($x = 0; $x < count($this->p2); $x++){
                                $menu2 = explode(',',$this->p2[$x]);
                                //em=estructura menu id encriptado
                                echo '<li><a onclick="opcion(\''.$menu2[4].'?em='.base64_encode($menu2[1]).'\');">'.$menu2[3].'</a></li>';
                            }
                        if($this->p2 != ''){echo '</ul>';}
                        //limpiar las variables de los arreglos para los submenus
                        unset($menu2);
                        unset($this->p2);
                        
                        
                        //se llama la funcion permisos para agregar aplicaciones en forma de submenus
//                        $this->permisos('app',$menu1[1],$this->usid);
//                        if($this->p4 != ''){echo '<ul>';}   
//                            //se recorre el arreglo $this->p4 para agregar las opciones de submenu que existen para el menu en custion que tiene el usuario
//                            for($z = 0; $z < count($this->p4); $z++){
//                                $menu3 = explode(',',$this->p4[$z]);
//                                echo '<li><a href="'.$menu3[4].'?var1='.base64_encode($this->usid).'&nav='.$this->nav.'&estid='.$menu3[1].'" onclick="window.open(this.href);return false;">'.$menu3[3].'</a></li>';
//                            }
//                        if($this->p4 != ''){echo '</ul>';}
//                        //limpiar las variables de los arreglos para los submenus
//                        unset($menu3);
//                        unset($this->p4);
                        
                    echo '</li>';
                echo '</ul>';
                
            }
            
            //se obtiene login del usuario mediante usid
            $this->uslogin($this->usid);
            
//                echo '<ul class="nav">';
//                    echo '<li class="nav2"> <a>menu 2</a>';
//                        echo '<ul>';    
//                            echo '<li><a>submenu1</a></li>';
//                            echo '<li><a>submenu2</a></li>';
//                            echo '<li><a>submenu3</a></li>';
//                        echo '</ul>';
//                    echo '</li>';
//                echo '</ul>';
                
                /*opciones del usuario*/
                echo '<ul class="nav" style="float:right;">';
                    echo '<li class="nav2" style="width:110px;text-align:center;"> <a style="font-size:7pt;">'.strtoupper($this->login).' <img class="opcionesusuario" src="../images/usericon2.png"> </a>';
                        echo '<ul style="margin-left:-30px;">';    
                            echo '<li><a onclick="popup(\'cambiapas.php\')"><img style="width:12px;height:15px;margin-right:5px;" src="../images/keyicon2.png">Contraseña</a></li>';
                            echo '<li><form method="post" action="../config/logout.php" name="salir"><a onclick="logout();"><img style="width:12px;height:12px;" src="../images/onofficon.png"> Cerrar sesion</a></form></li>';
                        echo '</ul>';
                    echo '</li>';
                echo '</ul>';
            echo '</div>';
        echo '</div>';
        echo '</div>';
        //se cierra conexion a la base de datos
        $this->cierra_conexion("0");

    }

}

?>