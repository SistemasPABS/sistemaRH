
<?php
include ('../../../../config/conectasql.php');

class creanuevo_editar extends conectasql{
    protected $usid;
    protected $estid;


    public function __construct($usid, $estid) {
        $this->usid = $usid;
        $this->estid = $estid;
    }
    public function librerias() {
        echo '<link href="../../../../estilos/personasStyles.css" type="text/css" rel="stylesheet">';
        echo '<script type="text/javascript" src="../../../../librerias/jquery-1.10.2.min.js"></script>';
        echo '<script type="text/javascript" src="lanzadera_ne.js"></script>';
    }
    
    public function formulario($op,$prs) {
        if($op=='editar'){
            $titulo='Edita Persona';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $fvcp='onchange="valida_nueva_clave(this.value);"';
            $this->consulta_persona($prs);
            if($this->generales['persona_status'] == '1'){$checked='checked="yes"';}else{$checked='';}
            $vg1='1000';
            if($vg1 == $this->generales['persona_genero']){$vgd1='selected';}else{$vgd1='';}
            $vg2='femenino';
            if($vg2 == $this->generales['persona_genero']){$vgd2='selected';}else{$vgd2='';}
            $vg3='masculino';
            if($vg3 == $this->generales['persona_genero']){$vgd3='selected';}else{$vgd3='';}
            $nacdefault= $this->generales['nacionalidad_id'];
            $paisdefault= $this->generales['pais_id'];
            $this->selects_creator('select * from estados order by est_id','estados','est_id','est_nombre','estados','onChange= "ver_municipios();"',$this->generales['est_id']);
            $selectestado=$this->select; 
            $this->selects_creator('select * from municipios order by mcp_id','municipios','mcp_id','mcp_nombre','municipios','onChange=""',$this->generales['mcp_id']);
            $selectmcp=$this->select;
            $bancodefault= $this->bancarios['banco_id'];
            if($this->documentos['doc_ine'] == '1'){$checkedine='checked="yes"';}else{$checkedine='';}
            if($this->documentos['doc_acta_nac'] == '1'){$checkedacta='checked="yes"';}else{$checkedacta='';}
            if($this->documentos['doc_comprobante'] == '1'){$checkedcomp='checked="yes"';}else{$checkedcomp='';}
            if($this->documentos['doc_estudio'] == '1'){$checkedcertificado='checked="yes"';}else{$checkedcertificado='';}
            if($this->documentos['doc_curp'] == '1'){$checkedcurp='checked="yes"';}else{$checkedcurp='';}
            if($this->documentos['doc_rfc'] == '1'){$checkedrfc='checked="yes"';}else{$checkedrfc='';}
            if($this->documentos['doc_nss'] == '1'){$checkednss='checked="yes"';}else{$checkednss='';}
            if($this->documentos['doc_lic_manejo'] == '1'){$checkedlicencia='checked="yes"';}else{$checkedlicencia='';}
            if($this->documentos['doc_recomendacion'] == '1'){$checkedrecomendacion='checked="yes"';}else{$checkedrecomendacion='';}
            if($this->documentos['doc_policia'] == '1'){$checkedantecedentes='checked="yes"';}else{$checkedantecedentes='';}
            if($this->documentos['doc_fonacot'] == '1'){$checkedfonacot='checked="yes"';}else{$checkedfonacot='';}
            if($this->documentos['doc_infonavit'] == '1'){$checkedinfonavit='checked="yes"';}else{$checkedinfonavit='';}
        }else if($op == 'nuevo'){
            $titulo='Nueva Persona';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $checked='checked="yes"';
            $fvcp='onblur="valida_nueva_clave(this.value);"';
            $paisdefault='1000';
            $selectestado='<select class="input0" name="estados" value="0">
                            <option value="1000">Seleccione un pais</option>
                           </select>';
            $selectmcp='<select class="input0" ame="municipios" value="0">
                            <option value="1000">Seleccione un estado</option>
                        </select>';
            $bancodefault='';
            $checkedine='';
            $checkedacta='';
            $checkedcomp='';
            $checkedcertificado='';
            $checkedcurp='';
            $checkedrfc='';
            $checkednss='';
            $checkedlicencia='';
            $checkedrecomendacion='';
            $checkedantecedents='';
            $checkedfonacot='';
            $checkedinfonavit='';
        }
        
        echo '<head><title> '.$titulo.' </title></head>';
        echo '<form method="post" name="form_personas" action="agrega_persona.php'.$operacion.'">';
            echo '<div class="row">';
                echo '<div class="col-6"';
                    echo '<h2>Datos personales</h2>';
                echo '</div>';
                echo '<div class="col-6"';
                    echo '<label>Activo:</label><input type="checkbox" id="status" name="status" '.$checked.'>';
                echo '</div>';
            echo '</div>';
            
            echo '<div class="row">';
                echo '<div class="col-1"><label>Clave</label><br><input onkeypress="return caracteres_esp(event)" class="input0" type="text" id="clave" name="clave" placeholder="Clave" value="'.$this->generales['persona_cve'].'" '.$fvcp.' required ><input name="registro" id="registro" value="'.$prs.'" hidden></div> ';
                echo '<div class="col-3"><label>Nombre (s)</label><br><input  onkeypress="return solo_letras(event)" class="input0" type="text"  pattern="[A-Za-z]" name="nombre" value="'.$this->generales['persona_nombre'].'" placeholder="Nombre" required></div>';
                echo '<div class="col-4"><label>Apellido P</label><br><input onkeypress="return solo_letras(event)" class="input0" type="text" name="paterno" value="'.$this->generales['persona_paterno'].'" placeholder="Apellido Paterno" required></div>';
                echo '<div class="col-4"><label>Materno</label><br><input onkeypress="return solo_letras(event)" class="input0" type="text" name="materno" value="'.$this->generales['persona_materno'].'" placeholder="Apellido Materno" required></div>';
            echo '</div>';
            echo '<div class="row">';
                echo ' <div class="col-3"><label>RFC</label><br><input class="input0" type="text" name="rfc" onkeypress="return solo_letras_numeros(event)" onKeyUp="this.value=this.value.toUpperCase();" value="'.$this->generales['persona_rfc'].'" placeholder="RFC"></div>';
                echo ' <div class="col-3"><label>NSS</label><br><input class="input0" type="text" name="nss" onkeypress="return solo_numeros(event);" value="'.$this->generales['persona_nss'].'" placeholder="NSS" required></div>';
                echo ' <div class="col-3"><label>CURP</label><br><input class="input0" type="text" name="curp" onkeypress="return solo_letras_numeros(event);" onKeyUp="this.value=this.value.toUpperCase();"  value="'.$this->generales['persona_curp'].'" placeholder="CURP" required></div>';
                echo ' <div class="col-3"><label>Genero</label><br>'
                        . '<select class="input0" name="genero" id="genero">'
                            . '<option value="1000" '.$vgd1.'>Selecciona genero</option>'
                            . '<option value="femenino" '.$vgd2.'>Femenino</option>'
                            . '<option value="masculino" '.$vgd3.'>Masculino</option>'
                        . '</select></div>';
            echo '</div>'; 
            
            echo '<div class="row">';
                echo ' <div class="col-5"><label>Calle</label><br><input class="input0" type="text" name="calle" onkeypress="return solo_letras_numeros(event);" value="'.$this->generales['persona_calle'].'" placeholder="Calle"></div>';
                echo ' <div class="col-2"><label>numero</label><br><input class="input0" type="text"  name="numero" onkeypress="return solo_numeros(event)" value="'.$this->generales['persona_calle_numero'].'" placeholder="Numero" required></div>';
                echo ' <div class="col-3"><label>Colonia</label><br><input class="input0" type="text" name="colonia" onkeypress="return solo_letras_numeros(event);" value="'.$this->generales['persona_colonia'].'" placeholder="Colonia" required></div>';
                echo ' <div class="col-2"><label>CP</label><br><input class="input0" type="text" name="cp" onkeypress="return solo_numeros(event);" value="'.$this->generales['persona_cp'].'" placeholder="CP" required></div>';
            echo '</div>';   
            echo '<div class="row">';
                echo ' <div class="col-4"><label>Tel Fijo</label><br><input class="input0" type="text" maxlength="10" name="telefono" onkeypress="return solo_numeros(event);" value="'.$this->generales['persona_tel_fijo'].'" placeholder="Telefono Fijo" required></div>';
                echo ' <div class="col-4"><label>Telefono</label><br><input class="input0" type="text" maxlength="10" name="celular" onkeypress="return solo_numeros(event);" value="'.$this->generales['persona_tel_movil'].'" placeholder="Celular" required></div>';
                echo ' <div class="col-4"><label>Correo electronico</label><br><input class="input0" type="email" name="correo" value="'.$this->generales['persona_correo'].'" placeholder="Correo electronico"></div>';
            
            echo '</div>';
            echo '<div class="row">';
                echo ' <div class="col-2"><label>Fec.Nacimineto</label><br><input class="inputdate" type="date" name="fecha_nac" onkeypress="solo_letras" value="'.$this->generales['persona_fecnac'].'"></div>';
                echo ' <div class="col-3"><label>Edo. Civil</label><br><input class="input0" type="text" name="civil" onkeypress="solo_numeros" value="'.$this->generales['persona_edo_civil'].'"></div>';
                echo ' <div class="col-2"><label>Edad</label><br><input class="input0" type="text" name="edad" value="'.$this->generales['persona_edad'].'"></div>';
            echo '</div>';

            echo '<div class="row">';
                echo '<div class="col-3"><label>Nacionalidad</label><br>';
                        $this->selects_creator('select * from nacionalidades order by nacionalidad_nombre','nacionalidad','nacionalidad_id','nacionalidad_nombre','nacionalidad','onChange= ""',$nacdefault);
                        echo $this->select;   
                echo '</div>';
                echo '<div class="col-3"><label>Pais</label><br>';
                        $this->selects_creator('select * from paises order by pais_nombre','pais','pais_id','pais_nombre','pais','onChange= "ver_estados();"',$paisdefault);
                        echo $this->select;   
                echo '</div>';
                echo ' <div class="col-3"><label>Estado</label><br>';
                    echo '<div id="cont_se">';
                        echo $selectestado;
                    echo '</div>'; 
                echo '</div>';
                echo ' <div class="col-3"><label>Municipio</label><br>';
                    echo '<div id="cont_sm">';
                        echo $selectmcp;
                    echo '</div>'; 
                echo '</div>';
            echo '</div>'; 
            
            echo '<div class="division"></div>';
          
            echo '<div class="row">';
                echo '<div class="col-3">';
                         echo '<h4>Datos Bancarios</h4>';
                echo '</div>';
                echo '<div class="col-3"><label>Banco</label><br>';
                        $this->selects_creator('select * from bancos order by banco_id','banco','banco_id','banco_nombre','Banco','onChange= ""',$bancodefault);
                        echo $this->select; 
                echo '</div>';
                echo '<div class="col-3"> <label>Clave Bancaria</label><br>'
                    .'<input class="input0" type="text" name="clavebanco" onkeypress="return solo_numeros(event);" value="'.$this->bancarios['db_cve'].'" placeholder="Clave interbancaria" required></div>';
                
                echo '<div class="col-3"><label>Cuenta</label><br>'
                    .'<input class="input0" type="text" name="cuenta" onkeypress="return solo_numeros(event);" value="'.$this->bancarios['db_cuenta'].'"placeholder="Numero de Cuenta" required ></div>';
            echo '</div>';  
           
            echo '<div class="division"></div>';
            
            echo '<div class="row">';  
                echo '<div class="col-2">';
                    echo '<h4 class="">Documentos</h4>';   
                echo '</div>';
                echo '<div class="col-3">';
                    echo '<div class="row">';
                        echo '<label class="lbd" for="ife">IFE o INNE</label>';
                        echo '<input type="checkbox" name="chk_ine" '.$checkedine.'><br>';
                    echo '</div>';
                    echo '<div class="row">';
                       echo '<label class="lbd" for="acta">Acta de nacimiento</label>';
                       echo '<input type="checkbox" name="chk_acta" '.$checkedacta.'><br>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<label class="lbd" for="comp">Comp. de domicilio</label>';
                        echo '<input type="checkbox" name="chk_comp" '.$checkedcomp.'><br>';
                    echo '</div>';
                    echo '<div class="row">';
                       echo '<label class="lbd" for="certificado">Comp. de estudios</label>';
                       echo '<input type="checkbox" name="chk_certificado" '.$checkedcertificado.'><br>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<label class="lbd" for="curp">CURP</label>';
                        echo '<input type="checkbox" name="chk_curp" '.$checkedcurp.'><br>';
                    echo '</div>';
                    echo '<div class="row">';    
                        echo '<label class="lbd" for="ref">RFC</label>';
                        echo '<input type="checkbox" name="chk_rfc" '.$checkedrfc.'><br>';
                    echo '</div>';
                echo '</div>';          
                    
                echo '<div class="col-3">';
                    echo '<div class="row">';
                        echo '<label class="lbd" for="nss"  >NSS</label>';
                        echo '<input type="checkbox" name="chk_nss"'.$checkednss.'><br>';                    
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<label class="lbd" for="licencia" >Licencia</label><br>';
                        echo '<input type="checkbox" name="chk_licencia"'.$checkedlicencia.'><br>';
                    echo '</div>';    
                    echo '<div class="row">';   
                        echo '<label class="lbd" for="recomendacion" >Cartas de Rec</label><br>';
                        echo '<input type="checkbox" name="chk_recomendacion"'.$checkedrecomendacion.'><br><br>';
                    echo '</div>'; 
                    echo '<div class="row">';   
                        echo '<label class="lbd" for="antecedentes">Const. de Antecedentes</label><br>';
                        echo '<input type="checkbox" name="chk_antecedentes"'.$checkedantecedentes.'><br>';
                    echo '</div>'; 
                    echo '<div class="row">';   
                        echo '<label class="lbd" for="fonacot">Fonacot</label><br>';
                        echo '<input type="checkbox" name="chk_fonacot" '.$checkedfonacot.'><br>';
                    echo '</div>'; 
                    echo '<div class="row">';   
                        echo '<label class="lbd" for="infonavit">Infonavit</label>';
                        echo '<input type="checkbox" name="chk_infonavit"'.$checkedinfonavit.'><br>';
                    echo '</div>'; 
                echo '</div>';     
            echo '</div>';     
            echo '<div class="division"></div>';
            echo '<div class="row-centrado">';
                echo '<button type="button" onclick="valida_campos(\''.$op.'\');" class="btnA" > Guardar </button>';   
                echo '<button type="button" onclick="self.close();"    class="btnA" style="margin-left:10px;">Cancelar</button>';
            echo '</div>';
        echo '</form>';
       
    }   
}
?>
