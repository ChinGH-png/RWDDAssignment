<?php
include 'database.php';
session_start();

header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log the request
error_log("=== CUSTOM WORKOUT SAVE REQUEST ===");
error_log("Session user_id: " . ($_SESSION['user_id'] ?? 'NOT SET'));
error_log("POST data: " . print_r($_POST, true));
error_log("Raw input: " . file_get_contents('php://input'));

if (!isset($_SESSION['user_id'])) {
    error_log("❌ USER NOT LOGGED IN");
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

// Get the input data
$input = file_get_contents('php://input');
error_log("Raw JSON input: " . $input);

if (empty($input)) {
    error_log("❌ NO DATA RECEIVED");
    echo json_encode(['success' => false, 'error' => 'No data received']);
    exit;
}

$data = json_decode($input, true);

if (!$data) {
    error_log("❌ JSON DECODE FAILED");
    echo json_encode(['success' => false, 'error' => 'Invalid JSON data']);
    exit;
}

error_log("✅ Data decoded successfully:");
error_log("Workout name: " . ($data['workout_name'] ?? 'MISSING'));
error_log("Exercises count: " . count($data['exercises'] ?? []));
error_log("Full data: " . print_r($data, true));

try {
    $pdo->beginTransaction();
    error_log("✅ Transaction started");

    // Get user email from session
    $userStmt = $pdo->prepare("SELECT Email FROM tblusers WHERE UserID = ?");
    $userStmt->execute([$_SESSION['user_id']]);
    $user = $userStmt->fetch();
    
    if (!$user) {
        throw new Exception('User not found in database');
    }
    
    error_log("✅ User found: " . $user['Email']);

    // Validate required data
    if (empty($data['workout_name'])) {
        throw new Exception('Workout name is required');
    }

    if (empty($data['exercises']) || !is_array($data['exercises'])) {
        throw new Exception('No exercises selected');
    }

    // Calculate totals
    $totalDuration = 0;
    $totalCalories = 0;
    
    foreach ($data['exercises'] as $index => $exercise) {
        error_log("Exercise $index: " . $exercise['name'] . " - " . $exercise['duration'] . "s");
        $totalDuration += $exercise['duration'];
        
        // Get calories from exercise table
        $calorieStmt = $pdo->prepare("SELECT base_calories_burn_30s, base_calories_burn_45s FROM tblexercise WHERE Exercise_Name = ?");
        $calorieStmt->execute([$exercise['name']]);
        $calorieData = $calorieStmt->fetch();
        
        if ($calorieData) {
            $calories = ($exercise['duration'] == 30) ? $calorieData['base_calories_burn_30s'] : $calorieData['base_calories_burn_45s'];
            $totalCalories += $calories;
            error_log("  Calories for {$exercise['name']}: $calories");
        } else {
            error_log("  ❌ No calorie data found for: {$exercise['name']}");
            $totalCalories += 5; // Default fallback
        }
    }
    
    error_log("📊 Totals - Duration: {$totalDuration}s, Calories: {$totalCalories}");

    // Insert into workoutplan
    $stmt = $pdo->prepare("
        INSERT INTO tblworkoutplan (Email, workout_name, description, is_public, difficulty_level, estimated_duration, estimated_calories_burn) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    $is_public = isset($data['is_public']) && $data['is_public'] ? 1 : 0;
    
    $stmt->execute([
        $user['Email'],
        $data['workout_name'],
        $data['description'] ?? '',
        $is_public,
        $data['difficulty_level'] ?? 'Beginner',
        $totalDuration,
        $totalCalories
    ]);
    
    $workoutId = $pdo->lastInsertId();
    error_log("✅ Workout plan saved with ID: $workoutId");

    // Insert exercises
    $exerciseStmt = $pdo->prepare("
        INSERT INTO tblcustom_exercises (PlanID, ExerciseRefID, ExerciseName, DurationSeconds) 
        VALUES (?, ?, ?, ?)
    ");
    
    $exerciseCount = 0;
    foreach ($data['exercises'] as $exercise) {
        // Get ExerciseID
        $refStmt = $pdo->prepare("SELECT ExerciseID FROM tblexercise WHERE Exercise_Name = ?");
        $refStmt->execute([$exercise['name']]);
        $refData = $refStmt->fetch();
        
        $exerciseRefID = $refData ? $refData['ExerciseID'] : 0;
        
        $exerciseStmt->execute([
            $workoutId,
            $exerciseRefID,
            $exercise['name'],
            $exercise['duration']
        ]);
        $exerciseCount++;
        error_log("  ✅ Exercise saved: {$exercise['name']} (RefID: $exerciseRefID)");
    }
    
    error_log("✅ Saved $exerciseCount exercises");

    $pdo->commit();
    error_log("🎉 TRANSACTION COMPLETED SUCCESSFULLY");
    
    echo json_encode(['success' => true, 'workout_id' => $workoutId, 'message' => 'Workout saved successfully!']);
    
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("❌ ERROR: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

error_log("=== SAVE PROCESS COMPLETED ===");

?>