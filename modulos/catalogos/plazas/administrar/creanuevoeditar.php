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
    
    public function formulario($op,$plz) {
        if($op == 'editar'){
            $titulo='Edita Plaza';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->consulta_plaza($plz);
            if($this->plazas['plaza_activo'] == '1'){$checked='checked="yes"';}else{$checked='';}
        }else if($op == 'nuevo'){
            $titulo='Nueva Plaza';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $checked='checked="yes"';
        }
        
        echo '<head><title> '.$titulo.' </title></head>';
        echo '<form method="post" name="form_plazas" action="agregaplaza.php'.$operacion.'">';
                echo '<div class="row">';
                    echo '<div class="col-4"><label>Nombre</label><br><input class="input0" type="text" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="'.$this->plazas['plaza_nombre'].'" placeholder="Nombre" required><input name="registro" id="registro" value="'.$plz.'" hidden></div>';
                    echo '<div class="col-4"><br><label>Status</label><input type="checkbox" name="estatus" id="estatus" '.$checked.'></div>';
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