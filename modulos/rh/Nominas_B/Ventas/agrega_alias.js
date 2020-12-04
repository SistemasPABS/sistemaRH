window.onload=agrega_alias;

function agrega_alias() {
    
    autocompletable();
  
}

function autocompletable(){
    //Variables de opciones para el autocompletado de los imputs
    var persona = btoa('per');
        //Ajax de autocompletar 
    $( "#nombre" ).autocomplete({
        source: function( request,response ) {
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
            $('#clave').val(ui.item.clave);
            
          return false;
        }
    });
 }