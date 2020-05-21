<?php
    include ('../../../../config/cookie.php');
?>
<?php
    
    $op = base64_decode($_GET['op']);
    //echo $op;
        
    if($op == 'nuevo'){
        $error = array();
        
        if(!isset($_POST['plazas']) || $_POST['plazas'] == '1000'){
            $error[]='plaza';
        }else if(isset($_POST['genero']) || $_POST['genero'] != '1000'){
            $plaza=$_POST['plazas'];
        }
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
            //limpa cadenas
            $nombre=$insert->limpia_cadena($nombre);
            $plaza=$insert->limpia_cadena($plaza);
            
            //inserta datos
            $insert->agrega_sucursal($nombre, $plaza, $chk_activo);
        }
        $insert->cierra_conexion("0");
        if($insert->inserts == '1'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>'; 
            echo 'Registro guardado con exito!';
        }else {
            echo 'Error al guardar la nueva sucursal';
            print_r($error);
        }
    }else if ($op == 'editar') {
        $error = array();
        //valida select plazas
        if(!isset($_POST['plazas']) || $_POST['plazas'] == '1000'){
            $error[]='plaza';
        }else if(isset($_POST['genero']) || $_POST['genero'] != '1000'){
            $plaza=$_POST['plazas'];
        }
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
            //limpa cadenas
            $registro=$insert->limpia_cadena($registro);
            $nombre=$insert->limpia_cadena($nombre);
            $plaza=$insert->limpia_cadena($plaza);
            
            //inserta datos
            $insert->actualiza_suc($registro, $nombre, $plaza, $chk_activo);
        }
        $insert->cierra_conexion("0");
        if($insert->update== '1'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>'; 
            echo 'Registro editado con exito!';
        }else {
            echo 'Error al editar la sucursal';
            print_r($error); 
        }
    }

?>