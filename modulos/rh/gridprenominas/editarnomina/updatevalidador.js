function traerpercepcionesdeducciones(opc,btn){
    //Obtener ID de Persona para evaluador.php 
    var papaboton = btn.parentNode;
    var personaid = papaboton.childNodes[1].value;
    var papa = btn.parentNode;
    var hijo = papa.parentNode;
    var nieto = hijo.parentNode;
    
    //alert(abuelo);
    var tr = document.createElement("tr"); 
    var url = "updateevaluador.php";
     $.ajax({
             type: "POST",
             url:url,
             data:{opc:btoa(opc),perid:btoa(personaid)},
             success: function(data){
             //alert(data);    
             tr.innerHTML=data;
             nieto.appendChild(tr)
             }
           });
 
 }
 
 function editnomina(){
        //alert ("Hello");
      if(confirm('En este momento actualizaras tu nomina')){
          if(confirm('¿Deseas continuar?')){
              //pendiente a realizar las validaciones 
          var cantidadpersonas = document.getElementsByName("persona[]");
          var cantidadpersonas = cantidadpersonas.length;
          document.getElementById("cantpersonas").value=cantidadpersonas;
          document.todalanomina.submit();
          }
        else{
        }
      }
      
     
 }

 
 function NumText(string){//solo letras y numeros
  var out = '';
  //Se añaden las letras validas
  var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890 ';//Caracteres validos

  for (var i=0; i<string.length; i++)
     if (filtro.indexOf(string.charAt(i)) != -1) 
     out += string.charAt(i);
  return out;
}



function Numeros(string){//Solo numeros
  var out = '';
  var filtro = '12345678900.0';//Caracteres validos

  //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos 
  for (var i=0; i<string.length; i++)
     if (filtro.indexOf(string.charAt(i)) != -1) 
           //Se añaden a la salida los caracteres validos
     out += string.charAt(i);

  //Retornar valor filtrado
  return out;
} 
 