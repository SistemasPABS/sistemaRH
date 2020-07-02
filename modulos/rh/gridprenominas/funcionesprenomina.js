function comenzarnomina(){
    
    var plazas = document.getElementById("plazas").value.required = true;
    var empresa = document.getElementById("empresa").value.required = true;
    var tipoperiodo = document.getElementById("tipoperiodo").value.required = true;
    var fechaperiodo = document.getElementById("fechaperiodo").value.required =true;
    var numservicios = document.getElementById("numservicios").value.required = true;
    var ventasdirectas = document.getElementById("ventasdirectas").value.required=true;
    var cobrosporventa = document.getElementById("cobrosporventa").value.required=true;
    var saldo = document.getElementById("saldo").value.required=true;
    var cobrosanteriores = document.getElementById("cobrosanteriores").value.required=true;
    var observaciones = document.getElementById("observaciones").value.required=true;


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

function gridnomina(){
  location.href='../gridprenominas/index.php';
}