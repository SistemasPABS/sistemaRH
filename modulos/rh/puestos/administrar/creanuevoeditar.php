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
    
    public function formulario($op,$psto) {
        
        if($op == 'editar'){
            $titulo='Edita Puesto';
            $fvcp='onblur="valida_nueva_clave(this.value);"';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->consulta_puesto($psto);
            if(!empty($this->consulta['puesto_cve'])){
                $clve=$this->consulta['puesto_cve'];
            }
            if(!empty($this->consulta['puesto_nombre'])){
                $nom=$this->consulta['puesto_nombre'];
            }
            $selectdefault= $this->consulta['plaza_id'];
            $grupodefault= $this->consulta['emp_id'];
            $sucidcom= $this->consulta['suc_id'];
            $this->selects_creator('select * from sucursales order by suc_id','sucursales','suc_id','suc_nombre','sucursales','onChange= ""',$this->consulta['suc_id']);
            $selectsuc=$this->select;
            $this->selects_creator('select * from salarios order by sal_id','salarios','sal_id','sal_nombre','salarios','onChange= ""',$this->consulta['sal_id']);
            $selectsal=$this->select; 
            $this->selects_creator('select * from puestos order by puesto_id','jefes','puesto_id','puesto_nombre','jefes','onChange= ""',$this->consulta['puesto_id']);
            $selectjefe=$this->select;
            $this->select_multiple('select * from vw_comisiones where suc_id='.$sucidcom.' order by co_id', 'comisiones', 'co_id', 'co_nombre', 'comisiones', 'onChange=""','');
            $comisiones_selectA=$this->select;
            if(!empty($this->consulta['puesto_descripcion'])){
                $descrip= $this->consulta['puesto_descripcion'];
            }           
            $selectsuc2='<select class="input0" name="estados" value="0">
                           <option value="1000">Seleccione una plaza</option>
                          </select>';
            $this->consulta_com_puesto($this->consulta['puesto_id']);
            
        }else if($op == 'nuevo'){
            $titulo='Nuevo Puesto';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $fvcp='onblur="valida_nueva_clave(this.value);"';
            $clve='';
            $nom='';
            $descrip='';
            $selectdefault='';
            $grupodefault='';
            $desc='';
            $selectsuc='<select class="input0" name="estados" value="0">
                            <option value="1000">Seleccione una plaza</option>
                           </select>';
            $selectsuc2='<select class="input0" name="estados" value="0">
                            <option value="1000">Seleccione una plaza</option>
                           </select>';
            $selectsal='<select class="input0" name="salarios" value="0">
                            <option value="1000">Seleccione un salario</option>
                           </select>';
            $selectjefe='<select class="input0" name="jefes" value="0">
                            <option value="1000">Jefe inmediato</option>
                           </select>';
            $comisiones_selectA='<select class="input0" name="comisionesA"  id="="comisionesA" value="0" size="5" multiple>
                            <option value="1000">Seleccione una sucursal</option>
                           </select>';
            $comisiones_selectB='<select class="input0" name="comisionesA" value="0" size="5" multiple>
                            <option value="1000">Seleccione una sucursal</option>
                           </select>';
        }
        
        echo '<head><title> '.$titulo.' </title></head>';
        echo '<form method="post" id="form_puesto" name="form_puesto" action="agregapuesto.php'.$operacion.'">';
            echo '<div class="row">';
                echo '<input name="registro" id="registro" value="'.$psto.'" hidden>';
            echo '</div>';
            echo '<div class="row">';
                echo '<div class="col-3"><label>Clave</label><br><input class="input0" name="clave" onkeypress="return solo_letras_numeros(event);" id="clave" placeholder="Clave" value="'.$clve.'"'.$fvcp.'></div>';
                echo '<div class="col-3"><label>Nombre</label><br><input class="input0" name="nombre" onkeypress="return solo_letras(event);"  id="nombre" placeholder="Nombre" value="'.$nom.'"></div>';
                echo '<div class="col-3"><label>Grupo</label><br>';
                    $this->selects_creator('select * from empresas', 'grupo', 'emp_id', 'emp_nombre', 'grupo', 'onChange=""', $grupodefault);
                    echo $this->select;
                echo '</div>';
            echo '</div>';

            echo '<div class="row">';
                echo '<div class="col-3">';
                    echo '<label>Puesto</label><br>';
                    echo '<label>Plaza</label><br>';
                        $this->selects_creator('select * from plazas order by plaza_id','plazas','plaza_id','plaza_nombre','plazas','onChange= "ver_sucursales();"',$selectdefault);
                        echo $this->select; 
                        echo '<br>';
                    echo '<label>Sucursales</label><br>';
                    echo '<div id="cont_se">';
                        echo $selectsuc;
                    echo '</div>';
                    echo '<label>Salarios</label><br>';
                    echo '<div id="cont_sl">';
                        echo $selectsal;
                    echo '</div>';
                echo '</div>';
                
                echo '<div class="col-3">';
                    echo '<label>Jefe inmediato</label><br>';
                    echo '<label>Plaza</label><br>';
                        $this->selects_creator('select * from plazas order by plaza_id','plazas2','plaza_id','plaza_nombre','plazas','onChange= "ver_sucursales2();"',$selectdefault);
                        echo $this->select; 
                        echo '<br>';
                    echo '<label>Sucursales</label><br>';
                    echo '<div id="cont_se2">';
                        echo $selectsuc2;
                    echo '</div>';
                    echo '<label>Jefe inmediato</label><br>';
                    echo '<div id="cont_jf">';
                        echo $selectjefe;
                    echo '</div>';
                echo '</div>';
                
                echo '<div class="col-6"><label>Descripción</label><br>';
                    echo '<textarea class="input0"  style="height:113px;" name="descripcion" onkeypress="return solo_letras_numeros(event);" id="descripcion" rows="12" cols="56" style="margin-left:5px;" maxlength="200">'.$descrip.'</textarea>';
                echo '</div>';  

            echo '</div>';  
            echo '<div class="division"></div>';
            echo '<div class="row">';
           
                echo '<div class="col-6">';
                    echo '<h5> Comisiones disponibles en la sucursal seleccionada </h5>';
                echo '</div>';
                echo '<div class="col-6">';
                    echo '<h5 style="margin-left:10px;">Comisiones asignadas</h5>';
                echo '</div>';
                echo '<div class="col-5">';
                    echo '<div id="cont_coms">'.$comisiones_selectA.'</div>';
                echo '</div>';
                echo '<div class="col-2" style="margin-top:10px;">';
                    echo '<a class="btnadd" onclick="myFunction();"> Agregar ></a>';
                echo '</div>';
                echo '<div class="col-5">';
                    echo '<ul id="myList">';
                        //echo '<li><input type="text" value="" name="com[]" hidden> bla bla bla <input type="button" onclick="eliminar(this)" value="eliminar"></li>';
                        echo $this->html;
                    echo '</ul>';
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