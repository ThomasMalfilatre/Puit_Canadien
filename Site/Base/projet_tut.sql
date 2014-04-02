-- phpMyAdmin SQL Dump
-- version 4.1.5
-- http://www.phpmyadmin.net
--
-- Client :  info2
-- Généré le :  Mar 11 Février 2014 à 09:11
-- Version du serveur :  5.5.24-4-log
-- Version de PHP :  5.4.9-4ubuntu2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `DBmalfilatre`
--

-- --------------------------------------------------------

--
-- Structure de la table `ACTIVITE`
--

CREATE TABLE IF NOT EXISTS `ACTIVITE` (
  `id` int(4) NOT NULL,
  `nom` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ACTIVITE`
--

INSERT INTO `ACTIVITE` (`id`, `nom`) VALUES
(1, 'Java'),
(2, 'Python'),
(3, 'Anglais'),
(4, 'Repos'),
(5, 'Cafe'),
(6, 'PHP');

-- --------------------------------------------------------

--
-- Structure de la table `PARTICIPE`
--

CREATE TABLE IF NOT EXISTS `PARTICIPE` (
  `users` varchar(20) NOT NULL,
  `activite` int(4) NOT NULL,
  `Date` date NOT NULL,
  `Heure` time NOT NULL,
  PRIMARY KEY (`users`,`activite`,`Date`,`Heure`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `PARTICIPE`
--

INSERT INTO `PARTICIPE` (`users`, `activite`, `Date`, `Heure`) VALUES
('admin', 1, '0000-00-00', '07:00:00'),
('admin', 3, '2014-03-02', '18:50:00'),
('admin', 5, '2014-02-13', '15:10:00');

-- --------------------------------------------------------

--
-- Structure de la table `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
  `login` varchar(20) NOT NULL,
  `passwd` varchar(40) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `USERS`
--

INSERT INTO `USERS` (`login`, `passwd`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3'),
('thomas', 'ef6e65efc188e7dffd7335b646a85a21'),
('toto', 'f71dbe52628a3f83a77ab494817525c6');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
