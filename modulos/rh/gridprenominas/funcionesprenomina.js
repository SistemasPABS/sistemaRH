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
    //alert(plazas+' '+empresa+' '+tipoperiodo+' '+fechaperiodo+' '+numservicios+' '+ventasdirectas+' '+cobrosporventa+' '+saldo+' '+cobrosanteriores+' '+observaciones);
    location.href='../sobrerecibo/index.php?oc1='+btoa(plazas)+'&oc2='+btoa(empresa)+'&oc3='+btoa(tipoperiodo)+'&oc4='+btoa(fechaperiodo)+'&oc5='+btoa(numservicios)+'&oc6='+btoa(ventasdirectas)+'&oc7='+btoa(cobrosporventa)+'&oc8='+btoa(saldo)+'&oc9='+btoa(cobrosanteriores)+'&oc10='+btoa(observaciones);
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