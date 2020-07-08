function modificar(){
    //alert ('HOLA VIEJA CONFIABLE');
  var idnomina = document.getElementById("nomid").value;
  url = "./editarnomina.php";
  $.ajax({
    type: "POST",
    url:url,
    data:{idnom:btoa(idnomina)},
    success: function(data){
    //alert(data);    
    location.href='../gridprenominas/editarnomina.php?oc1='+btoa(idnomina);
    }
  });

}