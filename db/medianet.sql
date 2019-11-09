-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Sam 09 Novembre 2019 à 08:33
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
(1, 'Gringe', 'Wargram'),
(2, 'Berthe Syla', 'Nostalgie Record'),
(3, 'Orelsan, Gringe', 'Wargram');

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
  `updated_at` timestamp NULL NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `documents`
--

INSERT INTO `documents` (`id`, `documentable_id`, `documentable_type`, `nom`, `resume`, `genre`, `disponible`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'medianet\\models\\Livre', 'Les misérables', 'Jean Valjean est un personnage aussi fantastique que Quasimodo. Mais il est fait, lui aussi, de ce beau fantastique des poètes qui part de la réalité, qui l\'exalte, l\'amplifie, la magnifie. Au début, Jean Valjean est un innocent qui a volé un pain et qui ne rencontre pas un président Magnaud pour le sauver du bagne.', 'Roman', 1, '2019-11-08 15:34:26', '2019-11-08 15:34:26', NULL),
(2, 2, 'medianet\\models\\Livre', 'Cherub 1 : 100 jours en enfer', 'James n\'a que 12 ans lorsque sa vie tourne au cauchemar. Placé dans un orphelinat à la mort de sa mère, il glisse vers la délinquance. Il est alors recruté par CHERUB, une mystérieuse organisation gouvernementale.', 'Policier', 1, '2019-11-08 15:35:19', '2019-11-08 15:35:19', NULL),
(3, 3, 'medianet\\models\\Livre', 'Harry potter 1', 'Orphelin, le jeune Harry Potter peut enfin quitter ses tyranniques oncle et tante Dursley lorsqu\'un curieux messager lui révèle qu\'il est un sorcier. À 11 ans, Harry va enfin pouvoir intégrer la légendaire école de sorcellerie de Poudlard, y trouver une famille digne de ce nom et des amis.', 'Fantasy', 1, '2019-11-08 15:36:56', '2019-11-08 15:36:56', NULL),
(4, 1, 'medianet\\models\\CD', 'Enfant Lune', 'Enfant lune est le premier album studio solo du rappeur français Gringe, produit par Wagram Music. Originellement prévu pour le 19 octobre', 'Rap', 1, '2019-11-08 15:37:36', '2019-11-08 15:37:36', NULL),
(5, 2, 'medianet\\models\\CD', 'Le Lilas blanc', 'Elle naquit par un dimanche Du plus joli des mois de mai Quand le printemps à chaque branche ', 'Dramatique', 0, '2019-11-08 15:38:59', '2019-11-08 15:46:38', NULL),
(6, 3, 'medianet\\models\\CD', 'Casseur Flowter', 'Casseurs Flowters est un groupe de hip-hop français, originaire de Caen, dans le Calvados. Formé par Orelsan et Gringe.', 'hip hop', 1, '2019-11-08 15:39:52', '2019-11-08 15:48:09', NULL),
(7, 1, 'medianet\\models\\DVD', 'Rocky', 'Rocky est une série cinématographique écrite par Sylvester Stallone, dont il incarne le personnage principal.', 'Drame', 1, '2019-11-08 15:40:26', '2019-11-08 15:48:09', NULL),
(8, 2, 'medianet\\models\\DVD', 'Rocky 2', 'Rocky 2 : La Revanche (Rocky II) est un film américain écrit et réalisé par Sylvester Stallone, sorti en 1979.', 'Drame', 1, '2019-11-08 15:41:13', '2019-11-08 15:41:13', NULL),
(9, 3, 'medianet\\models\\DVD', 'Rocky 3', 'Rocky 3 : L\'Œil du tigre (Rocky III) est un film américain, écrit et réalisé par Sylvester Stallone, sorti en 1982. C\'est le troisième opus de la saga Rocky.', 'Drame', 1, '2019-11-08 15:42:09', '2019-11-08 15:42:09', NULL),
(10, 4, 'medianet\\models\\DVD', 'L\'étalon Italien', 'L\'Étalon italien est un film érotique réalisé par Morton Lewis en 1970. C\'est le premier film de Sylvester Stallone.', 'Erotique', -1, '2019-11-08 15:43:19', '2019-11-08 15:43:59', NULL);

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
(1, 'Silverster Stallone', 119),
(2, 'Silverster Stallone', 121),
(3, 'Silverster Stallone', 123),
(4, 'Silverster Stallone', 61);

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
(1, 5, '2019-11-08 15:46:38', '2019-11-22 15:46:38', NULL, 2),
(2, 6, '2019-11-08 15:47:15', '2019-11-22 15:47:15', '2019-11-08 15:47:43', 2),
(3, 6, '2019-11-08 15:47:58', '2019-11-22 15:47:58', '2019-11-08 15:48:09', 2),
(4, 7, '2019-11-08 15:47:58', '2019-11-22 15:47:58', '2019-11-08 15:48:09', 2);

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
(1, 'Victor Hugo', 'Livre de poche'),
(2, 'Robert Muchamore', 'Cherub'),
(3, 'J-K Rowling', 'HP');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `emprunt_id` int(11) DEFAULT NULL,
  `date_reservation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_limite` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `document_id`, `emprunt_id`, `date_reservation`, `date_limite`) VALUES
(1, 1, 10, NULL, '2019-11-08 15:43:59', '2019-11-15 15:43:59');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `telephone` varchar(256) DEFAULT NULL,
  `demande_adhesion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `mdp`, `email`, `adresse`, `adhesion`, `created_at`, `updated_at`, `deleted_at`, `telephone`, `demande_adhesion`) VALUES
(1, 'Felix', 'Léo', '$2y$10$Lj5lGTLhf2xAC0WAh4VVIuO32HeCR42khu/lq5EasPr7Q8I3RI.IG', 'leofelixoff@outlook.fr', '2B rue braconnot', '2019-11-12 15:29:12', '2019-11-08 15:29:12', '2019-11-08 15:29:12', NULL, '0662287945', NULL),
(2, 'Pinot', 'Antoine', '$2y$10$e77XomZ6gWGoOP5JG8yBCeN5tSVhUpDlmxL0VDYB8OYkaWMCHif1e', 'antoine.pinot1@gmail.com', '21rue aristide briand 54520 laxou', '2019-11-25 15:31:25', '2019-11-08 15:31:25', '2019-11-08 15:31:25', NULL, '0780408131', NULL),
(3, 'Praga', 'Yvain', '$2y$10$u1yXpn/MSiCxIHZAvIByxuQNK0wKP7HIpEEuEm6R8QdDTMvpDank2', 'praga.yvain@gmail.com', '2 rue des gentilles', '2019-11-06 15:32:06', '2019-11-08 15:32:06', '2019-11-08 15:32:06', NULL, '09000000', NULL),
(4, 'Dal ponte', 'Simon', '$2y$10$671ULj6u2.hqjopZFDh92u3oMng1SJhkvTNgxsqTUgU/E.NnzDJG6', 'simon.dalponte@gmail.com', '768 rue des Zinzins', '2019-11-08 15:33:26', '2019-11-08 15:33:26', '2019-11-08 15:33:26', NULL, '06000000', NULL),
(5, 'Canals', 'Gérome', '$2y$10$D5MFt.bNHg5cfMYWXszGk.RwqUDfa9nWb9vqMB2wu6BIPzG0xv4Ji', 'canals.gerome@gmail.com', 'Introuvable', NULL, '2019-11-08 15:50:07', '2019-11-08 15:50:07', NULL, '9999999', '2019-11-08 15:50:07'),
(6, 'Baumont', 'Loic', '$2y$10$yaL78K1/fxKmn6dHesTfE.llKR4SMvQTqgL3baWalKK4KSASHeDRS', 'loic.baumont@gmail.com', 'introuvable', NULL, '2019-11-08 15:51:00', '2019-11-08 15:51:00', NULL, '999999', '2019-11-08 15:51:00'),
(7, 'Doe', 'John', '$2y$10$/IqgWXSN2WsUxC8s8sJn.ecEUkT7xX/M8fdZCQA7R3tP7uMq4RsQi', 'john.doe@gmail.com', 'adresse de john doe', '2019-11-09 07:32:55', '2019-11-09 07:32:55', '2019-11-09 07:32:55', NULL, '0606060606', NULL);

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
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `dvds`
--
ALTER TABLE `dvds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `emprunts`
--
ALTER TABLE `emprunts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
