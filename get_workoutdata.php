<?php
include 'database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $month = $_GET['month'] ?? date('n');
    $year = $_GET['year'] ?? date('Y');
    
    // Get user ID from session or cookie
    session_start();
    $user_id = $_SESSION['user_id'] ?? null;
    
    if (!$user_id) {
        echo json_encode(['success' => false, 'error' => 'User not logged in']);
        exit;
    }
    
    try {
        // Query to get workout data for the month
        $stmt = $pdo->prepare("
            SELECT 
                DAY(completion_date) as day,
                COUNT(*) as completed_workouts,
                SUM(calories_burned) as total_calories,
                GROUP_CONCAT(workout_type) as workout_types
            FROM workout_history 
            WHERE user_id = ? 
            AND MONTH(completion_date) = ? 
            AND YEAR(completion_date) = ?
            GROUP BY DAY(completion_date)
            ORDER BY day
        ");
        
        $stmt->execute([$user_id, $month, $year]);
        $workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'workouts' => $workouts
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Database error: ' . $e->getMessage()
        ]);
    }
}
?>