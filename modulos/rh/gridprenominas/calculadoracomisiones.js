function calculadoracomisiones(btn){
    
    //Estoy obteniendo el ID de la comision 
    var tdpadre = btn.parentNode;
    var trpadre = tdpadre.parentNode;
    var tdidcomision = trpadre.childNodes[3];
    var idcomision = tdidcomision.firstChild.value;
    //alert(primerhijodelsegundohijo);

    //El valor será ingresado en el 7.firstchild
    var tdmontoenpesos = trpadre.childNodes[7]
    var montoenpesos = tdmontoenpesos.firstChild;
    //alert(montoenpesos);
    
    //Estoy obteniendo el monto bruto//
    var montobruto = btn.value;

    //Estoy obteniendo el monto historico//
    var tdmontohistorico=trpadre.childNodes[5];
    var montohistorico = tdmontohistorico.firstChild.value;
    //alert (montohistorico);

    //Estoy obteniendo el monto en porcentaje//
    var tdporcentaje = trpadre.childNodes[4];
    var porcentaje = tdporcentaje.firstChild.value;
    alert(porcentaje);
    
    /*if(montohistorico != 0){ //IF PARA LAS OPERACIONES QUE TIENEN MONTO Y NO PORCENTAJE
        if(idcomision == 17){
         var monto= montobruto * montohistorico;
        }
    }else{
        alert('No hay definicion para monto')
    }
    montoenpesos.value = monto;*/
}