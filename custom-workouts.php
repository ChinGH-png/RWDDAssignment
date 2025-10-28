<?php
session_start();
// Include your database connection
require_once 'database.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'save_workout':
                // Save workout logic
                break;
            case 'delete_workout':
                // Delete workout logic
                break;
        }
    }
}

// Fetch user's custom workouts
$user_id = $_SESSION['user_id'] ?? null;
$user_workouts = [];
if ($user_id) {
    $stmt = $pdo->prepare("SELECT * FROM custom_workouts WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user_workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch public workouts
$public_workouts = [];
$stmt = $pdo->prepare("SELECT * FROM custom_workouts WHERE is_public = 1 AND user_id != ?");
$stmt->execute([$user_id]);
$public_workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Workouts</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header and Navigation (same as before) -->
    
    <main>
        <div class="container">
            <!-- Custom Workout Creation Section -->
            <div id="custom-workout" class="page active">
                <div class="section">
                    <h2 class="section-title">Create Custom Workout</h2>
                    <div class="custom-workout-layout">
                        <!-- Left Side: Form -->
                        <div class="exercise-gallery-section">
                            <form id="workout-form" method="POST" action="save_custom_workoutplan.php">
                                <input type="hidden" name="action" value="save_workout">
                                
                                <div class="form-group">
                                    <label for="workout-name">Workout Name</label>
                                    <input type="text" id="workout-name" name="workout_name" class="form-control" placeholder="Enter workout name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="workout-description">Description</label>
                                    <textarea id="workout-description" name="workout_description" class="form-control" placeholder="Describe your workout"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="difficulty-level">Difficulty Level</label>
                                    <select id="difficulty-level" name="difficulty_level" class="form-control">
                                        <option value="beginner">Beginner</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="advanced">Advanced</option>
                                    </select>
                                </div>
                                
                                <div class="checkbox-group">
                                    <input type="checkbox" id="make-public" name="is_public" value="1">
                                    <label for="make-public">Make Public</label>
                                </div>
                                
                                <div class="checkbox-group">
                                    <input type="checkbox" id="share-community" name="share_community" value="1">
                                    <label for="share-community">Share with community</label>
                                </div>
                                
                                <h3>Select Exercises</h3>
                                
                                <div class="button-group">
                                    <button type="button" class="btn btn-primary" id="select-exercises-btn">
                                        <i class="fas fa-dumbbell"></i> Select Exercises from Library
                                    </button>
                                    <span class="selected-count" id="selected-count">0 selected</span>
                                </div>
                                
                                <!-- Hidden field to store selected exercises -->
                                <input type="hidden" id="selected-exercises" name="exercises">
                                
                                <div class="workout-exercises">
                                    <h3>Workout Exercises</h3>
                                    <div id="exercises-list">
                                        <!-- Exercises will be added here dynamically -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Right Side: Buttons -->
                        <div class="custom-buttons">
                            <div class="button-group">
                                <button type="submit" form="workout-form" class="btn btn-primary" id="save-workout-btn">
                                    <i class="fas fa-save"></i> Save Workout
                                </button>
                            </div>
                            
                            <div class="bottom-buttons">
                                <button type="button" class="btn btn-secondary" id="add-custom-exercise">
                                    <i class="fas fa-plus"></i> Add Custom Exercise
                                </button>
                                <button type="button" class="btn btn-secondary" id="reset-workout">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- My Workouts Section -->
            <div id="my-workouts" class="page">
                <div class="section">
                    <h2 class="section-title">My Custom Workouts</h2>
                    
                    <div class="workout-grid">
                        <?php foreach ($user_workouts as $workout): ?>
                        <div class="workout-card" data-workout-id="<?php echo $workout['id']; ?>">
                            <div class="card-header custom-workout">
                                <div class="icon">
                                    <i class="fas fa-dumbbell"></i>
                                </div>
                                <h3><?php echo htmlspecialchars($workout['name']); ?></h3>
                            </div>
                            <div class="card-body">
                                <p><?php echo htmlspecialchars($workout['description']); ?></p>
                                <div class="details">
                                    <span><i class="fas fa-signal"></i> <?php echo ucfirst($workout['difficulty_level']); ?></span>
                                    <span><i class="fas fa-clock"></i> <?php echo $workout['duration']; ?> min</span>
                                </div>
                                <div class="card-actions">
                                    <button class="btn-edit" onclick="editWorkout(<?php echo $workout['id']; ?>)">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn-delete" onclick="deleteWorkout(<?php echo $workout['id']; ?>)">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    <button class="btn-copy" onclick="copyWorkout(<?php echo $workout['id']; ?>)">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if (empty($user_workouts)): ?>
                        <div class="no-workouts">
                            <p>You haven't created any custom workouts yet.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Public Workouts Section -->
            <div id="public-workouts" class="page">
                <div class="section">
                    <h2 class="section-title">Community Workouts</h2>
                    
                    <div class="workout-grid">
                        <?php foreach ($public_workouts as $workout): ?>
                        <div class="workout-card" data-workout-id="<?php echo $workout['id']; ?>">
                            <div class="card-header custom-workout">
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h3><?php echo htmlspecialchars($workout['name']); ?></h3>
                            </div>
                            <div class="card-body">
                                <p><?php echo htmlspecialchars($workout['description']); ?></p>
                                <div class="details">
                                    <span><i class="fas fa-signal"></i> <?php echo ucfirst($workout['difficulty_level']); ?></span>
                                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($workout['creator_name']); ?></span>
                                </div>
                                <div class="card-actions">
                                    <button class="btn-copy" onclick="copyWorkout(<?php echo $workout['id']; ?>)">
                                        <i class="fas fa-copy"></i> Add to My Workouts
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if (empty($public_workouts)): ?>
                        <div class="no-workouts">
                            <p>No public workouts available yet.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Exercise Selection Modal -->
    <div class="modal" id="exercise-modal">
        <div class="modal__overlay"></div>
        <div class="modal__dialog">
            <div class="modal__header">
                <h3>Select Exercises</h3>
                <button class="modal__close">&times;</button>
            </div>
            <div class="modal__body">
                <div class="exercise-gallery" id="exercise-gallery">
                    <!-- Exercise cards will be populated by JavaScript -->
                </div>
                
                <div class="duration-section">
                    <h3>Select Duration</h3>
                    <div class="duration-options">
                        <div class="duration-option" data-duration="30">30 Seconds</div>
                        <div class="duration-option" data-duration="45">45 Seconds</div>
                    </div>
                </div>
            </div>
            <div class="modal__actions">
                <button class="btn btn-secondary" id="cancel-exercise">Cancel</button>
                <button class="btn btn-primary" id="add-selected-btn">Add Selected Exercises</button>
            </div>
        </div>
    </div>

    <script>
        // JavaScript code from previous implementation
        // Add these AJAX functions for PHP integration
        
        function saveWorkout(formData) {
            fetch('save_custom_workoutplan.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Workout saved successfully!');
                    // Reset form or redirect
                } else {
                    alert('Error saving workout: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving workout');
            });
        }

        function deleteWorkout(workoutId) {
            if (confirm('Are you sure you want to delete this workout?')) {
                const formData = new FormData();
                formData.append('action', 'delete_workout');
                formData.append('workout_id', workoutId);

                fetch('delete_custom_workoutplan.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Workout deleted successfully!');
                        // Remove workout card from DOM
                        document.querySelector(`[data-workout-id="${workoutId}"]`).remove();
                    } else {
                        alert('Error deleting workout: ' + data.message);
                    }
                });
            }
        }

        function copyWorkout(workoutId) {
            const formData = new FormData();
            formData.append('action', 'copy_workout');
            formData.append('workout_id', workoutId);

            fetch('copy_custom_workoutplan.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Workout copied to your collection!');
                    // Refresh my workouts section
                    loadMyWorkouts();
                } else {
                    alert('Error copying workout: ' + data.message);
                }
            });
        }

        function loadMyWorkouts() {
            fetch('get_custom_workoutplan.php')
            .then(response => response.json())
            .then(data => {
                // Update my workouts section with new data
                updateWorkoutsGrid('my-workouts', data);
            });
        }

        // Update form submission to use AJAX
        document.getElementById('workout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const exercises = getSelectedExercises();
            formData.append('exercises', JSON.stringify(exercises));
            
            saveWorkout(formData);
        });

        // Rest of the JavaScript from previous implementation...
    </script>
</body>
</html>