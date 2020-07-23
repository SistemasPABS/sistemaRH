function window_open(url){
  window.open( "modalparaexportacion.php", "filtros", "width=500,height=380, top=85,left=50");
 }

function cargarperiodos(){
  var idtipoperiodo = document.getElementById("tipoperiodo").value;
  var url = "../../rh/gridprenominas/selectperiodo.php";
  $.ajax({
        type: "POST",
        url:url,
        data:{idtp:btoa(idtipoperiodo)},
        success: function(data){
        //alert(data);    
        document.getElementById("fechas").innerHTML=data;
        }
      });
}

function ejecutarreporte(){
  var idtipoperiodo = document.getElementById("tipoperiodo").value;
  var idperiodo = document.getElementById("fechaperiodo").value;
  var plaza = document.getElementById("plazas").value;
  //var empresa  = document.getElementById("empresa").value;
  location.href = './tiposreportesnomina/reporteespecial.php?idtipoperiodo='+btoa(idtipoperiodo)+'idperiodo='+btoa(idperiodo)+'plaza='+btoa(plaza);

}