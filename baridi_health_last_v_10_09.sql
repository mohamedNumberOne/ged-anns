-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 09 oct. 2023 à 16:33
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
  `date_enr` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_arrive` datetime DEFAULT current_timestamp(),
  `id_user` int(5) NOT NULL,
  `txt_cour` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `courriers`
--

INSERT INTO `courriers` (`id_cour`, `ref`, `sujet`, `date_enr`, `date_arrive`, `id_user`, `txt_cour`) VALUES
(43, 'c-1-2023', 'demande aide', '2023-10-09 10:26:31', '2023-10-03 00:00:00', 2, 'salut un aide svp dfdfdddd zrfozuhz fzoufhzof zfo zfozugfzoufg zofugzofuzgv pzi hvzpivhzpvi gzvz ghvpz vgz povugzvozugvzv ^zgvzo ugvzpvmgzv^zg v^zv gz^vz vzv'),
(45, 'c-2-2023', 'sujet 2', '2023-10-09 14:13:48', '2023-10-03 00:00:00', 2, 'messagee');

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
  `traite` tinyint(1) DEFAULT 0,
  `urgent` tinyint(1) DEFAULT 0,
  `confidentiel` tinyint(1) DEFAULT 0,
  `important` tinyint(1) DEFAULT 0,
  `secret` tinyint(1) NOT NULL,
  `vu` tinyint(1) NOT NULL,
  `date_vu` datetime DEFAULT NULL,
  `date_env` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `envoyer`
--

INSERT INTO `envoyer` (`id_env`, `id_cour`, `id_service`, `id_org`, `id_user`, `type`, `traite`, `urgent`, `confidentiel`, `important`, `secret`, `vu`, `date_vu`, `date_env`) VALUES
(19, 43, 4, NULL, 2, 0, 0, 1, 0, 0, 0, 0, NULL, '2023-10-09 10:26:31'),
(20, 45, 6, NULL, 2, 0, 0, 0, 1, 1, 1, 1, '2023-10-12 14:22:26', '2023-10-09 14:13:48');

-- --------------------------------------------------------

--
-- Structure de la table `fichiers_cour`
--

CREATE TABLE `fichiers_cour` (
  `id_fichier_cour` int(6) NOT NULL,
  `id_cour` int(6) DEFAULT NULL,
  `src_fichier_cour` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `fichiers_cour`
--

INSERT INTO `fichiers_cour` (`id_fichier_cour`, `id_cour`, `src_fichier_cour`) VALUES
(6, 43, 'courriers/2023-10-09 10-26-31.png'),
(7, 45, 'courriers/2023-10-09 14-13-48.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `fichiers_rep`
--

CREATE TABLE `fichiers_rep` (
  `id_fichier_rep` int(6) NOT NULL,
  `id_rep` int(6) DEFAULT NULL,
  `src_fichier_rep` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `org_exterieurs`
--

CREATE TABLE `org_exterieurs` (
  `id_org` int(6) NOT NULL,
  `nom_org` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `repenses`
--

CREATE TABLE `repenses` (
  `id_rep` int(6) NOT NULL,
  `id_cour` int(6) DEFAULT NULL,
  `id_user` int(5) DEFAULT NULL,
  `txt_rep` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(3, 'budget', 1),
(4, 'formation', NULL),
(5, 'planification', NULL),
(6, 'prévention', NULL),
(7, 'informatique', NULL);

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
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `nom_user`, `pnom_user`, `email_user`, `ps_user`, `poste_user`, `grade_user`, `id_service`) VALUES
(2, 'nassim', 'pnom ', 'm@gmail.com', '$2y$10$oaPXDVV4XcBMx/Hla7UKeusOVq9RZZ3OkLMqD7.tHgT0f6F37x9/2', 'post', 1, 7);

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
-- Index pour la table `fichiers_cour`
--
ALTER TABLE `fichiers_cour`
  ADD PRIMARY KEY (`id_fichier_cour`),
  ADD KEY `id_cour` (`id_cour`);

--
-- Index pour la table `fichiers_rep`
--
ALTER TABLE `fichiers_rep`
  ADD PRIMARY KEY (`id_fichier_rep`),
  ADD KEY `id_rep` (`id_rep`);

--
-- Index pour la table `org_exterieurs`
--
ALTER TABLE `org_exterieurs`
  ADD PRIMARY KEY (`id_org`);

--
-- Index pour la table `repenses`
--
ALTER TABLE `repenses`
  ADD PRIMARY KEY (`id_rep`),
  ADD KEY `id_cour` (`id_cour`),
  ADD KEY `id_user` (`id_user`);

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
  MODIFY `id_cour` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `envoyer`
--
ALTER TABLE `envoyer`
  MODIFY `id_env` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `fichiers_cour`
--
ALTER TABLE `fichiers_cour`
  MODIFY `id_fichier_cour` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `fichiers_rep`
--
ALTER TABLE `fichiers_rep`
  MODIFY `id_fichier_rep` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `org_exterieurs`
--
ALTER TABLE `org_exterieurs`
  MODIFY `id_org` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `repenses`
--
ALTER TABLE `repenses`
  MODIFY `id_rep` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `services_internes`
--
ALTER TABLE `services_internes`
  MODIFY `id_service` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Contraintes pour la table `fichiers_cour`
--
ALTER TABLE `fichiers_cour`
  ADD CONSTRAINT `fichiers_cour_ibfk_1` FOREIGN KEY (`id_cour`) REFERENCES `courriers` (`id_cour`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fichiers_rep`
--
ALTER TABLE `fichiers_rep`
  ADD CONSTRAINT `fichiers_rep_ibfk_1` FOREIGN KEY (`id_rep`) REFERENCES `repenses` (`id_rep`) ON DELETE CASCADE;

--
-- Contraintes pour la table `repenses`
--
ALTER TABLE `repenses`
  ADD CONSTRAINT `repenses_ibfk_1` FOREIGN KEY (`id_cour`) REFERENCES `courriers` (`id_cour`) ON DELETE CASCADE,
  ADD CONSTRAINT `repenses_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_service`) REFERENCES `services_internes` (`id_service`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
