-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2026 at 10:47 AM
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
-- Database: `healthcare_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `admin_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `role`, `admin_status`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$3aqUZhlKjOE/e41qhhhtO.u4x7eI/DWCXcXlmGJ3oONQWu98agOE.', 'manager', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `appointment_status` varchar(20) DEFAULT NULL,
  `reason_for_visit` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `patient_id`, `doctor_id`, `branch_id`, `slot_id`, `appointment_date`, `booking_time`, `appointment_status`, `reason_for_visit`) VALUES
(31, 21, 48, 4, 5, '2026-04-21', '2026-04-20 08:12:46', 'Completed', 'acne'),
(32, 21, 45, 1, 2, '2026-04-23', '2026-04-20 08:24:17', 'Confirmed', 'pain'),
(33, 22, 36, 7, 2, '2026-04-30', '2026-04-20 08:38:07', 'Cancelled', 'ache'),
(34, 22, 36, 7, 3, '2026-04-28', '2026-04-20 08:38:35', 'Confirmed', 'pain');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `location`, `city`, `district`, `contact_number`) VALUES
(1, 'Uttara', 'Sector 10', 'Dhaka', 'Dhaka', '01736579131'),
(2, 'Banani', 'Road 11', 'Dhaka', 'Dhaka', '01700000002'),
(3, 'Gulshan', 'Gulshan 1', 'Dhaka', 'Dhaka', '01900000003'),
(4, 'Dhanmondi', 'Road 27', 'Dhaka', 'Dhaka', '018432167809'),
(5, 'Bailey Road', 'Central', 'Dhaka', 'Dhaka', '01705870912'),
(6, 'Halishahar', 'Road 10', 'Chittagong', 'Chittagong', '01901870712'),
(7, 'Srimangal', 'Medical road', 'Sylhet', 'Sylhet', '01705870912');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `first_name`, `last_name`, `email`, `password`, `phone`, `specialization`, `qualification`, `experience_years`, `branch_id`) VALUES
(35, 'Rezaul', 'Karim', 'rezaul@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01711112222', 'Cardiology', 'MBBS, MD (Cardiology)', 8, NULL),
(36, 'Mahmudul', 'Hasan', 'mahmud@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01822223333', 'Cardiology', 'MBBS, FCPS (Cardiology)', 7, NULL),
(37, 'Shafiul', 'Islam', 'shafiul@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01933334444', 'Neurology', 'MBBS, MD (Neurology)', 9, NULL),
(38, 'Imran', 'Hossain', 'imran@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01644445555', 'Neurology', 'MBBS, FCPS (Neurology)', 6, NULL),
(39, 'Rashedul', 'Islam', 'rashed@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01555556666', 'Neurology', 'MBBS, MD (Neurology)', 5, NULL),
(40, 'Tanvir', 'Hasan', 'tanvir@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01766667777', 'Orthopedic', 'MBBS, MS (Orthopedics)', 11, NULL),
(41, 'Saiful', 'Islam', 'saiful@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01877778888', 'Orthopedic', 'MBBS, D-Ortho', 6, NULL),
(42, 'Kamrul', 'Hasan', 'kamrul@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01988889999', 'Orthopedic', 'MBBS, MS (Orthopedics)', 7, NULL),
(43, 'Farhana', 'Rahman', 'farhana@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01699990000', 'Gynecology', 'MBBS, FCPS (Gynecology)', 10, NULL),
(44, 'Nusrat', 'Jahan', 'nusrat@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01712344321', 'Gynecology', 'MBBS, DGO', 5, NULL),
(45, 'Tanjina', 'Akter', 'tanjina@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01823455432', 'Gynecology', 'MBBS, FCPS (Gynecology)', 8, NULL),
(46, 'Ishrat', 'Jahan', 'ishrat@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01934566543', 'Dermatology', 'MBBS, DDV (Dermatology)', 6, NULL),
(47, 'Sharmin', 'Sultana', 'sharmin@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01645677654', 'Dermatology', 'MBBS, FCPS (Dermatology)', 7, NULL),
(48, 'Afsana', 'Mimi', 'afsana@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01756788765', 'Dermatology', 'MBBS, MD (Dermatology)', 5, NULL),
(50, 'Maliha', 'Rahman', 'maliha@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01712345678', 'Cardiology', 'MBBS, MD (Cardiology)', 10, NULL),
(51, 'Arif', 'Haque', 'arif.haque@gmail.com', '$2y$10$pRhOlALPtYHXbDQWIrSDI.S9wAz8J53re4vbURi.ziEFIoSnlAoQu', '01899887766', 'Medicine', 'MBBS, FCPS (Medicine)', 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedule`
--

CREATE TABLE `doctor_schedule` (
  `schedule_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `day_of_week` varchar(20) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`schedule_id`, `doctor_id`, `branch_id`, `day_of_week`, `start_time`, `end_time`) VALUES
(201, 35, 2, 'Monday', '09:00:00', '12:00:00'),
(202, 36, 7, 'Tuesday', '10:00:00', '13:00:00'),
(203, 36, 7, 'Thursday', '10:00:00', '13:00:00'),
(204, 37, 1, 'Sunday', '10:00:00', '13:00:00'),
(205, 37, 1, 'Tuesday', '10:00:00', '13:00:00'),
(206, 38, 2, 'Monday', '14:00:00', '17:00:00'),
(207, 38, 4, 'Wednesday', '09:00:00', '12:00:00'),
(208, 39, 3, 'Thursday', '14:00:00', '17:00:00'),
(209, 40, 1, 'Sunday', '09:00:00', '12:00:00'),
(210, 41, 2, 'Tuesday', '09:00:00', '12:00:00'),
(211, 41, 6, ' Saturday', '09:00:00', '12:00:00'),
(212, 42, 3, 'Wednesday', '14:00:00', '17:00:00'),
(213, 43, 4, 'Sunday', '14:00:00', '17:00:00'),
(214, 43, 5, 'Tuesday', '10:00:00', '13:00:00'),
(215, 44, 5, 'Wednesday', '09:00:00', '12:00:00'),
(216, 45, 1, 'Thursday', '10:00:00', '13:00:00'),
(217, 46, 6, 'Sunday', '10:00:00', '13:00:00'),
(218, 47, 3, 'Saturday', '10:00:00', '13:00:00'),
(219, 48, 4, 'Tuesday', '14:00:00', '17:00:00'),
(220, 48, 1, 'Thursday', '09:00:00', '12:00:00'),
(221, 50, 1, 'Sunday', '09:00:00', '12:00:00'),
(222, 50, 2, 'Monday', '10:00:00', '13:00:00'),
(223, 50, 3, 'Tuesday', '14:00:00', '17:00:00'),
(224, 51, 2, 'Wednesday', '09:00:00', '12:00:00'),
(225, 51, 4, 'Friday', '10:00:00', '13:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `medical_history`
--

CREATE TABLE `medical_history` (
  `history_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `prescribed_medicine` text DEFAULT NULL,
  `recommended_tests` text DEFAULT NULL,
  `visit_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_history`
--

INSERT INTO `medical_history` (`history_id`, `patient_id`, `doctor_id`, `diagnosis`, `prescribed_medicine`, `recommended_tests`, `visit_date`) VALUES
(9, 21, 48, 'acne', 'acutane', 'blood test', '2026-04-20'),
(10, 21, 48, 'acne', 'acutane', 'blood test', '2026-04-20');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `first_name`, `last_name`, `email`, `password`, `phone`, `gender`, `date_of_birth`, `address`, `registration_date`) VALUES
(1, 'Salman', 'Kabir', 'salmaaaan.kabir@gmail.com', '$2y$10$9sP0UUhP7JfPoDTwyGngLuS1KaSSbWrBzsBRa23RAVaFcF1VjgaPG', '01987396428', 'Male', '2002-09-08', '', '2026-04-07 03:17:48'),
(7, 'Rahman', 'Mirza', 'mirza.rahman@gmail.com', '$2y$10$1dU7NnFO8/9JF/F9CSQEM.XgC1Ppb6L86U5odEkFW0zgrIBoUaBFS', '0198755643', 'Male', '1995-09-05', 'Banani, Dhaka', '2026-04-12 09:27:44'),
(8, 'Safwan', 'Amin', 'safwan.amin@gmail.com', '$2y$10$FsIuNIaWgvjBVuH8WzeODuc0uc0p/unhl3BbCK9UvwrlvYmUjeUOW', '01648176655', 'Male', '0006-04-14', '', '2026-04-13 20:15:19'),
(9, 'Seam', 'Khondker', 'khondker.seam@gmail.com', '$2y$10$rW6St0n4mppcNwXO02g3j.6zPI9xYJyX68RW5utJYqTJC4ffJu/TW', '01648176123', 'Male', '2003-04-19', 'Banani, Dhaka', '2026-04-13 20:17:47'),
(13, 'Karim', 'Benzama', 'banzama.madrid@real.com', '$2y$10$UhZv0sfZzImsxMPySCGIR.ehcz/Th73qGJHqBV7XxZNRv7.dczTuG', '01987654356', 'Male', '1990-08-11', '', '2026-04-18 04:45:00'),
(14, 'Nurul', 'Abedin', 'nurul01@gmail.com', '$2y$10$s0TBMfCRzmjIJr.xrsH8oOdOg4e5yTMrtL.r715Y0by2xZyRUvW..', '01986748889', 'Male', '1998-09-11', '', '2026-04-19 11:26:12'),
(21, 'Aisha', 'Abedin', 'aishaabedin@gmail.com', '$2y$10$lWuNPEIyZ2NEVPPRUTLzuOa1jPCqimAlpi6oxe0O1vt.L3ulo0Fti', '01751648439', 'Female', '2003-09-25', 'Badda', '2026-04-20 06:16:17'),
(22, 'saira', 'islam', 'saira@yahoo.com', '$2y$10$gJGB0YaxzgHz6tFSbK5UeesG.MZdONEHwRVXcoD.paEMgRYj6DOcq', '01714532190', 'Female', '2016-06-07', 'Sylhet', '2026-04-20 08:37:30');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `queue_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `queue_number` int(11) DEFAULT NULL,
  `queue_status` varchar(20) DEFAULT NULL,
  `checkin_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`queue_id`, `appointment_id`, `branch_id`, `queue_number`, `queue_status`, `checkin_time`) VALUES
(30, 31, 4, 1, 'Done', '2026-04-20 08:12:46'),
(31, 32, 1, 1, 'Waiting', '2026-04-20 08:24:17'),
(32, 33, 7, 1, 'Cancelled', '2026-04-20 08:38:07'),
(33, 34, 7, 1, 'Waiting', '2026-04-20 08:38:35');

-- --------------------------------------------------------

--
-- Table structure for table `timeslot`
--

CREATE TABLE `timeslot` (
  `slot_id` int(11) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `max_patients` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timeslot`
--

INSERT INTO `timeslot` (`slot_id`, `start_time`, `end_time`, `max_patients`) VALUES
(1, '09:00:00', '10:00:00', 5),
(2, '10:00:00', '11:00:00', 5),
(3, '11:00:00', '12:00:00', 5),
(4, '14:00:00', '15:00:00', 5),
(5, '15:00:00', '16:00:00', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `slot_id` (`slot_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`queue_id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `timeslot`
--
ALTER TABLE `timeslot`
  ADD PRIMARY KEY (`slot_id`),
  ADD UNIQUE KEY `unique_timeslot` (`start_time`,`end_time`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `medical_history`
--
ALTER TABLE `medical_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `queue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `timeslot`
--
ALTER TABLE `timeslot`
  MODIFY `slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`doctor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_4` FOREIGN KEY (`slot_id`) REFERENCES `timeslot` (`slot_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE SET NULL;

--
-- Constraints for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD CONSTRAINT `doctor_schedule_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`doctor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_schedule_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_history`
--
ALTER TABLE `medical_history`
  ADD CONSTRAINT `medical_history_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_history_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`doctor_id`) ON DELETE CASCADE;

--
-- Constraints for table `queue`
--
ALTER TABLE `queue`
  ADD CONSTRAINT `queue_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`appointment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `queue_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
