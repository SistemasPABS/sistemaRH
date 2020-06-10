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

<!DOCTYPE html>

<html>
    <head>
        <title> Inicio </title>
        
        <link rel="shortcut icon" type="image/x-icon" href="../images/notepadicon.ico">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel = "stylesheet" type="text/css" href="../estilos/loginStyles.css" medis="screen" />
        <script type="text/javascript" src="../librerias/md5-min.js"></script>
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
                echo    '<div id="fondo">
                            <div class="alineado">
                                <img class="logo" src="../images/logo.png">
                                <div class="contenedor" >
                                    <div class="centrado">
                                        <h4 class="Titulo">Inicio de Sesión </h4>
                                        <form action="login.php" method="POST" id="formLogin">
                                            <label class="Subtitulo">Usuario</label>
                                            <input class="Input"  style="margin-left: 40px;" name="login" type="text" id="user" /><br/><br/>

                                            <label class="Subtitulo">Contraseña</label>
                                            <input class="Input" name="passwd" type="password" id="passwd" /><br/><br/>
                                            <input class="bottonAcces" type="button" onclick="clr();" value="LOGIN" /> 
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>';
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
                        echo    '<div id="fondo">
                                    <div class="alineado">
                                        <img class="logo" src="../images/logo.png">
                                        <div class="contenedor" >
                                            <div class="centrado">
                                                <h4 class="Titulo">Inicio de Sesión </h4>
                                                <form action="login.php" method="POST" id="formLogin">
                                                    <label class="Subtitulo">Usuario</label>
                                                    <input class="Input"  style="margin-left: 40px;" name="login" type="text" id="user" /><br/><br/>

                                                    <label class="Subtitulo">Contraseña</label>
                                                    <input class="Input" name="passwd" type="password" id="passwd" /><br/><br/>
                                                    <input class="bottonAcces" type="button" onclick="clr();" value="LOGIN" /> 
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript"> alert(\'Usuario y contraseña incorrectos\'); </script>';
                    }
                    $valida->cierra_conexion("0");
                }
            }
        ?>
    </body>
</html>