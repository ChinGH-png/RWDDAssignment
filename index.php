<?php include 'database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FITPM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Center sun/moon icons in toggle switch*/
        .slider .icon,
        .slider .icon-moon {
            position: absolute;
            top: 50%;
            left: 17px;
            transform: translate(-50%, -50%);
            font-size: 18px;
            transition: opacity 0.4s, left 0.4s;
            pointer-events: none;
        }
        .slider .icon {
            color: #FFD600;
            opacity: 1;
        }
        .slider .icon-moon {
            color: #00ff7f;
            opacity: 0;
        }
        .toggle-switch input:checked + .slider .icon {
            opacity: 0;
        }
        .toggle-switch input:checked + .slider .icon-moon {
            opacity: 1;
            left: 53px;
        }
        /* Make toggle background full green in light mode */
        .slider {
            background: #2E8B57 !important;
        }
        /* When dark mode is active, revert to original gradient */
        body.dark-mode .slider {
            background: linear-gradient(90deg, #4fc3f7 60%, #222 100%) !important;
        }
        /* Add better contrast for form labels and text */
        .auth-container label,
        .auth-container .auth-title,
        .auth-container p,
        .auth-container a {
            color: #fff !important;
            transition: color 0.3s;
        }
        /* Light mode: black text */
        body:not(.dark-mode) .auth-container label,
        body:not(.dark-mode) .auth-container .auth-title,
        body:not(.dark-mode) .auth-container p,
        body:not(.dark-mode) .auth-container a {
            color: #111 !important;
        }
        .auth-container input,
        .auth-container textarea {
            color: #111 !important;
            background: #fff !important;
        }

        /* --- Hover Effects for Interactive Elements --- */
        /* Buttons */
        .btn:hover,
        .btn:focus {
            background: #2196f3 !important;
            color: #fff !important;
            transform: scale(1.07);
            box-shadow: 0 2px 12px rgba(33,150,243,0.15);
            transition: background 0.2s, color 0.2s, transform 0.2s;
        }
        /* Cards */
        .content-card:hover,
        .card:hover {
            border-color: #2196f3 !important;
            color: #2196f3 !important;
            transform: scale(1.05);
            box-shadow: 0 4px 16px rgba(33,150,243,0.12);
            transition: border-color 0.2s, color 0.2s, transform 0.2s, box-shadow 0.2s;
        }
        /* Navigation links */
        nav a:hover,
        nav a:focus,
        .nav-container .logo:hover,
        .nav-container .logo:focus {
            color: #2196f3 !important;
            transform: scale(1.07);
            transition: color 0.2s, transform 0.2s;
        }
        /* Auth links */
        .auth-container a:hover,
        .auth-container a:focus {
            color: #2196f3 !important;
            transform: scale(1.07);
            transition: color 0.2s, transform 0.2s;
        }
        /* Social login buttons */
        .social-btn:hover,
        .social-btn:focus {
            background: #2196f3 !important;
            color: #fff !important;
            transform: scale(1.07);
            transition: background 0.2s, color 0.2s, transform 0.2s;
        }
        /* Filter buttons */
        .filter-btn:hover,
        .filter-btn:focus {
            background: #2196f3 !important;
            color: #fff !important;
            transform: scale(1.07);
            transition: background 0.2s, color 0.2s, transform 0.2s;
        }
        /* Menu toggle */
        .menu-toggle:hover,
        .menu-toggle:focus {
            color: #2196f3 !important;
            transform: scale(1.07);
            transition: color 0.2s, transform 0.2s;
        }
        /* Mission cards */
        .mission-card:hover,
        .mission-card:focus {
            color: #2196f3 !important;
            transform: scale(1.05);
            box-shadow: 0 4px 16px rgba(33,150,243,0.12);
            transition: color 0.2s, transform 0.2s, box-shadow 0.2s;
        }
        /* Comment post button */
        .post-comment:hover,
        .post-comment:focus {
            background: #2196f3 !important;
            color: #fff !important;
            transform: scale(1.07);
            transition: background 0.2s, color 0.2s, transform 0.2s;
        }

        /* Signup card styles (added) */
        body { --auth-bg: #0f0f0f; --card-bg:#151515; --muted:#cfcfcf; --accent:#86f28f; --accent-text:#063c11; }
        /* ensure main pages don't clash; target auth container specifically */
        .auth-container {
            max-width:420px;
            margin: 40px auto;
            background: var(--card-bg);
            padding: 26px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.6);
            border: 1px solid rgba(255,255,255,0.03);
        }
        .auth-title { text-align:center; color:#fff; margin:0 0 18px; font-size:20px; font-weight:700; }
        .auth-container .form-group { margin-bottom:14px; }
        .auth-container label { display:block; font-size:13px; margin-bottom:6px; color:var(--muted); }
        .auth-container .form-control {
            width:100%;
            padding:12px 14px;
            border-radius:8px;
            border:0;
            box-sizing:border-box;
            background:#fff;
            color:#111;
            font-size:14px;
        }
        .auth-container select.form-control { appearance:none; -webkit-appearance:none; -moz-appearance:none; }
        .form-options { margin:8px 0 16px; display:flex; align-items:center; gap:8px; color:var(--muted); }
        .form-options .remember-me { display:flex; align-items:center; gap:8px; }
        .form-options input[type="checkbox"] { width:16px; height:16px; }
        .btn-primary {
            background: var(--accent);
            color: var(--accent-text);
            border: none;
            padding:12px 14px;
            border-radius:10px;
            font-weight:600;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            width:100%;
            box-shadow: 0 2px 0 rgba(0,0,0,0.15);
            cursor:pointer;
        }
        .btn-primary:active { transform: translateY(1px); }
        .auth-container p, .auth-container a { color: var(--muted); text-align:center; }
        /* small responsive tweak */
        @media (max-width:480px) {
            .auth-container { margin:20px; padding:18px; border-radius:10px; }
        }

        /* --- Recipe Page Styles --- */
        /* Food Page */
        #food {
            padding: 2rem 0;
        }
        #food .filter-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        #food .filter-btn {
            background: #2196f3;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        #food .filter-btn:hover {
            background: #1976d2;
        }
        #food .filter-btn.active {
            background: #1976d2;
            pointer-events: none;
        }
        #food .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        #food .recipe-card {
            background: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        #food .recipe-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }
        #food .recipe-image {
            position: relative;
            height: 150px;
            overflow: hidden;
        }
        #food .recipe-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        #food .recipe-image:hover img {
            transform: scale(1.1);
        }
        #food .recipe-content {
            padding: 1rem;
        }
        #food .recipe-title {
            font-size: 1.2rem;
            margin: 0.5rem 0;
            color: #333;
        }
        #food .recipe-desc {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        #food .recipe-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #999;
        }

        /* Highlighted words in workout descriptions */
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }
    </style>
</head>

<body>
    
    <!-- Header Navigation -->
<header>
    <div class="nav-container">
        <!-- Menu Toggle Button (now on left) -->
        <div class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <div class="logo" onclick="showPage('home')">
            <i class="fas fa-dumbbell"></i>
            <span>FitPM</span>
        </div>
        
        <!-- Dark/Light Mode Toggle Button -->
        <button class="theme-toggle" id="themeToggle">
            <i class="fas fa-sun"></i>
        </button>
        
        <nav id="mainNav">
    <ul>
        <li><a onclick="showWorkoutTypePage(); hideMenu()" class="nav-workout"><i class="fas fa-running"></i> Workout</a></li>
        <li><a onclick="showCalendarPage(); hideMenu()" class="nav-calendar"><i class="fas fa-calendar-alt"></i> Calendar</a></li>
        <li><a onclick="showFoodPage(); hideMenu()" class="nav-food"><i class="fas fa-utensils"></i> Food</a></li>
        <li><a onclick="showPage('about'); hideMenu()" class="nav-about"><i class="fas fa-info-circle"></i> About</a></li>
    </ul>
</nav>
        
        <div class="auth-buttons desktop-auth">
            <button class="btn btn-login" onclick="showPage('login')"><i class="fas fa-sign-in-alt"></i> Login</button>
            <button class="btn btn-signup" onclick="showPage('signup')"><i class="fas fa-user-plus"></i> Sign Up</button>
            </a>
        </div>

        <!-- profile UI (hidden until user is signed in) -->
        <div class="profile-container" style="display:none; position:relative; margin-left:0.75rem;">
    <button id="profileBtn" style="background:transparent;border:none;cursor:pointer;display:flex;align-items:center;gap:0.5rem;">
        <div id="profileAvatar" style="width:36px;height:36px;border-radius:50%;background:#2196f3;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">U</div>
        <span id="profileName" style="color:var(--primary-green);font-weight:600;display:inline-block;"></span>
        <i class="fas fa-caret-down" style="color:var(--primary-green);"></i>
    </button>

        <!-- admin options -->
    <div id="profileDropdown" style="display:none; position:absolute; right:0; top:46px; background:var(--card-bg); border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.6); overflow:hidden; min-width:220px; z-index:1000;">
        <!-- Admin Only Section -->
        <div id="adminSection" style="display:none;">
            <a href="admin_dashboard.php" style="display:flex;align-items:center;gap:10px;padding:0.8rem 1rem;color:var(--dark-gray);text-decoration:none;border-bottom:1px solid rgba(255,255,255,0.03);transition:background 0.3s;">
                <i class="fas fa-tachometer-alt" style="color:#2196f3;width:16px;"></i>
                Dashboard
            </a>
        </div>
        
        <!-- Common Options for All Users -->
        <!-- Dynamic Profile Link -->
<a href="#" id="profileLink" style="display:flex;align-items:center;gap:10px;padding:0.8rem 1rem;color:var(--dark-gray);text-decoration:none;border-bottom:1px solid rgba(255,255,255,0.03);transition:background 0.3s;">
    <i class="fas fa-user" style="color:#4caf50;width:16px;"></i>
    Profile
</a>
        
        <a href="#" id="profileLogout" style="display:flex;align-items:center;gap:10px;padding:0.8rem 1rem;color:#e53935;text-decoration:none;transition:background 0.3s;">
            <i class="fas fa-sign-out-alt" style="width:16px;"></i>
            Logout
        </a>
    </div>
</div>


    <!-- changed background:#fff -> background:var(--card-bg) and stronger shadow for dark mode -->
    <div id="profileDropdown" style="display:none; position:absolute; right:0; top:46px; background:var(--card-bg); border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.6); overflow:hidden; min-width:220px;">
    <a href="userprofile.php" id="profileView" style="display:block;padding:0.6rem 0.9rem;color:var(--dark-gray);text-decoration:none;border-bottom:1px solid rgba(255,255,255,0.03);">Profile</a>
    <a href="#" id="profileLogout" style="display:block;padding:0.6rem 0.9rem;color:#e53935;text-decoration:none;">Logout</a>
</div>
</header>

    <!-- Home Page -->
    <main id="home" class="page active">
        <div class="container">
            <section class="hero">
                <div class="hero-content">
                    <h1>Welcome to Your Fitness Journey</h1>
                    <p>Start your healthy lifestyle today with personalized workout plans and nutrition guidance. Transform your body and mind with our expert-curated programs.</p>
                    <button class="btn btn-primary" onclick="showWorkoutTypePage()"><i class="fas fa-play"></i> Get Started</button>
                </div>
                <div class="hero-image">
                    <div>
                        <i class="fas fa-heartbeat" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                        <h3>Your Path to Wellness Starts Here</h3>
                    </div>
                </div>
            </section>

            <section class="section">
                <h2 class="section-title">Featured Workouts</h2>
                <div class="content-grid">
                    <!-- Cardio -->
                    <div class="content-card" onclick="startWorkout('cardio')">
                        <i class="fas fa-fire"></i>
                        <h3>Cardio Blast</h3>
                        <p>30-minute high intensity</p>
                    </div>
                    <!-- Strength -->
                    <div class="content-card" onclick="startWorkout('strength')">
                        <i class="fas fa-dumbbell"></i>
                        <h3>Strength Training</h3>
                        <p>Full body workout</p>
                    </div>
                    <!-- Yoga -->
                    <div class="content-card" onclick="startWorkout('yoga')">
                        <i class="fas fa-spa"></i>
                        <h3>Yoga Flow</h3>
                        <p>Relaxing yoga session</p>
                    </div>
                </div>
            </section>

            <section class="section">
                <h2 class="section-title">Nutrition Plans</h2>
                <div class="content-grid">
                    <div class="content-card" onclick="showFoodPage()">
                        <i class="fas fa-egg"></i>
                        <h3>Healthy Breakfast</h3>
                        <p>Start your day right</p>
                    </div>
                    <div class="content-card" onclick="showFoodPage()">
                        <i class="fas fa-apple-alt"></i>
                        <h3>Lunch Recipes</h3>
                        <p>Nutritious midday meals</p>
                    </div>
                    <div class="content-card" onclick="showFoodPage()">
                        <i class="fas fa-fish"></i>
                        <h3>Dinner Ideas</h3>
                        <p>Healthy evening options</p>
                    </div>
                </div>
            </section>
        </div>
        <div id="select-exercises" class="page">
  <h1>Select Exercises</h1>
  <div class="exercise-gallery" id="exerciseGallery"></div>
  <button class="btn btn-primary" onclick="saveSelectedExercises()">Save Selection</button>
</div>

    </main>
<!-- Custom Workout Creation & Viewing Page -->
<!-- Custom Workout Creation & Viewing Page -->
<main id="custom-workout" class="page">
    <div class="container">
        <h1 class="section-title">Custom Workouts</h1>
        
        <!-- Tab Navigation -->
        <div class="tab-navigation" style="margin-bottom: 2rem;">
            <button class="tab-btn active" onclick="showTab('create', event)">Create Workout</button>
            <button class="tab-btn" onclick="showTab('my-workouts', event)">My Workouts</button>
            <button class="tab-btn" onclick="showTab('public-workouts', event)">Public Workouts</button>
        </div>

        <!-- Create Workout Tab -->
        <div id="create-tab" class="tab-content active">
            <div class="auth-container">
                <h3>Create Custom Workout</h3>
                <form id="customWorkoutForm">
                    <div class="form-group">
                        <label>Workout Name</label>
                        <input type="text" id="workoutName" name="workout_name" class="form-control" placeholder="Enter workout name" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="workoutDescription" name="description" class="form-control" placeholder="Describe your workout" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Difficulty Level</label>
                        <select id="difficultyLevel" name="difficulty_level" class="form-control">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Make Public</label>
                        <input type="checkbox" id="isPublic" name="is_public" value="1">
                        <label for="isPublic" style="display: inline; margin-left: 0.5rem;">Share with community</label>
                    </div>

                    <!-- Exercise Selection Button -->
                    <div class="form-group">
                        <label>Select Exercises</label>
                        <button type="button" id="open-exercise-modal" class="btn btn-secondary" style="width: 100%; margin-bottom: 1rem;">
                            <i class="fas fa-plus"></i> Select Exercises from Library
                        </button>
                    </div>

                    <!-- Selected Exercises List -->
                    <div class="form-group">
                        <label>Workout Exercises</label>
                        <div id="selected-exercises-list" class="exercise-list" style="
                            border: 1px solid var(--light-gray);
                            border-radius: 8px;
                            padding: 1rem;
                            min-height: 100px;
                            background: #f9f9f9;
                            margin-bottom: 1rem;
                        ">
                            <div class="empty-state" style="text-align: center; padding: 2rem; color: #666;">
                                No exercises selected yet. Click the button above to add exercises.
                            </div>
                        </div>
                    </div>

                    <div id="responseMessage" style="margin: 1rem 0;"></div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Workout
                    </button>
                </form>
            </div>
        </div>

        <!-- My Workouts Tab -->
        <div id="my-workouts-tab" class="tab-content">
            <h3>My Custom Workouts</h3>
            <div id="myWorkouts" class="workout-grid">
                <div style="text-align: center; padding: 2rem; color: #666;">
                    No workouts yet. Create your first custom workout!
                </div>
            </div>
        </div>

        <!-- Public Workouts Tab -->
        <div id="public-workouts-tab" class="tab-content">
            <h3>Community Workouts</h3>
            <div id="publicWorkouts" class="workout-grid">
                <div style="text-align: center; padding: 2rem; color: #666;">
                    No public workouts available.
                </div>
            </div>
        </div>
    </div>
    
    <!-- Exercise Selection Modal -->
    <div id="exercise-modal" class="modal" style="
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    ">
        <div class="modal-content" style="
            background-color: white;
            border-radius: 12px;
            width: 90%;
            max-width: 700px;
            max-height: 80vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        ">
            <div class="modal-header" style="
                padding: 20px;
                border-bottom: 1px solid #eee;
                display: flex;
                justify-content: space-between;
                align-items: center;
            ">
                <h2 class="modal-title" style="
                    font-size: 20px;
                    font-weight: 600;
                    color: #2c3e50;
                ">Select Exercises</h2>
                <span class="close-modal" style="
                    font-size: 24px;
                    cursor: pointer;
                    color: #7f8c8d;
                ">&times;</span>
            </div>
            <div class="modal-body" style="
                padding: 20px;
                overflow-y: auto;
                flex-grow: 1;
            ">
                <div class="search-box" style="margin-bottom: 20px;">
                    <input type="text" id="exercise-search" class="form-control" placeholder="Search exercises...">
                </div>
                
                <div class="duration-selector" style="
                    display: flex;
                    gap: 10px;
                    margin-bottom: 20px;
                ">
                    <div class="duration-option selected" data-duration="30" style="
                        flex: 1;
                        text-align: center;
                        padding: 12px;
                        border: 2px solid #3498db;
                        border-radius: 6px;
                        cursor: pointer;
                        background-color: #3498db;
                        color: white;
                        font-weight: bold;
                    ">30 seconds</div>
                    <div class="duration-option" data-duration="45" style="
                        flex: 1;
                        text-align: center;
                        padding: 12px;
                        border: 2px solid #ddd;
                        border-radius: 6px;
                        cursor: pointer;
                        background-color: #f8f9fa;
                        color: #333;
                    ">45 seconds</div>
                </div>
                
                <div class="exercise-grid" id="exercise-library" style="
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                    gap: 15px;
                ">
                    <!-- Exercise cards will be populated here -->
                </div>
            </div>
            <div class="modal-footer" style="
                padding: 20px;
                border-top: 1px solid #eee;
                display: flex;
                justify-content: flex-end;
                gap: 10px;
            ">
                <button id="cancel-selection" class="btn btn-secondary">Cancel</button>
                <button id="add-selected-exercises" class="btn btn-primary">Add Selected to Workout</button>
            </div>
        </div>
    </div>
</main>

    <!-- Workout Type Selection Page -->
<main id="workout-type" class="page">
    <div class="container">
        <h2 class="section-title">Workout Type</h2>
        <div class="section" style="margin-bottom: 2.5rem;">
            <div class="search-filter-container" style="background: var(--light-gray); border-radius: 12px; padding: 1.5rem 1rem; box-shadow: var(--shadow); max-width: 800px; margin: 0 auto;">
                <h3 style="color: var(--primary-green); margin-bottom: 1rem; text-align: center;">Find Your Workout</h3>
                <div class="search-filter" style="gap: 0.75rem;">
                    <input type="text" class="search-box" placeholder="Search workouts...">
                    <div class="filter-options" style="justify-content: flex-start;">
                        <button class="filter-btn active" id="filter-all">All</button>
                        <button class="filter-btn" id="filter-cardio">Cardio</button>
                        <button class="filter-btn" id="filter-strength">Strength</button>
                        <button class="filter-btn" id="filter-yoga">Yoga</button>
                    </div>
                </div>
                <!-- Add exercise list container below filter bar -->
                <div id="exercise-list-container" style="margin: 1.5rem 0; text-align: center;"></div>
            </div>
        </div>

        <div class="section">
            <h3 style="color: var(--primary-green); margin-bottom: 1rem; text-align: center;">Available Workouts</h3>
            <div class="card-grid">
                <!-- Cardio Blast -->
                <div class="card" data-type="cardio" onclick="startWorkout('cardio')">
                    <div class="card-image" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <i class="fas fa-fire" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                        Cardio Blast
                    </div>
                    <div class="card-content">
                        <div class="card-title">Cardio Blast</div>
                        <p class="card-desc">30-minute high intensity cardio workout to burn calories and improve endurance.</p>
                        <div class="card-meta">
                            <span><i class="fas fa-clock"></i> 30 min</span>
                            <span><i class="fas fa-burn"></i> 350 cal</span>
                        </div>
                        <!-- Cardio example exercises -->
                        <div class="workout-examples" style="margin-top:0.5rem;">
                            <strong style="color:#2196f3;">Example Exercises:</strong>
                            <ul style="padding-left:1.25rem; margin:0.25rem 0 0 0;">
                                <li>Jumping Jacks</li>
                                <li>High Knees</li>
                                <li>Burpees</li>
                                <li>Mountain Climbers</li>
                                <li>Sprints</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Strength Training -->
                <div class="card" data-type="strength" onclick="startWorkout('strength')">
                    <div class="card-image" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <i class="fas fa-dumbbell" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                        Strength Training
                    </div>
                    <div class="card-content">
                        <div class="card-title">Strength Training</div>
                        <p class="card-desc">Full body strength workout focusing on major muscle groups.</p>
                        <div class="card-meta">
                            <span><i class="fas fa-clock"></i> 15-20 min</span>
                            <span><i class="fas fa-burn"></i> 280 cal</span>
                        </div>
                        <!-- Strength example exercises -->
                        <div class="workout-examples" style="margin-top:0.5rem;">
                            <strong style="color:#2196f3;">Example Exercises:</strong>
                            <ul style="padding-left:1.25rem; margin:0.25rem 0 0 0;">
                                <li>Squats</li>
                                <li>Push-ups</li>
                                <li>Deadlifts</li>
                                <li>Bench Press</li>
                                <li>Lunges</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Yoga Flow -->
                <div class="card" data-type="yoga" onclick="startWorkout('yoga')">
                    <div class="card-image" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <i class="fas fa-spa" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                        Yoga Flow
                    </div>
                    <div class="card-content">
                        <div class="card-title">Yoga Flow</div>
                        <p class="card-desc">Relaxing yoga session to improve flexibility and reduce stress.</p>
                        <div class="card-meta">
                            <span><i class="fas fa-clock"></i> 60 min</span>
                            <span><i class="fas fa-burn"></i> 180 cal</span>
                        </div>
                        <!-- Yoga example exercises -->
                        <div class="workout-examples" style="margin-top:0.5rem;">
                            <strong style="color:#2196f3;">Example Exercises:</strong>
                            <ul style="padding-left:1.25rem; margin:0.25rem 0 0 0;">
                                <li>Sun Salutation</li>
                                <li>Warrior II</li>
                                <li>Tree Pose</li>
                                <li>Downward Dog</li>
                                <li>Child's Pose</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Custom Workout -->
          <div class="card custom-workout-card" onclick="showPage('custom-workout')">
    <div class="card-image" style="background: linear-gradient(135deg, #00aaff, #007bff);">
        <i class="fas fa-bolt"></i>
        Custom Workout
    </div>
    <div class="card-content">
        <div class="card-title">Custom Workouts</div>
        <p class="card-desc">Create, manage, and browse custom workout routines.</p>
        <div class="card-meta">
            <span><i class="fas fa-users"></i> Community</span>
            <span><i class="fas fa-edit"></i> Create</span>
        </div>
    </div>
</div>


</main>

<!-- Food/Recipe Page -->
<main id="food" class="page">
    <div class="container">
        <div class="filter-section">
            <h2 class="section-title">Recipes</h2>
            <div class="search-filter">
                <input type="text" class="search-box" placeholder="Search recipes..." id="foodSearch">
                <div class="filter-options">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="Breakfast">Breakfast</button>
                    <button class="filter-btn" data-filter="Lunch">Lunch</button>
                    <button class="filter-btn" data-filter="Dinner">Dinner</button>
                    <button class="filter-btn" data-filter="Snacks">Snacks</button>
                </div>
            </div>
        </div>

        <div class="card-grid" id="recipeGrid">
            <!-- Recipes will be dynamically loaded here -->
        </div>
    </div>
</main>

    <!-- Workout Detail Page -->
    <main id="workout-detail" class="page">
	<div class="container">
		<div class="detail-header">
			<h1 class="section-title" id="runnerTitle">Workout</h1>
			<p id="runnerSubtitle">Follow the automatic exercise sequence</p>
		</div>

		<div class="detail-content" style="display:flex;gap:2rem;flex-wrap:wrap;">
			<!-- Left: exercise visual / list -->
			<div style="flex:1; min-width:300px;">
				<div id="exerciseCard" style="background:linear-gradient(135deg,#4fc3f7,#2e8b57);border-radius:12px;padding:2rem;color:#fff;text-align:center;">
					<div id="exerciseImage" style="width:100%;max-width:300px;margin:0 auto 1rem;border-radius:8px;overflow:hidden;display:none;">
						<img src="" alt="" style="width:100%;height:auto;display:block;">
					</div>
					<i id="exerciseIcon" class="fas fa-dumbbell" style="font-size:3rem;margin-bottom:0.5rem;"></i>
					<h3 id="exerciseName" style="margin:0.5rem 0;">Exercise</h3>
					<p id="exerciseDesc" style="opacity:0.95;">Instruction / details</p>
				</div>

				<div id="exerciseListContainer" style="margin-top:1rem;">
					<h4 style="color:var(--primary-green);">Exercise Sequence</h4>
					<ul id="exerciseList" style="list-style:decimal;padding-left:1.25rem;"></ul>
				</div>
			</div>

			<!-- Right: timer and controls -->
			<div style="flex:0 0 360px; min-width:260px;">
				<div class="timer-block" style="text-align:center;">
					<h3 style="color:var(--primary-green);">Workout Timer</h3>
					<div id="runnerTimer" style="font-size:2.5rem;font-weight:700;color:#4caf50;margin:0.5rem 0;">00:00</div>
					<div style="display:flex;gap:0.5rem;justify-content:center;margin:0.75rem 0;">
						<button id="runnerStart" class="btn"><i class="fas fa-play"></i> Start</button>
						<button id="runnerPause" class="btn"><i class="fas fa-pause"></i> Pause</button>
						<button id="runnerReset" class="btn"><i class="fas fa-redo"></i> Reset</button>
						<!-- Skip current exercise -->
						<button id="runnerSkip" class="btn" style="background:#f57c00;color:#fff;"><i class="fas fa-forward"></i> Skip</button>
					</div>

					<button id="runnerMarkDone" class="btn btn-primary" style="width:100%;margin-top:1rem;"><i class="fas fa-check"></i> Mark as Done!</button>
				</div>
			</div>
		</div>

		<div class="nav-buttons" style="margin-top:1.25rem;">
			<button class="btn" onclick="showPage('workout-type')"><i class="fas fa-arrow-left"></i> Back</button>
			<!-- Next exercise removed (auto-advance) -->
		</div>
	</div>
</main>

   <!-- Food Detail Page -->
<main id="food-detail" class="page">
    <div class="container">
        <div class="detail-header">
            <h1 class="section-title" id="recipeTitle">Recipe</h1>
            <p id="recipeSubtitle">Meal details</p>
        </div>

        <div class="detail-content">
            <div class="detail-image" id="recipeImage">
                <!-- Recipe image will be dynamically loaded -->
            </div>
            <div class="detail-info">
                <div class="info-section">
                    <h3>Ingredients</h3>
                    <ul class="ingredients-list" id="recipeIngredients">
                        <!-- Ingredients will be dynamically loaded -->
                    </ul>
                </div>
                
                <div class="info-section">
                    <h3>Instructions</h3>
                    <ol class="instructions-list" id="recipeInstructions">
                        <!-- Instructions will be dynamically loaded -->
                    </ol>
                </div>
                
                <div class="info-section">
                    <h3>Nutrition Information</h3>
                    <p id="recipeNutrition">Nutrition details</p>
                </div>
            </div>
        </div>

        <div class="comments-section">
            <h3>Comments</h3>
            <div class="comment">
                <div class="comment-header">
                    <span>USERNAME 01</span>
                    <span>Apr 30, 2025</span>
                </div>
                <p>This recipe is amazing! So easy to make and delicious. I added some cherry tomatoes for extra flavor.</p>
            </div>
            <div class="comment">
                <div class="comment-header">
                    <span>USERNAME 02</span>
                    <span>Apr 25, 2025</span>
                </div>
                <p>Great recipe, highly recommend! I used different vegetables and it turned out perfect.</p>
            </div>
            <div class="form-group">
                <textarea class="form-control comment-text" placeholder="Leave a comment" rows="3"></textarea>
                <button class="btn btn-primary post-comment" style="margin-top: 1rem; width: 100%;"><i class="fas fa-comment"></i> Post Comment</button>
            </div>
        </div>

        <div class="nav-buttons">
            <button class="btn" onclick="showPage('food')"><i class="fas fa-arrow-left"></i> Back to Recipes</button>
        </div>
    </div>
</main>

    <!-- Calendar Page -->
<main id="calendar" class="page">
    <div class="container">
        <h1 class="section-title">Workout Calendar</h1>
        <div class="calendar-container">
            <div class="calendar-header">
                <button id="prev-month" class="calendar-nav-btn"><i class="fas fa-chevron-left"></i></button>
                <h2 id="current-month">October 2025</h2>
                <button id="next-month" class="calendar-nav-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
            
            <!-- Calendar grid with proper structure -->
            <div class="calendar-grid">
                <div class="calendar-day-header">Sun</div>
                <div class="calendar-day-header">Mon</div>
                <div class="calendar-day-header">Tue</div>
                <div class="calendar-day-header">Wed</div>
                <div class="calendar-day-header">Thu</div>
                <div class="calendar-day-header">Fri</div>
                <div class="calendar-day-header">Sat</div>
                <!-- Calendar days will be added by JavaScript -->
            </div>
            
            <!-- Monthly summary will be added here -->
            <div id="monthly-summary" class="monthly-summary"></div>
        </div>
    </div>
</main>

    <!-- About Us Page -->
    <main id="about" class="page">
        <div class="container">
            <div class="about-content">
                <h1 class="section-title">About Us</h1>
                <div class="about-text">
                    <p>Welcome to FIT PM! We are dedicated to helping you achieve your fitness goals through personalized workout plans and nutrition guidance.</p>
                    <p>Our mission is to make healthy living accessible to everyone. Whether you're just starting your fitness journey or looking to take your training to the next level, we have the resources and support you need.</p>
                    <p>At FIT PM, we believe that fitness should be enjoyable and sustainable. Our team of certified trainers and nutrition experts work tirelessly to create content that is both effective and engaging.</p>
                    <p>Join our community of fitness enthusiasts and start transforming your life today! Together, we can achieve amazing results and build healthier habits that last a lifetime.</p>
                </div>
                
                <div class="mission-grid">
                    <div class="mission-card">
                        <i class="fas fa-bullseye"></i>
                        <h3>Our Mission</h3>
                        <p>To make fitness accessible and enjoyable for everyone, regardless of their starting point.</p>
                    </div>
                    <div class="mission-card">
                        <i class="fas fa-eye"></i>
                        <h3>Our Vision</h3>
                        <p>A world where everyone enjoys the benefits of a healthy, active lifestyle.</p>
                    </div>
                    <div class="mission-card">
                        <i class="fas fa-hand-holding-heart"></i>
                        <h3>Our Values</h3>
                        <p>Quality, Accessibility, Community, and Sustainable Results.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Login Page -->
    <main id="login" class="page">
        <div class="container">
            <div class="auth-container">
                <h2 class="auth-title">Sign In</h2>
                
                <!-- inline message for login/register feedback -->
                <div id="loginMessage" style="text-align:center;margin-bottom:0.75rem;color:#e53935;"></div>
                
                <form id="loginForm">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="wwwwww@gmail.com" id="loginEmail" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="**********" id="loginPassword" required>
                    </div>
                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember">
                            <label for="remember">Remember Password 😊</label>
                        </div>
                        <a href="#" style="color: var(--primary-green);">Forgot Password?</a>
                    </div>
                    <button type="submit" id="loginSubmit" class="btn btn-primary" style="width: 100%;"><i class="fas fa-sign-in-alt"></i> Sign In</button>
                </form>
                
                <p style="text-align: center; margin-top: 1rem;">
                    Don't have an account? <a href="#" onclick="showPage('signup')" style="color: var(--primary-green);">Sign Up</a>
                </p>
            </div>
        </div>
    </main>

    <!-- Signup Page -->
    <main id="signup" class="page">
        <div class="container">
            <div class="auth-container" role="region" aria-label="Create account">
                <h2 class="auth-title">Create Account</h2>
                
                <form id="signupForm" novalidate>
                    <div class="form-group">
                        <label for="signupFullName">Full Name</label>
                        <input id="signupFullName" type="text" class="form-control" placeholder="Enter your full name">
                    </div>

                    <div class="form-group">
                        <label for="signupEmail">Email</label>
                        <input id="signupEmail" type="email" class="form-control" placeholder="example@gmail.com" required>
                    </div>

                    <div class="form-group">
                        <label for="signupGender">Gender</label>
                        <select id="signupGender" class="form-control">
                            <option value="" disabled selected>Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Prefer not to say</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="signupGoal">Fitness Goal</label>
                        <select id="signupGoal" class="form-control">
                            <option value="" disabled selected>Select your primary goal</option>
                            <option>Lose weight</option>
                            <option>Build muscle</option>
                            <option>Maintain fitness</option>
                            <option>Improve endurance</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="signupPassword">Password</label>
                        <input id="signupPassword" type="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <div class="form-group">
                        <label for="signupConfirm">Confirm Password</label>
                        <input id="signupConfirm" type="password" class="form-control" placeholder="Confirm password" required>
                    </div>

                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="terms" required>
                            <label for="terms">I agree to the Terms and Conditions</label>
                        </div>
                    </div>

                    <div id="signupMessage" style="text-align:center;margin-top:0.25rem;color:#e53935;"></div>

                    <button type="submit" id="signupSubmit" class="btn-primary"><i class="fas fa-user-plus"></i> Create Account</button>
                    
                    <p style="margin-top:12px;">Already have an account? <a href="#" onclick="showPage('login')">Sign In</a></p>
                </form>
            </div>
        </div>
    </main>
<main id="workout-detail" class="page">
	<div class="container">
		<div class="detail-header">
			<h1 class="section-title" id="runnerTitle">Workout</h1>
			<p id="runnerSubtitle">Follow the automatic exercise sequence</p>
		</div>

		<div class="detail-content" style="display:flex;gap:2rem;flex-wrap:wrap;">
			<!-- Left: exercise visual / list -->
			<div style="flex:1; min-width:300px;">
				<div id="exerciseCard" style="background:linear-gradient(135deg,#4fc3f7,#2e8b57);border-radius:12px;padding:2rem;color:#fff;text-align:center;">
					<div id="exerciseImage" style="width:100%;max-width:300px;margin:0 auto 1rem;border-radius:8px;overflow:hidden;display:none;">
						<img src="" alt="" style="width:100%;height:auto;display:block;">
					</div>
					<i id="exerciseIcon" class="fas fa-dumbbell" style="font-size:3rem;margin-bottom:0.5rem;"></i>
					<h3 id="exerciseName" style="margin:0.5rem 0;">Exercise</h3>
					<p id="exerciseDesc" style="opacity:0.95;">Instruction / details</p>
				</div>

				<div id="exerciseListContainer" style="margin-top:1rem;">
					<h4 style="color:var(--primary-green);">Exercise Sequence</h4>
					<ul id="exerciseList" style="list-style:decimal;padding-left:1.25rem;"></ul>
				</div>
			</div>

			<!-- Right: timer and controls -->
			<div style="flex:0 0 360px; min-width:260px;">
				<div class="timer-block" style="text-align:center;">
					<h3 style="color:var(--primary-green);">Workout Timer</h3>
					<div id="runnerTimer" style="font-size:2.5rem;font-weight:700;color:#4caf50;margin:0.5rem 0;">00:00</div>
					<div style="display:flex;gap:0.5rem;justify-content:center;margin:0.75rem 0;">
						<button id="runnerStart" class="btn"><i class="fas fa-play"></i> Start</button>
						<button id="runnerPause" class="btn"><i class="fas fa-pause"></i> Pause</button>
						<button id="runnerReset" class="btn"><i class="fas fa-redo"></i> Reset</button>
						<!-- Skip current exercise -->
						<button id="runnerSkip" class="btn" style="background:#f57c00;color:#fff;"><i class="fas fa-forward"></i> Skip</button>
					</div>

					<button id="runnerMarkDone" class="btn btn-primary" style="width:100%;margin-top:1rem;"><i class="fas fa-check"></i> Mark as Done!</button>
				</div>
			</div>
		</div>

		<div class="nav-buttons" style="margin-top:1.25rem;">
			<button class="btn" onclick="showPage('workout-type')"><i class="fas fa-arrow-left"></i> Back</button>
			<!-- Next exercise removed (auto-advance) -->
		</div>
	</div>
</main>

    <!-- Footer -->
    <footer>
        <div class="copyright">
            Copyright © 2025 FIT PM Healthy Lifestyle. All rights reserved.
        </div>
    </footer>
    <script src="script.js"></script>
    <script>
    // --- SPA Back/Forward Navigation ---

    // Save the original showPage function if it exists
    const _origShowPage = window.showPage;

    // Enhanced showPage: push state to history
    window.showPage = function(pageId) {
        // ...existing code to show/hide pages...
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        const page = document.getElementById(pageId);
        if (page) page.classList.add('active');
        // Push state if not triggered by popstate
        if (!window._navigatingByPopState) {
            history.pushState({ pageId }, '', '#' + pageId);
        }
        window._navigatingByPopState = false;
    };

    // On initial load, show page from hash or default to 'home'
    document.addEventListener('DOMContentLoaded', function() {
        const initialPage = location.hash ? location.hash.substring(1) : 'home';
        window.showPage(initialPage);
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        window._navigatingByPopState = true;
        const pageId = (event.state && event.state.pageId) || (location.hash ? location.hash.substring(1) : 'home');
        window.showPage(pageId);
    });

    // --- Auth UI updates: show profile when signed in (with Cookies) ---
(function() {
    const authButtons = document.querySelector('.auth-buttons.desktop-auth');
    const profileContainer = document.querySelector('.profile-container');
    const profileAvatar = document.getElementById('profileAvatar');
    const profileName = document.getElementById('profileName');
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    const profileLogout = document.getElementById('profileLogout');
    const adminSection = document.getElementById('adminSection');

    // Get user data from cookie
    function getUserData() {
        const cookies = document.cookie.split(';');
        for (let cookie of cookies) {
            const [name, value] = cookie.trim().split('=');
            if (name === 'fitpm_user' && value) {
                try {
                    return JSON.parse(decodeURIComponent(value));
                } catch (e) {
                    console.error('Error parsing user cookie:', e);
                }
            }
        }
        return null;
    }

    function checkLoginStatus() {
        const cookies = document.cookie.split(';');
        for (let cookie of cookies) {
            const [name, value] = cookie.trim().split('=');
            if (name === 'fitpm_login' && value === '1') {
                return true;
            }
        }
        return false;
    }

    function initialsFromName(name) {
        if (!name) return 'U';
        return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
    }

    window.updateAuthUI = function() {
    const isLoggedIn = checkLoginStatus();
    const userData = getUserData();
    
    if (isLoggedIn && userData) {
        // User is logged in
        if (authButtons) authButtons.style.display = 'none';
        if (profileContainer) profileContainer.style.display = 'flex';
        
        const isAdmin = userData.role === 'admin';
        
        if (profileAvatar) profileAvatar.textContent = initialsFromName(userData.name);
        if (profileName) { 
            if (isAdmin) {
                profileName.innerHTML = `${userData.name} <span style="background:#ff6b6b;color:white;padding:2px 6px;border-radius:10px;font-size:10px;margin-left:5px;">Admin</span>`;
            } else {
                profileName.textContent = userData.name;
            }
            profileName.style.display = 'inline-block'; 
        }

        // Show/hide admin section
        if (adminSection) {
            adminSection.style.display = isAdmin ? 'block' : 'none';
        }

        // Update profile link based on role - ADD THIS
        const profileLink = document.getElementById('profileLink');
        if (profileLink) {
            if (isAdmin) {
                profileLink.href = 'adminprofile.php';
            } else {
                profileLink.href = 'userprofile.php';
            }
        }
    } else {
        // User is not logged in
        if (authButtons) authButtons.style.display = '';
        if (profileContainer) profileContainer.style.display = 'none';
    }
};

    // Toggle dropdown
    if (profileBtn) {
        profileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const currentDisplay = profileDropdown.style.display;
            profileDropdown.style.display = currentDisplay === 'block' ? 'none' : 'block';
        });
    }
    
    // Logout
    if (profileLogout) {
        profileLogout.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Clear localStorage
            localStorage.removeItem('fitpm_user');
            localStorage.removeItem('fitpm_name');
            localStorage.removeItem('fitpm_user_role');
            
            // Call server logout
            fetch('logout.php')
                .then(() => {
                    updateAuthUI();
                    showPage('home');
                })
                .catch(err => {
                    console.error('Logout error:', err);
                    // Fallback: manually clear cookies
                    document.cookie = "fitpm_user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                    document.cookie = "fitpm_login=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                    updateAuthUI();
                    showPage('home');
                });
        });
    }

    // Close dropdown on outside click
    document.addEventListener('click', function(e) {
        if (profileContainer && !profileContainer.contains(e.target)) {
            profileDropdown.style.display = 'none';
        }
    });

    // Initial run on load
    document.addEventListener('DOMContentLoaded', updateAuthUI);
})();

    // --- Update login/register flow to save current user ---
    // ...existing login handler code ...
    // inside the successful login/register branches (API or local fallback),
    // add: localStorage.setItem('fitpm_user', email); and call updateAuthUI();

    // Replace the relevant success locations in the existing login handler:
    // (Below are the three places to add these two lines)
    //
    // 1) After successful API login:
    //     if (data && data.token) localStorage.setItem('fitpm_token', data.token);
    //     localStorage.setItem('fitpm_user', email);
    //     updateAuthUI();
    //
    // 2) After successful API registration:
    //     if (rdata && rdata.token) localStorage.setItem('fitpm_token', rdata.token);
    //     localStorage.setItem('fitpm_user', email);
    //     updateAuthUI();
    //
    // 3) In localStorage fallback when signing in or after creating local user:
    //     localStorage.setItem('fitpm_token', 'local-' + btoa(email));
    //     localStorage.setItem('fitpm_user', email);
    //     updateAuthUI();
    //
    // (The main login handler block is large; please insert the three lines exactly at those three success spots.)
    //
    // ...existing code...

    // --- Login -> register flow (client-side) ---
	(function() {
		const loginForm = document.getElementById('loginForm');
		const loginMessage = document.getElementById('loginMessage');
		const loginSubmit = document.getElementById('loginSubmit');

		function showMsg(msg, color = '#e53935') {
			loginMessage.style.color = color;
			loginMessage.textContent = msg;
		}

		async function apiPost(path, payload) {
			const res = await fetch(path, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(payload),
			});
			return res;
		}

		// LocalStorage fallback user store (only used if network fails)
		const LS_USERS_KEY = 'fitpm_users';
		function lsGetUsers() {
			try { return JSON.parse(localStorage.getItem(LS_USERS_KEY) || '{}'); } catch(e){ return {}; }
		}
		function lsSaveUser(email, password) {
			const users = lsGetUsers(); users[email] = { password }; localStorage.setItem(LS_USERS_KEY, JSON.stringify(users));
		}
		function lsCheckUser(email, password) {
			const users = lsGetUsers(); return users[email] && users[email].password === password;
		}
		function lsUserExists(email) {
			const users = lsGetUsers(); return !!users[email];
		}

		loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            showMsg('');
            loginSubmit.disabled = true;
            
            const formData = new FormData();
            formData.append('email', document.getElementById('loginEmail').value.trim());
            formData.append('password', document.getElementById('loginPassword').value);
            try {
                showMsg('Signing in...', '#333');
                const res = await fetch('login.php', {
                    method: 'POST',
                    body: formData
                });
        
                const data = await res.json();
                if (data.success) {
                    // Store user info with role
                    localStorage.setItem('fitpm_user', data.user.email);
                    localStorage.setItem('fitpm_name', data.user.name);
                    localStorage.setItem('fitpm_user_role', data.user.role);
                    localStorage.setItem('fitpm_user_table', data.user.table);
                    
                    // Update UI
                    updateAuthUI();
                    
                    showMsg(`Signed in as ${data.user.role === 'admin' ? 'Admin' : 'User'} successfully!`, '#2e7d32');
                    
                    // Redirect based on role
                    setTimeout(() => {
                        if (data.user.role === 'admin') {
                            window.location.href = 'admin_dashboard.php';
                        } else {
                            showPage('home');
                        }
                    }, 1000);
                } else {
                    showMsg(data.error || 'Login failed');
                }
            } catch (err) {
                console.error('Login error:', err);
                showMsg('Login failed. Please try again.');
            }
            
            loginSubmit.disabled = false;
        });
	})();

    /* --- Automatic Exercise Runner (per-category 15-item pools, randomized selection + specific icons) --- */
(function(){
	// Per-category pools (15 distinct exercises each; selection size will vary 8-10)
	const cardioPool = [
		"Jumping Jacks","High Knees","Burpees","Mountain Climbers","Sprints",
		"Butt Kickers","Skaters","Jump Rope","Tuck Jumps","Lateral Hops",
		"Jump Lunges","Speed Skaters","Box Jumps","Stair Runs","Power Knees"
	];
	const strengthPool = [
		"Squats","Push-ups","Deadlifts","Bench Press","Lunges",
		"Overhead Press","Bent-over Row","Biceps Curls","Tricep Dips","Romanian Deadlift",
		"Chest Fly","Calf Raises","Hip Thrusts","Farmer Carry","Pull-ups"
	];
	const yogaPool = [
		"Sun Salutations","Warrior II","Tree Pose","Downward Dog","Child's Pose",
		"Bridge Pose","Camel Pose","Seated Twist","Standing Forward Bend","Cat-Cow",
		"Pigeon Pose","Boat Pose","Chair Pose","Eagle Pose","Reclining Bound Angle"
	];

	// Fisher–Yates shuffle
	function shuffle(arr) {
		for (let i = arr.length - 1; i > 0; i--) {
			const j = Math.floor(Math.random() * (i + 1));
			[arr[i], arr[j]] = [arr[j], arr[i]];
		}
		return arr;
	}

	// durations: randomly 30 or 45 seconds for all exercises
function getDurationFor(ex) {
    if (!ex || !ex.name) return Math.random() < 0.5 ? 30 : 45;
    const n = ex.name.toLowerCase();
    
    // Keep warmup and cooldown longer
    if (n.includes('warm')) return 300;
    if (n.includes('cool')) return 180;
    
    // For all other exercises, randomly choose 30 or 45 seconds
    return Math.random() < 0.5 ? 30 : 45;
}

	// explicit icon map (FontAwesome classes) for known exercises
	const ICON_MAP = {
		/* Cardio */
		"Jumping Jacks": "fas fa-running",
		"High Knees": "fas fa-running",
		"Burpees": "fas fa-fire",
		"Mountain Climbers": "fas fa-mountain",
		"Sprints": "fas fa-tachometer-alt",
		"Butt Kickers": "fas fa-walking",
		"Skaters": "fas fa-bolt",
		"Jump Rope": "fas fa-person-jumping", // fallback acceptable
		"Tuck Jumps": "fas fa-arrow-up",
		"Lateral Hops": "fas fa-arrows-alt-h",
		"Jump Lunges": "fas fa-running",
		"Speed Skaters": "fas fa-bolt",
		"Box Jumps": "fas fa-box",
		"Stair Runs": "fas fa-step-forward",
		"Power Knees": "fas fa-bolt",

		/* Strength */
		"Squats": "fas fa-dumbbell",
		"Push-ups": "fas fa-hands",
		"Deadlifts": "fas fa-weight-hanging",
		"Bench Press": "fas fa-dumbbell",
		"Lunges": "fas fa-walking",
		"Overhead Press": "fas fa-arrow-up",
		"Bent-over Row": "fas fa-dumbbell",
		"Biceps Curls": "fas fa-hand-rock",
		"Tricep Dips": "fas fa-chair",
		"Romanian Deadlift": "fas fa-weight-hanging",
		"Chest Fly": "fas fa-heart",
		"Calf Raises": "fas fa-shoe-prints",
		"Hip Thrusts": "fas fa-arrow-up",
		"Farmer Carry": "fas fa-briefcase",
		"Pull-ups": "fas fa-arrows-alt-v",

		/* Yoga */
		"Sun Salutations": "fas fa-sun",
		"Warrior II": "fas fa-shield-alt",
		"Tree Pose": "fas fa-tree",
		"Downward Dog": "fas fa-paw",
		"Child's Pose": "fas fa-child",
		"Bridge Pose": "fas fa-archway",
		"Camel Pose": "fas fa-couch",
		"Seated Twist": "fas fa-sync-alt",
		"Standing Forward Bend": "fas fa-arrow-down",
		"Cat-Cow": "fas fa-cat",
		"Pigeon Pose": "fas fa-dove",
		"Boat Pose": "fas fa-ship",
		"Chair Pose": "fas fa-chair",
		"Eagle Pose": "fas fa-feather",
		"Reclining Bound Angle": "fas fa-bed"
	};

	function iconForName(name) {
		if (!name) return 'fas fa-bolt';
		return ICON_MAP[name] || (name.toLowerCase().includes('run') ? 'fas fa-running' :
			name.toLowerCase().includes('squat') ? 'fas fa-dumbbell' :
			name.toLowerCase().includes('jump') ? 'fas fa-bolt' : 'fas fa-bolt');
	}

	let runnerExercises = [];
	let runnerIndex = 0;
	let runnerRemaining = 0;
	let runnerTimerId = null;
	let runnerPaused = true;
	let currentWorkoutType = 'cardio';

	// DOM refs
	const runnerTitle = document.getElementById('runnerTitle');
	const runnerSubtitle = document.getElementById('runnerSubtitle');
	const exerciseName = document.getElementById('exerciseName');
	const exerciseDesc = document.getElementById('exerciseDesc');
	const exerciseIcon = document.getElementById('exerciseIcon');
	const exerciseList = document.getElementById('exerciseList');
	const runnerTimer = document.getElementById('runnerTimer');
	const startBtn = document.getElementById('runnerStart');
	const pauseBtn = document.getElementById('runnerPause');
	const resetBtn = document.getElementById('runnerReset');
	const markDoneBtn = document.getElementById('runnerMarkDone');
	const skipBtn = document.getElementById('runnerSkip'); // <-- new

	function fmt(s){ const m = Math.floor(s/60); const sec = s%60; return `${String(m).padStart(2,'0')}:${String(sec).padStart(2,'0')}`; }

	function renderList(){
		if (!exerciseList) return;
		exerciseList.innerHTML = '';
		runnerExercises.forEach((ex, i) => {
			const li = document.createElement('li');
			li.textContent = `${ex.name} (${fmt(getDurationFor(ex))})`;
			if (i === runnerIndex) { li.style.fontWeight = '700'; li.style.color = '#4caf50'; }
			exerciseList.appendChild(li);
		});
	}

	function renderCurrent(){
		const ex = runnerExercises[runnerIndex];
		const exerciseImage = document.getElementById('exerciseImage');
		
		if (!ex) {
			exerciseName.textContent = 'Done';
			exerciseDesc.textContent = 'All exercises complete';
			exerciseIcon.className = 'fas fa-flag-checkered';
			runnerTimer.textContent = '00:00';
			if (exerciseImage) exerciseImage.style.display = 'none';
			return;
		}
		
		exerciseName.textContent = ex.name;
		exerciseDesc.textContent = ex.type === 'rest' ? 'Rest' : 'Perform the exercise';
		exerciseIcon.className = iconForName(ex.name);
		
		// Handle exercise image
		if (exerciseImage) {
			const imgSrc = EXERCISE_IMAGES[ex.name];
			if (imgSrc) {
				exerciseImage.style.display = 'block';
				exerciseImage.querySelector('img').src = imgSrc;
				exerciseImage.querySelector('img').alt = ex.name;
			} else {
				exerciseImage.style.display = 'none';
			}
		}
		
		runnerRemaining = getDurationFor(ex);
		runnerTimer.textContent = fmt(runnerRemaining);
		renderList();
	}

	function stopTimer(){ if (runnerTimerId) { clearInterval(runnerTimerId); runnerTimerId = null; } }
	function startTimer(){ if (runnerTimerId) return; runnerPaused = false; runnerTimerId = setInterval(()=> {
		if (runnerRemaining > 0) { runnerRemaining -= 1; runnerTimer.textContent = fmt(runnerRemaining); }
		else { stopTimer(); nextExercise(); }
	}, 1000); }
	function pauseTimer(){ runnerPaused = true; stopTimer(); }
	function resetTimer(){ stopTimer(); renderCurrent(); runnerPaused = true; }

	function nextExercise(){
		runnerIndex++;
		if (runnerIndex >= runnerExercises.length) {
			exerciseName.textContent = 'Workout Complete';
			exerciseDesc.textContent = 'Great job! Mark as done or go back.';
			exerciseIcon.className = 'fas fa-check-circle';
			runnerTimer.textContent = '00:00';
			renderList();
			return;
		}
		renderCurrent();
		startTimer();
	}

	// helper: random integer inclusive
	function randomInt(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	// build workout: warmup + N random unique exercises from pool + cooldown
	// N is randomly chosen between 8 and 10 unless specified
	function buildWorkoutFromPool(pool, middleCount = null) {
		const poolCopy = pool.slice();
		shuffle(poolCopy);
		// pick random count if not provided
		const count = (typeof middleCount === 'number' && middleCount > 0) ? Math.min(middleCount, poolCopy.length) : randomInt(8, 10);
		const middle = poolCopy.slice(0, count).map(name => ({ name, type:'work' }));
		// warmup + middle + cooldown
		const sequence = [{ name: 'Warm up (light cardio & mobility)', type:'warmup' }, ...middle, { name: 'Cool down (stretching)', type:'cooldown' }];
		return sequence;
	}

	// --- New: daily cache helpers ---
	function todayKey(type) {
		const d = new Date();
		const y = d.getFullYear();
		const m = String(d.getMonth()+1).padStart(2,'0');
		const day = String(d.getDate()).padStart(2,'0');
		return `fitpm_workout_${type}_${y}-${m}-${day}`;
	}
	function saveDailyWorkout(type, sequence) {
		try { localStorage.setItem(todayKey(type), JSON.stringify(sequence)); } catch(e){ /* ignore */ }
	}
	function loadDailyWorkout(type) {
		try {
			const v = localStorage.getItem(todayKey(type));
			return v ? JSON.parse(v) : null;
		} catch(e){ return null; }
	}
	// --- End daily cache helpers ---

	// external entry (updated to use daily cache)
	window.startWorkout = function(type = 'cardio'){
    if (!requireAuth('access workouts')) return;
    
    currentWorkoutType = type;

		// Try to load today's cached workout for this type
		let sequence = loadDailyWorkout(type);

		// If not present, build and cache it (randomized once per day)
		if (!sequence) {
			if (type === 'cardio') sequence = buildWorkoutFromPool(cardioPool);
			else if (type === 'strength') sequence = buildWorkoutFromPool(strengthPool);
		
		
			else if (type === 'yoga') sequence = buildWorkoutFromPool(yogaPool);
			else sequence = buildWorkoutFromPool(cardioPool);

			// store the sequence (array of objects) for today's reuse
			saveDailyWorkout(type, sequence);
		}

		// Ensure runnerExercises is an array of {name, type}
		runnerExercises = (sequence || []).map(item => {
			// if older storage used plain strings, normalize
			if (typeof item === 'string') return { name: item, type: 'work' };
			return item;
		});

		runnerIndex = 0;
		runnerPaused = true;
		renderStateForType(currentWorkoutType);
		showPage('workout-detail');
		renderCurrent();
	};

	function renderStateForType(type){
		const titleMap = { cardio: 'Cardio Blast Workout', strength: 'Strength Training Workout', yoga: 'Yoga Flow Workout', custom:'Custom Workout' };
		runnerTitle.textContent = titleMap[type] || 'Workout';
		runnerSubtitle.textContent = 'Auto sequence — follow the timer';
	}

	// wire controls
	if (startBtn) startBtn.addEventListener('click', ()=> { if (!runnerExercises.length) return; startTimer(); });
	if (pauseBtn) pauseBtn.addEventListener('click', ()=> { pauseTimer(); });
	if (resetBtn) resetBtn.addEventListener('click', ()=> { resetTimer(); });
	if (markDoneBtn) markDoneBtn.addEventListener('click', ()=> { 
    pauseTimer(); 
    
    // Calculate total workout time in seconds
    const totalWorkoutSeconds = runnerExercises.reduce((total, ex) => total + getDurationFor(ex), 0);
    const completedExercises = runnerExercises.filter(ex => ex.type === 'work');
    
    
    
    // Save workout completion
    saveWorkoutCompletion(estimatedCalories, 1);
    
    alert(`Workout completed! Estimated calories burned: ${estimatedCalories}`);
    
    // Update calendar display if we're on the calendar page
    if (document.getElementById('calendar').classList.contains('active')) {
        const today = new Date();
        updateCalendar(today.getMonth(), today.getFullYear());
    }
});

	// Skip current exercise: stop timer and move to next exercise immediately
	if (skipBtn) skipBtn.addEventListener('click', ()=> {
		// stop any running timer
		stopTimer();
		// advance as if the exercise completed
		nextExercise();
	});
})();

// Update the EXERCISE_IMAGES mapping with correct path
const EXERCISE_IMAGES = {
    // Bench Press, Farmer Carry, Skaters group
    "Bench Press": "Exercises/Bench Press.jpeg",
    "Farmer Carry": "Exercises/Farmer Carry.jpeg",
    "Skaters": "Exercises/Skaters.jpeg",

    // Bent-Over Row, High Knee Skips, Speed Skaters
    "Bent-over Row": "Exercises/Bent-Over Row.jpeg",
    "High Knees": "Exercises/High Knee Skips.jpeg",
    "Speed Skaters": "Exercises/Speed Skaters.gif",

    // Biceps Curl, Hips Thrusts, Sprint
    "Biceps Curls": "Exercises/Biceps Curl.jpeg",
    "Hip Thrusts": "Exercises/Hips Thrusts.jpeg",
    "Sprints": "Exercises/Sprint.gif",

    // Boat Pose, Jump Lunges, Squat
    "Boat Pose": "Exercises/Boat Pose.jpeg",
    "Jump Lunges": "Exercises/Jump Lunges.jpeg",
    "Squats": "Exercises/Squat.gif",

    // Box Jumps, Jump Rope, Stairs runs 
    "Box Jumps": "Exercises/Box Jumps.jpeg",
    "Jump Rope": "Exercises/Jump Rope.jpeg",
    "Stair Runs": "Exercises/Stairs runs.jpeg",

    // Bridge Pose, Jumping jack, Standing Foward Bend
    "Bridge Pose": "Exercises/Bridge Pose.jpeg",
    "Jumping Jacks": "Exercises/Jumping jack.jpg",
    "Standing Forward Bend": "Exercises/Standing Foward Bend.jpeg",

    // Burpees, Lateral Hop, Sun salutation
    "Burpees": "Exercises/Burpees.jpeg",
    "Lateral Hops": "Exercises/Lateral Hop.jpeg", 
    "Sun Salutations": "Exercises/Sun salutation.jpeg",

    // Butt Kickers, Lunges, Tree Yoga
    "Butt Kickers": "Exercises/Butt Kickers.jpeg",
    "Lunges": "Exercises/Lunges.jpeg",
    "Tree Pose": "Exercises/Tree Yoga.jpeg",

    // Calf Raises, Mountain Climbing, Triceps Dips
    "Calf Raises": "Exercises/Calf Raises.jpeg",
    "Mountain Climbers": "Exercises/Mountain Climbing.jpeg",
    "Tricep Dips": "Exercises/Triceps Dips.jpeg",

    // Camel Pose, Overhead Press, Tuck Jump
    "Camel Pose": "Exercises/Camel Pose.jpeg",
    "Overhead Press": "Exercises/Overhead Press.jpeg",
    "Tuck Jumps": "Exercises/Tuck Jump.jpeg",

    // Cat-Cow pose, Pigeon Pose, Warrior 2
    "Cat-Cow": "Exercises/Cat-Cow pose.jpeg",
    "Pigeon Pose": "Exercises/Pigeon Pose.jpeg",
    "Warrior II": "Exercises/Warrior 2.jpeg",

    // Chair Pose, Power Knees
    "Chair Pose": "Exercises/Chair Pose.jpeg",
    "Power Knees": "Exercises/Power Knees.gif",

    // Child Pose, Pull Ups
    "Child's Pose": "Exercises/Child Pose.jpeg",
    "Pull-ups": "Exercises/Pull Ups.jpeg",

    // Chest fly, Push-ups
    "Chest Fly": "Exercises/Chest fly.gif",
    "Push-ups": "Exercises/Push-ups.jpeg",

    // Dead lift, Reclining Bound Angle
    "Deadlifts": "Exercises/Dead lift.jpeg",
    "Reclining Bound Angle": "Exercises/Reclining Bound Angle.jpeg",

    // Downward dog, Romanian Deadlift
    "Downward Dog": "Exercises/Downward dog.jpeg",
    "Romanian Deadlift": "Exercises/Romanian Deadlift.jpeg",

    // Eagle pose, Seated Twist
    "Eagle Pose": "Exercises/Eagle pose.jpeg",
    "Seated Twist": "Exercises/Seated Twist.jpeg"
};
    // Custom Workout Modal Functionality
(function() {
    // Sample exercise data - you can replace this with data from your database
    const exercises = [
         { id: 1, name: "Jumping Jacks", description: "Boosts heart rate, improves coordination, full-body warm-up.", type: "Cardio" },
    { id: 3, name: "High Knees", description: "Strengthens legs, improves speed and cardiovascular endurance.", type: "Cardio" },
    { id: 5, name: "Burpees", description: "Full-body workout, builds strength and cardio fitness.", type: "Cardio" },
    { id: 7, name: "Mountain Climbers", description: "Engages core, improves agility and cardiovascular health.", type: "Cardio" },
    { id: 9, name: "Sprints", description: "Enhances speed, burns fat, builds explosive power.", type: "Cardio" },
    { id: 11, name: "Butt Kickers", description: "Warms up hamstrings, improves running form and speed.", type: "Cardio" },
    { id: 13, name: "Skaters", description: "Builds lateral strength, balance, and coordination.", type: "Cardio" },
    { id: 15, name: "Jump Rope", description: "Improves timing, endurance, and cardiovascular health.", type: "Cardio" },
    { id: 17, name: "Tuck Jumps", description: "Develops explosive power and leg strength.", type: "Cardio" },
    { id: 19, name: "Lateral Hops", description: "Enhances agility, balance, and lower-body strength", type: "Cardio" },
    { id: 21, name: "Jump Lunges", description: "Builds leg strength, balance, and cardiovascular endurance.", type: "Cardio" },
    { id: 23, name: "Speed Skaters", description: "Improves lateral movement, coordination, and cardio.", type: "Cardio" },
    { id: 25, name: "Box Jumps", description: "Increases power, coordination, and lower-body strength.", type: "Cardio" },
    { id: 27, name: "Stair Runs", description: "Builds leg muscles, boosts cardiovascular fitness.", type: "Cardio" },
    { id: 29, name: "Power Knees", description: "Strengthens core and legs, improves coordination and cardio.", type: "Cardio" },
    { id: 31, name: "Squats", description: "Strengthens legs, glutes, and core; improves mobility.", type: "Strength" },
    { id: 33, name: "Push-ups", description: "Builds chest, shoulders, triceps, and core strength.", type: "Strength" },
    { id: 35, name: "Deadlifts", description: "Strengthens back, glutes, hamstrings; improves posture.", type: "Strength" },
    { id: 37, name: "Bench Press", description: "Targets chest, shoulders, and triceps.", type: "Strength" },
    { id: 39, name: "Lunges", description: "Improves balance, leg strength, and flexibility.", type: "Strength" },
    { id: 41, name: "Overhead Press", description: "Builds shoulder and upper back strength.", type: "Strength" },
    { id: 43, name: "Bent-over Row", description: "Strengthens upper back and arms.", type: "Strength" },
    { id: 45, name: "Biceps Curls", description: "Isolates and strengthens biceps.", type: "Strength" },
    { id: 47, name: "Tricep Dips", description: "Targets triceps and shoulders.", type: "Strength" },
    { id: 49, name: "Romanian Deadlift", description: "Focuses on hamstrings and glutes.", type: "Strength" },
    { id: 51, name: "Chest Fly", description: "Opens chest, strengthens pectorals.", type: "Strength" },
    { id: 53, name: "Calf Raises", description: "Builds calf muscles and ankle stability.", type: "Strength" },
    { id: 55, name: "Hip Thrusts", description: "Strengthens glutes and core.", type: "Strength" },
    { id: 57, name: "Farmer Carry", description: "Improves grip, core, and total-body strength.", type: "Strength" },
    { id: 59, name: "Pull-ups", description: "Builds upper-body and core strength.", type: "Strength" },
    { id: 61, name: "Sun Salutations", description: "Warms up the body, improves circulation and flexibility.", type: "Yoga" },
    { id: 63, name: "Warrior II", description: "Builds leg strength, balance, and focus.", type: "Yoga" },
    { id: 65, name: "Tree Pose", description: "Enhances balance and core stability.", type: "Yoga" },
    { id: 67, name: "Downward Dog", description: "Stretches spine and hamstrings, strengthens arms.", type: "Yoga" },
    { id: 69, name: "Child's Pose", description: "Relieves tension, promotes relaxation.", type: "Yoga" },
    { id: 71, name: "Bridge Pose", description: "Strengthens glutes and back, opens chest.", type: "Yoga" },
    { id: 73, name: "Camel Pose", description: "Improves spinal flexibility, opens chest and hips.", type: "Yoga" },
    { id: 75, name: "Seated Twist", description: "Enhances spinal mobility and digestion.", type: "Yoga" },
    { id: 77, name: "Standing Forward Bend", description: "Stretches hamstrings and back.", type: "Yoga" },
    { id: 79, name: "Cat-Cow", description: "Improves spinal flexibility and posture.", type: "Yoga" },
    { id: 81, name: "Pigeon Pose", description: "Opens hips, relieves lower back tension.", type: "Yoga" },
    { id: 83, name: "Boat Pose", description: "Strengthens core and hip flexors.", type: "Yoga" },
    { id: 85, name: "Chair Pose", description: "Builds leg strength and endurance.", type: "Yoga" },
    { id: 87, name: "Eagle Pose", description: "Improves balance, focus, and flexibility.", type: "Yoga" },
    { id: 89, name: "Reclining Bound Angle", description: "Opens hips, promotes relaxation.", type: "Yoga" }
];

    // DOM Elements
    const exerciseModal = document.getElementById('exercise-modal');
    const openExerciseModalBtn = document.getElementById('open-exercise-modal');
    const closeExerciseModalBtn = document.querySelector('.close-modal');
    const cancelSelectionBtn = document.getElementById('cancel-selection');
    const addSelectedExercisesBtn = document.getElementById('add-selected-exercises');
    const exerciseLibrary = document.getElementById('exercise-library');
    const selectedExercisesContainer = document.getElementById('selected-exercises-list');
    const durationOptions = document.querySelectorAll('.duration-option');
    const exerciseSearch = document.getElementById('exercise-search');
    
    // State variables
    let selectedExercises = [];
    let currentDuration = 30;
    let selectedExerciseIds = new Set();
    
    // Initialize the exercise library
    function initializeExerciseLibrary() {
        exerciseLibrary.innerHTML = '';
        
        exercises.forEach(exercise => {
            const exerciseCard = document.createElement('div');
            exerciseCard.className = 'exercise-card';
            exerciseCard.dataset.id = exercise.id;
            exerciseCard.style.cssText = `
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 15px;
                cursor: pointer;
                transition: all 0.3s;
                background: white;
            `;
            
            exerciseCard.innerHTML = `
                <h3 style="font-size: 16px; margin-bottom: 8px; color: #2c3e50;">${exercise.name}</h3>
                <p style="font-size: 14px; color: #7f8c8d; margin: 0;">${exercise.description}</p>
                <div style="font-size: 12px; color: #3498db; margin-top: 8px; text-transform: capitalize;">${exercise.type}</div>
            `;
            
            exerciseCard.addEventListener('click', () => {
                exerciseCard.classList.toggle('selected');
                
                if (exerciseCard.classList.contains('selected')) {
                    exerciseCard.style.borderColor = '#3498db';
                    exerciseCard.style.backgroundColor = '#e1f0fa';
                    selectedExerciseIds.add(exercise.id);
                } else {
                    exerciseCard.style.borderColor = '#e9ecef';
                    exerciseCard.style.backgroundColor = 'white';
                    selectedExerciseIds.delete(exercise.id);
                }
            });
            
            exerciseLibrary.appendChild(exerciseCard);
        });
    }
    
    // Update selected exercises display
    function updateSelectedExercises() {
        if (selectedExercises.length === 0) {
            selectedExercisesContainer.innerHTML = '<div class="empty-state" style="text-align: center; padding: 2rem; color: #666;">No exercises selected yet. Click the button above to add exercises.</div>';
            return;
        }
        
        selectedExercisesContainer.innerHTML = '';
        
        selectedExercises.forEach((exercise, index) => {
            const exerciseItem = document.createElement('div');
            exerciseItem.className = 'exercise-item';
            exerciseItem.style.cssText = `
                background-color: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 6px;
                padding: 12px;
                margin-bottom: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            `;
            
            exerciseItem.innerHTML = `
                <div class="exercise-info" style="display: flex; flex-direction: column;">
                    <div class="exercise-name" style="font-weight: 500;">${exercise.name}</div>
                    <div class="exercise-duration" style="color: #7f8c8d; font-size: 14px;">${exercise.duration} seconds</div>
                </div>
                <div class="remove-exercise" data-index="${index}" style="color: #e74c3c; cursor: pointer; font-size: 18px; padding: 5px;">×</div>
            `;
            
            selectedExercisesContainer.appendChild(exerciseItem);
        });
        
        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-exercise').forEach(button => {
            button.addEventListener('click', (e) => {
                const index = parseInt(e.target.dataset.index);
                selectedExercises.splice(index, 1);
                updateSelectedExercises();
            });
        });
    }
    
    // Event Listeners
    openExerciseModalBtn.addEventListener('click', () => {
        exerciseModal.style.display = 'flex';
        initializeExerciseLibrary();
    });
    
    closeExerciseModalBtn.addEventListener('click', () => {
        exerciseModal.style.display = 'none';
        selectedExerciseIds.clear();
        // Reset selection styles
        document.querySelectorAll('.exercise-card').forEach(card => {
            card.style.borderColor = '#e9ecef';
            card.style.backgroundColor = 'white';
        });
    });
    
    cancelSelectionBtn.addEventListener('click', () => {
        exerciseModal.style.display = 'none';
        selectedExerciseIds.clear();
        // Reset selection styles
        document.querySelectorAll('.exercise-card').forEach(card => {
            card.style.borderColor = '#e9ecef';
            card.style.backgroundColor = 'white';
        });
    });
    
    addSelectedExercisesBtn.addEventListener('click', () => {
        selectedExerciseIds.forEach(id => {
            const exercise = exercises.find(e => e.id === id);
            if (exercise && !selectedExercises.some(e => e.id === id)) {
                selectedExercises.push({
                    ...exercise,
                    duration: currentDuration
                });
            }
        });
        
        updateSelectedExercises();
        exerciseModal.style.display = 'none';
        selectedExerciseIds.clear();
        
        // Reset selection styles
        document.querySelectorAll('.exercise-card').forEach(card => {
            card.style.borderColor = '#e9ecef';
            card.style.backgroundColor = 'white';
        });
    });
    
    // Duration selection
    durationOptions.forEach(option => {
        option.addEventListener('click', () => {
            durationOptions.forEach(opt => {
                opt.style.backgroundColor = '#f8f9fa';
                opt.style.color = '#333';
                opt.style.borderColor = '#ddd';
                opt.classList.remove('selected');
            });
            option.style.backgroundColor = '#3498db';
            option.style.color = 'white';
            option.style.borderColor = '#3498db';
            option.classList.add('selected');
            currentDuration = parseInt(option.dataset.duration);
        });
    });
    
    // Exercise search functionality
    exerciseSearch.addEventListener('input', () => {
        const searchTerm = exerciseSearch.value.toLowerCase();
        const exerciseCards = document.querySelectorAll('.exercise-card');
        
        exerciseCards.forEach(card => {
            const exerciseName = card.querySelector('h3').textContent.toLowerCase();
            const exerciseDesc = card.querySelector('p').textContent.toLowerCase();
            const exerciseType = card.querySelector('div').textContent.toLowerCase();
            
            if (exerciseName.includes(searchTerm) || exerciseDesc.includes(searchTerm) || exerciseType.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Form submission
    document.getElementById('customWorkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const workoutName = document.getElementById('workoutName').value;
        
        if (!workoutName) {
            document.getElementById('responseMessage').innerHTML = '<div style="color: #e53935;">Please enter a workout name</div>';
            return;
        }
        
        if (selectedExercises.length === 0) {
            document.getElementById('responseMessage').innerHTML = '<div style="color: #e53935;">Please add at least one exercise to your workout</div>';
            return;
        }
        
        // In a real application, you would save the workout data to your database here
        document.getElementById('responseMessage').innerHTML = '<div style="color: #2e7d32;">Workout saved successfully!</div>';
        
        // Reset form
        this.reset();
        selectedExercises = [];
        updateSelectedExercises();
    });
    
    // Initialize
    updateSelectedExercises();
})();
    </script>
</body>

</html>
