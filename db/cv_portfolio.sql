-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 20, 2025 at 12:43 PM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cv_portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
CREATE TABLE IF NOT EXISTS `certificates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `issuing_organization` varchar(200) NOT NULL,
  `issue_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `credential_id` varchar(100) DEFAULT NULL,
  `credential_url` varchar(500) DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `file_type` enum('image','pdf') NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `title`, `issuing_organization`, `issue_date`, `expiry_date`, `credential_id`, `credential_url`, `file_path`, `file_type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'AWS Certified Solutions Architect', 'Amazon Web Services', '2023-06-15', '2026-06-15', 'AWS-123456789', 'https://aws.amazon.com/verification', 'uploads/certificates/6854da627e8f2_1750391394.pdf', 'pdf', 'Professional level certification for designing distributed systems on AWS', '2025-06-20 03:28:28', '2025-06-20 03:49:54'),
(2, 'Google Cloud Professional Developer', 'Google Cloud', '2023-03-20', '2026-03-20', 'GCP-987654321', 'https://cloud.google.com/certification', NULL, 'pdf', 'Advanced certification for developing applications on Google Cloud Platform', '2025-06-20 03:28:28', '2025-06-20 03:28:28'),
(3, 'Microsoft Certified: Azure Developer Associate', 'Microsoft', '2023-09-10', '2026-09-10', 'MS-AZ-456789', 'https://docs.microsoft.com/certifications', NULL, 'pdf', 'Professional certification for Azure application development', '2025-06-20 03:28:28', '2025-06-20 03:28:28'),
(4, 'Certified Scrum Master (CSM)', 'Scrum Alliance', '2022-11-05', '2024-11-05', 'CSM-789123', 'https://www.scrumalliance.org', NULL, 'pdf', 'Certification for Scrum methodology and agile project management', '2025-06-20 03:28:28', '2025-06-20 03:28:28'),
(5, 'Oracle Certified Professional, Java SE 11 Developer', 'Oracle', '2022-08-12', '2025-08-12', 'OCP-11-456', 'https://education.oracle.com', NULL, 'pdf', 'Professional Java development certification', '2025-06-20 03:28:28', '2025-06-20 03:28:28'),
(6, 'Docker Certified Associate', 'Docker Inc.', '2023-01-25', '2026-01-25', 'DCA-789456', 'https://www.docker.com/certification', NULL, 'pdf', 'Certification for Docker containerization technology', '2025-06-20 03:28:28', '2025-06-20 03:28:28'),
(7, 'Kubernetes Administrator (CKA)', 'Cloud Native Computing Foundation', '2023-04-18', '2026-04-18', 'CKA-123789', 'https://www.cncf.io/certification', NULL, 'pdf', 'Certified Kubernetes Administrator certification', '2025-06-20 03:28:28', '2025-06-20 03:28:28'),
(8, 'Certified Information Systems Security Professional (CISSP)', 'ISC²', '2022-12-03', '2025-12-03', 'CISSP-456123', 'https://www.isc2.org', NULL, 'pdf', 'Advanced security certification for IT professionals', '2025-06-20 03:28:28', '2025-06-20 03:28:28'),
(9, 'Project Management Professional (PMP)', 'Project Management Institute', '2023-07-22', '2026-07-22', 'PMP-789321', 'https://www.pmi.org', NULL, 'pdf', 'Professional project management certification', '2025-06-20 03:28:28', '2025-06-20 03:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

DROP TABLE IF EXISTS `company_info`;
CREATE TABLE IF NOT EXISTS `company_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `hiring_manager` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`id`, `name`, `position`, `hiring_manager`, `street`, `city`, `state`, `zip`, `created_at`) VALUES
(1, 'Tech Solutions Co., Ltd.', 'Senior Software Developer', 'Mr. Somchai Tech', '456 Silom Road', 'Bangkok', 'Bangkok', '10500', '2025-06-17 01:48:24');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL,
  `course_code` varchar(20) DEFAULT NULL,
  `course_name` varchar(200) NOT NULL,
  `course_description` text,
  `credits` int(11) DEFAULT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `academic_year` varchar(20) DEFAULT NULL,
  `instructor` varchar(100) DEFAULT NULL,
  `course_type` enum('Core','Elective','General Education','Thesis','Project','Internship') DEFAULT 'Core',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `education_id` (`education_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `user_id`, `education_id`, `course_code`, `course_name`, `course_description`, `credits`, `grade`, `semester`, `academic_year`, `instructor`, `course_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'CS501', 'Advanced Algorithms and Data Structures', 'Study of complex algorithms, data structures, and their applications in software development', 3, 'A', 'Fall', '2012-2013', 'Dr. Somchai Algorithm', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(2, 1, 1, 'CS502', 'Machine Learning Fundamentals', 'Introduction to machine learning algorithms, statistical learning theory, and practical applications', 3, 'A-', 'Fall', '2012-2013', 'Dr. Nisit ML', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(3, 1, 1, 'CS503', 'Database Systems and Design', 'Advanced database concepts, distributed databases, and data modeling techniques', 3, 'A', 'Spring', '2012-2013', 'Dr. Pichai Database', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(4, 1, 1, 'CS504', 'Software Engineering Principles', 'Software development methodologies, design patterns, and project management', 3, 'A-', 'Spring', '2012-2013', 'Dr. Manee Software', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(5, 1, 1, 'CS505', 'Computer Networks and Security', 'Network protocols, security principles, and cybersecurity fundamentals', 3, 'B+', 'Fall', '2013-2014', 'Dr. Anan Network', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(6, 1, 1, 'CS506', 'Research Methods in Computer Science', 'Research methodology, academic writing, and thesis preparation', 3, 'A', 'Fall', '2013-2014', 'Dr. Wipa Research', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(7, 1, 1, 'CS507', 'Thesis Project', 'Independent research project culminating in a master\'s thesis', 6, 'A', 'Spring', '2013-2014', 'Dr. Thesis Advisor', 'Thesis', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(8, 1, 2, 'CE201', 'Digital Logic Design', 'Fundamentals of digital circuits, Boolean algebra, and logic gates', 3, 'A', 'Fall', '2008-2009', 'Prof. Digital Logic', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(9, 1, 2, 'CE202', 'Computer Architecture', 'CPU design, memory systems, and computer organization', 3, 'A-', 'Spring', '2008-2009', 'Prof. Architecture', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(10, 1, 2, 'CE203', 'Programming Fundamentals', 'Introduction to programming concepts using C and C++', 3, 'A', 'Fall', '2008-2009', 'Prof. Programming', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(11, 1, 2, 'CE204', 'Data Structures and Algorithmss', 'Fundamental data structures and algorithm analysis', 3, 'A', 'Spring', '2008-2009', 'Prof. Data Structures', 'Core', '2025-06-20 03:00:00', '2025-06-20 12:28:36'),
(13, 1, 2, 'CE302', 'Computer Networks', 'Network protocols, TCP/IP, and network programming', 3, 'A', 'Spring', '2009-2010', 'Prof. Networks', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(14, 1, 2, 'CE401', 'Software Engineering', 'Software development lifecycle and project management', 3, 'A', 'Fall', '2010-2011', 'Prof. Software Eng', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(15, 1, 2, 'CE402', 'Database Systems', 'Relational databases, SQL, and database design', 3, 'A', 'Spring', '2010-2011', 'Prof. Database', 'Core', '2025-06-20 03:00:00', '2025-06-20 03:00:00'),
(16, 1, 2, 'CE501', 'Capstone Project', 'Final year project integrating all learned concepts', 6, 'A', 'Fall-Spring', '2011-2012', 'Prof. Capstone', 'Project', '2025-06-20 03:00:00', '2025-06-20 03:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cover_letter`
--

DROP TABLE IF EXISTS `cover_letter`;
CREATE TABLE IF NOT EXISTS `cover_letter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `introduction` text NOT NULL,
  `body` text NOT NULL,
  `closing` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cover_letter`
--

INSERT INTO `cover_letter` (`id`, `introduction`, `body`, `closing`, `created_at`) VALUES
(1, 'I am writing to express my strong interest in the Senior Software Developer position at Tech Solutions Co., Ltd. With over 5 years of experience in software development and a passion for creating efficient, scalable solutions, I believe I would be a valuable addition to your team.', 'Throughout my career, I have developed expertise in full-stack development, with a particular focus on PHP, MySQL, and modern JavaScript frameworks. My experience includes leading development teams, implementing complex features, and optimizing application performance. I have successfully delivered numerous projects that have significantly improved business processes and user experiences.\r\n\r\nAt my current position, I have been responsible for architecting and implementing enterprise-level applications, mentoring junior developers, and collaborating with cross-functional teams to ensure project success. I am particularly proud of my work in developing a real-time data processing system that improved operational efficiency by 40%.', 'Thank you for considering my application. I am excited about the opportunity to contribute to Tech Solutions Co., Ltd. and would welcome the chance to discuss how my skills and experience align with your needs. I am available for an interview at your convenience.', '2025-06-17 01:48:40');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `field_of_study` varchar(100) DEFAULT NULL,
  `school` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT '0',
  `gpa` decimal(3,2) DEFAULT NULL,
  `achievements` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `user_id`, `degree`, `field_of_study`, `school`, `start_date`, `end_date`, `is_current`, `gpa`, `achievements`) VALUES
(1, 1, 'Master of Science', 'Computer Science', 'Chulalongkorn University', '2012-06-01', '2014-05-31', 0, '3.85', 'Published 2 research papers\r\nReceived full scholarship\r\nGraduated with honors'),
(2, 1, 'Bachelor of Science', 'Computer Engineering', 'King Mongkut\'s University of Technology Thonburi', '2008-06-01', '2012-05-31', 0, '3.75', 'Dean\'s List all semesters\r\nLed student programming club\r\nWon 3 programming competitions');

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

DROP TABLE IF EXISTS `experience`;
CREATE TABLE IF NOT EXISTS `experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT '0',
  `description` text,
  `achievements` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `user_id`, `title`, `company`, `start_date`, `end_date`, `is_current`, `description`, `achievements`) VALUES
(1, 1, 'Senior Software Developer', 'Tech Solutions Co., Ltd.', '2020-01-01', NULL, 1, 'Lead developer for enterprise applications, managing a team of 5 developers and implementing complex features.', 'Led development of real-time data processing system that improved efficiency by 40%\r\nImplemented CI/CD pipeline reducing deployment time by 60%\r\nMentored 3 junior developers who were promoted to mid-level positions'),
(2, 1, 'Software Developer', 'Digital Innovations Ltd.', '2017-06-01', '2019-12-31', 0, 'Full-stack developer responsible for developing and maintaining web applications.', 'Developed and maintained 5 major web applications\r\nReduced application load time by 50%\r\nImplemented automated testing reducing bugs by 30%');

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

DROP TABLE IF EXISTS `interests`;
CREATE TABLE IF NOT EXISTS `interests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon_class` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`id`, `name`, `icon_class`, `created_at`) VALUES
(1, 'Travelling', 'fas fa-plane', '2025-06-20 04:27:34'),
(2, 'Books', 'fas fa-book-open', '2025-06-20 04:27:34'),
(3, 'Music', 'fas fa-music', '2025-06-20 08:57:56'),
(4, 'Cooking', 'fas fa-utensils', '2025-06-20 08:58:41');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `proficiency` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `proficiency`, `created_at`) VALUES
(1, 'Khmer', 5, '2025-06-20 04:27:23'),
(2, 'English', 3, '2025-06-20 04:27:23'),
(3, 'Chinese', 1, '2025-06-20 04:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

DROP TABLE IF EXISTS `personal_info`;
CREATE TABLE IF NOT EXISTS `personal_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `height` varchar(20) NOT NULL,
  `weight` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `marital_status` varchar(20) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `country` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`id`, `name`, `title`, `email`, `phone`, `height`, `weight`, `date_of_birth`, `gender`, `nationality`, `marital_status`, `religion`, `address`, `city`, `state`, `zip`, `country`, `location`, `created_at`) VALUES
(1, 'Chamrern S.', 'Senior Software Developer', 'tiengchamrern2@gmail.com', '+855 78783645 / 967797762', '165 cm', '55 kg', '2003-11-10', 'Male', 'Khmer', 'Single', 'Cambodian', 'Sangkat TuekThla, Khan Sensokh,', 'Phnom Penh', 'Phnom Penh', '120802', 'Cambodia', 'Phnom Penh, Cambodia', '2025-06-17 01:47:43'),
(6, 'Chamrern S.', 'Senior Software Developer', 'tiengchamrern2@gmail.com', '+855 78783645 / 967797762', '165 cm', '52 kg', '2003-11-10', 'Male', 'Khmer', 'Single', 'Cambodian', 'Sangkat TuekThla, Khan Sensokh,', 'Phnom Penh', 'Phnom Penh', '120802', 'Cambodia', 'Phnom Penh, Cambodia', '2025-06-20 12:30:51'),
(7, 'Tieng Chamrern', 'Senior Software Developer', 'tiengchamrern2@gmail.com', '+855 78783645 / 967797762', '165 cm', '52 kg', '2003-11-10', 'Male', 'Khmer', 'Single', 'Cambodian', 'Sangkat TuekThla, Khan Sensokh,', 'Phnom Penh', 'Phnom Penh', '120802', 'Cambodia', 'Phnom Penh, Cambodia', '2025-06-20 12:31:12'),
(8, 'Tieng Chamrern', 'Senior Web Developer', 'tiengchamrern2@gmail.com', '+855 78783645 / 967797762', '165 cm', '52 kg', '2003-11-10', 'Male', 'Khmer', 'Single', 'Cambodian', 'Sangkat TuekThla, Khan Sensokh,', 'Phnom Penh', 'Phnom Penh', '120802', 'Cambodia', 'Phnom Penh, Cambodia', '2025-06-20 12:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `proficiency_level` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `user_id`, `skill_name`, `proficiency_level`, `category`) VALUES
(1, 1, 'PHP', 'Expert', 'Programming Languages'),
(2, 1, 'MySQL', 'Expert', 'Databases'),
(3, 1, 'JavaScript', 'Advanced', 'Programming Languages'),
(4, 1, 'Laravel', 'Expert', 'Frameworks'),
(5, 1, 'Vue.js', 'Advanced', 'Frameworks'),
(6, 1, 'Git', 'Expert', 'Tools'),
(7, 1, 'Docker', 'Advanced', 'DevOps'),
(8, 1, 'AWS', 'Intermediate', 'Cloud Services'),
(9, 1, 'RESTful APIs', 'Expert', 'Architecture'),
(10, 1, 'Agile Methodologies', 'Expert', 'Methodologies'),
(11, 1, 'HTML5', 'Expert', 'Web Technologies'),
(12, 1, 'CSS3', 'Expert', 'Web Technologies'),
(13, 2, 'JavaScript', 'Advanced', 'Programming Languages'),
(14, 1, 'React', 'Expert', 'Frameworks'),
(15, 1, 'Node.js', 'Advanced', 'Backend'),
(16, 1, 'MongoDB', 'Intermediate', 'Databases'),
(17, 2, 'Git', 'Advanced', 'Tools'),
(18, 1, 'Responsive Design', 'Expert', 'Web Technologies'),
(19, 1, 'UI/UX Design', 'Advanced', 'Design'),
(20, 1, 'Web Accessibility', 'Intermediate', 'Web Technologies');

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

DROP TABLE IF EXISTS `social_media`;
CREATE TABLE IF NOT EXISTS `social_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `display_order` int(11) DEFAULT '0',
  `icon_class` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `social_media`
--

INSERT INTO `social_media` (`id`, `user_id`, `platform`, `username`, `url`, `is_active`, `display_order`, `icon_class`, `created_at`, `updated_at`) VALUES
(1, 1, 'Email', 'tiengchamrern2@gmail.com', 'mailto:tiengchamrern2@gmail.com', 1, 1, 'fas fa-envelope', '2025-06-20 02:00:00', '2025-06-20 02:00:00'),
(2, 1, 'Telegram', '@chamrern_dev', 'https://t.me/chamrern_dev', 1, 2, 'fab fa-telegram', '2025-06-20 02:00:00', '2025-06-20 02:00:00'),
(3, 1, 'Facebook', 'chamrern.sopheak', 'https://facebook.com/chamrern.sopheak', 1, 3, 'fab fa-facebook', '2025-06-20 02:00:00', '2025-06-20 02:00:00'),
(4, 1, 'LinkedIn', 'chamrern-sopheak', 'https://linkedin.com/in/chamrern-sopheak', 1, 4, 'fab fa-linkedin', '2025-06-20 02:00:00', '2025-06-20 02:00:00'),
(9, 1, 'Twitter', 'twitterchamrern.dev', 'https://twitter.com/chamrern.dev', 1, 5, 'fab fa-twitter', '2025-06-20 12:37:47', '2025-06-20 12:37:47'),
(8, 1, 'Instagram', 'instagram.chamrerns', 'https://instagram.com/chamrerns', 1, 0, 'fab fa-instagram', '2025-06-20 12:09:25', '2025-06-20 12:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'chamrern', '$2y$10$zhhWik5gqWRRsTGp6gQBM.96r3HD2KdCG7HYFhFy4wypg5TzTI.Sy', 'tiengchamrern2@gmail.com', '2025-06-17 01:30:09'),
(2, 'users', '$2y$10$VNwGPnIiL3QeaGwra419vOklc9WqVlce5J7BIbc/IFzOMMfAlCL.u', 'user@gmail.com', '2025-06-17 01:36:43'),
(3, 'users1', '$2y$10$a/jbEKibIruaCqvmRSyko.GzP8cAZyMEcDZ9DfIFutGUsOvN7R1VK', 'user2@gmail.com', '2025-06-20 02:52:17'),
(4, 'users2', '$2y$10$TRNhPrvkVw8M4FS86pt.6Op6BQ75EazKYwLVsz24d29mHJSJLZgD.', 'user4@gmail.com', '2025-06-20 10:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `seo_metadata`
--

DROP TABLE IF EXISTS `seo_metadata`;
CREATE TABLE IF NOT EXISTS `seo_metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_url` varchar(500) NOT NULL,
  `page_title` varchar(200) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text,
  `meta_author` varchar(100) DEFAULT NULL,
  `og_title` varchar(200) DEFAULT NULL,
  `og_description` text,
  `og_image` varchar(500) DEFAULT NULL,
  `og_type` varchar(50) DEFAULT 'website',
  `og_site_name` varchar(100) DEFAULT 'Portfolio System',
  `og_locale` varchar(10) DEFAULT 'en_US',
  `twitter_card` varchar(50) DEFAULT 'summary_large_image',
  `twitter_title` varchar(200) DEFAULT NULL,
  `twitter_description` text,
  `twitter_image` varchar(500) DEFAULT NULL,
  `twitter_site` varchar(100) DEFAULT '@portfoliosystem',
  `canonical_url` varchar(500) DEFAULT NULL,
  `robots` varchar(100) DEFAULT 'index, follow',
  `language` varchar(10) DEFAULT 'en',
  `theme_color` varchar(7) DEFAULT '#007bff',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_url` (`page_url`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `seo_metadata`
--

INSERT INTO `seo_metadata` (`id`, `page_url`, `page_title`, `meta_description`, `meta_keywords`, `meta_author`, `og_title`, `og_description`, `og_image`, `og_type`, `og_site_name`, `og_locale`, `twitter_card`, `twitter_title`, `twitter_description`, `twitter_image`, `twitter_site`, `canonical_url`, `robots`, `language`, `theme_color`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '/', 'Professional CV & Portfolio - Chamrern S.', 'Professional CV and portfolio showcasing software development skills, experience, and achievements. Expert in PHP, MySQL, JavaScript, and modern web technologies.', 'CV, portfolio, resume, software developer, PHP, MySQL, JavaScript, web development, professional', 'Chamrern S.', 'Professional CV & Portfolio - Chamrern S.', 'Professional CV and portfolio showcasing software development skills, experience, and achievements. Expert in PHP, MySQL, JavaScript, and modern web technologies.', '/images/og-home.jpg', 'website', 'Portfolio System', 'en_US', 'summary_large_image', 'Professional CV & Portfolio - Chamrern S.', 'Professional CV and portfolio showcasing software development skills, experience, and achievements.', '/images/twitter-home.jpg', '@portfoliosystem', '/', 'index, follow', 'en', '#007bff', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(2, 'certificates', 'Professional Certifications - Chamrern S.', 'View professional certifications and achievements including AWS, Google Cloud, Microsoft Azure, and other industry-recognized credentials.', 'certifications, AWS, Google Cloud, Microsoft Azure, professional development, skills validation', 'Chamrern S.', 'Professional Certifications - Chamrern S.', 'View professional certifications and achievements including AWS, Google Cloud, Microsoft Azure, and other industry-recognized credentials.', '/images/og-certificates.jpg', 'website', 'Portfolio System', 'en_US', 'summary_large_image', 'Professional Certifications - Chamrern S.', 'View professional certifications and achievements including AWS, Google Cloud, Microsoft Azure, and other industry-recognized credentials.', '/images/twitter-certificates.jpg', '@portfoliosystem', '/certificates.php', 'index, follow', 'en', '#007bff', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(3, 'cover-letter', 'Cover Letter Generator - Professional Templates', 'Generate professional cover letters with customizable templates. Perfect for job applications and career advancement opportunities.', 'cover letter, job application, professional templates, career, employment', 'Chamrern S.', 'Cover Letter Generator - Professional Templates', 'Generate professional cover letters with customizable templates. Perfect for job applications and career advancement opportunities.', '/images/og-cover-letter.jpg', 'website', 'Portfolio System', 'en_US', 'summary_large_image', 'Cover Letter Generator - Professional Templates', 'Generate professional cover letters with customizable templates.', '/images/twitter-cover-letter.jpg', '@portfoliosystem', '/cover-letter.php', 'index, follow', 'en', '#007bff', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(4, 'user_dashboard', 'User Dashboard - Portfolio Management', 'Access your personal portfolio dashboard to manage CV information, certificates, skills, and professional details.', 'dashboard, portfolio management, CV management, user profile, professional details', 'Chamrern S.', 'User Dashboard - Portfolio Management', 'Access your personal portfolio dashboard to manage CV information, certificates, skills, and professional details.', '/images/og-dashboard.jpg', 'website', 'Portfolio System', 'en_US', 'summary_large_image', 'User Dashboard - Portfolio Management', 'Access your personal portfolio dashboard to manage CV information.', '/images/twitter-dashboard.jpg', '@portfoliosystem', '/user_dashboard.php', 'index, follow', 'en', '#007bff', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(5, 'admin', 'Admin Panel - Portfolio System Management', 'Administrative panel for managing portfolio system, users, content, and system settings.', 'admin, management, portfolio system, user management, content management', 'Chamrern S.', 'Admin Panel - Portfolio System Management', 'Administrative panel for managing portfolio system, users, content, and system settings.', '/images/og-admin.jpg', 'website', 'Portfolio System', 'en_US', 'summary_large_image', 'Admin Panel - Portfolio System Management', 'Administrative panel for managing portfolio system.', '/images/twitter-admin.jpg', '@portfoliosystem', '/admin.php', 'noindex, nofollow', 'en', '#007bff', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(6, 'login', 'Login - Portfolio System', 'Secure login page for accessing your personal portfolio dashboard. Manage your CV, certificates, and professional information.', 'login, sign in, portfolio system, user authentication, secure access, dashboard login', 'Chamrern S.', 'Login - Portfolio System', 'Secure login page for accessing your personal portfolio dashboard. Manage your CV, certificates, and professional information.', '/images/og-login.jpg', 'website', 'Portfolio System', 'en_US', 'summary_large_image', 'Login - Portfolio System', 'Secure login page for accessing your personal portfolio dashboard.', '/images/twitter-login.jpg', '@portfoliosystem', '/login.php', 'noindex, nofollow', 'en', '#007bff', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(7, 'register', 'Register - Create Portfolio Account', 'Create a new account to build and manage your professional portfolio. Start showcasing your skills, experience, and achievements.', 'register, sign up, create account, portfolio system, new user, professional portfolio', 'Chamrern S.', 'Register - Create Portfolio Account', 'Create a new account to build and manage your professional portfolio. Start showcasing your skills, experience, and achievements.', '/images/og-register.jpg', 'website', 'Portfolio System', 'en_US', 'summary_large_image', 'Register - Create Portfolio Account', 'Create a new account to build and manage your professional portfolio.', '/images/twitter-register.jpg', '@portfoliosystem', '/register.php', 'noindex, nofollow', 'en', '#007bff', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `seo_analytics`
--

DROP TABLE IF EXISTS `seo_analytics`;
CREATE TABLE IF NOT EXISTS `seo_analytics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_url` varchar(500) NOT NULL,
  `page_views` int(11) DEFAULT '0',
  `unique_visitors` int(11) DEFAULT '0',
  `bounce_rate` decimal(5,2) DEFAULT '0.00',
  `avg_time_on_page` int(11) DEFAULT '0',
  `search_keywords` text,
  `referring_domains` text,
  `social_shares` int(11) DEFAULT '0',
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `page_url` (`page_url`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `seo_settings`
--

DROP TABLE IF EXISTS `seo_settings`;
CREATE TABLE IF NOT EXISTS `seo_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL,
  `setting_description` text,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seo_settings`
--

INSERT INTO `seo_settings` (`id`, `setting_key`, `setting_value`, `setting_description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Portfolio System', 'Website name for SEO and social media', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(2, 'site_description', 'Professional CV and Portfolio Management System', 'Default site description for SEO', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(3, 'site_keywords', 'CV, portfolio, resume, professional, career, skills, experience', 'Default site keywords for SEO', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(4, 'google_analytics_id', '', 'Google Analytics tracking ID', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(5, 'google_search_console', '', 'Google Search Console verification code', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(6, 'bing_webmaster_tools', '', 'Bing Webmaster Tools verification code', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00'),
(7, 'default_og_image', '/images/default-og.jpg', 'Default Open Graph image for social sharing', 1, '2025-06-20 13:00:00', '2025-06-20 13:00:00');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



