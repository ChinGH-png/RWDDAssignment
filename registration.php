<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

error_log("Registration attempt: " . print_r($_POST, true));

try {
    $conn = new mysqli('localhost', 'root', '', 'rwddassignment');
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get and validate form data — accept either Goal_Name or goal_set (or goal)
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $goal = trim($_POST['Goal_Name'] ?? $_POST['goal_set'] ?? $_POST['goal'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$name || !$gender || !$goal || !$password) {
        throw new Exception("All fields are required");
    }

    $conn->begin_transaction();
    try {
        $stmt1 = $conn->prepare("INSERT INTO tblemail (Email) VALUES (?)");
        if (!$stmt1) {
            throw new Exception("Email prepare failed: " . $conn->error);
        }
        $stmt1->bind_param("s", $email);
        $stmt1->execute();
        $stmt1->close();

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt2 = $conn->prepare("INSERT INTO tblusers (Email, password_hash, Name, Gender, Goal_Name) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt2) {
            throw new Exception("User prepare failed: " . $conn->error);
        }
        $stmt2->bind_param("sssss", $email, $password_hash, $name, $gender, $goal);
        $stmt2->execute();
        $stmt2->close();

        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Registration successful'
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }

} catch (Exception $e) {
    error_log("Registration error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

if (isset($conn)) {
    $conn->close();
}
?>