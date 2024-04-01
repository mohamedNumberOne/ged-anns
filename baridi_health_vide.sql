-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 23 août 2023 à 17:03
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `baridi_health`
--

-- --------------------------------------------------------

--
-- Structure de la table `courriers`
--

CREATE TABLE `courriers` (
  `id_cour` int(6) NOT NULL,
  `ref` varchar(30) DEFAULT NULL,
  `sujet` varchar(250) DEFAULT NULL,
  `src_fichier` varchar(250) DEFAULT NULL,
  `traite` tinyint(1) DEFAULT 0,
  `date_enr` date DEFAULT current_timestamp(),
  `id_user` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `envoyer`
--

CREATE TABLE `envoyer` (
  `id_env` int(6) NOT NULL,
  `id_cour` int(6) DEFAULT NULL,
  `id_service` smallint(3) DEFAULT NULL,
  `id_org` int(6) DEFAULT NULL,
  `id_user` int(5) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `date_env` date DEFAULT NULL,
  `confidentiel` tinyint(4) NOT NULL,
  `urgent` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `org_exterieurs`
--

CREATE TABLE `org_exterieurs` (
  `id_org` int(6) NOT NULL,
  `nom_org` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `org_exterieurs`
--

INSERT INTO `org_exterieurs` (`id_org`, `nom_org`) VALUES
(1, 'ministère des finances'),
(2, 'ministère du commerce'),
(3, 'ministère des affaires étrangères ');

-- --------------------------------------------------------

--
-- Structure de la table `services_internes`
--

CREATE TABLE `services_internes` (
  `id_service` smallint(3) NOT NULL,
  `nom_service` varchar(250) DEFAULT NULL,
  `grade_service` smallint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `services_internes`
--

INSERT INTO `services_internes` (`id_service`, `nom_service`, `grade_service`) VALUES
(1, 'réglementation ', NULL),
(2, 'budget ', NULL),
(3, 'planification', NULL),
(4, 'les marchés !=', NULL),
(5, 'Secrétariat générale ( SG )', NULL),
(6, 'inspection ', NULL),
(7, 'chef cabinet ', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(5) NOT NULL,
  `nom_user` varchar(100) DEFAULT NULL,
  `pnom_user` varchar(100) DEFAULT NULL,
  `email_user` varchar(100) DEFAULT NULL,
  `ps_user` varchar(150) DEFAULT NULL,
  `poste_user` varchar(150) DEFAULT NULL,
  `grade_user` smallint(2) DEFAULT NULL,
  `id_service` smallint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `courriers`
--
ALTER TABLE `courriers`
  ADD PRIMARY KEY (`id_cour`),
  ADD UNIQUE KEY `ref` (`ref`),
  ADD UNIQUE KEY `sujet` (`sujet`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `envoyer`
--
ALTER TABLE `envoyer`
  ADD PRIMARY KEY (`id_env`),
  ADD KEY `id_cour` (`id_cour`),
  ADD KEY `id_service` (`id_service`),
  ADD KEY `id_org` (`id_org`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `org_exterieurs`
--
ALTER TABLE `org_exterieurs`
  ADD PRIMARY KEY (`id_org`);

--
-- Index pour la table `services_internes`
--
ALTER TABLE `services_internes`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email_user` (`email_user`),
  ADD KEY `id_service` (`id_service`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `courriers`
--
ALTER TABLE `courriers`
  MODIFY `id_cour` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `envoyer`
--
ALTER TABLE `envoyer`
  MODIFY `id_env` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `org_exterieurs`
--
ALTER TABLE `org_exterieurs`
  MODIFY `id_org` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `services_internes`
--
ALTER TABLE `services_internes`
  MODIFY `id_service` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `courriers`
--
ALTER TABLE `courriers`
  ADD CONSTRAINT `courriers_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `envoyer`
--
ALTER TABLE `envoyer`
  ADD CONSTRAINT `envoyer_ibfk_1` FOREIGN KEY (`id_cour`) REFERENCES `courriers` (`id_cour`) ON DELETE CASCADE,
  ADD CONSTRAINT `envoyer_ibfk_2` FOREIGN KEY (`id_service`) REFERENCES `services_internes` (`id_service`) ON DELETE CASCADE,
  ADD CONSTRAINT `envoyer_ibfk_3` FOREIGN KEY (`id_org`) REFERENCES `org_exterieurs` (`id_org`) ON DELETE CASCADE,
  ADD CONSTRAINT `envoyer_ibfk_4` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_service`) REFERENCES `services_internes` (`id_service`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
