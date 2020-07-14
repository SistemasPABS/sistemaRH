function editarnomina(){
    
    var plazas = document.getElementById("plazas").value;
    var empresa = document.getElementById("empresa").value;
    var tipoperiodo = document.getElementById("tipoperiodo").value;
    var fechaperiodo=document.getElementById("fechaperiodo").value;
    var numservicios = document.getElementById("numservicios").value;
    var ventasdirectas = document.getElementById("ventasdirectas").value;
    var cobrosporventa = document.getElementById("cobrosporventa").value;
    var saldo = document.getElementById("saldo").value;
    var cobrosanteriores = document.getElementById("cobrosanteriores").value;
    var observaciones = document.getElementById("observaciones").value;
    var idnom = document.getElementById("idnom").value;

    location.href='./editarnomina/updatebasenom.php?oc0='+btoa(idnom)+'&oc1='+btoa(plazas)+'&oc2='+btoa(empresa)+'&oc3='+btoa(tipoperiodo)+'&oc4='+btoa(fechaperiodo)+'&oc5='+btoa(numservicios)+'&oc6='+btoa(ventasdirectas)+'&oc7='+btoa(cobrosporventa)+'&oc8='+btoa(saldo)+'&oc9='+btoa(cobrosanteriores)+'&oc10='+btoa(observaciones);

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
        var filtro = '1234567890';//Caracteres validos
      
        //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos 
        for (var i=0; i<string.length; i++)
           if (filtro.indexOf(string.charAt(i)) != -1) 
                 //Se añaden a la salida los caracteres validos
           out += string.charAt(i);
      
        //Retornar valor filtrado
        return out;
      } 
