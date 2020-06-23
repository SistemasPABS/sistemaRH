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
            $titulo='Edita Tipo contrato';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->consulta_tipoc($tipc);
            $fvcp='onchange="valida_nueva_clave(this.value);"';
            $clave= $this->consulta['tipoc_cve'];
            $nombre= $this->consulta['tipoc_nombre'];
            $plantilla= $this->consulta['tipoc_plantilla'];
            
        }else if($op == 'nuevo'){
            $titulo='Nuevo Tipo Contrato';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $fvcp='onblur="valida_nueva_clave(this.value);"';
            $clave='';
            $nombre='';
        }
        echo '<head><title> '.$titulo.' </title></head>';
        echo '<form method="post" enctype="multipart/form-data" name="form_tipoc" action="agregatipoc.php'.$operacion.'">';
            echo '<div class="row">';
                echo '<input name="registro" id="registro" value="'.$tipc.'" hidden>';
                echo '<div class="col-2"><label>Clave</label><br><input class="input0" type="text" name="clave" onkeypress="return solo_letras_numeros(event);" '.$fvcp.' id="clave" value="'.$clave.'" placeholder="Clave" required></div>';
                echo '<div class="col-4"><label>Nombre</label><input class="input0" type="text" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="'.$nombre.'" placeholder="Nombre"></div>';
                echo '<div class="col-2"><label>Plantilla</label><br><input type="file" name="plantilla"></div>';
            echo '</div>';

            echo '<div class="division"></div>';
            echo '<div class="row-centrado">';
                echo '<button type="button" id="forward" onclick="valida_campos(\''.$op.'\');" class="btnA" > Guardar </button>';   
                echo '<button type="button" id="cancel"  onclick="self.close();" class="btnA" style="margin-left:10px;"> Cancelar </button>';
            echo '</div>';
        echo '</form>';
    }
  }
?>