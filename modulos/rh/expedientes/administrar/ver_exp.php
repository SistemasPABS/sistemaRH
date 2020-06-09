<?php
include ('../../../../config/conectasql.php');

class ver_exp extends conectasql{
    protected $usid;
    protected $em;
    
    public function __construct($usid,$em) {
        $this->usid=$usid;
        $this->em=$em;
    }
    
     public function librerias() {
        echo '<link rel="stylesheet" type="text/css" href="../../../../estilos/estilos.css">';
        echo '<style type="text/css">.fondotrabajo{background-color: transparent;background-image: none;}</style>';
        echo '<script type="text/javascript" src="lanzadera_exp.js"></script>';
        /*librerias necesarias para generar el grid*/
        echo '<link rel="stylesheet" href="../../../../librerias/jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
        <script type="text/javascript" src="../../../../librerias/jqwidgets/scripts/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxdata.js"></script> 
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxbuttons.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxscrollbar.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxlistbox.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxdropdownlist.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxmenu.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxgrid.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxgrid.pager.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxgrid.sort.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxgrid.filter.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxgrid.columnsresize.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxgrid.selection.js"></script> 
        <script type="text/javascript" src="../../../../librerias/jqwidgets/jqwidgets/jqxpanel.js"></script>
        <script type="text/javascript" src="../../../../librerias/jqwidgets/scripts/demos.js"></script>
        '
        ;
    }
    
     public function interfaz($registro) {
         
        $this->consulta_exp_per($registro);
        $nombre= $this->consulta['nombrecompleto'];
        echo '<form name="opbusqueda2" id="opbusqueda2" method="post" action="exportar.php" target="_blank" >';
            echo '<input name="registro" id="registro" value="'.$registro.'" hidden>';
            echo '<div class="titulo"> <h2>Expediente de:'.$nombre.'</h2></div>';
            echo '<div name="busqueda" id="busqueda">';
                echo 'Buscar por: ';
                echo '<select class="selectbuscar" name="buscaopcion" id="buscaopcion" onchange="cambiaopciones(\'parametro\');">';
                    echo '<option value="tip" > Tipo Expediente </option>';
                    echo '<option value="des" > Descripción </option>';
                echo '</select>';
                echo '</div>';
                echo '<div name="paramentro" id="parametro"> <input type="text" id="busca" name="busca" class="campobuscar"></div>';
                echo '<div id="divus_buscar" name="divus_buscar"><input type="button" onclick="enviar();" class="cierre2" name="us_buscar" id="us_buscar" value="Buscar"></div>';

                echo '<div name="toolbar" id="toolbar" style="">';
                $this->permisos('papp', $this->em,$this->usid);
                if(in_array(56, $this->p3)){ echo '<input class="cierre2" type="button" name="nuevo"    id="nuevo"    value="Nuevo"     onclick="popup(\'Expediente/nuevo_editar.php\',\''. base64_encode(56).'\',\''. base64_encode('nuevo').'\',\''. base64_encode($registro).'\');" style="width:45px;" > ';}
                if(in_array(57, $this->p3)){ echo '<input class="cierre2" type="button" name="editar"   id="editar"   value="Editar"    onclick="edita(\'Expediente/nuevo_editar.php\',\''. base64_encode(57).'\',\''. base64_encode('editar').'\');" style="width:40px;" > ';}
                if(in_array(58, $this->p3)){ echo '<input class="cierre2" type="button" name="export"   id="expxls"   value="XLS"       onclick="exportar(\'exportar.php\',\'xls\');" style="width:40px;" >';}
            echo '</div>';  
        $this->listado();
        echo '</form>';
//         echo '</div>';
    }
    
    public function listado() {
     echo '<div class="rtabla">';
        echo '<div id="jqxWidget" style="font-size: 8pt; font-family: Verdana; float: left;">
                <div id="jqxgrid" style="font-size: 8pt;">
                </div>
             </div>'; 
     echo '</div>';
   }
}

?>