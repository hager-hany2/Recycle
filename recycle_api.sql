-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8080:3308
-- Generation Time: Nov 22, 2024 at 03:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recycle_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` text NOT NULL,
  `image_url` text NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `user_id`, `category_name`, `category_description`, `image_url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'food', 'Turn your food waste into  something valuable.We buy food scraps, expired products,and more. Help reduce waste, support sustainability,and get paid. Schedule a pickup and start earning today!', 'image/pexels-ella-olsson-572949-1640774 1.jpg', NULL, '2024-11-22 02:21:32', '2024-11-22 02:21:32'),
(2, 1, 'plastic', 'Turn your plastic waste into value! We buy all types of plastic for recycling. Help reduce pollution and earn cash by recycling with us.Schedule a pickup today and make a difference.', 'image/pexels-magda-ehlers-pexels-2547565.jpg', NULL, '2024-11-22 02:22:16', '2024-11-22 02:22:16'),
(4, 1, 'GLass', 'Got glass waste? We buy it! Turn your old glass items into cash and contribute to a greener, cleaner planet. Schedule a pickup today and join us in recycling for a more sustainable future!', 'image/pexels-suzyhazelwood-2955032 2.jpg', NULL, '2024-11-22 02:24:29', '2024-11-22 02:24:29'),
(5, 1, 'Metal', 'Got glass waste? We buy it! Turn your old glass items into cash and contribute to a greener, cleaner planet. Schedule a pickup today and join us in recycling for a more sustainable future!', 'image/download (19).jpeg', NULL, '2024-11-22 02:26:25', '2024-11-22 02:26:25'),
(6, 1, 'Paper', 'Have excess paper? We buy it! Turn your paper waste into cash while helping to save trees and reduce landfill waste. Schedule a pickup today and contribute to a greener future!', 'image/pexels-shvets-production-7512846 1.jpg', NULL, '2024-11-22 02:27:32', '2024-11-22 02:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_04_183727_create_categories_table', 1),
(6, '2024_11_12_194406_create_products_table', 1),
(7, '2024_11_15_143627_create_orders_table', 1),
(8, '2024_11_18_230449_create_productspoints_table', 1),
(9, '2024_11_18_231255_create_orderpoints_table', 1),
(10, '2024_11_18_231256_create_payments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderpoints`
--

CREATE TABLE `orderpoints` (
  `OrderPoint_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ProductsPoints_id` bigint(20) UNSIGNED NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` enum('pending','cancel','complete') NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `pickup_time` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` enum('pending','cancel','complete') NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `OrderPoint_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `Amount_paid` decimal(10,2) NOT NULL,
  `status` enum('pending','cancel','complete') NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'YourAppName', '770793fb3adfb2f33d5acaf57cbf78ed371ccb73534376728f7365446bd241ee', '[\"*\"]', NULL, NULL, '2024-11-22 02:17:18', '2024-11-22 02:17:18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `price_product` int(11) NOT NULL,
  `point_product` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `QuantityType` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_description`, `price_product`, `point_product`, `category_name`, `image_url`, `QuantityType`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Fruit and Vegetable Peels', 'Fruit and Vegetable Peels in good condition recyclable', 5, 50, 'food', 'images\\ae5435e14c64ff48a4e98a0928158dd2 (1).jpg', 'killo', NULL, '2024-11-22 02:29:34', '2024-11-22 02:29:34'),
(2, 1, 'Coffee Ground', 'Coffee Ground in good condition recyclable', 4, 40, 'food', 'image/StockCake-Eggshells on Board_1728080212.jpg', 'killo', NULL, '2024-11-22 02:31:38', '2024-11-22 02:31:38'),
(3, 1, 'Eggshells', 'Eggshells in good condition recyclable', 8, 80, 'food', 'image/StockCake-Eggshells on Board_1728080212.jpg', 'killo', NULL, '2024-11-22 02:33:23', '2024-11-22 02:33:23'),
(4, 1, 'Stale Bread', 'Stale Bread in good condition recyclable', 10, 100, 'food', 'image/StockCake-Moldy bread slice_1728080262.jpg', 'killo', NULL, '2024-11-22 02:34:35', '2024-11-22 02:34:35'),
(5, 1, 'Organic Food Scraps', 'Organic Food Scraps in good condition recyclable', 5, 50, 'food', 'image/f47d2da7c6804cd6d6d9c5918e3be67d.jpg', 'killo', NULL, '2024-11-22 02:35:59', '2024-11-22 02:35:59'),
(6, 1, 'Old or Damaged Grains', 'Old or Damaged Grains in good condition recyclable', 5, 50, 'food', 'image/StockCake-Assorted Nuts Spill_1728080554.jpg', 'killo', NULL, '2024-11-22 02:37:08', '2024-11-22 02:37:08'),
(7, 1, 'Fish and Bone Waste', 'Fish and Bone Waste in good condition recyclable', 5, 50, 'food', 'image/daabdad095dd4696aaeaa632b89ade5a.jpg', 'killo', NULL, '2024-11-22 02:38:38', '2024-11-22 02:38:38'),
(8, 5, 'Metal Cans', 'Metal Cans in good condition recyclable', 16, 160, 'Metal', 'image/b9c6771500da094ca0751a144d5d0cb2.jpg', 'killo', NULL, '2024-11-22 02:40:35', '2024-11-22 02:40:35'),
(9, 5, 'Metal Wire', 'Metal Wire in good condition recyclable', 20, 200, 'Metal', 'image/StockCake-Tangled Wire Ball_1728082509.jpg', 'killo', NULL, '2024-11-22 02:41:34', '2024-11-22 02:41:34'),
(10, 5, 'Cream box', 'Cream box in good condition recyclable', 2, 20, 'Metal', 'image/download (26).jpeg', 'peace', NULL, '2024-11-22 02:43:07', '2024-11-22 02:43:07'),
(11, 5, 'Metal Kitchen Utensils', 'Metal Kitchen Utensils in good condition recyclable', 5, 50, 'Metal', 'image/download (25).jpeg', 'peace', NULL, '2024-11-22 02:46:24', '2024-11-22 02:46:24'),
(13, 5, 'Almonia antiques', 'Almonia antiques in good condition recyclable', 12, 120, 'Metal', 'image/download (28).jpeg', 'killo', NULL, '2024-11-22 02:48:45', '2024-11-22 02:48:45'),
(14, 6, 'Newspapers and Magazines', 'Newspapers and Magazines in good condition recyclable', 6, 60, 'Paper', 'image/StockCake-Piled News Media_1728077828.jpg', 'killo', NULL, '2024-11-22 02:53:44', '2024-11-22 02:53:44'),
(15, 6, 'Card board', 'Card board in good condition recyclable', 6, 60, 'Paper', 'image/StockCake-Warehouse Cardboard Stacks_1728077869.jpg', 'killo', NULL, '2024-11-22 02:55:35', '2024-11-22 02:55:35'),
(16, 6, 'School Books', 'School Books in good condition recyclable', 12, 120, 'Paper', 'image/download (2).jpeg', 'killo', NULL, '2024-11-22 02:56:50', '2024-11-22 02:56:50'),
(17, 6, 'Old Books', 'Old Books in good condition recyclable', 12, 120, 'Paper', 'image/StockCake-Stacked old books_1728077901.jpg', 'killo', NULL, '2024-11-22 02:57:42', '2024-11-22 02:57:42'),
(18, 6, 'Envelopes', 'Envelopes in good condition recyclable', 12, 120, 'Paper', 'image/StockCake-Vintage Letter Collection_1728078271.jpg', 'killo', NULL, '2024-11-22 02:58:58', '2024-11-22 02:58:58'),
(19, 6, 'Egg Cartons', 'Egg Cartons in good condition recyclable', 2, 20, 'Paper', 'image/StockCake-Stacked Egg Cartons_1728078051.jpg', 'peace', NULL, '2024-11-22 03:00:50', '2024-11-22 03:00:50'),
(20, 6, 'Paper Towels', 'Paper Towels in good condition recyclable', 3, 30, 'Paper', 'image/StockCake-Wicker Basket Display_1728078176.jpg', 'peace', NULL, '2024-11-22 03:01:53', '2024-11-22 03:01:53'),
(21, 4, 'Glass Bottles', 'Glass Bottles in good condition recyclable', 5, 50, 'Glass', 'image/tockCake-Chilled Glass Bottle_1728067927.jpg', 'peace', NULL, '2024-11-22 03:12:04', '2024-11-22 03:12:04'),
(22, 4, 'glass makeup', 'glass makeup in good condition recyclable', 3, 30, 'Glass', 'image/ownload (8).jpeg', 'peace', NULL, '2024-11-22 03:16:24', '2024-11-22 03:16:24'),
(23, 4, 'Glass Cups and Mugs', 'Glass Cups and Mugs in good condition recyclable', 3, 30, 'Glass', 'image/StockCake-Mug Tree Art_1728074436.jpg', 'peace', NULL, '2024-11-22 03:17:33', '2024-11-22 03:17:33'),
(24, 4, 'Decorative Glass', 'Decorative Glass in good condition recyclable', 5, 50, 'Glass', 'image/ownload (32).jpeg', 'peace', NULL, '2024-11-22 03:18:34', '2024-11-22 03:18:34'),
(25, 4, 'Glass Jars', 'Glass Jars in good condition recyclable', 3, 30, 'Glass', 'image/StockCake-Open Glass Jar_1728076478.jpg', 'peace', NULL, '2024-11-22 03:19:43', '2024-11-22 03:19:43'),
(27, 4, 'Mirrors', 'Mirrors in good condition recyclable', 20, 200, 'Glass', 'image/StockCake-Shattered Wooden Mirror_1728075836.jpg', 'peace', NULL, '2024-11-22 03:25:03', '2024-11-22 03:25:03'),
(28, 4, 'Glass Light Bulbs', 'Glass Light Bulbs in good condition recyclable', 5, 50, 'Glass', 'image/StockCake-Illuminated light bulbs_1728076268.jpg', 'peace', NULL, '2024-11-22 03:26:19', '2024-11-22 03:26:19'),
(29, 2, 'chair', 'Plastic chair in good condition recyclable.', 12, 120, 'Glass', 'image/download (6).jpeg', 'peace', NULL, '2024-11-22 03:34:25', '2024-11-22 03:34:25'),
(30, 4, 'Glass Windows', 'Glass Windows in good condition recyclable', 20, 200, 'Glass', 'image/StockCake-Shattered glass hallway_1728075645.jpg', 'peace', NULL, '2024-11-22 03:40:05', '2024-11-22 03:40:05'),
(32, 6, 'Paper Bags', 'Paper Bags in good condition recyclable', 5, 50, 'Paper', 'image/StockCake-Shopping spree essentials_1728077958.jpg', 'Killo', NULL, '2024-11-21 21:01:49', '2024-11-21 21:01:49'),
(33, 2, 'Bottle', 'Plastic Bootle in good condition recyclable', 5, 50, 'plastic', 'image/StockCake-Recycled plastic bottle_1727012161.jpg', 'peace', NULL, '2024-11-22 05:14:49', '2024-11-22 05:14:49'),
(34, 2, 'Plastic foundation', 'Plastic foundation in good condition recyclable', 2, 20, 'plastic', 'image/cosmetic_liqfound (1).webp', 'peace', NULL, '2024-11-22 05:17:18', '2024-11-22 05:17:18'),
(35, 2, 'plastic toys', 'plastic toys in good condition recyclable', 4, 40, 'plastic', 'image/Plastic cup in good condition recyclable', 'peace', NULL, '2024-11-22 05:18:48', '2024-11-22 05:18:48'),
(36, 2, 'water cooler', 'water cooler in good condition recyclable', 12, 120, 'plastic', 'image/shopping.webp', 'peace', NULL, '2024-11-22 05:19:55', '2024-11-22 05:19:55'),
(37, 2, 'Shampoo and Detergent Bottles', 'Shampoo and Detergent Bottles in good condition recyclable', 4, 40, 'plastic', 'image/download.jpeg', 'peace', NULL, '2024-11-22 05:21:14', '2024-11-22 05:21:14'),
(38, 2, 'Plastic Pipes', 'Plastic Pipes in good condition recyclable', 5, 50, 'plastic', 'image/tockCake-Colorful Pipe Array_1728067328.jpg', 'peace', NULL, '2024-11-22 05:22:27', '2024-11-22 05:22:27'),
(39, 2, 'Plastic Food', 'Plastic Food Containers in good condition recyclable', 20, 200, 'plastic', 'image/ownload (3).jpeg', 'peace', NULL, '2024-11-22 05:23:28', '2024-11-22 05:23:28'),
(40, 2, 'Plastic plate', 'Plastic plate in good condition recyclable', 15, 150, 'plastic', 'image/StockCake-Colorful Party Tableware_1727006759.jpg', 'Killo', NULL, '2024-11-22 05:25:24', '2024-11-22 05:25:24'),
(41, 2, 'Plastic cup', 'Plastic cup in good condition recyclable', 5, 50, 'plastic', 'image/images (6).jpeg', 'Killo', NULL, '2024-11-22 05:39:19', '2024-11-22 05:39:19'),
(42, 2, 'Plastic Bags', 'Plastic Bags in good condition recyclable', 5, 50, 'plastic', 'image/StockCake-Colorful plastic bags_1727997458.jpg', 'Killo', NULL, '2024-11-22 05:44:07', '2024-11-22 05:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `productspoints`
--

CREATE TABLE `productspoints` (
  `ProductsPoints_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `point` int(11) NOT NULL,
  `image_url` text NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productspoints`
--

INSERT INTO `productspoints` (`ProductsPoints_id`, `user_id`, `name`, `point`, `image_url`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'oil', 150, 'image/image 6.png', NULL, '2024-11-22 06:02:14', '2024-11-22 06:02:14'),
(2, 1, 'sugar', 300, 'image/R.png', NULL, '2024-11-22 06:03:04', '2024-11-22 06:03:04'),
(3, 1, 'flour', 500, 'image/Flour-PNG-Clipart.png', NULL, '2024-11-22 06:03:45', '2024-11-22 06:03:45'),
(4, 1, 'rice', 100, 'image/rice.png', NULL, '2024-11-22 06:04:34', '2024-11-22 06:04:34'),
(5, 1, 'lentils/beans (500gm)', 90, 'image/R (1).png', NULL, '2024-11-22 06:05:07', '2024-11-22 06:05:07'),
(6, 1, 'reuseable bags', 100, 'image/OIP.jpg', NULL, '2024-11-22 06:05:36', '2024-11-22 06:05:36'),
(7, 1, 'reuseable water bottles', 200, 'image/download (7).jpeg', NULL, '2024-11-22 06:05:59', '2024-11-22 06:05:59'),
(8, 1, 'wooden cutlery set', 150, 'image/download (7).jpeg', NULL, '2024-11-22 06:06:31', '2024-11-22 06:06:31'),
(9, 1, 'organic soap', 150, 'image/OIP (1).jpg', NULL, '2024-11-22 06:07:12', '2024-11-22 06:07:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('admin','user','مستخدم','ادمن') NOT NULL DEFAULT 'user',
  `category_user` enum('restaurant','home','school') NOT NULL,
  `api_token` varchar(80) DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `point` int(11) NOT NULL DEFAULT 0,
  `is_locked` tinyint(4) NOT NULL DEFAULT 0,
  `image_url` varchar(255) NOT NULL DEFAULT 'images/96fe121-5dfa-43f4-98b5-db50019738a7.jpg',
  `Gender` enum('female','male') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `email_verified_at`, `password`, `type`, `category_user`, `api_token`, `price`, `point`, `is_locked`, `image_url`, `Gender`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'hager', 'hager@gmail.com', '01002444738', NULL, '$2y$10$Y2s6winKj98p2Ap9mT7.jOu14FiKxz5RI/uupTPHmjNMoGW6kuTeC', 'admin', 'home', NULL, 0, 0, 0, 'images/96fe121-5dfa-43f4-98b5-db50019738a7.jpg', 'female', NULL, '2024-11-22 02:17:18', '2024-11-22 02:17:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `categories_category_name_unique` (`category_name`),
  ADD KEY `categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderpoints`
--
ALTER TABLE `orderpoints`
  ADD PRIMARY KEY (`OrderPoint_id`),
  ADD KEY `orderpoints_user_id_foreign` (`user_id`),
  ADD KEY `orderpoints_productspoints_id_foreign` (`ProductsPoints_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_orderpoint_id_foreign` (`OrderPoint_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `productspoints`
--
ALTER TABLE `productspoints`
  ADD PRIMARY KEY (`ProductsPoints_id`),
  ADD KEY `productspoints_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orderpoints`
--
ALTER TABLE `orderpoints`
  MODIFY `OrderPoint_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `productspoints`
--
ALTER TABLE `productspoints`
  MODIFY `ProductsPoints_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderpoints`
--
ALTER TABLE `orderpoints`
  ADD CONSTRAINT `orderpoints_productspoints_id_foreign` FOREIGN KEY (`ProductsPoints_id`) REFERENCES `productspoints` (`ProductsPoints_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderpoints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_orderpoint_id_foreign` FOREIGN KEY (`OrderPoint_id`) REFERENCES `orderpoints` (`OrderPoint_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `productspoints`
--
ALTER TABLE `productspoints`
  ADD CONSTRAINT `productspoints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
