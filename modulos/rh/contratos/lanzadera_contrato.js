window.onload=lanzadera;
function lanzadera (){
  //Bloquea el menu contextual del formulario
  document.oncontextmenu = function() { return false; };
  genera(); 
}

function input(id){
    document.getElementById('id').innerHTML = '<input>';
    return false;
}

//Ventana emergente para la creacion  de contratos
function popup(url,estid,op) {
        popupWindow = window.open(
	url+'?em='+estid+'&op='+op,'apst'+op,'height=600px,width=850px,left=200,top=200, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}

//Ventana emergente para la edicion de un contrato
function edita(url,estid,op){
    var cto = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    //alert(suc);
    if( cto != 0){
        if(confirm('¿Desea editar los datos del contrato '+cto+'?')){
            popupWindow = window.open(
            url+'?em='+estid+'&op='+op+'&cto='+btoa(cto),'apst'+btoa(cto),'height=780px,width=1024px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
        }
    }else{
        alert('Seleccione un contrato para editar');
    }
}
//Funcion de eliminar pendiente por validaciones
function eliminar_r(url) {
    //alert('hola');
    var cto = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    if(cto != 0){
        if(confirm('¿Desea eliminar el contrato '+cto+'?')){
            alert('hola');
        
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
        alert('Seleccione el contrato que desea eliminar');
    }
}
//Funcion para exportar los resultados del datagrid
function exportar(url,dato4){
    var dato  = document.opbusqueda.plazas.value;       //plaza a buscar
    var dato2 = document.opbusqueda.sucursales.value;   //sucursal a buscar
    var dato3 = document.opbusqueda.busca.value;        //por nombre de contrato
    //alert(chk1+' '+chk2);
    popupWindow = window.open(url+'?chk1='+btoa(dato)+'&chk2='+btoa(dato2)+'&chk3='+btoa(dato3)+'&chk4='+btoa(dato4),'popup'+btoa(dato),'height=780px,width=1024px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}
//Funcion para generar el contrato en doc del contrato seleccionado en el datagrid
function contrato(url){
    //alert('hola');
    var ct = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    if(ct != 0){
        if(confirm('¿Desea generar el contrato '+ct+'?')){
            popupWindow = window.open(
            url+'?ct='+btoa(ct),'act'+btoa(ct),'height=400px,width=600px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
        }
    }else{
        alert('Seleccione una persona para generar el contrato');
    }
}
//Evento del Enter
function pulsar(e) {
    tecla = (document.all) ? e.keyCode :e.which;
    return(tecla!=13);
} 

//Funcion para generar la estructura del datagrid
function genera() {
        var dato  = document.opbusqueda.plazas.value;
        var dato2 = document.opbusqueda.busca.value;
        var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'con_id'},
                        { name: 'nombrecompleto'},
                        { name: 'tipoc_nombre'},
                        { name: 'tipoc_plantilla'},
                        { name: 'plaza_nombre'},
                        { name: 'raz_nombre'},
                        { name: 'puesto_nombre'},
                        { name: 'con_fecha_inicio'},
                        { name: 'con_fecha_fin'},
                        { name: 'con_status'}
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
                        { text: 'Registro', datafield: 'con_id',width: 60,cellsalign: 'center'},
                        { text: 'Nombre', datafield: 'nombrecompleto',width: 230,cellsalign: 'center'},
                        { text: 'Contrato', datafield: 'tipoc_nombre',width: 100,cellsalign: 'center'},
                        { text: 'Documento', datafield: 'tipoc_plantilla',width: 90,cellsalign: 'center'},
                        { text: 'Plaza', datafield: 'plaza_nombre',width: 60,cellsalign: 'center'},
                        { text: 'Razon Social', datafield: 'raz_nombre', width: 90,cellsformat: 'center' },
                        { text: 'Puesto', datafield: 'puesto_nombre', width: 90, cellsformat: 'centre'},
                        { text: 'Fecha inicial', datafield: 'con_fecha_inicio', width: 100, cellsformat: 'center'},
                        { text: 'Fecha final', datafield: 'con_fecha_fin',width: 100,cellsalign: 'center'},
                        { text: 'Status', datafield: 'con_status',width: 70,cellsalign: 'center'}
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
    var dato  = document.opbusqueda.plazas.value;       //plaza a buscar
    var dato2 = document.opbusqueda.busca.value;        //por nombre de contrato
    //alert(dato+' '+dato2);
        var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'con_id'},
                        { name: 'nombrecompleto'},
                        { name: 'tipoc_nombre'},
                        { name: 'tipoc_plantilla'},
                        { name: 'plaza_nombre'},
                        { name: 'raz_nombre'},
                        { name: 'puesto_nombre'},
                        { name: 'con_fecha_inicio'},
                        { name: 'con_fecha_fin'},
                        { name: 'con_status'}
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
                        { text: 'Registro', datafield: 'con_id',width: 60,cellsalign: 'center'},
                        { text: 'Nombre', datafield: 'nombrecompleto',width: 230,cellsalign: 'center'},
                        { text: 'Contrato', datafield: 'tipoc_nombre',width: 100,cellsalign: 'center'},
                        { text: 'Documento', datafield: 'tipoc_plantilla',width: 90,cellsalign: 'center'},
                        { text: 'Plaza', datafield: 'plaza_nombre',width: 60,cellsalign: 'center'},
                        { text: 'Razon Social', datafield: 'raz_nombre', width: 90,cellsformat: 'center' },
                        { text: 'Puesto', datafield: 'puesto_nombre', width: 90, cellsformat: 'centre'},
                        { text: 'Fecha inicial', datafield: 'con_fecha_inicio', width: 100, cellsformat: 'center'},
                        { text: 'Fecha final', datafield: 'con_fecha_fin',width: 100,cellsalign: 'center'},
                        { text: 'Status', datafield: 'con_status',width: 70,cellsalign: 'center'}
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