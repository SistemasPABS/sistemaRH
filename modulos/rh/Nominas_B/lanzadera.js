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
	url+'?em='+estid+'&op='+op,'aprs'+op,'height=780px,width=1024px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}

function edita(url,estid,op){
   var prs = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
   //alert(prs);
    if(prs != 0){
        if(confirm('¿Desea editar los datos del registro '+prs+'?')){
            popupWindow = window.open(
            url+'?em='+estid+'&op='+op+'&prs='+btoa(prs),'aprs'+btoa(prs),'height=780px,width=1024px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
        }
    }else{
        alert('Seleccione persona para editar');
    }
}

function eliminar_r(url) {
    //alert('hola');
    var prs = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    if(prs != 0){
        if(confirm('¿Desea eliminar los datos del registro '+prs+'?')){
            $.ajax({
                type:"POST",
                url:url,
                data:{prs:btoa(prs)},
                success: function(data){
                alert("Registro eliminado con exito");    //success: function(datos){ $(\'#tabla\').html(datos); }
                }
            });
            genera();
        }
    }else{
        alert('Seleccione el registro que desea eliminar');
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
    var est = document.getElementById("buscaopcion").value;
    if(est == 'est'){
        document.getEementById(posicion).innerHTML = ('<select id="busca" name="busca" class="selectbuscar" > <option value="1"> Activo </option> <option value="0"> Inactivo </option> </select>');
        return false;
    }else{
        document.getElementById(posicion).innerHTML = ('<input type="text" id="busca" name="busca" class="campobuscar" >');
        return false;
    }
}

function genera() { 
        var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'nomina_id'},
                        { name: 'no_nomina'},
                        { name: 'plaza_nombre'},
                        { name: 'area'},
                        { name: 'nombre_u'},
                        { name: 'observaciones'},
                        { name: 'xp_id'}
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
                      { text: 'Registro', datafield:'nomina_id',width: 100,cellsalign: 'center'},
                      { text: 'No Nomina', datafield: 'no_nomina',width: 100,cellsalign: 'center'},
                      { text: 'Plaza', datafield: 'plaza_nombre', width: 200,cellsformat: 'D' },
                      { text: 'Area', datafield: 'area', width: 200,cellsformat: 'D' },
                      { text: 'Usuario', datafield: 'nombre_u',width:200,cellsformat: 'D'},
                      { text: 'Observaciones', datafield: 'observaciones',width:100,cellsformat: 'D'},
                      { text: 'XP', datafield:'xp_id',width:90,cellsformat: 'D'}
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
                        { name: 'nomina_id'},
                        { name: 'no_nomina'},
                        { name: 'plaza_nombre'},
                        { name: 'area'},
                        { name: 'nombre_u'},
                        { name: 'observaciones'},
                        { name: 'xp_id'}
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
                      { text: 'Registro', datafield:'nomina_id',width: 100,cellsalign: 'center'},
                      { text: 'No Nomina', datafield: 'no_nomina',width: 100,cellsalign: 'center'},
                      { text: 'Plaza', datafield: 'plaza_nombre', width: 200,cellsformat: 'D' },
                      { text: 'Area', datafield: 'area', width: 200,cellsformat: 'D' },
                      { text: 'Usuario', datafield: 'nombre_u',width:200,cellsformat: 'D'},
                      { text: 'Observaciones', datafield: 'observaciones',width:100,cellsformat: 'D'},
                      { text: 'XP', datafield:'xp_id',width:90,cellsformat: 'D'}
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


