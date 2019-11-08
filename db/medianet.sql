-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Ven 08 Novembre 2019 à 08:41
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
-- Structure de la table `cds`
--

CREATE TABLE `cds` (
  `id` int(11) NOT NULL,
  `artistes` varchar(255) NOT NULL,
  `maison_disque` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `cds`
--

INSERT INTO `cds` (`id`, `artistes`, `maison_disque`) VALUES
(1, 'Gringe', 'disney'),
(2, 'Jean michel patoche', 'les zinzins\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `documentable_id` int(11) NOT NULL,
  `documentable_type` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `resume` text NOT NULL,
  `genre` varchar(255) NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `documents`
--

INSERT INTO `documents` (`id`, `documentable_id`, `documentable_type`, `nom`, `resume`, `genre`, `disponible`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'medianet\\models\\CD', 'aaaaaaaaaaaaaaa', 'aaaaa', 'aaaa', 1, '2019-11-05 13:12:36', '2019-11-07 14:10:55', NULL),
(2, 2, 'medianet\\models\\CD', 'le petit bonhome en mousse', 'oh non pas encore', 'payarde', 1, '2019-11-05 13:13:44', '2019-11-07 14:10:55', NULL),
(3, 1, 'medianet\\models\\DVD', 'Rocky', 'pas besoin de resume', 'Drame', 0, '2019-11-05 13:16:17', '2019-11-07 14:10:47', NULL),
(4, 2, 'medianet\\models\\DVD', 'Rocky 2', 'ah ouais', 'drame', 1, '2019-11-05 13:17:01', '2019-11-07 12:58:50', NULL),
(5, 1, 'medianet\\models\\Livre', '100 jours en enfer', 'pauvre gamin', 'policier', 1, '2019-11-05 13:19:22', '2019-11-05 13:19:22', NULL),
(6, 2, 'medianet\\models\\Livre', 'trafic oh oui', 'oh la la pas bien', 'policer', 1, '2019-11-05 13:20:27', '2019-11-07 09:16:46', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `dvds`
--

CREATE TABLE `dvds` (
  `id` int(11) NOT NULL,
  `acteurs` varchar(255) NOT NULL,
  `duree` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dvds`
--

INSERT INTO `dvds` (`id`, `acteurs`, `duree`) VALUES
(1, 'Stallone', 119),
(2, 'Stallone', 121);

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

CREATE TABLE `emprunts` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `date_emprunt` timestamp NULL DEFAULT NULL,
  `date_limite` timestamp NULL DEFAULT NULL,
  `date_retour` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `emprunts`
--

INSERT INTO `emprunts` (`id`, `document_id`, `date_emprunt`, `date_limite`, `date_retour`, `user_id`) VALUES
(1, 3, '2019-11-07 12:49:12', '2019-11-21 12:49:12', '2019-11-07 12:49:48', 1),
(2, 3, '2019-11-07 12:58:17', '2019-11-21 12:58:17', '2019-11-07 12:58:34', 1),
(3, 4, '2019-11-07 12:58:27', '2019-11-21 12:58:27', '2019-11-07 12:58:50', 1),
(4, 1, '2019-11-07 13:56:54', '2019-11-21 13:56:54', '2019-11-07 13:57:33', 1),
(5, 1, '2019-11-07 13:57:58', '2019-11-21 13:57:58', '2019-11-07 13:58:58', 1),
(6, 1, '2019-11-07 13:59:36', '2019-11-21 13:59:36', '2019-11-07 14:00:18', 1),
(7, 1, '2019-11-07 14:00:36', '2019-11-21 14:00:36', '2019-11-07 14:00:55', 1),
(8, 1, '2019-11-07 14:01:41', '2019-11-21 14:01:41', '2019-11-07 14:01:45', 1),
(9, 1, '2019-11-07 14:02:38', '2019-11-21 14:02:38', '2019-11-07 14:02:53', 1),
(10, 1, '2019-11-07 14:03:30', '2019-11-21 14:03:30', '2019-11-07 14:03:36', 1),
(11, 1, '2019-11-07 14:04:18', '2019-11-21 14:04:18', '2019-11-07 14:05:51', 1),
(12, 1, '2019-11-07 14:08:39', '2019-11-21 14:08:39', '2019-11-07 14:08:44', 1),
(13, 1, '2019-11-07 14:10:12', '2019-11-21 14:10:12', '2019-11-07 14:10:37', 1),
(14, 1, '2019-11-07 14:10:47', '2019-11-21 14:10:47', '2019-11-07 14:10:55', 1),
(15, 2, '2019-11-07 14:10:47', '2019-11-21 14:10:47', '2019-11-07 14:10:55', 1),
(16, 3, '2019-11-07 14:10:47', '2019-11-21 14:10:47', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

CREATE TABLE `livres` (
  `id` int(11) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `edition` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `livres`
--

INSERT INTO `livres` (`id`, `auteur`, `edition`) VALUES
(1, 'Robert Muchamore', 'platine'),
(2, 'Robert Muchamore', 'platine');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `date_debut` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_limite` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `adhesion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `telephone` varchar(256) DEFAULT NULL,
  `demande_adhesion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `mdp`, `email`, `adresse`, `adhesion`, `created_at`, `updated_at`, `deleted_at`, `telephone`, `demande_adhesion`) VALUES
(1, 'FELIX', 'FELIX', '$2y$10$m2iYWnDClXkVlOxDvdCNxeigyKXAAIu77eNlnAuMS6lwGLJ6.sYom', 'felix@gmail.com', '2 b rue capucin', '2019-11-01 23:00:00', '2019-11-07 12:46:10', '2019-11-07 12:46:10', NULL, '666', NULL),
(2, 'leo', 'leo', '$2y$10$m2iYWnDClXkVlOxDvdCNxeigyKXAAIu77eNlnAuMS6lwGLJ6.sYom', 'leo@gmail.com', 'Chez moi', '2019-10-31 23:00:00', '2019-11-07 12:46:54', '2019-11-07 12:46:54', NULL, '999', NULL),
(7, 'test', 'test', '$2y$10$HFsOaQJksoXvQbQ5d/8Z4O8kGZZcKd7nGmp55YMJbpEYtQ1KFuvH.', 'test@gmail.com', 'test', '2019-11-07 13:42:34', '2019-11-07 13:42:19', '2019-11-07 13:42:34', NULL, '33', NULL),
(8, 'test', 'test', '$2y$10$il3IlRz1QP/myoumIi.Lfe749hX67wYkOCruvgH9uwkRvY5O.lHuO', 'ohlala@gmail.com', 'test', NULL, '2019-11-07 14:12:05', '2019-11-07 14:12:05', NULL, '888', '2019-11-07 14:12:05');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `cds`
--
ALTER TABLE `cds`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dvds`
--
ALTER TABLE `dvds`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `livres`
--
ALTER TABLE `livres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `cds`
--
ALTER TABLE `cds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `dvds`
--
ALTER TABLE `dvds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `emprunts`
--
ALTER TABLE `emprunts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
