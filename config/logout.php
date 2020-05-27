<?php
session_start();
if (isset($_SESSION['listo']) && isset($_SESSION['us_id']) && isset($_SESSION['plogin'])) {
   unset($_SESSION['listo']);
   unset($_SESSION['us_id']);
   unset($_SESSION['plogin']);
}
header('Location: ../index.php');
exit;
?>