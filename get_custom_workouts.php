<?php
include 'database.php';
session_start();

header('Content-Type: application/json');

// Debug logging
error_log("=== GET CUSTOM WORKOUTS REQUEST ===");
error_log("Session user_id: " . ($_SESSION['user_id'] ?? 'NOT SET'));

if (!isset($_SESSION['user_id'])) {
    error_log("❌ User not logged in");
    echo json_encode([]);
    exit;
}

try {
    // Get user email from session
    $userStmt = $pdo->prepare("SELECT Email FROM tblusers WHERE UserID = ?");
    $userStmt->execute([$_SESSION['user_id']]);
    $user = $userStmt->fetch();

    if (!$user) {
        error_log("❌ User not found in database");
        echo json_encode([]);
        exit;
    }

    error_log("✅ User found: " . $user['Email']);

    $stmt = $pdo->prepare("
        SELECT 
            wp.PlanID as id,
            wp.workout_name,
            wp.description,
            wp.difficulty_level,
            wp.is_public,
            wp.estimated_duration,
            wp.estimated_calories_burn,
            COUNT(ce.ExerciseID) as exercise_count,
            wp.created_at
        FROM tblworkoutplan wp
        LEFT JOIN tblcustom_exercises ce ON wp.PlanID = ce.PlanID
        WHERE wp.Email = ?
        GROUP BY wp.PlanID
        ORDER BY wp.created_at DESC
    ");
    $stmt->execute([$user['Email']]);
    $workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    error_log("✅ Found " . count($workouts) . " workouts for user");
    
    echo json_encode($workouts);

} catch (Exception $e) {
    error_log("❌ Database error: " . $e->getMessage());
    echo json_encode([]);
}
?>