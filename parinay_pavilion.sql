-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 27, 2025 at 01:06 PM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 8.3.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parinay_pavilion`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `status`, `created_at`) VALUES
(1, 'Super Admin', 'admin@parinay.com', 'Admin@123', 1, '2025-12-22 04:21:55');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `time_slot` varchar(50) DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `booking_amount` decimal(10,2) NOT NULL,
  `second_amount` decimal(10,2) DEFAULT 0.00,
  `final_amount` decimal(10,2) DEFAULT 0.00,
  `paid_amount` decimal(10,2) DEFAULT 0.00,
  `booking_status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `property_id`, `booking_date`, `time_slot`, `guest_count`, `total_amount`, `booking_amount`, `second_amount`, `final_amount`, `paid_amount`, `booking_status`, `payment_status`, `created_at`) VALUES
(2, 1, 1, '2025-02-11', 'Day', 800, 150000.00, 50000.00, 0.00, 0.00, 50000.00, 'confirmed', 'partial', '2025-12-21 04:34:13'),
(3, 3, 2, '2025-12-21', 'Night', 150, 100000.00, 5200.00, 0.00, 0.00, 5200.00, 'confirmed', 'partial', '2025-12-21 06:00:22'),
(4, 3, 2, '2025-12-21', 'Day', 150, 100000.00, 5200.00, 0.00, 0.00, 5200.00, 'confirmed', 'partial', '2025-12-21 06:03:58'),
(5, 3, 2, '2025-12-20', 'Day', 150, 100000.00, 5200.00, 0.00, 0.00, 5200.00, 'confirmed', 'partial', '2025-12-21 06:08:48'),
(6, 3, 2, '2025-12-20', 'Night', 150, 100000.00, 5200.00, 0.00, 0.00, 5200.00, 'confirmed', 'partial', '2025-12-21 06:14:03'),
(7, 3, 1, '2025-12-22', 'Night', 200, 150000.00, 5206.00, 0.00, 0.00, 5206.00, 'confirmed', 'partial', '2025-12-21 06:15:22'),
(8, 3, 1, '2025-12-22', 'Day', 500, 150000.00, 2200.00, 0.00, 0.00, 2200.00, 'confirmed', 'partial', '2025-12-21 06:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `id` int(11) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`id`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'KALPIPARA Bhinga, Road, Near Awas Vikas Coloney, Bahraich, Uttarpradesh - 271802', '+91 9621973170', 'Info@parinaypavallion.com', '2025-12-20 06:45:31', '2025-12-22 10:54:17');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `mobile`, `email`, `message`, `created_at`) VALUES
(1, 'Akhilesh Kumar', '9999999999', 'akhilesh@gmail.com', 'I want to book a lawn for wedding.', '2025-12-20 07:03:06'),
(2, 'Et non provident to', '25', 'rejaq@mailinator.com', 'Inventore a iure rep', '2025-12-20 08:23:12'),
(3, 'Et non provident to', '25', 'rejaq@mailinator.com', 'Inventore a iure rep', '2025-12-20 08:26:39'),
(4, 'Voluptas ipsum quod', '35', 'parefifa@mailinator.com', 'Dignissimos mollitia', '2025-12-20 08:31:51'),
(5, 'Aut numquam itaque m', '79', 'xigyqo@mailinator.com', 'Laborum molestiae es', '2025-12-20 08:34:26'),
(6, 'Akhilesh Kumar', '07800302707', 'yadavakhilesh710@gmail.com', 'sdsafdgsdgjkglj;jlk', '2025-12-21 16:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`) VALUES
(1, 'AC'),
(2, 'WiFi'),
(3, 'Parking'),
(4, 'Power Backup'),
(5, 'Decoration'),
(6, 'Catering'),
(7, 'King Bed'),
(8, 'Balcony'),
(9, 'Bathtub');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` enum('lawn','hall','room','general') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image`, `type`, `created_at`) VALUES
(1, 'https://parinaypavallionadmin.codescarts.com/public/gallery/PP1.jpg', NULL, '2025-12-20 11:53:38'),
(2, 'https://parinaypavallionadmin.codescarts.com/public/gallery/PP2.jpg', NULL, '2025-12-20 11:53:10'),
(3, 'https://parinaypavallionadmin.codescarts.com/public/gallery/pp3.jpg', NULL, '2025-12-20 11:53:10'),
(4, 'https://parinaypavallionadmin.codescarts.com/public/gallery/pp4.jpg', NULL, '2025-12-20 11:53:10'),
(5, 'https://parinaypavallionadmin.codescarts.com/public/gallery/pp5.jpg', NULL, '2025-12-20 11:53:10'),
(6, 'https://parinaypavallionadmin.codescarts.com/public/gallery/pp6.jpg', NULL, '2025-12-20 11:53:10');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `payment_gateway` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(150) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('success','failed','pending') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('lawn','hall','room') NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `min_guests` int(11) DEFAULT 0,
  `max_guests` int(11) DEFAULT 0,
  `base_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_featured` tinyint(4) DEFAULT 0 COMMENT '1 = featured, 0 = normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `type`, `name`, `description`, `min_guests`, `max_guests`, `base_price`, `status`, `created_at`, `updated_at`, `is_featured`) VALUES
(1, 'lawn', 'Royal Garden Lawn', 'Open green lawn suitable for grand weddings', 200, 1000, 150000.00, 1, '2025-12-19 07:13:50', '2025-12-19 07:53:40', 1),
(2, 'lawn', 'Emerald Lawn', 'Premium lawn with night lighting', 150, 600, 100000.00, 1, '2025-12-19 07:13:50', '2025-12-19 07:53:40', 1),
(3, 'hall', 'Crystal Banquet Hall', 'Fully AC banquet hall for weddings & parties', 100, 400, 80000.00, 1, '2025-12-19 07:13:50', '2025-12-19 07:53:40', 1),
(4, 'hall', 'Golden Celebration Hall', 'Spacious hall with modern interiors', 80, 300, 60000.00, 1, '2025-12-19 07:13:50', '2025-12-19 07:13:50', 0),
(5, 'room', 'Deluxe Room', 'Luxury room with king bed and balcony', 1, 3, 4500.00, 1, '2025-12-19 07:13:50', '2025-12-19 07:13:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `property_availabilities`
--

CREATE TABLE `property_availabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time_slot` varchar(50) DEFAULT NULL,
  `is_available` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `property_availabilities`
--

INSERT INTO `property_availabilities` (`id`, `property_id`, `date`, `time_slot`, `is_available`) VALUES
(1, 1, '2025-02-10', 'Morning', 1),
(2, 1, '2025-02-10', 'Evening', 1),
(3, 2, '2025-02-10', 'Full Day', 1),
(4, 3, '2025-02-11', 'Morning', 1),
(5, 3, '2025-02-11', 'Evening', 0),
(6, 5, '2025-02-09', 'Full Day', 1),
(7, 1, '2025-02-10', 'Day', 0),
(8, 1, '2025-02-11', 'Day', 0),
(9, 2, '2025-12-21', 'Night', 0),
(10, 2, '2025-12-21', 'Day', 0),
(11, 2, '2025-12-20', 'Day', 0),
(12, 2, '2025-12-20', 'Night', 0),
(13, 1, '2025-12-22', 'Night', 0),
(14, 1, '2025-12-22', 'Day', 0);

-- --------------------------------------------------------

--
-- Table structure for table `property_facilities`
--

CREATE TABLE `property_facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `facility_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `property_facilities`
--

INSERT INTO `property_facilities` (`id`, `property_id`, `facility_id`) VALUES
(20, 1, 3),
(21, 1, 4),
(22, 1, 5),
(23, 1, 6),
(24, 2, 3),
(25, 2, 4),
(26, 2, 5),
(27, 3, 1),
(28, 3, 3),
(29, 3, 10),
(30, 3, 4),
(31, 4, 1),
(32, 4, 3),
(33, 4, 4),
(34, 5, 1),
(35, 5, 2),
(36, 5, 7),
(37, 5, 8),
(38, 5, 9);

-- --------------------------------------------------------

--
-- Table structure for table `property_features`
--

CREATE TABLE `property_features` (
  `id` bigint(20) NOT NULL,
  `property_id` bigint(20) DEFAULT NULL,
  `feature` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image`) VALUES
(1, 1, 'https://parinaypavallionadmin.codescarts.com/Public/property/1.jpeg'),
(2, 1, 'https://parinaypavallionadmin.codescarts.com/Public/property/2.jpeg'),
(3, 2, 'https://parinaypavallionadmin.codescarts.com/Public/property/3.jpeg'),
(4, 3, 'https://parinaypavallionadmin.codescarts.com/Public/property/4.jpeg'),
(5, 3, 'https://parinaypavallionadmin.codescarts.com/Public/property/5.jpeg'),
(6, 4, 'https://parinaypavallionadmin.codescarts.com/Public/property/6.jpeg'),
(7, 5, 'https://parinaypavallionadmin.codescarts.com/Public/property/7.jpeg'),
(8, 5, 'https://parinaypavallionadmin.codescarts.com/Public/property/7.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(100) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) DEFAULT 1 COMMENT '1=active, 0=inactive',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `icon`, `title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'https://cdn-icons-png.flaticon.com/512/1046/1046784.png', 'Catering', 'Multi-cuisine gourmet experience with customized menus for all events.', 1, '2025-12-19 07:36:43', '2025-12-19 07:40:13'),
(2, 'https://cdn-icons-png.flaticon.com/512/727/727245.png', 'Music & DJ', 'Professional sound systems with live DJ and music arrangements.', 1, '2025-12-19 07:36:43', '2025-12-19 07:40:13'),
(3, 'https://cdn-icons-png.flaticon.com/512/3063/3063822.png', 'Decor', 'Thematic floral and light decorations tailored to your event theme.', 1, '2025-12-19 07:36:43', '2025-12-19 07:40:13'),
(4, 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png', 'Planning', 'Dedicated event manager to plan and execute your event seamlessly.', 1, '2025-12-19 07:36:43', '2025-12-19 07:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `site_contact`
--

CREATE TABLE `site_contact` (
  `id` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1 COMMENT '1=active, 0=inactive',
  `createdAt` datetime DEFAULT current_timestamp(),
  `updatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `image`, `link`, `status`, `createdAt`, `updatedAt`) VALUES
(1, 'Grand Wedding Venue', 'https://parinaypavallionadmin.codescarts.com/Public/slider/slider1.jpg', NULL, 1, '2025-12-19 06:55:09', '2025-12-22 11:38:55');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `facebook`, `instagram`) VALUES
(1, 'https://www.facebook.com/yourprofile', 'https://www.instagram.com/yourprofile');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `password`, `created_at`) VALUES
(1, 'Akhilesh', 'akhilfc131@foundercodes.com', '7800302799', '$2b$10$SNAZe5pK1KkvcEgvBVaUeOeF/z57RoDpNadtTgQy.mRLe.GI30znm', NULL),
(2, 'Akhilesh', 'akhilfc1344@foundercodes.com', '7800302791', '$2b$10$CzekeyDIJBkrS6LbIkQ0U.Q0QsvT1p9izFL1WDhfc3v.teRIk5sPa', NULL),
(3, 'Vishal Mishra', 'vishal@gmail.com', '7570006440', '$2b$10$lT3KTTIMzXnP76CGQrvdUu9LL866M.GPLmZLF993pPnX9v7e4TTKi', NULL),
(4, 'Akhilesh yadav', 'yadav@gmail.com', '7800302701', '$2b$10$zLxbBUjdaIs.2ZBhfzSnFezaAlkI2QoqvODlZLPpB3.4u2geKehl.', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payments_booking` (`booking_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_availabilities`
--
ALTER TABLE `property_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `property_id` (`property_id`,`date`,`time_slot`);

--
-- Indexes for table `property_facilities`
--
ALTER TABLE `property_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Indexes for table `property_features`
--
ALTER TABLE `property_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_contact`
--
ALTER TABLE `site_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `property_availabilities`
--
ALTER TABLE `property_availabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `property_facilities`
--
ALTER TABLE `property_facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `property_features`
--
ALTER TABLE `property_features`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_availabilities`
--
ALTER TABLE `property_availabilities`
  ADD CONSTRAINT `property_availabilities_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_facilities`
--
ALTER TABLE `property_facilities`
  ADD CONSTRAINT `property_facilities_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `property_facilities_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_features`
--
ALTER TABLE `property_features`
  ADD CONSTRAINT `property_features_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
