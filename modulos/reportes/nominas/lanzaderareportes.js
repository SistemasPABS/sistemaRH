function window_open(url){
    window.open( "modalparaexportacion.php", "filtros", "width=500,height=380, top=85,left=50");
   }
  
  function ejecutarreporte(){
    var idnom = document.getElementById("idnomina").value;
    location.href='reporteespecial.php?idnom='+btoa(idnom);
    //?idnom='+btoa(idnom)
} 