<?php
    include ('../../../../../config/cookie.php');
?>
<?php
    //Establece zona horaria
    date_default_timezone_set('America/Mexico_City');
    //Obtiene fecha y Hora
    $fecha=date("Y-m-d");
    $hora=date("H:i:s");
    $f=date("Ymd");
    $h=date("His");
    
    $op = base64_decode($_GET['op']);
       
    if($op == 'nuevo'){
        $error = array();
        //Valida que la clave no este seteada
        if(!isset($_POST['persona']) || empty($_POST['persona'])){
            $error[] = "persona";
        }else if (isset($_POST['persona']) || !empty($_POST['persona'])) {
            $persona = $_POST['persona'];
        }
        if(!isset($_POST['desc']) || empty($_POST['desc'])){
            $error[] = "desc";
        }else if (isset($_POST['desc']) || !empty($_POST['desc'])) {
            $desc= $_POST['desc'];
        }
        //Valida que la clave no este seteada
        if(!isset($_POST['tipo_exp']) || empty($_POST['tipo_exp'])){
            $error[] = "tipo_exp";
        }else if (isset($_POST['tipo_exp']) || !empty($_POST['tipo_exp'])) {
            $tipo_exp = $_POST['tipo_exp'];
        }
        
        $e=$_FILES['doc']['type'];
        $ext= explode('/',$e);
        
        //se define nombre de la plantilla
        $nombredoc= $persona.$tipo_exp.$f.$h.'.'.$ext[1];
        //Asigna destino y nombre al documento a copiar
        $destino='../../../../../formatos/expedientes/'.$nombredoc;
        //mueve o copia el archivo seleccionado
        move_uploaded_file($_FILES['doc']['tmp_name'],$destino);
        //Asigna permisos al archivo guardado
        chmod($destino,'0777');

       // datos deexpediente
       
//        echo 'datos de plazas<br>';
//        echo 'Persona: '.$persona.'<br>';
//        echo 'Descripcion: '.$desc.'<br>';
//        echo 'Nombre: '.$nombredoc.'<br>';
//        echo 'Fecha: '.$fecha.'<br>';
//        echo 'Hora: '.$hora.'<br>';
//        echo 'Tipo Exp: '.$tipo_exp.'<br>';
        
        
     
        include '../../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia caenas
            $persona=$insert->limpia_cadena($persona);
            $desc=$insert->limpia_cadena($desc); 
            $nombredoc=$insert->limpia_cadena($nombredoc); 
            $tipo_exp=$insert->limpia_cadena($tipo_exp); 
                    
            //inserta datos
            $insert->agrega_expediente($persona, $desc, $nombredoc, $fecha, $hora, $tipo_exp);
        }
        $insert->cierra_conexion("0");
        //Mensaje de confirmacion de registro guardado 
        if($insert->inserts == '1'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>';
            echo 'Registro guardado con exito!';
            echo 'Extencion: '.$ext;
        }else {
            echo 'Error al guardar';
            print_r($error);
        }
        
    }else if ($op == 'editar') {
        include '../../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");
        
        $error = array();
        //Valida que la el id del expediente a editar
        if(!isset($_POST['registro']) || empty($_POST['registro'])){
            $error[] = "registro";
        }else if (isset($_POST['registro']) || !empty($_POST['registro'])) {
            $registro = $_POST['registro'];
        }
        //Valida que la clave no este seteada
        if(!isset($_POST['persona']) || empty($_POST['persona'])){
            $error[] = "persona";
        }else if (isset($_POST['persona']) || !empty($_POST['persona'])) {
            $persona = $_POST['persona'];
        }
        if(!isset($_POST['desc']) || empty($_POST['desc'])){
            $error[] = "desc";
        }else if (isset($_POST['desc']) || !empty($_POST['desc'])) {
            $desc= $_POST['desc'];
        }
        //Valida que la clave no este seteada
        if(!isset($_POST['tipo_exp']) || empty($_POST['tipo_exp'])){
            $error[] = "tipo_exp";
        }else if (isset($_POST['tipo_exp']) || !empty($_POST['tipo_exp'])) {
            $tipo_exp = $_POST['tipo_exp'];
        }
        if($_FILES['doc']['name'] != null){
            $archivo='archivo';
        }else{
            $archivo='sin archivo';
        }
        
        // datos deexpediente
//        echo 'datos del expediente<br>';
//        echo 'Registro: '.$registro.'<br>';
//        echo 'Persona: '.$persona.'<br>';
//        echo 'Descripcion: '.$desc.'<br>';
//        echo 'Fecha: '.$fecha.'<br>';
//        echo 'Hora: '.$hora.'<br>';
//        echo 'Tipo Exp: '.$tipo_exp.'<br>';
        

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
            print_r($error);
        }else{
            //se consultan los valores del registro del expediente
            $insert->consulta_doc_exp($registro);
            
            if($insert->consulta['txp_id'] != $tipo_exp){
                $tipo_exp=$tipo_exp;
                $desc=$desc;
                if($archivo == 'archivo'){
                    //se borra el archivo anterior
                    unlink('../../../../../formatos/expedientes/'.$insert->consulta['exp_ruta']);
                    //se define nombre de la plantilla
                    $e=$_FILES['doc']['type'];
                    $ext= explode('/',$e);
                    $nombredoc= $persona.$tipo_exp.$f.$h.'.'.$ext[1];
                    //Asigna destino y nombre al documento a copiar
                    $destino='../../../../../formatos/expedientes/'.$nombredoc;
                    //mueve o copia el archivo seleccionado
                    move_uploaded_file($_FILES['doc']['tmp_name'],$destino);
                    //Asigna permisos al archivo guardado
                    chmod($destino,'0777');
                }else if($archivo == 'sin archivo'){
                    $e=$insert->consulta['exp_ruta'];
                    $ext= explode('.',$e);
                    $nombredoc=$persona.$tipo_exp.$f.$h.'.'.$ext[1];
                    rename('../../../../../formatos/expedientes/'.$insert->consulta['exp_ruta'], '../../../../../formatos/expedientes/'.$nombredoc);
                }
                //hacer update a la tabla
                //echo $registro.'<br>'.$desc.'<br>'.$nombredoc.'<br>'.$fecha.'<br>'.$hora.'<br>'.$tipo_doc.'<br>';
                $insert->edita_expediente($registro, $desc, $nombredoc, $fecha, $hora, $tipo_exp);
                
            }else if($insert->consulta['txp_id'] == $tipo_exp){
                $tipo_exp=$insert->consulta['txp_id'];
                $desc=$desc;
                if($archivo == 'archivo'){
                    //se borra el archivo anterior
                    unlink('../../../../../formatos/expedientes/'.$insert->consulta['exp_ruta']);
                    //se define nombre de la plantilla
                    $e=$_FILES['doc']['type'];
                    $ext= explode('/',$e);
                    $nombredoc= $persona.$tipo_exp.$f.$h.'.'.$ext[1];
                    //Asigna destino y nombre al documento a copiar
                    $destino='../../../../../formatos/expedientes/'.$nombredoc;
                    //mueve o copia el archivo seleccionado
                    move_uploaded_file($_FILES['doc']['tmp_name'],$destino);
                    //Asigna permisos al archivo guardado
                    chmod($destino,'0777');
                }else if($archivo == 'sin archivo'){
                    $nombredoc=$insert->consulta['txp_ruta'];
                }
                //hacer update a la tabla
                //echo $registro.'<br>'.$desc.'<br>'.$nombredoc.'<br>'.$fecha.'<br>'.$hora.'<br>'.$tipo_doc.'<br>';
                $insert->edita_expediente($registro, $desc, $nombredoc, $fecha, $hora, $tipo_exp);
            }
            
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