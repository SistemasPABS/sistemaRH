window.onload=lanzadera;
function lanzadera (){
  document.oncontextmenu = function() { return false; };
}

function valida_campos(op){
    
    if(op == 'nuevo'){
        if (document.getElementById("estatus").checked ===false){
            alert("El nuevo registro debe estar activo");
            document.form_com.estatus.focus();
            return 0;
        }
    }
    if (document.form_com.nombre.value.length === 0){
        alert("La descripcion no puede ir en blanco");
        document.form_com.nombre.focus();
        return 0;
    }
    if (document.form_com.tipo_com.value=="1000"){
        alert("Debes de seleccionar una Tipo de comision");
        document.form_com.tipo_com.focus();
        return 0;
    }
 
    if (document.form_com.comision.value.length === 0){
        alert("La comision no puede ir en blanco");
        document.form_com.comision.focus();
        return 0;
    }
    if (document.form_com.grupos.value=="1000"){
        alert("Debes de seleccionar un grupo");
        document.form_com.grupos.focus();
        return 0;
    }
    
   
   document.form_com.submit();    
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
    especiales=[8,13,32];
    
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