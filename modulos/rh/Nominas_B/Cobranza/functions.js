// FUNCIONES DEL MODAL

var modal = document.getElementById("modal");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

$(document).ready(function() {

  // get the name of uploaded file
	$('input[type="file"]').change(function(){
		var value = $("input[type='file']").val();
		$('.js-value').text(value);
	});

});


function ver_sucursales(){
  //alert('hola');
  var a = document.form_nominaCob.plazas.value;
  var a = btoa(a);
  var est = btoa('suc');
 // alert("valores "+a+" "+est);
  var url = "agrega_selects.php";
        $.ajax({
            type: "POST",
            url:url,
            data:{ns:a,op:est},
            success: function(data){
            document.getElementById("cont_se").innerHTML=data;
          }
        });
}
 

function valida_campos(op){
   
   /* if (document.form_personas.clave.value.length==0){
    alert("El nuevo empleado debe tener una clave");
    document.form_personas.clave.focus();
    return 0;
    }*/
    
    document.form_nominaCob.submit();
    
 }