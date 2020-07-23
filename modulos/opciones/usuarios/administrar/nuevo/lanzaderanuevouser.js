window["pestañas"] = {
	on	: "on",
	off	: "off",
	items	:["general", "permisos"]
};

window.onload = function() {
	mostrarPestaña(pestañas, tag("_general"));
        arbolpermisos();
       
};

function estado(){ 
    if (document.nuevouser.usadmin.checked) {
            var el = document.getElementById('ocontroles'); //se define la variable "el" igual a nuestro div
            el.style.display = 'block'; //damos un atributo display:none que oculta el div
    }else{
           var el = document.getElementById('ocontroles'); //se define la variable "el" igual a nuestro div
           el.style.display = 'none'; //damos un atributo display:none que oculta el div
    }
}

/*		Alias para document.getElementById	*/
function tag(id)	{return document.getElementById(id);}

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

function usuario(dir) {
    var cod=document.getElementById("uslogin").value;
    var campo1=document.getElementById("usnombre");
    var campo2=document.getElementById("uspaterno");
    var campo3=document.getElementById("usmaterno");
    var campo4=document.getElementById("usemail");
    var campo5=document.getElementById("ustelefono");
        
    var ajax=nuevoAjax();
    ajax.open('POST',dir+'userjarabe.php', true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("var1="+cod);
            
    ajax.onreadystatechange=function()
    {
        if (ajax.readyState==4)
        {
            var respuesta=ajax.responseXML;
            campo1.value=respuesta.getElementsByTagName("us_nombre")[0].childNodes[0].data;
            campo2.value=respuesta.getElementsByTagName("us_apellidopaterno")[0].childNodes[0].data;
            campo3.value=respuesta.getElementsByTagName("us_apellidomaterno")[0].childNodes[0].data;
            campo4.value=respuesta.getElementsByTagName("us_email")[0].childNodes[0].data;
            campo5.value=respuesta.getElementsByTagName("us_numtelefono")[0].childNodes[0].data;
        }
    } 

}

function marcar(obj,chk) {
	elem=obj.getElementsByTagName('input');
  for(i=0;i<elem.length;i++)
  	elem[i].checked=chk.checked;
}

function addRow(tableID) {
    if (document.nuevouser.usnombre.value.length!=0 && document.nuevouser.uspaterno.value.length!=0 && document.nuevouser.usmaterno.value.length!=0){
        if(document.nuevouser.asignarempleado.value.length!=0){
                var n = document.nuevouser.usnombre.value;
                var p = document.nuevouser.uspaterno.value;
                var m = document.nuevouser.usmaterno.value;
                var finalstring =n+' '+p+' '+m;
                var string = document.nuevouser.asignarempleado.value;
                    if(string.length != finalstring.length){
                        var table = document.getElementById(tableID);
                        var rowCount = table.rows.length;
                        var row = table.insertRow(rowCount);

                        var cell1 = row.insertCell(0);
                        var element1 = document.createElement("input");
                        element1.type = "checkbox";
                        cell1.appendChild(element1);

                        var cell2 = row.insertCell(1);
                        var valor = document.nuevouser.asignarempleado.value;
                        var element2 = document.createTextNode(valor);
                        cell2.appendChild(element2);

                        var cell3 = row.insertCell(2);
                        var element3 = document.createElement("input");
                        element3.type = "checkbox";
                        element3.name = "asignacion[]";
                        element3.class = "aoculto";
                        element3.value = valor;
                        element3.checked = "yes";
                        element3.hidden = "yes";
                        cell3.appendChild(element3);
                    }else{alert('El usuario nuevo no puede administrarse asi mismo')};
        }else{
          alert('Debe escribir el nombre del empleado que quiere asignar');
        }
    }else{
       alert('Ingrese los datos generales del nuevo usuario');
    }

}
 
function deleteRow(tableID) {

               try {

               var table = document.getElementById(tableID);

               var rowCount = table.rows.length;

 

               for(var i=0; i<rowCount; i++) {

                    var row = table.rows[i];

                    var chkbox = row.cells[0].childNodes[0];

                    if(null != chkbox && true == chkbox.checked) {

                         table.deleteRow(i);

                         rowCount--;

                         i--;

                    }

               }

               }catch(e) {

                    alert(e);

               }

}

function dosearch() {
                var tableReg = document.getElementById('datatable');
                var searchText = document.getElementById('contenidotabla').value.toLowerCase();
                for (var i = 1; i < tableReg.rows.length; i++) {
                    var cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
                    var found = false;
                    for (var j = 0; j < cellsOfRow.length && !found; j++) {
                        var compareWith = cellsOfRow[j].innerHTML.toLowerCase();
                        if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1)) {
                            found = true;
                        }
                    }
                    if (found) {
                        tableReg.rows[i].style.display = '';
                    } else {
                        tableReg.rows[i].style.display = 'none';
                    }
                }
}

