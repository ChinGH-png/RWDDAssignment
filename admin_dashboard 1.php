<?php
session_start();

// Check if user is admin
$isAdmin = false;
$userName = "Admin";

// Check session first
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    $isAdmin = true;
    $userName = $_SESSION['user_name'] ?? 'Admin';
} 
// Check cookie as fallback
elseif (isset($_COOKIE['fitpm_user'])) {
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

$conn = mysqli_connect("localhost", "root", "", "rwddassignment");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form actions
$action = $_POST['action'] ?? '';
$selectedTable = $_GET['table'] ?? '';
$message = '';

if ($action && $selectedTable) {
    switch($action) {
        case 'add':
            $columns = [];
            $values = [];
            foreach ($_POST as $key => $value) {
                if ($key != 'action' && $key != 'table') {
                    $columns[] = "`$key`";
                    $values[] = "'" . mysqli_real_escape_string($conn, $value) . "'";
                }
            }
            $sql = "INSERT INTO $selectedTable (" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ")";
            if (mysqli_query($conn, $sql)) {
                $message = "Record added successfully!";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
            break;
            
        case 'edit':
            $updates = [];
            $whereConditions = [];
            foreach ($_POST as $key => $value) {
                if ($key != 'action' && $key != 'table') {
                    if (strpos($key, 'where_') === 0) {
                        // This is a WHERE condition (for primary key)
                        $actualKey = substr($key, 6);
                        $whereConditions[] = "`$actualKey` = '" . mysqli_real_escape_string($conn, $value) . "'";
                    } else {
                        // This is a field to update
                        $updates[] = "`$key` = '" . mysqli_real_escape_string($conn, $value) . "'";
                    }
                }
            }
            if (!empty($updates) && !empty($whereConditions)) {
                $sql = "UPDATE $selectedTable SET " . implode(',', $updates) . " WHERE " . implode(' AND ', $whereConditions);
                if (mysqli_query($conn, $sql)) {
                    $message = "Record updated successfully!";
                } else {
                    $message = "Error: " . mysqli_error($conn);
                }
            }
            break;
            
        case 'delete':
            $whereConditions = [];
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'where_') === 0) {
                    $actualKey = substr($key, 6);
                    $whereConditions[] = "`$actualKey` = '" . mysqli_real_escape_string($conn, $value) . "'";
                }
            }
            if (!empty($whereConditions)) {
                $sql = "DELETE FROM $selectedTable WHERE " . implode(' AND ', $whereConditions);
                if (mysqli_query($conn, $sql)) {
                    $message = "Record deleted successfully!";
                } else {
                    $message = "Error: " . mysqli_error($conn);
                }
            }
            break;
    }
}

// Get all tables
$tables = [];
$result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_array($result)) {
    $tables[] = $row[0];
}

// Get table data if a table is selected
$tableData = [];
$columns = [];
$primaryKeys = [];

if (!empty($selectedTable)) {
    // Get table columns and primary keys
    $columnsResult = mysqli_query($conn, "SHOW COLUMNS FROM $selectedTable");
    while ($column = mysqli_fetch_assoc($columnsResult)) {
        $columns[] = $column['Field'];
        if ($column['Key'] == 'PRI') {
            $primaryKeys[] = $column['Field'];
        }
    }
    
    // Get table data
    $dataResult = mysqli_query($conn, "SELECT * FROM $selectedTable LIMIT 100");
    while ($row = mysqli_fetch_assoc($dataResult)) {
        $tableData[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FitPM</title>
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
        }

        .admin-container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .admin-title {
            color: var(--primary-green);
            font-size: 28px;
            font-weight: 700;
        }

        .welcome-message {
            font-size: 16px;
            color: var(--dark-gray);
        }

        .btn {
            background: var(--primary-green);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .btn:hover {
            background: #267c4a;
            transform: translateY(-2px);
        }

        .btn-logout {
            background: #e53935;
        }

        .btn-logout:hover {
            background: #c62828;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            text-align: center;
            border-left: 4px solid var(--primary-green);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--dark-gray);
            opacity: 0.8;
        }

        .table-section {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .section-title {
            color: var(--primary-green);
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: 600;
        }

        .table-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .table-btn {
            background: var(--primary-green);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
        }

        .table-btn:hover {
            background: #267c4a;
            transform: translateY(-2px);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: var(--card-bg);
        }

        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .data-table th {
            background: var(--primary-green);
            color: white;
            font-weight: 600;
        }

        .data-table tr:hover {
            background: rgba(46, 139, 87, 0.1);
        }

        .action-btn {
            padding: 6px 12px;
            margin: 2px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 12px;
        }

        .edit-btn {
            background: #ffc107;
            color: #333;
        }

        .edit-btn:hover {
            background: #e0a800;
        }

        .delete-btn {
            background: #e53935;
            color: white;
        }

        .delete-btn:hover {
            background: #c62828;
        }

        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            font-weight: 500;
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: var(--dark-gray);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: var(--card-bg);
            color: var(--dark-gray);
        }

        .add-form, .edit-form {
            background: rgba(46, 139, 87, 0.05);
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid var(--primary-green);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--card-bg);
            padding: 30px;
            border-radius: 12px;
            min-width: 500px;
            max-width: 90%;
            max-height: 90%;
            overflow-y: auto;
            box-shadow: var(--shadow);
        }

        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table-list {
                justify-content: center;
            }

            .modal-content {
                min-width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
    <div class="admin-header">
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="index.php" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div>
                <h1 class="admin-title">Admin Dashboard</h1>
                <p class="welcome-message">Welcome back, <?php echo htmlspecialchars($userName); ?>! :D</p>
            </div>
        </div>
    </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number" id="totalUsers">0</div>
                <div class="stat-label">Total Users</div>
                <i class="fas fa-users" style="font-size: 2rem; color: var(--primary-green); margin-top: 10px;"></i>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="totalAdmins">0</div>
                <div class="stat-label">Admin Accounts</div>
                <i class="fas fa-user-shield" style="font-size: 2rem; color: var(--primary-green); margin-top: 10px;"></i>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="totalExercises">0</div>
                <div class="stat-label">Exercises</div>
                <i class="fas fa-running" style="font-size: 2rem; color: var(--primary-green); margin-top: 10px;"></i>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="totalRecipes">0</div>
                <div class="stat-label">Recipes</div>
                <i class="fas fa-utensils" style="font-size: 2rem; color: var(--primary-green); margin-top: 10px;"></i>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Error') === false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="table-section">
            <h2 class="section-title">Database Management</h2>
            <div class="table-list">
                <?php foreach ($tables as $table): ?>
                    <a href="?table=<?php echo $table; ?>" class="table-btn">
                        <i class="fas fa-table"></i> <?php echo $table; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <?php if (!empty($selectedTable)): ?>
                <h3 style="color: var(--primary-green); margin: 20px 0;">Table: <?php echo $selectedTable; ?></h3>
                
                <!-- Add New Record Form -->
                <div class="add-form">
                    <h4 style="color: var(--primary-green); margin-bottom: 15px;">Add New Record</h4>
                    <form method="post">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="table" value="<?php echo $selectedTable; ?>">
                        <div class="form-grid">
                            <?php foreach ($columns as $column): ?>
                                <?php 
                                    // Skip auto-increment columns for add form
                                    $skipAdd = false;
                                    if (in_array($column, $primaryKeys)) {
                                        $columnInfo = mysqli_fetch_assoc(mysqli_query($conn, "SHOW COLUMNS FROM $selectedTable WHERE Field = '$column'"));
                                        if (strpos($columnInfo['Extra'], 'auto_increment') !== false) {
                                            $skipAdd = true;
                                        }
                                    }
                                ?>
                                <?php if (!$skipAdd): ?>
                                    <div class="form-group">
                                        <label><?php echo $column; ?>:</label>
                                        <input type="text" name="<?php echo $column; ?>" placeholder="Enter <?php echo $column; ?>">
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit" class="btn" style="margin-top: 15px;">
                            <i class="fas fa-plus"></i> Add Record
                        </button>
                    </form>
                </div>
                
                <!-- Table Data with Edit/Delete -->
                <?php if (empty($tableData)): ?>
                    <p>No data in this table.</p>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <?php foreach ($columns as $column): ?>
                                        <th><?php echo $column; ?></th>
                                    <?php endforeach; ?>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tableData as $row): ?>
                                    <tr>
                                        <?php foreach ($columns as $column): ?>
                                            <td><?php echo htmlspecialchars($row[$column] ?? ''); ?></td>
                                        <?php endforeach; ?>
                                        <td>
                                            <!-- Edit Button -->
                                            <button class="action-btn edit-btn" 
                                                    onclick="openEditModal('<?php echo $selectedTable; ?>', <?php echo htmlspecialchars(json_encode($row)); ?>, <?php echo htmlspecialchars(json_encode($primaryKeys)); ?>)">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            
                                            <!-- Delete Form -->
                                            <form method="post" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="table" value="<?php echo $selectedTable; ?>">
                                                <?php foreach ($primaryKeys as $pk): ?>
                                                    <input type="hidden" name="where_<?php echo $pk; ?>" value="<?php echo $row[$pk]; ?>">
                                                <?php endforeach; ?>
                                                <button type="submit" class="action-btn delete-btn">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p style="text-align: center; color: var(--dark-gray); opacity: 0.7; margin-top: 20px;">
                    Select a table to view and manage its data.
                </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3 style="color: var(--primary-green); margin-bottom: 20px;">Edit Record</h3>
            <form id="editForm" method="post">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="table" id="editTable">
                <div id="editFields" class="form-grid"></div>
                <div style="margin-top: 20px; text-align: right;">
                    <button type="button" onclick="closeEditModal()" class="btn" style="background: #6c757d; margin-right: 10px;">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Load statistics
        async function loadStatistics() {
            try {
                const response = await fetch('admin_stats.php');
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('totalUsers').textContent = data.totalUsers;
                    document.getElementById('totalAdmins').textContent = data.totalAdmins;
                    document.getElementById('totalExercises').textContent = data.totalExercises;
                    document.getElementById('totalRecipes').textContent = data.totalRecipes;
                }
            } catch (error) {
                console.error('Error loading statistics:', error);
            }
        }

        // Edit modal functions
        function openEditModal(table, row, primaryKeys) {
            document.getElementById('editTable').value = table;
            
            let fieldsHtml = '';
            for (const [key, value] of Object.entries(row)) {
                // Create hidden fields for primary keys (for WHERE clause)
                if (primaryKeys.includes(key)) {
                    fieldsHtml += `<input type="hidden" name="where_${key}" value="${value}">`;
                } else {
                    // Create editable fields for non-primary keys
                    fieldsHtml += `
                        <div class="form-group">
                            <label>${key}:</label>
                            <input type="text" name="${key}" value="${value}" required>
                        </div>
                    `;
                }
            }
            document.getElementById('editFields').innerHTML = fieldsHtml;
            document.getElementById('editModal').style.display = 'block';
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });

        // Load statistics when page loads
        document.addEventListener('DOMContentLoaded', loadStatistics);
    </script>
</body>
</html>