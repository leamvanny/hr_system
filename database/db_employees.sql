-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 10, 2025 at 12:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_employees`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(11) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `emp_name`, `check_in`, `check_out`) VALUES
(1, 'Alex Jame', '2025-07-01 08:00:00', '2025-07-01 17:00:00'),
(2, 'Alex Jame', '2025-07-02 08:00:00', '2025-07-02 17:00:00'),
(4, 'Phoung Bravith', '2025-07-01 08:00:00', '2025-07-01 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `subDepartment_id` varchar(100) NOT NULL,
  `department_code` varchar(100) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `department_color_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `subDepartment_id`, `department_code`, `department_name`, `department_color_code`) VALUES
(1, 'DP1', 'IT', 'Information Technology', '#00d5ff'),
(2, 'DP2', 'HR', 'Human Resources', '#00d5ff'),
(3, 'DP3', 'FN', 'Finance', '#00d5ff'),
(4, 'DP4', 'MK', 'Marketing', '#00d5ff'),
(5, 'DP5', 'CS', 'Customer Support', '#00d5ff'),
(6, 'DP6', 'DP1', 'Engineer', '#00d5ff'),
(7, 'DP7', 'DP01', 'Marketing & Sale', '#4ae8cd');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `hire_date` date NOT NULL,
  `department_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `salary_id` int(11) NOT NULL,
  `attendance_id` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_id`, `full_name`, `dob`, `gender`, `email`, `phone`, `hire_date`, `department_id`, `position_id`, `salary_id`, `attendance_id`, `role_id`) VALUES
(1, 'EMP-001', 'Alex Jame', '2000-01-01', 'Male', 'alex.jame@gmail.com', '098765678', '2023-01-01', 4, 3, 7, NULL, 1),
(2, 'EMP-002', 'Phoung Bravith', '2000-01-01', 'Male', 'phoung.bravith@gmail.com', '09876577', '2023-10-01', 6, 6, 7, NULL, 3),
(3, 'EMP-003', 'Bong Chhaiya', '2002-01-01', 'Female', 'bong.bros@gmail.com', '098765678', '2024-01-01', 6, 1, 5, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `position_id` int(11) NOT NULL,
  `job_position` varchar(100) DEFAULT NULL,
  `job_description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`position_id`, `job_position`, `job_description`) VALUES
(1, 'Software Developer', ''),
(2, 'HR Manager', ''),
(3, 'Financial Analyst', ''),
(4, 'Marketing Specialist', ''),
(5, 'Customer Service Representative', ''),
(6, 'Full Stack Web Development', 'Frond-end and Backend'),
(7, 'Senior QA', 'hhahahaa'),
(8, 'Junior QA', 'Quality Assurance');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(100) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `role_type`) VALUES
(1, 'Admin Office', 'Admin'),
(2, 'Manager', 'Manager'),
(3, 'Default Employee', 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `salary_id` int(11) NOT NULL,
  `base_salary` decimal(10,2) DEFAULT NULL,
  `salary_description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`salary_id`, `base_salary`, `salary_description`) VALUES
(1, 5000.00, ''),
(2, 4500.00, ''),
(3, 6000.00, ''),
(4, 4000.00, ''),
(5, 5500.00, ''),
(6, 500.00, ''),
(7, 800.00, 'Nice Nice');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'alex.john', 'Alex1234!'),
(2, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `attendance_id` (`attendance_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `fk_employee_salary` (`salary_id`),
  ADD KEY `fk_employee_department` (`department_id`),
  ADD KEY `fk_employee_position` (`position_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`position_id`),
  ADD UNIQUE KEY `job_title` (`job_position`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`salary_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `jobs` (`position_id`),
  ADD CONSTRAINT `employees_ibfk_4` FOREIGN KEY (`attendance_id`) REFERENCES `attendances` (`id`),
  ADD CONSTRAINT `employees_ibfk_5` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `employees_ibfk_6` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`),
  ADD CONSTRAINT `employees_ibfk_7` FOREIGN KEY (`salary_id`) REFERENCES `salaries` (`salary_id`),
  ADD CONSTRAINT `fk_employee_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_employee_position` FOREIGN KEY (`position_id`) REFERENCES `jobs` (`position_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_employee_salary` FOREIGN KEY (`salary_id`) REFERENCES `salaries` (`salary_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
