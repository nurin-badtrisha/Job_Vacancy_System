-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2026 at 05:55 AM
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
-- Database: `startit`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'StartITadmin', 'SI12345@');

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `applicant_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(15) DEFAULT NULL,
  `education_level` varchar(100) DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `icnumber` varchar(20) NOT NULL,
  `skills` text DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `state` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`applicant_id`, `username`, `password`, `full_name`, `phone_number`, `date_of_birth`, `gender`, `education_level`, `experience_years`, `address`, `icnumber`, `skills`, `email`, `state`, `city`, `postcode`, `profile_picture`) VALUES
(8, 'alia', '12345', 'alia', '0167895600', '2026-06-22', 'Female', 'DIPLOMA', 2, 'tun teja 2', '06071097', 'PHP', 'alia@gmail.com', 'PAHANG', 'Raub', '78000', ''),
(9, 'trisha2006', '1234', 'nurin', '0106638108', '2006-06-10', 'Female', 'MASTER', 2, 'tun teja 2', '060610140428', 'PHP. HTML', 'nbadtrisha@gmail.com', 'PAHANG', 'Raub', '43200', '');

-- --------------------------------------------------------

--
-- Table structure for table `apply_job`
--

CREATE TABLE `apply_job` (
  `applicant_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `applicant_status` varchar(50) DEFAULT 'Pending',
  `applied_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apply_job`
--

INSERT INTO `apply_job` (`applicant_id`, `job_id`, `resume_path`, `applicant_status`, `applied_date`) VALUES
(8, 8, 'resume/6a38914cca8b3_RESUME NURIN BADTRISHA (1).pdf', 'rejected', '2026-06-22'),
(8, 10, 'resume/6a387f9c82b5a_RESUME NURIN BADTRISHA (1).pdf', 'approved', '2026-06-22'),
(9, 8, 'resume/6a38902c93b70_RESUME NURIN BADTRISHA (1).pdf', 'approved', '2026-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `company_address` text DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `company_state` varchar(50) DEFAULT NULL,
  `company_city` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `company_email`, `company_address`, `contact_number`, `company_state`, `company_city`) VALUES
(12, 'Vismart Sdn Bhd', 'cismart@www.vismart.com.my', 'No 11 Lorong 227C Seksyen 51A 46100', '03-7958 6688', 'SELANGOR', 'Petaling Jaya'),
(13, 'Northern Tech Dynamics Sdn Bhd', 'info@northerntech.com.my', 'Unit 5, Gurney Paragon, Persiaran Gurney', '04-2267890', 'PENANG', 'George Town');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone_number`, `message`, `created_at`) VALUES
(1, 'nurin', 'nbadtrisha@gmail.com', '0106638108', 'i have question', '2026-06-21 03:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `job_posting`
--

CREATE TABLE `job_posting` (
  `job_id` int(11) NOT NULL,
  `pic_id` int(11) NOT NULL,
  `job_position` varchar(100) NOT NULL,
  `job_description` text DEFAULT NULL,
  `experience` varchar(100) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `salary_range` varchar(50) DEFAULT NULL,
  `job_location` varchar(100) DEFAULT NULL,
  `language_preference` varchar(200) DEFAULT NULL,
  `working_days` varchar(200) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `posted_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `job_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_posting`
--

INSERT INTO `job_posting` (`job_id`, `pic_id`, `job_position`, `job_description`, `experience`, `education`, `salary_range`, `job_location`, `language_preference`, `working_days`, `company_name`, `posted_date`, `job_image`) VALUES
(8, 8, 'Software Development', 'We are seeking a motivated and detail-oriented Software Developer to join our growing team at Vismart Sdn Bhd. In this role, you will be responsible for designing, developing, and maintaining high-quality software solutions that drive our business forward. You will work closely with cross-functional teams to translate user requirements into functional, scalable, and secure applications.\r\n\r\nKey Responsibilities\r\n\r\nDevelopment: Write clean, maintainable, and efficient code across the full software development lifecycle (SDLC).\r\n\r\nCollaboration: Participate in code reviews, technical discussions, and sprint planning sessions with the development team.\r\n\r\nTroubleshooting: Identify, debug, and resolve technical issues in existing applications to ensure optimal performance.\r\n\r\nIntegration: Collaborate with UI/UX designers to implement intuitive front-end interfaces and with backend engineers to integrate robust APIs and database systems.\r\n\r\nDocumentation: Maintain comprehensive technical documentation for developed features and system architecture.\r\n\r\nRequirements\r\n\r\nEducation: Bachelor’s degree in Computer Science, Software Engineering, or a related field.\r\n\r\nExperience: At least 1 year of hands-on experience in software development.\r\n\r\nTechnical Skills: Proficiency in modern programming languages (e.g., JavaScript/TypeScript, Python, or Java) and familiarity with relevant frameworks (e.g., React, Node.js, or Django).\r\n\r\nCommunication: Excellent command of English and Bahasa Melayu to effectively collaborate within our diverse team.\r\n\r\nMindset: Strong problem-solving abilities, a proactive attitude, and a passion for learning new technologies.', '1 years', 'Degree', 'RM3000 onwards', 'No 11 Lorong 227C Seksyen 51A 46100 Petaling Jaya Selangor', 'English and Bahasa Melayu', '5 days', 'Vismart Sdn Bhd', '2026-06-21 09:25:33', 'jobImages/6a37ae0d16d70_8752041214822728789.jpg'),
(10, 9, 'Cybersecurity Analyst', 'We are looking for a dedicated Cybersecurity Analyst to join our IT department. You will be responsible for monitoring our network for security breaches, investigating incidents, and implementing security measures to protect our data infrastructure. The ideal candidate will have experience with firewalls, intrusion detection systems (IDS), and vulnerability scanning tools. You will play a critical role in maintaining our security posture and ensuring compliance with industry standards.', '2+ years', 'Banchelor\'s Degree in Cybersecurity or IT', '5000 - 8000', 'Unit 5, Gurney Paragon, Persiaran Gurney', 'English and Bahasa Melayu', 'Monday - Friday', 'Northern Tech Dynamic Sdn Bhd', '2026-06-21 09:42:04', 'jobImages/6a37b1ec3d35d_8890759915491060141.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `person_in_charge`
--

CREATE TABLE `person_in_charge` (
  `pic_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person_in_charge`
--

INSERT INTO `person_in_charge` (`pic_id`, `admin_id`, `company_id`, `username`, `password`) VALUES
(8, 1, 12, 'vismartIT', '12345'),
(9, 1, 13, 'northern_pic', 'SecurePass2026!');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`applicant_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `icnumber` (`icnumber`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `apply_job`
--
ALTER TABLE `apply_job`
  ADD PRIMARY KEY (`applicant_id`,`job_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`),
  ADD UNIQUE KEY `company_email` (`company_email`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_posting`
--
ALTER TABLE `job_posting`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `fk_job_posting_pic` (`pic_id`);

--
-- Indexes for table `person_in_charge`
--
ALTER TABLE `person_in_charge`
  ADD PRIMARY KEY (`pic_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `company_id` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicant`
--
ALTER TABLE `applicant`
  MODIFY `applicant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_posting`
--
ALTER TABLE `job_posting`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `person_in_charge`
--
ALTER TABLE `person_in_charge`
  MODIFY `pic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apply_job`
--
ALTER TABLE `apply_job`
  ADD CONSTRAINT `apply_job_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `applicant` (`applicant_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `apply_job_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `job_posting` (`job_id`) ON DELETE CASCADE;

--
-- Constraints for table `job_posting`
--
ALTER TABLE `job_posting`
  ADD CONSTRAINT `fk_job_posting_pic` FOREIGN KEY (`pic_id`) REFERENCES `person_in_charge` (`pic_id`) ON DELETE CASCADE;

--
-- Constraints for table `person_in_charge`
--
ALTER TABLE `person_in_charge`
  ADD CONSTRAINT `person_in_charge_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `person_in_charge_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
