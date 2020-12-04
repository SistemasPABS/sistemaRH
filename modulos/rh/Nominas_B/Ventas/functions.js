window.onload=functions;

function functions() {
  autocompletable();
}

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
  var a = document.form_nominaVen.plazas.value;
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
   
  document.form_nominaVen.submit();
    
}

function popup(url,estid,op) {
  popupWindow = window.open(
url+'?em='+estid+'&op='+op,'aprs'+op,'height=350px,width=550px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}
