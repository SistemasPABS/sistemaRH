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
    var aus = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    var prs = document.getElementById("registro").value;
    //alert('persona: '+prs+' exp: '+exp);
    if(aus != 0){
        if(confirm('¿Desea editar los datos del registro '+aus+'?')){
            var url2 ='registros/valida_edicion.php';
            $.ajax({
                type:"POST",
                url:url2,
                data:{aus:btoa(aus)},
                success: function(data){
                //alert(data);    //success: function(datos){ $(\'#tabla\').html(datos); }
                    if(data == 0){
                        //alert('Puede editarla');
                        popupWindow = window.open(
                        url+'?em='+estid+'&op='+op+'&exp='+btoa(aus)+'&prs='+btoa(prs),'aexp'+btoa(aus),'height=780px,width=1024px,left=0,top=0, ,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
                    }else{
                        alert('La ausencia ya ha sido autorizada y no puede editarla');
                    }
                }
            });
            
        }
    }else{
        alert('Seleccione ausencia para editar');
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

function autoriza_aus(url){
    var aus = document.getElementsByClassName("jqx-fill-state-pressed")[0].textContent;
    //alert(aus);

    if(aus != 0){
        if(confirm('¿Desea autoizar el registro '+aus+'?')){
            $.ajax({
                type:"POST",
                url:url,
                data:{aus:btoa(aus)},
                success: function(data){
                alert(data);    //success: function(datos){ $(\'#tabla\').html(datos); }
                genera();
                }
            });
        }
    }else{
        alert('Seleccione la ausencia que desea autorizar');
    }
}

function genera() {
        var dato3 = document.opbusqueda2.registro.value;        //valor registro
        
        var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'aus_id'},
                        { name: 'ta_nombre'},
                        { name: 'aus_vac_years'},
                        { name: 'aus_correspondientes'},
                        { name: 'aus_tomados'},
                        { name: 'aus_disponibles'},
                        { name: 'aus_dias_vac'},
                        { name: 'aus_restantes'},
                        { name: 'aus_dias'},
                        { name: 'aus_fecha_inicio'},
                        { name: 'aus_fecha_fin'},
                        { name: 'aus_observaciones'},
                        { name: 'aus_autorizado_login'}
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
                      { text: 'Registro', datafield: 'aus_id',width: 60,cellsalign: 'center'},
                      { text: 'Tipo ausencia', datafield: 'ta_nombre',width: 100,cellsalign: 'center'},
                      { text: 'Años', datafield: 'aus_vac_years', width: 70,cellsformat: 'D' },
                      { text: 'Correspondientes', datafield: 'aus_correspondientes', width: 100,cellsformat: 'D' },
                      { text: 'Tomados', datafield: 'aus_tomados',width:80,cellsformat: 'D'},
                      { text: 'Disponibles', datafield: 'aus_disponibles',width:80,cellsformat: 'D'},
                      { text: 'Vacaciones', datafield: 'aus_dias_vac',width:80,cellsformat: 'D'},
                      { text: 'Restantes', datafield: 'aus_restantes',width:80,cellsformat: 'D'},
                      { text: 'Ausencias(dias)', datafield: 'aus_dias',width:90,cellsformat: 'D'},
                      { text: 'Fecha inicio', datafield: 'aus_fecha_inicio',width:100,cellsformat: 'D'},
                      { text: 'Fecha fin', datafield: 'aus_fecha_fin', width:100,cellsalign: 'center' },
                      { text: 'Observaciones', datafield: 'aus_observaciones', width:200,cellsalign: 'center' },
                      { text: 'Autorizado', datafield: 'aus_autorizado_login', width:80,cellsalign: 'center' }
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
                       { name: 'aus_id'},
                        { name: 'ta_nombre'},
                        { name: 'aus_vac_years'},
                        { name: 'aus_correspondientes'},
                        { name: 'aus_tomados'},
                        { name: 'aus_disponibles'},
                        { name: 'aus_dias_vac'},
                        { name: 'aus_restantes'},
                        { name: 'aus_dias'},
                        { name: 'aus_fecha_inicio'},
                        { name: 'aus_fecha_fin'},
                        { name: 'aus_observaciones'},
                        { name: 'aus_autorizado_login'}
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
                      { text: 'Registro', datafield: 'aus_id',width: 60,cellsalign: 'center'},
                      { text: 'Tipo ausencia', datafield: 'ta_nombre',width: 100,cellsalign: 'center'},
                      { text: 'Años', datafield: 'aus_vac_years', width: 70,cellsformat: 'D' },
                      { text: 'Correspondientes', datafield: 'aus_correspondientes', width: 100,cellsformat: 'D' },
                      { text: 'Tomados', datafield: 'aus_tomados',width:80,cellsformat: 'D'},
                      { text: 'Disponibles', datafield: 'aus_disponibles',width:80,cellsformat: 'D'},
                      { text: 'Vacaciones', datafield: 'aus_dias_vac',width:80,cellsformat: 'D'},
                      { text: 'Restantes', datafield: 'aus_restantes',width:80,cellsformat: 'D'},
                      { text: 'Ausencias(dias)', datafield: 'aus_dias',width:90,cellsformat: 'D'},
                      { text: 'Fecha inicio', datafield: 'aus_fecha_inicio',width:100,cellsformat: 'D'},
                      { text: 'Fecha fin', datafield: 'aus_fecha_fin', width:100,cellsalign: 'center' },
                      { text: 'Observaciones', datafield: 'aus_observaciones', width:200,cellsalign: 'center'},
                      { text: 'Autorizado', datafield: 'aus_autorizado_login', width:80,cellsalign: 'center'}
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