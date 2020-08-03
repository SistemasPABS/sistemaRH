<?php
include ('../../../../config/cookie.php');
?>
<?php
    session_start();
    $usid=$_SESSION['us_id'];
    date_default_timezone_set('America/Mexico_City');
    $fecha=date("Ymd");
    $hora=date("H:i:s");
    $op= base64_decode($_GET['op']);
    
    if($op == 'nuevo'){
    
        //Datos para Insert en la tabla persona
        $error=array();
        //variable status
        if(!isset($_POST['status'])){
            $status='0';
        }else if(isset($_POST['status']) && $_POST['status'] == 'on'){
            $status='1';
        }
        //variable id(registro)
        if(!isset($_POST['registro']) || empty($_POST['registro'])){
            $registro='';
        }else if(isset($_POST['registro']) || !empty($_POST['registro'])){
            $registro=$_POST['registro'];
        }
        //variable clave
        if(!isset($_POST['clave']) || empty($_POST['clave'])){
            $error[]='clave';
        }else if(isset($_POST['clave']) || !empty($_POST['clave'])){
            $clave=$_POST['clave'];
        }
        //variable nombre
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[]='nombre';
        }else if(isset($_POST['nombre']) || !empty($_POST['nombre'])){
            $nombre=$_POST['nombre'];
        }
        //variable paterno
        if(!isset($_POST['paterno']) || empty($_POST['paterno'])){
            $error[]='paterno';
        }else if(isset($_POST['paterno']) || !empty($_POST['paterno'])){
            $paterno=$_POST['paterno'];
        }
        //variable materno
        if(!isset($_POST['materno']) || empty($_POST['materno'])){
            $error[]='materno';
        }else if(isset($_POST['materno']) || !empty($_POST['materno'])){
            $materno=$_POST['materno'];
        }
        //variable rfc
        if(!isset($_POST['rfc']) || empty($_POST['rfc'])){
            $error[]='rfc';
        }else if(isset($_POST['rfc']) || !empty($_POST['rfc'])){
            $rfc=$_POST['rfc'];
        }
        //variable nss
        if(!isset($_POST['nss']) || empty($_POST['nss'])){
            $error[]='nss';
        }else if(isset($_POST['nss']) || !empty($_POST['nss'])){
            $nss=$_POST['nss'];
        }
        //variable curp
        if(!isset($_POST['curp']) || empty($_POST['curp'])){
            $error[]='curp';
        }else if(isset($_POST['curp']) || !empty($_POST['curp'])){
            $curp=$_POST['curp'];
        }
        //variable genero
        if(!isset($_POST['genero']) || $_POST['genero'] == '1000'){
            $error[]='genero';
        }else if(isset($_POST['genero']) || $_POST['genero'] != '1000'){
            $genero=$_POST['genero'];
        }
        //Variables de Direccion
        //Calle
        if(!isset($_POST['calle']) || empty($_POST['calle'])){
            $error[]='calle';
        }else if(isset($_POST['calle']) || !empty($_POST['calle'])){
            $calle=$_POST['calle'];
        }
        //Numero
         if(!isset($_POST['numero']) || empty($_POST['numero'])){
            $error[]='numero';
        }else if(isset($_POST['numero']) || !empty($_POST['numero'])){
            $numero=$_POST['numero'];
        }
        //Colonia
         if(!isset($_POST['colonia']) || empty($_POST['colonia'])){
            $error[]='colonia';
        }else if(isset($_POST['colonia']) || !empty($_POST['colonia'])){
            $colonia=$_POST['colonia'];
        }
        //Cp
         if(!isset($_POST['cp']) || empty($_POST['cp'])){
            $error[]='cp';
        }else if(isset($_POST['cap']) || !empty($_POST['cp'])){
            $cp=$_POST['cp'];
        }
        //variable fecha_nac
        if(!isset($_POST['fecha_nac']) || empty($_POST['fecha_nac'])){
            $error[]='fecha_nac';
        }else if(isset($_POST['fecha_nac']) || !empty($_POST['fecha_nac'])){
            $fecha_nac =$_POST['fecha_nac'];
        }
        //variable de estado civil
        if(!isset($_POST['civil']) || empty($_POST['civil'])){
            $error[]='civil';
        }else if(isset($_POST['civil']) || !empty($_POST['civil'])){
            $civil=$_POST['civil'];
        }
        //variable de edad
       if(!isset($_POST['edad']) || empty($_POST['edad'])){
            $error[]='edad';
        }else if(isset($_POST['edad']) || !empty($_POST['edad'])){
            $edad=$_POST['edad'];
        }
        //variable de Afore
        $afore=$_POST['afore'];
        //variable de no de credito infonavit
        $creinfo=$_POST['creinfo'];
        //variable telefono
        if(!isset($_POST['telefono']) || empty($_POST['telefono'])){
            $error[]='telefono';
        }else if(isset($_POST['telefono']) || !empty($_POST['telefono'])){
            $telefono=$_POST['telefono'];
        }
        //variable celular
        if(!isset($_POST['celular']) || empty($_POST['celular'])){
            $error[]='celular';
        }else if(isset($_POST['celular']) || !empty($_POST['celular'])){
            $celular=$_POST['celular'];
        }
        //variable correo
        if(!isset($_POST['correo']) || empty($_POST['correo'])){
            $error[]='correo';
        }else if(isset($_POST['correo']) || !empty($_POST['correo'])){
            $correo=$_POST['correo'];
        }
        //variable pais
        if(!isset($_POST['nacionalidad']) || $_POST['nacionalidad'] == "1000"){
            $error[]='nacionalidad';
        }else if(isset($_POST['nacionalidad']) || $_POST['nacionalidad'] != "1000"){
            $nacionalidad=$_POST['nacionalidad'];
        }
        //variable pais
        if(!isset($_POST['pais']) || $_POST['pais'] == "1000"){
            $error[]='pais';
        }else if(isset($_POST['pais']) || $_POST['pais'] != "1000"){
            $pais=$_POST['pais'];
        }
        //variable estados
        if(!isset($_POST['estados']) || $_POST['estados'] == "1000"){
            $error[]='estados';
        }else if(isset($_POST['estados']) || $_POST['estados'] != "1000"){
            $estado=$_POST['estados'];
        }
        //variable municipios
        if(!isset($_POST['municipios']) || $_POST['municipios'] == "1000"){
            $error[]='municipios';
        }else if(isset($_POST['municipios']) || $_POST['municipios'] != "1000"){
            $municipio=$_POST['municipios'];
        }

        //Datos para insert en la tabla databank
        //variable banco
        if(!isset($_POST['banco']) || $_POST['banco'] == '1000'){
            $error[]='banco';
        }else if(isset($_POST['banco']) || $_POST['banco'] != '1000'){
            $banco=$_POST['banco'];
        }
        //variable clave bancaria
        if(!isset($_POST['clavebanco']) || empty($_POST['clavebanco'])){
            $error[]='clavebanco';
        }else if(isset($_POST['clavebanco']) || !empty($_POST['clavebanco'])){
            $clavebanco=$_POST['clavebanco'];
        }
        //variable cuenta
        if(!isset($_POST['cuenta']) || empty($_POST['cuenta'])){
            $error[]='cuenta';
        }else if(isset($_POST['cuenta']) || !empty($_POST['cuenta'])){
            $cuenta=$_POST['cuenta'];
        }

        //Datos para insertar en la tabla de documentos
        //variable chk_ine
        if(!isset($_POST['chk_ine'])){
            $chk_ine='0';
        }else if(isset($_POST['chk_ine']) && $_POST['chk_ine'] == 'on'){
            $chk_ine='1';
        }
        //variable chk_acta
        if(!isset($_POST['chk_acta'])){
            $chk_acta='0';
        }else if(isset($_POST['chk_acta']) && $_POST['chk_acta'] == 'on'){
            $chk_acta='1';
        }
        //variable chk_comp
        if(!isset($_POST['chk_comp'])){
            $chk_comp='0';
        }else if(isset($_POST['chk_comp']) && $_POST['chk_comp'] == 'on'){
            $chk_comp='1';
        }
        //variable chk_certificado
        if(!isset($_POST['chk_certificado'])){
            $chk_certificado='0';
        }else if(isset($_POST['chk_certificado']) && $_POST['chk_certificado'] == 'on'){
            $chk_certificado='1';
        }
        //variable chk_curp
        if(!isset($_POST['chk_curp'])){
            $chk_curp='0';
        }else if(isset($_POST['chk_curp']) && $_POST['chk_curp'] == 'on'){
            $chk_curp='1';
        }
        //variable chk_rfc
        if(!isset($_POST['chk_rfc'])){
            $chk_rfc='0';
        }else if(isset($_POST['chk_rfc']) && $_POST['chk_rfc'] == 'on'){
            $chk_rfc='1';
        }
        //variable chk_nss
        if(!isset($_POST['chk_nss'])){
            $chk_nss='0';
        }else if(isset($_POST['chk_nss']) && $_POST['chk_nss'] == 'on'){
            $chk_nss='1';
        }
        //variable chk_licencia
        if(!isset($_POST['chk_licencia'])){
            $chk_licencia='0';
        }else if(isset($_POST['chk_licencia']) && $_POST['chk_licencia'] == 'on'){
            $chk_licencia='1';
        }
        //variable chk_recomendacion
        if(!isset($_POST['chk_recomendacion'])){
            $chk_recomendacion='0';
        }else if(isset($_POST['chk_recomendacion']) && $_POST['chk_recomendacion'] == 'on'){
            $chk_recomendacion='1';
        }
        //variable chk_antecedentes
        if(!isset($_POST['chk_antecedentes'])){
            $chk_antecedentes='0';
        }else if(isset($_POST['chk_antecedentes']) && $_POST['chk_antecedentes'] == 'on'){
            $chk_antecedentes='1';
        }
        //variable chk_fonacot
        if(!isset($_POST['chk_fonacot'])){
            $chk_fonacot='0';
        }else if(isset($_POST['chk_fonacot']) && $_POST['chk_fonacot'] == 'on'){
            $chk_fonacot='1';
        }
        //variable chk_infonavit
        if(!isset($_POST['chk_infonavit'])){
            $chk_infonavit='0';
        }else if(isset($_POST['chk_infonavit']) && $_POST['chk_infonavit'] == 'on'){
            $chk_infonavit='1';
        }
        
        //datos generales
    //    echo 'datos generales<br>';
    //    echo 'estatus: '.$status.'<br>';
    //    echo 'clave: '.$clave.'<br>';
    //    echo 'nombre: '.$nombre.'<br>';
    //    echo 'appellido paterno: '.$paterno.'<br>';
    //    echo 'apellido materno: '.$materno.'<br>';
    //    echo 'rfc: '.$rfc.'<br>'; 
    //    echo 'nss: '.$nss.'<br>';
    //    echo 'curp'.$curp.'<br>';
    //    echo 'genero: '.$genero.'<br>';
    //    echo 'calle: '.$calle.'<br>';
    //    echo 'numero: '.$numero.'<br>';
    //    echo 'colonia: '.$colonia.'<br>';
    //    echo 'cp: '.$cp.'<br>';    
    //    echo 'fecha de nacimiento: '.$fecha_nac.'<br>';
    //    echo 'Estado civil: '.$civil.'<br>';
    //    echo 'Edad: '.$edad.'<br>';
    //    echo 'telefono: '.$telefono.'<br>';
    //    echo 'celular'.$celular.'<br>';
    //    echo 'correo: '.$correo.'<br>';
    //    echo 'nacionalidad:'.$nacionalidad.'<br>';
    //    echo 'pais:'.$pais.'<br>';
    //    echo 'estado:'.$estado.'<br>';
    //    echo 'municipio:'.$municipio.'<br>';
    //    echo '<br>';
    //    //Datos para insert en la tabla databank
    //    echo 'datos bancarios<br>';
    //    echo 'banco: '.$banco.'<br>';
    //    echo 'clave bancaria: '.$clavebanco.'<br>';
    //    echo 'cuenta: '.$cuenta.'<br>';
    //    echo '<br>';
    //    //Datos para insertar en la tabla de documentos
    //    echo 'documentos entregados<br>';
    //    echo 'chk ine: '.$chk_ine.'<br>';
    //    echo 'chk acta: '.$chk_acta.'<br>';
    //    echo 'chk comprobante: '.$chk_comp.'<br>';
    //    echo 'chk certificado: '.$chk_certificado.'<br>';
    //    echo 'chk curp: '.$chk_curp.'<br>';
    //    echo 'chk rfc: '.$chk_rfc.'<br>';
    //    echo 'chk nss: '.$chk_nss.'<br>';
    //    echo 'chk licencia: '.$chk_licencia.'<br>';
    //    echo 'chk recomendacion: '.$chk_recomendacion.'<br>';
    //    echo 'chk antecedentes: '.$chk_antecedentes.'<br>';
    //    echo 'chk fonacot: '.$chk_fonacot.'<br>';        
    //    echo 'chk infonavit: '.$chk_infonavit.'<br>';
    //    echo '<br>';
        
        include '../../../../config/conectasql.php';
        $insert = new conectasql();
        $insert->abre_conexion("0");

        //se valida que  no exista la clave para el empleado nuevo
        $insert->valida_nueva_persona($clave);
        $msj=$insert->msj;
        if($msj == 1){
            $error[]='clave existe';
        }
        //se validan errores en general
        if(sizeof($error)>0){
            //sustituir por mensaje html para mostrar error de datos
            echo 'El formulario tiene errores<br>';
        } else {
            //se limpian los variables que provienen de input, en busca de simbolos raros
            $clave=$insert->limpia_cadena($clave);
            $nombre=$insert->limpia_cadena($nombre);
            $paterno=$insert->limpia_cadena($paterno);
            $materno=$insert->limpia_cadena($materno);
            $calle=$insert->limpia_cadena($calle);
            $numero=$insert->limpia_cadena($numero);
            $colonia=$insert->limpia_cadena($colonia);
            $cp=$insert->limpia_cadena($cp);
            $pais=$insert->limpia_cadena($pais);
            $estado=$insert->limpia_cadena($estado);
            $municipio=$insert->limpia_cadena($municipio);
            $nacionalidad=$insert->limpia_cadena($nacionalidad);
            $rfc=$insert->limpia_cadena($rfc);
            $nss=$insert->limpia_cadena($nss);
            $curp=$insert->limpia_cadena($curp);
            $genero=$insert->limpia_cadena($genero);
            $correo=$insert->limpia_cadena($correo);
            $telefono=$insert->limpia_cadena($telefono);
            $celular=$insert->limpia_cadena($celular);
            $fecha_nac=$insert->limpia_cadena($fecha_nac);
            $banco=$insert->limpia_cadena($banco);
            $clavebanco=$insert->limpia_cadena($clavebanco);
            $cuenta=$insert->limpia_cadena($cuenta);
            $edad=$insert->limpia_cadena($edad);
            if($afore != null){$afore=$insert->limpia_cadena($afore);}
            if($creinfo != null){$creinfo=$insert->limpia_cadena($creinfo);}
            $civil=$insert->limpia_cadena($civil);
            $insert->generales_personas($clave,$nombre,$paterno,$materno,$calle,$numero,$colonia,$cp,$pais,$estado,$municipio,$nacionalidad,$rfc,$nss,$curp,$genero,$correo,$telefono,$celular,$fecha_nac,$fecha,$hora,$status, $edad, $civil,$usid,'','',0,$afore,$creinfo);
            //echo 'el id es:'.$insert->npid.'<br>';
            $insert->banco_personas($banco,$insert->npid,$clavebanco,$cuenta);
            $insert->docs_personas($insert->npid,$chk_comp,$chk_ine,$chk_licencia,$chk_acta,$chk_rfc,$chk_nss,$chk_curp,$chk_certificado,$chk_recomendacion,$chk_antecedentes,$chk_fonacot,$chk_infonavit); 
        }
        if($insert->inserts == '111'){
            $insert->exito('../../../../estilos/personasStyles.css');
        }else{
            echo 'Error insertando nuevo registro: ';
            print_r($error);
        }

        $insert->cierra_conexion("0");
        
    }else if($op == 'editar'){
        
        //Datos para Insert en la tabla persona
        $error=array();
        //variable status
        if(!isset($_POST['status'])){
            $status='0';
        }else if(isset($_POST['status']) && $_POST['status'] == 'on'){
            $status='1';
        }
        //variable id(registro)
        if(!isset($_POST['registro']) || empty($_POST['registro'])){
            $registro='';
        }else if(isset($_POST['registro']) || !empty($_POST['registro'])){
            $registro=$_POST['registro'];
        }
        //variable clave
        if(!isset($_POST['clave']) || empty($_POST['clave'])){
            $error[]='clave';
        }else if(isset($_POST['clave']) || !empty($_POST['clave'])){
            $clave=$_POST['clave'];
        }
        //variable nombre
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            $error[]='nombre';
        }else if(isset($_POST['nombre']) || !empty($_POST['nombre'])){
            $nombre=$_POST['nombre'];
        }
        //variable paterno
        if(!isset($_POST['paterno']) || empty($_POST['paterno'])){
            $error[]='paterno';
        }else if(isset($_POST['paterno']) || !empty($_POST['paterno'])){
            $paterno=$_POST['paterno'];
        }
        //variable materno
        if(!isset($_POST['materno']) || empty($_POST['materno'])){
            $error[]='materno';
        }else if(isset($_POST['materno']) || !empty($_POST['materno'])){
            $materno=$_POST['materno'];
        }
        //variable rfc
        if(!isset($_POST['rfc']) || empty($_POST['rfc'])){
            $error[]='rfc';
        }else if(isset($_POST['rfc']) || !empty($_POST['rfc'])){
            $rfc=$_POST['rfc'];
        }
        //variable nss
        if(!isset($_POST['nss']) || empty($_POST['nss'])){
            $error[]='nss';
        }else if(isset($_POST['nss']) || !empty($_POST['nss'])){
            $nss=$_POST['nss'];
        }
        //variable curp
        if(!isset($_POST['curp']) || empty($_POST['curp'])){
            $error[]='curp';
        }else if(isset($_POST['curp']) || !empty($_POST['curp'])){
            $curp=$_POST['curp'];
        }
        //variable genero
        if(!isset($_POST['genero']) || $_POST['genero'] == '1000'){
            $error[]='genero';
        }else if(isset($_POST['genero']) || $_POST['genero'] != '1000'){
            $genero=$_POST['genero'];
        }
        //Variables de Direccion
        //Calle
        if(!isset($_POST['calle']) || empty($_POST['calle'])){
            $error[]='calle';
        }else if(isset($_POST['calle']) || !empty($_POST['calle'])){
            $calle=$_POST['calle'];
        }
        //Numero
         if(!isset($_POST['numero']) || empty($_POST['numero'])){
            $error[]='numero';
        }else if(isset($_POST['numero']) || !empty($_POST['numero'])){
            $numero=$_POST['numero'];
        }
        //Colonia
         if(!isset($_POST['colonia']) || empty($_POST['colonia'])){
            $error[]='colonia';
        }else if(isset($_POST['colonia']) || !empty($_POST['colonia'])){
            $colonia=$_POST['colonia'];
        }
        //Cp
         if(!isset($_POST['cp']) || empty($_POST['cp'])){
            $error[]='cp';
        }else if(isset($_POST['cap']) || !empty($_POST['cp'])){
            $cp=$_POST['cp'];
        }
        //variable fecha_nac
        if(!isset($_POST['fecha_nac']) || empty($_POST['fecha_nac'])){
            $error[]='fecha_nac';
        }else if(isset($_POST['fecha_nac']) || !empty($_POST['fecha_nac'])){
            $fecha_nac =$_POST['fecha_nac'];
        }
        //variable de estado civil
        if(!isset($_POST['civil']) || empty($_POST['civil'])){
            $error[]='civil';
        }else if(isset($_POST['civil']) || !empty($_POST['civil'])){
            $civil=$_POST['civil'];
        }
        //variable de edad
       if(!isset($_POST['edad']) || empty($_POST['edad'])){
            $error[]='edad';
        }else if(isset($_POST['edad']) || !empty($_POST['edad'])){
            $edad=$_POST['edad'];
        }
        //variable de Afore
        $afore=$_POST['afore'];
        //variable de no de credito infonavit
        $creinfo=$_POST['creinfo'];
        //variable telefono
        if(!isset($_POST['telefono']) || empty($_POST['telefono'])){
            $error[]='telefono';
        }else if(isset($_POST['telefono']) || !empty($_POST['telefono'])){
            $telefono=$_POST['telefono'];
        }
        //variable celular
        if(!isset($_POST['celular']) || empty($_POST['celular'])){
            $error[]='celular';
        }else if(isset($_POST['celular']) || !empty($_POST['celular'])){
            $celular=$_POST['celular'];
        }
        //variable correo
        if(!isset($_POST['correo']) || empty($_POST['correo'])){
            $error[]='correo';
        }else if(isset($_POST['correo']) || !empty($_POST['correo'])){
            $correo=$_POST['correo'];
        }
        //variable pais
        if(!isset($_POST['nacionalidad']) || $_POST['nacionalidad'] == "1000"){
            $error[]='nacionalidad';
        }else if(isset($_POST['nacionalidad']) || $_POST['nacionalidad'] != "1000"){
            $nacionalidad=$_POST['nacionalidad'];
        }
        //variable pais
        if(!isset($_POST['pais']) || $_POST['pais'] == "1000"){
            $error[]='pais';
        }else if(isset($_POST['pais']) || $_POST['pais'] != "1000"){
            $pais=$_POST['pais'];
        }
        //variable estados
        if(!isset($_POST['estados']) || $_POST['estados'] == "1000"){
            $error[]='estados';
        }else if(isset($_POST['estados']) || $_POST['estados'] != "1000"){
            $estado=$_POST['estados'];
        }
        //variable municipios
        if(!isset($_POST['municipios']) || $_POST['municipios'] == "1000"){
            $error[]='municipios';
        }else if(isset($_POST['municipios']) || $_POST['municipios'] != "1000"){
            $municipio=$_POST['municipios'];
        }

        //Datos para insert en la tabla databank
        //variable banco
        if(!isset($_POST['banco']) || $_POST['banco'] == '1000'){
            $error[]='banco';
        }else if(isset($_POST['banco']) || $_POST['banco'] != '1000'){
            $banco=$_POST['banco'];
        }
        //variable clave bancaria
        if(!isset($_POST['clavebanco']) || empty($_POST['clavebanco'])){
            $error[]='clavebanco';
        }else if(isset($_POST['clavebanco']) || !empty($_POST['clavebanco'])){
            $clavebanco=$_POST['clavebanco'];
        }
        //variable cuenta
        if(!isset($_POST['cuenta']) || empty($_POST['cuenta'])){
            $error[]='cuenta';
        }else if(isset($_POST['cuenta']) || !empty($_POST['cuenta'])){
            $cuenta=$_POST['cuenta'];
        }

        //Datos para insertar en la tabla de documentos
        //variable chk_ine
        if(!isset($_POST['chk_ine'])){
            $chk_ine='0';
        }else if(isset($_POST['chk_ine']) && $_POST['chk_ine'] == 'on'){
            $chk_ine='1';
        }
        //variable chk_acta
        if(!isset($_POST['chk_acta'])){
            $chk_acta='0';
        }else if(isset($_POST['chk_acta']) && $_POST['chk_acta'] == 'on'){
            $chk_acta='1';
        }
        //variable chk_comp
        if(!isset($_POST['chk_comp'])){
            $chk_comp='0';
        }else if(isset($_POST['chk_comp']) && $_POST['chk_comp'] == 'on'){
            $chk_comp='1';
        }
        //variable chk_certificado
        if(!isset($_POST['chk_certificado'])){
            $chk_certificado='0';
        }else if(isset($_POST['chk_certificado']) && $_POST['chk_certificado'] == 'on'){
            $chk_certificado='1';
        }
        //variable chk_curp
        if(!isset($_POST['chk_curp'])){
            $chk_curp='0';
        }else if(isset($_POST['chk_curp']) && $_POST['chk_curp'] == 'on'){
            $chk_curp='1';
        }
        //variable chk_rfc
        if(!isset($_POST['chk_rfc'])){
            $chk_rfc='0';
        }else if(isset($_POST['chk_rfc']) && $_POST['chk_rfc'] == 'on'){
            $chk_rfc='1';
        }
        //variable chk_nss
        if(!isset($_POST['chk_nss'])){
            $chk_nss='0';
        }else if(isset($_POST['chk_nss']) && $_POST['chk_nss'] == 'on'){
            $chk_nss='1';
        }
        //variable chk_licencia
        if(!isset($_POST['chk_licencia'])){
            $chk_licencia='0';
        }else if(isset($_POST['chk_licencia']) && $_POST['chk_licencia'] == 'on'){
            $chk_licencia='1';
        }
        //variable chk_recomendacion
        if(!isset($_POST['chk_recomendacion'])){
            $chk_recomendacion='0';
        }else if(isset($_POST['chk_recomendacion']) && $_POST['chk_recomendacion'] == 'on'){
            $chk_recomendacion='1';
        }
        //variable chk_antecedentes
        if(!isset($_POST['chk_antecedentes'])){
            $chk_antecedentes='0';
        }else if(isset($_POST['chk_antecedentes']) && $_POST['chk_antecedentes'] == 'on'){
            $chk_antecedentes='1';
        }
        //variable chk_fonacot
        if(!isset($_POST['chk_fonacot'])){
            $chk_fonacot='0';
        }else if(isset($_POST['chk_fonacot']) && $_POST['chk_fonacot'] == 'on'){
            $chk_fonacot='1';
        }
        //variable chk_infonavit
        if(!isset($_POST['chk_infonavit'])){
            $chk_infonavit='0';
        }else if(isset($_POST['chk_infonavit']) && $_POST['chk_infonavit'] == 'on'){
            $chk_infonavit='1';
        }    
        //datos generales
//        echo 'datos generales<br>';
//        echo 'estatus: '.$status.'<br>';
//        echo 'registro:'.$registro.'<br>';
//        echo 'clave: '.$clave.'<br>';
//        echo 'nombre: '.$nombre.'<br>';
//        echo 'appellido paterno: '.$paterno.'<br>';
//        echo 'apellido materno: '.$materno.'<br>';
//        echo 'rfc: '.$rfc.'<br>'; 
//        echo 'nss: '.$nss.'<br>';
//        echo 'curp'.$curp.'<br>';
//        echo 'genero: '.$genero.'<br>';
//        echo 'calle: '.$calle.'<br>';
//        echo 'numero: '.$numero.'<br>';
//        echo 'colonia: '.$colonia.'<br>';
//        echo 'cp: '.$cp.'<br>';    
//        echo 'fecha de nacimiento: '.$fecha_nac.'<br>';
//        echo 'Edad: '.$edad.'<br>';
//        echo 'Edad: '.$civil.'<br>';
//        echo 'telefono: '.$telefono.'<br>';
//        echo 'celular'.$celular.'<br>';
//        echo 'correo: '.$correo.'<br>';
//        echo 'nacionalidad:'.$nacionalidad.'<br>';
//        echo 'pais:'.$pais.'<br>';
//        echo 'estado:'.$estado.'<br>';
//        echo 'municipio:'.$municipio.'<br>';
//        echo '<br>';
//        //Datos para insert en la tabla databank
//        echo 'datos bancarios<br>';
//        echo 'banco: '.$banco.'<br>';
//        echo 'clave bancaria: '.$clavebanco.'<br>';
//        echo 'cuenta: '.$cuenta.'<br>';
//        echo '<br>';
//        //Datos para insertar en la tabla de documentos
//        echo 'documentos entregados<br>';
//        echo 'chk ine: '.$chk_ine.'<br>';
//        echo 'chk acta: '.$chk_acta.'<br>';
//        echo 'chk comprobante: '.$chk_comp.'<br>';
//        echo 'chk certificado: '.$chk_certificado.'<br>';
//        echo 'chk curp: '.$chk_curp.'<br>';
//        echo 'chk rfc: '.$chk_rfc.'<br>';
//        echo 'chk nss: '.$chk_nss.'<br>';
//        echo 'chk licencia: '.$chk_licencia.'<br>';
//        echo 'chk recomendacion: '.$chk_recomendacion.'<br>';
//        echo 'chk antecedentes: '.$chk_antecedentes.'<br>';
//        echo 'chk fonacot: '.$chk_fonacot.'<br>';        
//        echo 'chk infonavit: '.$chk_infonavit.'<br>';
//        echo '<br>';
        
        //se realiza el update de los registros de la persona
        include '../../../../config/conectasql.php';
        $updatep = new conectasql();
        $updatep->abre_conexion("0");

        //se valida que  no exista la clave para el empleado nuevo
        $updatep->valida_nueva_persona($clave);
        $msj=$insert->msj;
        if($msj == 1){
            $error[]='clave existe';
        }
        //se validan errores en general
        if(sizeof($error)>0){
            //sustituir por mensaje html para mostrar error de datos
            echo 'El formulario tiene errores<br>';
        } else {
            //se limpian los variables que provienen de input, en busca de simbolos raros
            $registro=$updatep->limpia_cadena($registro);
            $clave=$updatep->limpia_cadena($clave);
            $nombre=$updatep->limpia_cadena($nombre);
            $paterno=$updatep->limpia_cadena($paterno);
            $materno=$updatep->limpia_cadena($materno);
            $calle=$updatep->limpia_cadena($calle);
            $numero=$updatep->limpia_cadena($numero);
            $colonia=$updatep->limpia_cadena($colonia);
            $cp=$updatep->limpia_cadena($cp);
            $pais=$updatep->limpia_cadena($pais);
            $estado=$updatep->limpia_cadena($estado);
            $municipio=$updatep->limpia_cadena($municipio);
            $nacionalidad=$updatep->limpia_cadena($nacionalidad);
            $rfc=$updatep->limpia_cadena($rfc);
            $nss=$updatep->limpia_cadena($nss);
            $curp=$updatep->limpia_cadena($curp);
            $genero=$updatep->limpia_cadena($genero);
            $correo=$updatep->limpia_cadena($correo);
            $telefono=$updatep->limpia_cadena($telefono);
            $celular=$updatep->limpia_cadena($celular);
            $fecha_nac=$updatep->limpia_cadena($fecha_nac);
            $banco=$updatep->limpia_cadena($banco);
            $clavebanco=$updatep->limpia_cadena($clavebanco);
            $cuenta=$updatep->limpia_cadena($cuenta);
            $edad=$updatep->limpia_cadena($edad);
            if($afore != null){$afore=$updatep->limpia_cadena($afore);}
            if($creinfo != null){$creinfo=$updatep->limpia_cadena($creinfo);}
            $civil=$updatep->limpia_cadena($civil);
            
            
            $updatep->update_personas_generales($registro,$clave,$nombre,$paterno,$materno,$calle,$numero,$colonia,$cp,$pais,$estado,$municipio,$nacionalidad,$rfc,$nss,$curp,$genero,$correo,$telefono,$celular,$fecha_nac,$fecha,$hora,$status, $edad, $civil,$usid,$afore,$creinfo);
            $updatep->update_personas_bancos($registro,$banco,$clavebanco,$cuenta);
            $updatep->update_personas_docs($registro,$chk_comp,$chk_ine,$chk_licencia,$chk_acta,$chk_rfc,$chk_nss,$chk_curp,$chk_certificado,$chk_recomendacion,$chk_antecedentes,$chk_fonacot,$chk_infonavit); 
        }
        if($updatep->update == '111'){
            $updatep->exito('../../../../estilos/personasStyles.css');
        }else{
            echo 'Error editando registro: ';
            print_r($error);
        }

        $updatep->cierra_conexion("0");

    }        
?>