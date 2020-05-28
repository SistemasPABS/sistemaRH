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
        echo '<link href="../../../../estilos/estilos.css" type="text/css" rel="stylesheet">';
        echo '<script type="text/javascript" src="../../../../librerias/jquery-1.10.2.min.js"></script>';
        echo '<script type="text/javascript" src="lanzadera.js"></script>';
    }
    
    public function formulario($op,$com) {
        if($op == 'editar'){
            $titulo='Edita Comision';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->consulta_com($com);
            if($this->consulta['co_activo'] == '1'){$checked='checked="yes"';}else{$checked='';}
            $selectdefault= $this->consulta['emp_id'];
            if($this->consulta['co_monto'] == 0){
                $v1='selected';//valor default para porcentaje
                $v3= $this->consulta['co_porcentaje'];
            }
            if($this->consulta['co_porcentaje'] == 0){
                $v2='selected';//valor default para porcentaje
                $v3= $this->consulta['co_monto'];
            }
        }else if($op == 'nuevo'){
            $titulo='Nueva Comision';
            $v1='';
            $v2='';
            $v3='';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $checked='checked="yes"';
            $selectdefault='';
        }
        
        echo '<head><title> '.$titulo.' </title></head>';
        echo '<form method="post" name="form_com" action="agregacom.php'.$operacion.'">';
                echo '<div class="row">';
                    echo '<input name="registro" id="registro" value="'.$com.'" hidden>';
                echo '</div>';
                echo '<div class="row">';
                    echo '<div class="col-8"><label>Nombre</label><br><input class="input0" type="text" name="nombre" onkeypress="return solo_letras_numeros(event);" id="nombre" value="'.$this->consulta['co_nombre'].'" placeholder="Nombre" required></div>';
                    echo '<div class="col-4"><br><label>Status</label><input type="checkbox" name="estatus" id="estatus" '.$checked.'></div>';
                echo '</div>';  
                echo '<div class="row">';
                    echo '<div class="col-4"><label>Tipo de Comision</label><br>';
                    echo '<select class="input0" name="tipo_com">
                            <option value="1000">Tipo de comision</option>
                            <option value="porcentaje" '.$v1.'>Porcentaje</option>
                            <option value="cantidad" '.$v2.'>Monto Fijo</option>
                           </select>';
                    echo '</div>';
                    echo '<div class="col-2"><label>Comision</label><br><input class="input0" type="text" name="comision" onkeypress="return solo_numeros(event);" id="comision" value='.$v3.'></div>';
                    echo '<div class="col-3"><label>Grupo</label><br>';
                        $this->selects_creator('select * from empresas order by emp_id','grupos','emp_id','emp_nombre','grupos','onChange= ""',$selectdefault);
                        echo $this->select;   
                    echo '</div>';
                      
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