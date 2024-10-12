-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 12, 2024 at 06:53 PM
-- Server version: 5.0.27
-- PHP Version: 5.2.1
-- 
-- Database: `cafe_solstice`
-- 

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `address`, `saved_payment`, `profile_picture`, `first_name`, `last_name`) VALUES 
(1, 'paultest1', 'paultest1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-10-12 14:41:06', '123 test madilim 6666666666666666666666666666666', '69 69 420', '1728737660_phy13.jpg', 'paul', 'test'),
(2, 'paultest2', 'paultest2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-10-12 14:44:07', 'tulok 123', '10012002', NULL, '', ''),
(4, 'paultest3', 'paultest3@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-12 21:17:43', '123 123 6969 madilim', '1111444455558888', '1728739086_phy12.jpg', 'Paul3', 'Test3');
