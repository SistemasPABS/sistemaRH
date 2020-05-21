<html>
<head>
<title>Problema</title>
<script language="javascript" type="text/javascript">
var cantidad = 0;
function agregarHijo() 
{
  cantidad++;
  var nuevohijo = document.createElement('input');
  nuevohijo.type = 'text';
  nuevohijo.name = 'nombre' + cantidad;
  nuevohijo.id = 'nombre' + cantidad;
  document.getElementById('fs').appendChild(nuevohijo);
  document.getElementById('fs').appendChild(document.createElement('br'));
}

</script>
</head>
<body>
<form method="post">
Ingrese su nombre: <input type="text" name="nombre" id="nombre"><br>
<div id="fs">
<legend>Ingrese los nombres de sus hijos</legend>
<input type="button" onclick="agregarHijo()" value="Presione 
el botón para agregar un hijo.">
<br>
</div>
<input type="submit" value="Registrar">
</form>
</body>
</html>