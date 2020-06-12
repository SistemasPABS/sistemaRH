<?php
require '../config/cookie.php';
?>
<html class="fondotrabajo">
    <head>
        <title>Cambia tu contraseña</title>
             
    </head>
    <body>
      <?php
            if (!isset($_POST['c_actual']) && !isset($_POST['c_nueva'])){
                include_once('creacambiapas.php');
                $cambiapas = new creacambiapas($usid,$nav);
                $cambiapas->librerias();
                $cambiapas->jscambiapas();
                $cambiapas->interfazpasswd();
            }else if(isset($_POST['c_actual']) && isset($_POST['c_nueva'])){
                session_start();
                $usid = $_SESSION['us_id'];
                $actual=$_POST['c_actual'];
                $ps1=$_POST['c_nueva'];
                $ps2=$_POST['c_confirma'];
                
                include ('creacambiapas.php');
                $cambiapas = new creacambiapas($usid);
                $cambiapas->abre_conexion("0");
                $cambiapas->verificanuevopas($actual,$ps1,$ps2);
                $cambiapas->cierra_conexion("0");
                //echo 'mensaje'.$cambiapas->flag;
                if ($cambiapas->flag = 1 ){
                   echo '<div style="margin-top:55px;width:auto;height:40px;background-color: black;text-align:center;border-top:3px solid white;border-bottom:3px solid white;color:white;padding-top:15px;">Contraseña actualizada con exito</div>';
                   echo '<script type="text/javascript">
                         setTimeout("self.close();",3000);
                         </script>';
                }  else {
                    $cambiapas->librerias();
                    $cambiapas->jscambiapas();
                    $cambiapas->interfazpasswd();
                    echo "<script>alert('Contraseñas invalidas')</script>";
                }
               
            }
      ?>
    </body>
</html>
