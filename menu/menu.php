<?php
require ('../config/cookie.php');
?>

<html class="fondotrabajo">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title> APP Controller </title>    
        <link rel="shortcut icon" type="image/x-icon" href="../images/notepadicon.ico">
        
    </head>
    <body topmargin="0" oncontextmenu="return false">
        <?php
            session_start(); 
            $usid=$_SESSION['us_id'];
            //echo 'Welcome '.$usid;
            include('./creamenu.php');
            $menu= new creamenu($usid);
            $menu->librerias();
            $menu->interfaz();
        ?>
        
    </body>
</html>