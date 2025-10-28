<?php
session_start();

// Check if user is admin
$isAdmin = false;
$userName = "Admin";

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    $isAdmin = true;
    $userName = $_SESSION['user_name'] ?? 'Admin';
} elseif (isset($_COOKIE['fitpm_user'])) {
    $userData = json_decode($_COOKIE['fitpm_user'], true);
    if ($userData && isset($userData['role']) && $userData['role'] === 'admin') {
        $isAdmin = true;
        $userName = $userData['name'] ?? 'Admin';
    }
}

if (!$isAdmin) {
    header("Location: index.php");
    exit();
}

// Connect to database to get admin details
$conn = mysqli_connect("localhost", "root", "", "rwddassignment");
$adminDetails = [];
if ($conn && isset($_SESSION['admin_email'])) {
    $stmt = $conn->prepare("SELECT Name, Email, Gender FROM tbladmin WHERE Email = ?");
    $stmt->bind_param("s", $_SESSION['admin_email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $adminDetails = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - FitPM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Same CSS as user profile but simplified */
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
            max-width: 600px;
            margin: 0 auto;
            padding: 15px;
        }

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

        .profile-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 25px;
            box-shadow: var(--shadow);
        }

        .avatar-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e53935, #ff6b6b);
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
            background: #e53935;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-block;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin: 25px 0;
        }

        .info-item {
            padding: 15px;
            background: rgba(229, 57, 53, 0.1);
            border-radius: 12px;
            border-left: 4px solid #e53935;
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

        @media (min-width: 768px) {
            .profile-container {
                padding: 25px;
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
        <a href="admin_dashboard.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <div class="profile-header">
            <h1 class="profile-title">Admin Profile</h1>
            <p class="profile-subtitle">System Administrator Information</p>
        </div>

        <div class="profile-card">
            <div class="avatar-section">
                <div class="avatar">
                    <?php 
                    $initials = '';
                    if ($adminDetails && isset($adminDetails['Name'])) {
                        $names = explode(' ', $adminDetails['Name']);
                        $initials = strtoupper(substr($names[0], 0, 1) . (isset($names[1]) ? substr($names[1], 0, 1) : ''));
                    } else {
                        $initials = 'A';
                    }
                    echo $initials;
                    ?>
                </div>
                <h2 class="user-name"><?php echo htmlspecialchars($adminDetails['Name'] ?? $userName); ?></h2>
                <span class="user-role">
                    <i class="fas fa-user-shield"></i> System Administrator
                </span>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Email Address</div>
                    <div class="info-value"><?php echo htmlspecialchars($adminDetails['Email'] ?? $_SESSION['admin_email'] ?? 'Not set'); ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Gender</div>
                    <div class="info-value"><?php echo htmlspecialchars($adminDetails['Gender'] ?? 'Not specified'); ?></div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Role</div>
                    <div class="info-value">System Administrator</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Access Level</div>
                    <div class="info-value">Full System Access</div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="admin_dashboard.php" class="btn">
                    <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                </a>
                <a href="index.php" class="btn">
                    <i class="fas fa-home"></i> Visit Site
                </a>
            </div>
        </div>
    </div>
</body>
</html>