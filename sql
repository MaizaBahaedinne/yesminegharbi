-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : dim. 07 juin 2026 à 23:28
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ygbd`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sujet` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id` int(11) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_courte` text DEFAULT NULL,
  `description_longue` longtext DEFAULT NULL,
  `objectifs` text DEFAULT NULL,
  `prerequis` text DEFAULT NULL,
  `prix` decimal(8,3) DEFAULT 0.000,
  `niveau` enum('junior','experimente','tous') DEFAULT 'tous',
  `theme` enum('cv','entretien','recrutement','branding') DEFAULT 'cv',
  `statut` enum('disponible','bientot','archive') DEFAULT 'bientot',
  `modules_count` tinyint(4) DEFAULT 0,
  `heures` varchar(20) DEFAULT '',
  `cover_image` varchar(255) DEFAULT NULL,
  `is_populaire` tinyint(1) DEFAULT 0,
  `has_certificate` tinyint(1) NOT NULL DEFAULT 0,
  `has_quiz` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` smallint(6) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id`, `slug`, `titre`, `description_courte`, `description_longue`, `objectifs`, `prerequis`, `prix`, `niveau`, `theme`, `statut`, `modules_count`, `heures`, `cover_image`, `is_populaire`, `has_certificate`, `has_quiz`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'cv-parfait-decrocher-entretien', 'CV Parfait : décrocher un entretien en 7 jours', 'Créez un CV ATS-friendly, percutant et adapté au marché tunisien et francophone.', 'Créez un CV optimisé pour les systèmes de suivi des candidatures (ATS), clair, structuré et percutant, en mettant en valeur les compétences et les expériences de manière stratégique. Le CV doit être parfaitement adapté aux standards du marché tunisien et francophone, en utilisant un langage professionnel, des mots-clés pertinents et une présentation moderne qui facilite la lecture à la fois par les recruteurs et par les logiciels de tri automatique.', '', '', 149.000, 'junior', 'cv', 'disponible', 7, '4h 30min', NULL, 0, 1, 1, 1, '2026-06-07 17:28:49', '2026-06-07 17:59:39'),
(2, 'maitriser-entretien-recrutement', 'Maitriser l\'entretien de recrutement', 'Préparez chaque type d’entretien : RH, technique, mise en situation et négociation de salaire.', 'Préparez de manière complète et structurée chaque type d’entretien professionnel, incluant les entretiens RH, les entretiens techniques, les mises en situation ainsi que les phases de négociation salariale. L’objectif est de développer des réponses claires, pertinentes et adaptées à chaque contexte, tout en renforçant la confiance, la communication et la capacité à valoriser ses compétences face aux recruteurs.', NULL, NULL, 199.000, 'junior', 'entretien', 'disponible', 8, '6h', NULL, 1, 0, 0, 2, '2026-06-07 17:28:49', '2026-06-07 17:17:52'),
(3, 'linkedin-pro-visibilite-opportunites', 'LinkedIn Pro : visibilité et opportunités', 'Transformez votre profil LinkedIn en machine à opportunités professionnelles.', 'Optimisez et transformez votre profil LinkedIn en un véritable levier de visibilité et de génération d’opportunités professionnelles. L’objectif est de structurer votre profil de manière stratégique afin d’attirer l’attention des recruteurs, des entreprises et des partenaires potentiels, tout en mettant en valeur votre expertise, vos compétences et votre parcours. Cela inclut l’amélioration du titre professionnel, la rédaction d’un résumé impactant, l’optimisation des expériences, ainsi que l’utilisation de mots-clés pertinents pour maximiser votre visibilité dans les recherches LinkedIn.', NULL, NULL, 149.000, 'junior', 'recrutement', 'bientot', 5, '3h', NULL, 0, 0, 0, 3, '2026-06-07 17:28:49', '2026-06-07 17:18:19');

-- --------------------------------------------------------

--
-- Structure de la table `lecons`
--

CREATE TABLE `lecons` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `video_url` varchar(512) DEFAULT NULL,
  `duree` smallint(6) DEFAULT 0,
  `type` enum('video','quiz','document','texte') NOT NULL DEFAULT 'video',
  `is_free` tinyint(1) NOT NULL DEFAULT 0,
  `position` smallint(6) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lecons`
--

INSERT INTO `lecons` (`id`, `module_id`, `titre`, `video_url`, `duree`, `type`, `is_free`, `position`, `created_at`, `updated_at`) VALUES
(2, 3, 'Les 5 erreurs fatales des candidats tunisiens', '', 10, 'video', 1, 1, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(3, 3, 'Ce que les recruteurs regardent en 6 secondes', '', 8, 'video', 1, 2, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(4, 3, 'Les 3 types de CV : lequel vous correspond ?', '', 12, 'video', 0, 3, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(5, 4, 'Comment fonctionne un logiciel ATS', '', 15, 'video', 0, 1, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(6, 4, 'Les mots-clés qui font passer votre CV au filtre', '', 18, 'video', 0, 2, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(7, 4, 'Tester votre CV avec un outil en ligne', '', 5, 'document', 0, 3, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(8, 5, 'Format chronologique, fonctionnel ou combiné', '', 12, 'video', 0, 1, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(9, 5, 'L\'en-tête : photo, contact et infos clés', '', 10, 'video', 0, 2, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(10, 5, 'Rédiger une accroche professionnelle percutante', '', 15, 'video', 1, 3, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(11, 6, 'La section Expériences — méthode STAR', '', 20, 'video', 0, 1, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(12, 6, 'Formations, certifications et diplômes', '', 10, 'video', 0, 2, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(13, 6, 'Compétences, langues et outils numériques', '', 12, 'video', 0, 3, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(14, 6, 'Centres d\'intérêt : quoi mettre (et quoi éviter)', '', 7, 'texte', 0, 4, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(15, 7, 'Analyser une offre d\'emploi en profondeur', '', 10, 'video', 0, 1, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(16, 7, 'Personnaliser votre CV en moins de 15 minutes', '', 15, 'video', 0, 2, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(17, 7, 'Exercice pratique — Adapte ton CV à une offre', '', 20, 'document', 0, 3, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(18, 8, 'Choisir un design professionnel adapté à votre secteur', '', 8, 'video', 0, 1, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(19, 8, 'Canva, Word, Notion : les meilleurs outils gratuits', '', 12, 'video', 1, 2, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(20, 8, 'Checklist finale avant d\'envoyer votre CV', '', 5, 'document', 0, 3, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(21, 9, 'Quiz final — testez vos acquis', '', 15, 'quiz', 0, 1, '2026-06-07 19:10:46', '2026-06-07 19:10:46');

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `formation_id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `position` smallint(6) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `modules`
--

INSERT INTO `modules` (`id`, `formation_id`, `titre`, `description`, `position`, `created_at`, `updated_at`) VALUES
(3, 1, 'Introduction : Pourquoi votre CV ne fonctionne pas', '', 1, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(4, 1, 'Comprendre les ATS (logiciels de tri automatique)', '', 2, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(5, 1, 'Structure et mise en page professionnelle', '', 3, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(6, 1, 'Rédiger chaque section avec impact', '', 4, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(7, 1, 'Adapter votre CV à chaque offre d\'emploi', '', 5, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(8, 1, 'Design, outils et checklist finale', '', 6, '2026-06-07 19:10:46', '2026-06-07 19:10:46'),
(9, 1, 'Évaluation et certificat', '', 7, '2026-06-07 19:10:46', '2026-06-07 19:10:46');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `prenom` varchar(80) DEFAULT '',
  `tag` varchar(100) DEFAULT 'newsletter',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ressources`
--

CREATE TABLE `ressources` (
  `id` int(11) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_courte` text DEFAULT NULL,
  `description_longue` longtext DEFAULT NULL,
  `type` enum('guide','template','checklist','ebook','kit') DEFAULT 'guide',
  `profil` enum('junior','experimente','recruteur','tous') DEFAULT 'tous',
  `prix` decimal(8,3) DEFAULT 0.000,
  `fichier_path` varchar(512) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `is_premium` tinyint(1) DEFAULT 0,
  `tag_badge` enum('gratuit','premium','nouveau','populaire') DEFAULT 'gratuit',
  `sort_order` smallint(6) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ressources`
--

INSERT INTO `ressources` (`id`, `slug`, `titre`, `description_courte`, `description_longue`, `type`, `profil`, `prix`, `fichier_path`, `cover_image`, `is_premium`, `tag_badge`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'checklist-entretien', 'Checklist entretien', '50 points clés à vérifier avant, pendant et après votre entretien.', 'Découvrez une liste complète de 50 points clés essentiels à vérifier et à maîtriser avant, pendant et après un entretien d’embauche. Cette checklist structurée vous aide à vous préparer efficacement, à adopter la bonne posture le jour J et à assurer un suivi professionnel après l’entretien. Elle couvre aussi bien la préparation du CV et des réponses aux questions fréquentes, que la communication non verbale, la gestion du stress, la qualité des échanges avec le recruteur, ainsi que les actions à mener après l’entretien pour maximiser vos chances de succès et laisser une impression positive et durable.', 'checklist', 'tous', 0.000, '', NULL, 0, 'gratuit', 1, '2026-06-07 17:28:49', '2026-06-07 17:21:10'),
(2, 'template-lettre-motivation', 'Template lettre de motivation', 'Modèle de lettre de motivation éditable, adapté au marché tunisien.', 'Accédez à un modèle de lettre de motivation entièrement éditable, conçu pour s’adapter aux exigences du marché tunisien. Ce modèle est structuré de manière professionnelle afin de mettre en valeur votre parcours, vos compétences et votre motivation de façon claire et percutante. Il peut être facilement personnalisé selon le poste visé, le secteur d’activité et le niveau d’expérience, tout en respectant les standards attendus par les recruteurs en Tunisie. L’objectif est de vous aider à rédiger une lettre convaincante, cohérente et adaptée aux pratiques de recrutement locales.', 'template', 'junior', 0.000, '', NULL, 0, 'gratuit', 2, '2026-06-07 17:28:49', '2026-06-07 17:21:35'),
(3, '10-erreurs-cv-a-eviter', 'Les 10 erreurs CV à éviter', 'Les 10 erreurs qui font rejeter votre CV dès les premières secondes.', 'Découvrez les 10 erreurs les plus fréquentes qui peuvent entraîner le rejet immédiat de votre CV dès les premières secondes de lecture par un recruteur. Ces erreurs concernent aussi bien la forme que le fond : présentation peu claire, fautes d’orthographe, manque de structure, absence de mots-clés pertinents, informations inutiles ou encore mauvaise adaptation au poste visé. L’objectif est de comprendre ces pièges courants afin d’optimiser votre CV, capter rapidement l’attention des recruteurs et augmenter significativement vos chances d’être retenu pour un entretien.', 'ebook', 'tous', 0.000, '', NULL, 0, 'gratuit', 3, '2026-06-07 17:28:49', '2026-06-07 17:22:21'),
(4, 'kit-candidat-complet', 'Kit candidat complet', 'CV + Lettre de motivation + Checklist entretien. Tout pour rÚussir votre candidature.', NULL, 'kit', 'junior', 49.000, NULL, NULL, 1, 'populaire', 4, '2026-06-07 17:28:49', '2026-06-07 17:28:49'),
(5, 'guide-salaires-tunisie-2026', 'Guide salaires Tunisie 2026', 'Grille complÞte par secteur et niveau pour nÚgocier votre salaire.', NULL, 'guide', 'tous', 29.000, NULL, NULL, 1, 'nouveau', 5, '2026-06-07 17:28:49', '2026-06-07 17:28:49'),
(6, 'kit-recruteur-professionnel', 'Kit recruteur professionnel', 'Scripts d\'entretien, grilles d\'Úvaluation et templates de fiches de poste.', NULL, 'kit', 'recruteur', 79.000, NULL, NULL, 1, 'premium', 6, '2026-06-07 17:28:49', '2026-06-07 17:28:49'),
(7, 'template-cv-ats', 'Template CV ATS', 'Template Word + PDF optimisÚ pour les systÞmes ATS. Compatible tous secteurs.', NULL, 'template', 'tous', 19.000, NULL, NULL, 1, 'premium', 7, '2026-06-07 17:28:49', '2026-06-07 17:28:49');

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES
('email', 'hello@yesminegharbi.com', '2026-06-07 21:25:42'),
('facebook_followers', '47K', '2026-06-07 21:25:42'),
('facebook_url', 'https://www.facebook.com/yesmineegharbi', '2026-06-07 21:25:42'),
('instagram_followers', '78K', '2026-06-07 21:25:42'),
('instagram_url', 'https://www.instagram.com/yesmine_gharbi/', '2026-06-07 21:25:42'),
('linkedin_followers', '', '2026-06-07 21:25:42'),
('linkedin_url', 'https://www.linkedin.com/in/yesmine-gharbi-recrutement/', '2026-06-07 21:25:42'),
('tiktok_followers', '53K', '2026-06-07 21:25:42'),
('tiktok_url', 'https://www.tiktok.com/@yesmine_gharbi', '2026-06-07 21:25:42');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Index pour la table `lecons`
--
ALTER TABLE `lecons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formation_id` (`formation_id`);

--
-- Index pour la table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `ressources`
--
ALTER TABLE `ressources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`key`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `lecons`
--
ALTER TABLE `lecons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ressources`
--
ALTER TABLE `ressources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lecons`
--
ALTER TABLE `lecons`
  ADD CONSTRAINT `lecons_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
