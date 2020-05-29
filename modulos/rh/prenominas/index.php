<?php
include ('../../../config/cookie.php');
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$usid=$_SESSION['us_id'];
$em=base64_decode($_GET['em']);//estructura menu
?>

<DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Prenómina</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"><!---Estilos de pestañas -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script><!---Estilos de pestañas -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script><!---Estilos de pestañas -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> <!-- Estilos de DataGrid-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css"> <!--Estilos de Datagrid -->
<link rel="stylesheet" href="https://code.jquery.com/jquery-3.5.1.js">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js">

<!---Estilos de pestañas --><script>
  $( function() {
    $( "#grupoTablas" ).tabs();
  } );
</script><!---Estilos de pestañas -->
<!--DATAGRID ESTILO JS-->
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>

</head>


<body> 
<div id="grupoTablas">
  <ul>
    <li><a href="#tab-1">Prenómina</a></li>
    <li><a href="#tab-2">Incidencias</a></li>
    <li><a href="#tab-3">Otras percepciones y Deducciones</a></li>
  </ul>
  <div id="tab-1"> <!--- Contenido Grid !-->
  <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nombre completo</th>
                <th>Puesto</th>
                <th>Plaza</th>
                <th>Sucursal</th>
                <th>Total Percepciones</th>
                <th>Total Deducciones</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="./sobrerecibo/index.php" data-toggle="modal">Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009/01/12</td>
                <td>$86,000</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2012/03/29</td>
                <td>$433,060</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
                <td>2008/11/28</td>
                <td>$162,700</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Brielle Williamson</td>
                <td>Integration Specialist</td>
                <td>New York</td>
                <td>61</td>
                <td>2012/12/02</td>
                <td>$372,000</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Herrod Chandler</td>
                <td>Sales Assistant</td>
                <td>San Francisco</td>
                <td>59</td>
                <td>2012/08/06</td>
                <td>$137,500</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Rhona Davidson</td>
                <td>Integration Specialist</td>
                <td>Tokyo</td>
                <td>55</td>
                <td>2010/10/14</td>
                <td>$327,900</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Colleen Hurst</td>
                <td>Javascript Developer</td>
                <td>San Francisco</td>
                <td>39</td>
                <td>2009/09/15</td>
                <td>$205,500</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Sonya Frost</td>
                <td>Software Engineer</td>
                <td>Edinburgh</td>
                <td>23</td>
                <td>2008/12/13</td>
                <td>$103,600</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Jena Gaines</td>
                <td>Office Manager</td>
                <td>London</td>
                <td>30</td>
                <td>2008/12/19</td>
                <td>$90,560</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Quinn Flynn</td>
                <td>Support Lead</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2013/03/03</td>
                <td>$342,000</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Charde Marshall</td>
                <td>Regional Director</td>
                <td>San Francisco</td>
                <td>36</td>
                <td>2008/10/16</td>
                <td>$470,600</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Haley Kennedy</td>
                <td>Senior Marketing Designer</td>
                <td>London</td>
                <td>43</td>
                <td>2012/12/18</td>
                <td>$313,500</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Tatyana Fitzpatrick</td>
                <td>Regional Director</td>
                <td>London</td>
                <td>19</td>
                <td>2010/03/17</td>
                <td>$385,750</td>
                <td>$256,000</td>
            </tr>
            <tr>
                <td>Michael Silva</td>
                <td>Marketing Designer</td>
                <td>London</td>
                <td>66</td>
                <td>2012/11/27</td>
                <td>$198,500</td>
                <td>$256,000</td>
            </tr>
    </table>
  </div>
  <div id="tab-2">
    <p>Contenido 2.</p>
  </div>
  <div id="tab-3">
    <p>Contenido 3.</p>
  </div>
</div>
 
</body>
</html>