window.onload=lanzadera;
    function lanzadera (){
    document.oncontextmenu = function() { return false; };
}

function valida_nueva_clave(clave,op){
    //alert(clave);
    if(op == 'clave'){
        var url="valida_nueva_clave.php";
        $.ajax({
            type: "POST",
            url:url,
            data:{cve:btoa(clave)},
            success: function(data){
                if(data.length != 0 ){
                    alert(data); 
                    document.getElementById("clave").value ='';
                }
            }
        });
    }
    if(op == 'nc'){
        var n = document.getElementById("nombre").value;
        var p = document.getElementById("paterno").value;
        var m = document.getElementById("materno").value;
        var nc = n+' '+p+' '+m; 
        //alert(nc);
        var url="valida_nueva_nc.php";
        $.ajax({
            type: "POST",
            url:url,
            data:{nc:btoa(nc)},
            success: function(data){
                if(data.length != 0 ){
                    alert(data); 
                    document.getElementById("nombre").value ='';
                    document.getElementById("paterno").value ='';
                    document.getElementById("materno").value ='';
                }
            }
        });
    }
}

function ver_estados(){
    //alert('hola');
    var a = document.form_personas.pais.value;
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

function ver_municipios(){
    //alert('hola');
    var a = document.form_personas.estados.value;
    var a = btoa(a);
    var mcp = btoa('mcp');
    //alert("Navegador autorizado "+a+" "+b);
    var url="agrega_selects.php";
         $.ajax({
            type: "POST",
            url:url,
            data:{ns:a,op:mcp},
            success: function(data){
            //alert(data);    
            document.getElementById("cont_sm").innerHTML=data;
            }
          });
}

function valida_campos(op){
    //alert(document.getElementById("status").checked);
    if(op=='nuevo'){
        if (document.getElementById("status").checked==false){
        alert("El nuevo registro debe estar activo");
        document.form_personas.status.focus();
        return 0;
        }
    }
    if (document.form_personas.clave.value.length==0){
    alert("El nuevo empleado debe tener una clave");
    document.form_personas.clave.focus();
    return 0;
    }
    if (document.form_personas.nombre.value.length==0){
    alert("El nombre no puede ir en blanco");
    document.form_personas.nombre.focus();
    return 0;
    }
    if (document.form_personas.paterno.value.length==0){
    alert("El apellido paterno no puede ir en blanco");
    document.form_personas.paterno.focus();
    return 0;
    }
    if (document.form_personas.materno.value.length==0){
    alert("El apellido materno no puede ir en blanco");
    document.form_personas.materno.focus();
    return 0;
    }
    if (document.form_personas.rfc.value.length==0){
    alert("El RFC no puede ir en blanco");
    document.form_personas.rfc.focus();
    return 0;
    }
    if (document.form_personas.curp.value.length==0){
    alert("La CURP no puede ir en blanco");
    document.form_personas.curp.focus();
    return 0;
    }
    if (document.form_personas.genero.value=="1000"){
    alert("Debes seleccionar un genero");
    document.form_personas.genero.focus();
    return 0;
    }
    
    if (document.form_personas.calle.value.length==0){
    alert("La calle no puede ir en blanco");
    document.form_personas.calle.focus();
    return 0;
    }
    
    if (document.form_personas.numero.value.length==0){
    alert("El numerono puede ir en blanco");
    document.form_personas.numero.focus();
    return 0;
    }
     if (document.form_personas.colonia.value.length==0){
    alert("La colonia no puede ir en blanco");
    document.form_personas.colonia.focus();
    return 0;
    }
     if (document.form_personas.cp.value.length==0){
    alert("El CP no puede ir en blanco");
    document.form_personas.cp.focus();
    return 0;
    }
    
    if (document.form_personas.fecha_nac.value.length==0){
    alert("Debes seleccionar una fecha de nacimiento");
    document.form_personas.fecha_nac.focus();
    return 0;
    }
    if (document.form_personas.civil.value.length==0){
    alert("Debes colocar un estado civil");
    document.form_personas.civil.focus();
    return 0;
    }
    if (document.form_personas.edad.value.length==0){
    alert("Debes seleccionar una fecha de nacimiento");
    document.form_personas.edad.focus();
    return 0;
    }
    if (document.form_personas.telefono.value.length <10){
    alert("El telefono debe de ser a 10 digitos");
    document.form_personas.telefono.focus();
    return 0;
    }
     if (document.form_personas.celular.value.length<10){
    alert("El numero de celular debe de ser a 10 digitos");
    document.form_personas.celular.focus();
    return 0;
    }
    if (document.form_personas.correo.value.length==0){
    alert("El correo no puede ir en blanco");
    document.form_personas.correo.focus();
    return 0;
    }
    if (document.form_personas.pais.value=="1000"){
    alert("Debes de seleccionar un pais");
    document.form_personas.pais.focus();
    return 0;
    }
    if (document.form_personas.plaza.value=="1000"){
    alert("Debes asignar una plaza de registro");
    document.form_personas.plaza.focus();
    return 0;
    }
    if (document.form_personas.estados.value=="1000"){
    alert("Debes de seleccionar un estado");
    document.form_personas.estados.focus();
    return 0;
    }
    if (document.form_personas.municipios.value=="1000"){
    alert("Debes de seleccionar un municipio");
    document.form_personas.municipios.focus();
    return 0;
    }
    if (document.form_personas.banco.value=="1000"){
    alert("Captura un banco para la nueva persona");
    document.form_personas.banco.focus();
    return 0;
    }
    if (document.form_personas.clavebanco.value.length==0){
    document.form_personas.clavebanco.value="000000000";
    //return 0;
    }
    if (document.form_personas.cuenta.value.length==0){
    document.form_personas.cuenta.value="Sin Cuenta";
    //return 0;
    }
    
    var btn = document.getElementById("forward");
    btn.disabled=true;
    document.form_personas.submit();
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

