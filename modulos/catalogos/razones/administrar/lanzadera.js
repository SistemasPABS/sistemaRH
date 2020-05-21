window.onload=lanzadera;
function lanzadera (){
  document.oncontextmenu = function() { return false; };
}
function valida_campos(op){
      
    if (document.form_razones.nombre.value.length === 0){
    alert("La razon social no puede ir en blanco");
    document.form_razones.nombre.focus();
    return 0;
    }
    if (document.form_razones.representante.value.length === 0){
    alert("El representante legal no puede ir en blanco");
    document.form_razones.representante.focus();
    return 0;
    }
    if (document.form_razones.direccion.value.length === 0){
    alert("La direccion no puede ir en blanco");
    document.form_razones.direccion.focus();
    return 0;
    }
        
    document.form_razones.submit();    
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

function solo_letras_numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras="AaBbCcDdEeFGgHhIiFfJjKkLlMmNnÑñOoPpQqRrSsTtUuVvWwXxYyZz0123456789.,";
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