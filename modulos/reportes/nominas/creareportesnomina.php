<?php 
include('../../../config/conectasql.php');

    class creareportesnomina extends conectasql{
        protected $usid;
        protected $em;

    public function __construct($usid,$em) {
        $this->usid=$usid;
        $this->em=$em;
    }
    
    public function librerias() {
        echo '<script type="text/javascript" src="lanzaderareportes.js"></script>';
        /*librerias necesarias para generar el grid*/
        echo'
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="lanzaderareportes.js"></script>';
    }

    public function interfaz() {
        echo '<form name="opbusqueda" id="opbusqueda" method="post" action="exportar.php" target="_blank" >';
            echo'
            <div class="container">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Reportes de Nominas </h4>
                        </div>

                        <table class="table table-fixed">
                            <thead>
                                <tr>
                                    <th class="col-xs-2">#</th><th class="col-xs-8">Reporte</th><th class="col-xs-2">Exportar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-xs-2">1</td><td class="col-xs-8">Reporte principal de nomina</td><td><input type="button" id="idreporte" name="idreporte" onclick=window_open() value="Exportar"></input></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';
        //$this->listado();
        echo '</form>';
    }
}

?>