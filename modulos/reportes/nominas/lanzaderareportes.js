function window_open(url){
  window.open( "modalparaexportacion.php", "filtros", "width=500,height=380, top=85,left=50");
 }

function ejecutarreporte(){
  var idnomina = document.getElementById("idnomina").value;
  var url = "tiposreportesnomina/reporteespecial.php";
  $.ajax({
    type:"POST",
    url:url,
    data:{idnom:btoa(idnomina)},
    success: function(data){
    alert('Reporte ejecutado');    
    //success: function(datos){ $(\'#tabla\').html(datos); }
    }
});
}