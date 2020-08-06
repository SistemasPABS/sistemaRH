window.onload = lanzadera;

function lanzadera (){
    document.oncontextmenu = function() { return false; };//funcion para menu contextual
    genera();//Funcion que genera el datagrid
}

function input(id){
    //
    document.getElementById('id').innerHTML = '<input>';
    return false;
}

function popup(url,estid){
   var prs = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    //alert(prs);
    if(prs != 0){
        if(confirm('¿Desea ver el expediente de '+prs+'?')){
            popupWindow = window.open(
            url+'?em='+estid+'&prs='+btoa(prs),'aprs'+btoa(prs),'height=780px,width=1024px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
        }
    }else{
        alert('Seleccione persona para ver expedientes');
    }
}

function pulsar(e) {
    tecla = (document.all) ? e.keyCode :e.which;
    return(tecla!=13);
} 

function cambiaopciones(posicion,id){
    document.getElementById(posicion).innerHTML = ('<input type="text" id="busca" name="busca" class="campobuscar" >');
    return false;
}

function genera() { 
        var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'persona_id'},
                        { name: 'persona_cve'},
                        { name: 'con_fecha_inicio'},
                        { name: 'nombrecompleto'},
                        { name: 'plaza_nombre'},
                        { name: 'suc_nombre'},
                        { name: 'persona_correo'},
                        { name: 'persona_status'}
                        ],
                        
                    url: 'datagrid.php'

                };
                var dataAdapter = new $.jqx.dataAdapter(source);

                $("#jqxgrid").jqxGrid(
                {
                    width: 990,
                    source: dataAdapter,
                    selectionmode: 'multiplerowsextended',
                    sortable: true,
                    pageable: true,
                    autoheight: true,
                    columnsresize: true,
                    columns: [
                      { text: 'Registro', datafield: 'persona_id',width: 100,cellsalign: 'center'},
                      { text: 'Clave', datafield: 'persona_cve',width: 100,cellsalign: 'center'},
                      { text: 'Fecha ingreso', datafield: 'con_fecha_inicio',width: 100,cellsalign: 'center'},
                      { text: 'Nombre Completo', datafield: 'nombrecompleto', width: 280,cellsformat: 'D' },
                      { text: 'Plaza', datafield: 'plaza_nombre', width: 200,cellsformat: 'D' },
                      { text: 'Area', datafield: 'suc_nombre', width: 100,cellsformat: 'D' },
                      { text: 'Correo', datafield: 'persona_correo', width: 190,cellsformat: 'D' },
                      { text: 'Estatus', datafield: 'persona_status', width:60,cellsalign: 'center' }
                    ]

                });

                $('#events').jqxPanel({ width: 100, height: 100});

                $("#jqxgrid").on("pagechanged", function (event) {
                    $("#eventslog").css('display', 'block');
                    if ($("#events").find('.logged').length >= 5) {
                        $("#events").jqxPanel('clearcontent');
                    }

                    var args = event.args;
                    var eventData = "pagechanged <div>Page:" + args.pagenum + ", Page Size: " + args.pagesize + "</div>";
                    $('#events').jqxPanel('prepend', '<div class="logged" style="margin-top: 5px;">' + eventData + '</div>');

                    // get page information.
                    var paginginformation = $("#jqxgrid").jqxGrid('getpaginginformation');
                    $('#paginginfo').html("<div style=\'margin-top: 5px;\'>Page:" + paginginformation.pagenum + ", Page Size: " + paginginformation.pagesize + ", Pages Count: " + paginginformation.pagescount + "</div>");
                });

                $("#jqxgrid").on("pagesizechanged", function (event) {
                    $("#eventslog").css('display', 'block');
                    $("#events").jqxPanel('clearcontent');

                    var args = event.args;
                    var eventData = "pagesizechanged <div>Page:" + args.pagenum + ", Page Size: " + args.pagesize + ", Old Page Size: " + args.oldpagesize + "</div>";
                    $('#events').jqxPanel('prepend', '<div style="margin-top: 5px;">' + eventData + '</div>');

                    // get page information.          
                    var paginginformation = $("#jqxgrid").jqxGrid('getpaginginformation');
                    $('#paginginfo').html("<div style=\'margin-top: 5px;\'>Page:" + paginginformation.pagenum + ", Page Size: " + paginginformation.pagesize + ", Pages Count: " + paginginformation.pagescount + "</div>");
                });
}

function enviar() { 
    var dato2 = document.opbusqueda.buscaopcion.value;//buscar por (nombre o clave)
    var dato  = document.opbusqueda.busca.value;       //el valor a buscar
    
        var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'persona_id'},
                        { name: 'persona_cve'},
                        { name: 'con_fecha_inicio'},
                        { name: 'nombrecompleto'},
                        { name: 'plaza_nombre'},
                        { name: 'suc_nombre'},
                        { name: 'persona_correo'},
                        { name: 'persona_status'}
                        ],
                        
                    url: 'datagrid.php?oc1='+btoa(dato)+'&oc2='+btoa(dato2)+''

                };
                var dataAdapter = new $.jqx.dataAdapter(source);

                $("#jqxgrid").jqxGrid(
                {
                    width: 990,
                    source: dataAdapter,
                    selectionmode: 'multiplerowsextended',
                    sortable: true,
                    pageable: true,
                    autoheight: true,
                    columnsresize: true,
                    columns: [
                      { text: 'Registro', datafield: 'persona_id',width: 100,cellsalign: 'center'},
                      { text: 'Clave', datafield: 'persona_cve',width: 100,cellsalign: 'center'},
                      { text: 'Fecha ingreso', datafield: 'con_fecha_inicio',width: 100,cellsalign: 'center'},
                      { text: 'Nombre Completo', datafield: 'nombrecompleto', width: 280,cellsformat: 'D' },
                      { text: 'Plaza', datafield: 'plaza_nombre', width: 200,cellsformat: 'D' },
                      { text: 'Area', datafield: 'suc_nombre', width: 100,cellsformat: 'D' },
                      { text: 'Correo', datafield: 'persona_correo', width: 190,cellsformat: 'D' },
                      { text: 'Estatus', datafield: 'persona_status', width:60,cellsalign: 'center' }
                    ]

                });

                $('#events').jqxPanel({ width: 100, height: 100});

                $("#jqxgrid").on("pagechanged", function (event) {
                    $("#eventslog").css('display', 'block');
                    if ($("#events").find('.logged').length >= 5) {
                        $("#events").jqxPanel('clearcontent');
                    }

                    var args = event.args;
                    var eventData = "pagechanged <div>Page:" + args.pagenum + ", Page Size: " + args.pagesize + "</div>";
                    $('#events').jqxPanel('prepend', '<div class="logged" style="margin-top: 5px;">' + eventData + '</div>');

                    // get page information.
                    var paginginformation = $("#jqxgrid").jqxGrid('getpaginginformation');
                    $('#paginginfo').html("<div style=\'margin-top: 5px;color:black;\'>Page:" + paginginformation.pagenum + ", Page Size: " + paginginformation.pagesize + ", Pages Count: " + paginginformation.pagescount + "</div>");
                });

                $("#jqxgrid").on("pagesizechanged", function (event) {
                    $("#eventslog").css('display', 'block');
                    $("#events").jqxPanel('clearcontent');

                    var args = event.args;
                    var eventData = "pagesizechanged <div>Page:" + args.pagenum + ", Page Size: " + args.pagesize + ", Old Page Size: " + args.oldpagesize + "</div>";
                    $('#events').jqxPanel('prepend', '<div style="margin-top: 5px;">' + eventData + '</div>');

                    // get page information.          
                    var paginginformation = $("#jqxgrid").jqxGrid('getpaginginformation');
                    $('#paginginfo').html("<div style=\'margin-top: 5px;color:black;\'>Page:" + paginginformation.pagenum + ", Page Size: " + paginginformation.pagesize + ", Pages Count: " + paginginformation.pagescount + "</div>");
                });
}