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
        echo '<script type="text/javascript" src="lanzaderasal.js"></script>';
    }
    
    public function formulario($op,$sal) {
        
        
        if($op == 'editar'){
            $titulo='Edita Salario';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->consulta_sal($sal);
            if($this->consulta['sal_activo'] == '1'){$checked='checked="yes"';}else{$checked='';}
            if($this->consulta['sal_tipo'] == 'sem'){$v1='selected';}
            if($this->consulta['sal_tipo'] == 'qui'){$v2='selected';}
            if($this->consulta['sal_tipo'] == 'men'){$v3='selected';}
            $saltipodefault= $this->consulta['sal_tipo_id'];
            $selectdefault= $this->consulta['plaza_id'];
            $this->selects_creator('select * from sucursales order by suc_id','sucursales','suc_id','suc_nombre','sucursales','onChange= ""',$this->consulta['suc_id']);
            $selectedit=$this->select; 
            
        
        }else if($op == 'nuevo'){
            $titulo='Nuevo Salario';
            $v1='';
            $v2='';
            $v3='';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $checked='checked="yes"';
            $selectedit='<select class="input0" name="sucursales" value="0">
                            <option value="1000">Seleccione una plaza</option>
                           </select>';
        }
        
        echo '<head><title> '.$titulo.' </title></head>';
        echo '<form method="post" name="form_sal" action="agregasal.php'.$operacion.'">';
                echo '<div class="row">';
                    echo '<div class="col-2"<h1>Salarios</h1></div>';
                    echo '<input name="registro" id="registro" value="'.$sal.'" hidden>';
                    echo '<div class="col-4"><label>Status</label><input type="checkbox" name="estatus" id="estatus" '.$checked.'></div>';

                echo '</div>';
                echo '<div class="row">';
                    echo '<div class="col-3"><label>Nombre      </label><br><input class="input0" type="text" name="nombre" onkeypress="return solo_letras(event);" id="nombre" value="'.$this->consulta['sal_nombre'].'"      required></div>';
                    echo '<div class="col-3"><label>Descripcion </label><br><input class="input0" type="text" name="desc"  onkeypress="return solo_letras_numeros(event);" id="desc"   value="'.$this->consulta['sal_descripcion'].'" required></div>';
                    echo '<div class="col-3"><label>Monto       </label><br><input class="input0" type="text" name="monto" onkeypress="return solo_numeros(event);" id="monto" value='.$this->consulta['sal_monto'].'></div>';
                echo '</div>';

                echo '</div>';  
                echo '<div class="row">';
                    echo '<div class="col-3"><label>Tipo Salario</label><br>';
                        $this->selects_creator('select * from tipos_salarios order by sal_tipo_id','tipo_sal','sal_tipo_id','sal_tipo_nombre','tipo salario','onChange= ""',$saltipodefault);
                        echo $this->select; 
                    echo '</div>';
                    echo '<div class="col-3"><label>Plaza</label><br>';
                        $this->selects_creator('select * from plazas order by plaza_id','plazas','plaza_id','plaza_nombre','plazas','onChange= "ver_sucursales();"',$selectdefault);
                        echo $this->select;   
                    echo '</div>';
                    echo '<div class="col-3"><label> Sucursal </label><br>';
                    echo '<div id="cont_se">';
                        echo $selectedit;
                    echo '</div>';  
                    echo '</div>';
                echo '</di>';   
                    
                echo '<div class="division"></div>';
                echo '<div class="row-centrado">';
                    echo '<button type="button" onclick="valida_campos(\''.$op.'\');" class="btnA" > Guardar </button>';   
                    echo '<button type="button" onclick="self.close();"               class="btnA" style="margin-left:10px;"> Cancelar </button>';
                echo '</div>';
        echo '</form>';
    }
}
?>