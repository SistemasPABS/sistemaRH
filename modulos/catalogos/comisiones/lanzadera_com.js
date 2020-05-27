window.onload=lanzadera;
function lanzadera (){
  document.oncontextmenu = function() { return false; };
  genera(); 
}
function input(id){
    document.getElementById('id').innerHTML = '<input>';
    return false;
}

function popup(url,estid,op) {
        popupWindow = window.open(
	url+'?em='+estid+'&op='+op,'acom'+op,'height=200px,width=740px,left=200,top=200, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}

function edita(url,estid,op){
    var com = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    //alert(suc);
    if(com != 0){
        if(confirm('¿Desea editar la comision '+com+'?')){
            popupWindow = window.open(
            url+'?em='+estid+'&op='+op+'&com='+btoa(com),'acom'+btoa(com),'height=200px,width=740px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
        }
    }else{
        alert('Seleccione la comision a editar');
    }
}

function eliminar_r(url) {
    //alert('hola');
    var com = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    if(com != 0){
        if(confirm('¿Desea eliminar la sucursal '+com+'?')){
            alert('valida que no existan comisiones asignadas');
        
//            $.ajax({
//                type:"POST",
//                url:url,
//                data:{prs:btoa(prs)},
//                success: function(data){
//                alert("Registro eliminado con exito");    //success: function(datos){ $(\'#tabla\').html(datos); }
//                }
//            });
//            genera();
        }
    }else{
        alert('Seleccione la comision que desea eliminar');
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
        var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'co_id'},
                        { name: 'co_nombre'},
                        { name: 'co_monto'},
                        { name: 'co_porcentaje'},
                        { name: 'plaza_nombre'},
                        { name: 'suc_nombre'},
                        { name: 'co_activo'}
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
                      { text: 'Registro', datafield: 'co_id',width: 150,cellsalign: 'center'},
                      { text: 'Comision', datafield: 'co_nombre',width: 150,cellsalign: 'center'},
                      { text: 'Monto', datafield: 'co_monto',width: 150,cellsalign: 'center'},
                      { text: 'Porcentaje', datafield: 'co_porcentaje', width: 150,cellsformat: 'center'},
                      { text: 'Plaza', datafield: 'plaza_nombre', width: 150,cellsformat: 'center' },
                      { text: 'Sucursal', datafield: 'suc_nombre', width: 150,cellsformat: 'center' },
                      { text: 'Status', datafield: 'co_activo', width: 90,cellsformat: 'center' }
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
    var dato  = document.opbusqueda.busca.value;       //el valor a buscar
    var dato2 = document.opbusqueda.buscaopcion.value;//buscar por (nombre o clave)
    //alert(dato+' '+dato2);
        var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'co_id'},
                        { name: 'co_nombre'},
                        { name: 'co_monto'},
                        { name: 'co_porcentaje'},
                        { name: 'plaza_nombre'},
                        { name: 'suc_nombre'},
                        { name: 'co_activo'}
                        ],
                        
                    url: 'datagrid.php?oc1='+btoa(dato)+'&oc2='+btoa(dato2)

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
                      { text: 'Registro', datafield: 'co_id',width: 150,cellsalign: 'center'},
                      { text: 'Comision', datafield: 'co_nombre',width: 150,cellsalign: 'center'},
                      { text: 'Monto', datafield: 'co_monto',width: 150,cellsalign: 'center'},
                      { text: 'Porcentaje', datafield: 'co_porcentaje', width: 150,cellsformat: 'center' },
                      { text: 'Plaza', datafield: 'plaza_nombre', width: 150,cellsformat: 'center' },
                      { text: 'Sucursal', datafield: 'suc_nombre', width: 150,cellsformat: 'center' },
                      { text: 'Status', datafield: 'co_activo', width: 90,cellsformat: 'center' }
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