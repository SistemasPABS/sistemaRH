<?php
    $user='sa';
    $passwd='';
    $database='jarabe_db';
    $server='192.168.0.47';
    global $user, $passwd, $database, $server;
    $conexion=mssql_connect($server,$user,$passwd);
    mssql_select_db($database,$conexion) or die ("No se puede conectar con el servidor");
    
    $usclave=$_POST['var1'];
    if($usclave != NULL){
    $sqljarabe="select us_nombre,us_apellidopaterno,us_apellidomaterno,us_email,us_numtelefono from usuarios where us_login = '$usclave';";
    $result= mssql_query($sqljarabe,$conexion);
    $row= mssql_fetch_row($result);
    
        if($row != NULL){
            $xml="<?xml version='1.0' encoding='ISO-8859-1'?>";
            $xml.="<datos>";
            $xml.="<us_nombre><![CDATA[$row[0]]]></us_nombre>";
            $xml.="<us_apellidopaterno><![CDATA[$row[1]]]></us_apellidopaterno>";
            $xml.="<us_apellidomaterno><![CDATA[$row[2]]]></us_apellidomaterno>";
            $xml.="<us_email><![CDATA[$row[3]]]></us_email>";
            $xml.="<us_numtelefono><![CDATA[$row[4]]]></us_numtelefono>";
            $xml.="</datos>";
            header("Content-type: text/xml");
            echo $xml; 
        }
    }
?>
