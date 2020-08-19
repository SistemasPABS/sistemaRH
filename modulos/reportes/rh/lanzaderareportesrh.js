function window_open(url){
    window.open( "modalparaexportacion.php", "filtros", "width=500,height=380, top=85,left=50");
   }
  
  function ejecutarreporte(){
    var fechainicio = document.getElementById("fechainicio").value;
    var fechafin = document.getElementById("fechafin").value;
    location.href='tiposreportesrh/rendimientos.php?fechainicio='+btoa(fechainicio)+'&fechafin='+btoa(fechafin);
    //?idnom='+btoa(idnom)
} 