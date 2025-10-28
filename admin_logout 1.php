<?php

session_start();
$_SESSION = array();
setcookie('fitpm_user', '', time() - 3600, "/");
setcookie('fitpm_login', '', time() - 3600, "/");
session_destroy();
header("Location: index.php"); // NOT admin_login.php
exit();
?>