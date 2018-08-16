-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 16 Août 2018 à 12:05
-- Version du serveur :  5.6.37
-- Version de PHP :  7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `seqoia34`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `food_record`
--

CREATE TABLE IF NOT EXISTS `food_record` (
  `id` int(11) NOT NULL,
  `recorded_at` date NOT NULL,
  `entitled` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `calories` int(11) NOT NULL,
  `username` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `food_record`
--

INSERT INTO `food_record` (`id`, `recorded_at`, `entitled`, `calories`, `username`) VALUES
(3, '2018-08-14', 'Test nom repas', 99999, 'Test nom'),
(4, '2018-08-14', 'Potage', 2000558, 'Chris'),
(21, '2018-08-16', 'Test nom repas', 99999, 'Test nom'),
(22, '2018-08-16', 'Potage', 2000558, 'Chris'),
(23, '2018-08-16', 'Test nom repas', 99999, 'Test nom'),
(24, '2018-08-16', 'Potage', 2000558, 'Chris'),
(25, '2018-08-16', 'Test nom repas', 99999, 'Test nom'),
(26, '2018-08-16', 'Potage', 2000558, 'Chris');

-- --------------------------------------------------------

--
-- Structure de la table `fos_user`
--

CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(8, 'Toto', 'Toto', 'toto@gmail.com', 'toto@gmail.com', 0, NULL, 'toto', NULL, NULL, NULL, 'a:0:{}'),
(9, 'user 1', 'user 1', 'userfix1@gmail.com', 'userfix1@gmail.com', 0, NULL, 'toto', NULL, NULL, NULL, 'a:0:{}'),
(10, 'user 2', 'user 2', 'userfix2@gmail.com', 'userfix2@gmail.com', 0, NULL, 'toto', NULL, NULL, NULL, 'a:0:{}'),
(11, 'user 3', 'user 3', 'userfix3@gmail.com', 'userfix3@gmail.com', 0, NULL, 'toto', NULL, NULL, NULL, 'a:0:{}'),
(12, 'user 4', 'user 4', 'userfix4@gmail.com', 'userfix4@gmail.com', 0, NULL, 'toto', NULL, NULL, NULL, 'a:0:{}'),
(13, 'user 5', 'user 5', 'userfix5@gmail.com', 'userfix5@gmail.com', 0, NULL, 'toto', NULL, NULL, NULL, 'a:0:{}'),
(14, 'user 6', 'user 6', 'userfix6@gmail.com', 'userfix6@gmail.com', 0, NULL, 'toto', NULL, NULL, NULL, 'a:0:{}'),
(15, 'Test nom', 'test nom', 'test@gmail.com', 'test@gmail.com', 1, NULL, '$2y$13$cBWdqo/dBRkdHFmeAFlZ1eWwrXOrWYadxl/zFbHbaB4uJiZK2EA0K', '2018-08-16 08:25:56', NULL, NULL, 'a:0:{}'),
(16, 'Test nom 2', 'test nom 2', 'test2@gmail.com', 'test2@gmail.com', 1, NULL, '$2y$13$9YUiD8BnonKt5df/AGVRXuooAhuXRGcAT/q5cLe44rlrZ1AXl1nXC', '2018-08-16 08:27:19', NULL, NULL, 'a:0:{}');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `food_record`
--
ALTER TABLE `food_record`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fos_user`
--
ALTER TABLE `fos_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `food_record`
--
ALTER TABLE `food_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
