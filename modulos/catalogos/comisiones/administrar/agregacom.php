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
        
        if(!isset($_POST['tipo_com']) || $_POST['tipo_com'] == '1000'){
            $error[]='tipo com';
        }else{
            if(isset($_POST['tipo_com']) || $_POST['tipo_com'] != '1000' && !empty($_POST['comision'])){
                $tipocom=$_POST['tipo_com'];
                if($tipocom == 'porcentaje' && !empty($_POST['comision'])){
                    $salporcentaje=$_POST['comision'];
                    $salmonto='0';
                } 
                if($tipocom == 'comision' && !empty($_POST['comision'])){
                    $salmonto=$_POST['comision'];
                    $salporcentaje='0';
                }

            }else{
               $error[]='tipo com2'; 
            }
        }
      
        if(!isset($_POST['plazas']) || $_POST['plazas'] == '1000'){
            $error[]='plaza';
        }else if(isset($_POST['plazas']) || $_POST['plazas'] != '1000'){
            $plaza=$_POST['plazas'];
        }
        
        if(!isset($_POST['sucursales']) || $_POST['sucursales'] == '1000'){
            $error[]='sucursales';
        }else if(isset($_POST['sucursales']) || $_POST['sucursales'] != '1000'){
            $sucursal=$_POST['sucursales'];
        }
        
        // datos de plazas
//        echo 'datos de plazas<br>';
//        echo 'Nombre:'.$nombre.'<br>';
//        echo 'estatus: '.$chk_activo.'<br>';
//        echo 'Monto: '.$salmonto.'<br>';
//        echo 'Porcentaje: '.$salporcentaje.'<br>';
//        echo 'Plaza: '.$plaza.'<br>';
//        echo 'Sucursal: '.$sucursal.'</br>';
        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia cadenas
            $nombre=$insert->limpia_cadena($nombre);
            $salmonto=$insert->limpia_cadena($salmonto);
            $salporcentaje=$insert->limpia_cadena($salporcentaje);
            $plaza=$insert->limpia_cadena($plaza);
            $sucursal=$insert->limpia_cadena($sucursal);
            $tipocom=$insert->limpia_cadena($tipocom);
            //insertar datos
            $insert->agrega_com($nombre, $salmonto, $salporcentaje, $plaza, $sucursal, $chk_activo);
        }
        $insert->cierra_conexion("0");
        if($insert->inserts == '1'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>'; 
            echo 'Registro guardado con exito!';
        }else {
            echo 'Error al guardar la nueva comision';
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
        //valida select plazas        
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
        
        
        if(!isset($_POST['tipo_com']) || $_POST['tipo_com'] == '1000'){
            $error[]='tipo com';
        }else{
            if(isset($_POST['tipo_com']) || $_POST['tipo_com'] != '1000' && !empty($_POST['comision'])){
                $tipocom=$_POST['tipo_com'];
                if($tipocom == 'porcentaje' && !empty($_POST['comision'])){
                    $salporcentaje=$_POST['comision'];
                    $salmonto='0';
                } 
                if($tipocom == 'cantidad' && !empty($_POST['comision'])){
                    $salmonto=$_POST['comision'];
                    $salporcentaje='0';
                }

            }else{
               $error[]='tipo com2'; 
            }
        }
        
        
        if(!isset($_POST['plazas']) || $_POST['plazas'] == '1000'){
            $error[]='plaza';
        }else if(isset($_POST['plazas']) || $_POST['plazas'] != '1000'){
            $plaza=$_POST['plazas'];
        }
         if(!isset($_POST['sucursales']) || $_POST['sucursales'] == '1000'){
            $error[]='sucursales';
        }else if(isset($_POST['sucursales']) || $_POST['sucursales'] != '1000'){
            $sucursal=$_POST['sucursales'];
        }
       
        // datos de plazas
//        echo 'datos de plazas<br>';
//        echo 'Nombre: '.$nombre.'<br>';
//        echo 'estatus: '.$chk_activo.'<br>';
//        echo 'Monto: '.$salmonto.'<br>';
//        echo 'Porcentaje: '.$salporcentaje.'<br>';
//        echo 'Plaza: '.$plaza.'<br>';
//        echo 'Sucursal: '.$sucursal.'</br>';
        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia cadenas
            $registro=$insert->limpia_cadena($registro);
            $nombre=$insert->limpia_cadena($nombre);
            $salmonto=$insert->limpia_cadena($salmonto);
            $salporcentaje=$insert->limpia_cadena($salporcentaje);
            $plaza=$insert->limpia_cadena($plaza);
            $sucursal=$insert->limpia_cadena($sucursal);
            $tipocom=$insert->limpia_cadena($tipocom);
            
            //insertar datos
            $insert->actualiza_com($registro,$nombre,$salmonto,$salporcentaje,$plaza,$sucursal,$chk_activo);
        }
        
        $insert->cierra_conexion("0");
        if($insert->update== '1'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>'; 
            echo 'Registro editado con exito!';
            
        }else {
            echo 'Error al editar la comision';
            print_r($error);
        }
    }

?>