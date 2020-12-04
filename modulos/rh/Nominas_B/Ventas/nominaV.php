<?php

include ('../sql.php');

class nominaV extends sqlad {
    
    protected $usid;
    protected $estid;

    public function __construct($usid, $estid) {
        $this->usid = $usid;
        $this->estid = $estid;
    }

    public function librerias() {

        echo '<link href="../styles.css" type="text/css" rel="stylesheet">';
        echo '<script type="text/javascript" src="../../../../librerias/jquery-1.10.2.min.js"></script>';
        echo '<script  src="./script.js"></script>';
        echo '<script  src="./functions.js"></script>';

    }
    
    public function interfaz($op,$prs) {

        $selectdefault='';
        $selectmcp='<select class="dropdown-select" name="" value="0">
                        <option value="1000">Seleccione una plaza</option>
                    </select>';

    echo '<form method="post" id="form_nominaVen" name="form_nominaVen" action="importaXls.php" enctype="multipart/form-data">';
                       
         /*Modal Seleccion de Nomina*/
        echo '<div id="modal" class="modal3">';
        echo '<div id="modal-content" class="modal-content">';
                echo '<div class="row">';
                    echo '<label class="titulo_1" >Detalles de Nomina Ventas</label></br>';
                echo '</div>';
                echo '<div class="row">';
                    echo'<div class="col-6">';
                        echo '<label class="titulo_2">Plaza</label><br>';
                        echo ' <div class="dropdown dropdown-dark">';
                            $this->selects_creator('select * from plazas order by plaza_id','plazas','plaza_id','plaza_nombre','plaza','onChange="ver_sucursales();"',0);
                            echo $this->select; 
                        echo '</div>';
                    echo'</div>';
                    echo'<div class="col-6">';
                        echo '<label class="titulo_2">Sucursal</label><br>';
                        echo '<div class="dropdown dropdown-dark">';
                        echo '<div id="cont_se">';
                            echo $selectmcp;
                            echo '</div>';
                        echo '</div>';
                    echo'</div>';           
                echo '</div>';
                echo '<div class="row">';
                    echo'<div class="col-8">';
                        echo '<br>';
                        /** Input para cargar el XP *****/
                        echo '<label for="custom-file-upload" class="filupp">
                                <span class="filupp-file-name js-value">Click para cargar un XP</span>
                                <input type="file" name="archivo" value="1" id="custom-file-upload"/>
                             </label>';

                    echo '</div>';

                    echo '<div class="col-4">';
                        echo '<label class="titulo_2">Semana:</label><br>';
                        echo '<div class="dropdown dropdown-dark">';
                            echo '<select class="dropdown-select" name="select">';
                            echo '<option value="0">Selecciona Nomina</option>';
                            for ($i=1; $i < 54; $i++) {
                                echo '<option value="'.$i.'">Sem '.$i.'</option>';
                            }
                            echo '</select>';
                        echo '</div>';    
                    echo '</div>';
                echo '<div class="row">';
                    echo '</br></br>';
                    echo'<div class="col-6">';
                        echo '<button type="button"  onclick="valida_campos();" class="btn_aceptar" > Generar Nomina </button>';
                    echo'</div>';
                    echo '<div class="col-6">';
                        echo '<br>';
                        echo '<input type="button" class="btn_xls" value="Plantilla">';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</form>';
    /*FIN DEL MODAL*/
 
    }
       
}
?>
