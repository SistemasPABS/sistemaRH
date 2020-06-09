<?php
session_start();
if(isset($_SESSION['plogin']) && $_SESSION['plogin'] === true){
    if($_SESSION['listo'] === true && isset($_SESSION['us_id'])){
         $oe= base64_encode($_SESSION['us_id']);
         header("Location: ../menu/menu.php?oe=$oe");//te manda a la pantalla de menu en caso de tener una sesion iniciada
    }
}else{
    header('Location: /controller/index.php');
}

?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
	<title>Sistemas PABS</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
	<script>
            window.onload=lanzadera;
            function lanzadera (){
              document.oncontextmenu = function() { return false; };
            }
            function clr() {
                var chk = hex_md5(document.getElementById("passwd").value);
                document.getElementById("passwd").value = chk;
                document.getElementById("formLogin").submit();
            }
        </script>
</head>
<body oncontextmenu="return false">
<?php
            date_default_timezone_set('America/Mexico_City');
            $fecha=date("Ymd");
            $hora=date("H:i:s");
            $equipo=gethostbyaddr($_SERVER['REMOTE_ADDR']);

            /*si no existe campo login y passswd se manda el formulario para login*/
            if(!isset($_POST['login']) && !isset($_POST['passwd'])){
                echo ('/login/logindesign.php');
		}else{
			/*si ya existe campo login y passwd(seteados) se realiza la validacion del usuario y password introducidos*/
			if(isset($_POST['login']) && isset($_POST['passwd'])){
				include ('../config/conectasql.php');
				$valida = new conectasql();
				$valida->abre_conexion("0");
				$valida->valida_usuario($_POST['login'],$_POST['passwd']);
				$acceso=$valida->acceso;
				$id = $valida->id;
				if($acceso == 'autorizado'){
					/*se guarda el registro del acceso autorizado*/
					$valida->registro_login($id, $fecha, $hora, $equipo);
					/*se crean las variables de sesion listo y us_id*/
					$_SESSION['listo'] = true;
					$_SESSION['us_id']= $valida->id;
					//$oe = base64_encode($id);//origen encriptado
					header("location: ../menu/menu.php");
				}else if($acceso = 'no autorizado'){
					/*si resulta en un login fallido se guarda registro del intento y muestra la pantalla de login de nuevo*/
					$navegador='login: '.$_POST['login'];
					$valida->historico_af($fecha, $hora, $equipo, $navegador, 'Error de usuario o contraseña');
					echo ('/login/logindesign.php');
				}
				$valida->cierra_conexion("0");
			}
		}
	?>

</body>
</html>