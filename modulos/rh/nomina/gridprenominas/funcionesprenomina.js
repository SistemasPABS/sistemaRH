
function comenzarnomina(obj){
    
    var plazas = document.getElementById("plazas").value;
    var empresa = document.getElementById("empresa").value;
    var tipoperiodo = document.getElementById("tipoperiodo").value;
    var fechaperiodo = document.getElementById("fechaperiodo").value;
    var saldoplan = document.getElementById("saldoplan").value;
    var adicionales = document.getElementById("adicionales").value;
    var serviciosdirectos = document.getElementById("serviciosdirectos").value;
    var abono = document.getElementById("abono").value;
    var ingresos = document.getElementById("ingresos").value;
    var cobrosanteriores = document.getElementById("cobrosanteriores").value;
    var recibototal = document.getElementById("recibototal").value;
    var observaciones = document.getElementById("observaciones").value;
    var em = document.getElementById("em").value;
    var importador = document.getElementById("importador").checked;


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
    if (document.modalnomina.saldoplan.value.length==0){
      alert("Captura el saldo del plan, si no existieron servicios deberás capturar 0");
      document.modalnomina.saldoplan.focus();
      return 0;
    }else
    if (document.modalnomina.adicionales.value.length==0){
      alert("Captura los adicionales, si no existieron ventas deberás capturar 0");
      document.modalnomina.adicionales.focus();
      return 0;
    }else
    if (document.modalnomina.serviciosdirectos.value.length==0){
      alert("Captura los serviciosdirectos, si no existieron cobros deberás capturar 0");
      document.modalnomina.serviciosdirectos.focus();
      return 0;
    }else
    if (document.modalnomina.abono.value.length==0){
      alert("Hace falta capturar el abono, si no existió saldo deberás capturar 0");
      document.modalnomina.abono.focus();
      return 0;
    }else
    if (document.modalnomina.observaciones.value.length==0){
      alert("Captura las observaciones correspondientes");
      document.modalnomina.observaciones.focus();
      return 0;
    }else
    {
      if (tipoperiodo==4){
        location.href='../nominaajuste/selectpersonas.php?oc1='+btoa(plazas)+'&oc2='+btoa(empresa)+'&oc3='+btoa(tipoperiodo)+'&oc4='+btoa(fechaperiodo)+'&oc5='+btoa(saldoplan)+'&oc6='+btoa(adicionales)+'&oc7='+btoa(serviciosdirectos)+'&oc8='+btoa(abono)+'&oc9='+btoa(ingresos)+'&oc10='+btoa(observaciones)+'&oc11='+btoa(em)+'&oc12='+btoa(cobrosanteriores)+'&oc13='+btoa(recibototal);
    }else if(tipoperiodo != 4){
        location.href='../sobrerecibo/index.php?oc1='+btoa(plazas)+'&oc2='+btoa(empresa)+'&oc3='+btoa(tipoperiodo)+'&oc4='+btoa(fechaperiodo)+'&oc5='+btoa(saldoplan)+'&oc6='+btoa(adicionales)+'&oc7='+btoa(serviciosdirectos)+'&oc8='+btoa(abono)+'&oc9='+btoa(ingresos)+'&oc10='+btoa(observaciones)+'&oc11='+btoa(em)+'&oc12='+btoa(cobrosanteriores)+'&oc13='+btoa(recibototal);  
    }
    if((importador)&&(tipoperiodo!=4)){
        location.href='../importador/index.php';
      /* alert('HOLA'); */
    }
  }
}

function cargarperiodos(){
    //alert ('HOLA');
    var idtipoperiodo = document.getElementById("tipoperiodo").value;
    var idempresa = document.getElementById("empresa").value;
    var url = "../gridprenominas/selectperiodo.php";
    
    $.ajax({
            type: "POST",
            url:url,
            data:{idtp:btoa(idtipoperiodo),idempresa:btoa(idempresa)},
            success: function(data){
            //alert(data);    
            document.getElementById("fechas").innerHTML=data;
            //document.getElementById("informacionadicional").innerHTML=data;
            }
          });
}

function comprobar(obj){
  if(obj.checked){
    document.getElementById("archivoimportador").style.display="";
  }else{
    document.getElementById("archivoimportador").style.display="none";
  }
}

/*function cargaradicionales(){
  var idempresa = document.getElementById("empresa").value;
  var idtipoperiodo = document.getElementById("tipoperiodo").value;
  var url="../prenominas/seleccionador.php";
  
  $.ajax({
    type: "POST",
    url:url,
    data:{idempresa:btoa(idempresa),idtp:btoa(idtipoperiodo)},
    success:function(data){
      document.getElementById("informacionadicional").innerHTML=data;
    }
  })
}*/

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
