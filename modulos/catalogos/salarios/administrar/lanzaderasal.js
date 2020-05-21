window.onload=lanzadera;
function lanzadera (){
  document.oncontextmenu = function() { return false; };
}

function ver_sucursales(){
//    alert('hola');
    var a = document.form_sal.plazas.value;
    var a = btoa(a);
    var est = btoa('est');
    //alert("valores "+a+" "+est);
    var url="agrega_selects.php";
         $.ajax({
            type: "POST",
            url:url,
            data:{ns:a,op:est},
            success: function(data){
            //alert(data);    
            document.getElementById("cont_se").innerHTML=data;
            }
          });
}

function valida_campos(op){
    //alert('hola');
    
    if(op == 'nuevo'){
        if (document.getElementById("estatus").checked ===false){
            alert("El nuevo registro debe estar activo");
            document.form_sal.estatus.focus();
            return 0;
        }
    }
    if (document.form_sal.nombre.value.length === 0){
        alert("La descripcion no puede ir en blanco");
        document.form_sal.desc.focus();
        return 0;
    }
    if (document.form_sal.desc.value.length === 0){
        alert("La descripcion no puede ir en blanco");
        document.form_sal.desc.focus();
        return 0;
    }
    if (document.form_sal.monto.value.length === 0){
        alert("El monto no puede ir en blanco");
        document.form_sal.monto.focus();
        return 0;
    }
    if (document.form_sal.tipo_sal.value=="1000"){
        alert("Debes de seleccionar una plaza");
        document.form_sal.tipo_sal.focus();
        return 0;
    }
    if (document.form_sal.plazas.value=="1000"){
        alert("Debes de seleccionar una plaza");
        document.form_com.plazas.focus();
        return 0;
    }
    if (document.form_sal.sucursales.value=="1000"){
        alert("Debes de seleccionar una sucursal");
        document.form_sal.sucursal.focus();
        return 0;
    }
       
    document.form_sal.submit();    
}
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