-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Nov 09, 2024 at 05:55 PM
-- Server version: 5.0.27
-- PHP Version: 5.2.1
-- 
-- Database: `cafe_solstice`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `deactivation_requests`
-- 

CREATE TABLE `deactivation_requests` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `deactivation_requests`
-- 

INSERT INTO `deactivation_requests` (`id`, `username`, `email`, `reason`, `message`, `created_at`) VALUES 
(1, 'paultest1', 'paultest1@gmail.com', 'Privacy Concerns', 'testing ulit', '2024-10-27 00:24:25'),
(2, 'paultest1', 'paultest1@gmail.com', 'Not Satisfied with Service', 'pharmacy â™¥', '2024-10-27 00:39:22'),
(3, 'paultest1', 'paultest1@gmail.com', 'Switching to a Competitor', 'pharmacy 3-Y1-4 â™¥', '2024-10-27 00:46:21'),
(4, 'paultest1', 'paultest1@gmail.com', 'Switching to a Competitor', 'pharmacy â™¥', '2024-10-27 00:56:14'),
(5, 'paultest1', 'paultest1@gmail.com', 'Other', 'pharmacy â™¥aaaaaaaaaa', '2024-10-27 01:09:18'),
(6, 'paultest1', 'paultest1@gmail.com', 'Switching to a Competitor', 'pharmacy', '2024-10-27 01:13:23');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

-- 
-- Dumping data for table `email_verifications`
-- 

INSERT INTO `email_verifications` (`id`, `user_id`, `token`, `created_at`, `expires_at`) VALUES 
(1, 15, '0588c379396e296a9fba98913e703d68', '2024-10-18 22:22:19', '2024-10-19 14:22:19'),
(2, 15, '90449b02ad234ca85cde4b32cf56cdf2', '2024-10-18 23:01:50', '2024-10-19 15:01:50'),
(3, 16, '3fb133987da81d2530ec42c46ff6f5e8', '2024-10-18 23:21:41', '2024-10-19 15:21:41'),
(4, 17, 'a63926df9353808f165ebb7a6f78436e', '2024-10-18 23:25:16', '2024-10-19 15:25:16'),
(5, 17, '16377de30c73e9bf9f5894fe442138f4', '2024-10-18 23:25:46', '2024-10-19 15:25:46'),
(25, 35, '06572ad595922a97507bda9764ca79b2', '2024-10-25 21:34:05', '2024-10-26 13:34:05'),
(26, 16, '453b94d26830f2ec71b087a943e31b13', '2024-10-25 22:47:54', '2024-10-26 14:47:54'),
(27, 1, 'abd36cf5d883495d700591417fbe28a5', '2024-10-27 01:06:45', '2024-10-27 17:06:45'),
(28, 14, '7480842455efb89ce3d525412300dda9', '2024-10-29 23:26:16', '2024-10-30 15:26:16'),
(29, 8, '105765f9e69c5bba7f80189362df6feb', '2024-10-29 23:33:35', '2024-10-30 15:33:35'),
(30, 8, 'bb1bb6c7a000ceba3646d64c39da9dd0', '2024-10-29 23:46:15', '2024-10-30 15:46:15'),
(31, 8, '21902db3f32b2cf8fc6e611f8a92afca', '2024-10-29 23:49:31', '2024-10-30 15:49:31'),
(32, 8, 'b7da9b6dc6cb94e5600d9bb792b251c3', '2024-10-29 23:49:45', '2024-10-30 15:49:45'),
(33, 16, '6464cef6b75634617636811089408ea9', '2024-10-29 23:50:36', '2024-10-30 15:50:36'),
(34, 16, 'a0d742f985ff996c1fd29ecd9aeeb5b8', '2024-10-29 23:58:41', '2024-10-30 15:58:41'),
(35, 36, '8839747fee30962d4f7e2c28ec9101bf', '2024-10-31 12:03:04', '2024-11-01 04:03:04'),
(36, 37, '123a23bc22124aed06594bf5d8994ee2', '2024-10-31 12:05:51', '2024-11-01 04:05:51'),
(37, 38, '6bc770548e15d24f406d5db517acdd07', '2024-10-31 12:07:17', '2024-11-01 04:07:17'),
(38, 39, 'd0a09c2324eee2e0929053419b7d4263', '2024-10-31 12:10:23', '2024-11-01 04:10:23'),
(39, 40, '19a5f926b2cb2be339130ddf675536e3', '2024-11-02 01:11:57', '2024-11-02 17:11:57'),
(40, 41, '72058a185aaf7b1888a01c1873724172', '2024-11-02 16:18:37', '2024-11-03 08:18:37');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=146 ;

-- 
-- Dumping data for table `order_items`
-- 

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`, `image`) VALUES 
(114, 57, 'Eclipse Choco Delight', 1, 120.00, 'images/menu02.png'),
(115, 58, 'Sunrise Brew', 1, 80.00, 'images/menu05.png'),
(118, 61, 'Solstice Berry Bliss', 1, 150.00, 'images/menu01.png'),
(119, 61, 'Crimson Twilight Tea', 1, 110.00, 'images/menu07.png'),
(120, 62, 'Solstice Berry Bliss', 1, 150.00, 'images/menu01.png'),
(121, 62, 'Eclipse Choco Delight', 2, 120.00, 'images/menu02.png'),
(122, 63, 'Spring Water', 1, 80.00, 'images/menu13.png'),
(123, 64, 'Solstice Berry Bliss', 3, 150.00, 'images/menu01.png'),
(124, 64, 'Eclipse Choco Delight', 2, 120.00, 'images/menu02.png'),
(125, 64, 'Aurora Matcha Dream', 3, 190.00, 'images/menu03.png'),
(126, 64, 'Spring Water', 1, 80.00, 'images/menu13.png'),
(127, 65, 'Solstice Berry Bliss', 1, 150.00, 'images/menu01.png'),
(128, 65, 'Eclipse Choco Delight', 1, 120.00, 'images/menu02.png'),
(129, 65, 'Aurora Matcha Dream', 1, 190.00, 'images/menu03.png'),
(130, 65, 'Solstice Shot', 1, 100.00, 'images/menu04.png'),
(131, 65, 'Sunrise Brew', 1, 80.00, 'images/menu05.png'),
(132, 65, 'Dawn Flat White', 1, 120.00, 'images/menu06.png'),
(133, 65, 'Vanilla Breeze', 1, 100.00, 'images/menu10.png'),
(134, 65, 'Midday Cappuccino', 1, 130.00, 'images/menu11.png'),
(135, 65, 'Golden Hour Caramel', 1, 140.00, 'images/menu12.png'),
(136, 65, 'Crimson Twilight Tea', 1, 110.00, 'images/menu07.png'),
(137, 65, 'Vanilla Cloud', 1, 160.00, 'images/menu08.png'),
(138, 65, 'Zenith Grapefruit Tea', 1, 170.00, 'images/menu09.png'),
(139, 65, 'Spring Water', 1, 80.00, 'images/menu13.png'),
(140, 65, 'Horizon Wildberry Kombucha', 1, 160.00, 'images/menu14.png'),
(141, 65, 'Stellar Soy Cocoa', 1, 170.00, 'images/menu15.png'),
(142, 65, 'French Toast', 1, 110.00, 'images/menu16.png'),
(143, 65, 'Blueberry Cheesecake', 1, 160.00, 'images/menu17.png'),
(144, 65, 'Strawberry Tart Supreme', 1, 170.00, 'images/menu18.png'),
(145, 66, 'Classic Beef Lasagna', 1, 240.00, 'images/menu19.png');

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
  `address` varchar(255) default NULL,
  `cellphone_number` varchar(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- 
-- Dumping data for table `orders`
-- 

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `order_date`, `total_amount`, `saved_payment`, `address`, `cellphone_number`) VALUES 
(57, 35, 'ORD672f760ca36d8', '2024-11-09 22:47:40', 134.40, '2024-6894-2457-1234', 'Our Lady of Fatima University, Tamaraw Hills Road, Deato Subdivision, 2nd District, Valenzuela, Northern Manila District, Metro Manila, 0550, Philippines', '09053312618'),
(58, 35, 'ORD672f761208df1', '2024-11-09 22:47:46', 89.60, '2024-6894-2457-1234', 'Our Lady of Fatima University, Tamaraw Hills Road, Deato Subdivision, 2nd District, Valenzuela, Northern Manila District, Metro Manila, 0550, Philippines', '09053312618'),
(61, 1, 'ORD672f78434b2c7', '2024-11-09 22:57:07', 291.20, '6969-6969-6969-6969', 'SM North Edsa, Bago Bantay, 1st District, Quezon City, Eastern Manila District, Metro Manila, Philippines', '09241124578'),
(62, 1, 'ORD672f81f6ee92e', '2024-11-09 23:38:30', 436.80, '6969-6969-6969-6969', 'SM North Edsa, Bago Bantay, 1st District, Quezon City, Eastern Manila District, Metro Manila, Philippines', '09241124578'),
(63, 1, 'ORD672f81fe2f6e1', '2024-11-09 23:38:38', 89.60, '6969-6969-6969-6969', 'SM North Edsa, Bago Bantay, 1st District, Quezon City, Eastern Manila District, Metro Manila, Philippines', '09241124578'),
(64, 1, 'ORD672f835fd58eb', '2024-11-09 23:44:31', 1500.80, '6969-6969-6969-6969', 'SM North Edsa, Bago Bantay, 1st District, Quezon City, Eastern Manila District, Metro Manila, Philippines', '09241124578'),
(65, 1, 'ORD672f83b2050d3', '2024-11-09 23:45:54', 2710.40, '6969-6969-6969-6969', 'SM North Edsa, Bago Bantay, 1st District, Quezon City, Eastern Manila District, Metro Manila, Philippines', '09241124578'),
(66, 35, 'ORD672f8ddc3c25f', '2024-11-10 00:29:16', 268.80, '2024-6894-2457-1234', 'Our Lady of Fatima University, Tamaraw Hills Road, Deato Subdivision, 2nd District, Valenzuela, Northern Manila District, Metro Manila, 0550, Philippines', '09053312618');

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
-- Table structure for table `products`
-- 

CREATE TABLE `products` (
  `id` int(11) NOT NULL auto_increment,
  `category` varchar(50) default NULL,
  `image` varchar(255) default NULL,
  `name` varchar(100) default NULL,
  `description` text,
  `price` decimal(10,2) default NULL,
  `status` enum('active','hidden') default 'active',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- 
-- Dumping data for table `products`
-- 

INSERT INTO `products` (`id`, `category`, `image`, `name`, `description`, `price`, `status`) VALUES 
(1, 'frappe', 'images/menu01.png', 'Solstice Berry Bliss', 'A creamy and refreshing blend of strawberries and cream.', 150.00, 'active'),
(2, 'frappe', 'images/menu02.png', 'Eclipse Choco Delight', 'A rich and creamy chocolate chip frappÃ©.', 120.00, 'active'),
(3, 'frappe', 'images/menu03.png', 'Aurora Matcha Dream', 'A smooth and creamy green tea frappÃ©.', 190.00, 'active'),
(4, 'hotcoffee', 'images/menu04.png', 'Solstice Shot', 'Strong coffee shot.', 100.00, 'active'),
(5, 'hotcoffee', 'images/menu05.png', 'Sunrise Brew', 'Classic brewed coffee.', 80.00, 'active'),
(6, 'hotcoffee', 'images/menu06.png', 'Dawn Flat White', 'Smooth flat white coffee.', 120.00, 'active'),
(7, 'icedcoffee', 'images/menu10.png', 'Vanilla Breeze', 'A smooth cold brew infused with the light sweetness of vanilla cream, creating a refreshing experience as gentle as a solstice breeze.', 100.00, 'active'),
(8, 'icedcoffee', 'images/menu11.png', 'Midday Cappuccino', 'A crisp and invigorating iced cappuccino, perfect for a refreshing boost during the peak of your day.', 130.00, 'active'),
(9, 'icedcoffee', 'images/menu12.png', 'Golden Hour Caramel', 'A rich blend of smooth espresso, velvety milk, and sweet caramel drizzle, inspired by the golden light of the solsticeâ€™s sunset.', 140.00, 'active'),
(10, 'iceddrinks', 'images/menu07.png', 'Crimson Twilight Tea', 'A refreshing hibiscus tea with pomegranate pearls, inspired by the deep hues of twilight.', 110.00, 'active'),
(11, 'iceddrinks', 'images/menu08.png', 'Vanilla Cloud', 'A delightful fusion of bold black tea, coffee jelly, and smooth vanilla cold foam, this drink mirrors the soft clouds of the solstice sky.', 160.00, 'active'),
(12, 'iceddrinks', 'images/menu09.png', 'Zenith Grapefruit Tea', 'A vibrant iced tea blend of ruby grapefruit and honey, representing the peak of refreshment during the zenith.', 170.00, 'active'),
(13, 'bottleddrinks', 'images/menu13.png', 'Spring Water', 'Pure and refreshing, this bottled water captures the essence of a hidden spring.', 80.00, 'active'),
(14, 'bottleddrinks', 'images/menu14.png', 'Horizon Wildberry Kombucha', 'A crisp and invigorating kombucha with wildberry essence, inspired by the endless possibilities of the horizon.', 160.00, 'active'),
(15, 'bottleddrinks', 'images/menu15.png', 'Stellar Soy Cocoa', 'A velvety soy chocolate drink that offers a rich and indulgent experience, reminiscent of the sparkling beauty of the stars.', 170.00, 'active'),
(16, 'pastry', 'images/menu16.png', 'French Toast', 'Bread dipped in a rich egg mixture, pan-fried to golden perfection, and topped with a sprinkle of cinnamon and maple syrup.', 110.00, 'active'),
(17, 'pastry', 'images/menu17.png', 'Blueberry Cheesecake', 'Creamy cheesecake layered with fresh blueberries and a buttery graham cracker crust, topped with a luscious blueberry compote.', 160.00, 'active'),
(18, 'pastry', 'images/menu18.png', 'Strawberry Tart Supreme', 'A delicate, buttery tart shell filled with smooth vanilla custard, topped with vibrant, juicy strawberries and a glossy glaze.', 170.00, 'active');

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
  `role` enum('member','admin') NOT NULL default 'member',
  `cellphone_number` varchar(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `address`, `saved_payment`, `profile_picture`, `first_name`, `last_name`, `account_status`, `expiry_date`, `cvc`, `payment_token`, `role`, `cellphone_number`) VALUES 
(1, 'paultest1', 'paultest1@gmail.com', '072f684e153b48e80c68bf14f3098663', '2024-10-12 14:41:06', 'SM North Edsa, Bago Bantay, 1st District, Quezon City, Eastern Manila District, Metro Manila, Philippines', '6969-6969-6969-6969', '1730343420_phy13.jpg', 'paul', 'test', 'Active', '2026-10-01', '758', NULL, 'member', '09241124578'),
(2, 'paultest2', 'paultest2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-10-12 14:44:07', 'tulok 123', '1001200223423412', '', 'paul2', 'test2', 'Pending', NULL, NULL, NULL, 'member', ''),
(4, 'paultest3', 'paultest3@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-12 21:17:43', '123 123 6969 madilim', '6969420069694200', '1728739086_phy12.jpg', 'Paul3', 'Test3', 'Pending', NULL, NULL, NULL, 'member', ''),
(5, 'paultest4', 'paultest4@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-13 03:53:14', '897234k kkk kkkk 69  69 69', '1234123412341234', '1728763128_phy25.jpg', 'Paul4', 'Test4', 'Pending', NULL, NULL, NULL, 'member', ''),
(6, 'paultest5', 'paultest5@gmail.com', '670b14728ad9902aecba32e22fa4f6bd', '2024-10-13 04:07:47', '123 123 123 123 aaaa', '1234-1234-8888-6969', '1729865591_phy09.jpg', 'Paul5', 'Test5', 'Active', '2025-10-01', '107', NULL, 'member', ''),
(8, 'paultest7', 'ptsebastian6585val@student.fat', '596793c886612d7387008344222dc79c', '2024-10-16 23:05:15', '123 Tamaraw Hills', '', NULL, 'Paul7', 'Test7', 'Pending', NULL, NULL, NULL, 'member', ''),
(9, 'paultest8', 'paultest8@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', '2024-10-17 01:18:31', '123 Tamaraw Hills', '', NULL, 'Paul8', 'Test8', 'Pending', NULL, NULL, NULL, 'member', ''),
(10, 'paultest9', 'paultest9@gmail.com', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-17 01:20:48', '123 Tamaraw Hills', '', NULL, 'Paul9', 'Test9', 'Pending', NULL, NULL, NULL, 'member', ''),
(11, 'poltest6969696969', 'ptsebastian6585val@s', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 22:12:49', '123 Tamaraw Hills', '', NULL, 'pol1', 'tes1', 'Pending', NULL, NULL, NULL, 'member', ''),
(12, 'poltest16969696969', 'ptsebastian6585val@st', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 22:14:34', '123 Tamaraw Hills', '', NULL, 'pol1', 'tes1', 'Pending', NULL, NULL, NULL, 'member', ''),
(13, 'poltest14564564564', 'ptsebastian6585val@stu', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 22:16:11', '123 Tamaraw Hills', '', NULL, 'pol1', 'tes1', 'Pending', NULL, NULL, NULL, 'member', ''),
(14, 'poltest178757', 'ptse585val@student.fatima.edu.ph', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 22:21:04', '123 Tamaraw Hills', '', NULL, 'pol1', 'tes1', 'Pending', NULL, NULL, NULL, 'member', ''),
(15, 'poltest1sdf54564', 'ptsean6585v@studma.edu.ph', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 22:22:19', '123 Tamaraw Hills', '', NULL, 'pol1', 'tes1', 'Active', NULL, NULL, NULL, 'member', ''),
(16, 'paultest10', 'paul.dreadlike3@gmail.com', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 23:21:41', '123 Tamraw Hills', '', NULL, 'Paul10', 'Test10', 'Pending', NULL, NULL, NULL, 'member', ''),
(17, 'poltest2sdfs43252', '234anv@student.fatima.edu.ph', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-18 23:25:16', '123 Tamaraw Hills', '', NULL, 'Pol2', 'Test2', 'Active', NULL, NULL, NULL, 'member', ''),
(35, 'poltest1', 'ptsebastian6585val@student.fatima.edu.phg', '751cb3f4aa17c36186f4856c8982bf27', '2024-10-25 21:34:05', 'Our Lady of Fatima University, Tamaraw Hills Road, Deato Subdivision, 2nd District, Valenzuela, Northern Manila District, Metro Manila, 0550, Philippines', '2024-6894-2457-1234', '1730484513_phy48.jpg', 'pol', 'test', 'Active', '2025-12-01', '222', NULL, 'admin', '09053312618'),
(36, 'poltest6999', 'paultest11111@gmail.com', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-31 12:03:04', '6969 123 madilim', '', NULL, '     ', 'test', 'Pending', NULL, NULL, NULL, 'member', ''),
(37, 'poltest69999', 'paultest111111@gmail.com', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-31 12:05:51', '6969 123 madilim', '', NULL, '              ', 'test', 'Pending', NULL, NULL, NULL, 'member', ''),
(38, 'poltest6999999', 'paultest11111111@gmail.com', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-31 12:07:17', '6969 123 madilim', '', NULL, '              ', 'test', 'Pending', NULL, NULL, NULL, 'member', ''),
(39, 'poltest6999999999', 'paultest11111111111@gmail.com', 'd77d1c8fd85502a8fe5858da6bd44446', '2024-10-31 12:10:23', '6969 123 madilim', '', NULL, 'paul jr.', 'test', 'Pending', NULL, NULL, NULL, 'member', ''),
(40, 'paultest66', 'paultest66@gmail.com', '072f684e153b48e80c68bf14f3098663', '2024-11-02 01:11:57', 'SM City Grand Central, Rizal Avenue Extension, Barangay 88, Zone 8, Grace Park East, District 2, Caloocan, Northern Manila District, Metro Manila, 1403, Philippines', '1234-5555-6785-4785', '1730481486_rys01.jpg', 'paul gerald', 'sebastian', 'Active', '2028-10-01', '443', NULL, 'member', ''),
(41, 'paultest55', 'ptsebastian6585val@student.fatima.edu.ph', '072f684e153b48e80c68bf14f3098663', '2024-11-02 16:18:37', 'OLFU RISE Tower, Fatima Avenue, Deato Subdivision, 2nd District, Valenzuela, Northern Manila District, Metro Manila, 1441, Philippines', '1235-5554-7824-3458', '1730536749_phy41.jpg', 'Paul Test', 'Sebastian', 'Active', '2027-11-01', '743', NULL, 'member', '09885588877');

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
