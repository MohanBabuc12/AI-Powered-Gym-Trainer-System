-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2025 at 04:06 PM
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
-- Database: `fitnessgym`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercises`
--

INSERT INTO `exercises` (`id`, `name`) VALUES
(1, 'Lateral Rise'),
(2, 'Alternative Dumbbell Curls'),
(3, 'Barbell Row'),
(4, 'Push Up'),
(5, 'Squats'),
(6, 'Shoulder Press'),
(7, 'Tricep Dips');

-- --------------------------------------------------------

--
-- Table structure for table `fitnessplans`
--

CREATE TABLE `fitnessplans` (
  `plan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `plan_details` varchar(255) NOT NULL,
  `plan_duration` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fitnessplans`
--

INSERT INTO `fitnessplans` (`plan_id`, `user_id`, `plan_name`, `plan_details`, `plan_duration`, `start_date`, `end_date`, `created_at`) VALUES
(1, 2, 'Weight Loss', 'Muscle Building', '', '2025-08-17', '2025-08-24', '2025-08-16 19:49:10'),
(2, 20, 'Weight Gain', 'Muscle Building', '', '2025-09-26', '2025-10-26', '2025-09-25 15:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `foodcomposition`
--

CREATE TABLE `foodcomposition` (
  `food_id` int(11) NOT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `calories` int(11) DEFAULT NULL,
  `proteins` float DEFAULT NULL,
  `carbs` float DEFAULT NULL,
  `fats` float DEFAULT NULL,
  `serving_size` varchar(255) DEFAULT NULL,
  `date_logged` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foodcomposition`
--

INSERT INTO `foodcomposition` (`food_id`, `food_name`, `calories`, `proteins`, `carbs`, `fats`, `serving_size`, `date_logged`, `user_id`) VALUES
(1, 'Idli', 58, 1.5, 12, 0.4, '1 piece (39g)', '2025-02-04', 1),
(2, 'Vada', 73, 2.1, 8, 3.9, '1 piece (35g)', '2025-02-04', 1),
(3, 'Soda', 150, 0, 39, 0, '1 can (355ml)', '2025-02-04', 2),
(4, 'Fries', 312, 3.4, 41, 15, '100g', '2025-02-04', 2),
(5, 'Vada', 168, 3.9, 30, 3.7, '1 dosa (86g)', '2025-02-04', 3),
(6, 'Idli', 132, 3, 18, 5.8, '1 piece (60g)', '2025-02-04', 3),
(7, 'Fries', 170, 4.2, 20, 8, '100g', '2025-02-04', 4),
(8, 'Vada', 295, 17, 33, 14, '1 burger (120g)', '2025-02-04', 4),
(9, 'Fries', 180, 4.5, 25, 7, '6 pieces', '2025-02-04', 5),
(10, 'Soda', 138, 4.5, 27, 2, '1 cup (140g)', '2025-02-04', 5);

-- --------------------------------------------------------

--
-- Table structure for table `progresstracking`
--

CREATE TABLE `progresstracking` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `body_weight` float DEFAULT NULL,
  `lifted_weights` float DEFAULT NULL,
  `bmi` float DEFAULT NULL,
  `body_fat_percentage` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progresstracking`
--

INSERT INTO `progresstracking` (`progress_id`, `user_id`, `body_weight`, `lifted_weights`, `bmi`, `body_fat_percentage`, `created_at`) VALUES
(1, 4, 72, NULL, 22.22, 132.6, '2025-01-23 07:42:40'),
(2, 4, 60, NULL, 17.92, 168.87, '2025-01-23 07:59:58'),
(3, 8, 55, NULL, 21.48, 136.19, '2025-01-24 06:29:16'),
(4, 8, 60, NULL, 23.44, 132.45, '2025-01-24 06:29:57'),
(5, 5, 70, NULL, 21.13, 135.67, '2025-01-24 10:04:51'),
(6, 5, 65, NULL, 20.06, 136, '2025-01-24 10:05:53'),
(7, 9, 80, NULL, 27.68, 134.34, '2025-01-24 10:54:44'),
(8, 9, 85, NULL, 29.41, 134.34, '2025-01-24 10:55:55'),
(9, 2, 70, NULL, 20.45, 135.17, '2025-01-30 12:38:20'),
(10, 2, 72, NULL, 21.04, 135.17, '2025-01-30 13:04:53'),
(11, 1, 70, NULL, 20.45, 113.86, '2025-02-02 11:46:20'),
(12, 1, 73, NULL, 21.8, 121.94, '2025-02-02 11:49:13'),
(13, 1, 80, NULL, 20.82, 117.45, '2025-02-02 11:54:36'),
(14, 1, 80, NULL, 43.9, 68.67, '2025-02-02 11:57:11'),
(15, 1, 33, NULL, 22.92, 124.03, '2025-02-02 11:57:48'),
(16, 1, 55, NULL, 18.81, 0, '2025-02-02 12:03:14'),
(17, 1, 55, NULL, 126.26, 0, '2025-02-02 12:04:17'),
(18, 1, 66, NULL, 151.52, 0, '2025-02-02 12:04:53'),
(19, 1, 66, NULL, 151.52, 0, '2025-02-02 12:04:54'),
(20, 1, 75, NULL, 21.68, 116.46, '2025-02-02 12:18:33'),
(21, 3, 55, NULL, 16.98, 108.45, '2025-02-02 12:21:01'),
(22, 8, 55, NULL, 19.03, 116.43, '2025-02-02 12:21:58'),
(23, 8, 80, NULL, 23.12, 113.69, '2025-02-02 18:25:11'),
(24, 1, 75, NULL, 36.68, 0, '2025-02-03 13:19:27'),
(25, 2, 50, NULL, 14.45, 113.69, '2025-02-04 03:23:24'),
(26, 1, 80, NULL, 35.56, 125.58, '2025-02-04 06:36:00'),
(27, 1, 72, NULL, 21.74, 122.11, '2025-02-28 09:31:13'),
(28, 2, 80, NULL, 24.69, 120.04, '2025-06-07 12:02:20'),
(29, 20, 53, NULL, 20.7, 178.95, '2025-09-25 15:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `streaks`
--

CREATE TABLE `streaks` (
  `streak_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_streak` int(11) DEFAULT 0,
  `last_logged` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `streaks`
--

INSERT INTO `streaks` (`streak_id`, `user_id`, `current_streak`, `last_logged`) VALUES
(1, 2, 1, '0000-00-00'),
(14, 20, 1, '2025-09-25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `plan_id` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `weight`, `height`, `created_at`, `plan_id`, `password`, `role`) VALUES
(1, 'User', 73, 188, '2025-01-20 04:06:09', NULL, 'User', 'user'),
(2, 'Jack', 81, 186, '2025-01-20 04:18:57', NULL, 'Jack', 'user'),
(3, 'testuser', 50, 15, '2025-01-20 04:57:45', NULL, 'testuser', 'user'),
(4, 'Preethi', 55, 150, '2025-01-21 07:03:53', NULL, 'Preethi', 'user'),
(5, 'Nandeesh', 75, 170, '2025-01-21 13:53:17', NULL, 'Nandeesh', 'user'),
(8, 'Gagan', 50, 170, '2025-01-23 07:57:45', NULL, 'Gagan', 'user'),
(9, 'Darshan', 85, 183, '2025-01-24 10:45:24', NULL, 'Darshan', 'user'),
(14, 'admin', NULL, NULL, '2025-01-31 03:05:04', NULL, 'admin123', 'admin'),
(16, 'Gaganvs', 55, 170, '2025-02-02 10:27:41', NULL, 'Gaganvs', 'user'),
(17, 'Rock', 55, 150, '2025-02-04 06:26:50', NULL, 'Rock', 'user'),
(18, 'Justin', 67, 185, '2025-06-07 12:12:27', NULL, 'Justin@123', 'user'),
(19, 'Appy', 75, 174, '2025-06-08 03:12:04', NULL, 'Nandeesh@2004', 'user'),
(20, 'Shreya', 53, 160, '2025-09-25 15:42:48', NULL, 'Shreya@12345', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `workoutlogs`
--

CREATE TABLE `workoutlogs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `exercise_name` varchar(255) DEFAULT NULL,
  `weights_lifted` float DEFAULT NULL,
  `repetitions` int(11) DEFAULT NULL,
  `log_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workoutlogs`
--

INSERT INTO `workoutlogs` (`log_id`, `user_id`, `exercise_name`, `weights_lifted`, `repetitions`, `log_date`) VALUES
(1, 1, 'Squat', 100, 10, '2025-01-20'),
(2, 2, 'pushup', 10, 15, '2025-01-12'),
(3, 2, 'Squats', 50, 15, '2025-01-21'),
(4, 2, 'Squats', 50, 12, '2025-01-12'),
(5, 2, 'Squats', 50, 11, '2025-01-01'),
(6, 5, 'Squats', 30, 10, '2025-01-01'),
(7, 2, 'Biceps', 30, 10, '2025-01-01'),
(8, 2, 'Biceps', 30, 10, '2025-01-01'),
(9, 1, 'Biceps', 30, 10, '2025-01-01'),
(10, 2, 'pushup', 20, 20, '2025-01-01'),
(11, 4, 'dumbel', 20, 12, '2025-01-01'),
(12, 9, 'Alternate dumbell', 10, 4, '2025-01-01'),
(13, 2, 'pushup', 20, 20, '2025-01-30'),
(14, 2, 'pushup', 20, 20, '2025-01-30'),
(15, 2, 'pushup', 20, 20, '2025-01-30'),
(16, 2, 'pushup', 20, 20, '2025-01-30'),
(17, 2, 'Push Up', 20, 1, '2025-01-30'),
(18, 2, 'Alternative Dumbbell Curls', 33, 33, '2025-01-30'),
(19, 2, 'Tricep Dips', 50, 50, '2025-01-30'),
(21, 1, 'Lateral Rise', 49, 200, '2025-02-03'),
(22, 20, 'Barbell Row', 20, 60, '2025-09-25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fitnessplans`
--
ALTER TABLE `fitnessplans`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `foodcomposition`
--
ALTER TABLE `foodcomposition`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `progresstracking`
--
ALTER TABLE `progresstracking`
  ADD PRIMARY KEY (`progress_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `streaks`
--
ALTER TABLE `streaks`
  ADD PRIMARY KEY (`streak_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `workoutlogs`
--
ALTER TABLE `workoutlogs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `workoutlogs_ibfk_1` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fitnessplans`
--
ALTER TABLE `fitnessplans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `foodcomposition`
--
ALTER TABLE `foodcomposition`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `progresstracking`
--
ALTER TABLE `progresstracking`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `streaks`
--
ALTER TABLE `streaks`
  MODIFY `streak_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `workoutlogs`
--
ALTER TABLE `workoutlogs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fitnessplans`
--
ALTER TABLE `fitnessplans`
  ADD CONSTRAINT `fitnessplans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `foodcomposition`
--
ALTER TABLE `foodcomposition`
  ADD CONSTRAINT `foodcomposition_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `progresstracking`
--
ALTER TABLE `progresstracking`
  ADD CONSTRAINT `progresstracking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `streaks`
--
ALTER TABLE `streaks`
  ADD CONSTRAINT `streaks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `workoutlogs`
--
ALTER TABLE `workoutlogs`
  ADD CONSTRAINT `workoutlogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
