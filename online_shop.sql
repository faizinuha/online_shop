-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2024 at 08:02 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Food'),
(2, 'Drink'),
(4, 'Sport'),
(5, 'Dress'),
(6, 'Animal Food'),
(7, 'Animal'),
(8, 'Doll');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `product_id` bigint NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 25, 1, '9.00', 'cancelled', '2024-06-27 14:26:59', '2024-06-28 02:45:11'),
(6, 6, 22, 4, '60.00', 'completed', '2024-06-27 14:43:58', '2024-06-28 03:19:48'),
(8, 6, 24, 3, '30.00', 'completed', '2024-06-27 14:48:35', '2024-06-28 03:16:47'),
(10, 6, 22, 13, '195.00', 'cancelled', '2024-06-27 14:49:20', '2024-06-28 03:27:17'),
(11, 6, 24, 1000, '10000.00', 'completed', '2024-06-27 14:52:29', '2024-06-28 05:28:09'),
(12, 6, 27, 1, '10000000.00', 'cancelled', '2024-06-27 15:18:00', '2024-06-28 07:05:20'),
(13, 6, 22, 7, '105.00', 'cancelled', '2024-06-28 01:00:08', '2024-06-28 03:27:15'),
(14, 6, 27, 3, '300.00', 'pending', '2024-06-28 04:07:17', '2024-06-28 04:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `stock` enum('out of stock','available') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'available',
  `price` decimal(15,2) NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `excerpt` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `user_id` bigint NOT NULL,
  `category_id` bigint DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `stock`, `price`, `body`, `excerpt`, `image`, `user_id`, `category_id`, `created_at`, `updated_at`) VALUES
(18, 'Burger King', 'out of stock', '15.00', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Placeat, aspernatur obcaecati odit aperiam autem minima, expedita molestias natus quas officiis nostrum rerum facere, excepturi quasi reprehenderit animi soluta voluptate! Laudantium!', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Placeat, aspernatur obcaecati odit aperiam...', '1719463507burgerjpg.jpg', 2, 1, '2024-06-27 02:55:21', '2024-06-27 07:55:16'),
(20, 'Lemonade', 'out of stock', '8.00', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi animi modi doloremque quam voluptatem velit voluptate dolore eaque quaerat dolorum! Veniam non aperiam consequuntur exercitationem repellendus. Excepturi officia pariatur amet?', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi animi modi doloremque quam voluptate...', '1719464730DRINK.png', 10, 2, '2024-06-27 05:05:30', '2024-06-27 07:55:00'),
(22, 'Fried Rice', 'available', '15.00', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi animi modi doloremque quam voluptatem velit voluptate dolore eaque quaerat dolorum! Veniam non exercitationem repellendus. Excepturi officia pariatur amet?', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi animi modi doloremque quam voluptate...', '1719471400Nasi Goreng (Indonesian Fried Rice) - Sugar Spice & More.jpg', 2, 1, '2024-06-27 06:56:40', '2024-06-27 06:56:40'),
(24, 'Drink', 'available', '10.00', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi animi modi doloremque quam voluptatem velit voluptate dolore eaque quaerat dolorum! Veniam non aperiam consequuntur exercitationem repellendus. Excepturi officia pariatur amet?', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi animi modi doloremque quam voluptate...', '1719540651DRINK.png', 2, 2, '2024-06-27 06:58:05', '2024-06-28 02:10:51'),
(25, 'Ice Coffee', 'available', '9.00', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur iusto velit, labore harum ab, quis error nemo inventore praesentium, maxime eligendi? Facere, corporis rerum esse quo aspernatur accusantium accusamus sapiente.', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur iusto velit, labore harum ab, ...', '1719476652IcedCoffeenewjpg.jpg', 10, 2, '2024-06-27 08:24:12', '2024-06-27 08:24:12'),
(27, 'Fried Rice', 'available', '100.00', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis tempora quo odit maxime est numquam, quas amet ea repellendus omnis voluptas eos nihil inventore consequatur provident totam assumenda ipsam neque!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis tempora quo odit maxime est numq...', '1719539505Nasi Goreng (Indonesian Fried Rice) - Sugar Spice & More.jpg', 2, 1, '2024-06-27 15:01:08', '2024-06-28 07:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `username` varchar(255) NOT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bio` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `role`, `email`, `password`, `address`, `firstname`, `lastname`, `phone`, `bio`) VALUES
(2, 'Admin', 'admin', 'admin@gmail.com', '$2y$10$4DxQU/hkuQtEzj5r.0Ced.RJWV.frWDjvAG7UScXV/VEnbeL2Ur5a', 'Jl. Mawar No.20', 'Admin', 'Last', '081356983', '<div style=\"text-align: center;\"><div style=\"line-height: 19px; margin-left: 25px;\"><b>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam dolorum aliquam deleniti sequi laborum at ad cupiditate, totam illo unde ullam facilis libero. In ea accusamus voluptatem voluptates, aut incidunt?</b></div></div>'),
(3, 'Johndoe', 'admin', 'johndoe@gmail.com', '$2y$10$4/LW3YKVFTZaxQU.ypJYdua5DHVC2UHRwRYt/rJ418t7cTECDLtC2', 'Jalan Mangga Kecil No.13, RT 09 RW 03, Kelurahan Besi Tua', NULL, NULL, '', NULL),
(6, 'customer', 'customer', 'customer1@email.com', '$2y$10$uexv6qhjcClKZaTnRKE28.2VpJoDdCBxc9NY83HPi9OtaB7aNfxqm', 'Warta Prakarsa (Cak War). Jl. Petemon IV No.32-A, RT 14/RW 08', 'Customer', '1', '08136739', '<div style=\"text-align: center; line-height: 19px;\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam sunt velit doloremque distinctio, explicabo repellendus odio vel iusto at earum alias ullam in nostrum a excepturi corporis sit rerum debitis.</div>'),
(9, 'customer2', 'customer', 'customer2@email.com', '$2y$10$DOipFim6Xz7WMpkYoTQGtO9BYnrKIxUHSZpNk03agZmnDNtyLj0QG', NULL, 'Customer', '2', NULL, NULL),
(10, 'admin2', 'admin', 'admin2@gmail.com', '$2y$10$e0qT58r7i6DCdI0xuxiDAeeft.khTwQZf959OnY5DkjwR8T9Clx7S', 'Jl. Mawar No.14', 'Admin', '2', '081353434', '<div style=\"text-align: center; line-height: 19px;\"><b>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur iusto velit, labore harum ab, quis error nemo inventore praesentium, maxime eligendi? Facere, corporis rerum esse quo aspernatur accusantium accusamus sapiente.</b></div>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
