-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 01:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rwddassignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `AdminID` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `Gender` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`AdminID`, `Email`, `Name`, `password_hash`, `Gender`) VALUES
(2, 'admin1@gmail.com', 'Admin1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `tblcustom_exercises`
--

CREATE TABLE `tblcustom_exercises` (
  `ExerciseID` int(11) NOT NULL,
  `PlanID` int(11) NOT NULL,
  `ExerciseRefID` int(11) NOT NULL,
  `ExerciseName` varchar(100) NOT NULL,
  `DurationSeconds` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblemail`
--

CREATE TABLE `tblemail` (
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblemail`
--

INSERT INTO `tblemail` (`Email`) VALUES
('admin1@gmail.com'),
('tes1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tblexercise`
--

CREATE TABLE `tblexercise` (
  `ExerciseID` int(11) NOT NULL,
  `Exercise Category` varchar(20) NOT NULL,
  `Exercise_Name` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `base_calories_burn_30s` int(15) NOT NULL,
  `base_calories_burn_45s` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblexercise`
--

INSERT INTO `tblexercise` (`ExerciseID`, `Exercise Category`, `Exercise_Name`, `Description`, `base_calories_burn_30s`, `base_calories_burn_45s`) VALUES
(1, 'Cardio', 'Jumping Jacks', 'Boosts heart rate, improves coordination, full-body warm-up.', 10, 19),
(3, 'Cardio', 'High Knees', 'Strengthens legs, improves speed and cardiovascular endurance.', 10, 19),
(5, 'Cardio', 'Burpees', 'Full-body workout, builds strength and cardio fitness.', 10, 19),
(7, 'Cardio', 'Mountain Climbers', 'Engages core, improves agility and cardiovascular health.', 10, 19),
(9, 'Cardio', 'Sprints', 'Enhances speed, burns fat, builds explosive power.', 13, 18),
(11, 'Cardio', 'Butt Kickers', 'Warms up hamstrings, improves running form and speed.', 8, 13),
(13, 'Cardio', 'Skaters', 'Builds lateral strength, balance, and coordination.', 10, 19),
(15, 'Cardio', 'Jump Rope', 'Improves timing, endurance, and cardiovascular health.', 12, 19),
(17, 'Cardio', 'Tuck Jumps', 'Develops explosive power and leg strength.', 10, 19),
(19, 'Cardio', 'Lateral Hops', 'Enhances agility, balance, and lower-body strength', 10, 19),
(21, 'Cardio', 'Jump Lunges', 'Builds leg strength, balance, and cardiovascular endurance.', 10, 19),
(23, 'Cardio', 'Speed Skaters', 'Improves lateral movement, coordination, and cardio.', 10, 19),
(25, 'Cardio', 'Box Jumps', 'Increases power, coordination, and lower-body strength.', 10, 19),
(27, 'Cardio', 'Stair Runs', 'Builds leg muscles, boosts cardiovascular fitness.', 11, 30),
(29, 'Cardio', 'Power Knees', 'Strengthens core and legs, improves coordination and cardio.', 10, 16),
(31, 'Strength', 'Squats', 'Strengthens legs, glutes, and core; improves mobility.', 7, 11),
(33, 'Strength', 'Push-ups', 'Builds chest, shoulders, triceps, and core strength.', 5, 8),
(35, 'Strength', 'Deadlifts', 'Strengthens back, glutes, hamstrings; improves posture.', 7, 11),
(37, 'Strength', 'Bench Press', 'Targets chest, shoulders, and triceps.', 7, 11),
(39, 'Strength', 'Lunges', 'Improves balance, leg strength, and flexibility.', 5, 8),
(41, 'Strength', 'Overhead Press', 'Builds shoulder and upper back strength.', 7, 11),
(43, 'Strength', 'Bent-over Row', 'Strengthens upper back and arms.', 7, 11),
(45, 'Strength', 'Biceps Curls', 'Isolates and strengthens biceps.', 4, 6),
(47, 'Strength', 'Tricep Dips', 'Targets triceps and shoulders.', 4, 6),
(49, 'Strength', 'Romanian Deadlift', 'Focuses on hamstrings and glutes.', 7, 11),
(51, 'Strength', 'Chest Fly', 'Opens chest, strengthens pectorals.', 7, 11),
(53, 'Strength', 'Calf Raises', 'Builds calf muscles and ankle stability.', 4, 6),
(55, 'Strength', 'Hip Thrusts', 'Strengthens glutes and core.', 5, 7),
(57, 'Strength', 'Farmer Carry', 'Improves grip, core, and total-body strength.', 7, 12),
(59, 'Strength', 'Pull-ups', 'Builds upper-body and core strength.', 10, 14),
(61, 'Yoga', 'Sun Salutations', 'Warms up the body, improves circulation and flexibility.', 5, 8),
(63, 'Yoga', 'Warrior II', 'Builds leg strength, balance, and focus.', 3, 5),
(65, 'Yoga', 'Tree Pose', 'Enhances balance and core stability.', 3, 5),
(67, 'Yoga', 'Downward Dog', 'Stretches spine and hamstrings, strengthens arms.', 3, 5),
(69, 'Yoga', 'Child\'s Pose', 'Relieves tension, promotes relaxation.', 2, 5),
(71, 'Yoga', 'Bridge Pose', 'Strengthens glutes and back, opens chest.', 3, 5),
(73, 'Yoga', 'Camel Pose', 'Improves spinal flexibility, opens chest and hips.', 3, 5),
(75, 'Yoga', 'Seated Twist', 'Enhances spinal mobility and digestion.', 3, 5),
(77, 'Yoga', 'Standing Forward Bend', 'Stretches hamstrings and back.', 3, 5),
(79, 'Yoga', 'Cat-Cow', 'Improves spinal flexibility and posture.', 3, 5),
(81, 'Yoga', 'Pigeon Pose', 'Opens hips, relieves lower back tension.', 3, 5),
(83, 'Yoga', 'Boat Pose', 'Strengthens core and hip flexors.', 3, 5),
(85, 'Yoga', 'Chair Pose', 'Builds leg strength and endurance.', 3, 5),
(87, 'Yoga', 'Eagle Pose', 'Improves balance, focus, and flexibility.', 3, 5),
(89, 'Yoga', 'Reclining Bound Angle', 'Opens hips, promotes relaxation.', 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tblfoodplan`
--

CREATE TABLE `tblfoodplan` (
  `MealID` int(11) NOT NULL,
  `Meal_Name` varchar(100) NOT NULL,
  `Meal_Type` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Protein` decimal(5,2) NOT NULL,
  `Carbs` decimal(5,2) NOT NULL,
  `Fats` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfoodplan`
--

INSERT INTO `tblfoodplan` (`MealID`, `Meal_Name`, `Meal_Type`, `Description`, `Protein`, `Carbs`, `Fats`) VALUES
(1, 'Avocado Toast with Poached Egg', 'Breakfast', 'Creamy avocado on toasted sourdough with a runny poached egg and chili flakes.', 16.00, 34.00, 20.00),
(2, 'Banana Oat Pancakes', 'Breakfast', 'Light, fluffy pancakes made with oats and banana — no refined sugar required.', 12.00, 48.00, 10.00),
(3, 'Greek Yogurt Parfait', 'Breakfast', 'Layered Greek yogurt with honey, granola and fresh berries for a quick protein-rich breakfast.', 18.00, 30.00, 6.00),
(4, 'Savory Spinach & Feta Omelette', 'Breakfast', 'A quick omelette packed with spinach, tangy feta and herbs.', 22.00, 4.00, 20.00),
(5, 'Apple Cinnamon Overnight Oats', 'Breakfast', 'Make ahead oats soaked in milk overnight with apple, cinnamon and walnuts.', 8.00, 46.00, 10.00),
(6, 'Mango Coconut Smoothie Bowl', 'Breakfast', 'Thick mango smoothie topped with coconut, granola and chia seeds for texture.', 4.00, 60.00, 8.00),
(7, 'Quinoa & Chickpea Power Bowl', 'Lunch', 'Protein-packed bowl with quinoa, roasted chickpeas, avocado and lemon-tahini dressing.', 16.00, 52.00, 20.00),
(8, 'Chicken Caesar Wrap', 'Lunch', 'Grilled chicken, crisp romaine and a light Caesar-style dressing wrapped in a tortilla.', 34.00, 45.00, 18.00),
(9, 'Soba Noodle Salad with Sesame', 'Lunch', 'Chilled buckwheat noodles with crisp veggies and a sesame-soy dressing.', 12.00, 60.00, 12.00),
(10, 'Mediterranean Tuna Salad', 'Lunch', 'Light salad of canned tuna, olives, cucumber, tomatoes and a lemon-olive oil dressing.', 28.00, 10.00, 20.00),
(11, 'Veggie Burrito Bowl', 'Lunch', 'Black beans, rice, roasted peppers, corn and salsa come together for a satisfying bowl.', 14.00, 70.00, 14.00),
(12, 'Egg Fried Rice', 'Lunch', 'Leftover rice transformed quickly with eggs, peas and soy for a satisfying lunch.', 14.00, 60.00, 12.00),
(13, 'Grilled Salmon & Asparagus', 'Dinner', 'Simple grilled salmon fillet with lemon, garlic and roasted asparagus.', 36.00, 10.00, 28.00),
(14, 'Chicken & Vegetable Stir-Fry', 'Dinner', 'Quick stir-fry with colorful veg, garlic, ginger and a light soy glaze.', 34.00, 28.00, 14.00),
(15, 'Beef Bolognese with Wholewheat Spaghetti', 'Dinner', 'Rich tomato & beef ragù slowly simmered and served over wholewheat pasta.', 36.00, 62.00, 24.00),
(16, 'Creamy Tofu & Vegetable Curry', 'Dinner', 'Coconut-based curry with tofu and mixed vegetables — aromatic and warming.', 22.00, 40.00, 24.00),
(17, 'Prawn & Garlic Linguine', 'Dinner', 'Garlicky prawns tossed with linguine, lemon and parsley for a light but indulgent plate.', 28.00, 70.00, 12.00),
(18, 'Sheet-Pan Lemon Herb Chicken', 'Dinner', 'One-pan roast chicken thighs with potatoes and seasonal vegetables.', 38.00, 40.00, 24.00),
(19, 'Mushroom Risotto (Vegetarian)', 'Dinner', 'Creamy arborio rice cooked slowly with mushrooms and white wine.', 12.00, 72.00, 16.00),
(20, 'Protein Smoothie (Chocolate Banana)', 'Snacks', 'Post-workout chocolate banana smoothie with protein powder and oats.', 28.00, 40.00, 6.00),
(21, 'Peanut Butter Energy Balls', 'Snacks', 'No-bake snack balls made with oats, peanut butter and honey — perfect for on-the-go.', 8.00, 20.00, 12.00),
(22, 'Greek Yogurt & Berry Bowl', 'Snacks', 'Simple, refreshing snack of yogurt, honey and mixed berries.', 11.00, 22.00, 3.00),
(23, 'Crispy Baked Chickpeas', 'Snacks', 'Savory crunchy baked chickpeas seasoned with paprika and garlic powder.', 7.00, 22.00, 5.00),
(24, 'Apple Slices with Almond Butter', 'Snacks', 'Simple, balanced snack: crisp apple slices topped with almond butter and a sprinkle of cinnamon.', 4.00, 22.00, 7.00),
(25, 'Mini Caprese Skewers', 'Snacks', 'Light and fresh cherry tomato, mozzarella and basil skewers drizzled with balsamic.', 6.00, 4.00, 8.00);

-- --------------------------------------------------------

--
-- Table structure for table `tblgoal`
--

CREATE TABLE `tblgoal` (
  `Goal_Name` varchar(50) NOT NULL,
  `GoalWorkoutID` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblgoal`
--

INSERT INTO `tblgoal` (`Goal_Name`, `GoalWorkoutID`) VALUES
('Build muscle', '2'),
('Improve endurance', '4'),
('Lose weight', '1'),
('Maintain fitness', '3');

-- --------------------------------------------------------

--
-- Table structure for table `tblprogress`
--

CREATE TABLE `tblprogress` (
  `ProgressID` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Goal_Name` varchar(50) NOT NULL,
  `CaloriesBurned` int(15) NOT NULL,
  `WorkoutCompleted` int(50) NOT NULL,
  `Completion_percent` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `UserID` int(111) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `Goal_Name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`UserID`, `Email`, `password_hash`, `Name`, `Gender`, `Goal_Name`) VALUES
(11, 'tes1@gmail.com', '$2y$10$jX7kuXgiHBTc2NVVZ7Zge.nP/mgLha8L7MllUVi5Wz8/MHXIBZa3.', 'test1', 'Male', 'Lose weight');

-- --------------------------------------------------------

--
-- Table structure for table `tblworkoutplan`
--

CREATE TABLE `tblworkoutplan` (
  `PlanID` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `workout_name` varchar(100) NOT NULL DEFAULT 'Custom Workout',
  `description` text DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `difficulty_level` varchar(20) NOT NULL,
  `estimated_duration` smallint(5) UNSIGNED NOT NULL,
  `estimated_calories_burn` smallint(5) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`AdminID`),
  ADD KEY `FK` (`Email`);

--
-- Indexes for table `tblcustom_exercises`
--
ALTER TABLE `tblcustom_exercises`
  ADD KEY `fk_custom_exercise_ref` (`ExerciseRefID`);

--
-- Indexes for table `tblemail`
--
ALTER TABLE `tblemail`
  ADD PRIMARY KEY (`Email`);

--
-- Indexes for table `tblexercise`
--
ALTER TABLE `tblexercise`
  ADD PRIMARY KEY (`ExerciseID`);

--
-- Indexes for table `tblfoodplan`
--
ALTER TABLE `tblfoodplan`
  ADD PRIMARY KEY (`MealID`);

--
-- Indexes for table `tblgoal`
--
ALTER TABLE `tblgoal`
  ADD PRIMARY KEY (`Goal_Name`);

--
-- Indexes for table `tblprogress`
--
ALTER TABLE `tblprogress`
  ADD PRIMARY KEY (`ProgressID`),
  ADD KEY `Email ForeignKeyy` (`Email`),
  ADD KEY `GOALL` (`Goal_Name`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `GOALLLL` (`Goal_Name`);

--
-- Indexes for table `tblworkoutplan`
--
ALTER TABLE `tblworkoutplan`
  ADD PRIMARY KEY (`PlanID`),
  ADD UNIQUE KEY `uniq_user_planname` (`Email`,`workout_name`),
  ADD KEY `Foreign Key` (`Email`),
  ADD KEY `idx_public_created` (`is_public`,`created_at`),
  ADD KEY `idx_user_created` (`Email`,`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblexercise`
--
ALTER TABLE `tblexercise`
  MODIFY `ExerciseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tblfoodplan`
--
ALTER TABLE `tblfoodplan`
  MODIFY `MealID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblprogress`
--
ALTER TABLE `tblprogress`
  MODIFY `ProgressID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `UserID` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblworkoutplan`
--
ALTER TABLE `tblworkoutplan`
  MODIFY `PlanID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD CONSTRAINT `FK` FOREIGN KEY (`Email`) REFERENCES `tblemail` (`Email`);

--
-- Constraints for table `tblcustom_exercises`
--
ALTER TABLE `tblcustom_exercises`
  ADD CONSTRAINT `fk_custom_exercise_ref` FOREIGN KEY (`ExerciseRefID`) REFERENCES `tblexercise` (`ExerciseID`) ON UPDATE CASCADE;

--
-- Constraints for table `tblprogress`
--
ALTER TABLE `tblprogress`
  ADD CONSTRAINT `Email ForeignKeyy` FOREIGN KEY (`Email`) REFERENCES `tblemail` (`Email`),
  ADD CONSTRAINT `GOALL` FOREIGN KEY (`Goal_Name`) REFERENCES `tblgoal` (`Goal_Name`);

--
-- Constraints for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD CONSTRAINT `Email` FOREIGN KEY (`Email`) REFERENCES `tblemail` (`Email`),
  ADD CONSTRAINT `GOALLLL` FOREIGN KEY (`Goal_Name`) REFERENCES `tblgoal` (`Goal_Name`);

--
-- Constraints for table `tblworkoutplan`
--
ALTER TABLE `tblworkoutplan`
  ADD CONSTRAINT `Foreign Key` FOREIGN KEY (`Email`) REFERENCES `tblemail` (`Email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
