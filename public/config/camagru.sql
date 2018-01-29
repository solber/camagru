-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 16 jan. 2018 à 23:49
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE IF EXISTS camagru;
CREATE DATABASE camagru;
use camagru;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL,
  `owner_comment` int(11) NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `posted_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `img_id`, `owner_comment`, `comment_text`, `posted_date`) VALUES
(21, 96, 6, 'Meoow', '2018-01-28 23:36:12');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_path` varchar(255) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `posted_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `img_path`, `owner_id`, `posted_date`) VALUES
(95, 'img/user/6/1517178919UhchPPTcas.png', 6, '2018-01-28 23:35:19'),
(96, 'img/user/6/1517178959CiGesgRet4.png', 6, '2018-01-28 23:36:00');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL,
  `owner_like_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `img_id`, `owner_like_id`) VALUES
(33, 95, 6),
(34, 96, 7);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(60) NOT NULL,
  `verified` varchar(1) NOT NULL DEFAULT 'N',
  `mailable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `mail`, `password`, `token`, `verified`, `mailable`) VALUES
(6, 'solber', 'solber@hotmail.fr', '$2y$10$mGLV8ninO.JQOVOD4rrHke1OGhrobQ0OqPFdKWEWILqKEd.7uELWC', '1eKYEfbZR5mWEQzOG0kFfWowcPqPHfm089UretBNLty4V5aOUX29HHS5EAWw', 'Y', 0),
(7, 'solber2', 'solber@hotmail.fr', '$2y$10$mGLV8ninO.JQOVOD4rrHke1OGhrobQ0OqPFdKWEWILqKEd.7uELWC', '1eKYEfbZR5mWEQzOG0kFfWowcPqPHfm089UretBNLty4V5aOUX29HHS5EAWw', 'Y', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
