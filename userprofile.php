<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['fitpm_user'])) {
    header("Location: index.php");
    exit();
}

// Get user data
$userData = null;
if (isset($_SESSION['user_id'])) {
    $userData = [
        'name' => $_SESSION['user_name'] ?? 'User',
        'email' => $_SESSION['user_email'] ?? '',
        'role' => $_SESSION['user_role'] ?? 'user'
    ];
} elseif (isset($_COOKIE['fitpm_user'])) {
    $userData = json_decode($_COOKIE['fitpm_user'], true);
}

// Connect to database to get user details
$conn = mysqli_connect("localhost", "root", "", "rwddassignment");
$userDetails = [];
$message = '';
$messageType = '';

if ($conn && isset($userData['email'])) {
    // Get user details
    $stmt = $conn->prepare("SELECT UserID, Name, Email, Gender, Goal_Name FROM tblusers WHERE Email = ?");
    $stmt->bind_param("s", $userData['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $userDetails = $result->fetch_assoc();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $gender = $_POST['gender'] ?? '';
        $goal = $userDetails['Goal_Name'] ?? ''; // Keep original goal, not from form

        if (!empty($name) && !empty($email) && !empty($gender)) {
            // Check if email is already taken by another user
            $checkEmailStmt = $conn->prepare("SELECT UserID FROM tblusers WHERE Email = ? AND UserID != ?");
            $checkEmailStmt->bind_param("si", $email, $userDetails['UserID']);
            $checkEmailStmt->execute();
            $emailResult = $checkEmailStmt->get_result();

            if ($emailResult->num_rows > 0) {
                $message = "Email address is already taken by another user.";
                $messageType = 'error';
            } else {
                // Update user in database
                $updateStmt = $conn->prepare("UPDATE tblusers SET Name = ?, Email = ?, Gender = ? WHERE UserID = ?");
                $updateStmt->bind_param("sssi", $name, $email, $gender, $userDetails['UserID']);
                
                if ($updateStmt->execute()) {
                    $message = "Profile updated successfully!";
                    $messageType = 'success';
                    
                    // Update session
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    
                    // Update user details for display
                    $userDetails['Name'] = $name;
                    $userDetails['Email'] = $email;
                    $userDetails['Gender'] = $gender;
                    
                    // Update cookie
                    if (isset($_COOKIE['fitpm_user'])) {
                        $cookieData = json_decode($_COOKIE['fitpm_user'], true);
                        $cookieData['name'] = $name;
                        $cookieData['email'] = $email;
                        setcookie('fitpm_user', json_encode($cookieData), time() + (30 * 24 * 60 * 60), "/");
                    }
                } else {
                    $message = "Error updating profile: " . $updateStmt->error;
                    $messageType = 'error';
                }
            }
        } else {
            $message = "Please fill in all required fields.";
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - FitPM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #2e8b57;
            --light-green: #4caf50;
            --dark-gray: #333;
            --light-gray: #f5f5f5;
            --card-bg: #fff;
            --shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        body.dark-mode {
            --card-bg: #151515;
            --light-gray: #2a2a2a;
            --dark-gray: #f5f5f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light-gray);
            color: var(--dark-gray);
            transition: background 0.3s, color 0.3s;
            min-height: 100vh;
        }

        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 15px;
        }

        /* Back Button */
        .btn-back {
            background: #6c757d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-title {
            color: var(--primary-green);
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .profile-subtitle {
            color: var(--dark-gray);
            opacity: 0.8;
            font-size: 1rem;
        }

        .profile-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 25px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }

        .avatar-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2.5rem;
            color: white;
            font-weight: 700;
        }

        .user-name {
            font-size: 1.5rem;
            color: var(--dark-gray);
            margin-bottom: 8px;
        }

        .user-role {
            background: var(--primary-green);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-block;
        }

        /* Edit/Save Toggle */
        .edit-toggle {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        .btn-edit, .btn-save, .btn-cancel {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-edit {
            background: #2196f3;
            color: white;
        }

        .btn-edit:hover {
            background: #1976d2;
        }

        .btn-save {
            background: var(--primary-green);
            color: white;
        }

        .btn-save:hover {
            background: #267c4a;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        /* Form Styles */
        .profile-form {
            display: none;
        }

        .profile-form.active {
            display: block;
        }

        .profile-info {
            display: block;
        }

        .profile-info.hidden {
            display: none;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin: 20px 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background: var(--card-bg);
            color: var(--dark-gray);
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-green);
        }

        .form-group input[readonly],
        .form-group select[readonly] {
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
            border-color: #dee2e6;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .info-item {
            padding: 15px;
            background: rgba(46, 139, 87, 0.1);
            border-radius: 12px;
            border-left: 4px solid var(--primary-green);
        }

        .info-label {
            font-size: 0.8rem;
            color: var(--dark-gray);
            opacity: 0.7;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .info-value {
            font-size: 1rem;
            color: var(--dark-gray);
            font-weight: 600;
        }

        /* Fitness Stats */
        .fitness-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item {
            text-align: center;
            padding: 15px;
            background: rgba(46, 139, 87, 0.05);
            border-radius: 12px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--dark-gray);
            opacity: 0.8;
        }

        .btn {
            background: var(--primary-green);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .btn:hover {
            background: #267c4a;
            transform: translateY(-2px);
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        /* Message Styles */
        .message {
            padding: 12px 15px;
            margin: 15px 0;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            text-align: center;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (min-width: 768px) {
            .profile-container {
                padding: 25px;
            }

            .profile-title {
                font-size: 2.2rem;
            }

            .avatar {
                width: 120px;
                height: 120px;
                font-size: 3rem;
            }

            .info-grid, .form-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .fitness-stats {
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
            }

            .btn-back {
                position: absolute;
                top: 25px;
                left: 25px;
                margin-bottom: 0;
            }

            .profile-container {
                position: relative;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Back Button -->
        <a href="index.php" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <div class="profile-header">
            <h1 class="profile-title">My Fitness Profile</h1>
            <p class="profile-subtitle">Track your fitness journey and achievements</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="avatar-section">
                <div class="avatar">
                    <?php 
                    $initials = '';
                    if ($userDetails && isset($userDetails['Name'])) {
                        $names = explode(' ', $userDetails['Name']);
                        $initials = strtoupper(substr($names[0], 0, 1) . (isset($names[1]) ? substr($names[1], 0, 1) : ''));
                    } else {
                        $initials = 'U';
                    }
                    echo $initials;
                    ?>
                </div>
                <h2 class="user-name"><?php echo htmlspecialchars($userDetails['Name'] ?? $userData['name'] ?? 'User'); ?></h2>
                <span class="user-role">
                    <i class="fas fa-user"></i> Fitness Member
                </span>
            </div>

            <!-- Edit/Save Toggle -->
            <div class="edit-toggle">
                <button type="button" id="editBtn" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
                <button type="button" id="saveBtn" class="btn-save" style="display: none;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <button type="button" id="cancelBtn" class="btn-cancel" style="display: none;">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>

            <!-- Profile Information (View Mode) -->
            <div class="profile-info" id="profileInfo">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><?php echo htmlspecialchars($userDetails['Name'] ?? $userData['name'] ?? 'Not set'); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value"><?php echo htmlspecialchars($userDetails['Email'] ?? $userData['email'] ?? 'Not set'); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Gender</div>
                        <div class="info-value"><?php echo htmlspecialchars($userDetails['Gender'] ?? 'Not specified'); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Fitness Goal</div>
                        <div class="info-value"><?php echo htmlspecialchars($userDetails['Goal_Name'] ?? 'Not set'); ?></div>
                    </div>
                </div>
            </div>

            <!-- Profile Form (Edit Mode) -->
            <form class="profile-form" id="profileForm" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userDetails['Name'] ?? $userData['name'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userDetails['Email'] ?? $userData['email'] ?? ''); ?>" required>
                        <small style="color: #6c757d; font-size: 0.8rem;">You can change your email address</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender *</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" <?php echo (isset($userDetails['Gender']) && $userDetails['Gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo (isset($userDetails['Gender']) && $userDetails['Gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo (isset($userDetails['Gender']) && $userDetails['Gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                            <option value="Prefer not to say" <?php echo (isset($userDetails['Gender']) && $userDetails['Gender'] === 'Prefer not to say') ? 'selected' : ''; ?>>Prefer not to say</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="goal">Fitness Goal</label>
                        <select id="goal" name="goal" readonly>
                            <option value="<?php echo htmlspecialchars($userDetails['Goal_Name'] ?? ''); ?>" selected>
                                <?php echo htmlspecialchars($userDetails['Goal_Name'] ?? 'Not set'); ?>
                            </option>
                        </select>
                        <small style="color: #6c757d; font-size: 0.8rem;">Fitness goal cannot be changed from profile</small>
                    </div>
                </div>
            </form>

            <!-- Fitness Statistics -->
            <h3 style="color: var(--primary-green); margin: 25px 0 15px 0; text-align: center;">Fitness Progress</h3>
            <div class="fitness-stats">
                <div class="stat-item">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Workouts Completed</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">3,450</div>
                    <div class="stat-label">Calories Burned</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Active Days</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">75%</div>
                    <div class="stat-label">Goal Progress</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('editBtn');
            const saveBtn = document.getElementById('saveBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const profileInfo = document.getElementById('profileInfo');
            const profileForm = document.getElementById('profileForm');
            const goalField = document.getElementById('goal');

            // Edit button click
            editBtn.addEventListener('click', function() {
                profileInfo.classList.add('hidden');
                profileForm.classList.add('active');
                editBtn.style.display = 'none';
                saveBtn.style.display = 'inline-flex';
                cancelBtn.style.display = 'inline-flex';
            });

            // Cancel button click
            cancelBtn.addEventListener('click', function() {
                profileInfo.classList.remove('hidden');
                profileForm.classList.remove('active');
                editBtn.style.display = 'inline-flex';
                saveBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
            });

            // Save button click - submit the form
            saveBtn.addEventListener('click', function() {
                profileForm.submit();
            });

            // Form submission validation
            profileForm.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const gender = document.getElementById('gender').value;

                if (!name || !email || !gender) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                    return false;
                }

                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    alert('Please enter a valid email address.');
                    return false;
                }
            });
        });
    </script>
</body>
</html>