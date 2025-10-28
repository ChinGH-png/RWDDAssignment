<?php
// Clear cookies
setcookie('fitpm_user', '', time() - 3600, "/");
setcookie('fitpm_login', '', time() - 3600, "/");

// Clear session
session_start();
session_destroy();

echo "Logged out successfully";
?>