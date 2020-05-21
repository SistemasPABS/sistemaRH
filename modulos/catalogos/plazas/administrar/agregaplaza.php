<?php
    include ('../../../../config/cookie.php');
?>
<?php
    
    $op = base64_decode($_GET['op']);
    //echo $op;
        
    if($op == 'nuevo'){
        $error = array();

        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[] = "nombre";
        }else if (isset($_POST['nombre']) || !empty($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }

        if(!isset($_POST['estatus'])){
            $chk_activo = '0';
        }else if(isset($_POST['estatus']) && $_POST['estatus'] == 'on'){
            $chk_activo = '1';
        }
       
        // datos de plazas
//        echo 'datos de plazas<br>';
//        echo 'estatus: '.$chk_activo.'<br>';
//        echo 'Nombre: '.$nombre.'<br>';
        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia caenas
            $nombre=$insert->limpia_cadena($nombre);
            
            //inserta datos
            $insert->nuevaplaza($nombre, $chk_activo);
        }
        $insert->cierra_conexion("0");
        if($insert->inserts == '1'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>';
            echo 'Registro guardado con exito!';
        }else {
            echo 'Error al guardar la nueva plaza';
            print_r($error);
        }
    }else if ($op == 'editar') {
        $error = array();
        
        //variable id(registro)
        if(!isset($_POST['registro']) || empty($_POST['registro'])){
            $registro='';
        }else if(isset($_POST['registro']) || !empty($_POST['registro'])){
            $registro=$_POST['registro'];
        }
        //variable nombre plaza
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[] = "nombre";
        }else if (isset($_POST['nombre']) || !empty($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }
        //variable estatus plaza
        if(!isset($_POST['estatus'])){
            $chk_activo = '0';
        }else if(isset($_POST['estatus']) && $_POST['estatus'] == 'on'){
            $chk_activo = '1';
        }
        
       
        // datos de plazas
//        echo 'datos de plazaaaaas<br>';
//        echo 'estatus: '.$chk_activo.'<br>';
//        echo 'Nombre: '.$nombre.'<br>';
        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia caenas
            $registro=$insert->limpia_cadena($registro);
            $nombre=$insert->limpia_cadena($nombre);
            
            //inserta datos
            $insert->edita_plaza($registro,$nombre,$chk_activo);
        }
        $insert->cierra_conexion("0");
        if($insert->update== '1'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>';
            echo 'Registro editado con exito!';
        }else {
            echo 'Error al editar la plaza';
            print_r($error);
        }
    }

?>