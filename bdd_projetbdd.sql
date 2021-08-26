-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : Dim 24 jan. 2021 à 20:26
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdd_projetbdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `allumer`
--

CREATE TABLE `allumer` (
  `IdAppareil` int(11) NOT NULL,
  `DebutAllumage` datetime NOT NULL,
  `FinAllumage` datetime DEFAULT NULL,
  `IdJournal` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `allumer`
--

INSERT INTO `allumer` (`IdAppareil`, `DebutAllumage`, `FinAllumage`, `IdJournal`) VALUES
(5, '2021-01-24 20:06:20', '2021-01-24 20:06:31', 7),
(3, '2021-01-24 19:58:41', '2021-01-24 19:58:47', 7),
(4, '2021-01-24 20:06:55', '2021-01-24 20:07:16', 7),
(6, '2021-01-24 20:14:06', '2021-01-24 20:14:21', 7),
(5, '2021-01-24 20:18:56', '2021-01-24 20:19:21', 7);

-- --------------------------------------------------------

--
-- Structure de la table `appareil`
--

CREATE TABLE `appareil` (
  `IdAppareil` int(11) NOT NULL,
  `DescriptionLieu` varchar(30) DEFAULT NULL,
  `Libelle` varchar(50) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `IdPiece` int(11) NOT NULL,
  `IdTypeAppareil` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `appareil`
--

INSERT INTO `appareil` (`IdAppareil`, `DescriptionLieu`, `Libelle`, `Description`, `IdPiece`, `IdTypeAppareil`) VALUES
(4, 'Kuisine', 'Frigo', 'J\'aime manger', 0, 9),
(3, 'Salon', 'Ordinateur', 'Mon pc', 0, 23),
(5, 'Kuisine', 'Four', 'Four', 0, 18),
(6, 'Garge', 'Chargeur de la Tesla', 'Chargeur', 0, 12);

-- --------------------------------------------------------

--
-- Structure de la table `appart`
--

CREATE TABLE `appart` (
  `IdAppart` int(11) NOT NULL,
  `Libelle` varchar(50) DEFAULT NULL,
  `IdSecu` int(11) NOT NULL,
  `IdTypeAppart` int(11) NOT NULL,
  `IdMaison` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `appart`
--

INSERT INTO `appart` (`IdAppart`, `Libelle`, `IdSecu`, `IdTypeAppart`, `IdMaison`) VALUES
(7, 'Mon appart !', 3, 1, 7),
(6, 'Appart étudiant', 1, 3, 6),
(8, 'SAUMON', 3, 6, 8),
(9, 'La palce (un peux plus petit)', 1, 6, 9);

-- --------------------------------------------------------

--
-- Structure de la table `consommer`
--

CREATE TABLE `consommer` (
  `IdAppareil` int(11) NOT NULL,
  `IdRessource` int(11) NOT NULL,
  `ConsoParHeure` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `consommer`
--

INSERT INTO `consommer` (`IdAppareil`, `IdRessource`, `ConsoParHeure`) VALUES
(3, 1, 1),
(4, 1, 10),
(5, 1, 4),
(6, 1, 15);

-- --------------------------------------------------------

--
-- Structure de la table `contenirappareil`
--

CREATE TABLE `contenirappareil` (
  `IdAppart` int(11) NOT NULL,
  `IdAppareil` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contenirappareil`
--

INSERT INTO `contenirappareil` (`IdAppart`, `IdAppareil`) VALUES
(6, 3),
(7, 4),
(8, 5),
(9, 6);

-- --------------------------------------------------------

--
-- Structure de la table `contenirpiece`
--

CREATE TABLE `contenirpiece` (
  `IdAppart` int(11) NOT NULL,
  `IdPiece` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contenirtypepiece`
--

CREATE TABLE `contenirtypepiece` (
  `IdTypeAppart` int(11) NOT NULL,
  `IdTypePiece` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dateallumage`
--

CREATE TABLE `dateallumage` (
  `DebutAllumage` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `datelocation`
--

CREATE TABLE `datelocation` (
  `DebutLocation` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dateproprio`
--

CREATE TABLE `dateproprio` (
  `DebutPossession` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `dateproprio`
--

INSERT INTO `dateproprio` (`DebutPossession`) VALUES
('1984-01-25'),
('2020-02-14'),
('2020-09-01'),
('2021-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `NumeroDepartement` int(11) NOT NULL,
  `NomDepartement` varchar(50) DEFAULT NULL,
  `IdRegion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`NumeroDepartement`, `NomDepartement`, `IdRegion`) VALUES
(1, 'Ain', 1),
(3, 'Allier', 1),
(7, 'Ardèche', 1),
(15, 'Cantal', 1),
(26, 'Drôme', 1),
(38, 'Isère', 1),
(42, 'Loire', 1),
(43, 'Haute-Loire', 1),
(63, 'Puy-de-Dôme', 1),
(69, 'Rhône', 1),
(73, 'Savoie', 1),
(74, 'Haute-Savoie', 1),
(21, 'Côte-d\'Or', 2),
(25, 'Doubs', 2),
(39, 'Jura', 2),
(58, 'Nièvre', 2),
(70, 'Haute-Saône', 2),
(71, 'Saône-et-Loire', 2),
(90, 'Territoire de Belfort', 2),
(89, 'Yonne', 2),
(22, 'Côtes-d\'Armor', 3),
(29, 'Finistère', 3),
(35, 'Ille-et-Vilaine', 3),
(56, 'Morbihan', 3),
(18, 'Cher', 4),
(28, 'Eure-et-Loir', 4),
(36, 'Indre', 4),
(37, 'Indre-et-Loire', 4),
(41, 'Loir-et-Cher', 4),
(45, 'Loiret', 4),
(20, 'Corse', 5),
(8, 'Ardennes', 6),
(10, 'Aube', 6),
(51, 'Marne', 6),
(52, 'Haute-Marne', 6),
(54, 'Meurthe-et-Moselle', 6),
(55, 'Meuse', 6),
(57, 'Moselle', 6),
(67, 'Bas-Rhin', 6),
(68, 'Haut-Rhin', 6),
(88, 'Vosges', 6),
(2, 'Aisne', 7),
(59, 'Nord', 7),
(60, 'Oise', 7),
(62, 'Pas-de-Calais', 7),
(80, 'Somme ', 7),
(75, 'Paris', 8),
(77, 'Seine-et-Marne', 8),
(78, 'Yvelines', 8),
(91, 'Essonne', 8),
(92, 'Hauts-de-Seine', 8),
(93, 'Seine-Saint-Denis', 8),
(94, 'Val-de-Marne', 8),
(95, 'Val-d\'Oise', 8),
(14, 'Calvados', 9),
(27, 'Eure', 9),
(50, 'Manche', 9),
(61, 'Orne', 9),
(76, 'Seine-Maritime', 9),
(16, 'Charente', 10),
(17, 'Charente-Maritime', 10),
(19, 'Corrèze', 10),
(23, 'Creuse', 10),
(24, 'Dordogne', 10),
(33, 'Gironde', 10),
(40, 'Landes', 10),
(47, 'Lot-et-Garonne', 10),
(64, 'Pyrénées-Atlantiques', 10),
(79, 'Deux-Sèvres', 10),
(86, 'Vienne', 10),
(87, 'Haute-Vienne', 10),
(9, 'Ariège', 11),
(11, 'Aude', 11),
(12, 'Aveyron', 11),
(30, 'Gard', 11),
(31, 'Haute-Garonne', 11),
(32, 'Gers', 11),
(34, 'Hérault', 11),
(46, 'Lot', 11),
(48, 'Lozère', 11),
(65, 'Hautes-Pyrénées', 11),
(66, 'Pyrénées-Orientales', 11),
(81, 'Tarn', 11),
(82, 'Tarn-et-Garonne', 11),
(44, 'Loire-Atlantique', 12),
(49, 'Maine-et-Loire', 12),
(53, 'Mayenne', 12),
(72, 'Sarthe', 12),
(85, 'Vendée', 12),
(4, 'Alpes-de-Haute-Provence', 13),
(5, 'Hautes-Alpes', 13),
(6, 'Alpes-Maritimes', 13),
(13, 'Bouches-du-Rhône', 13),
(83, 'Var', 13),
(84, 'Vaucluse', 13),
(971, 'Guadeloupe', 14),
(972, 'Martinique', 15),
(973, 'Guyane', 16),
(974, 'La Réunion', 17),
(976, 'Mayotte', 18);

-- --------------------------------------------------------

--
-- Structure de la table `emettre`
--

CREATE TABLE `emettre` (
  `IdAppareil` int(11) NOT NULL,
  `IdSubstance` int(11) NOT NULL,
  `EmissionParHeure` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `emettre`
--

INSERT INTO `emettre` (`IdAppareil`, `IdSubstance`, `EmissionParHeure`) VALUES
(3, 1, 0.1),
(4, 1, 0.5),
(5, 1, 0.5),
(6, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `journal_allumage`
--

CREATE TABLE `journal_allumage` (
  `IdJournal` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `journal_allumage`
--

INSERT INTO `journal_allumage` (`IdJournal`) VALUES
(7),
(8),
(9),
(10),
(11);

-- --------------------------------------------------------

--
-- Structure de la table `louer`
--

CREATE TABLE `louer` (
  `Id_personne` int(11) NOT NULL,
  `DebutLocation` date NOT NULL,
  `FinLocation` date DEFAULT NULL,
  `IdAppart` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `louer`
--

INSERT INTO `louer` (`Id_personne`, `DebutLocation`, `FinLocation`, `IdAppart`) VALUES
(17, '2020-07-15', NULL, 8),
(18, '1984-01-25', NULL, 9),
(16, '2021-01-01', NULL, 7),
(15, '2020-09-01', NULL, 6);

-- --------------------------------------------------------

--
-- Structure de la table `maison`
--

CREATE TABLE `maison` (
  `IdMaison` int(11) NOT NULL,
  `NumeroMaison` int(11) DEFAULT NULL,
  `NomRue` varchar(50) DEFAULT NULL,
  `DegreIsolation` varchar(3) DEFAULT NULL,
  `EvalEco` varchar(3) DEFAULT NULL,
  `NomMaison` varchar(50) DEFAULT NULL,
  `IdVille` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `maison`
--

INSERT INTO `maison` (`IdMaison`, `NumeroMaison`, `NomRue`, `DegreIsolation`, `EvalEco`, `NomMaison`, `IdVille`) VALUES
(9, 45, 'Rue en Or', 'A', 'A', 'Le palace', 8),
(8, 3, 'Rue du pont', 'B', 'A', 'Mon carton', 7),
(7, 14, 'Rue Du Suicide', 'A', 'B', 'Ma Maison', 6),
(6, 12, 'Rue Jean Jores', 'C', 'C', 'Appart étudiant', 6);

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `Id_personne` int(11) NOT NULL,
  `AdresseMail` varchar(50) DEFAULT NULL,
  `MotDePasse` varchar(255) NOT NULL,
  `DateNaissance` date DEFAULT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Genre` char(1) DEFAULT NULL,
  `Telephone` char(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`Id_personne`, `AdresseMail`, `MotDePasse`, `DateNaissance`, `Nom`, `Prenom`, `Genre`, `Telephone`) VALUES
(16, 'diegodeloffre@mail.com', '$2y$10$jVqn59Vu4gxBmA1CnmTh4uHun/tdienDcX3f91bnwC3r9DjBKYd16', '1998-04-02', 'DELOFFRE', 'Diégo', 'm', '0664521347'),
(18, 'jorisloit@mail.com', '$2y$10$IHGKYLPN39/UtIJxsS5t2eXjSqZuyW0ujV/vovbDXEhT0e1NhFFmS', '1940-01-24', 'LOIT', 'Joris', 'f', '06487541'),
(17, 'pierrotfour@mail.com', '$2y$10$DXDSHLymdD2M0cbJ62/hoOUdC.FQoNIihMl6czpRGxg7fqT7Tdd7O', '1992-02-13', 'FOUR', 'Pierrot', 'o', '065847910'),
(15, 'maximesenger@mail.com', '$2y$10$pD6UQ0yKH7D8fYBbGcwduO06pcA5ReGgrWYysWaQKmWv70ChP33sm', '2000-07-29', 'Maxime', 'SENGER', 'm', '0669106758');

-- --------------------------------------------------------

--
-- Structure de la table `piece`
--

CREATE TABLE `piece` (
  `IdPiece` int(11) NOT NULL,
  `Libelle` varchar(50) DEFAULT NULL,
  `IdTypePiece` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `piece`
--

INSERT INTO `piece` (`IdPiece`, `Libelle`, `IdTypePiece`) VALUES
(1, 'Salon', 1),
(2, 'Salle à manger', 2),
(3, 'Chambre', 3),
(4, 'Salle de bain', 4),
(5, 'Cuisine', 5),
(6, 'Toilettes', 6),
(7, 'Autre', 7);

-- --------------------------------------------------------

--
-- Structure de la table `propriétaire`
--

CREATE TABLE `propriétaire` (
  `Id_personne` int(11) NOT NULL,
  `DebutPossession` date NOT NULL,
  `FinPossession` date DEFAULT NULL,
  `IdMaison` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `propriétaire`
--

INSERT INTO `propriétaire` (`Id_personne`, `DebutPossession`, `FinPossession`, `IdMaison`) VALUES
(18, '1984-01-25', NULL, 9),
(17, '2020-02-14', NULL, 8),
(16, '2021-01-01', NULL, 7),
(15, '2020-09-01', NULL, 6);

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `IdRegion` int(11) NOT NULL,
  `NomRegion` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`IdRegion`, `NomRegion`) VALUES
(1, 'Auvergne-Rhônes-Alpes'),
(2, 'Bourgogne-Franche-Comté'),
(3, 'Bretagne'),
(4, 'Centre-Val de Loire'),
(5, 'Corse'),
(6, 'Grand Est'),
(7, 'Hauts-de-France'),
(8, 'Île-de-France'),
(9, 'Normandie'),
(10, 'Nouvelle-Aquitaine'),
(11, 'Occitanie'),
(12, 'Pays de la Loire'),
(13, 'Provence-Alpes-Côte d\'Azur'),
(14, 'Guadeloupe'),
(15, 'Martinique'),
(16, 'Guyane'),
(17, 'La Réunion'),
(18, 'Mayotte');

-- --------------------------------------------------------

--
-- Structure de la table `ressources`
--

CREATE TABLE `ressources` (
  `IdRessource` int(11) NOT NULL,
  `Libelle` varchar(50) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `ValeurMinConsoParJour` double DEFAULT NULL,
  `ValeurMaxConsoParJour` double DEFAULT NULL,
  `ValeurCritConsoParJour` double DEFAULT NULL,
  `ValeurIdealeConsoParJour` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ressources`
--

INSERT INTO `ressources` (`IdRessource`, `Libelle`, `Description`, `ValeurMinConsoParJour`, `ValeurMaxConsoParJour`, `ValeurCritConsoParJour`, `ValeurIdealeConsoParJour`) VALUES
(1, 'Electricité', 'L\'électricité est l\'énergie la plus consommée dans le monde.(en KWH)', 30, 60, 90, 45),
(2, 'Eau', 'L\'eau est une ressource très importante dans une maison.(en m3)', 0.45, 0.65, 0.7, 0.55),
(3, 'Gaz', 'On utilise peu d\'appareil à gaz dans une maison mais il reste une ressource importante. (en KWH)', 45, 70, 80, 50);

-- --------------------------------------------------------

--
-- Structure de la table `securite`
--

CREATE TABLE `securite` (
  `IdSecu` int(11) NOT NULL,
  `Libelle` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `securite`
--

INSERT INTO `securite` (`IdSecu`, `Libelle`) VALUES
(1, 'Faible'),
(2, 'Moyen'),
(3, 'Fort');

-- --------------------------------------------------------

--
-- Structure de la table `substances`
--

CREATE TABLE `substances` (
  `IdSubstance` int(11) NOT NULL,
  `Libelle` varchar(50) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `ValeurMinProdParJour` double DEFAULT NULL,
  `ValeurMaxProdParJour` double DEFAULT NULL,
  `ValeurCritProdParJour` double DEFAULT NULL,
  `ValeurIdealeProdParJour` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `substances`
--

INSERT INTO `substances` (`IdSubstance`, `Libelle`, `Description`, `ValeurMinProdParJour`, `ValeurMaxProdParJour`, `ValeurCritProdParJour`, `ValeurIdealeProdParJour`) VALUES
(1, 'CO2', 'Principal polluant émis dans le monde.(en kg)', 15.81, 27.66, 36.64, 20.25),
(2, 'Eaux grises', 'Eaux usagées par des usages d\'hygiène.(en L)', 400, 800, 1000, 600);

-- --------------------------------------------------------

--
-- Structure de la table `typeappareil`
--

CREATE TABLE `typeappareil` (
  `IdTypeAppareil` int(11) NOT NULL,
  `Libelle` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typeappareil`
--

INSERT INTO `typeappareil` (`IdTypeAppareil`, `Libelle`) VALUES
(1, 'Radiateur électrique'),
(7, 'Lave linge'),
(6, 'Lave vaisselle'),
(5, 'Gasinière'),
(4, 'Hotte'),
(3, 'Climatiseur'),
(2, 'Radiateur à gaz'),
(8, 'Sèche linge'),
(9, 'Réfrigérateur'),
(10, 'Congélateur'),
(11, 'Plaque de cuisson'),
(12, 'Blender'),
(13, 'Console de jeu'),
(14, 'Télévision'),
(15, 'Box internet'),
(16, 'Grille pain'),
(17, 'Machine à café'),
(18, 'Four'),
(19, 'Micro-ondes'),
(20, 'Aspirateur'),
(21, 'Fer à repasser'),
(22, 'Douche'),
(23, 'Ordinateur'),
(24, 'Ventilateur'),
(25, 'Lampes'),
(26, 'Téléphone');

-- --------------------------------------------------------

--
-- Structure de la table `typeappart`
--

CREATE TABLE `typeappart` (
  `IdTypeAppart` int(11) NOT NULL,
  `Libelle` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typeappart`
--

INSERT INTO `typeappart` (`IdTypeAppart`, `Libelle`) VALUES
(1, 'Studio'),
(2, 'T1'),
(3, 'T2'),
(4, 'T3'),
(5, 'T4'),
(6, 'T5');

-- --------------------------------------------------------

--
-- Structure de la table `typepiece`
--

CREATE TABLE `typepiece` (
  `IdTypePiece` int(11) NOT NULL,
  `Libelle` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typepiece`
--

INSERT INTO `typepiece` (`IdTypePiece`, `Libelle`) VALUES
(1, 'Salon'),
(2, 'Salle à manger'),
(3, 'Chambre'),
(4, 'Salle de bain'),
(5, 'Cuisine'),
(6, 'Toilettes'),
(7, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `IdVille` int(11) NOT NULL,
  `NomVille` varchar(50) DEFAULT NULL,
  `CP` char(5) DEFAULT NULL,
  `NumeroDepartement` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`IdVille`, `NomVille`, `CP`, `NumeroDepartement`) VALUES
(8, 'Paris', '75000', 4),
(7, 'Anger', '49000', 1),
(6, 'Tours', '37000', 37);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `allumer`
--
ALTER TABLE `allumer`
  ADD PRIMARY KEY (`IdAppareil`,`DebutAllumage`),
  ADD KEY `DebutAllumage` (`DebutAllumage`),
  ADD KEY `IdJournal` (`IdJournal`);

--
-- Index pour la table `appareil`
--
ALTER TABLE `appareil`
  ADD PRIMARY KEY (`IdAppareil`),
  ADD KEY `IdPiece` (`IdPiece`),
  ADD KEY `IdTypeAppareil` (`IdTypeAppareil`);

--
-- Index pour la table `appart`
--
ALTER TABLE `appart`
  ADD PRIMARY KEY (`IdAppart`),
  ADD KEY `IdSecu` (`IdSecu`),
  ADD KEY `IdTypeAppart` (`IdTypeAppart`),
  ADD KEY `IdMaison` (`IdMaison`);

--
-- Index pour la table `consommer`
--
ALTER TABLE `consommer`
  ADD PRIMARY KEY (`IdAppareil`,`IdRessource`),
  ADD KEY `IdRessource` (`IdRessource`);

--
-- Index pour la table `contenirappareil`
--
ALTER TABLE `contenirappareil`
  ADD PRIMARY KEY (`IdAppart`,`IdAppareil`),
  ADD KEY `IdAppareil` (`IdAppareil`);

--
-- Index pour la table `contenirpiece`
--
ALTER TABLE `contenirpiece`
  ADD PRIMARY KEY (`IdAppart`,`IdPiece`),
  ADD KEY `IdPiece` (`IdPiece`);

--
-- Index pour la table `contenirtypepiece`
--
ALTER TABLE `contenirtypepiece`
  ADD PRIMARY KEY (`IdTypeAppart`,`IdTypePiece`),
  ADD KEY `IdTypePiece` (`IdTypePiece`);

--
-- Index pour la table `dateallumage`
--
ALTER TABLE `dateallumage`
  ADD PRIMARY KEY (`DebutAllumage`);

--
-- Index pour la table `datelocation`
--
ALTER TABLE `datelocation`
  ADD PRIMARY KEY (`DebutLocation`);

--
-- Index pour la table `dateproprio`
--
ALTER TABLE `dateproprio`
  ADD PRIMARY KEY (`DebutPossession`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`NumeroDepartement`),
  ADD KEY `IdRegion` (`IdRegion`);

--
-- Index pour la table `emettre`
--
ALTER TABLE `emettre`
  ADD PRIMARY KEY (`IdAppareil`,`IdSubstance`),
  ADD KEY `IdSubstance` (`IdSubstance`);

--
-- Index pour la table `journal_allumage`
--
ALTER TABLE `journal_allumage`
  ADD PRIMARY KEY (`IdJournal`);

--
-- Index pour la table `louer`
--
ALTER TABLE `louer`
  ADD PRIMARY KEY (`Id_personne`,`DebutLocation`),
  ADD KEY `DebutLocation` (`DebutLocation`),
  ADD KEY `IdAppart` (`IdAppart`);

--
-- Index pour la table `maison`
--
ALTER TABLE `maison`
  ADD PRIMARY KEY (`IdMaison`),
  ADD KEY `IdVille` (`IdVille`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`Id_personne`);

--
-- Index pour la table `piece`
--
ALTER TABLE `piece`
  ADD PRIMARY KEY (`IdPiece`),
  ADD KEY `IdTypePiece` (`IdTypePiece`);

--
-- Index pour la table `propriétaire`
--
ALTER TABLE `propriétaire`
  ADD PRIMARY KEY (`Id_personne`,`DebutPossession`),
  ADD KEY `DebutPossession` (`DebutPossession`),
  ADD KEY `IdMaison` (`IdMaison`);

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`IdRegion`);

--
-- Index pour la table `ressources`
--
ALTER TABLE `ressources`
  ADD PRIMARY KEY (`IdRessource`);

--
-- Index pour la table `securite`
--
ALTER TABLE `securite`
  ADD PRIMARY KEY (`IdSecu`);

--
-- Index pour la table `substances`
--
ALTER TABLE `substances`
  ADD PRIMARY KEY (`IdSubstance`);

--
-- Index pour la table `typeappareil`
--
ALTER TABLE `typeappareil`
  ADD PRIMARY KEY (`IdTypeAppareil`);

--
-- Index pour la table `typeappart`
--
ALTER TABLE `typeappart`
  ADD PRIMARY KEY (`IdTypeAppart`);

--
-- Index pour la table `typepiece`
--
ALTER TABLE `typepiece`
  ADD PRIMARY KEY (`IdTypePiece`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`IdVille`),
  ADD KEY `NumeroDepartement` (`NumeroDepartement`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appareil`
--
ALTER TABLE `appareil`
  MODIFY `IdAppareil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `appart`
--
ALTER TABLE `appart`
  MODIFY `IdAppart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `journal_allumage`
--
ALTER TABLE `journal_allumage`
  MODIFY `IdJournal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `maison`
--
ALTER TABLE `maison`
  MODIFY `IdMaison` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `Id_personne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `piece`
--
ALTER TABLE `piece`
  MODIFY `IdPiece` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `IdRegion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `ressources`
--
ALTER TABLE `ressources`
  MODIFY `IdRessource` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `securite`
--
ALTER TABLE `securite`
  MODIFY `IdSecu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `substances`
--
ALTER TABLE `substances`
  MODIFY `IdSubstance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `typeappareil`
--
ALTER TABLE `typeappareil`
  MODIFY `IdTypeAppareil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `typeappart`
--
ALTER TABLE `typeappart`
  MODIFY `IdTypeAppart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `typepiece`
--
ALTER TABLE `typepiece`
  MODIFY `IdTypePiece` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `IdVille` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
