-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2024 at 10:04 AM
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
-- Database: `onlinefoodphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `date`) VALUES
(1, 'admin', 'ad_11', 'admin@mail.com', '', '2024-09-02 14:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `rs_id`, `title`, `slogan`, `price`, `img`) VALUES
(1, 1, 'Chicken Patties', 'Chicken patties which melt in your mouth, and are quick and easy to make. Served hot with a crisp salad.', 1100.00, '62908867a48e4.jpg'),
(2, 1, 'Seafood Platter', 'A platter with Sea bass, Cuttlefish, Baked crab, Prawns, Tiger prawns. Served with garlic bread or grilled potatoes.', 1600.00, '629089fee52b9.jpg'),
(3, 4, 'Thandoori Chicken', 'Savory chicken pieces marinated in lemon juice, yogurt, and aromatic spices make this grilled tandoori chicken.', 800.00, '62908bdf2f581.jpg'),
(4, 1, 'Chicken Kottu', 'Thinly shredded roti mixed with the curry, vegetables and Sri Lankan aromatic spices.', 1000.00, '62908d393465b.jpg'),
(5, 2, 'Prawns Spaghetti', 'Spaghetti with prawns in a fresh tomato sauce. This dish originates from Southern Italy and with the combination of prawns, garlic, chilli and pasta.', 1600.00, '606d7491a9d13.jpg'),
(6, 2, 'Cheesy Lasagna', 'Fit our Better-than-Ever Cheesy Meat Lasagna made with cottage cheese, ground beef and pasta sauce.', 1800.00, '606d74c416da5.jpg'),
(7, 2, 'Crispy Chicken Strips', 'Fried chicken strips, served with special honey mustard sauce.', 1800.00, '606d74f6ecbbb.jpg'),
(8, 2, 'Chicken Spaghetti', 'Spaghetti with chicken in a fresh tomato sauce. This dish originates from Southern Italy and with the combination of prawns, garlic, chilli and pasta.', 1400.00, '606d752a209c3.jpg'),
(9, 3, 'Vegetable Fried Rice', 'Chinese rice wok with cabbage, beans, carrots, and spring onions.', 1200.00, '606d7575798fb.jpg'),
(10, 3, 'Coconut Roti', 'Pan grilled flatbread with freshly grated coconut with Butter.', 400.00, '606d75a7e21ec.jpg'),
(11, 3, 'Spring Rolls', 'Lightly seasoned shredded cabbage, onion and carrots, wrapped in house made spring roll wrappers, deep fried to golden brown.', 600.00, '606d75ce105d0.jpg'),
(12, 3, 'Chicken Curry', 'delicious, spicy, one-pot Indian chicken curry composed with gravy seasoned with a mixture of ground spices.', 900.00, '606d7600dc54c.jpg'),
(13, 0, 'Chicken Wings', 'Fried chicken wings tossed in spicy kochchi sauce served with crisp celery sticks and Blue cheese dip.', 900.00, '6702c60d8b762.jpg'),
(14, 4, 'Cheese Balls', 'Made with real cheese powder, these cheese balls are bound to get you hooked.', 1000.00, '606d768a1b2a1.jpg'),
(15, 4, 'Potato Salad', 'A hearty side dish that consists of potatoes, eggs, vegetables, and mayonnaise.', 600.00, '606d76ad0c0cb.jpg'),
(16, 3, 'Spicy Chicken Pasta', 'This Spicy Chicken Pasta is the perfect level of spice, whilst absolutely bursting with flavour.', 1500.00, '66d3fd8f9ad3d.png'),
(18, 2, 'Chicken Fried Rice ', 'chicken fried rice is going to be simple, packed full of flavour and easy to make. this dish is filled with chicken & vegetables.', 1200.00, '66d40244770c0.jpg'),
(19, 3, 'Fish and Chips ', 'Fish and chips is a hot dish consisting of fried fish in batter, served with chips. The dish originated in England.', 800.00, '66d403f777353.png'),
(21, 0, 'tests', 'test', 1200.00, '66f64035033d9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `FId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `Feedback` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`id`, `frm_id`, `status`, `remark`, `remarkDate`) VALUES
(1, 2, 'in process', 'none', '2022-05-01 05:17:49'),
(2, 3, 'in process', 'none', '2022-05-27 11:01:30'),
(3, 2, 'closed', 'thank you for your order!', '2022-05-27 11:11:41'),
(4, 3, 'closed', 'none', '2022-05-27 11:42:35'),
(5, 4, 'in process', 'none', '2022-05-27 11:42:55'),
(6, 1, 'rejected', 'none', '2022-05-27 11:43:26'),
(7, 7, 'in process', 'none', '2022-05-27 13:03:24'),
(8, 8, 'in process', 'none', '2022-05-27 13:03:38'),
(9, 9, 'rejected', 'thank you', '2022-05-27 13:03:53'),
(10, 7, 'closed', 'thank you for your ordering with us', '2022-05-27 13:04:33'),
(11, 8, 'closed', 'thanks ', '2022-05-27 13:05:24'),
(12, 5, 'closed', 'none', '2022-05-27 13:18:03'),
(13, 10, 'closed', 'we done', '2023-01-31 10:58:27'),
(14, 11, 'in process', 'ok', '2023-02-01 16:52:23'),
(15, 11, 'closed', 'ok-', '2023-02-01 16:52:43'),
(16, 11, 'rejected', 'ok', '2023-02-01 16:52:57'),
(17, 16, 'in process', 'hiii', '2023-08-01 12:48:08'),
(18, 15, 'closed', 'hii', '2023-08-01 12:49:15'),
(19, 16, 'in process', 'test', '2023-10-17 11:45:47'),
(20, 16, 'closed', 'test', '2023-10-17 11:46:25'),
(21, 13, 'in process', 'test', '2023-10-17 11:48:57'),
(22, 15, 'rejected', 'test', '2023-10-17 11:49:44'),
(23, 22, 'in process', 'test', '2023-10-25 12:34:54'),
(24, 23, 'rejected', 'test', '2023-10-25 12:43:51'),
(25, 25, 'in process', '15 min ', '2023-10-26 06:33:56'),
(26, 28, 'in process', 'Food Delivery is on the way', '2024-09-01 11:09:35'),
(27, 28, 'closed', 'hj', '2024-09-01 11:13:12'),
(28, 29, 'in process', 'food is on the way', '2024-09-01 11:13:48'),
(29, 28, 'in process', 'k', '2024-09-03 03:03:12'),
(30, 30, 'closed', 'already deivered', '2024-09-05 00:24:50'),
(31, 31, 'rejected', 'cancelled ', '2024-09-05 00:25:24'),
(32, 29, 'closed', 'hj', '2024-09-24 16:59:02'),
(33, 29, 'in process', 'the', '2024-09-27 05:55:33'),
(34, 29, 'in process', 'already update ', '2024-09-27 05:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `rs_id` int(222) NOT NULL,
  `c_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `url` varchar(222) NOT NULL,
  `o_hr` varchar(222) NOT NULL,
  `c_hr` varchar(222) NOT NULL,
  `o_days` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`) VALUES
(1, 2, 'Leon\'s kitchen - AMBALANWATTA', 'leonsambalanwatta@gmail.com', '091-2225267', 'www.leonsambalanwaththa.com', '9am', '10pm', 'mon-sun', 'No 65, Hospital Road, Ambalanwatta.', '6290877b473ce.jpg', '2024-08-31 15:04:21'),
(2, 3, 'Leon\'s Kitchen- UNAWATUNA', 'leonsunawatuna@gmail.com', '091-2225799', 'www.loensunawatuna.com', '7am', '8pm', 'mon-sat', ' No 4, Bonavista Road, Unawatuna. ', '66d45fb401275.jpg', '2024-09-01 12:36:04'),
(3, 3, 'Leon\'s PUB - UNAWATUNA', 'leonspub@gmail.com', '0912223235', 'www.leonspub.com', '9am', '12pm', 'mon-sun', 'No 12, Pub Street, Walladewala Road, Unawatuna.', '6290860e72d1e.jpg', '2024-08-31 15:07:09'),
(4, 6, 'Leon\'s Kitchen -GALLE FORT', 'leonsgalle@gmail.com', '0911524865', 'www.leonsgalle.com', '8am', '8pm', 'mon-sat', '          No 234, Main street, Galle Fort.          ', '66d3e5037ff46.png', '2024-09-01 03:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(222) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `res_category`
--

INSERT INTO `res_category` (`c_id`, `c_name`, `date`) VALUES
(2, 'Ambalanwatta', '2024-08-31 15:03:40'),
(3, 'Unawatuna', '2024-08-31 15:04:00'),
(6, 'GalleFort', '2024-09-01 05:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `stf_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(3) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`stf_id`, `username`, `password`, `email`, `code`, `date`) VALUES
(1, 'staff', 'stf11', 'staff@gmail.com', '011', '2024-09-20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `email`, `phone`, `password`, `address`, `status`, `date`) VALUES
(1, 'banuka', 'Yasas', 'Banuka Dias', 'banukadias5@gmail.com', '0768843295', 'yasa12', 'No 47, Makuluwa, 1st Lane, Galle.', 1, '2024-08-31 14:46:35'),
(2, 'Malaka', 'Dinul', 'Malaka de Silva', 'malaka@gmail.com', '0768642158', 'ma1212', 'N0 23, Wudwad Pedesa,Galle.', 1, '2024-08-31 14:48:08'),
(3, 'Nuhansa', 'Navinhara', 'de Silva', 'nuhansa@gmail.com', '0701234567', 'nuhan12', 'No 23, Sangamiththapura, Galle', 1, '2024-08-31 14:49:40'),
(4, 'Chanudi', 'Kalani', 'Ravihari ', 'chanudi@gmail.com', '0768834312', 'CH12', 'No23, Mapalagama Road, Neluwa', 1, '2024-09-04 18:19:28'),
(13, 'Ravishka', 'Amashan', 'Senadhi', 'amashan12@gmail.com', '076-8843295', 'am1212', 'No 23/A,Kuruduwaththa Road, Ambalangoda ', 1, '2024-09-01 14:36:28'),
(16, 'yasasri', 'banuka Dias', 'Wimalaweera', 'lakshithdias6@gmail.com', '0879989890', 'yasa12', 'galle', 1, '2024-09-23 07:01:20'),
(17, 'admin', 'Manage', 'Kalani', 'Chanupost99@gmaik.com', '0762367212', 'cha111', 'Galle Road,Wakwella', 1, '2024-10-02 08:24:57'),
(18, 'shamila', 'shamila', 'Gunawardhana', 'chanupost99@gmail.com', '0762367212', 'cha111', 'galle', 1, '2024-10-02 08:27:53');

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(222) NOT NULL,
  `u_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `quantity` int(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_orders`
--

INSERT INTO `users_orders` (`o_id`, `u_id`, `title`, `quantity`, `price`, `status`, `date`) VALUES
(13, 7, 'Lobster Thermidor', 1, 36.00, 'in process', '2023-10-17 11:48:57'),
(15, 7, 'Lobster Thermidor', 1, 36.00, 'rejected', '2023-10-17 11:49:44'),
(16, 10, 'Lobster Thermidor', 1, 36.00, 'closed', '2023-10-17 11:46:25'),
(20, 11, 'Chicken Patties', 1, 1100.00, NULL, '2023-10-21 09:28:05'),
(21, 11, 'Seafood Platter', 1, 1600.00, NULL, '2023-10-21 09:28:05'),
(22, 10, 'Chicken Patties', 3, 1100.00, 'in process', '2023-10-25 12:34:54'),
(23, 10, 'Seafood Platter', 1, 1600.00, 'rejected', '2023-10-25 12:43:51'),
(25, 10, 'Prawns Spaghetti', 1, 1600.00, 'in process', '2023-10-26 06:33:57'),
(29, 1, 'Coconut Roti', 1, 400.00, 'in process', '2024-09-27 05:55:33'),
(30, 1, 'Thandoori Chicken', 1, 800.00, 'closed', '2024-09-05 00:24:50'),
(31, 1, 'Cheese Balls', 3, 1000.00, 'rejected', '2024-09-05 00:25:24'),
(32, 18, 'Chicken Patties', 1, 1100.00, NULL, '2024-10-02 08:29:20'),
(33, 18, 'Seafood Platter', 1, 1600.00, NULL, '2024-10-02 08:29:20'),
(35, 1, 'Chicken Kottu', 1, 1000.00, NULL, '2024-10-05 08:40:13'),
(37, 1, 'Seafood Platter', 1, 1600.00, NULL, '2024-10-06 17:11:49'),
(38, 1, 'Chicken Kottu', 1, 1000.00, NULL, '2024-10-06 17:11:49'),
(39, 1, 'Chicken Patties', 1, 1100.00, NULL, '2024-10-06 17:11:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`FId`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`stf_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `FId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `stf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
