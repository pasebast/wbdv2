-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 13, 2024 at 11:04 AM
-- Server version: 5.0.27
-- PHP Version: 5.2.1
-- 
-- Database: `cafe_solstice`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

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
(39, 24, 'Solstice Berry Bliss', 1, 150.00, 'images/menu01.png');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

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
(24, 4, 'ORD670ba48b116b0', '2024-10-13 10:44:27', 168.00, 'Unknown');

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
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `address`, `saved_payment`, `profile_picture`, `first_name`, `last_name`) VALUES 
(1, 'paultest1', 'paultest1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-10-12 14:41:06', '123 test madilim 6666666666666666666666666666666', '6969696969696969', '1728737660_phy13.jpg', 'paul', 'test'),
(2, 'paultest2', 'paultest2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-10-12 14:44:07', 'tulok 123', '1001200223423412', '', 'paul2', 'test2'),
(4, 'paultest3', 'paultest3@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-12 21:17:43', '123 123 6969 madilim', '6969420069694200', '1728739086_phy12.jpg', 'Paul3', 'Test3'),
(5, 'paultest4', 'paultest4@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-13 03:53:14', '897234k kkk kkkk 69  69 69', '1234123412341234', '1728763128_phy25.jpg', 'Paul4', 'Test4'),
(6, 'paultest5', 'paultest5@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-13 04:07:47', '123 123 123 123 aaaa', '1235123512351235', '', 'Paul5', 'Test5'),
(7, 'paultest6', 'paultest6@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-13 04:23:44', '666666 test', '1238123812381238', '', 'Paul6', 'Test6');

-- 
-- Constraints for dumped tables
-- 

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
