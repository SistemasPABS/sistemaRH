<?php
include_once ('../../../config/cookie.php');
include_once ('../../../config/conectasql.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $persona=$_POST["personaid"];
    $count = count($persona);
    for ($i = 0; $i < $count; $i++) {
        echo $persona[$i];
    }
}
?>