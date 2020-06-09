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
        echo '<script type="text/javascript" src="lanzadera_expediente.js"></script>';
    }
    
    public function formulario($op,$prs,$exp) {
        if($op=='editar'){
           $titulo = 'Edita Expediente';
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
            $this->consulta_doc_exp($exp);
            $descripcion= $this->consulta['exp_desc'];
            $this->selects_creator('select * from tipos_expedientes', 'tipo_exp', 'txp_id', 'txp_nombre', 'Tipo de Exp', 'onChange=""', $this->consulta['txp_id']);
            $select_tipo_exp = $this->select;
            
        }else if($op == 'nuevo'){
           $titulo = 'Agrega Expediente'; 
            $operacion= base64_encode($op);
            $operacion='?op='.$operacion;
           $this->selects_creator('select * from tipos_expedientes', 'tipo_exp', 'txp_id', 'txp_nombre', 'Tipo de Exp', '', '');
           $select_tipo_exp = $this->select;
           $descripcion='';
           $exp='';
        }
        
        echo '<head><title> '.$titulo.' </title></head>';
        echo '<form method="post" enctype="multipart/form-data" name="form_expediente" action="agrega_expediente.php'.$operacion.'">';
            echo '<div class"row">';
                echo '<div clas="titulo"><h2>'.$titulo.'</h2></div>';
            echo '</div>';
            echo '<div class="row">';
                echo '<input name="persona" id="persona" value="'.$prs.'" hidden>';
                echo '<input name="registro" id="registro" value="'.$exp.'" hidden>';
                echo '<div class="col-4">';
                    echo '<label>Tipo de Exp</label><br>';
                    echo $select_tipo_exp;
                echo '</div>';
                echo '<div class="col-4">'
                      . '<label>Descripcion</label><input class="input0" type="text" name="desc" onkeypress="return solo_letras(event);" id="desc" value="'.$descripcion.'" placeholder="Descripcion">'
                   . '</div>';
                echo '<div class="col-2"><label>Cargar Doc.</label><br><input type="file" name="doc" id="doc" ></div>';
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
