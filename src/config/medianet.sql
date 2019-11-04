-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Lun 04 Novembre 2019 à 13:40
-- Version du serveur :  5.7.27-0ubuntu0.18.04.1
-- Version de PHP :  7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `medianet`
--

-- --------------------------------------------------------

--
-- Structure de la table `CD`
--

CREATE TABLE `CD` (
  `id_cd` int(11) NOT NULL,
  `artistes` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `maison_disque` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Document`
--

CREATE TABLE `Document` (
  `id_doc` int(11) NOT NULL,
  `nom_doc` int(20) NOT NULL,
  `resume_doc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `genre_doc` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dispo_doc` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `DVD`
--

CREATE TABLE `DVD` (
  `id_dvd` int(11) NOT NULL,
  `acteurs` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `duree_dvd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Emprunt`
--

CREATE TABLE `Emprunt` (
  `id_emprunt` int(11) NOT NULL,
  `tmp_pris` date NOT NULL,
  `tmp_retour` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Livre`
--

CREATE TABLE `Livre` (
  `id_livre` int(11) NOT NULL,
  `auteur` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `edition` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `id_user` int(11) NOT NULL,
  `nom_user` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email_user` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mdp_user` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `adresse_user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tel_user` int(10) NOT NULL,
  `adhesion_user` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `CD`
--
ALTER TABLE `CD`
  ADD PRIMARY KEY (`id_cd`);

--
-- Index pour la table `Document`
--
ALTER TABLE `Document`
  ADD PRIMARY KEY (`id_doc`);

--
-- Index pour la table `DVD`
--
ALTER TABLE `DVD`
  ADD PRIMARY KEY (`id_dvd`);

--
-- Index pour la table `Emprunt`
--
ALTER TABLE `Emprunt`
  ADD PRIMARY KEY (`id_emprunt`);

--
-- Index pour la table `Livre`
--
ALTER TABLE `Livre`
  ADD PRIMARY KEY (`id_livre`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `CD`
--
ALTER TABLE `CD`
  MODIFY `id_cd` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Document`
--
ALTER TABLE `Document`
  MODIFY `id_doc` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `DVD`
--
ALTER TABLE `DVD`
  MODIFY `id_dvd` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Emprunt`
--
ALTER TABLE `Emprunt`
  MODIFY `id_emprunt` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Livre`
--
ALTER TABLE `Livre`
  MODIFY `id_livre` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
