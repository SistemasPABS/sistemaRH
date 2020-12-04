<?php

echo '<link href="../styles.css" type="text/css" rel="stylesheet">';
echo '<link href="../lib/jquery-ui.css" type="text/css" rel="stylesheet">';
echo '<script type="text/javascript" src="agrega_alias.js"></script>'; 
echo '<script type="text/javascript" src="../lib/jquery3.5.js"></script>';
echo '<script type="text/javascript" src="../lib/jquery-ui.js"></script>';

$estid = base64_decode($_GET['em']);
$op= base64_decode($_GET['op']);
$pz= base64_decode($_GET['pz']);


/*    echo "<h3>$pz'+++'</h3>";
    echo "<h3>$estid</h3>";
    echo "<h3>$op</h3>";
*/
    echo '<div class="fondo5">';
        echo '<form method="post" id="form_contrato" name="form_contrato" action="guarda_alias.php">';
            echo '<div class="row">';
                echo '<label class="titulo_12">Agregar Alias a Persona</label>';
            echo '</div>';
            echo '<div class="row">';
                echo '<label class="titulo_3">'.$op.'</label>';
            echo '</div>';
                echo '<input class="input0" id="id_persona" name="id_persona" value="" readonly hidden>';
                echo '<input class="input0" id="alias" name="alias" value="'.$op.'" readonly hidden>';
              
                               
            
            echo '<div class="row">';
                echo '<div class="col-12">';
                     echo '<input class="input10" id="clave" name="clave" value="" placeholder="clave del empleado"readonly >';
               
                    echo '<input class="input11" name="nombre" id="nombre" value="" placeholder="Teclea el nombre del Empleado">';
                    echo '</br>';
                    echo '</br>';
                    echo '</br>';
                    echo '<button class="btn_aceptar" type="submit">Agregar</button>';

                echo '</div>';
            echo '<div class="row">';
                echo '<label>Recuerda que tienes que verificar la clave de la persona para asegurarte que pertenece a la plaza de la cual estas haciendo la nomina</label>';
            echo '</div>';
            echo '</div>';
            
        echo '</form>';
    echo '</div>';
?>