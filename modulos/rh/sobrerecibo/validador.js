function traerpercepcionesdeducciones(opc,btn){
   //Obtener ID de Persona para evaluador.php 
   var papaboton = btn.parentNode;
   var hermano = papaboton.parentNode;
   
   var personaid = hermano.value;
   
    
   var papa = btn.parentNode;
   var hijo = papa.parentNode;
   var nieto = hijo.parentNode;
   
   //alert(abuelo);
   var tr = document.createElement("tr");
   
   
   var url = "evaluador.php";
    $.ajax({
            type: "POST",
            url:url,
            data:{opc:btoa(opc),perid:btoa(personaid)},
            success: function(data){
            //alert(data);    
            tr.innerHTML=data;
            nieto.appendChild(tr);
            }
          });

}

function enviarnomina(){
     if(confirm('Estas apunto de hacer explotar el sistema ')){
         if(confirm('¿SEGURO SEGURISIMO?')){
             //pendiente a realizar las validaciones 
         var cantidadpersonas = document.getElementsByName("persona[]");
         var cantidadpersonas = cantidadpersonas.length;
         document.getElementById("cantpersonas").value=cantidadpersonas;
         document.todalanomina.submit();
         }
     }
     
    
}
