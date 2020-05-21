<?php
session_start();
if (!isset($_SESSION['listo']) || $_SESSION['listo'] !== true && !isset($_SESSION['us_id']) && !isset($_SESSION['plogin'])) {
    header('Location: /controller/index.php'); //Redirige al inicio de sesion en caso de que no tengas la cookie
    exit;
}

?>