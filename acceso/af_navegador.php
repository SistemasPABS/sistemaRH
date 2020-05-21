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
.boton {
  cursor: pointer;
  margin: 10px;
  border-radius: 5px;
  text-decoration: none;
  padding: 10px;
  font-size: 22px;
  transition: .3s;
  -moz-transition: .3s;
   display: inline-block;
  color: #55acee;
  border: 2px #55acee solid;
}


</style>

HTML;

echo '<div id="absolut"><h2>Necesitas un navegador Firefox para poder utilizar la aplicacion</h2>'
    .'<img id="logo" src="../images/Firefox_logo.png" alt = "Firefox Logo"> </br>'
    .'<a class="boton" href="https://www.mozilla.org/es-MX/firefox/new/">Descarga aquì</a>'   
    .'</div>';
   

?>