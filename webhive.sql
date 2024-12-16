-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 16 déc. 2024 à 18:10
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

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `address`, `phone`, `email`, `payment_method`, `payment_details`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'kljhgbf', 'jkhjgf', '12345678', 'rahma@hhh.hhh', 'paypal', NULL, 'pending', '2024-12-10 17:24:03', '2024-12-10 17:24:03'),
(2, 1, 'kljhgbf', 'kjhv', '88888888', 'rahma@hhh.hhh', 'credit_card', NULL, 'pending', '2024-12-11 08:58:36', '2024-12-11 08:58:36'),
(3, 1, 'kljhgbf', 'lkjhgv', '58554286', 'rahma@hhh.hhh', 'credit_card', NULL, 'pending', '2024-12-11 09:10:06', '2024-12-11 09:10:06'),
(4, 1, 'kljhgbf', 'kjhbgvc', '58554286', '00@fff.ff', 'paypal', NULL, 'pending', '2024-12-11 09:29:48', '2024-12-11 09:29:48'),
(5, 1, 'kljhgbf', 'hdkjdc', '12345678', '00@fff.ff', 'credit_card', NULL, 'pending', '2024-12-11 09:40:17', '2024-12-11 09:40:17');

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

--
-- Déchargement des données de la table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(41, 33, 1, 1, 99.99),
(42, 34, 1, 3, 99.99),
(43, 34, 4, 1, 60.00),
(44, 1, 1, 1, 99.99),
(45, 2, 1, 1, 99.99),
(46, 3, 1, 1, 99.99),
(47, 4, 1, 1, 99.99),
(48, 5, 1, 2, 99.99);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `status` enum('available','unavailable','coming soon') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sales` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `img`, `status`, `created_at`, `updated_at`, `sales`) VALUES
(1, 'Ananas', 99.99, 'Description for product 1', 'image/ananas.jfif', 'available', '2024-11-26 17:22:36', '2024-12-04 02:03:47', 10),
(2, 'Avocado', 149.99, 'Description for product 2', 'image/Avocado.jfif', 'coming soon', '2024-11-26 17:22:36', '2024-12-04 02:04:07', 0),
(3, 'Cherry', 199.99, 'Description for product 3', 'image/Cherry.jpg', 'available', '2024-11-26 17:22:36', '2024-12-04 02:04:26', 10),
(4, 'Kiwi', 60.00, '', 'image/kiwi.jpg', 'available', '2024-11-26 23:20:14', '2024-12-04 03:04:00', 0),
(5, 'banane', 70.00, 'Discover the natural sweetness and sweet taste of our fresh bananas. Grown in ideal conditions, they are rich in essential nutrients such as potassium, vitamin B6 and vitamin C. Ideal for a quick snack, a base for smoothies or to add a sweet touch to your desserts, bananas are a food versatile appreciated by all.', 'image/banane.jfif', 'unavailable', '2024-11-27 08:53:47', '2024-12-04 08:15:27', 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

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
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

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
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
