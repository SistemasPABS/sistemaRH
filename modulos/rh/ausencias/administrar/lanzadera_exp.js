window.onload = lanzadera;

function lanzadera (){
    document.oncontextmenu = function() { return false; };//funcion para menu contextual
    genera();//Funcion que genera el datagrid
}

function popup(url, estid, op, prs) {
        popupWindow = window.open(
	url+'?em='+estid+'&op='+op+'&prs='+prs ,'aprs'+op,'height=300px,width=1024px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}

function edita(url,estid,op){
    var exp = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    var prs = document.getElementById("registro").value;
    //alert('persona: '+prs+' exp: '+exp);
    if(exp != 0){
        if(confirm('¿Desea editar los datos del registro '+exp+'?')){
            popupWindow = window.open(
            url+'?em='+estid+'&op='+op+'&exp='+btoa(exp)+'&prs='+btoa(prs),'aexp'+btoa(exp),'height=780px,width=1024px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
        }
    }else{
        alert('Seleccione persona para editar');
    }
}

function exportar(url,chk3){
    var chk1 = document.getElementById("buscaopcion").value;
    var chk2 = document.getElementById("busca").value;
    //alert(chk1+' '+chk2);
    popupWindow = window.open(url+'?chk1='+btoa(chk1)+'&chk2='+btoa(chk2)+'&chk3='+btoa(chk3),'popup'+btoa(chk1),'height=780px,width=1024px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
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
        var dato3 = document.opbusqueda2.registro.value;        //valor registro
        
        var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'exp_id'},
                        { name: 'exp_desc'},
                        { name: 'exp_fecha'},
                        { name: 'exp_hora'},
                        { name: 'txp_nombre'},
                        { name: 'exp_ruta'}
                        ],
                        
                    url: 'datagrid.php?oc3='+btoa(dato3)

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
                      { text: 'Registro', datafield: 'exp_id',width: 100,cellsalign: 'center'},
                      { text: 'Descripcion', datafield: 'exp_desc',width: 300,cellsalign: 'center'},
                      { text: 'Fehca', datafield: 'exp_fecha', width: 180,cellsformat: 'D' },
                      { text: 'Hora', datafield: 'exp_hora', width: 90,cellsformat: 'D' },
                      { text: 'Tipo de Exp', datafield: 'txp_nombre',width:260,cellsformat: 'D'},
                      { text: 'Documento', datafield: 'exp_ruta', width:60,cellsalign: 'center' }
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
    var dato2 = document.opbusqueda2.buscaopcion.value;  //buscar por (nombre o clave)
    var dato  = document.opbusqueda2.busca.value;        //el valor a buscar
    var dato3 = document.opbusqueda2.registro.value;        //valor registro
    alert(dato3);
        var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'exp_id'},
                        { name: 'exp_desc'},
                        { name: 'exp_fecha'},
                        { name: 'exp_hora'},
                        { name: 'txp_nombre'},
                        { name: 'exp_ruta'}
                        ],
                        
                    url: 'datagrid.php?oc1='+btoa(dato)+'&oc2='+btoa(dato2)+'&oc3='+btoa(dato3)

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
                      { text: 'Registro', datafield: 'exp_id',width: 100,cellsalign: 'center'},
                      { text: 'Descripcion', datafield: 'exp_desc',width: 300,cellsalign: 'center'},
                      { text: 'Fehca', datafield: 'exp_fecha', width: 180,cellsformat: 'D' },
                      { text: 'Hora', datafield: 'exp_hora', width: 90,cellsformat: 'D' },
                      { text: 'Tipo de Exp', datafield: 'txp_nombre',width:260,cellsformat: 'D'},
                      { text: 'Documento', datafield: 'exp_ruta', width:60,cellsalign: 'center' }
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