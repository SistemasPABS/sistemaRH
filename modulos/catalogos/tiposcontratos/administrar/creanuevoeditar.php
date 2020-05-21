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
    
    public function formulario($op,$tipc) {
        if($op == 'editar'){
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->consulta_tipoc($tipc);
            $fvcp='onchange="valida_nueva_clave(this.value);"';
            $clave= $this->consulta['tipoc_cve'];
            $nombre= $this->consulta['tipoc_nombre'];
            $plantilla= $this->consulta['topoc_plantilla'];
            
        }else if($op == 'nuevo'){
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $fvcp='onblur="valida_nueva_clave(this.value);"';
            $clave='';
            $nombre='';
            $plantilla='';
        }
        
        echo '<form method="post" enctype="multipart/form-data" name="form_tipoc" action="agregatipoc.php'.$operacion.'">';
            echo '<div class="row">';
                echo '<div class="col-6"';
                   echo '<h1>Datos personales</h1>';
                echo '</div>';
            echo '</div>';
            echo '<div class="row">';
                echo '<input name="registro" id="registro" value="'.$tipc.'" hidden>';
                echo '<div class="col-2"><label>Clave</label><br><input class="input0" type="text" name="clave" onkeypress="return solo_letras_numeros(event);" '.$fvcp.' id="clave" value="'.$clave.'" placeholder="Clave" required></div>';
                echo '<div class="col-8"><label>Nombre</label><input class="input0" type="text" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="'.$nombre.'" placeholder="Nombre"></div>';
                echo '<div class="col-2"><label>Plantilla</label><br><input type="file" name="plantilla"></div>';
            echo '</div>';

            echo '<div class="division"></div>';
            echo '<div class="row-centrado">';
                echo '<button type="button" onclick="valida_campos(\''.$op.'\');" class="btnA" > Guardar </button>';   
                echo '<button type="button" onclick="self.close();" class="btnA" style="margin-left:10px;"> Cancelar </button>';
            echo '</div>';
        echo '</form>';
    }
  }
?>