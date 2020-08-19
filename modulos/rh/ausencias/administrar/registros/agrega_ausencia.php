<?php
    include ('../../../../../config/cookie.php');
?>
<?php
    //Establece zona horaria
    date_default_timezone_set('America/Mexico_City');
    //Obtiene fecha y Hora
    $fecha=date("Y-m-d");
    $hora=date("H:i:s");
    session_start();
    $usid=$_SESSION['us_id'];//id del usuario
    $f=date("Ymd");
    $h=date("His");
    
    $op = base64_decode($_GET['op']);
    
    if($op == 'nuevo'){
        $error = array();
        $persona=$_POST['persona'];
        $tipoaus=$_POST['tipo_aus'];
        $year=$_POST['year'];
        $derecho=$_POST['derecho'];
        if(!isset($_POST['tomados']) || empty($_POST['tomados'])){
            $tomados = '0';
        }else if (isset($_POST['tomados']) || !empty($_POST['tomados'])) {
            $tomados = $_POST['tomados'];
        }
        $disp=$_POST['disp'];
        if(!isset($_POST['vac']) || empty($_POST['vac'])){
            $vac = '0';
        }else if (isset($_POST['vac']) || !empty($_POST['vac'])) {
            $vac = $_POST['vac'];
        }
        if(!isset($_POST['rest']) || empty($_POST['rest'])){
            $rest = '0';
        }else if (isset($_POST['rest']) || !empty($_POST['rest'])) {
            $rest = $_POST['rest'];
        }
        $diasa=$_POST['diasa'];
        if(!isset($_POST['diasa']) || empty($_POST['diasa'])){
            $diasa = '0';
        }else if (isset($_POST['diasa']) || !empty($_POST['diasa'])) {
            $diasa = $_POST['diasa'];
        }
        $finicio=$_POST['finicio'];
        $ffin=$_POST['ffin'];
        if(!isset($_POST['obs']) || empty($_POST['obs'])){
            $error[] = "observaciones";
        }else if (isset($_POST['obs']) || !empty($_POST['obs'])) {
            $obs= $_POST['obs'];
        }
        

        //datos de nuevo registro de ausencia
       
//        echo 'datos de nueva ausencia<br>';
//        echo 'Persona: '.$persona.'<br>';
//        echo 'Tipo ausencia: '.$tipoaus.'<br>';
//        echo 'Años: '.$year.'<br>';
//        echo 'Derecho: '.$derecho.'<br>';
//        echo 'Tomados: '.$tomados.'<br>';
//        echo 'Disponibles: '.$disp.'<br>';
//        echo 'Vacaciones: '.$vac.'<br>';
//        echo 'Restantes: '.$rest.'<br>';
//        echo 'Dias ausencias: '.$diasa.'<br>';
//        echo 'Fecha inicio: '.$finicio.'<br>';
//        echo 'Fecha fin: '.$ffin.'<br>';
//        echo 'Observaciones: '.$obs.'<br>';
     
        include '../../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
        }else{
            //limpia caenas
            $persona=$insert->limpia_cadena($persona);
            $tipoaus=$insert->limpia_cadena($tipoaus);
            $year=$insert->limpia_cadena($year);
            $derecho=$insert->limpia_cadena($derecho); 
            $tomados=$insert->limpia_cadena($tomados); 
            $disp=$insert->limpia_cadena($disp); 
            $vac=$insert->limpia_cadena($vac); 
            $rest=$insert->limpia_cadena($rest); 
            $diasa=$insert->limpia_cadena($diasa);
            //$finicio=$insert->limpia_cadena($finicio);
            //$ffin=$insert->limpia_cadena($ffin); 
                    
            //inserta datos
            $insert->agrega_ausencia($persona,$tipoaus,$year,$derecho,$tomados,$disp,$vac,$rest,$diasa,$finicio,$ffin,$obs,'0',$fecha,$hora,$usid,'0');
        }
        $insert->cierra_conexion("0");
        //Mensaje de confirmacion de registro guardado 
        if($insert->inserts == '1'){
            $insert->exito('../../../../../estilos/personasStyles.css');
        }else {
            echo 'Error al guardar';
            print_r($error);
        }
        
    }else if ($op == 'editar') {
        include '../../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");
        
        $error = array();
        $registro=$_POST['registro'];
        $persona=$_POST['persona'];
        $year=$_POST['year'];
        $derecho=$_POST['derecho'];
         if(!isset($_POST['tomados']) || empty($_POST['tomados'])){
            $tomados = '0';
        }else if (isset($_POST['tomados']) || !empty($_POST['tomados'])) {
            $tomados = $_POST['tomados'];
        }
        $disp=$_POST['disp'];
        if(!isset($_POST['vac']) || empty($_POST['vac'])){
            $vac = '0';
        }else if (isset($_POST['vac']) || !empty($_POST['vac'])) {
            $vac = $_POST['vac'];
        }
        if(!isset($_POST['rest']) || empty($_POST['rest'])){
            $rest = '0';
        }else if (isset($_POST['rest']) || !empty($_POST['rest'])) {
            $rest = $_POST['rest'];
        }
        $diasa=$_POST['diasa'];
        if(!isset($_POST['diasa']) || empty($_POST['diasa'])){
            $diasa = '0';
        }else if (isset($_POST['diasa']) || !empty($_POST['diasa'])) {
            $diasa = $_POST['diasa'];
        }
        $finicio=$_POST['finicio'];
        $ffin=$_POST['ffin'];
        if(!isset($_POST['obs']) || empty($_POST['obs'])){
            $error[] = "observaciones";
        }else if (isset($_POST['obs']) || !empty($_POST['obs'])) {
            $obs= $_POST['obs'];
        }
        
        
       //datos de nuevo registro de ausencia
       
//        echo 'datos de nueva ausencia<br>';
//        echo 'Registro: '.$registro.'<br>';
//        echo 'Persona: '.$persona.'<br>';
//        echo 'Tipo ausencia: '.$tipoaus.'<br>';
//        echo 'Años: '.$year.'<br>';
//        echo 'Derecho: '.$derecho.'<br>';
//        echo 'Tomados: '.$tomados.'<br>';
//        echo 'Disponibles: '.$disp.'<br>';
//        echo 'Vacaciones: '.$vac.'<br>';
//        echo 'Restantes: '.$rest.'<br>';
//        echo 'Dias ausencias: '.$diasa.'<br>';
//        echo 'Fecha inicio: '.$finicio.'<br>';
//        echo 'Fecha fin: '.$ffin.'<br>';
//        echo 'Observaciones: '.$obs.'<br>';
        

        if (sizeof($error)>0){
            echo 'El formulario tiene errores';
            print_r($error);
        }else{
            //limpia caenas
            $registro=$insert->limpia_cadena($registro);
            $persona=$insert->limpia_cadena($persona);
            $year=$insert->limpia_cadena($year);
            $derecho=$insert->limpia_cadena($derecho); 
            $tomados=$insert->limpia_cadena($tomados); 
            $disp=$insert->limpia_cadena($disp); 
            $vac=$insert->limpia_cadena($vac); 
            $rest=$insert->limpia_cadena($rest); 
            $diasa=$insert->limpia_cadena($diasa);
            //$finicio=$insert->limpia_cadena($finicio);
            //$ffin=$insert->limpia_cadena($ffin); 
            
            //echo $registro.'<br>'.$desc.'<br>'.$nombredoc.'<br>'.$fecha.'<br>'.$hora.'<br>'.$tipo_doc.'<br>';
            $insert->edita_ausencia($registro,$year,$derecho,$tomados,$disp,$vac,$rest,$diasa,$finicio,$ffin,$obs,$fecha,$hora,$usid);
                       
        }
        
        $insert->cierra_conexion("0");
        if($insert->update== '1'){
            $insert->exito('../../../../../estilos/personasStyles.css');
        }else {
            echo 'Error al editar la plaza';
            print_r($error);
        }
    }

?>