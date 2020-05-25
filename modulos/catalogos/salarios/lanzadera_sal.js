window.onload=lanzadera;
function lanzadera (){
  document.oncontextmenu = function() { return false; };
  genera(); 
}
function input(id){
    document.getElementById('id').innerHTML = '<input>';
    return false;
}

function autoriza_sal(url){
    //alert('hola');
    var sl = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    if(sl != 0){
        if(confirm('¿Desea autoizar el registro '+sl+'?')){
            $.ajax({
                type:"POST",
                url:url,
                data:{sal:btoa(sl)},
                success: function(data){
                alert(data);    //success: function(datos){ $(\'#tabla\').html(datos); }
                genera();
                }
            });
        }
    }else{
        alert('Seleccione el salario a autorizar');
    }
}

function popup(url,estid,op) {
        popupWindow = window.open(
	url+'?em='+estid+'&op='+op,'aslr'+op,'height=200px,width=740px,left=200,top=200, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}

function edita(url,estid,op){
    var sl = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    //alert(sl);
    if(sl != 0){
        if(confirm('¿Desea editar los datos del salario '+sl+'?')){
            popupWindow = window.open(
            url+'?em='+estid+'&op='+op+'&sl='+btoa(sl),'aslr'+btoa(sl),'height=200px,width=740px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
        }
    }else{
        alert('Seleccione el salario a editar');
    }
}

function eliminar_r(url) {
    //alert('hola');
    var sal = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    if(sal != 0){
        if(confirm('¿Desea eliminar el salario '+sal+'?')){
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
        alert('Seleccione el salario que desea eliminar');
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
                        { name: 'sal_id'},
                        { name: 'sal_nombre'},
                        { name: 'sal_descripcion'},
                        { name: 'plaza_nombre'},
                        { name: 'suc_nombre'},
                        { name: 'sal_monto'},
                        { name: 'sal_tipo'},
                        { name: 'us_login'},
                        { name: 'sal_activo'}
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
                      { text: 'Registro', datafield: 'sal_id',width: 80,cellsalign: 'center'},
                      { text: 'Nombre', datafield: 'sal_nombre',width: 110,cellsalign: 'center'},
                      { text: 'Descripcion', datafield: 'sal_descripcion',width: 220,cellsalign: 'center'},
                      { text: 'Plaza', datafield: 'plaza_nombre', width: 110,cellsformat: 'center'},
                      { text: 'Sucursal', datafield: 'suc_nombre', width: 110,cellsformat: 'center'},
                      { text: 'Monto', datafield: 'sal_monto',width: 110,cellsalign: 'center'},
                      { text: 'Tipo', datafield: 'sal_tipo', width: 110,cellsformat: 'center'},
                      { text: 'Autorizado', datafield: 'us_login', width: 90,cellsformat: 'center'},
                      { text: 'Status', datafield: 'sal_activo',width: 50,cellsalign: 'center'}
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
                        { name: 'sal_id'},
                        { name: 'sal_nombre'},
                        { name: 'sal_descripcion'},
                        { name: 'plaza_nombre'},
                        { name: 'suc_nombre'},
                        { name: 'sal_monto'},
                        { name: 'sal_tipo'},
                        { name: 'us_login'},
                        { name: 'sal_activo'}
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
                      { text: 'Registro', datafield: 'sal_id',width: 80,cellsalign: 'center'},
                      { text: 'Nombre', datafield: 'sal_nombre',width: 110,cellsalign: 'center'},
                      { text: 'Descripcion', datafield: 'sal_descripcion',width: 220,cellsalign: 'center'},
                      { text: 'Plaza', datafield: 'plaza_nombre', width: 110,cellsformat: 'center'},
                      { text: 'Sucursal', datafield: 'suc_nombre', width: 110,cellsformat: 'center'},
                      { text: 'Monto', datafield: 'sal_monto',width: 110,cellsalign: 'center'},
                      { text: 'Tipo', datafield: 'sal_tipo', width: 110,cellsformat: 'center'},
                      { text: 'Autorizado', datafield: 'us_login', width: 90,cellsformat: 'center'},
                      { text: 'Status', datafield: 'sal_activo',width: 50,cellsalign: 'center'}
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