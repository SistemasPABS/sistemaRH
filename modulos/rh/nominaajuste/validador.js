function ajustarnomina(){
    var idpersona = document.getElementById("personaid").value;
    var url = 'ajustador.php';
    $.ajax({
        type: "POST",
        url:url,
        data:{perid:btoa(idpersona)},
        success: function(data){
        alert(data);    
        }
      });
}