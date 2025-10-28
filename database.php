<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rwddassignment";

// MySQLi connection (for any existing code)
$conn = new mysqli($servername, $username, $password, $dbname); 
if ($conn->connect_error) {
    die("MySQLi Connection failed: " . $conn->connect_error);
}

// PDO connection (for custom workout files and modern PHP)
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}

// Optional: Global database config constants (good practice)
define('DB_HOST', $servername);
define('DB_USER', $username);
define('DB_PASS', $password);
define('DB_NAME', $dbname);

// Check if we need legacy mysql_* functions (unlikely, but just in case)
if (!function_exists('mysqli_connect') && function_exists('mysql_connect')) {
    $mysql_link = mysql_connect($servername, $username, $password);
    mysql_select_db($dbname, $mysql_link);
}
?>