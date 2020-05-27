window.onload=lanzadera;
//Funcion al abrir la ventana
function lanzadera (){
  document.oncontextmenu = function() { return false; };
  autocompletable();
}
//Autocompletado y busqueda de coincidencia de resultados
function autocompletable(){
    //Variables de opciones para el autocompletado de los imputs
    var persona = btoa('per');
    var contrato = btoa('cont');
    var puesto = btoa('pues');
    var razon = btoa('raz');
    var salario = btoa('sal');
    //Ajax de autocompletar 
    $( "#nombre" ).autocomplete({
        source: function( request, response ) {
                
            $.ajax({
                url: "fetchDatos.php",
                type: 'post',
                dataType: "json",
                data: {
                    op:persona,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },//Al seleccionar un valor rrellena el resto de campos con los resultados del query
        select: function (event, ui) {
            $('#nombre').val(ui.item.label); 
            $('#id_persona').val(ui.item.value);
            $('#direccion').val(ui.item.dir);
            $('#genero').val(ui.item.genero);
            $('#rfc').val(ui.item.rfc);
            $('#curp').val(ui.item.curp);
            $('#nss').val(ui.item.nss);
            $('#nac').val(ui.item.nac);
            return false;
        }
    });//Input contrato
    $( "#contrato" ).autocomplete({
        source: function( request, response ) {
                
            $.ajax({
                url: "fetchDatos.php",
                type: 'post',
                dataType: "json",
                data: {
                    op:contrato,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('#contrato').val(ui.item.label); // display the selected text
            $('#id_contrato').val(ui.item.value); // save selected id to input
            return false;
        }
    });//Input Puesto
    $( "#puesto" ).autocomplete({
        source: function( request, response ) {
                
            $.ajax({
                url: "fetchDatos.php",
                type: 'post',
                dataType: "json",
                data: {
                    op:puesto,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('#puesto').val(ui.item.label); // display the selected text
            $('#id_puesto').val(ui.item.value); // save selected id to input
            $('#plaza').val(ui.item.plaza);
            return false;
        }
    });//Input Razon social
    $( "#razon" ).autocomplete({
        source: function( request, response ) {
                
            $.ajax({
                url: "fetchDatos.php",
                type: 'post',
                dataType: "json",
                data: {
                    op:razon,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('#razon').val(ui.item.label); // display the selected text
            $('#id_razon').val(ui.item.value); // save selected id to input
            return false;
        }
    });//Input salario
    $( "#salario" ).autocomplete({
        source: function( request, response ) {
                
            $.ajax({
                url: "fetchDatos.php",
                type: 'post',
                dataType: "json",
                data: {
                    op:salario,
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('#salario').val(ui.item.label); // display the selected text
            $('#id_salario').val(ui.item.value); // save selected id to input
            $('#pago').val(ui.item.pago); // save selected id to input
            return false;
        }
    });
 }
 //Valida campos antes de mandar el formulario
function valida_campos(op){
       //Nombre persona
    if (document.form_contrato.nombre.value.length === 0){
        alert("El nombre no puede ir en blanco");
        document.form_contrato.clave.focus();
        return 0;
    }//id persona
    if (document.form_contrato.id_persona.value.length === 0){
        alert("Nombre no valido");
        document.form_contrato.id_persona.focus();
        return 0;
    }//Nombre Contrato
    if (document.form_contrato.contrato.value.length === 0){
        alert("Debes seleccionar un contrato");
        document.form_contrato.contrato.focus();
        return 0;
    }//Contrato
    if (document.form_contrato.puesto.value.length === 0){
        alert("Debes seleccionar un puesto");
        document.form_contrato.puesto.focus();
        return 0;
    }//razon Social
    if (document.form_contrato.razon.value.length === 0){
        alert("Debes seleccionar una razon social");
        document.form_contrato.razon.focus();
        return 0;
    }//Salario
    if (document.form_contrato.salario.value.length === 0){
        alert("Debes seleccionar un salario");
        document.form_contrato.salario.focus();
        return 0;
    }//Horario
    if (document.form_contrato.horario.value.length === 0){
        alert("El contrato debe de tener un horario");
        document.form_contrato.horario.focus();
        return 0;
    }//Periodo de prueba
    if (document.form_contrato.prueba.value.length === 0){
        alert("Debes seleccionar un periodo de prueba");
        document.form_contrato.prueba.focus();
        return 0;
    }//Fecha Inicial
    if (document.form_contrato.fecha_ini.value.length === 0){
        alert("Debes seleccionar una fecha de inicio");
        document.form_contrato.fecha_ini.focus();
        return 0;
    }//Estatus
    if(op=='nuevo'){
        if (document.getElementById("status").checked==false){
        alert("El nuevo contrato debe estar activo");
        document.form_contrato.status.focus();
        return 0;
        }
    }
    //Envia el action del formulario
   document.form_contrato.submit();    
}
//Valida que el campo contenga solo letras
function solo_letras(e){
       
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras="AaBbCcDdEeFGgHhIiFfJjKkLlMmNnÑñOoPpQqRrSsTtUuVvWwXxYyZz";
    especiales=[8,13, 32];
    
    tecla_especial=false;
    for(var i in especiales){
        if(key == especiales[i]){
            tecla_especial=true;
            break;
        }
    }
    if(letras.indexOf(tecla) == -1 && !tecla_especial){
       // alert("El campo solo acepta Letras");
        return false;
    }
}
//Valida que el campo tenga solo numeros y letras
function solo_letras_numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras="AaBbCcDdEeFGgHhIiFfJjKkLlMmNnÑñOoPpQqRrSsTtUuVvWwXxYyZz0123456789";
    especiales=[8,13, 32];
    
    tecla_especial=false;
    for(var i in especiales){
        if(key == especiales[i]){
            tecla_especial=true;
            break;
        }
    }
    if(letras.indexOf(tecla) == -1 && !tecla_especial){
        //alert("El campo solo acepta Letras y numeros");
        return false;
    }
}
//Valoida que el campo solo tenga numeros
function solo_numeros(evt){
    if(window.event){
        keynum = evt.keyCode;
    }else{
        keynum = evt.which;
    }
    if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13){
        return true;
    }
    else{
      //  alert("El campo solo acepta numeros");
        return false;
    }
}