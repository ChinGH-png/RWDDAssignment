<?php
include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $goal = $_POST['goal_set'];

    $stmt = $conn->prepare("UPDATE tblusers SET Name=?, Gender=?, goal_set=? WHERE Email=?");
    $stmt->bind_param("ssss", $name, $gender, $goal, $email);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location='user_profile.php';</script>";
    } else {
        echo "<script>alert('Update failed. Please try again.'); window.location='user_profile.php';</script>";
    }
}
?>
