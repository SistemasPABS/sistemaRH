<?php

echo <<< HTML
	<style type="text/css">
#absolut {
   padding: 15%; 
   justify-content: center;
   text-align: center;
   font-family: Arial, Helvetica, sans-serif;
}
#logo {
   width: 150px;
   height: auto;
}
</style>

HTML;

echo '<div id="absolut"><img id="logo" src="../images/advertencia.png" alt = "Firefox Logo"> </br>'
    .'<h2> La maquina desde la cual estas tratando de acceder no esta autorizada para poder utilizar la aplicacion</h2>'
    .'<h3>Ponte en contacto con tu administrador de sistemas </h3>'
    .'</div>';

?>