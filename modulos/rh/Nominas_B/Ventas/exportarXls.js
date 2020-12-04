/**Funciones de descarga de archivos de nomina */
function exportTableToExcel(tableID, filename = ''){
  
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById("nominaTb");
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    //Nombre y extencion del archivo
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // link para el autodescarfga
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Enlace de descarga junto al enlace 
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        //pepara autodescarga
        downloadLink.download = filename;
        //ejecutar autodescarga
        downloadLink.click();
    }
}