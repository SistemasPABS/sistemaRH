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
    
      public function formulario($op,$rzn) {
        if($op == 'editar'){
            $titulo='Edita razon Social';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->consulta_razon($rzn);
            $nombre= $this->consulta['raz_nombre'];
            $repre= $this->consulta['raz_legal'];
            $dir= $this->consulta['raz_direccion'];
        }else if($op == 'nuevo'){
            $titulo='Nueva Razon Social';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $nombre='';
            $repre= '';
            $dir= '';
        }
        
        echo '<head><title> '.$titulo.' </title></head>';
        echo '<form method="post" name="form_razones" action="agregarazon.php'.$operacion.'">';
            echo '<div class="row">';
                echo '<input name="registro" id="registro" value="'.$rzn.'" hidden>';
                echo '<div class="col-6"><label>Razon Social</label><br><input class="input0" type="text" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="'.$nombre.'" placeholder="Nombre" required></div>';
                echo '<div class="col-6"><label>Representante Legal</label><input class="input0" type="text" name="representante" onkeypress="return solo_letras(event);" id="representante" value="'.$repre.'"></div>';
                echo '<div class="col-12"><br><label>Direccion</label><input class="input0" type="text" name="direccion" onkeypress="return solo_letras_numeros(event);" id="direccion" value="'.$dir.'"></div>';
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