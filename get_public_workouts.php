<?php
include 'database.php';
session_start();

header('Content-Type: application/json');

$stmt = $pdo->prepare("
    SELECT 
        wp.PlanID as id,
        wp.workout_name,
        wp.description,
        wp.difficulty_level,
        wp.estimated_duration,
        wp.estimated_calories_burn,
        u.Name as creator_name,
        COUNT(ce.ExerciseID) as exercise_count,
        wp.created_at
    FROM tblworkoutplan wp
    LEFT JOIN tblusers u ON wp.Email = u.Email
    LEFT JOIN tblcustom_exercises ce ON wp.PlanID = ce.PlanID
    WHERE wp.is_public = 1
    GROUP BY wp.PlanID
    ORDER BY wp.created_at DESC
");
$stmt->execute();
$workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($workouts);
?>