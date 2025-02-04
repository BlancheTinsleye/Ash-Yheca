-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2025 at 10:51 AM
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
-- Database: `disenyo_pilipino`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL COMMENT 'Unique identifier for each category.',
  `category_name` varchar(15) NOT NULL COMMENT 'name of the product category',
  `description` text NOT NULL COMMENT 'description of categories.',
  `parent_id` int(11) NOT NULL COMMENT 'identifier for the parent category(if any)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`, `parent_id`) VALUES
(1, 'Damit', 'Uri ng kasuotan', 0),
(2, 'Gamit', 'Iba\'t ibang bagay o kagamitan', 0),
(3, 'Pagkain', 'Uri ng mga pagkain', 0),
(4, 'Pambabae', 'Kasuotan ng Babae', 1),
(5, 'Panlalaki', 'Kasuotan ng Lalaki', 1),
(6, 'Pambata', 'Kasuotan ng Bata', 1),
(7, 'Pambahay', 'Gamit sa bahay', 2),
(8, 'Pangkusina', 'Gamit sa Kusina', 2),
(9, 'Panlabas', 'Gamit sa Labas', 2),
(10, 'Abubot', 'Iba pang gamit', 2),
(11, 'Ulam', 'Mga Putahe', 3),
(12, 'Matatamis', 'Matatamis', 3),
(13, 'Maaalat', 'Maaalat', 3);

-- --------------------------------------------------------

--
-- Table structure for table `language_translations`
--

CREATE TABLE `language_translations` (
  `id` int(11) NOT NULL,
  `key_name` varchar(50) NOT NULL,
  `language_code` varchar(10) NOT NULL,
  `translation_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `language_translations`
--

INSERT INTO `language_translations` (`id`, `key_name`, `language_code`, `translation_text`) VALUES
(1, 'language', 'en', 'Language'),
(2, 'language', 'tl', 'Wika'),
(3, 'login_txt', 'en', 'Log-in'),
(4, 'login_txt', 'tl', 'Mag Log-in'),
(5, 'to_login_page_bttn', 'en', 'Click to proceed'),
(6, 'to_login_page_bttn', 'tl', 'Pindutin upang magpatuloy'),
(7, 'create_account_txt', 'en', 'CREATE ACCOUNT'),
(8, 'create_account_txt', 'tl', 'GUMAWA NG ACCOUNT'),
(9, 'to_create_account_bttn', 'en', 'Click to create account'),
(10, 'to_create_account_bttn', 'tl', 'Gumawa ng account'),
(11, 'pn_login', 'en', 'Log-in'),
(12, 'pn_login', 'tl', 'Mag Log-in'),
(13, 'login_bttn', 'en', 'Log-in'),
(14, 'login_bttn', 'tl', 'Mag Log-in'),
(15, 'ask_no_account', 'en', 'No account'),
(16, 'ask_no_account', 'tl', 'Wala pang account'),
(17, 'clothes', 'en', 'Clothes'),
(18, 'clothes', 'tl', 'Damit'),
(19, 'items', 'en', 'Items'),
(20, 'items', 'tl', 'Gamit'),
(21, 'food', 'en', 'Foods'),
(22, 'food', 'tl', 'Pagkain'),
(23, 'for_girls', 'en', 'For Girls'),
(24, 'for_girls', 'tl', 'Pambabae'),
(25, 'for_boys', 'en', 'For Boys'),
(26, 'for_boys', 'tl', 'Panlalaki'),
(27, 'for_kids', 'en', 'For Kids'),
(28, 'for_kids', 'tl', 'Pambata'),
(29, 'product', 'en', 'Product'),
(30, 'product', 'tl', 'Produkto'),
(31, 'price', 'en', 'Price'),
(32, 'price', 'tl', 'Presyo'),
(33, 'stock', 'en', 'Stock'),
(34, 'stock', 'tl', 'istak'),
(35, 'AS_view_prdct_bttn', 'en', 'View Product'),
(36, 'AS_view_prdct_bttn', 'tl', 'Busisiin ang produkto'),
(37, 'prdct_id', 'en', 'Product ID'),
(38, 'prdct_id', 'tl', 'ID ng Produkto'),
(39, 'categories', 'en', 'Categories'),
(40, 'categories', 'tl', 'Kategorya'),
(41, 'description', 'en', 'Description'),
(42, 'description', 'tl', 'Deskripsyon'),
(43, 'AS_edit_prdct_bttn', 'en', 'Edit Product'),
(44, 'AS_edit_prdct_bttn', 'tl', 'I-edit and Produkto'),
(45, 'AS_save_edit_bttn', 'en', 'Save'),
(46, 'AS_save_edit_bttn', 'tl', 'I-save'),
(47, 'cancel_edit_bttn', 'en', 'Cancel'),
(48, 'cancel_edit_bttn', 'tl', 'Ikansela'),
(49, 'username', 'en', 'Username'),
(50, 'username', 'tl', 'Username'),
(51, 'email', 'en', 'Email'),
(52, 'email', 'tl', 'Email'),
(53, 'first_name', 'en', 'First Name'),
(54, 'first_name', 'tl', 'Pangalan'),
(55, 'surname', 'en', 'Surname'),
(56, 'surname', 'tl', 'Apelyido'),
(57, 'address', 'en', 'Your address'),
(58, 'address', 'tl', 'Iyong adres'),
(59, 'number', 'en', 'Type your number'),
(60, 'number', 'tl', 'Ilagay ang numero ng telepono'),
(61, 'password', 'en', 'Password'),
(62, 'password', 'tl', 'Ilagay ang password'),
(63, 'check_password', 'en', 'Type again your password'),
(64, 'check_password', 'tl', 'Ilagay muli ang iyong password'),
(65, 'next_bttn', 'en', 'Next'),
(66, 'next_bttn', 'tl', 'Sunod'),
(67, 'remove_bttn', 'en', 'Remove'),
(68, 'remove_bttn', 'tl', 'Tanggalin'),
(69, 'notif_inv_login', 'en', 'Invalid username or password. Please try again.'),
(70, 'notif_inv_login', 'tl', 'Mali ang username o password na iyong inilagay, Maaari sanang ulitin mo na lamang'),
(71, 'for_home', 'en', 'Home'),
(72, 'for_home', 'tl', 'Pambahay'),
(73, 'for_kitchen', 'en', 'Kitchen'),
(74, 'for_kitchen', 'tl', 'Pangkusina'),
(75, 'for_outside', 'en', 'Outdoor'),
(76, 'for_outside', 'tl', 'Panlabas'),
(77, 'for_stuffs', 'en', 'Stuffs'),
(78, 'for_stuffs', 'tl', 'Abubot'),
(79, 'side_dish', 'en', 'Side Dish'),
(80, 'side_dish', 'tl', 'Ulam'),
(81, 'sweets', 'en', 'Sweets'),
(82, 'sweets', 'tl', 'Matatamis'),
(83, 'salty', 'en', 'Salty'),
(84, 'salty', 'tl', 'Maaalat'),
(91, 'filter', 'en', 'FILTER'),
(92, 'filter', 'tl', 'I-FILTER'),
(93, 'choose_fltr', 'en', 'Choose Filter'),
(94, 'choose_fltr', 'tl', 'Mamili ng Filter'),
(95, 'rate', 'en', 'Rate'),
(96, 'rate', 'tl', 'Marka'),
(97, 'choose_order', 'en', 'Choose Order'),
(98, 'choose_order', 'tl', 'Mamili ng pagkakasunod'),
(99, 'product', 'en', 'Product'),
(100, 'product', 'tl', 'Produkto'),
(101, 'description', 'en', 'Deskcription'),
(102, 'description', 'tl', 'Deskripsyon'),
(103, 'bilang', 'en', 'QTY'),
(104, 'bilang', 'tl', 'Bilang'),
(105, 'checkout', 'en', 'checkout'),
(106, 'checkout', 'tl', 'i-checkout'),
(107, 'history', 'en', 'History'),
(108, 'history', 'tl', 'Mga Pinamili'),
(109, 'logout', 'en', 'Log out'),
(110, 'logout', 'tl', 'Mag log out'),
(111, 'logout_mssg', 'en', 'Are you sure?'),
(112, 'logout_mssg', 'tl', 'Ikaw ba\'y sigurado?'),
(113, 'liked_mssg', 'en', 'Added to likes'),
(114, 'liked_mssg', 'tl', 'Nailagay na sa mga gusto'),
(115, 'unliked_mssg', 'en', 'Removed from likes'),
(116, 'unliked_mssg', 'tl', 'Inialis sa mga gusto');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `product_id`, `user_id`) VALUES
(33, 5, 1),
(34, 5, 16),
(37, 3, 16),
(38, 4, 16),
(39, 8, 16),
(40, 17, 16),
(41, 17, 1),
(42, 12, 1),
(43, 21, 1),
(44, 24, 1),
(45, 26, 16),
(46, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ordered_products`
--

CREATE TABLE `ordered_products` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'ID of the user who placed the order.',
  `product_id` int(11) NOT NULL COMMENT 'Id of the product included in the order.',
  `status` enum('pending','to_be_shipped','on_delivery','delivered','cancelled','returned') NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'the quantity of the product ordered',
  `total_prc` decimal(10,2) NOT NULL COMMENT 'the total price for this product (quantity x price)',
  `shipping_address` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'unique identifier for each cart',
  `rate_status` enum('true','false') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordered_products`
--

INSERT INTO `ordered_products` (`order_id`, `user_id`, `product_id`, `status`, `quantity`, `total_prc`, `shipping_address`, `order_date`, `rate_status`) VALUES
(1, 16, 1, 'pending', 1, 150.00, 'mapulang lupa', '2024-11-19 14:48:24', 'true'),
(2, 16, 29, 'to_be_shipped', 1, 30.00, 'mapulang lupa', '2024-11-19 15:45:49', 'false'),
(3, 17, 1, 'pending', 1, 150.00, 'mapulang lupa', '2024-11-19 15:56:51', 'false'),
(4, 16, 15, 'pending', 1, 10.00, 'asasas', '2024-11-19 16:03:56', 'false'),
(5, 17, 15, 'to_be_shipped', 1, 10.00, 'dasfds', '2024-11-19 16:05:02', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL COMMENT 'Unique identifier for each order.',
  `user_id` int(11) NOT NULL COMMENT 'ID of the user who placed the order.',
  `total_price` decimal(10,2) NOT NULL COMMENT 'ID of the user who placed the order.',
  `order_status` enum('pending','shipped','delivered') NOT NULL COMMENT 'The current status of the order.',
  `shipping_address` text NOT NULL COMMENT 'shipping_address	text	255	Not Null	Shipping address for the order.',
  `order_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6) COMMENT 'Unique identifier for each cart.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `order_status`, `shipping_address`, `order_date`) VALUES
(2, 16, 150.00, 'pending', 'mapulang lupa', '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL COMMENT 'unique identifier for each order item',
  `order_id` int(11) NOT NULL COMMENT 'ID of the related order',
  `product_id` varchar(15) NOT NULL COMMENT 'Id of the product included in the order.',
  `quantity` int(11) NOT NULL COMMENT 'the quantity of the product ordered',
  `price` decimal(10,2) NOT NULL COMMENT 'the total price for this product (quantity x price)',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'unique identifier for each cart'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`, `order_date`) VALUES
(2, 2, '1', 1, 150.00, '2024-11-19 14:02:46');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL COMMENT 'unique identifier for each payment',
  `order_id` int(11) NOT NULL COMMENT 'Id of the related order',
  `amount` decimal(10,2) NOT NULL COMMENT 'the amount paid',
  `payment_method` enum('credit card','paypal','bank transfer') NOT NULL COMMENT 'the method used to make the payment',
  `payment_status` enum('pending','completed','failed') NOT NULL COMMENT 'the current status of the payment',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'date and time the payment was made'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(15) NOT NULL COMMENT 'Unique identifier for each product.',
  `name` varchar(100) NOT NULL COMMENT 'The name of the product.',
  `description` text NOT NULL COMMENT 'Detailed description of the product.',
  `product_img` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL COMMENT 'Price of the product.',
  `rate` decimal(1,1) NOT NULL,
  `stock` int(5) NOT NULL COMMENT 'Number of items in stock.',
  `parent_category` int(11) NOT NULL,
  `category_id` int(11) NOT NULL COMMENT 'Identifier for product’s category',
  `group_prdct_num` int(11) DEFAULT NULL COMMENT 'same num, same group\r\n',
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6) COMMENT 'Product creation date',
  `updated_at` datetime(6) NOT NULL COMMENT 'Date of latest product update'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `product_img`, `price`, `rate`, `stock`, `parent_category`, `category_id`, `group_prdct_num`, `created_at`, `updated_at`) VALUES
(1, 'Lampara', 'Magdala ng ganda at liwanag sa bawat sulok ng iyong tahanan gamit ang aming lampara. Dinisenyo para pagsamahin ang modernong istilo at praktikalidad, ito ay perpektong akma sa anumang espasyo—mula sa salas hanggang sa kwarto.\r\n\r\nMga Tampok:\r\n\r\nSleek at Eleganteng Disenyo: Ang minimalistang disenyo ay nagbibigay ng simple ngunit eleganteng dekorasyon sa iyong bahay.\r\nMaliwanag na Ilaw: Tamang-tamang liwanag na hindi nakakasilaw, perpekto para sa pagbabasa o sa paglikha ng mainit na ambiance.\r\nMatibay na Materyales: Gawa sa de-kalidad na materyales na siguradong tatagal sa mahabang panahon.\r\nEnergy-Efficient: Makatipid sa kuryente gamit ang LED technology na eco-friendly at matipid sa konsumo.\r\nMula sa klasikal na istilo hanggang sa modernong disenyo, ang aming lampara ay hindi lang nagbibigay-liwanag, kundi nagbibigay-halaga sa kabuuan ng iyong tahanan.', 'https://res.cloudinary.com/dkympjwqc/image/upload/v1729571046/lampara_sexgdv.jpg', 150.00, 0.0, 120, 2, 7, NULL, '2024-10-24 02:20:47.242554', '0000-00-00 00:00:00.000000'),
(2, 'BARONG TAGALOG', 'Gawang Pilipino, dekalidad, at mura pa', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1726758220/barong1_y9rx6j.jpg', 400.00, 0.0, 100, 1, 5, NULL, '2024-10-24 02:20:47.325875', '0000-00-00 00:00:00.000000'),
(3, 'Abaca Walis', 'Matibay na walis na gawa sa abaca para sa pang matagalang gamitan', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755498/images_8_jrcqxg.jpg', 80.00, 0.0, 52, 2, 7, NULL, '2024-10-24 02:20:47.333636', '0000-00-00 00:00:00.000000'),
(4, 'Maria Clara kostyum', 'Kostyum pandula-dulaan', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755498/images_9_bna55s.jpg', 120.00, 0.0, 33, 1, 4, NULL, '2024-10-24 02:20:47.340618', '0000-00-00 00:00:00.000000'),
(5, 'Baro\'t Saya', 'Makapal na tela at magandang disenyo', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755500/images_10_lj1hgu.jpg', 300.00, 0.0, 22, 1, 4, NULL, '2024-10-24 02:20:47.347331', '0000-00-00 00:00:00.000000'),
(6, 'Baro\\\'t Saya', 'Makapal na tela at magandang disenyo', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755500/sg-11134201-7rbl7-lphyvpv8ozzrd1_urimz9.jpg', 300.00, 0.0, 12, 1, 4, NULL, '2024-10-24 02:20:47.360998', '0000-00-00 00:00:00.000000'),
(7, 'Dibayder Matibay', 'Dekalidad na materyal para sa dekalidad na dibayder', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755497/images_11_uwqhy2.jpg', 750.00, 0.0, 7, 3, 7, NULL, '2024-10-24 02:20:47.368953', '0000-00-00 00:00:00.000000'),
(8, 'Last Supper', 'Dekorasyon sa bahay na magpapaganda sa araw ng mga naninirahan dito', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755497/images_12_jvqsgw.jpg', 400.00, 0.0, 32, 2, 7, 1, '2024-11-18 04:46:54.329300', '0000-00-00 00:00:00.000000'),
(9, 'Last Supper carved makintab', 'Magandang ukit ng \"the Last Supper\"', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755498/images_13_q68vxb.jpg', 1000.00, 0.0, 7, 2, 7, 1, '2024-11-18 04:46:54.465181', '0000-00-00 00:00:00.000000'),
(10, 'Last Supper carved', 'Sopistikadong ukit ng sikat na pinta na \"The Last Supper\"', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755498/NTII_SKH_1196294-001_yxnt2y.jpg', 1350.00, 0.0, 4, 2, 7, 1, '2024-11-18 04:46:54.484612', '0000-00-00 00:00:00.000000'),
(11, 'Plantsa', 'Makalumang plantsa at matibay kaya\'t ito\'y pang matagalan', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755498/images_14_jnv4hs.jpg', 100.00, 0.0, 23, 2, 7, NULL, '2024-10-24 02:23:41.049336', '0000-00-00 00:00:00.000000'),
(12, 'Pogs Asorted', 'Laruang pambata', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755499/images_15_dmzdjs.jpg', 20.00, 0.0, 46, 3, 10, NULL, '2024-10-24 02:23:41.064599', '0000-00-00 00:00:00.000000'),
(13, 'Barong', 'Magandang disenyo para sa mga pormal na event na dadaluhan', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1726759243/barong2_uq26uc.jpg', 350.00, 0.0, 56, 1, 5, NULL, '2024-10-24 02:23:41.071189', '0000-00-00 00:00:00.000000'),
(14, 'Pogs Amongus', 'Pogs na may disenyon ng larong \"Among us\"', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755498/images_16_qrguqe.jpg', 25.00, 0.0, 12, 3, 10, NULL, '2024-10-24 02:23:41.082517', '0000-00-00 00:00:00.000000'),
(15, 'Teks', 'Pang malakasang itsa ng teks ba galawan mo? bakit hindi mo bilhin ang teks na \'to', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755499/images_17_jdx7xv.jpg', 10.00, 0.0, 19, 2, 10, NULL, '2024-10-24 02:23:41.088988', '0000-00-00 00:00:00.000000'),
(16, 'Teks isang box', 'Teks na isang box ang dami', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755499/images_18_udshau.jpg', 40.00, 0.0, 11, 2, 10, NULL, '2024-10-24 02:23:41.104278', '0000-00-00 00:00:00.000000'),
(17, 'Paper Doll (apat na balot)', 'Magaganda paper doll kada balot', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755499/images_19_mijyo1.jpg', 70.00, 0.0, 17, 2, 10, NULL, '2024-10-24 02:23:41.114609', '0000-00-00 00:00:00.000000'),
(18, 'Paper doll per pack', 'Laruan para sa ating mga dalaginding', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755499/images_20_pc4iqb.jpg', 20.00, 0.0, 7, 2, 10, NULL, '2024-10-24 02:23:41.120667', '0000-00-00 00:00:00.000000'),
(19, 'Daster pang nanay', '', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1726759507/daster1_wkhdye.jpg', 120.00, 0.0, 34, 1, 4, NULL, '2024-10-24 02:23:41.132283', '0000-00-00 00:00:00.000000'),
(20, 'Pamaypay na makulay', 'Matibay at magandang pamaypay', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755498/colorful-pamaypay-filipino-fan-multicolor-tulay-barong-warehouse_5d87a220-d60e-4228-a1ea-f5963d8ac8b5_b6y1xx.jpg', 50.00, 0.0, 78, 2, 10, 2, '2024-11-19 01:29:12.005559', '0000-00-00 00:00:00.000000'),
(21, 'Pamaypay Asorted', 'Magandang pamaypay para sa tag-init', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755497/images_3_v58oyn.jpg', 25.00, 0.0, 34, 0, 2, 2, '2024-11-19 01:29:12.049730', '0000-00-00 00:00:00.000000'),
(22, 'Pamayapay simple', 'Murang pamaypay at matibay ', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755497/images_4_mziy1t.jpg', 15.00, 0.0, 35, 0, 2, 2, '2024-11-19 01:29:12.058478', '0000-00-00 00:00:00.000000'),
(23, 'Bakya (simple)', 'Sapin sa paa ng mga magaganda', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755497/images_5_jk7tvt.jpg', 70.00, 0.0, 51, 0, 2, NULL, '2024-10-23 13:54:09.602687', '0000-00-00 00:00:00.000000'),
(24, 'Walis Tambo', 'Matibay na kahoy kaya makakasiguradong dekalidad', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755497/images_6_nguuav.jpg', 50.00, 0.0, 23, 0, 7, NULL, '2024-10-23 13:54:09.614984', '0000-00-00 00:00:00.000000'),
(25, 'Walis tambo (bulto)', 'Magagandang kalidad ng walis tambo, makakamura ka na at makakamura ka', 'https://res.cloudinary.com/damtc4g0q/image/upload/v1727755498/images_7_irlndl.jpg', 175.00, 0.0, 20, 0, 7, NULL, '2024-10-23 13:54:09.631264', '0000-00-00 00:00:00.000000'),
(26, 'Modernong Disenyo ng Pamaypay', 'Ang aming modernong pamaypay ay pinagsasama ang tradisyonal na ganda at makabagong istilo. Gawa sa matibay at magaan na materyales, ang pamaypay na ito ay may minimalistang disenyo na may malinis at eleganteng mga linya, perpekto para sa mga taong mayroong modernong pananaw.\r\n\r\nMayroon itong ergonomikong hawakan para sa komportableng paggamit, habang ang malawak at maayos na mga talulot ay nagbibigay ng mabisang hangin sa bawat galaw. Ang disenyong ito ay hindi lamang praktikal, kundi isa ring fashion statement—nababagay sa anumang kasuotan, mula sa casual hanggang sa formal na okasyon.\r\n\r\nMagaan dalhin at madaling isama sa bag o bulsa, ang pamaypay na ito ay ang perpektong kasama sa mainit na panahon o kahit saan ka magpunta.', 'https://res.cloudinary.com/dkympjwqc/image/upload/v1729573045/abaniko_jn19kw.png', 35.00, 0.0, 120, 2, 10, NULL, '2024-10-24 02:24:53.303128', '2024-10-22 09:11:36.000000'),
(27, 'Pancit Canton', 'Ang Pancit Canton ay isang masarap at mabilis na lutuing instant noodle na perpekto para sa anumang oras ng pagkain. Gawa mula sa mataas na kalidad na sangkap, ang mga pansit ay malambot at puno ng lasa sa bawat kagat. Madali itong ihanda sa loob ng ilang minuto lamang—pakuluan, alisan ng tubig, ihalo sa espesyal na sauce at seasoning, at handa na!\r\n\r\nTamang-tama ito bilang meryenda o kasabay ng ulam para sa mas nakabubusog na kainan. Available sa iba\'t ibang flavor tulad ng Chilimansi, Calamansi, at Sweet & Spicy, ang Pancit Canton ay siguradong magbibigay ng kasiyahan sa iyong panlasa.\r\n\r\nPampatanggal-gutom, mabilis, at abot-kaya—ito ang Pancit Canton, hatid ang klasikong sarap na paborito ng mga Pinoy!', 'https://res.cloudinary.com/dkympjwqc/image/upload/v1729573362/pc_u1gmrw.png', 25.00, 0.0, 100, 3, 13, NULL, '2024-10-24 02:24:53.326129', '2024-10-22 09:31:59.000000'),
(28, 'Tocino', 'Ang Tocino ay isang paboritong pagkaing Pilipino, kilala sa tamis at lambot nito. Ginawa mula sa malinamnam na karne ng baboy na marinated sa masarap na timpla ng asukal, asin, at mga pampalasa, ang tocino ay nagbibigay ng tamang balanse ng tamis at alat.\r\n\r\nMadaling lutuin, ito ay perpektong ihain bilang almusal kasama ng mainit na kanin at itlog, ngunit masarap din itong tangkilikin sa anumang oras ng araw.\r\n\r\nTampok:\r\n\r\nPinatamis at pinalambot gamit ang tradisyonal na paraan ng pag-marinade\r\nGinawa mula sa mataas na kalidad na karne ng baboy\r\nPerpekto para sa almusal o kahit anong pagkain\r\nMadaling lutuin at mabilis ihain\r\nTikman ang lutong bahay na sarap ng tocino na siguradong magugustuhan ng buong pamilya!', 'https://res.cloudinary.com/dkympjwqc/image/upload/v1729582762/tocino_qhp9kj.jpg', 60.00, 0.0, 50, 3, 11, NULL, '2024-10-23 13:55:07.823763', '0000-00-00 00:00:00.000000'),
(29, 'Afritada', '\r\nAng Afritada ay isang masarap na pagkaing Pilipino na nagtatampok ng malambot na karne, karaniwang manok o baboy, na niluluto sa makulay na sarsa na gawa sa kamatis. Ito ay sinamahan ng sari-saring gulay tulad ng patatas, carrots, at bell peppers, na nagbibigay ng tamang timpla ng lasa at texture. Ang bawat kagat ay puno ng masarap na lasa ng tangy tomato sauce na may halong bahagyang tamis at alat. Ang Afritada ay isang klasikong ulam na paborito sa mga hapag-kainan ng mga Pilipino, perpektong ihain kasama ng mainit na kanin para sa isang pusong busog at nakakaganang pagkain.', 'https://res.cloudinary.com/dkympjwqc/image/upload/v1729583855/afritada_bpvjff.jpg', 30.00, 0.0, 50, 3, 11, NULL, '2024-10-23 13:55:07.836654', '0000-00-00 00:00:00.000000'),
(30, 'Parol ', 'Makulay na Parol para sa Pasko\r\n\r\nIhandog ang ganda ng tradisyon ng Pasko sa inyong tahanan gamit ang aming makulay na parol! Ang parol ay simbolo ng liwanag at pag-asa, at perpektong dekorasyon para sa bawat tahanan o establisyemento tuwing kapaskuhan.\r\n\r\nMga Tampok:\r\n\r\nMataas na kalidad: Ginawa mula sa matibay na materyales, siguradong tatagal at maaaring gamitin taon-taon.\r\nMakulay na disenyo: Ipinagmamalaki ang makukulay na papel at ilaw na nagpapaliwanag sa gabi.\r\nIba\'t ibang laki at estilo: May iba\'t ibang disenyo at sukat upang bumagay sa inyong espasyo at tema ng dekorasyon.\r\nMadaling i-install: May kasamang mga hook at kurdon para sa mabilis at madaling pagbitin sa anumang bahagi ng bahay.\r\nEco-friendly: Ginawa gamit ang environment-friendly na mga materyales, kaya\'t ligtas gamitin at may malasakit sa kalikasan.\r\nMula sa tradisyonal hanggang sa modernong disenyo, ang aming parol ay magdadala ng kakaibang liwanag at saya sa inyong Pasko. Mag-order na ngayon at simulan na ang masayang pagdiriwang!', 'https://res.cloudinary.com/dkympjwqc/image/upload/v1729584344/parol_hwpxp2.jpg', 250.00, 0.0, 70, 2, 10, NULL, '2024-10-23 13:55:07.845815', '2024-10-22 10:09:12.000000');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL COMMENT 'unique identifier for each review',
  `product_id` varchar(15) NOT NULL COMMENT 'the product was reviewed',
  `user_id` int(11) NOT NULL COMMENT 'the user who submitted the review',
  `rating` int(6) NOT NULL COMMENT 'user''s rating (between 1 and 5)',
  `comment` text NOT NULL COMMENT 'the written review by the user',
  `review_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'date and time the review was submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `review_date`) VALUES
(1, '1', 17, 4, 'ganda', '2024-11-19 12:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(6) NOT NULL COMMENT 'Unique identifier for roles',
  `role_name` varchar(10) NOT NULL COMMENT 'Role name(‘Customer’, ‘Admin’)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'User'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `cart_id` int(11) NOT NULL COMMENT 'Unique identifier for each cart.',
  `user_id` int(11) NOT NULL COMMENT 'ID of the user who owns the cart.',
  `product_id` varchar(11) NOT NULL COMMENT 'ID of the product in the cart.',
  `quantity` int(11) NOT NULL COMMENT 'The quantity of the product in the cart.',
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6) COMMENT 'Date and time the product was added to the cart.',
  `updated_at` datetime(6) NOT NULL COMMENT 'Unique identifier for each cart.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 16, '3', 3, '2024-11-19 06:13:19.453870', '2024-11-19 07:13:19.000000'),
(2, 1, '14', 1, '2024-11-18 23:54:13.000000', '2024-11-19 07:54:13.000000'),
(3, 17, '13', 1, '2024-11-19 04:20:00.000000', '2024-11-19 12:20:00.000000'),
(4, 16, '2', 1, '2024-11-19 04:54:50.000000', '2024-11-19 12:54:50.000000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'Unique identifier for each user.',
  `username` varchar(50) NOT NULL COMMENT 'The username chosen by the user.',
  `password` varchar(100) NOT NULL COMMENT 'The hashed password of the user.',
  `email` varchar(50) NOT NULL COMMENT 'User''s email address.',
  `first_name` varchar(30) NOT NULL COMMENT 'User''s email address.',
  `last_name` varchar(30) NOT NULL COMMENT 'User''s last name',
  `phone_number` int(10) NOT NULL COMMENT 'User''s contact phone number.',
  `address` text NOT NULL COMMENT 'User''s shipping address.',
  `role_id` int(6) NOT NULL COMMENT 'The role of the user (either customer or admin).',
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) COMMENT 'Date and time the user account was created.',
  `updated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) COMMENT 'Date and time the user account was updated',
  `profile_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `phone_number`, `address`, `role_id`, `created_at`, `updated_at`, `profile_link`) VALUES
(1, 'geripineda', '$2y$10$F1OJOIsb457z2nSb61AdzuoN.5QFLDt2MA8pX0I9Vu31Pxlx9UyYG', 'geri@gmail.com', 'geri', 'pineda', 2147483647, 'guiguinto bulacan', 1, '2024-10-14 01:59:24.433771', '2024-10-14 01:59:24.433771', NULL),
(2, 'pinedageri', '$2y$10$.BXwFpO3KN3sZB.vLx0GxOmULA4hQ4CUa2hQR.kB4RWAJF9Ww0dA2', 'pineda@gmail.com', 'geri', 'pineda', 2147483647, 'guiguinto bulacan', 1, '2024-10-14 02:05:40.041593', '2024-10-14 02:05:40.041593', NULL),
(3, 'bjashley', '$2y$10$29zWcW2WcNUvmrAMF3WmA.JjJWFq5u8Hb6kdAYfWfBEQi.13M92Yu', 'admin@example.com', 'BJ Ashley', 'Mercado', 0, '', 2, '2024-10-14 02:18:30.354486', '2024-10-14 02:18:30.354486', NULL),
(4, 'thisisgeri', '$2y$10$4E0DP8UxlIuQSFo7geWvr.0MSZTm0Pjiwrxz0GtLjKBgti0xGHBy6', 'thisisgeri@gmail.com', 'geri', 'pineda', 2147483647, 'guiguinto bulacan', 1, '2024-10-22 06:04:11.382651', '2024-10-22 06:04:11.382651', NULL),
(5, 'gerigeezelle', '$2y$10$rIDCF30sbtvlL.mkcjpVvu.QSSa9AXUpg.SNbBM1lICN4IgYf/dY.', 'gerigeezelle@gmail.com', 'geezelle', 'pineda', 2147483647, 'guiguinto bulacan', 1, '2024-10-22 06:08:59.366514', '2024-10-22 06:08:59.366514', NULL),
(6, 'greizelle', '$2y$10$H3vIYfhP3/RoR13FNy5aZOUovxcfseg6ipcFdwwfdxwN62yT9ktju', 'greizelle@gmail.com', 'greizelle', 'pineda', 2147483647, 'guiguinto bulacan', 1, '2024-10-22 06:19:48.148406', '2024-10-22 06:19:48.148406', NULL),
(7, 'acdefgh', '$2y$10$15RBTEAyZvaKtcz0t6WEMOj5lCN2s6TO52YzbgytnHv5W45EgFTyq', 'acdefgh@gmail.com', 'acdefgh', 'acdefgh', 1234567891, 'asdddsfdsfadsfs', 1, '2024-10-22 06:22:30.365567', '2024-10-22 06:22:30.365567', NULL),
(8, 'ayawkona', '$2y$10$Bj.jD35GXVF4eMYV34QHau21ECOx2lhQ/e8SmE21DxCwr/plvcxRe', 'ayawkona@gmail.com', 'ayawkona', 'ayawkona', 1234567891, 'asdddsfdsfadsfs', 1, '2024-10-22 06:28:07.240347', '2024-10-22 06:28:07.240347', NULL),
(9, 'sukonako', '$2y$10$6TC9EYSK1Q2qOr9/xjHPbugLUYJGLz1OpwRho8IIsWEdz8/3rPViC', 'sukonako@gmail.com', 'sukonako', 'sukonako', 1234567891, 'asdddsfdsfadsfs', 1, '2024-10-22 06:29:12.216829', '2024-10-22 06:29:12.216829', NULL),
(10, 'birthday', '$2y$10$n6V7DHEfmT0v9iagWVjfI.LvK.KZjD2HXrHprdBGCwBenVE.ZWALG', 'birthday@gmail.com', 'birthday', 'birthday', 1234567891, 'asdddsfdsfadsfs', 1, '2024-10-22 06:30:45.238391', '2024-10-22 06:30:45.238391', NULL),
(16, 'jayjayjay', '$2y$10$g8vrBR2jIYZL9mYayMToBOzgLFNCwVpkO08l5vuXUpkegrpHD7mw.', 'jay@gmail.com', 'jay', 'jay', 1231231234, 'mapulang lupa', 1, '2024-10-23 09:59:14.131629', '2024-10-23 09:59:14.131629', NULL),
(17, 'sample1', '$2y$10$sh69OVniOJ9/jTNwP/gq2OTCKMGdL/TA/VJZsSWY4aLeWYbsXMEIm', 'sample1@gail.com', 'sam', 'pol', 1234567890, 'sampol', 1, '2024-11-19 10:23:25.854027', '2024-11-19 10:23:25.854027', NULL),
(18, 'sample2', '$2y$10$1vXHIlfQceprDlisExoN0e4HX9GcdO8v3tcaUxrpveUJtim4KY6cq', 'sample2@gmail.com', 'sam', 'pol', 1234567890, 'sampol', 1, '2024-11-19 10:28:51.604047', '2024-11-19 10:28:51.604047', NULL),
(19, 'ash_ash', '$2y$10$Dof8x95WLx3hjmcQOu8ZheSIcNhyxHP68Mtu.C2l4g/JGXQX5i4cq', 'ash_ash@gmail.com', 'ashley', 'baltazar', 2147483647, 'mapulang lupa', 1, '2025-02-04 09:37:01.437662', '2025-02-04 09:37:01.437662', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `fk_parent` (`parent_id`);

--
-- Indexes for table `language_translations`
--
ALTER TABLE `language_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `fk_lks_prdct_id` (`product_id`),
  ADD KEY `fk_lks_user_id` (`user_id`);

--
-- Indexes for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_op_user_id` (`user_id`),
  ADD KEY `fk_op_prdct_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `address` (`shipping_address`(768)),
  ADD KEY `fk_userid` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `fk_order_id` (`order_id`),
  ADD KEY `fk_productid` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category_id` (`category_id`),
  ADD KEY `fk_prdcts_prnt_ctgry` (`parent_category`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each category.', AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `language_translations`
--
ALTER TABLE `language_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each order.', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier for each order item', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier for each payment';

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each product.', AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique identifier for each review', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each cart.', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each user.', AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_lks_prdct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `fk_lks_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD CONSTRAINT `fk_op_prdct_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `fk_op_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_orders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
