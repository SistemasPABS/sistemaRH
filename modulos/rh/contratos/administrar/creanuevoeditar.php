<?php
include ('../../../../config/conectasql.php');

class creanuevoeditar extends conectasql{
    protected  $usid;
    protected $estid;
    
    
    
    public function _construct($usid, $estid) {
        $this->usid = $usid;
        $this->estid = $estid;
    }
    
    public function librerias() {
        echo '<link href="../../../../estilos/personasStyles.css" type="text/css" rel="stylesheet">';
        echo '<script type="text/javascript" src="../../../../librerias/jquery-1.10.2.min.js"></script>';
        echo '<script type="text/javascript" src="lanzadera.js"></script>';
    }
    
    public function formulario($op,$psto) {
        
        if($op == 'editar'){
            
            
        }else if($op == 'nuevo'){
           
        }
        
        echo '<form method="post" id="form_puesto" name="form_puesto" action="agregapuesto.php'.$operacion.'">';
            echo '<div class="row">';
                echo '<div class="col-8"';
                    echo '<label>Nombre</label><input class="input0" name="nombre" placeholder="Nombre">';
                echo '</div>';
                echo '<div class="col-8"';
                    echo '<div class="col-12"><label>Nombre</label><input class="input0" name="nombre" placeholder="Nombre"></div>';
                echo '</div>';
                echo '<div class="row">';
                    echo '<div class="col-4"><label>RFC</label><input class="input0" name="rfc" readonly></div>';
                    echo '<div class="col-4"><label>CURP</label><input class="input0" name="curp" readonly></div>';
                    echo '<div class="col-4"><label>NSS</label><input class="input0" name="nss" readonly></div>';
                echo '<div>';
                
                echo '<div class="row">';
                    echo '<div class="col-4"><label>RFC</label><input class="input0" name="rfc" readonly></div>';
                    echo '<div class="col-4"><label>CURP</label><input class="input0" name="curp" readonly></div>';
                    echo '<div class="col-4"><label>NSS</label><input class="input0" name="nss" readonly></div>';
                echo '<div>';
                
                echo '<div class="row">';
                    echo '<div class="col-3"><label>Genero</label><input class="input0" name="genero" readonly></div>';
                    echo '<div class="col-3"><label>Nacionalidad</label><input class="input0" name="nacionalidad" readonly></div>';
                    echo '<div class="col-6"><label>Direccion</label><input class="input0" name="direccion" placeholder="Direccion" readonly>';
                echo '<div>';
                
            echo '</div>';
            echo '<div class="division"></div>';
            echo '<div class="row-centrado">';
                echo '<button type="button" onclick="valida_campos(\''.$op.'\');" class="btnA" > Guardar </button>';   
                echo '<button type="button" onclick="self.close();"               class="btnA" style="margin-left:10px;"> Cancelar </button>';
            echo '</div>';
        echo '</form>';
    }
}
?>