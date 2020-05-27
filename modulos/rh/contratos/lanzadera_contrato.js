window.onload=lanzadera;
function lanzadera (){
  document.oncontextmenu = function() { return false; };
  genera(); 
}

function input(id){
    document.getElementById('id').innerHTML = '<input>';
    return false;
}

//function autoriza_p(url){
//    //alert('hola');
//    var p = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
//    if(p != 0){
//        if(confirm('¿Desea autoizar el registro '+p+'?')){
//            $.ajax({
//                type:"POST",
//                url:url,
//                data:{pue:btoa(p)},
//                success: function(data){
//                alert(data);    //success: function(datos){ $(\'#tabla\').html(datos); }
//                genera();
//                }
//            });
//        }
//    }else{
//        alert('Seleccione el salario a autorizar');
//    }
//}

function popup(url,estid,op) {
        popupWindow = window.open(
	url+'?em='+estid+'&op='+op,'apst'+op,'height=600px,width=850px,left=200,top=200, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}

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
        alert('Seleccione el puesto que desea eliminar');
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
                        { name: 'puesto_id'},
                        { name: 'puesto_cve'},
                        { name: 'puesto_nombre'},
                        { name: 'puesto_descripcion'},
                        { name: 'plaza_nombre'},
                        { name: 'suc_nombre'},
                        { name: 'sal_nombre'},
                        { name: 'puesto_fecha'},
                        { name: 'puesto_hora'},
                        { name: 'us_login'},
                        { name: 'nombre_jefe'}
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
                      { text: 'Registro', datafield: 'puesto_id',width: 60,cellsalign: 'center'},
                      { text: 'Clave', datafield: 'puesto_cve',width: 60,cellsalign: 'center'},
                      { text: 'Nombre', datafield: 'puesto_nombre',width: 100,cellsalign: 'center'},
                      { text: 'Descripcion', datafield: 'puesto_descripcion',width: 170,cellsalign: 'center'},
                      { text: 'Plaza', datafield: 'plaza_nombre', width: 100,cellsformat: 'center' },
                      { text: 'Sucursal', datafield: 'suc_nombre', width: 100, cellsformat: 'centre'},
                      { text: 'Salario', datafield: 'sal_nombre', width: 100, cellsformat: 'center'},
                      { text: 'Fecha', datafield: 'puesto_fecha',width: 100,cellsalign: 'center'},
                      { text: 'Hora', datafield: 'puesto_hora',width: 100,cellsalign: 'center'},
                      { text: 'Autorizado', datafield: 'us_login',width: 100,cellsalign: 'center'},
                      { text: 'Jefe inmediato', datafield: 'nombre_jefe',width: 100,cellsalign: 'center'}
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
                        { name: 'puesto_id'},
                        { name: 'puesto_cve'},
                        { name: 'puesto_nombre'},
                        { name: 'puesto_descripcion'},
                        { name: 'plaza_nombre'},
                        { name: 'suc_nombre'},
                        { name: 'sal_nombre'},
                        { name: 'puesto_fecha'},
                        { name: 'puesto_hora'},
                        { name: 'us_login'},
                        { name: 'nombre_jefe'}
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
                      { text: 'Registro', datafield: 'puesto_id',width: 60,cellsalign: 'center'},
                      { text: 'Clave', datafield: 'puesto_cve',width: 60,cellsalign: 'center'},
                      { text: 'Nombre', datafield: 'puesto_nombre',width: 100,cellsalign: 'center'},
                      { text: 'Descripcion', datafield: 'puesto_descripcion',width: 170,cellsalign: 'center'},
                      { text: 'Plaza', datafield: 'plaza_nombre', width: 100,cellsformat: 'center' },
                      { text: 'Sucursal', datafield: 'suc_nombre', width: 100, cellsformat: 'centre'},
                      { text: 'Salario', datafield: 'sal_nombre', width: 100, cellsformat: 'center'},
                      { text: 'Fecha', datafield: 'puesto_fecha',width: 100,cellsalign: 'center'},
                      { text: 'Hora', datafield: 'puesto_hora',width: 100,cellsalign: 'center'},
                      { text: 'Autorizado', datafield: 'us_login',width: 100,cellsalign: 'center'},
                      { text: 'Jefe inmediato', datafield: 'nombre_jefe',width: 100,cellsalign: 'center'}
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