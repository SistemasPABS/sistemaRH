<?php
require '../config/cookie.php';
?>
<html class="fondotrabajo">
    <head>
        <title>Cambia tu contraseña</title>
             
    </head>
    <body>
      <?php
            //$passwdmd5=md5($_POST['c_actual']);
            $estid = $_GET['oe'];
            $n1=$_POST['c_nueva'];
            $n2=$_POST['c_confirma'];
            
            if (!isset($_POST['c_actual']) && !isset($_POST['c_nueva'])){
                include_once('creacambiapas.php');
                $cambiapas = new creacambiapas($usid,$nav);
                $cambiapas->librerias();
                $cambiapas->jscambiapas();
                $cambiapas->interfazpasswd();
            }else{
                include ('creacambiapas.php');
                $cambiapas = new creacambiapas($usid,$nav);
                $cambiapas->passwdactual($_POST['c_actual']);
                $cambiapas->condicion('nombre','pwd','=');
                $cambiapas->query('select nombre,pwd from tcausr'.' ');
                $cambiapas->verificanuevopas($n1,$n2);
                //echo 'mensaje'.$cambiapas->flag;
                if ($flag = NULL ){
                   echo '<div style="margin-top:55px;width:auto;height:40px;background-color: black;text-align:center;border-top:3px solid white;border-bottom:3px solid white;color:white;padding-top:15px;">Contraseña actualizada con exito</div>';
                   echo '<script type="text/javascript">
                         setTimeout("self.close();",4000);
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
