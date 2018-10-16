<?php
session_start();
session_unset();
setcookie("rememberme", '', - 1, '/');
session_destroy();
header('location: login.php');
?>