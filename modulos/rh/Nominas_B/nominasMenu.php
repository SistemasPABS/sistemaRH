<?php
include ('../../../config/conectasql.php');

class nominasMenu extends conectasql{
    protected $usid;
    protected $em;
    
    public function __construct($usid,$em) {
        $this->usid=$usid;
        $this->em=$em;
    }
    
     public function librerias() {
        //Estilos
        echo '<link rel="stylesheet" type="text/css" href="../../../estilos/estilos.css">';
        echo '<link rel="stylesheet" type="text/css" href="styles.css">';
        

        //JavaScript
        echo '<script type="text/javascript" src="lanzadera.js"></script>';

       //Jquery
       echo '<script type="text/javascript" src="./lib/jquery3.5.js"></script>';
       echo '<link rel="stylesheet" href="../../../librerias/jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />

       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxcore.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxdata.js"></script> 
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxbuttons.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxscrollbar.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxlistbox.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxdropdownlist.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxmenu.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxgrid.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxgrid.pager.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxgrid.sort.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxgrid.filter.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxgrid.columnsresize.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxgrid.selection.js"></script> 
       <script type="text/javascript" src="../../../librerias/jqwidgets/jqwidgets/jqxpanel.js"></script>
       <script type="text/javascript" src="../../../librerias/jqwidgets/scripts/demos.js"></script>
       
       ';
    }
    
    public function interfaz() {
        //Titulo
            $enlaceDefault = 'none';
        
            echo '<div class="row">';
                echo '<div class="col-md-3">';

                echo '</div>';
                echo '<div class="col-md-1">';
                    echo '<img class="nomina-ico" src="./icon/nomina.png" alt="nomina">';
                echo '</div>';
                echo '<div class="col-md-5">';
                    echo '<h1 class="titulo_bc">Nominas</h1>';
                echo '</div>';
                echo '<div class="col-md-3">';
                    
                echo '</div>';
            echo '</div>';
           
            echo '<div class="row">';
                echo '<div class="col-md-12>"';
                    echo '<div class="division"></div>';
                echo '</div>';
            echo '</div>';
            
        //TABLA       
        echo '<form name="opbusqueda" id="opbusqueda" method="post" action="exportar.php" target="_blank" >';
            echo '<div name="busqueda" id="busqueda">';
                echo 'Buscar por: ';
                echo '<select class="selectbuscar" name="buscaopcion" id="buscaopcion" onchange="cambiaopciones(\'parametro\');">';
                    echo '<option value="nom" > # Nomina  </option>';
                    echo '<option value="plz" > Plaza </option>';
                    echo '<option value="area" > Area </option>';
                echo '</select>';
                echo '</div>';
                echo '<div name="paramentro" id="parametro"> <input type="text" id="busca" name="busca" class="campobuscar"></div>';
                echo '<div id="divus_buscar" name="divus_buscar"><input type="button" onclick="enviar();" class="cierre2" name="us_buscar" id="us_buscar" value="Buscar"></div>';

                echo '<div name="toolbar" id="toolbar" style="">';
                $this->permisos('papp', $this->em,$this->usid);

                if(in_array(88, $this->p3)){
                    echo '<div id="one" class="button">
                        <input class="cierre2" type="button" name="nuevo" id="one" value="Nuevo"        style="width:45px;" > 
                    </div>';
                    
                }
            
                //if(in_array(89, $this->p3)){echo '<input class="cierre2" type="button" name="editar"   id="editar"   value="Editar"    onclick="edita(\'administrar/nuevo_editar.php\',\''. base64_encode($this->em).'\',\''. base64_encode('editar').'\');" style="width:40px;" > ';}
            
            echo '</div>';  
                $this->listado();
        echo '</form>';


/******************************* MODAL SELECCION NOMINA *************************************/ 
    echo '<div id="modal-container">';
        echo '<div class="modal-background">';
            echo '<div class="modal">';
                echo '<div class="row">';
                    echo '<label class="titulo_1">Selecione Tipo de Nomina</label>';
                echo '</div>';
                echo '<div class="row">';
                    echo '<input class="btn_opc" type="button" name="nuevo" id="one" value="Nomina de Cobranza"  onclick="popup(\'Cobranza/index.php\',\''. base64_encode($this->em).'\',\''. base64_encode('nuevo').'\');" > ';
                echo '</div>';    
                echo '<div class="row">';
                    echo '<input class="btn_opc" type="button" name="nuevo" id="one" value="Nomina de Ventas"  onclick="popup(\'Ventas/index.php\',\''. base64_encode($this->em).'\',\''. base64_encode('nuevo').'\');" > ';
                echo '</div>';  
                echo '<div class="row">';
                    echo '<input class="btn_opc" type="button" name="nuevo" id="one" value="Nomina de Funeraria"  onclick="popup(\'Funeraria/index.php\',\''. base64_encode($this->em).'\',\''. base64_encode('nuevo').'\');" > ';
                echo '</div>';  
                echo '<div class="row">';
                    echo '<input class="btn_opc" type="button" name="nuevo" id="one" value="Nomina de Administartivos"  onclick="popup(\'Administracion/index.php\',\''. base64_encode($this->em).'\',\''. base64_encode('nuevo').'\');" > ';
                echo '</div>';  
            echo '</div>';
        echo '</div>';
    echo '</div>';
    
    
    /****************************** FIN MODAL SELECCION NOMINA ***********************************/

    echo '<script  src="./modal.js"></script>';    

    }

    public function listado() {       
        echo '<br>';                                                              
        echo '<div class="rtabla">';
        echo '<div id="jqxWidget" style="font-size: 8pt; font-family: Verdana; float: left;">
                <div id="jqxgrid" style="font-size: 8pt;" >
                </div>
              </div>';
        echo '</div>';



    } 
    
}

?>