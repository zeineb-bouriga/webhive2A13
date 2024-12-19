-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 19 déc. 2024 à 01:49
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `webhive`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `articlePicture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `reactA` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `description`, `articlePicture`, `created_at`, `reactA`) VALUES
(1, 'azeazeazeaze', 'sazeazesazeazesazeazesazeazesazeazesazeazesazeazesazeazesazeaze', 'cropped-favicon-32x32.png', '2024-11-13 22:40:40', NULL),
(2, 'znlnalze', 'sazeazesazeazesazeazesazeazesazeazesazeazesazeazesazeazesazeazesazeazesazeaze', 'chouu-removebg-preview (1)-fotor-bg-remover-20240610141458.png', '2024-11-26 23:07:34', NULL),
(5, 'Here is a title ', 'Here is a title Here is a title Here is a title Here is a title Here is a title Here is a title ', '3.png', '2024-12-10 19:52:42', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `commentContent` text NOT NULL,
  `author` int(11) NOT NULL,
  `creationDate` datetime NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`commentID`, `topicID`, `commentContent`, `author`, `creationDate`, `status`) VALUES
(10, 8, 'chkounou lwachka hedha ', 1, '2024-11-27 09:28:53', 'active'),
(13, 11, 'ks;szc;c;zzlz', 1, '2024-12-04 09:55:25', 'active'),
(14, 12, 'gjghkjhk', 1, '2024-12-07 17:23:11', 'active'),
(16, 14, 'kuhxa', 1, '2024-12-11 09:33:57', 'active'),
(17, 15, 'poiuyhgfd', 1, '2024-12-17 11:39:27', 'active');

-- --------------------------------------------------------

--
-- Structure de la table `commentsa`
--

CREATE TABLE `commentsa` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 1,
  `comment_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `reactC` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentsa`
--

INSERT INTO `commentsa` (`id`, `article_id`, `user_id`, `comment_text`, `created_at`, `reactC`) VALUES
(1, 2, 14, 'azealzealkjelakzelakzenlakzn', '2024-12-18 02:35:46', 0),
(2, 2, 14, 'amdddouuni', '2024-12-18 02:37:43', 0),
(3, 2, 14, 'azeazeaeaze', '2024-12-18 02:45:04', 0),
(4, 2, 14, 'azeazeazeazeazeazeaz', '2024-12-18 02:56:05', 0),
(5, 2, 14, 'lazelanela', '2024-12-18 03:07:24', 0),
(6, 2, 14, 'azeazeaze', '2024-12-18 03:18:29', 0),
(7, 2, 14, 'az,erm', '2024-12-18 03:38:05', 0),
(8, 5, 14, ',mdfv,', '2024-12-18 04:17:30', 0),
(9, 2, 14, 'azeazeaeae', '2024-12-18 04:34:11', 0),
(10, 2, 14, 'é&quot;&#039;é&quot;&#039;²', '2024-12-18 05:25:05', 0);

-- --------------------------------------------------------

--
-- Structure de la table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_address` varchar(50) NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_status` varchar(50) NOT NULL,
  `delivery_agent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `delivery_agent`
--

CREATE TABLE `delivery_agent` (
  `agent_id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `agent_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `delivery_agent`
--

INSERT INTO `delivery_agent` (`agent_id`, `full_name`, `contact_number`, `agent_status`) VALUES
(2, 'ice', 78965432, 0),
(3, 'zainab', 12345678, 0),
(5, 'malek', 78945623, 1),
(6, 'hama', 45612398, 1);

-- --------------------------------------------------------

--
-- Structure de la table `delivery_location`
--

CREATE TABLE `delivery_location` (
  `location_id` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `delivery_location`
--

INSERT INTO `delivery_location` (`location_id`, `address`, `latitude`, `longitude`, `timestamp`) VALUES
(4, 'Délégation Msaken, Sousse, Tunisia', 35.6737, 10.5385, '2024-12-03 23:15:49'),
(5, 'Ariana, Tunisia', 36.9686, 10.122, '2024-12-04 02:06:20'),
(8, 'Tunis, Tunisia', 36.8002, 10.1858, '2024-12-11 09:29:57'),
(9, 'Djerba Island, Robbana, Délégation Djerba Midoun, ', 33.7736, 10.8862, '2024-12-11 09:35:22'),
(10, 'Sfax, La Médina, Délégation Sfax Ville, Sfax, 3000', 34.7394, 10.7604, '2024-12-16 13:02:36');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `idmessage` int(11) NOT NULL,
  `idreclamation` int(11) NOT NULL,
  `contenu_message` varchar(20) NOT NULL,
  `auteur` varchar(20) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_details` text DEFAULT NULL,
  `status` enum('pending','paid','shipped','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('available','unavailable','coming soon') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sales` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `img`, `status`, `created_at`, `updated_at`, `sales`) VALUES
(1, 'Ananas', 10.00, 'The pineapple is a tropical fruit valued for its freshness and sweet-tangy flavor. It is marketed as an exotic, healthy, and versatile product, perfect for consumers seeking a balanced, refreshing, and vitamin-rich diet.', 'image/ananas.jfif', 'available', '2024-11-26 16:22:36', '2024-12-17 20:33:46', 10),
(2, 'Avocado', 23.00, 'Avocado is a creamy, nutrient-dense fruit, marketed on marketplaces as a healthy and versatile choice. Packed with healthy fats, vitamins, and fiber, it appeals to health-conscious consumers looking for a nutritious addition to salads, sandwiches, or smoothies.', 'image/Avocado.jfif', 'coming soon', '2024-11-26 16:22:36', '2024-12-17 20:37:20', 0),
(3, 'Cherry', 7.00, 'Cherries are a sweet, juicy, and vibrant fruit, marketed on marketplaces as a premium, healthy snack. With their rich flavor and antioxidants, they appeal to consumers seeking a refreshing, natural treat or an ingredient for desserts, smoothies, and more.', 'image/Cherry.jpg', 'available', '2024-11-26 16:22:36', '2024-12-17 20:35:38', 10),
(4, 'Kiwi', 9.00, 'Kiwi is a tangy, nutrient-packed fruit, marketed on marketplaces as a delicious and healthy option. Rich in vitamins, fiber, and antioxidants, it appeals to consumers looking for a refreshing, exotic snack or a vibrant addition to smoothies and salads.', 'image/kiwi.jpg', 'available', '2024-11-26 22:20:14', '2024-12-17 20:36:30', 0),
(5, 'banane', 7.50, 'Discover the natural sweetness and sweet taste of our fresh bananas. Grown in ideal conditions, they are rich in essential nutrients such as potassium, vitamin B6 and vitamin C. Ideal for a quick snack, a base for smoothies or to add a sweet touch to your desserts, bananas are a food versatile appreciated by all.', 'image/banane.jfif', 'unavailable', '2024-11-27 07:53:47', '2024-12-17 20:52:07', 0);

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `idreclamation` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `image` varchar(200) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reclamation`
--

INSERT INTO `reclamation` (`idreclamation`, `nom`, `prenom`, `email`, `image`, `user_id`) VALUES
(0, 'azer', 'azedrftg', 'zainab.bouriga@gmail', 'Privacy Violation', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `topicTitle` varchar(255) NOT NULL,
  `topicContent` text NOT NULL,
  `author` int(11) NOT NULL,
  `creationDate` datetime NOT NULL,
  `lastUpdated` datetime NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `commentsCount` int(11) DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `topics`
--

INSERT INTO `topics` (`id`, `topicTitle`, `topicContent`, `author`, `creationDate`, `lastUpdated`, `tags`, `likes`, `views`, `commentsCount`, `status`, `image`, `user_id`) VALUES
(5, 'arbizighni', 'xzkl,zlkcz', 1, '2024-11-20 09:22:07', '2024-11-20 09:25:56', 'ekmez;;c', 0, 2, 0, 'active', '673d9d1439345.png', NULL),
(6, 'arbizighni', 'ggchgf', 1, '2024-11-20 09:27:01', '2024-11-20 09:27:01', 'erfjlek', 0, 0, 0, 'active', '673d9d55adc9c.png', NULL),
(8, 'arbizighni', 'hubjhbkkjbjhb', 1, '2024-11-24 13:03:02', '2024-11-24 13:03:02', 'hughjbhbhjb', 0, 0, 1, 'active', '674315f6356f4.png', NULL),
(10, 'daz,babx', ';ncd;nz;nc', 1, '2024-12-04 09:51:04', '2024-12-04 09:51:04', 'dznznkn', 0, 2, 0, 'active', '675017f88849f.png', NULL),
(11, 'arbiarbi', 'efcklmefklmec', 1, '2024-12-04 09:55:04', '2024-12-04 09:55:04', 'mlkzmlckmzlkmck', 3, 4, 1, 'active', '675018e8714aa.png', NULL),
(12, 'uuihu', 'hkkll', 1, '2024-12-07 17:23:02', '2024-12-07 17:23:02', 'ùmù', 2, 7, 1, 'active', '67547666bf647.png', NULL),
(13, 'arbizighni', 'lksql', 1, '2024-12-08 17:48:01', '2024-12-08 17:48:01', 'ekmez;;c', 0, 2, 0, 'active', '6755cdc1c4833.png', NULL),
(14, 'cdsdsvdv', 'xwcwwdc', 1, '2024-12-11 09:00:44', '2024-12-11 09:00:44', 'wqqsqs', 2, 7, 1, 'active', '675946ac3357c.png', NULL),
(15, 'arbiarbi', 'mpoiuygtfrds', 1, '2024-12-17 11:39:13', '2024-12-17 11:39:13', 'lkjhgf', 2, 3, 1, 'inactive', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'CLIENT',
  `phone` varchar(10) NOT NULL,
  `isBanned` tinyint(1) NOT NULL,
  `banDate` datetime DEFAULT NULL,
  `profilePicture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `isBanned`, `banDate`, `profilePicture`) VALUES
(1, 'tasnim sam', 'tasnim@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'ADMIN', '58906040', 0, NULL, 'back xo.png'),
(9, 'ala sam', 'alasam@gmail.com', 'a8cd70c4467b76b34ad9ba82455aa26d', 'CLIENT', '92901861', 0, '2024-12-18 09:40:09', 'back xo.png'),
(10, 'Med', 'sam.med@gmail.com', '6093b13c473f37a4d32d25216a6a9133', 'FARMER', '22223333', 0, NULL, 'back xo.png'),
(11, 'saif', 'saif.sam@gmail.com', '8c7682d566f21185d7dfb18e8b5f8e80', 'FARMER', '26753417', 0, '2024-12-19 21:53:30', 'd4e75f63-d507-4eb9-a33a-15e01f46b614.jpeg'),
(12, 'hamzaaaaa', 'hamzazighni875@gmail.com', '28936322a5eb164c9ced5a0166f93f15', 'CLIENT', '50986710', 0, '2024-12-18 09:54:02', 'ANIMATION1.png'),
(13, 'salouma', 'benhasa91@gmail.com', '48892f2e5f01c6ab7dd4978c1f9a9483', 'ADMIN', '58906040', 0, NULL, ''),
(14, 'ouda', 'ouda@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'CLIENT', '222222222', 0, NULL, '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `topicID` (`topicID`);

--
-- Index pour la table `commentsa`
--
ALTER TABLE `commentsa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`);

--
-- Index pour la table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `fk_agent` (`delivery_agent_id`),
  ADD KEY `fk_order` (`order_id`);

--
-- Index pour la table `delivery_agent`
--
ALTER TABLE `delivery_agent`
  ADD PRIMARY KEY (`agent_id`);

--
-- Index pour la table `delivery_location`
--
ALTER TABLE `delivery_location`
  ADD PRIMARY KEY (`location_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`idmessage`),
  ADD KEY `idreclamation` (`idreclamation`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`idreclamation`),
  ADD KEY `fk_user` (`user_id`);

--
-- Index pour la table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `commentsa`
--
ALTER TABLE `commentsa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `delivery_agent`
--
ALTER TABLE `delivery_agent`
  MODIFY `agent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `delivery_location`
--
ALTER TABLE `delivery_location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`topicID`) REFERENCES `topics` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `fk_agent` FOREIGN KEY (`delivery_agent_id`) REFERENCES `delivery_agent` (`agent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`idreclamation`) REFERENCES `reclamation` (`idreclamation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `reclamation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
