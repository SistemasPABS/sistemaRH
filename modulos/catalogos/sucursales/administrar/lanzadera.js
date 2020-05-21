window.onload=lanzadera;
function lanzadera (){
  document.oncontextmenu = function() { return false; }; 
}
function valida_campos(op){
    
    
    if(op == 'nuevo'){
        if (document.getElementById("estatus").checked ===false){
            alert("El nuevo registro debe estar activo");
            document.form_suc.status.focus();
            return 0;
        }
    }
     if (document.form_suc.plazas.value=="1000"){
        alert("Debes de seleccionar una plaza");
        document.form_suc.plazas.focus();
        return 0;
    }
    if (document.form_suc.nombre.value.length === 0){
        alert("El nombre no puede ir en blanco");
        document.form_suc.nombre.focus();
        return 0;
    }
    
        
   document.form_suc.submit();    
}
function solo_letras(e){
       
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras="AaBbCcDdEeFGgHhIiFfJjKkLlMmNnÑñOoPpQqRrSsTtUuVvWwXxYyZz";
    especiales=[8,13,32];
    
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