-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Jeu 07 Novembre 2019 à 08:58
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
(1, 'Gringe', 'Wagram Music'),
(2, 'Jean michel patoche', 'les zinzins\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `reference` varchar(256) DEFAULT NULL,
  `documentable_id` int(11) NOT NULL,
  `documentable_type` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `resume` text NOT NULL,
  `genre` varchar(255) NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `documents`
--

INSERT INTO `documents` (`id`, `reference`, `documentable_id`, `documentable_type`, `nom`, `resume`, `genre`, `disponible`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1245', 1, 'medianet\\models\\CD', 'Enfante lune', 'resume', 'rap', 1, '2019-11-05 13:12:36', '2019-11-05 13:12:36', NULL),
(2, '7643', 2, 'medianet\\models\\CD', 'le petit bonhome en mousse', 'oh non pas encore', 'payarde', 0, '2019-11-05 13:13:44', '2019-11-05 13:13:44', NULL),
(3, '8763', 1, 'medianet\\models\\DVD', 'Rocky', 'pas besoin de resume', 'Drame', 0, '2019-11-05 13:16:17', '2019-11-05 13:16:17', NULL),
(4, '7544', 2, 'medianet\\models\\DVD', 'Rocky 2', 'ah ouais', 'drame', 1, '2019-11-05 13:17:01', '2019-11-05 13:17:01', NULL),
(5, '4433', 1, 'medianet\\models\\Livre', '100 jours en enfer', 'pauvre gamin', 'policier', 1, '2019-11-05 13:19:22', '2019-11-05 13:19:22', NULL),
(6, '6545', 2, 'medianet\\models\\Livre', 'trafic', 'oh la la pas bien', 'policer', 1, '2019-11-05 13:20:27', '2019-11-05 13:20:27', NULL);

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
(1, 2, NULL, '2019-11-29 23:00:00', NULL, 1),
(2, 3, NULL, '2019-11-29 23:00:00', NULL, 1);

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
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `adhesion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `telephone` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `mdp`, `email`, `adresse`, `photo`, `adhesion`, `created_at`, `updated_at`, `deleted_at`, `telephone`) VALUES
(1, 'felix', 'leo', '$2y$10$nJYOe3fSP4XfoCx1EbG8u.hqoOPBYv9HKc82wJgAtBaDHKcL3nC8e', 'leofelix@gmail.com', '2 B rue capucins', 'zinzin', NULL, '2019-11-05 09:17:00', '2019-11-05 14:49:04', NULL, '44466'),
(2, 'test', 'test', '$2y$10$ETMqipzJc0bojpj8cHzqqOiD8JlcttOPPoK6bct2YDyuimzMRI2te', 'test@gmail.com', 'test', 'zinzin', '2019-11-06 23:00:00', '2019-11-05 13:24:53', '2019-11-05 14:21:48', NULL, '0');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
