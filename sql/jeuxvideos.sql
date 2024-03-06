-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 05 mars 2024 à 17:52
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jeuxvideos`
--
DROP DATABASE IF EXISTS `jeuxvideos`;
CREATE DATABASE `jeuxvideos`;
USE `jeuxvideos`;
-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `uti_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uti_login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uti_pwd` varchar(255) NOT NULL,
  PRIMARY KEY (`uti_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`uti_id`, `uti_login`, `uti_pwd`) VALUES
(1, 'admin@QuantumGamerShop.com', '$2y$10$USnX5W6WaoO1btg5StuKSuMfuEUu5HHnEKRAyTP6IGFKuySrYef8C');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `cli_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cli_nom` varchar(20) NOT NULL,
  `cli_prenom` varchar(20) NOT NULL,
  `cli_username` varchar(20) NOT NULL,
  `cli_telephone` varchar(20) NOT NULL,
  `cli_mail` varchar(255) NOT NULL,
  `cli_pwd` varchar(255) NOT NULL,
  `verify_token` varchar(255) NOT NULL,
  `verify_status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`cli_id`),
  UNIQUE KEY `cli_username` (`cli_username`),
  UNIQUE KEY `cli_mail` (`cli_mail`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`cli_id`, `cli_nom`, `cli_prenom`, `cli_username`, `cli_telephone`, `cli_mail`, `cli_pwd`, `verify_token`, `verify_status`) VALUES
(1, 'Moussi', 'Sid-Ahmed', 'Sidox91', '01 02 03 04 05', 'aze62955@gmail.com', '$2y$10$oanhJ9Gap/DQIPhUEM1.8ufXT8Aq7BnDJ44GLZIlc79l7Yhu9REqe', '003567fc1de572278122076cb7981c40', 1);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire_jeux`
--

DROP TABLE IF EXISTS `commentaire_jeux`;
CREATE TABLE IF NOT EXISTS `commentaire_jeux` (
  `c_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `commentaire` text,
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `j_id` smallint UNSIGNED NOT NULL,
  `cli_id` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`c_id`),
  KEY `j_id` (`j_id`),
  KEY `cli_id` (`cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commentaire_jeux`
--

INSERT INTO `commentaire_jeux` (`c_id`, `commentaire`, `date_ajout`, `j_id`, `cli_id`) VALUES
(5, 'COol le jeux', '2024-03-04 12:23:13', 4, 1),
(6, 'bien', '2024-03-04 12:31:05', 4, 1),
(7, 'bien', '2024-03-04 15:18:46', 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

DROP TABLE IF EXISTS `jeux`;
CREATE TABLE IF NOT EXISTS `jeux` (
  `j_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `j_titre` varchar(255) NOT NULL,
  `j_editeur` varchar(255) NOT NULL,
  `j_parution` date NOT NULL,
  `j_resume` text NOT NULL,
  `j_genre` varchar(255) NOT NULL,
  `j_public` varchar(255) NOT NULL,
  `j_joueurs` varchar(255) NOT NULL,
  `j_dateAjout` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`j_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `jeux`
--

INSERT INTO `jeux` (`j_id`, `j_titre`, `j_editeur`, `j_parution`, `j_resume`, `j_genre`, `j_public`, `j_joueurs`, `j_dateAjout`) VALUES
(4, 'Marvel\'s Spider-man 2', 'Sony Interactive Entertainment', '2023-10-20', 'Les deux Spider-Man, Peter Parker et Miles Morales, sont de retour pour une nouvelle aventure de la célèbre franchise Spider-Man de Marvel acclamée par la critique.Balancez-vous de toile en toile, sautez du haut des gratte-ciels et utilisez vos nouvelles delta-toiles dans le New York de Marvel, en passant rapidement de Peter Parker à Miles Morales pour vivre différentes histoires et découvrir de nouveaux pouvoirs, tandis que Venom menace de détruire leur vie, leur ville et ceux qu’ils aiment.', '[\"Action\"]', '+16', '1', '2024-02-16 19:57:53'),
(5, 'Marvel\'s Spider-man Miles Morales', 'Sony Interactive Entertainment', '2020-11-12', 'Dans la dernière aventure de l\'univers Marvel\'s Spider-Man, le jeune Miles Morales prend ses marques dans son nouveau foyer tout en marchant dans les pas de son mentor, Peter Parker, en tant que nouveau Spider-Man. Mais quand une lutte acharnée pour le pouvoir menace de détruire son nouveau foyer, ce héros en devenir réalise qu\'un grand pouvoir implique de grandes responsabilités. Pour sauver le New York de Marvel, Miles doit enfiler la tenue de Spider-Man et lui faire honneur.', '[\"Action\"]', '+16', '1', '2024-02-16 19:59:33'),
(6, 'Cyberpunk 2077 Ultimate Edition', 'CD Projekt', '2023-12-07', 'Cyberpunk 2077 est un RPG d\'action-aventure en monde ouvert qui se déroule à Night City, une mégalopole obsédée par le pouvoir, la séduction et les modifications corporelles. Incarnez V, cyber-mercenaire, et affrontez les forces les plus puissantes de la ville dans un combat pour la gloire et la survie. C\'est ici que se forgent les légendes. Quelle sera la vôtre ?L\'EXPÉRIENCE CYBERPUNK 2077 ULTIME', '[\"Tir\",\"jeu de r\\u00f4le\"]', '+18', '1', '2024-02-16 20:01:24'),
(7, 'New Super Mario Bros. U Deluxe', 'Nintendo', '2019-01-11', 'U Deluxe sur Nintendo Switch ! Jusqu\'à quatre joueurs* peuvent s\'associer pour récolter des pièces et se débarrasser de leurs ennemis dans leur course vers le drapeau, ou encore s\'affronter dans une compétition amicale pour grapiller un maximum d\'or !', '[\"Plate-Forme\",\"Aventure\"]', 'tout_public', '1-4', '2024-02-16 20:02:49');

-- --------------------------------------------------------

--
-- Structure de la table `jeux_plateformes`
--

DROP TABLE IF EXISTS `jeux_plateformes`;
CREATE TABLE IF NOT EXISTS `jeux_plateformes` (
  `quantite_jeux` int NOT NULL DEFAULT '5',
  `j_id` smallint UNSIGNED NOT NULL,
  `plateforme_id` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`j_id`,`plateforme_id`),
  KEY `plateforme_id` (`plateforme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `jeux_plateformes`
--

INSERT INTO `jeux_plateformes` (`quantite_jeux`, `j_id`, `plateforme_id`) VALUES
(5, 4, 1),
(5, 5, 1),
(4, 5, 2),
(5, 6, 1),
(5, 6, 3),
(2, 7, 4);

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `loc_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` smallint UNSIGNED NOT NULL,
  `jeu_id` smallint UNSIGNED NOT NULL,
  `plateforme_id` smallint UNSIGNED NOT NULL,
  `date_location` datetime NOT NULL,
  PRIMARY KEY (`loc_id`),
  KEY `jeu_id` (`jeu_id`),
  KEY `client_id` (`client_id`),
  KEY `plateforme_id` (`plateforme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`loc_id`, `client_id`, `jeu_id`, `plateforme_id`, `date_location`) VALUES
(1, 1, 4, 1, '2024-03-04 19:16:56');

-- --------------------------------------------------------

--
-- Structure de la table `notation_jeu`
--

DROP TABLE IF EXISTS `notation_jeu`;
CREATE TABLE IF NOT EXISTS `notation_jeu` (
  `notation_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `note` tinyint UNSIGNED NOT NULL,
  `date_notation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `j_id` smallint UNSIGNED NOT NULL,
  `cli_id` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`notation_id`),
  KEY `j_id` (`j_id`),
  KEY `cli_id` (`cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `notation_jeu`
--

INSERT INTO `notation_jeu` (`notation_id`, `note`, `date_notation`, `j_id`, `cli_id`) VALUES
(1, 4, '2024-03-04 11:31:41', 4, 1),
(5, 2, '2024-03-04 12:10:32', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `plateformes`
--

DROP TABLE IF EXISTS `plateformes`;
CREATE TABLE IF NOT EXISTS `plateformes` (
  `plateforme_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_plateforme` varchar(255) NOT NULL,
  PRIMARY KEY (`plateforme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `plateformes`
--

INSERT INTO `plateformes` (`plateforme_id`, `nom_plateforme`) VALUES
(1, 'PS5'),
(2, 'PS4'),
(3, 'Xbox'),
(4, 'Switch');

-- --------------------------------------------------------

--
-- Structure de la table `visuel`
--

DROP TABLE IF EXISTS `visuel`;
CREATE TABLE IF NOT EXISTS `visuel` (
  `v_id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `visuel_ps5` varchar(255) DEFAULT NULL,
  `visuel_ps4` varchar(255) DEFAULT NULL,
  `visuel_xbox` varchar(255) DEFAULT NULL,
  `visuel_switch` varchar(255) DEFAULT NULL,
  `j_id` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`v_id`),
  KEY `j_id` (`j_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `visuel`
--

INSERT INTO `visuel` (`v_id`, `visuel_ps5`, `visuel_ps4`, `visuel_xbox`, `visuel_switch`, `j_id`) VALUES
(2, '../../../assets/img/plateforme/ps5/spiderman2.webp', NULL, NULL, NULL, 4),
(3, '../../../assets/img/plateforme/ps5/spiderman_morales.jpg', '../../../assets/img/plateforme/ps4/spiderman_morales.jpg', NULL, NULL, 5),
(4, '../../../assets/img/plateforme/ps5/cyberpunk.webp', NULL, '../../../assets/img/plateforme/xbox/cyberpunk.jpg', NULL, 6),
(5, NULL, NULL, NULL, '../../../assets/img/plateforme/switch/mario.jpg', 7);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire_jeux`
--
ALTER TABLE `commentaire_jeux`
  ADD CONSTRAINT `commentaire_jeux_ibfk_1` FOREIGN KEY (`j_id`) REFERENCES `jeux` (`j_id`),
  ADD CONSTRAINT `commentaire_jeux_ibfk_2` FOREIGN KEY (`cli_id`) REFERENCES `client` (`cli_id`);

--
-- Contraintes pour la table `jeux_plateformes`
--
ALTER TABLE `jeux_plateformes`
  ADD CONSTRAINT `jeux_plateformes_ibfk_1` FOREIGN KEY (`j_id`) REFERENCES `jeux` (`j_id`),
  ADD CONSTRAINT `jeux_plateformes_ibfk_2` FOREIGN KEY (`plateforme_id`) REFERENCES `plateformes` (`plateforme_id`);

--
-- Contraintes pour la table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`jeu_id`) REFERENCES `jeux` (`j_id`),
  ADD CONSTRAINT `location_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client` (`cli_id`),
  ADD CONSTRAINT `location_ibfk_3` FOREIGN KEY (`plateforme_id`) REFERENCES `plateformes` (`plateforme_id`);

--
-- Contraintes pour la table `notation_jeu`
--
ALTER TABLE `notation_jeu`
  ADD CONSTRAINT `notation_jeu_ibfk_1` FOREIGN KEY (`j_id`) REFERENCES `jeux` (`j_id`),
  ADD CONSTRAINT `notation_jeu_ibfk_2` FOREIGN KEY (`cli_id`) REFERENCES `client` (`cli_id`);

--
-- Contraintes pour la table `visuel`
--
ALTER TABLE `visuel`
  ADD CONSTRAINT `visuel_ibfk_1` FOREIGN KEY (`j_id`) REFERENCES `jeux` (`j_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
