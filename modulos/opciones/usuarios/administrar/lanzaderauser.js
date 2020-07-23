window["pestañas"] = {
	on	: "on",
	off	: "off",
	items	:["general", "permisos"]
};

window.onload = function() {
	mostrarPestaña(pestañas, tag("_general"));
        arbolpermisos();
       
};

function ver_sucursales(){
    //alert('hola');
    var a = document.nuevouser.plazas.value;
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

function estado(){ 
    if (document.nuevouser.usadmin.checked) {
            var el = document.getElementById('ocontroles'); //se define la variable "el" igual a nuestro div
            el.style.display = 'block'; //damos un atributo display:none que oculta el div
    }else{
            var el = document.getElementById('ocontroles'); //se define la variable "el" igual a nuestro div
            el.style.display = 'none'; //damos un atributo display:none que oculta el div
    }
}

/*Alias para document.getElementById*/
function tag(id){return document.getElementById(id);}

window["mostrarPestaña"] = function(sistema,cual)	{
	soy = cual.id;
	contenido = soy.substr(1);
	for (var i = 0, total = sistema.items.length; i < total; i ++)
		tag(sistema.items[i]).style.display = (sistema.items[i] == contenido) ? "block" : "none";
	for (i = 0, todos = sistema.items, total = todos.length; i < total; i ++)
		tag("p" + todos[i]).className = "pestaña " +  sistema.off;
	tag("p" + contenido).className = "pestaña " + sistema.on;
};

function valida_nuevouser(){
                    document.getElementById("asignarempleado").value='';
                    if (document.nuevouser.usnombre.value.length===0){
                    alert("Ingrese el nombre del usuario");
                    document.nuevouser.usnombre.focus();
                    return 0;
                    }
                    if (document.nuevouser.uspaterno.value.length===0){
                    alert("Ingrese el apellido paterno");
                    document.nuevouser.uspaterno.focus();
                    return 0;
                    }
                    if (document.nuevouser.usmaterno.value.length===0){
                    alert("Ingrese el apellido materno");
                    document.nuevouser.usmaterno.focus();
                    return 0;
                    }
                    if (document.nuevouser.uspassword.value.length===0){
                    alert("La contraseña no puede estar en blanco");
                    document.nuevouser.uspassword.focus();
                    return 0;
                    }
                    if (document.nuevouser.usemail.value.length===0){
                    alert("Ingrese un correo electronico");
                    document.nuevouser.usemail.focus();
                    return 0;
                    }
                    if (document.nuevouser.ustelefono.value.length===0){
                    alert("Ingrese un numero telefonico");
                    document.nuevouser.ustelefono.focus();
                    return 0;
                    }
                    if (document.nuevouser.uslogin.value.length===0){
                    alert("Ingrese un Login");
                    document.nuevouser.uslogin.focus();
                    return 0;
                    };
                    if (document.nuevouser.usfechacaducidad.value.length===0){
                    alert("Indique la fecha de caducidad");
                    document.nuevouser.usfechacaducidad.focus();
                    return 0;
                    };
                document.nuevouser.submit();
                };
                
function sololetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
};                
                
function solonumeros(e){
     var key = window.Event ? e.which : e.keyCode;
     return (key <= 13 || (key >= 48 && key <= 57));
};

function nuevoAjax(){ 
    var xmlhttp=false; 
    try 
    { 
        xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
    }
    catch(e)
    { 
        try
        { 
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
        } 
        catch(E) { xmlhttp=false; }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

    return xmlhttp; 
} 

function asigna(e,dir){
    var key = window.Event ? e.which : e.keyCode;
    if(key = 9){
     usuario(dir);
    /*document.getElementById('usnombre').value = document.getElementById('uslogin').value;*/
}
}

function marcar(obj,chk) {
	elem=obj.getElementsByTagName('input');
  for(i=0;i<elem.length;i++)
  	elem[i].checked=chk.checked;
}

function myFunction() {
    //alert('hola');
  var flg='myList';
  var plz = document.getElementById("plazas");
  var suc = document.getElementById("sucursales");
  var tplz = plz.options[plz.selectedIndex].text;
  var tsuc = suc.options[suc.selectedIndex].text;
  var vplz = plz.value;
  var vsuc = suc.value;
  alert(vplz+','+vsuc+'--'+tplz+'/'+tsuc);
  
//  document.getElementById(flg).appendChild(node);
//  
//  boton.onclick = function() {
//    var li = this.parentNode;
//    li.parentNode.removeChild(li);
//  }
}

function eliminar(elemento){
    var li = elemento.parentNode;
    li.parentNode.removeChild(li);
}
 



