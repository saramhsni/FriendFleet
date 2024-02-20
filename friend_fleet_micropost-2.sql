-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 20, 2024 at 12:58 PM
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
-- Database: `friend_fleet_micropost`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240111221059', '2024-01-11 22:11:08', 241);

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `user_source` int(11) NOT NULL,
  `user_target` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`user_source`, `user_target`) VALUES
(9, 16),
(9, 38),
(9, 40),
(9, 48),
(9, 49),
(9, 50),
(16, 38),
(16, 40),
(16, 48),
(16, 49),
(16, 50),
(38, 16),
(38, 40),
(38, 48),
(38, 49),
(38, 50),
(40, 16),
(40, 38),
(40, 48),
(40, 49),
(40, 50),
(48, 9),
(48, 16),
(48, 38),
(48, 40),
(48, 49),
(48, 50),
(49, 16),
(49, 38),
(49, 40),
(49, 48),
(50, 16),
(50, 38),
(50, 40),
(50, 48),
(50, 49);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` longtext NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `micro_post`
--

CREATE TABLE `micro_post` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `micro_post`
--

INSERT INTO `micro_post` (`id`, `author_id`, `title`, `text`, `created_at`, `image`) VALUES
(17, 16, 'Design or (Dis)content', 'Among design professionals, there\'s a bit of controversy surrounding the filler text. Controversy, as in Death to Lorem Ipsum.', '2024-01-17 10:21:51', 'beautiful-3vau5vtfa3qn7k8v-65d48fbc05346.jpg'),
(31, 40, 'Test Post Anna with Edit', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore', '2024-01-30 21:29:48', 'digital-camera-photo-1080x675-65b96a4c18fff.jpg'),
(37, 38, 'Publish your passions, your way', 'Create a beautiful blog that fits your style. Choose from a selection of easy-to-use templates – all with flexible layouts and hundreds of background images – or design something new.', '2024-02-05 22:46:32', '360-F-573959050-BXeecXwfgIlMFGdOfHRiSdedBealWU5Q-65d48c4a77ac6.jpg'),
(44, 48, 'Where does it come from?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', '2024-02-16 11:27:35', '4k-beautiful-colorful-abstract-wallpaper-photo-65d48c2b435d1.jpg'),
(45, 49, 'Welcome to the Dummy Text Generator!', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.', '2024-02-20 11:32:35', 'desktop-wallpaper-beautiful-nature-latest-beauty-nature-65d48dd34ed46.jpg'),
(46, 50, 'In enim justo, rhoncus ut', 'mperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet', '2024-02-20 11:35:27', 'france-in-pictures-beautiful-places-to-photograph-mont-st-michel-65d48e7f4095a.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `micro_post_user`
--

CREATE TABLE `micro_post_user` (
  `micro_post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `micro_post_user`
--

INSERT INTO `micro_post_user` (`micro_post_id`, `user_id`) VALUES
(31, 48),
(37, 48),
(44, 48);

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) NOT NULL,
  `hashed_token` varchar(100) NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `pseudo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`, `is_active`, `pseudo`) VALUES
(9, 'mani@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$ajfGKylCZUHEHPlSKh8ZyuwLdZKoK4ktSr8hA.i5SRYPzY1wZVnjO', 0, 1, 'maniar'),
(14, 'kami@gmail.com', '[]', '$2y$13$33Oknw3tiiJ/ltGnYu61we2wNu9352HOd25wkNsWuJ77qDaakGnSa', 1, 1, 'kamran'),
(16, 'ali@gmail.com', '[]', '$2y$13$6tiGW.LnRA2RB4u/iAR6b.IrW8VE1llwNhLKvtAgMKZNe3KbbU3Vy', 1, 1, 'AliS'),
(18, 'yun@gmail.com', '[]', '$2y$13$h.uUIb95vEf1PWW6SiaLT.WzG/QmH3jwBjFftGRdzrHrOToJJolo2', 0, 1, 'Yun'),
(30, 'bobo@gmail.com', '[]', '$2y$13$unTHOMDUDEUo9it2q9LvOOqUCXRxrcr0aNmf3Ku4BrXWtMyEtLER2', 0, 1, 'bobo'),
(31, 'koko@gmail.com', '[]', '$2y$13$dYgAqCJNb1QBtNyi0YEPteNJGv5m6jHaUl0oBWiLtX/dxjzDmVyb.', 0, 1, 'koko'),
(32, 'nono@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$VMUWMl7k8QCKLiHpiTzdKOlf.mgNzFNoZ08zxCPTq1aQG1tL7SsAO', 0, 1, 'nono'),
(38, 'sami@gmail.com', '[]', '$2y$13$tiCX0G2w8quWTG.xxe30aet8UVIteRKqozkYUGh1jgo.ex7fcu35C', 0, 1, 'sami'),
(40, 'Anne@gmail.com', '[]', '$2y$13$NGOb4WvDjFReCQnN43UmU.HiTAD3nr2LPF5f2/gTLM6SmfqYyHoMa', 1, 1, 'Anne'),
(42, 'hey@gmail.com', '[]', '$2y$13$pJ4aJSmShEGQCyZg/hilk.B.1RgGzWc1md4UZH4zywLWouRKQMhd2', 0, 1, 'hey'),
(44, 'dena@gmail.com', '[]', '$2y$13$//UmcBn8jY7k2ClRsfVyb.A6d2vt4W27Q70wGazqxMf6NR9ksFfMC', 0, 1, 'Dena'),
(45, 'dadi@gmail.com', '[]', '$2y$13$sTJPp6fN02RfB4dXZEiPu.QrdZyqnefu6wqPdENEO7InKYJqJvSKq', 0, 1, 'dadi'),
(46, 'maysam@gmail.com', '[]', '$2y$13$Vwbi60nthj32.Tr501piP.Xkf2NtOCV8ymqs.C/1kdTphGDx4Anj.', 0, 1, 'maysam'),
(47, 'shabi@gmail.com', '[]', '$2y$13$9x.MYTPe5pD/tidSkZCi5eYb7plwIJYNygo1GoOEmWeq4LcSvV4xK', 0, 1, 'shabi'),
(48, 'sara@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$rpv.ypAjPNcMYlJNgYyE2.wyx.xHP2nj2NH4Znq1wPohsl4DfsOEy', 0, 1, 'sara'),
(49, 'parmi@gmail.com', '[]', '$2y$13$p8nkk1D52Tqp0NZYS7OW8.K2Xde2lHlzjHlf.lmV0LV5QIVjzDA1W', 0, 1, 'parmi'),
(50, 'soli@gmail.com', '[]', '$2y$13$skPZyxFj4OuVNQystPuf3.smGdgHmHqZU2vJMgX4E9QEcVEytrXW6', 0, 1, 'soli');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bio` varchar(1024) DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `name`, `bio`, `profession`, `date_of_birth`, `image`) VALUES
(8, 9, NULL, NULL, NULL, NULL, '1642574-65d4909be1acd.jpg'),
(12, 14, NULL, NULL, NULL, NULL, NULL),
(14, 16, NULL, NULL, NULL, NULL, 'DF411C8F-B2C4-4F69-96F5-052DE01FE782-65a7a9f13c13f.jpg'),
(16, 18, NULL, NULL, NULL, NULL, NULL),
(28, 30, NULL, NULL, NULL, NULL, NULL),
(29, 31, NULL, NULL, NULL, NULL, NULL),
(30, 32, NULL, NULL, NULL, NULL, NULL),
(36, 38, NULL, NULL, NULL, NULL, 'photo-2024-01-17-11-04-56-65b670985e456.jpg'),
(38, 40, 'Anne', 'I\'m Anne from Lyon', 'English Teacher', '1988-01-02', '2024-01-30-21-51-39-65b9618d46ecf.jpg'),
(40, 42, NULL, NULL, NULL, NULL, NULL),
(42, 44, NULL, NULL, NULL, NULL, NULL),
(43, 45, NULL, NULL, NULL, NULL, NULL),
(44, 46, NULL, NULL, NULL, NULL, NULL),
(45, 47, NULL, NULL, NULL, NULL, NULL),
(46, 48, 'Sara', 'I am very ziba', 'nadoombe', '2020-07-18', 'bb-krista-800x1000-65d48cba43a0d.jpg'),
(47, 49, 'parmida', NULL, NULL, NULL, 'Jodie-Comer-65d48d910c3e5.jpg'),
(48, 50, NULL, NULL, NULL, NULL, 'scarlett-johansson-1311777589-view-1-65d48e51c608a.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526C4B89032C` (`post_id`),
  ADD KEY `IDX_9474526CF675F31B` (`author_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`user_source`,`user_target`),
  ADD KEY `IDX_8408FDA73AD8644E` (`user_source`),
  ADD KEY `IDX_8408FDA7233D34C1` (`user_target`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DB021E96F624B39D` (`sender_id`),
  ADD KEY `IDX_DB021E96E92F8F78` (`recipient_id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `micro_post`
--
ALTER TABLE `micro_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2AEFE017F675F31B` (`author_id`);

--
-- Indexes for table `micro_post_user`
--
ALTER TABLE `micro_post_user`
  ADD PRIMARY KEY (`micro_post_id`,`user_id`),
  ADD KEY `IDX_19DCF74D11E37CEA` (`micro_post_id`),
  ADD KEY `IDX_19DCF74DA76ED395` (`user_id`);

--
-- Indexes for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D95AB405A76ED395` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `micro_post`
--
ALTER TABLE `micro_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C4B89032C` FOREIGN KEY (`post_id`) REFERENCES `micro_post` (`id`),
  ADD CONSTRAINT `FK_9474526CF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `FK_8408FDA7233D34C1` FOREIGN KEY (`user_target`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8408FDA73AD8644E` FOREIGN KEY (`user_source`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_DB021E96E92F8F78` FOREIGN KEY (`recipient_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_DB021E96F624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `micro_post`
--
ALTER TABLE `micro_post`
  ADD CONSTRAINT `FK_2AEFE017F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `micro_post_user`
--
ALTER TABLE `micro_post_user`
  ADD CONSTRAINT `FK_19DCF74D11E37CEA` FOREIGN KEY (`micro_post_id`) REFERENCES `micro_post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_19DCF74DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `FK_D95AB405A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
