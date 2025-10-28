<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $conn = new mysqli('localhost', 'root', '', 'rwddassignment');
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        throw new Exception("Email and password are required");
    }

    session_start();

    // Check in BOTH users and admin tables
    $userFound = false;
    $userData = null;
    $role = 'user';
    $tableUsed = '';

    // First check users table (your actual table structure)
    $stmt = $conn->prepare("SELECT UserID as id, Name, password_hash, 'user' as role FROM tblusers WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $userFound = true;
        $userData = $result->fetch_assoc();
        $role = 'user';
        $tableUsed = 'tblusers';
    } else {
        // If not found in users, check admin table (your actual table structure)
        $stmt = $conn->prepare("SELECT AdminID as id, Name, password_hash, 'admin' as role FROM tbladmin WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $userFound = true;
            $userData = $result->fetch_assoc();
            $role = 'admin';
            $tableUsed = 'tbladmin';
        }
    }

    if (!$userFound) {
        throw new Exception("Invalid email or password");
    }

    // Verify password - handle both plain text (temporary) and hashed passwords
    $passwordValid = false;
    
    // First try password_verify for hashed passwords
    if (password_verify($password, $userData['password_hash'])) {
        $passwordValid = true;
    } 
    // Fallback: check if password matches directly (for development/testing)
    else if ($password === $userData['password_hash']) {
        $passwordValid = true;
    }

    if (!$passwordValid) {
        throw new Exception("Invalid email or password");
    }

    // Set session based on role
    if ($role === 'admin') {
        $_SESSION['admin_id'] = $userData['id'];
        $_SESSION['admin_name'] = $userData['Name'];
        $_SESSION['admin_email'] = $email;
        $_SESSION['is_admin'] = true;
        $_SESSION['user_role'] = 'admin';
    } else {
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['Name'];
        $_SESSION['user_email'] = $email;
        $_SESSION['is_admin'] = false;
        $_SESSION['user_role'] = 'user';
    }

    // Set cookie with role information
    $cookie_value = json_encode([
        'user_id' => $userData['id'],
        'email' => $email,
        'name' => $userData['Name'],
        'role' => $role,
        'table_used' => $tableUsed
    ]);
    
    setcookie('fitpm_user', $cookie_value, time() + (30 * 24 * 60 * 60), "/");
    setcookie('fitpm_login', '1', time() + (30 * 24 * 60 * 60), "/");

    // Return success with role information
    echo json_encode([
        'success' => true,
        'user' => [
            'email' => $email,
            'name' => $userData['Name'],
            'role' => $role,
            'table' => $tableUsed
        ],
        'redirect_url' => $role === 'admin' ? 'admin_dashboard.php' : 'index.php'
    ]);

} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

if (isset($conn)) {
    $conn->close();
}
?>