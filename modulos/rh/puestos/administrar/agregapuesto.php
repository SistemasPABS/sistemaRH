<?php
    include ('../../../../config/cookie.php');
?>
<?php
    date_default_timezone_set('America/Mexico_City');
    $fecha=date("Ymd");
    $hora=date("H:i:s");
    $op = base64_decode($_GET['op']);
    //echo $op;
        
    if($op == 'nuevo'){
        $aut='0';
        $uss='0';
        $error = array();       
        
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[] = "nombre";
        }else if (isset($_POST['nombre']) || !empty($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }
        if(!isset($_POST['grupo']) || $_POST['grupo'] == '1000'){
            $error[]='grupo';
        }else if(isset($_POST['grupo']) || $_POST['grupo'] != '1000'){
            $grupo=$_POST['grupo'];
        }
        if(!isset($_POST['clave']) || empty($_POST['clave'])){
            $error[] = "clave";
        }else if (isset($_POST['clave']) || !empty($_POST['clave'])) {
            $clave = $_POST['clave'];
        }
        if(!isset($_POST['descripcion']) || empty($_POST['descripcion'])){
            $error[] = "desc";
        }else if (isset($_POST['descripcion']) || !empty($_POST['descripcion'])) {
            $desc = $_POST['descripcion'];
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
        if(!isset($_POST['salarios']) || $_POST['salarios'] == '1000'){
            $error[]='salarios';
        }else if(isset($_POST['salarios']) || $_POST['salarios'] != '1000'){
            $salario=$_POST['salarios'];
        }
        if(!isset($_POST['jefes']) || $_POST['jefes'] == '1000'){
            $error[]='jefes';
        }else if(isset($_POST['jefes']) || $_POST['jefes'] != '1000'){
            $jefe=$_POST['jefes'];
        }
        if(!isset($_POST['com'])){
            $coms='0';
        }else if(isset($_POST['com'])){
            $coms=$_POST['com'];
        }
            
        // datos de puestos
//        echo 'datos del puesto<br>';
//        echo 'Clave: '.$clave.'<br>';
//        echo 'Nombre: '.$nombre.'<br>';
//        echo 'Grupo: '.$grupo.'<br>';
//        echo 'Plaza: '.$plaza.'<br>';
//        echo 'Sucursal: '.$sucursal.'<br>';
//        echo 'Salario: '.$salario.'<br>';
//        echo 'Descripcion:'.$desc.'<br>';
//        echo 'Hora: '.$hora.'<br>';
//        echo 'Fecha: '.$fecha.'<br>';
//        echo 'Autorizacion: '.$aut.'<br>';
//        echo 'Usuario: '.$uss.'<br>';
//        echo 'Puesto Jefe: '.$jefe.'<br>';
//        //print_r($coms);
//        echo '<br>';
//        foreach ($coms as $co){
//            echo $co.'<br>';
//        }
        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            $clave=$insert->limpia_cadena($clave);
            $nombre=$insert->limpia_cadena($nombre);
            $desc=$insert->limpia_cadena($desc);
            $plaza=$insert->limpia_cadena($plaza);
            $sucursal=$insert->limpia_cadena($sucursal);
            $salario=$insert->limpia_cadena($salario);
            $jefe=$insert->limpia_cadena($jefe);
            $grupo=$insert->limpia_cadena($grupo);
            
            //inserta datos
            $insert->agrega_puesto($clave,$nombre,$desc,$aut,$uss,$fecha,$hora,$plaza,$sucursal,$salario,$jefe,$grupo);
            
            //consulta puesto insertado
            $insert->consulta_puesto_agregado($clave);
            
            //se insertan las comisiones si es que hay
            if($coms != '0'){
                foreach ($coms as $co){
                    $insert->agrega_com_puesto($insert->consulta['puesto_id'], $co);
                }
                $insert->inserts.='1';//se pone aqui para no repetir en el bucle
            }else{
                $insert->inserts.='1';//se agrega aqui tambien por si no se agregaron comisiones intencionalmente
            }
        }
        $insert->cierra_conexion("0");
        
        if($insert->inserts == '11'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>';
            echo 'Registro guardado con exito!';
        }else {
            echo 'Error al guardar el nuevo puesto';
            print_r($error);
        }
        
    }else if ($op == 'editar') {
        $error = array();       
        if(!isset($_POST['registro']) || empty($_POST['registro'])){
            $error[] = "registro";
        }else if (isset($_POST['registro']) || !empty($_POST['registro'])) {
            $registro = $_POST['registro'];
        }
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[] = "nombre";
        }else if (isset($_POST['nombre']) || !empty($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }
         if(!isset($_POST['grupo']) || $_POST['grupo'] == '1000'){
            $error[]='grupo';
        }else if(isset($_POST['grupo']) || $_POST['grupo'] != '1000'){
            $grupo=$_POST['grupo'];
        }
        if(!isset($_POST['clave']) || empty($_POST['clave'])){
            $error[] = "clave";
        }else if (isset($_POST['clave']) || !empty($_POST['clave'])) {
            $clave = $_POST['clave'];
        }
        if(!isset($_POST['descripcion']) || empty($_POST['descripcion'])){
            $error[] = "desc";
        }else if (isset($_POST['descripcion']) || !empty($_POST['descripcion'])) {
            $desc = $_POST['descripcion'];
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
        if(!isset($_POST['salarios']) || $_POST['salarios'] == '1000'){
            $error[]='salarios';
        }else if(isset($_POST['salarios']) || $_POST['salarios'] != '1000'){
            $salario=$_POST['salarios'];
        }
         if(!isset($_POST['jefes']) || $_POST['jefes'] == '1000'){
            $error[]='jefes';
        }else if(isset($_POST['jefes']) || $_POST['jefes'] != '1000'){
            $jefe=$_POST['jefes'];
        }
        if(!isset($_POST['com'])){
            $coms='0';
        }else if(isset($_POST['com'])){
            $coms=$_POST['com'];
        }
        // datos de puestos
//        echo 'datos del puesto<br>';
//        echo 'Clave: '.$clave.'<br>';
//        echo 'Nombre: '.$nombre.'<br>';
//        echo 'Plaza: '.$plaza.'<br>';
//        echo 'Sucursal: '.$sucursal.'<br>';
//        echo 'Salario: '.$salario.'<br>';
//        echo 'Descripcion:'.$desc.'<br>';
//        echo 'Hora: '.$hora.'<br>';
//        echo 'Fecha: '.$fecha.'<br>';
//        echo 'Autorizacion: '.$aut.'<br>';
//        echo 'Usuario: '.$uss.'<br>';
//        echo 'Puesto Jefe: '.$jefe.'<br>';
//        echo 'Grupo: '.$grupo.'<br>';
//        //print_r($coms);
//        echo '<br>';
//        foreach ($coms as $co){
//            echo $co.'<br>';
//        }
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia cadenas
            $clave=$insert->limpia_cadena($clave);
            $nombre=$insert->limpia_cadena($nombre);
            $desc=$insert->limpia_cadena($desc);
            $plaza=$insert->limpia_cadena($plaza);
            $sucursal=$insert->limpia_cadena($sucursal);
            $salario=$insert->limpia_cadena($salario);
            $jefe=$insert->limpia_cadena($jefe);
            $grupo=$insert->limpia_cadena($grupo);
            //inserta datos
            $insert->edita_puesto($registro,$clave,$nombre,$plaza,$sucursal,$salario,$jefe,$desc,$grupo);
            
            //se borran comisiones
            $insert->elimina_comision_puesto($registro);
            
            //si se realizo la eliminacion de las comisiones con exito luego se insertan las comisiones que quedaron
            if($insert->flag1 == '1'){
                if($coms != '0'){
                    foreach ($coms as $co){
                        $insert->agrega_com_puesto($registro, $co);
                    }
                    $insert->update.='1';
                }else{
                    $insert->update.='1';//se agrega aqui tambien por si no se agregaron comisiones intencionalmente
                }
            }
        }
        $insert->cierra_conexion("0");
        
        if($insert->update == '11'){
            echo '<script type="text/javascript">window.opener.genera();</script>';
            echo '<script type="text/javascript">
                    setTimeout("self.close();",4000);
                  </script>';
            echo 'Registro editado con exito!';
        }else {
            echo 'Error al editar el puesto';
            print_r($error);
            echo $insert->update;
        }
    }

?>