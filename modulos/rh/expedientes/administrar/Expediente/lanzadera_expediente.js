window.onload=lanzadera;
    function lanzadera (){
    document.oncontextmenu = function() { return false; };
}

function valida_campos(op){
    if (op == 'editar' ) {
        if (document.form_expediente.registro.value.length === 0){
            alert("Error de registro");
            document.form_expediente.desc.focus();
            return 0;
        }
    } 
    
    if (document.form_expediente.desc.value.length === 0){
        alert("El expediente debe de tener una descripcion");
        document.form_expediente.desc.focus();
        return 0;
    }
    if (document.form_expediente.doc.value.length === 0){
        alert("Debes de seleccionar un archivo");
        document.form_expediente.doc.focus();
        return 0;
    }
    if (document.form_expediente.tipo_exp.value=="1000"){
        alert("Debes seleccionar un tipo de expediente");
        document.form_expediente.tipo_exp.focus();
        return 0;
    }
    
           
    document.form_expediente.submit();    
}

function solo_letras(e){
       
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras="AaBbCcDdEeFGgHhIiFfJjKkLlMmNnÑñOoPpQqRrSsTtUuVvWwXxYyZz.,";
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
