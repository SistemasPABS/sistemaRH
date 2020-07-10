<?php
    //Cookie para validar permisos del usuario
    include ('../../../../config/cookie.php');
?>
<?php
    //Establece zona horaria
    date_default_timezone_set('America/Mexico_City');
    //Obtiene fecha y Hora
    $fecha=date("Ymd");
    $hora=date("H:i:s");
    //Decodifica opcion nuevo o editar
    $op = base64_decode($_GET['op']);
    //Validaciones de campos para contrato nuevo
    if($op == 'nuevo'){
        $error = array(); //ARRAY PARA ALMACENAR ERRORES       
        //Validaciones de campos seteados y no vacios 
        if(!isset($_POST['id_persona']) || empty($_POST['id_persona'])){
            $error[] = "id_persona";
        }else if (isset($_POST['id_persona']) || !empty($_POST['id_persona'])) {
            $id_persona = $_POST['id_persona'];
        }
        //Variable id del contrato
        if(!isset($_POST['id_contrato']) || empty($_POST['id_contrato'])){
            $error[] = "id_contrato";
        }else if (isset($_POST['id_contrato']) || !empty($_POST['id_contrato'])) {
            $id_contrato = $_POST['id_contrato'];
        }
        //variable id del puesto
        if(!isset($_POST['id_puesto']) || empty($_POST['id_puesto'])){
            $error[] = "id_puesto";
        }else if (isset($_POST['id_puesto']) || !empty($_POST['id_puesto'])) {
            $id_puesto = $_POST['id_puesto'];
        }
        //Variable id de la razon socil        
        if(!isset($_POST['id_razon']) || empty($_POST['id_razon'])){
            $error[] = "id_razon";
        }else if (isset($_POST['id_razon']) || !empty($_POST['id_razon'])) {
            $id_razon = $_POST['id_razon'];
        }
        //Variable de id del salario
        if(!isset($_POST['salario']) || empty($_POST['salario'])){
            $error[] = "salario";
        }else if (isset($_POST['salario']) || !empty($_POST['salario'])) {
            $salario = $_POST['salario'];
        }
        //variable de horario
        if(!isset($_POST['horario']) || empty($_POST['horario'])){
            $error[] = "horario";
        }else if (isset($_POST['horario']) || !empty($_POST['horario'])) {
            $horario = $_POST['horario'];
        }
        //variable de tiempo de prueba
        if(!isset($_POST['prueba']) || empty($_POST['prueba'])){
            $error[] = "prueba";
        }else if (isset($_POST['prueba']) || !empty($_POST['prueba'])) {
            $prueba = $_POST['prueba'];
        }
        //variable de fecha inicio de contrato
        if(!isset($_POST['fecha_ini']) || empty($_POST['fecha_ini'])){
            $error[] = "fecha_ini";
        }else if (isset($_POST['fecha_ini']) || !empty($_POST['fecha_ini'])) {
            $fecha_ini = $_POST['fecha_ini'];
        }
        //variable de fecha de fin de contrato
        if(!isset($_POST['fecha_fin']) || empty($_POST['fecha_fin'])){
            $fecha_fin = "";
        }else if (isset($_POST['fecha_fin']) || !empty($_POST['fecha_fin'])) {
            $fecha_fin = $_POST['fecha_fin'];
        }
        //variable status
        if(!isset($_POST['status'])){
        $status='0';
        }else if(isset($_POST['status']) && $_POST['status'] == 'on'){
            $status='1';
        }
        //variable status
        if(!isset($_POST['adic'])){
            $adic='0';
        }else if(isset($_POST['adic']) && $_POST['adic'] == 'on'){
            $adic='1';
        }
 
        // datos de puestos
//        echo 'datos del Contrato<br>';
//        echo 'id_Persona: '.$id_persona.'<br>';
//        echo 'Contrato Tipo: '.$id_contrato.'<br>';
//        echo 'Puesto: '.$id_puesto.'<br>';
//        echo 'Razon: '.$id_razon.'<br>';
//        echo 'Salario:'.$salario.'<br>';
//        echo 'Horario: '.$horario.'<br>';
//        echo 'Periodo: '.$prueba.'<br>';
//        echo 'Fecha Inicial: '.$fecha_ini.'<br>';
//        echo 'Fecha Fin: '.$fecha_fin.'<br>';
//        echo 'Estatus: '.$status.'<br>';
//        echo 'Estatus: '.$adic.'<br>'; 
        
        //Conexion a la base de datos
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");
        //valida que el array de errores este vacio
        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //Limpia las cadenas de valores de simbolos especiales
            $id_persona=$insert->limpia_cadena($id_persona);
            $id_contrato=$insert->limpia_cadena($id_contrato);
            $id_puesto=$insert->limpia_cadena($id_puesto);
            $id_razon=$insert->limpia_cadena($id_razon);
            $salario=$insert->limpia_cadena($salario);
            $horario=$insert->limpia_cadena($horario);
            $prueba=$insert->limpia_cadena($prueba);
            $fecha_fin=$insert->limpia_cadena($fecha_fin);
            $fecha_ini=$insert->limpia_cadena($fecha_ini);
            $status=$insert->limpia_cadena($status);
            $adic=$insert->limpia_cadena($adic);
            //inserta datos
            $insert->agrega_contrato($id_persona, $id_contrato, $id_razon, $id_puesto, $salario, $horario, $prueba, $adic, $fecha_ini,$fecha_fin, $status);
           
        }
        $insert->cierra_conexion("0");
        //Valida si la incercion se realizo correctamente
        if($insert->inserts == '1'){
            $insert->exito('../../../../estilos/personasStyles.css');
        }else {
            //Si existe error imprime el array de errores
            echo 'Error al guardar el contrato';
            print_r($error);
        }
        
    }else if ($op == 'editar') {
        
        $error = array(); //ARRAY PARA ALMACENAR ERRORES       
        //Validaciones de campos seteados y no vacios 
        //Validaciones de campos seteados y no vacios 
        if(!isset($_POST['registro']) || empty($_POST['registro'])){
            $error[] = "registro";
        }else if (isset($_POST['registro']) || !empty($_POST['registro'])) {
            $registro = $_POST['registro'];
        }
        if(!isset($_POST['id_persona']) || empty($_POST['id_persona'])){
            $error[] = "id_persona";
        }else if (isset($_POST['id_persona']) || !empty($_POST['id_persona'])) {
            $id_persona = $_POST['id_persona'];
        }
        //Variable id del contrato
        if(!isset($_POST['id_contrato']) || empty($_POST['id_contrato'])){
            $error[] = "id_contrato";
        }else if (isset($_POST['id_contrato']) || !empty($_POST['id_contrato'])) {
            $id_contrato = $_POST['id_contrato'];
        }
        //variable id del puesto
        if(!isset($_POST['id_puesto']) || empty($_POST['id_puesto'])){
            $error[] = "id_puesto";
        }else if (isset($_POST['id_puesto']) || !empty($_POST['id_puesto'])) {
            $id_puesto = $_POST['id_puesto'];
        }
        //Variable id de la razon socil        
        if(!isset($_POST['id_razon']) || empty($_POST['id_razon'])){
            $error[] = "id_razon";
        }else if (isset($_POST['id_razon']) || !empty($_POST['id_razon'])) {
            $id_razon = $_POST['id_razon'];
        }
        //Variable de id del salario
        if(!isset($_POST['salario']) || empty($_POST['salario'])){
            $error[] = "salario";
        }else if (isset($_POST['salario']) || !empty($_POST['salario'])) {
            $salario = $_POST['salario'];
        }
        //variable de horario
        if(!isset($_POST['horario']) || empty($_POST['horario'])){
            $error[] = "horario";
        }else if (isset($_POST['horario']) || !empty($_POST['horario'])) {
            $horario = $_POST['horario'];
        }
        //variable de tiempo de prueba
        if(!isset($_POST['prueba']) || empty($_POST['prueba'])){
            $error[] = "prueba";
        }else if (isset($_POST['prueba']) || !empty($_POST['prueba'])) {
            $prueba = $_POST['prueba'];
        }
        //variable de fecha inicio de contrato
        if(!isset($_POST['fecha_ini']) || empty($_POST['fecha_ini'])){
            $error[] = "fecha_ini";
        }else if (isset($_POST['fecha_ini']) || !empty($_POST['fecha_ini'])) {
            $fecha_ini = $_POST['fecha_ini'];
        }
        //variable de fecha de fin de contrato
        if(!isset($_POST['fecha_fin']) || empty($_POST['fecha_fin'])){
            $fecha_fin = "";
        }else if (isset($_POST['fecha_fin']) || !empty($_POST['fecha_fin'])) {
            $fecha_fin = $_POST['fecha_fin'];
        }
        //variable status
        if(!isset($_POST['status'])){
            $status='0';
        }else if(isset($_POST['status']) && $_POST['status'] == 'on'){
            $status='1';
        }
        //variable status
        if(!isset($_POST['adic'])){
            $adic='0';
        }else if(isset($_POST['adic']) && $_POST['adic'] == 'on'){
            $adic='1';
        }
 
        // datos de puestos
//        echo 'datos del Contrato<br>';
//        echo 'contrato: '.$registro.'<br>';
//        echo 'id_Persona: '.$id_persona.'<br>';
//        echo 'Contrato Tipo: '.$id_contrato.'<br>';
//        echo 'Puesto: '.$id_puesto.'<br>';
//        echo 'Razon: '.$id_razon.'<br>';
//        echo 'Plaza: '.$id_plaza.'<br>';
//        echo 'Salario:'.$salario.'<br>';
//        echo 'Horario: '.$horario.'<br>';
//        echo 'Periodo: '.$prueba.'<br>';
//        echo 'Fecha Inicial: '.$fecha_ini.'<br>';
//        echo 'Fecha Fin: '.$fecha_fin.'<br>';
//        echo 'Estatus: '.$status.'<br>';
//        echo 'Estatus: '.$adic.'<br>'; 

        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");
        //valida que el array no contenga errores
        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia cadenas de caracteres especiales
            $registro=$insert->limpia_cadena($registro);
            $id_persona=$insert->limpia_cadena($id_persona);
            $id_contrato=$insert->limpia_cadena($id_contrato);
            $id_puesto=$insert->limpia_cadena($id_puesto);
            $id_razon=$insert->limpia_cadena($id_razon);
            $salario=$insert->limpia_cadena($salario);
            $horario=$insert->limpia_cadena($horario);
            $prueba=$insert->limpia_cadena($prueba);
            $fecha_fin=$insert->limpia_cadena($fecha_fin);
            $fecha_ini=$insert->limpia_cadena($fecha_ini);
            $status=$insert->limpia_cadena($status);
            $adic=$insert->limpia_cadena($adic);       
            //inserta datos
            $insert->edita_contrato($registro,$id_persona, $id_contrato, $id_razon, $id_puesto, $salario, $horario, $prueba, $adic, $fecha_ini,$fecha_fin, $status);
        }

        $insert->cierra_conexion("0");
        //Valida que el update se realizo con exito
        if($insert->update == '1'){
            $insert->exito('../../../../estilos/personasStyles.css');
        }else {
            //imprime el array de errores
            echo 'Error al editar el contrato';
            print_r($error);
            echo $insert->update;
        }
    }

?>