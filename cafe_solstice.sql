-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 20, 2024 at 11:26 AM
-- Server version: 5.0.27
-- PHP Version: 5.2.1
-- 
-- Database: `cafe_solstice`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `email_verifications`
-- 

CREATE TABLE `email_verifications` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `email_verifications`
-- 

INSERT INTO `email_verifications` (`id`, `user_id`, `token`, `created_at`, `expires_at`) VALUES 
(1, 15, '0588c379396e296a9fba98913e703d68', '2024-10-18 22:22:19', '2024-10-19 14:22:19'),
(2, 15, '90449b02ad234ca85cde4b32cf56cdf2', '2024-10-18 23:01:50', '2024-10-19 15:01:50'),
(3, 16, '3fb133987da81d2530ec42c46ff6f5e8', '2024-10-18 23:21:41', '2024-10-19 15:21:41'),
(4, 17, 'a63926df9353808f165ebb7a6f78436e', '2024-10-18 23:25:16', '2024-10-19 15:25:16'),
(5, 17, '16377de30c73e9bf9f5894fe442138f4', '2024-10-18 23:25:46', '2024-10-19 15:25:46'),
(6, 18, 'a53e8994dd7321693d50b8f5de675fec', '2024-10-18 23:30:05', '2024-10-19 15:30:05'),
(7, 18, '369c3f634a6d61ca145b037c94232d93', '2024-10-18 23:30:29', '2024-10-19 15:30:29');

-- --------------------------------------------------------

-- 
-- Table structure for table `order_items`
-- 

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- 
-- Dumping data for table `order_items`
-- 

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`, `image`) VALUES 
(25, 18, 'Vanilla Breeze', 3, 100.00, 'images/menu10.png'),
(26, 18, 'Blueberry Cheesecake', 1, 160.00, 'images/menu17.png'),
(27, 19, 'French Toast', 1, 110.00, 'images/menu16.png'),
(28, 19, 'Strawberry Tart Supreme', 1, 170.00, 'images/menu18.png'),
(29, 19, 'Vanilla Cloud', 1, 160.00, 'images/menu08.png'),
(30, 19, 'Dawn Flat White', 1, 120.00, 'images/menu06.png'),
(31, 20, 'Eclipse Choco Delight', 1, 120.00, 'images/menu02.png'),
(32, 21, 'Solstice Berry Bliss', 4, 150.00, 'images/menu01.png'),
(33, 21, 'Eclipse Choco Delight', 1, 120.00, 'images/menu02.png'),
(34, 21, 'Vanilla Cloud', 1, 160.00, 'images/menu08.png'),
(35, 21, 'Strawberry Tart Supreme', 1, 170.00, 'images/menu18.png'),
(36, 22, 'Blueberry Cheesecake', 1, 160.00, 'images/menu17.png'),
(37, 23, 'Eclipse Choco Delight', 2, 120.00, 'images/menu02.png'),
(38, 23, 'Golden Hour Caramel', 1, 140.00, 'images/menu12.png'),
(39, 24, 'Solstice Berry Bliss', 1, 150.00, 'images/menu01.png'),
(40, 25, 'Solstice Berry Bliss', 1, 150.00, 'images/menu01.png'),
(41, 25, 'Vanilla Cloud', 1, 160.00, 'images/menu08.png'),
(42, 25, 'Crimson Twilight Tea', 2, 110.00, 'images/menu07.png'),
(43, 26, 'Eclipse Choco Delight', 1, 120.00, 'images/menu02.png'),
(44, 26, 'Aurora Matcha Dream', 1, 190.00, 'images/menu03.png'),
(45, 27, 'Eclipse Choco Delight', 1, 120.00, 'images/menu02.png'),
(46, 27, 'Aurora Matcha Dream', 1, 190.00, 'images/menu03.png'),
(47, 28, 'Solstice Berry Bliss', 1, 150.00, 'images/menu01.png'),
(48, 28, 'Dawn Flat White', 1, 120.00, 'images/menu06.png'),
(49, 29, 'Solstice Berry Bliss', 1, 150.00, 'images/menu01.png'),
(50, 29, 'Crimson Twilight Tea', 1, 110.00, 'images/menu07.png'),
(51, 30, 'Solstice Berry Bliss', 1, 150.00, 'images/menu01.png'),
(52, 30, 'Blueberry Cheesecake', 1, 160.00, 'images/menu17.png'),
(53, 31, 'Solstice Berry Bliss', 1, 150.00, 'images/menu01.png');

-- --------------------------------------------------------

-- 
-- Table structure for table `orders`
-- 

CREATE TABLE `orders` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `order_date` datetime NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `saved_payment` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- 
-- Dumping data for table `orders`
-- 

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `order_date`, `total_amount`, `saved_payment`) VALUES 
(18, 1, 'ORD670b9c59ab69d', '2024-10-13 10:09:29', 515.20, '1234567894545667'),
(19, 1, 'ORD670b9cc2834e4', '2024-10-13 10:11:14', 627.20, '1111111111111111'),
(20, 1, 'ORD670b9cf943c1b', '2024-10-13 10:12:09', 134.40, '1111111111111111'),
(21, 1, 'ORD670b9f1e210f0', '2024-10-13 10:21:18', 1176.00, '1111111111111111'),
(22, 1, 'ORD670b9fbd7ace3', '2024-10-13 10:23:57', 179.20, '6969696969696969'),
(23, 2, 'ORD670ba44c0722f', '2024-10-13 10:43:24', 425.60, '1001200223423412'),
(24, 4, 'ORD670ba48b116b0', '2024-10-13 10:44:27', 168.00, 'Unknown'),
(25, 4, 'ORD670bdce2059f7', '2024-10-13 14:44:50', 593.60, '6969420069694200'),
(26, 1, 'ORD6713c34f33a58', '2024-10-19 14:33:51', 347.20, '6969696969696969'),
(27, 1, 'ORD671485ed7d041', '2024-10-20 04:24:13', 347.20, '1111-1111-1111-1111'),
(28, 1, 'ORD67148613bbd71', '2024-10-20 04:24:51', 302.40, '1111-1111-1111-1111'),
(29, 1, 'ORD671486f83f463', '2024-10-20 04:28:40', 291.20, '1111-1111-1111-1111'),
(30, 1, 'ORD67148781de89f', '2024-10-20 04:30:57', 347.20, '1111-1111-1111-1111'),
(31, 1, 'ORD671487ae7721e', '2024-10-20 04:31:42', 168.00, '1111-1111-1111-1111');

-- --------------------------------------------------------

-- 
-- Table structure for table `password_resets`
-- 

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- 
-- Dumping data for table `password_resets`
-- 

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `expires_at`) VALUES 
(1, 8, '671c94e1ab0d16f30216ccf53bca6b61', '0000-00-00 00:00:00'),
(2, 8, 'a97fee7be907fde8dd1d8e89d5963d94', '0000-00-00 00:00:00'),
(3, 8, 'b361af75e626bed800dc51543633667c', '0000-00-00 00:00:00'),
(4, 8, '17bb4cd548a4f95a348140e3985c5563', '0000-00-00 00:00:00'),
(5, 8, '6b6606b4ebee54687c1715c0cbe2841d', '0000-00-00 00:00:00'),
(6, 8, 'be38d721490d2de68cd2a16b942fa1ec', '2024-10-17 16:27:09'),
(7, 8, '3110560fb58e6fbb5c3cc5446ca4595d', '2024-10-17 16:31:29'),
(8, 8, '05f0a71901c3e953346dd59420b926eb', '2024-10-17 16:35:23'),
(9, 8, '29526bc43a33e9447e7c0b66f05d73eb', '2024-10-17 16:35:28'),
(10, 8, '7998ecd303fa80fa69722e5ae01c1bf7', '2024-10-17 16:36:19'),
(11, 8, 'd72816441d85a3dd2021d844ed1a5f16', '2024-10-17 16:42:04'),
(12, 8, '0a6c665d86effa1d7842c843feb3cb96', '2024-10-17 16:45:28'),
(13, 8, '767b68233901a39cc9d2791eaef63c04', '2024-10-17 16:47:21'),
(17, 8, 'cfd7e5ca352f83908e626c2709ec2d36', '2024-10-17 17:03:12'),
(18, 15, 'd4da34e7c51f849b9742e7c559643062', '2024-10-19 15:10:38'),
(19, 15, 'afdac4ce51c69a493399353933f19297', '2024-10-19 15:12:39'),
(20, 15, '3fef7fa40729826b2c054149d6f2efa7', '2024-10-19 15:13:41'),
(21, 15, '830d42cbdfcf3b74b200cb8d16b04c4f', '2024-10-19 15:13:51'),
(22, 15, 'a5f48af01ed62697ef943ba311ae1b44', '2024-10-19 15:16:38'),
(23, 15, '5eab37405a6e3fef1a423c6cb575ec19', '2024-10-19 15:17:46');

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `address` varchar(255) default NULL,
  `saved_payment` varchar(255) default NULL,
  `profile_picture` varchar(255) default NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `account_status` enum('Active','Pending','Deactivated') default 'Pending',
  `expiry_date` date default NULL,
  `cvc` varchar(4) default NULL,
  `payment_token` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `address`, `saved_payment`, `profile_picture`, `first_name`, `last_name`, `account_status`, `expiry_date`, `cvc`, `payment_token`) VALUES 
(1, 'paultest1', 'paultest1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-10-12 14:41:06', '123 test madilim 6666666666666666666666666666666', '1111-1111-1111-1111', '1728737660_phy13.jpg', 'paul', 'test', 'Active', '2025-10-01', '823', NULL),
(2, 'paultest2', 'paultest2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-10-12 14:44:07', 'tulok 123', '1001200223423412', '', 'paul2', 'test2', 'Pending', NULL, NULL, NULL),
(4, 'paultest3', 'paultest3@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-12 21:17:43', '123 123 6969 madilim', '6969420069694200', '1728739086_phy12.jpg', 'Paul3', 'Test3', 'Pending', NULL, NULL, NULL),
(5, 'paultest4', 'paultest4@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-13 03:53:14', '897234k kkk kkkk 69  69 69', '1234123412341234', '1728763128_phy25.jpg', 'Paul4', 'Test4', 'Pending', NULL, NULL, NULL),
(6, 'paultest5', 'paultest5@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-13 04:07:47', '123 123 123 123 aaaa', '1235123512351235', '', 'Paul5', 'Test5', 'Pending', NULL, NULL, NULL),
(7, 'paultest6', 'paultest6@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-13 04:23:44', '666666 test', '1238123812381238', '', 'Paul6', 'Test6', 'Pending', NULL, NULL, NULL),
(8, 'paultest7', 'ptsebastian6585val@student.fat', '596793c886612d7387008344222dc79c', '2024-10-16 23:05:15', '123 Tamaraw Hills', '', NULL, 'Paul7', 'Test7', 'Pending', NULL, NULL, NULL),
(9, 'paultest8', 'paultest8@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', '2024-10-17 01:18:31', '123 Tamaraw Hills', '', NULL, 'Paul8', 'Test8', 'Pending', NULL, NULL, NULL),
(10, 'paultest9', 'paultest9@gmail.com', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-17 01:20:48', '123 Tamaraw Hills', '', NULL, 'Paul9', 'Test9', 'Pending', NULL, NULL, NULL),
(11, 'poltest6969696969', 'ptsebastian6585val@s', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 22:12:49', '123 Tamaraw Hills', '', NULL, 'pol1', 'tes1', 'Pending', NULL, NULL, NULL),
(12, 'poltest16969696969', 'ptsebastian6585val@st', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 22:14:34', '123 Tamaraw Hills', '', NULL, 'pol1', 'tes1', 'Pending', NULL, NULL, NULL),
(13, 'poltest14564564564', 'ptsebastian6585val@stu', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 22:16:11', '123 Tamaraw Hills', '', NULL, 'pol1', 'tes1', 'Pending', NULL, NULL, NULL),
(14, 'poltest178757', 'ptse585val@student.fatima.edu.ph', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 22:21:04', '123 Tamaraw Hills', '', NULL, 'pol1', 'tes1', 'Pending', NULL, NULL, NULL),
(15, 'poltest1sdf54564', 'ptsean6585v@studma.edu.ph', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 22:22:19', '123 Tamaraw Hills', '', NULL, 'pol1', 'tes1', 'Active', NULL, NULL, NULL),
(16, 'paultest10', 'paultest10@gmail.com', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 23:21:41', '123 Tamraw Hills', '', NULL, 'Paul10', 'Test10', 'Pending', NULL, NULL, NULL),
(17, 'poltest2sdfs43252', '234anv@student.fatima.edu.ph', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 23:25:16', '123 Tamaraw Hills', '', NULL, 'Pol2', 'Test2', 'Active', NULL, NULL, NULL),
(18, 'poltest1', 'ptsebastian6585val@student.fatima.edu.ph', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 23:30:05', '123 Tamaraw Hills', '', '', 'pol1', 'tes1', 'Pending', NULL, NULL, NULL);

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `email_verifications`
-- 
ALTER TABLE `email_verifications`
  ADD CONSTRAINT `email_verifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- 
-- Constraints for table `order_items`
-- 
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

-- 
-- Constraints for table `orders`
-- 
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- 
-- Constraints for table `password_resets`
-- 
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
