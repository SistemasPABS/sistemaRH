function editarnomina(){
    
    var plazas = document.getElementById("plazas").value;
    var empresa = document.getElementById("empresa").value;
    var tipoperiodo = document.getElementById("tipoperiodo").value;
    var fechaperiodo=document.getElementById("fechaperiodo").value;
    var saldoplan = document.getElementById("saldoplan").value;
    var adicionales = document.getElementById("adicionales").value;
    var serviciosdirectos = document.getElementById("serviciosdirectos").value;
    var abono = document.getElementById("abono").value;
    var ingresos = document.getElementById("ingresos").value;
    var cobrosanteriores = document.getElementById("cobrosanteriores").value;
    var recibototal = document.getElementById("recibototal").value;
    var observaciones = document.getElementById("observaciones").value;
    var idnom = document.getElementById("idnom").value;

    location.href='./editarnomina/updatebasenom.php?oc0='+btoa(idnom)+'&oc1='+btoa(plazas)+'&oc2='+btoa(empresa)+'&oc3='+btoa(tipoperiodo)+'&oc4='+btoa(fechaperiodo)+'&oc5='+btoa(saldoplan)+'&oc6='+btoa(adicionales)+'&oc7='+btoa(serviciosdirectos)+'&oc8='+btoa(abono)+'&oc9='+btoa(ingresos)+'&oc10='+btoa(observaciones)+'&oc12='+btoa(cobrosanteriores)+'&oc13='+btoa(recibototal);

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

      function filtrarporfechas(){
        /*alert('HOLA');*/

        var fechacreacioninicio = document.getElementById("fechacreacioninicio").value;
        var fechacreacionfin = document.getElementById("fechacreacionfin").value;
        var em = document.getElementById("em").value;
        //alert (fechacreacioninicio+fechacreacionfin+em);
        //alert('em='+btoa(em)+'&fechacreacioninicio='+btoa(fechacreacioninicio)+'&fechacreacionfin='+btoa(fechacreacionfin));
        location.href='index.php?em='+btoa(em)+'&fechacreacioninicio='+btoa(fechacreacioninicio)+'&fechacreacionfin='+btoa(fechacreacionfin);

      }