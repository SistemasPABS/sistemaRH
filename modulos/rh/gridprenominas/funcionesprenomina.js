$('#empresa').multiselect({
  columns: 1,
  placeholder: 'Select Languages'
});

function comenzarnomina(){
    
    var plazas = document.getElementById("plazas").value;
    var empresa = document.getElementById("empresa").value;
    var tipoperiodo = document.getElementById("tipoperiodo").value;
    var fechaperiodo = document.getElementById("fechaperiodo").value;
    var numservicios = document.getElementById("numservicios").value;
    var ventasdirectas = document.getElementById("ventasdirectas").value;
    var cobrosporventa = document.getElementById("cobrosporventa").value;
    var saldo = document.getElementById("saldo").value;
    var cobrosanteriores = document.getElementById("cobrosanteriores").value;
    var observaciones = document.getElementById("observaciones").value;
    var em = document.getElementById("em").value;


    if (document.modalnomina.plazas.value.length==0){
      alert("Se debe escoger una plaza");
      document.modalnomina.plazas.focus();
      return 0;
    }else
    if (document.modalnomina.empresa.value.length==0){
      alert("Se debe escoger una empresa");
      document.modalnomina.empresa.focus();
      return 0;
    }else
    if (document.modalnomina.tipoperiodo.value.length==0){
      alert("Se debe escoger un tipo de periodo");
      document.modalnomina.tipoperiodo.focus();
      return 0;
    }else
    if (document.modalnomina.fechaperiodo.value.length==0){
      alert("Selecciona una fecha del periodo");
      document.modalnomina.fechaperiodo.focus();
      return 0;
    }else
    if (document.modalnomina.numservicios.value.length==0){
      alert("Captura numeros de servicios, si no existieron servicios deberás capturar 0");
      document.modalnomina.numservicios.focus();
      return 0;
    }else
    if (document.modalnomina.ventasdirectas.value.length==0){
      alert("Captura las ventas directas, si no existieron ventas deberás capturar 0");
      document.modalnomina.ventasdirectas.focus();
      return 0;
    }else
    if (document.modalnomina.cobrosporventa.value.length==0){
      alert("Captura los cobros por venta, si no existieron cobros deberás capturar 0");
      document.modalnomina.cobrosporventa.focus();
      return 0;
    }else
    if (document.modalnomina.saldo.value.length==0){
      alert("Hace falta capturar el saldo, si no existió saldo deberás capturar 0");
      document.modalnomina.saldo.focus();
      return 0;
    }else
    if (document.modalnomina.observaciones.value.length==0){
      alert("Captura las observaciones correspondientes");
      document.modalnomina.observaciones.focus();
      return 0;
    }else
    {
      location.href='../sobrerecibo/index.php?oc1='+btoa(plazas)+'&oc2='+btoa(empresa)+'&oc3='+btoa(tipoperiodo)+'&oc4='+btoa(fechaperiodo)+'&oc5='+btoa(numservicios)+'&oc6='+btoa(ventasdirectas)+'&oc7='+btoa(cobrosporventa)+'&oc8='+btoa(saldo)+'&oc9='+btoa(cobrosanteriores)+'&oc10='+btoa(observaciones)+'&oc11='+btoa(em);
    }
    
    //alert(plazas+' '+empresa+' '+tipoperiodo+' '+fechaperiodo+' '+numservicios+' '+ventasdirectas+' '+cobrosporventa+' '+saldo+' '+cobrosanteriores+' '+observaciones);
    
    //location.href='../sobrerecibo/index.php?oc1='+btoa(plazas)+'&oc2='+btoa(empresa)+'&oc3='+btoa(tipoperiodo)+'&oc4='+btoa(fechaperiodo)+'&oc6='+btoa(numservicios)+'&oc7='+btoa(ventasdirectas)+'&oc8='+btoa(cobrosporventa)+'&oc9='+btoa(saldo)+'&oc10='+btoa(cobrosanteriores)+'&oc11='+btoa(observaciones); //'datagrid.php?oc1='+btoa(dato)+'&oc2='+btoa(dato2)  

}

function cargarperiodos(){
    //alert ('HOLA');
    var idtipoperiodo = document.getElementById("tipoperiodo").value;
    var url = "../gridprenominas/selectperiodo.php";
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
