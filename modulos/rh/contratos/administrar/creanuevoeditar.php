<?php
include ('../../../../config/conectasql.php');

class creanuevoeditar extends conectasql{
    protected  $usid;
    protected $estid;
    
    public function _construct($usid, $estid) {
        //Recinbe el id de secion del usuario y el id de la estructura del menu
        $this->usid = $usid;
        $this->estid = $estid;
    }
    
    public function librerias() {
        echo '<link href="../../../../estilos/personasStyles.css" type="text/css" rel="stylesheet">';
        echo '<link href="../../../../librerias/jquery-ui.css" type="text/css" rel="stylesheet">';
        echo '<script type="text/javascript" src="../../../../librerias/jquery-1.10.2.min.js"></script>';
        //Libreria para funcion autocomplete de los input
        echo '<script type="text/javascript" src="../../../../librerias/jquery-ui.js"></script>';
        echo '<script type="text/javascript" src="lanzadera.js"></script>';       
    }

    public function formulario($op,$cto) {
        
        if($op == 'editar'){
            //Codifica el tipo de operacion Nuevo o Editar
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;   
            $this->consulta_cto($cto);//Asigna a la variable consulta la informacion a editar de vw_contratos
            $jefe= $this->consulta['con_jefe_inmediato'];
            $persona_id=$this->consulta['persona_id'];
            $persona_nom=$this->consulta['nombrecompleto'];
            $persona_gen=$this->consulta['persona_genero'];
            $persona_rfc=$this->consulta['persona_rfc'];
            $persona_curp=$this->consulta['persona_curp'];
            $persona_nss=$this->consulta['persona_nss']; 
            $persona_nac=$this->consulta['nacionalidad_nombre'];
            $persona_dir=$this->consulta['persona_dom'];
            $contrato_id=$this->consulta['tipoc_id'];
            $Contrato_nom=$this->consulta['tipoc_nombre'];
            $puesto_id=$this->consulta['puesto_id'];
            $puesto_nom=$this->consulta['puesto_nombre'];
            $razon_id=$this->consulta['raz_id'];
            $razon_nom=$this->consulta['raz_nombre'];
            $plaza_nom=$this->consulta['plaza_nombre'];
            $suc_nom= $this->consulta['suc_nombre'];
            $sal_id=$this->consulta['sal_id'];
            $sal_monto=$this->consulta['sal_monto_con'];
            $sal_pago=$this->consulta['sal_tipo'];
            $con_horario=$this->consulta['con_horario'];
            $con_prueba=$this->consulta['con_periodo'];
            $con_ini=$this->consulta['con_fecha_inicio'];
            $con_fin=$this->consulta['con_fecha_fin'];
            $con_aimss=$this->consulta['con_alta_imss'];
            $con_bimss=$this->consulta['con_baja_imss'];
            $con_sdi= $this->consulta['con_sdi'];
            //convierte el valor entero en on u off del checkbox
            if($this->consulta['con_adic'] == '1'){$checkedadic='checked="yes"';}else{$checkedadic='';}
            if($this->consulta['con_firmado'] == '1'){$checkconfir='checked="yes"';}else{$checkconfir='';}
            if($this->consulta['con_status'] == '1'){$checkedstatus='checked="yes"';}else{$checkedstatus='';}
            $ffin='';
            
            $sqljf="select * from vw_contratos where persona_id=$jefe";
            $resultjf= pg_query($this->conexion,$sqljf) or die('Eror :'. pg_last_error());
            $rowjf= pg_fetch_array($resultjf);
            $plazajf=$rowjf['plaza_id'];
            $sucjf=$rowjf['suc_id'];
            
            $this->selects_creator('select * from sucursales where plaza_id='.$plazajf.' order by suc_id', 'sucursales', 'suc_id', 'suc_nombre', 'sucursales', 'onChange="ver_jefes();"',$sucjf);
            $selectsuc2=$this->select;
            
            $this->selects_creator('select * from vw_contratos where suc_id='.$sucjf.' order by nombrecompleto', 'jefes', 'persona_id', 'nombrecompleto', 'jefes', 'onChange=""', $jefe);
            $selectjefe= $this->select;

        }else if($op == 'nuevo'){
            //inicializa variables para evitar alertas de errores
            $selectsuc2='<select class="input0" name="suc" value="0">
                            <option value="1000">--- Seleccione una plaza --- </option>
                           </select>';
            $selectjefe='<select class="input0" name="jefes" value="0">
                            <option value="1000"> --- Jefe inmediato --- </option>
                           </select>';
            $selectdefault='';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $cto='';
            $persona_id='';
            $persona_nom='';
            $persona_gen='';
            $persona_rfc='';
            $persona_curp='';
            $persona_nss=''; 
            $persona_nac='';
            $persona_dir='';
            $contrato_id='';
            $Contrato_nom='';
            $puesto_id='';
            $puesto_nom='';
            $razon_id='';
            $razon_nom='';
            $plaza_nom='';
            $suc_nom='';
            $sal_id='';
            $sal_monto='';
            $sal_pago='';
            $con_horario='';
            $con_prueba='';
            $con_ini='';
            $con_fin='';
            $con_aimss='';
            $con_bimss='';
            $con_sdi='';
            $checkedadic='';
            $checkconfir='';
            $checkedstatus='';
            $ffin='hidden';

        }

        echo '<form method="post" id="form_contrato" name="form_contrato" action="agregacontrato.php'.$operacion.'">';
            echo '<div class="row">';
                echo '<div class="col-8"';
                    echo '<h4>Datos de la Persona</h4>';
                    echo '<input name="registro" value="'.$cto.'" hidden>';
                echo '</div>';
            echo '</div>';
            echo '<div class="division"></div>';
            echo '<div class="row">';
                echo '<input id="id_persona" name="id_persona" value="'.$persona_id.'" hidden>';
                echo '<div class="col-8"><label>Nombre</label><input class="input0" name="nombre" id="nombre" value="'.$persona_nom.'" placeholder="Nombre" onblur="valida_persona(\'pipol\');"></div>';
                echo '<div class="col-4"><label>Genero</label><input class="input0" name="genero" id="genero"   value="'.$persona_gen.'"placeholder="Genero" readonly></div>';
            echo '</div>';
            echo '<div class="row">';
                echo '<div class="col-3"><label>RFC</label><input class="input0" name="rfc" id="rfc"  value="'.$persona_rfc.'"placeholder="RFC" readonly></div>';
                echo '<div class="col-3"><label>CURP</label><input class="input0" name="curp" id="curp"  value="'.$persona_curp.'"placeholder="CURP" readonly></div>';
                echo '<div class="col-3"><label>NSS</label><input class="input0" name="nss" id="nss"  value="'.$persona_nss.'"placeholder="NSS" readonly></div>';
                echo '<div class="col-3"><label>Nacionalidad</label><input class="input0" name="nac" id="nac"  value="'.$persona_nac.'"placeholder="Nacionalidad" readonly></div>';
            echo '<div>';    
            echo '<div class="row">';
                echo '<div class="col-12"><label>Dirección</label><input class="input0" name="direccion" id="direccion"  value="'.$persona_dir.'"placeholder="Direccion" readonly></div>';
            echo '<div>';
            echo '<div class="row">';
                echo '<div class="col-8"';
                    echo '<br><h4>Datos del contrato</h4>';
                echo '</div>';
            echo '</div>';
            echo '<div class="division"></div>';
            echo '<div class="row">';
                echo '<input type="text" name="id_contrato" id="id_contrato"  value="'.$contrato_id.'"hidden>';
                echo '<div class="col-3"><label>Tipo de Contrato</label><br><input class="input0" name="contrato" id="contrato"  value="'.$Contrato_nom.'"placeholder="Tipo de contrato" onblur="valida_persona(\'tcon\');"></div>';
                echo '<input type="text" name="id_puesto" id="id_puesto"  value="'.$puesto_id.'"hidden>';
                echo '<div class="col-3"><label>Puesto</label><br><input class="input0" name="puesto" id="puesto"  value="'.$puesto_nom.'"placeholder="Puesto" onblur="valida_persona(\'pst\');"></div>';
                echo '<input type="text" name="id_razon" id="id_razon"  value="'.$razon_id.'"hidden>';
                echo '<div class="col-3"><label>Razon Social</label><br><input class="input0" name="razon" id="razon" value="'.$razon_nom.'" onblur="valida_persona(\'rzn\');"></div>';
                echo '<div class="col-3"><label>Plaza</label><br><input class="input0" name="plaza" id="plaza" value="'.$plaza_nom.'" placeholder="Plaza" readonly></div>';
                
            echo '<div>';
            echo '<div class="row">';
                //echo '<input type="text" name="id_salario" id="id_salario" value="'.$sal_id.'" hidden>';
                echo '<div class="col-3"><label>Area</label><br><input class="input0" name="suc" id="suc" value="'.$suc_nom.'"placeholder="Area" readonly></div>';
                echo '<div class="col-3"><label>Salario</label><br><input class="input0" name="salario" id="salario" value="'.$sal_monto.'" placeholder="$ $ $" onblur="valida_salario();" onkeypress="return solo_numeros(event);"></div>';
                echo '<div class="col-3"><label>SDI</label><br><input class="input0" name="sdi" id="sdi" value="'.$sal_monto.'" placeholder="" onblur="" onkeypress="return solo_numeros(event);"></div>';
                echo '<div class="col-3"><label>Horario</label><br><input class="input0" name="horario" value="'.$con_horario.'"></div>';
                echo '<div class="col-3"><label>Periodo de Prueba</label><input class="input0" name="prueba"  value="'.$con_prueba.'" placeholder="en días"></div>';
                $this->selects_creator('select * from plazas order by plaza_id','plazas','plaza_id','plaza_nombre','plazas','onChange= "ver_sucursales();"',$plazajf);
                echo '<div class="col-3"><label>Plaza jefe inmediato</label> '.$this->select.' </div>';
                echo '<div class="col-3"><label>Sucursal jefe inmediato</label><div id="cont_se">'.$selectsuc2.'</div></div>';
                echo '<div class="col-3"><label>Jefe inmediato</label><div id="cont_jf">'.$selectjefe.'</div></div>';
                echo '<div class="col-3"><label></label></div>';
                echo '<div class="col-3"><label>Alta IMSS</label><input class="inputdate" type="date" name="aimss"  value="'.$con_aimss.'"></div>';
                echo '<div class="col-3"><label>Baja IMSS</label><input class="inputdate" type="date" name="bimss"  value="'.$con_bimss.'"></div>';
                echo '<div class="col-3"><br><label >Contrato firmado</label><input type="checkbox" name="cfir" id="cfir" '.$checkconfir.'></div>';
            echo '<div>';
            echo '<div class="row">';
                echo '<div class="col-3"><label>Fecha inicio</label><input class="inputdate" type="date" name="fecha_ini" value="'.$con_ini.'"></div>';
                echo '<div class="col-3"><label '.$ffin.'>Fecha Fin</label><input class="inputdate" type="date" name="fecha_fin" value="'.$con_fin.'" '.$ffin.'></div>';
                echo '<div class="col-3"><br><label>Estatus</label><input type="checkbox" name="status" id="status" '.$checkedstatus.'></div>';
                echo '<div class="col-3"><br><label>Adicionales</label><input type="checkbox" name="adic" id="adic" '.$checkedadic.'></div>';
            echo '<div>';                
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