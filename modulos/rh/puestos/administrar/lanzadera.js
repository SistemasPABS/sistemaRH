window.onload=lanzadera;
function lanzadera (){
  document.oncontextmenu = function() { return false; };
  
}

function valida_nueva_clave(clave){
    //alert(clave);
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

function ver_sucursales(){
    //alert('hola');
    var a = document.form_puesto.plazas.value;
    var a = btoa(a);
    var est = btoa('suc');
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

function ver_sucursales2(){
//    alert('hola');
    var a = document.form_puesto.plazas2.value;
    var a = btoa(a);
    var est = btoa('suc2');
    //alert("valores "+a+" "+est);
    var url="agrega_selects.php";
         $.ajax({
            type: "POST",
            url:url,
            data:{ns:a,op:est},
            success: function(data){
            //alert(data);
            document.getElementById("cont_se2").innerHTML=data;
            }
          });
}

function ver_salarios(){
    //alert('hola');
    var a = document.form_puesto.sucursales.value;
    var a = btoa(a);
    var sal = btoa('sal');
    //alert("Navegador autorizado "+a+" "+b);
    var url="agrega_selects.php";
         $.ajax({
            type: "POST",
            url:url,
            data:{ns:a,op:sal},
            success: function(data){
            //alert(data);    
            document.getElementById("cont_sl").innerHTML=data;
            }
          });
}

function ver_jefes(){
    //alert('hola');
    var a = document.form_puesto.sucursales2.value;
    var a = btoa(a);
    var jefe = btoa('jefe');
    //alert("Navegador autorizado "+a+" "+b);
    var url="agrega_selects.php";
         $.ajax({
            type: "POST",
            url:url,
            data:{ns:a,op:jefe},
            success: function(data){
            //alert(data);    
            document.getElementById("cont_jf").innerHTML=data;
            }
          });
}

function ver_comisiones(){
    //alert('hola');
    var a = document.form_puesto.sucursales.value;
    var a = btoa(a);
    var coms = btoa('coms');
    //alert("Navegador autorizado "+a+" "+b);
    var url="agrega_selects.php";
         $.ajax({
            type: "POST",
            url:url,
            data:{ns:a,op:coms},
            success: function(data){
            //alert(data);    
            document.getElementById("cont_coms").innerHTML=data;
            }
          });
}

function valida_campos(op){
    
    if (document.form_puesto.clave.value.length === 0){
        alert("La clave no puede ir en blanco");
        document.form_puesto.clave.focus();
        return 0;
    }
    if (document.form_puesto.nombre.value.length === 0){
        alert("El puesto debe llevar un nombre");
        document.form_puesto.nombre.focus();
        return 0;
    }
    if (document.form_puesto.plazas.value=="1000"){
        alert("Debes de seleccionar una plaza");
        document.form_puesto.plazas.focus();
        return 0;
    }
    if (document.form_puesto.sucursales.value=="1000"){
        alert("Debes de seleccionar una sucursal");
        document.form_puesto.sucursales.focus();
        return 0;
    }
    if (document.form_puesto.salarios.value=="1000"){
        alert("Debes de seleccionar una salario");
        document.form_puesto.salarios.focus();
        return 0;
    }
    if (document.form_puesto.jefes.value=="1000"){
        alert("Debes de seleccionar el puesto del jefe");
        document.form_puesto.jefes.focus();
        return 0;
    }
    if (document.getElementById("descripcion").value==""){
        alert("Debes incluir una descripcion del puesto");
        document.form_puesto.descripcion.focus();
        return 0;
    }
        
   document.form_puesto.submit();    
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

function myFunction() {
  var valor=document.form_puesto.comisiones.value;
  var select=document.form_puesto.comisiones;
  var texto = select.options[select.selectedIndex].text;
  var node = document.createElement("LI");
  var input = document.createElement("input");
  var textnode = document.createTextNode(texto);
  var boton = document.createElement("button");
  input.name="com[]";
  input.value=valor;
  input.hidden="yes";
  boton.innerHTML = "eliminar";
  node.appendChild(input);
  node.appendChild(textnode);
  node.appendChild(boton);
  document.getElementById("myList").appendChild(node);

  boton.onclick = function() {
    var li = this.parentNode;
    li.parentNode.removeChild(li);
  }
}

function eliminar(elemento){
    var li = elemento.parentNode;
    li.parentNode.removeChild(li);
}