-- Database jeuxvideos --
DROP DATABASE IF EXISTS `jeuxvideos`;
CREATE DATABASE `jeuxvideos`;
USE `jeuxvideos`;

-- Table pour les administrateurs --
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `uti_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uti_login` VARCHAR(20) NOT NULL,
  `uti_pwd` VARCHAR(255) NOT NULL
) ENGINE = INNODB CHARACTER SET=utf8mb4;

-- Table pour les clients -- 
DROP TABLE IF EXISTS `client`;
CREATE TABLE client (
  `cli_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cli_nom` VARCHAR(20) NOT NULL,
  `cli_prenom` VARCHAR(20) NOT NULL,
  `cli_username` VARCHAR(20) NOT NULL UNIQUE,
  `cli_telephone`VARCHAR(20) NOT NULL UNIQUE,
  `cli_mail` VARCHAR(255) NOT NULL UNIQUE,
  `cli_pwd` VARCHAR(255) NOT NULL,
  `verify_token` VARCHAR(255) NOT NULL,
  `verify_status` INT NOT NULL DEFAULT 0
) ENGINE = INNODB CHARACTER SET=utf8mb4;

-- Table pour les jeux --
DROP TABLE IF EXISTS `jeux`;
CREATE TABLE jeux (
  `j_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `j_titre` VARCHAR(255) NOT NULL,
  `j_editeur` VARCHAR(255) NOT NULL,
  `j_parution` DATE NOT NULL,
  `j_resume` TEXT NOT NULL,
  `j_genre` VARCHAR(255) NOT NULL,
  `j_public` VARCHAR(255) NOT NULL,
  `j_joueurs` VARCHAR(255) NOT NULL,
  `j_dateAjout` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = INNODB CHARACTER SET=utf8mb4;

-- Table pour les plateformes --
DROP TABLE IF EXISTS `plateformes`;
CREATE TABLE plateformes (
  `plateforme_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nom_plateforme` VARCHAR(255) NOT NULL
) ENGINE=INNODB CHARACTER SET=utf8mb4;

-- Table jointure entre la table jeux et plateformes --
DROP TABLE IF EXISTS `jeux_plateformes`;
CREATE TABLE jeux_plateformes (
  `quantite_jeux`INT NOT NULL DEFAULT 5,
  `j_id` SMALLINT UNSIGNED NOT NULL,
  `plateforme_id` SMALLINT UNSIGNED NOT NULL,
  PRIMARY KEY (`j_id`, `plateforme_id`),
  FOREIGN KEY (`j_id`) REFERENCES jeux(`j_id`),
  FOREIGN KEY (`plateforme_id`) REFERENCES plateformes(`plateforme_id`)
) ENGINE=INNODB CHARACTER SET=utf8mb4;

-- Table pour les visuels --
DROP TABLE IF EXISTS `visuel`;
CREATE TABLE visuel (
  `v_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `visuel_ps5` VARCHAR(255) DEFAULT NULL,
  `visuel_ps4` VARCHAR(255) DEFAULT NULL,
  `visuel_xbox` VARCHAR(255) DEFAULT NULL,
  `visuel_switch` VARCHAR(255) DEFAULT NULL,
  `j_id` SMALLINT UNSIGNED NOT NULL,
  FOREIGN KEY (`j_id`) REFERENCES jeux (`j_id`)
) ENGINE = INNODB CHARACTER SET=utf8mb4;

-- Table pour les commentaires --
DROP TABLE IF EXISTS `commentaire_jeux`;
CREATE TABLE commentaire_jeux (
  `c_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `commentaire` TEXT,
  `date_ajout` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `j_id` SMALLINT UNSIGNED NOT NULL,
  `cli_id` SMALLINT UNSIGNED NOT NULL,
  FOREIGN KEY (`j_id`) REFERENCES jeux (`j_id`),
  FOREIGN KEY (`cli_id`) REFERENCES client (`cli_id`)
) ENGINE = INNODB CHARACTER SET=utf8mb4;

-- Table pour les notations --
DROP TABLE IF EXISTS `notation_jeu`;
CREATE TABLE notation_jeu (
  `notation_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `note` TINYINT UNSIGNED NOT NULL,
  `date_notation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `j_id` SMALLINT UNSIGNED NOT NULL,
  `cli_id` SMALLINT UNSIGNED NOT NULL,
  FOREIGN KEY (`j_id`) REFERENCES jeux (`j_id`),
  FOREIGN KEY (`cli_id`) REFERENCES client (`cli_id`)
) ENGINE = INNODB CHARACTER SET=utf8mb4;

-- Table pour les locations --
DROP TABLE IF EXISTS `location`;
CREATE TABLE location (
  `loc_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `client_id` SMALLINT UNSIGNED NOT NULL,
  `jeu_id` SMALLINT UNSIGNED NOT NULL,
  `plateforme_id` SMALLINT UNSIGNED NOT NULL,
  `date_location` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`jeu_id`) REFERENCES jeux (`j_id`),
  FOREIGN KEY (`client_id`) REFERENCES client (`cli_id`),
  FOREIGN KEY (`plateforme_id`) REFERENCES plateformes (`plateformes_id`)
) ENGINE = INNODB CHARACTER SET=utf8mb4;
