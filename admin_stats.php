<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost", "root", "", "rwddassignment");
if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

// Get statistics
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM tblusers"))['count'];
$totalAdmins = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM tbladmin"))['count'];
$totalExercises = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM tblexercise"))['count'];
$totalRecipes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM tblfoodplan"))['count'];

echo json_encode([
    'success' => true,
    'totalUsers' => $totalUsers,
    'totalAdmins' => $totalAdmins,
    'totalExercises' => $totalExercises,
    'totalRecipes' => $totalRecipes
]);

mysqli_close($conn);
?>