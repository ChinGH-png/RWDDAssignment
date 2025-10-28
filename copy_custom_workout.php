<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id']) && !isset($_COOKIE['fitpm_user'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

// Your save logic here
echo json_encode(['success' => true, 'message' => 'Workout saved']);
?>