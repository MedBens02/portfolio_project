-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 11, 2024 at 11:05 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plateforme_scolaire`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `prenom`, `login`, `mot_de_passe`) VALUES
(1, 'Med', 'med', 'admin', '$2y$10$Sk3GQt3C2o6KIXeJBl6.CuYF0XJb9BZc/I9r1kXTAL.49O3kjRNCW');

-- --------------------------------------------------------

--
-- Table structure for table `chat_logs`
--

DROP TABLE IF EXISTS `chat_logs`;
CREATE TABLE IF NOT EXISTS `chat_logs` (
  `sender_id` int NOT NULL,
  `recipient_id` int NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chat_logs`
--

INSERT INTO `chat_logs` (`sender_id`, `recipient_id`, `time_stamp`, `msg`) VALUES
(2020, 1037, '2024-05-11 22:21:09', 'ANNONCE JS TEST'),
(2020, 1038, '2024-05-11 22:21:09', 'ANNONCE JS TEST'),
(2020, 1040, '2024-05-11 22:21:09', 'ANNONCE JS TEST'),
(2020, 1041, '2024-05-11 22:21:09', 'ANNONCE JS TEST'),
(2020, 1043, '2024-05-11 22:21:09', 'ANNONCE JS TEST'),
(2020, 1044, '2024-05-11 22:21:09', 'ANNONCE JS TEST'),
(2020, 1037, '2024-05-11 22:21:57', 'BONJOUR'),
(2020, 1037, '2024-05-11 22:22:01', 'test'),
(1037, 2020, '2024-05-11 22:22:06', 'ETST'),
(2020, 1037, '2024-05-11 22:22:17', 'test contadfdaf '),
(1037, 2020, '2024-05-11 22:43:03', 'fadjkcbkjn adk;cklasm'),
(2020, 1037, '2024-05-11 22:43:14', 'ad lj anmaf m.f d.'),
(2020, 1041, '2024-05-11 22:43:34', 'TEST ANNONCE'),
(2020, 1039, '2024-05-11 22:43:34', 'TEST ANNONCE'),
(2020, 1047, '2024-05-11 22:43:34', 'TEST ANNONCE'),
(2020, 1037, '2024-05-11 22:43:34', 'TEST ANNONCE');

-- --------------------------------------------------------

--
-- Table structure for table `enrollement`
--

DROP TABLE IF EXISTS `enrollement`;
CREATE TABLE IF NOT EXISTS `enrollement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cours` int NOT NULL,
  `id_etd` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_etd` (`id_etd`),
  KEY `id_cours` (`id_cours`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enrollement`
--

INSERT INTO `enrollement` (`id`, `id_cours`, `id_etd`) VALUES
(7, 9, 1037),
(12, 16, 1037),
(17, 7, 1037),
(24, 9, 1041),
(32, 7, 1039),
(35, 3, 1039),
(36, 3, 1040),
(54, 1, 1041),
(59, 1, 1039),
(61, 1, 1047),
(64, 1, 1037);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_requests`
--

DROP TABLE IF EXISTS `enrollment_requests`;
CREATE TABLE IF NOT EXISTS `enrollment_requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `cours_id` int NOT NULL,
  `prof_id` int NOT NULL,
  PRIMARY KEY (`request_id`),
  KEY `student` (`student_id`),
  KEY `cours` (`cours_id`),
  KEY `prof_request` (`prof_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `request` tinyint(1) NOT NULL DEFAULT '0',
  `path_profile` varchar(150) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'uploads/pfp.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1062 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `etudiant`
--

INSERT INTO `etudiant` (`id`, `nom`, `prenom`, `adresse`, `email`, `mot_de_passe`, `request`, `path_profile`) VALUES
(1037, 'med', 'med', 'ff', 'test@gmail.com', '$2y$10$vRmMJM55bS9w4tOJ33xMS.ybdPaHbIRPTi.5nFQhBa6S.ZgKqw/Uq', 0, 'uploads/pfp.png'),
(1039, 'Espinoza', 'Leslie', '207 Erin Well, West Andreamouth, TN 60441', 'leslie.espinoza@example.com', 'MlH%^U)yH3O', 0, 'uploads/pfp.png'),
(1040, 'Wood', 'Julie', '601 Sandra Knolls, Freemanfort, HI 57222', 'julie.wood@example.com', '@k0ytSS$mMSpo', 0, 'uploads/pfp.png'),
(1041, 'Cole', 'James', '718 Pope Plaza, Hillmouth, MS 84362', 'james.cole@example.com', 'kVt8nxnzrc', 0, 'uploads/pfp.png'),
(1043, 'Drake', 'Joseph', '24244 Nicole Rapids Suite 892, Jessicaville, AK 03618', 'joseph.drake@example.com', 'LgUpXuPsY9Dim2o', 0, 'uploads/pfp.png'),
(1044, 'Summers', 'Ann', '696 Townsend Brook Suite 548, Lake Nicoleshire, CO 35311', 'ann.summers@example.com', 'c%)mgZ0o(ZtreJ', 0, 'uploads/pfp.png'),
(1046, 'Brown', 'Keith', '319 Natalie Creek, Shahmouth, NH 90479', 'keith.brown@example.com', 'bniQ1zLZll', 0, 'uploads/pfp.png'),
(1047, 'English', 'Trevor', '858 Sullivan Lakes Apt. 060, Nealberg, NJ 45590', 'trevor.english@example.com', 'jYIyUvzDiZS', 0, 'uploads/pfp.png'),
(1048, 'Ellison', 'Teresa', '5522 Angela Ports Suite 989, West Natalie, NM 09164', 'teresa.ellison@example.com', 'STq3YM6NC*', 0, 'uploads/pfp.png'),
(1051, 'Porter', 'Angela', '37790 Raymond Forest Apt. 064, Janiceborough, IL 97440', 'angela.porter@example.com', 'ldmruy', 0, 'uploads/pfp.png'),
(1052, 'Montes', 'Samantha', '346 Natalie Lock, South Tannerbury, WY 10297', 'samantha.montes@example.com', 'ylrbqw', 0, 'uploads/pfp.png'),
(1054, 'Moore', 'William', 'USNS Haynes, FPO AE 37471', 'william.moore@example.com', 'unddde', 0, 'uploads/pfp.png'),
(1055, 'gg', 'gg', 'gg', 'testAdmin@gg.gg', 'gg', 0, 'uploads/pfp.png'),
(1056, 'gg', 'gg', 'gg', 'testAdmin2@gg.gg', 'gg', 0, 'uploads/pfp.png'),
(1057, 'gg', 'gg', 'gg', 'testAdmin3@gg.gg', 'gg', 0, 'uploads/pfp.png'),
(1058, 'gg', 'gg', 'gg', 'testAdmin4@gg.gg', 'gg', 0, 'uploads/pfp.png'),
(1060, 'test', 'test', 'test', 'testhash@gmail.com', '$2y$10$vRmMJM55bS9w4tOJ33xMS.ybdPaHbIRPTi.5nFQhBa6S.ZgKqw/Uq', 0, 'uploads/pfp.png'),
(1061, 'test', 'test', 'test', 'test10@gmail.com', '$2y$10$3ZKp95DF9h2TQQ8VkcyFVOSF7Act5LAbNj6mcBmx5pXnZMdsGRcbe', 0, 'uploads/pfp.png');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `prof_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prof` (`prof_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `nom`, `description`, `prof_id`) VALUES
(1, 'JavaScript', 'Cours de JavaScript', 2020),
(3, 'ENGLISH', 'Cours de ENGLISH', 2020),
(7, 'PYTHON', 'Cours de PYTHON', 2020),
(8, 'c#', 'Cours de c#', 2021),
(9, 'Français', 'Cours de français', 2020),
(13, 'controle de gestion', 'Cours de marketing', 2020),
(16, 'rr', 'rr', 2021),
(30, 'ff', 'ff', 2020);

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

DROP TABLE IF EXISTS `parties`;
CREATE TABLE IF NOT EXISTS `parties` (
  `id_part` int NOT NULL AUTO_INCREMENT,
  `id_cours` int NOT NULL,
  `title_part` varchar(100) NOT NULL,
  `path_part` varchar(255) NOT NULL,
  `view_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_part`),
  KEY `part_cours` (`id_cours`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id_part`, `id_cours`, `title_part`, `path_part`, `view_flag`) VALUES
(1, 1, 'Introduction to Module 1', '/uploads/introduction_module_1.pdf', 1),
(2, 3, 'Advanced Concepts Module 3', '/uploads/advanced_concepts_module_3.pdf', 1),
(3, 7, 'Beginner Guide Module 7', '/uploads/beginner_guide_module_7.pdf', 0),
(4, 8, 'Historical Overview Module 8', '/uploads/historical_overview_module_8.pdf', 1),
(5, 9, 'Practical Applications Module 9', '/uploads/practical_applications_module_9.pdf', 0),
(7, 13, 'Module 13 Summary', '/uploads/module_13_summary.pdf', 0),
(8, 16, 'Detailed Analysis Module 16', '/uploads/detailed_analysis_module_16.pdf', 1),
(11, 1, 'Introduction to Module 2', '/uploads/introduction_module_2.pdf', 0),
(12, 1, 'Introduction to Module 3', '/uploads/introduction_module_3.pdf', 1),
(13, 1, 'Introduction to Module 4', '/uploads/introduction_module_4.pdf', 1),
(26, 1, 'test', '/uploads/parts/PW1-slides-partie11.pdf', 0),
(35, 1, 'TEST', '/uploads/parts/TP3.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `professeurs`
--

DROP TABLE IF EXISTS `professeurs`;
CREATE TABLE IF NOT EXISTS `professeurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `request` tinyint(1) NOT NULL DEFAULT '0',
  `path_profile` varchar(150) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'uploads/pfp.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2032 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professeurs`
--

INSERT INTO `professeurs` (`id`, `nom`, `prenom`, `adresse`, `email`, `mot_de_passe`, `request`, `path_profile`) VALUES
(2020, 'med', 'med', 'TEST', 'test@gmail.com', '$2y$10$.VbqQqheUadSIeLi6gO8A.w2nbe3QR.CHbBeOMWdxnKJBlbF4e1dW', 0, 'uploads/pfp.png'),
(2021, 'ff', 'ff', 'ff', 'test2@gmial.com', '$2y$10$0X3hYZprrPKjA1ZA2OCjSuL.9DLrWTC8QQRA6/VPytvkzH62oihRC', 0, 'uploads/pfp.png'),
(2023, 'rr', 'rr', 'rr', 'test3@gmail.com', '$2y$10$0X3hYZprrPKjA1ZA2OCjSuL.9DLrWTC8QQRA6/VPytvkzH62oihRC', 0, 'uploads/pfp.png'),
(2024, 'ff', 'ff', 'ff', 'test6@gmial.com', '$2y$10$0X3hYZprrPKjA1ZA2OCjSuL.9DLrWTC8QQRA6/VPytvkzH62oihRC', 0, 'uploads/pfp.png'),
(2026, 'gg', 'gg', 'gg', 'testadmin2@gg.gg', '$2y$10$0X3hYZprrPKjA1ZA2OCjSuL.9DLrWTC8QQRA6/VPytvkzH62oihRC', 0, 'uploads/pfp.png'),
(2027, 'gg', 'gg', 'gg', 'testadmin3@gg.gg', '$2y$10$0X3hYZprrPKjA1ZA2OCjSuL.9DLrWTC8QQRA6/VPytvkzH62oihRC', 0, 'uploads/pfp.png'),
(2028, 'gg', 'gg', 'gg', 'testAdmin4@gg.gg', '$2y$10$0X3hYZprrPKjA1ZA2OCjSuL.9DLrWTC8QQRA6/VPytvkzH62oihRC', 0, 'uploads/pfp.png'),
(2029, 'gg', 'gg', 'gg', 'test34@gmail.com', '$2y$10$HoW9O0rUIFYJBuMeUPV.G.kARK9EkJK1aDsioPTsRaJpa3zf5RyvC', 0, 'uploads/pfp.png'),
(2031, 'test', 'test', 'test', 'test10@gmail.com', '$2y$10$rcPD35Kw3dkUUKLvEuU.Yuj82MsYRwPj5Nv5yZszjd.RdtKMruNx2', 0, 'uploads/pfp.png');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollement`
--
ALTER TABLE `enrollement`
  ADD CONSTRAINT `id_cours` FOREIGN KEY (`id_cours`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_etd` FOREIGN KEY (`id_etd`) REFERENCES `etudiant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enrollment_requests`
--
ALTER TABLE `enrollment_requests`
  ADD CONSTRAINT `cours` FOREIGN KEY (`cours_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prof_request` FOREIGN KEY (`prof_id`) REFERENCES `professeurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student` FOREIGN KEY (`student_id`) REFERENCES `etudiant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `prof` FOREIGN KEY (`prof_id`) REFERENCES `professeurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parties`
--
ALTER TABLE `parties`
  ADD CONSTRAINT `part_cours` FOREIGN KEY (`id_cours`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
