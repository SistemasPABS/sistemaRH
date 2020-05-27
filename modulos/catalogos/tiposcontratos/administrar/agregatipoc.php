<?php
    include ('../../../../config/cookie.php');
?>
<?php
    
    $op = base64_decode($_GET['op']);
    //echo $op;
    
    if($op == 'nuevo'){
        $error = array();
        //Valida que la clave no este seteada
        if(!isset($_POST['clave']) || empty($_POST['clave'])){
            $error[] = "clave";
        }else if (isset($_POST['clave']) || !empty($_POST['clave'])) {
            $clave= $_POST['clave'];
        }
        //Valida que la clave no este seteada
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[] = "nombre";
        }else if (isset($_POST['nombre']) || !empty($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }
        //se define nombre de la plantilla
        $nombreplantilla=$_POST['clave'].'.doc';
        //Asigna destino y nombre al documento a copiar
        $destino='../../../../formatos/contratos/'.$nombreplantilla;
        //mueve o copia el archivo seleccionado
        move_uploaded_file($_FILES['plantilla']['tmp_name'],$destino);
        //Asigna permisos al archivo guardado
        chmod($destino,'777');

       // datos de plazas
//        echo 'datos de plazas<br>';
//        echo 'Nombre: '.$nombre.'<br>';
//        echo 'Clave: '.$clave.'<br>';

     
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia caenas
            $nombre=$insert->limpia_cadena($nombre);
            $clave=$insert->limpia_cadena($clave);   
                    
            //inserta datos
            $insert->agrega_tipoc($clave, $nombre, $nombreplantilla);
        }
        $insert->cierra_conexion("0");
        //Mensaje de confirmacion de registro guardado 
        if($insert->inserts == '1'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>';
            echo 'Registro guardado con exito!';
        }else {
            echo 'Error al guardar';
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
       //Valida que la clave no este seteada
        if(!isset($_POST['clave']) || empty($_POST['clave'])){
            $error[] = "clave";
        }else if (isset($_POST['clave']) || !empty($_POST['clave'])) {
            $clave= $_POST['clave'];
        }
        //Valida que la clave no este seteada
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[] = "nombre";
        }else if (isset($_POST['nombre']) || !empty($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }
        //se define nombre de la plantilla
        $nombreplantilla=$_POST['clave'].'.doc';
        //Asigna destino y nombre al documento a copiar
        $destino='../../../../formatos/contratos/'.$nombreplantilla;
        //mueve o copia el archivo seleccionado
        move_uploaded_file($_FILES['plantilla']['tmp_name'],$destino);
        //Asigna permisos al archivo guardado
        chmod($destino,'777');

       // datos de plazas
//        echo 'datos de plazas<br>';
//        echo 'Nombre: '.$nombre.'<br>';
//        echo 'Clave: '.$clave.'<br>';
//        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia caenas
            $nombre=$insert->limpia_cadena($nombre);
            $clave=$insert->limpia_cadena($clave);   
                    
            //inserta datos
            $insert->edita_tipoc($registro, $clave, $nombre, $nombreplantilla);
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