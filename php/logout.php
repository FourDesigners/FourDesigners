<?php
session_start();
session_unset();
session_destroy();
setcookie("remembermeuser", '', - 1, '/');
header('location: ../civicSense.php');
?>
