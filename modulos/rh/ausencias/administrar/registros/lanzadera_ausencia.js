window.onload=lanzadera;
    function lanzadera (){
    document.oncontextmenu = function() { return false; };
}

function valida_campos(op){
    if (document.form_aus.tipo_aus.value=="1000"){
        alert("Debes seleccionar un tipo de ausencia");
        document.form_aus.tipo_aus.focus();
        return 0;
    }
    
    if (document.form_aus.finicio.value.length === 0){
        alert("Debes seleccionar una fecha de inicio");
        document.form_aus.finicio.focus();
        return 0;
    }
    
    if (document.form_aus.ffin.value.length === 0){
        alert("Debes seleccionar una fecha fin");
        document.form_aus.ffin.focus();
        return 0;
    }
    
    if (document.form_aus.obs.value.length === 0){
        alert("Capture observaciones para el registro de ausencia");
        document.form_aus.obs.focus();
        return 0;
    }
    
    if (document.form_aus.tipo_aus.value=="2"){
        if(document.form_aus.vac.value.length==0){
            alert("Debes capturar los dias para vacaciones");
            document.form_aus.vac.focus();
            return 0;
        }
    }else{
        if(document.form_aus.diasa.value.length==0){
            alert("Debes capturar los dias para vacaciones");
            document.form_aus.diasa.focus();
            return 0;
        }
    }
    
    var f1 = document.getElementById("finicio").value;
    var f2 = document.getElementById("ffin").value;
    var nf1 = f1.replace(/-/g,'');
    var nf2 = f2.replace(/-/g,'');
    //alert(nf1+'-'+nf2);
    
    if (nf2 < nf1){
        alert("La fecha fin no puede ser menor a la inicial");
        document.getElementById("ffin").value='';
        document.form_aus.ffin.focus();
        return 0;
    }
    
    var btn = document.getElementById("forward");
    btn.disabled=true;   
    document.form_aus.submit();    
}

function bloquea_opciones(){
    var aus = document.getElementById("tipo_aus").value;
    
    if(aus == 2){
        //alert(aus);
        document.getElementById("vac").readOnly = false;
        document.getElementById("diasa").readOnly = true;
    }else{
        document.getElementById("vac").readOnly = true;
        document.getElementById("diasa").readOnly = false;
    }
}

function valida_vacaciones(vac){
    //alert(vac);
    var disp = document.getElementById("disp").value;
    if(vac > disp){
        alert('Las vacaciones solicitadas es mayor al disponible');
        document.getElementById("vac").value='';
        return 0;
    }
    if(vac <= disp){
        var rest = parseInt(disp) - parseInt(vac);
        document.getElementById("rest").value=rest;
    }
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
