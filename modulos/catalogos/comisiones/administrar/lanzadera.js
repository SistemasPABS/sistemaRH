window.onload=lanzadera;
function lanzadera (){
  document.oncontextmenu = function() { return false; };
}
function ver_sucursales(){
//    alert('hola');
    var a = document.form_com.plazas.value;
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
        alert("El porcentaje no puede ir en blanco");
        document.form_com.comision.focus();
        return 0;
    }
    if (document.form_com.plazas.value=="1000"){
        alert("Debes de seleccionar una plaza");
        document.form_com.plazas.focus();
        return 0;
    }
    if (document.form_com.sucursales.value=="1000"){
        alert("Debes de seleccionar una sucursal");
        document.form_com.sucursal.focus();
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