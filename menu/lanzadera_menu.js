window.onload=lanzadera;
function lanzadera (){
  iframe_default();
  document.oncontextmenu = function() { return false; };
}

function iframe_default(){
    window.frames['contenedor'].location.replace('msjdia.php');
}

function popup(url) {
	popupWindow = window.open(
	url,'cambiar','height=210px,width=320px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
        //alert('hola');
}

function logout(){
    if(confirm('¿Desea cerrar la sesion?')){
        document.salir.submit();
    }
}

function opcion(ruta){
    window.frames['contenedor'].location.replace(ruta);
}