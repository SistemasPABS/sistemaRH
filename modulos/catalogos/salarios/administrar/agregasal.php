<?php
    include ('../../../../config/cookie.php');
?>
<?php
    
    $op = base64_decode($_GET['op']);
    //echo $op;
        
    if($op == 'nuevo'){
       
        $error = array();
        
        if(!isset($_POST['estatus'])){
            $chk_activo = '0';
        }else if(isset($_POST['estatus']) && $_POST['estatus'] == 'on'){
            $chk_activo = '1';
        }
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[] = 'nombre';
        }else if (isset($_POST['nombre']) || !empty($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }
        if(!isset($_POST['desc']) || empty($_POST['desc'])){
            $error[] = 'descripcion';
        }else if (isset($_POST['desc']) || !empty($_POST['desc'])) {
            $desc = $_POST['desc'];
        }
        if(!isset($_POST['monto']) || empty($_POST['monto'])){
            $error[] = 'monto';
        }else if (isset($_POST['monto']) || !empty($_POST['monto'])) {
            $monto = $_POST['monto'];
        }
        if(!isset($_POST['tipo_sal']) || $_POST['tipo_sal'] == '1000'){
            $error[]='tipo_salario';
        }else if(isset($_POST['tipo_sal']) || $_POST['tipo_sal'] != '1000'){
            $tiposal=$_POST['tipo_sal'];
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
//        echo 'datos de salarios<br>';
//        echo 'estatus: '.$chk_activo.'<br>';
//        echo 'Nombre: '.$nombre.'<br>';
//        echo 'Descripcion:'.$desc.'<br>';
//        echo 'Monto: '.$monto.'<br>';
//        echo 'Tipo salario: '.$tiposal.'<br>';
//        echo 'Plaza: '.$plaza.'<br>';
//        echo 'Sucursal: '.$sucursal.'</br>';
        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpa cadenas
            $nombre=$insert->limpia_cadena($nombre);
            $desc=$insert->limpia_cadena($desc);
            $monto=$insert->limpia_cadena($monto);
            $tiposal=$insert->limpia_cadena($tiposal);
            $plaza=$insert->limpia_cadena($plaza);
            $sucursal=$insert->limpia_cadena($sucursal);
            //inserta datos
            $insert->agrega_sal($nombre,$desc,$monto,$tiposal,$plaza,$sucursal,$chk_activo);
        }
        $insert->cierra_conexion("0");
        if($insert->inserts == '1'){
            $insert->exito('../../../../estilos/personasStyles.css');
        }else {
            echo 'Error al guardar el nuevo salario';
            print_r($error);
        }
    }else if ($op == 'editar') {
        $error = array();
        
        if(!isset($_POST['registro']) || empty($_POST['registro'])){
            $registro='';
        }else if(isset($_POST['registro']) || !empty($_POST['registro'])){
            $registro=$_POST['registro'];
        }
        if(!isset($_POST['estatus'])){
            $chk_activo = '0';
        }else if(isset($_POST['estatus']) && $_POST['estatus'] == 'on'){
            $chk_activo = '1';
        }
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[] = 'nombre';
        }else if (isset($_POST['nombre']) || !empty($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }
        if(!isset($_POST['desc']) || empty($_POST['desc'])){
            $error[] = 'descripcion';
        }else if (isset($_POST['desc']) || !empty($_POST['desc'])) {
            $desc = $_POST['desc'];
        }
        if(!isset($_POST['monto']) || empty($_POST['monto'])){
            $error[] = 'monto';
        }else if (isset($_POST['monto']) || !empty($_POST['monto'])) {
            $monto = $_POST['monto'];
        }
        if(!isset($_POST['tipo_sal']) || $_POST['tipo_sal'] == '1000'){
            $error[]='tipo_salario';
        }else if(isset($_POST['tipo_sal']) || $_POST['tipo_sal'] != '1000'){
            $tiposal=$_POST['tipo_sal'];
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
//        echo 'datos de salarios<br>';
//        echo 'estatus: '.$chk_activo.'<br>';
//        echo 'Nombre: '.$nombre.'<br>';
//        echo 'Descripcion:'.$desc.'<br>';
//        echo 'Monto: '.$monto.'<br>';
//        echo 'Tipo salario: '.$tiposal.'<br>';
//        echo 'Plaza: '.$plaza.'<br>';
//        echo 'Sucursal: '.$sucursal.'</br>';
        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpa cadenas
            $registro=$insert->limpia_cadena($registro);
            $nombre=$insert->limpia_cadena($nombre);
            $desc=$insert->limpia_cadena($desc);
            $monto=$insert->limpia_cadena($monto);
            $tiposal=$insert->limpia_cadena($tiposal);
            $plaza=$insert->limpia_cadena($plaza);
            $sucursal=$insert->limpia_cadena($sucursal);
            
            //inserta datos
            $insert->actualiza_sal($registro,$nombre,$desc,$monto,$tiposal,$plaza,$sucursal,$chk_activo);
        }
        $insert->cierra_conexion("0");
        if($insert->update== '1'){
            $insert->exito('../../../../estilos/personasStyles.css');
        }else {
            echo 'Error al editar el salario';
            print_r($error);
        }
    }

?>