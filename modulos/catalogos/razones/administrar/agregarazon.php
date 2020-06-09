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
         if(!isset($_POST['representante']) || empty($_POST['representante'])){
            $error[] = "representante";
        }else if (isset($_POST['representante']) || !empty($_POST['representante'])) {
            $representante= $_POST['representante'];
        }
         if(!isset($_POST['direccion']) || empty($_POST['direccion'])){
            $error[] = "direccion";
        }else if (isset($_POST['direccion']) || !empty($_POST['direccion'])) {
            $direccion = $_POST['direccion'];
        }

      
       
        // datos de plazas
//        echo 'datos de plazas<br>';
//        echo 'Nombre: '.$nombre.'<br>';
//        echo 'Repre: '.$representante.'<br>';
//        echo 'Dir: '.$direccion.'<br>';
        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia caenas
            $nombre=$insert->limpia_cadena($nombre);
            $direccion=$insert->limpia_cadena($direccion);   
            $representante=$insert->limpia_cadena($representante);            
            //inserta datos
            $insert->agrega_razon($nombre, $direccion, $representante);
        }
        $insert->cierra_conexion("0");
        if($insert->inserts == '1'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>';
            echo '<link href="../../../../estilos/personasStyles.css" type="text/css" rel="stylesheet">';
            echo '<div class="padre">
                    <div class="hijo">
                        <img class="icono" src="../../../../images/guardado2.png" alt="icono2" srcset="">
                        <h2 class="texto5">Registro Guardado Conexito!!</h2>
                        <h4 class="texto5">La ventana se cerrarra en automaico!</h4>
                    </div>
                 </div>';
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
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[] = "nombre";
        }else if (isset($_POST['nombre']) || !empty($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }
         if(!isset($_POST['representante']) || empty($_POST['representante'])){
            $error[] = "representante";
        }else if (isset($_POST['representante']) || !empty($_POST['representante'])) {
            $representante= $_POST['representante'];
        }
         if(!isset($_POST['direccion']) || empty($_POST['direccion'])){
            $error[] = "direccion";
        }else if (isset($_POST['direccion']) || !empty($_POST['direccion'])) {
            $direccion = $_POST['direccion'];
        }
        
       
        // datos de plazas
//        echo 'Registro: '.$registro.'<br>'; 
//        echo 'datos de plazas<br>';
//        echo 'Nombre: '.$nombre.'<br>';
//        echo 'Repre: '.$representante.'<br>';
//        echo 'Dir: '.$direccion.'<br>';
//        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia caenas
            $nombre=$insert->limpia_cadena($nombre);
            $direccion=$insert->limpia_cadena($direccion);   
            $representante=$insert->limpia_cadena($representante);   
            //inserta datos
            $insert->edita_razon($registro, $nombre, $direccion, $representante);
        }
        $insert->cierra_conexion("0");
        if($insert->update== '1'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>';
            echo '<link href="../../../../estilos/personasStyles.css" type="text/css" rel="stylesheet">';
            echo '<div class="padre">
                    <div class="hijo">
                        <img class="icono" src="../../../../images/editado2.png" alt="icono2" srcset="">
                        <h2 class="texto5">Registro Editado Conexito!!</h2>
                        <h4 class="texto5">La ventana se cerrarra en automaico!</h4>
                    </div>
                 </div>';
        }else {
            echo 'Error al editar la plaza';
            print_r($error);
        }
    }

?>