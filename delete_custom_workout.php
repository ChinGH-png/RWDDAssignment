<?php
include 'database.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) && !isset($_COOKIE['fitpm_user'])){
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$workoutId = $data['workout_id'];

// Get user email from session
$userStmt = $pdo->prepare("SELECT Email FROM tblusers WHERE UserID = ?");
$userStmt->execute([$_SESSION['user_id']]);
$user = $userStmt->fetch();

if (!$user) {
    echo json_encode(['success' => false, 'error' => 'User not found']);
    exit;
}

// Verify ownership
$stmt = $pdo->prepare("SELECT Email FROM tblworkoutplan WHERE PlanID = ?");
$stmt->execute([$workoutId]);
$workout = $stmt->fetch();

if (!$workout || $workout['Email'] != $user['Email']) {
    echo json_encode(['success' => false, 'error' => 'Not authorized']);
    exit;
}

try {
    $pdo->beginTransaction();
    
    // Delete custom exercises first
    $stmt = $pdo->prepare("DELETE FROM tblcustom_exercises WHERE PlanID = ?");
    $stmt->execute([$workoutId]);
    
    // Delete workout plan
    $stmt = $pdo->prepare("DELETE FROM tblworkoutplan WHERE PlanID = ?");
    $stmt->execute([$workoutId]);
    
    $pdo->commit();
    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>