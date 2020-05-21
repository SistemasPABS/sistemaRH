<?php

$server='127.0.0.1';
$port='5432';
$dbname='controller_db';
$user='web';
$passwd='Gu3lc0m';

$conexion = pg_connect("host=$server port=$port dbname=$dbname user=$user password=$passwd");                

?>