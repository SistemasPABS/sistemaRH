<?php
include ('../../../../../config/conectasql.php');

class creanuevo_editar extends conectasql{
    protected $usid;
    protected $estid;


    public function __construct($usid, $estid) {
        $this->usid = $usid;
        $this->estid = $estid;
    }
    
    public function librerias() {
        echo '<link href="../../../../../estilos/personasStyles.css" type="text/css" rel="stylesheet">';
        echo '<script type="text/javascript" src="../../../../../librerias/jquery-1.10.2.min.js"></script>';
        echo '<script type="text/javascript" src="lanzadera_ausencia.js"></script>';
    }
    
    public function formulario($op,$prs,$aus) {
        if($op=='editar'){
            $titulo = 'Edita Ausencia';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->consulta_aus_per($aus);
            $this->selects_creator('select * from tipos_ausencias', 'tipo_aus', 'ta_id', 'ta_nombre', 'Tipo de Ausencia', 'onChange="bloquea_opciones()" disabled', $this->consulta['ta_id']);
            $select_tipo_aus = $this->select;
            $years= $this->consulta['aus_vac_years'];
            $dias= $this->consulta['aus_correspondientes'];
            $tomados= $this->consulta['aus_tomados'];
            $disp= $this->consulta['aus_disponibles'];
            $diasvac= $this->consulta['aus_dias_vac'];
            $diasrest= $this->consulta['aus_restantes'];
            $diasfaltas= $this->consulta['aus_dias'];
            if($this->consulta['ta_id'] == 2){
                $diasfaltasestado='readOnly="yes"';
            }else{
                $diasfaltasestado='';
            }
            $inicio= $this->consulta['aus_fecha_inicio'];
            $final=$this->consulta['aus_fecha_fin'];
            $descripcion= $this->consulta['aus_observaciones'];
            
            
        }else if($op == 'nuevo'){
            $titulo = 'Agrega Ausencia'; 
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->selects_creator('select * from tipos_ausencias', 'tipo_aus', 'ta_id', 'ta_nombre', 'Tipo de Ausencia', 'onChange="bloquea_opciones()"', '');
            $select_tipo_aus = $this->select;
            $aus='';
            //si es un registro nuevo se procede a calcular varias cosas
            //los años trabajando
            $sqlfi="select con_fecha_inicio from vw_contratos where persona_id=$prs and con_status=1";
            $resultfi= pg_query($this->conexion,$sqlfi);
            $rowfi= pg_fetch_array($resultfi);
            $fecha_inicio = $rowfi['con_fecha_inicio'];
            $dia_actual = date("Y-m-d");
            $antiguedad = date_diff(date_create($fecha_inicio), date_create($dia_actual));
            $years=$antiguedad->format('%y');
            //dias a los que tiene derecho
            $sqld="select dxy_cantidad_dias from dias_x_years where dxy_cantidad_years=$years";
            $resultd=pg_query($this->conexion,$sqld);
            $rowd= pg_fetch_array($resultd);
            $dias=$rowd['dxy_cantidad_dias'];
            //dias tomados en las ultimasaciones
            $yy=date("Y");
            $sqlt="select aus_dias_vac from ausencias where aus_fecha_inicio >= '$yy-01-01' and persona_id=$prs and ta_id=2 order by aus_id desc";
            $resultt= pg_query($this->conexion,$sqlt);
            if($rowt= pg_fetch_array($resultt)){
                do{
                    $tomados=$tomados+$rowt['aus_dias_vac'];
                }while($rowt= pg_fetch_array($resultt));
            }else{
                $tomados=0;
            }
            //calculando los disponibles
            $disp=$dias-$tomados;
            $diasvac='';
            $diasrest='';
            $diasfaltas='';
            $diasfaltasestado='';
            $inicio='';
            $final='';
            $descripcion='';
        }
        
        echo '<head><title> '.$titulo.' </title></head>';
        echo '<form method="post" enctype="multipart/form-data" name="form_aus" action="agrega_ausencia.php'.$operacion.'">';
            echo '<div class="row">';
                echo '<input name="persona" id="persona" value="'.$prs.'" hidden>';
                echo '<input name="registro" id="registro" value="'.$aus.'" hidden>';
                echo '<div class="col-4">';
                    echo '<label>Tipo de Ausencia</label><br>';
                    echo $select_tipo_aus;
                echo '</div>';
            echo '</div>';
            
            echo '<div class="division"></div>';
            echo '<div class="row">';
                echo '<div class="col-2"><label>Años</label><br><input onkeypress="return caracteres_esp(event)" class="input0" type="text" id="year" name="year" value="'.$years.'" readonly="yes"></div> ';
                echo '<div class="col-2"><label>Derecho</label><br><input onkeypress="return caracteres_esp(event)" class="input0" type="text" id="derecho" name="derecho" value="'.$dias.'" readonly="yes"></div> ';
                echo '<div class="col-2"><label>Tomados</label><br><input onkeypress="return caracteres_esp(event)" class="input0" type="text" id="tomados" name="tomados" value="'.$tomados.'" readonly="yes"></div> ';
                echo '<div class="col-2"><label>Disponibles</label><br><input onkeypress="return caracteres_esp(event)" class="input0" type="text" id="disp" name="disp" value="'.$disp.'" readonly="yes"></div> ';
                echo '<div class="col-2"><label>Dias para vac.</label><br><input onkeypress="return caracteres_esp(event)" class="input0" type="text" id="vac" name="vac" value="'.$diasvac.'" onChange="valida_vacaciones(this.value);"></div> ';
                echo '<div class="col-2"><label>Restantes</label><br><input onkeypress="return caracteres_esp(event)" class="input0" type="text" id="rest" name="rest" value="'.$diasrest.'" readonly="yes"></div> ';
            echo '</div>';
            
            echo '<div class="division"></div>';
            echo '<div class="row">';
                echo '<div class="col-2"><label>Dias</label><br><input onkeypress="return caracteres_esp(event)" class="input0" type="text" id="diasa" name="diasa" value="'.$diasfaltas.'" '.$diasfaltasestado.'></div> ';
                echo '<div class="col-2"><label>Fecha inicio</label><input class="inputdate" type="date" id="finicio" name="finicio"  value="'.$inicio.'"></div>';
                echo '<div class="col-2"><label>Fecha fin</label><input class="inputdate" type="date" id="ffin" name="ffin"  value="'.$final.'"></div>';
            echo '</div>';
            
            echo '<div class="division"></div>';
            echo '<div class="row">';
                echo '<div class="col-12"><label>Observaciones</label><br><input onkeypress="return caracteres_esp(event)" class="input0" type="text" id="obs" name="obs" value="'.$descripcion.'"></div> ';
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
