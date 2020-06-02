-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2020 at 06:42 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anothershop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `image` text COLLATE utf8_unicode_ci,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `price` float(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active | 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `name`, `description`, `price`, `created`, `modified`, `status`) VALUES
(1, 'images/foods/lomi.jpg', 'Lomi Plain', 'Plain but yummy enough to crave you for more.', 15.00, '2020-06-01 01:00:00', '0000-00-00 00:00:00', '1'),
(2, 'images/foods/lomir.jpg', 'Lomi Regular', 'So you want some more than just a plain.', 20.00, '2020-06-01 01:00:00', '0000-00-00 00:00:00', '1'),
(3, 'images/foods/lomig.jpg', 'Lomi Large', 'Now your were talking, Let\'s fill thy tummy.', 25.00, '2020-06-01 01:00:00', '0000-00-00 00:00:00', '1'),
(4, 'images/foods/lomix.jpg', 'Lomi Xtra Large', 'You must be really hungry, have some more.', 30.00, '2020-06-01 01:00:00', '0000-00-00 00:00:00', '1'),
(5, 'images/foods/lomij.jpg', 'Lomi Jumbo', 'You decided to share it to your friends or love one huh.', 60.00, '2020-06-01 01:00:00', '0000-00-00 00:00:00', '1'),
(6, 'images/foods/lugaw.jpg', 'Lugaw Plain', 'Plain but can make you slurp good.', 15.00, '2020-06-01 01:00:00', '0000-00-00 00:00:00', '1'),
(7, 'images/foods/lugawE.jpg', 'Lugaw w/ Egg', 'Lugaw with her side kick the egg.', 20.00, '2020-06-01 01:00:00', '0000-00-00 00:00:00', '1'),
(8, 'images/foods/lugawwc.jpg', 'Lugaw Egg w/ Chicken', 'Lugaw with egg and it\'s mommy, chicken.', 30.00, '2020-06-01 01:00:00', '0000-00-00 00:00:00', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
