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
	url+'?em='+estid+'&op='+op,'aplz'+op,'height=350px,width=500px,left=200,top=200, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}

function edita(url,estid,op){
    var plz = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    //alert(plz);
    if(plz != 0){
        if(confirm('¿Desea editar los datos del registro '+plz+'?')){
            popupWindow = window.open(
            url+'?em='+estid+'&op='+op+'&plz='+btoa(plz),'aplz'+btoa(plz),'height=350px,width=500px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
        }
    }else{
        alert('Seleccione plaza para editar');
    }
}

function eliminar_r(url) {
    //alert('hola');
    var plz = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    if(plz != 0){
        if(confirm('¿Desea eliminar la plaza '+plz+'?')){
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
        alert('Seleccione la plaza que desea eliminar');
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
                        { name: 'plaza_id'},
                        { name: 'plaza_nombre'},
                        { name: 'plaza_activo'}
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
                      { text: 'ID', datafield: 'plaza_id',width: 150,cellsalign: 'center'},
                      { text: 'Nombre', datafield: 'plaza_nombre',width: 500,cellsalign: 'center'},
                      { text: 'Status', datafield: 'plaza_activo', width: 340,cellsformat: 'center' },
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
                        { name: 'plaza_id'},
                        { name: 'plaza_nombre'},
                        { name: 'plaza_activo'}
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
                      { text: 'ID', datafield: 'plaza_id',width: 150,cellsalign: 'center'},
                      { text: 'Nombre', datafield: 'plaza_nombre',width: 500,cellsalign: 'center'},
                      { text: 'Status', datafield: 'plaza_activo', width: 340,cellsformat: 'center' },
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