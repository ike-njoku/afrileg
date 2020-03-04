<?php 
// when ever your'e done executing the code in this script, delete it.
?>


<?php /*
	function create_table_function($table_name,$columns)
	{
		//you have to specify the names of the table and columns that you want to create
		

		// sql statement to create the table
		$create_table = "create table  ".$table_name." 
		(
			".$columns."
		) 
		";


		// include the path to the database connection;
		include("include/connect.php");

		// php/mysqli to actually create the table with the sql statement above

		$cretae_table_query = mysqli_query($config,$create_table);

		if ($cretae_table_query) {
			echo $table_name ." table created successfully <br>";
		}else{
			echo $table_name. " unable to create table at this momnet <br>";
		}
	}
	*/
?>

<?php 
	/*
		// create table for wallet
		$table_name = "wallet";
		$columns = "id int(16) NOT NULL AUTO_INCREMENT, customer_id varchar(225), amount varchar(225), PRIMARY KEY(id) ";
		// call the function:

		create_table_function($table_name,$columns);

		// create orders table
		$table_name = "orders";
		$columns = "id int(15) NOT NULL AUTO_INCREMENT,customer_id varchar(225), tracking_id varchar(225), regdate datetime, processing int(2) NOT NULL, shipped int(2) NOT NULL, fulfilled int(2) NOT NULL, grand_total int(2), PRIMARY KEY(id) ";

		create_table_function($table_name,$columns);


		// create coupons table;
		$table_name = "coupons";
		$columns = "id int(15) NOT NULL AUTO_INCREMENT, customer_id varchar(225), used int(2)NOT Null, code varchar(30), order_id varchar(225), value varchar(225), event varchar(225), PRIMARY KEY(id) ";
		create_table_function($table_name,$columns);
	*/
?>

<?php
// Function to get the client IP address
// function get_client_ip() {
//     $ipaddress = '';
//     if (isset($_SERVER['HTTP_CLIENT_IP']))
//         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
//     else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED'];
//     else if(isset($_SERVER['REMOTE_ADDR']))
//         $ipaddress = $_SERVER['REMOTE_ADDR'];
//     else
//         $ipaddress = 'UNKNOWN';

//     echo $ipaddress;
//     return $ipaddress;

// }


// get_client_ip();


?>

<?php 
	// if (isset($_COOKIE['guest_id'])) {
	// 	echo $_COOKIE['guest_id'];
	// }else{
	// 	$cookie_value= crc32(1);
	// 	$cookie_name = "guest_id";
	// 	// create cookie
	// 	$create_cookie = setcookie($cookie_name,$cookie_value);
	// 	// check if it worked
	// 	if ($create_cookie) {
	// 		echo $_COOKIE['guest_id'];
			
	// 		// destroy cookies
	// 		$destroy_cookie = setcookie($cookie_name,$cookie_value,time()-1);
	// 		if ($destroy_cookie) {
	// 			echo "your cookie has successfully been destroyed";
	// 		}
	// 	}
	// }

?>

<?php
-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2020 at 08:20 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `afrileg`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `avatar` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `avatar`) VALUES
(1, 'David', 'ikenjokudc@gmail.com', 'Achamma86!', ''),
(2, 'a', 'a@a.com', 'a', '');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_type` varchar(225) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` varchar(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchased` int(1) NOT NULL,
  `tracking_id` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Tops'),
(2, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(255) NOT NULL,
  `customer_id` int(32) NOT NULL,
  `used` int(2) NOT NULL,
  `order_id` varchar(2) NOT NULL,
  `code` varchar(40) NOT NULL,
  `value` varchar(32) NOT NULL,
  `event` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `customer_id`, `used`, `order_id`, `code`, `value`, `event`) VALUES
(1, 1, 0, '', '-894639625', '1000', 'purchase');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `active` varchar(32) NOT NULL,
  `username` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `avatar` varchar(225) NOT NULL,
  `regdate` date NOT NULL,
  `referal_code` varchar(32) NOT NULL,
  `referer_id` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `email`, `active`, `username`, `lastname`, `firstname`, `password`, `avatar`, `regdate`, `referal_code`, `referer_id`) VALUES
(1, 'testuser@afrileg.com', '1', 'Test User', '', '', '-895434946', '', '2020-02-16', '124806285', 0),
(2, 'agfrileg@afrileg.com', '1', 'afrileg', '', '', '-67338534', '', '2020-02-16', '757217276', 0),
(3, 'anita@afrileg.com', '27baa0cb4f1be9e60cfd82ce17d3be51', 'anita', '', '', '1716074633', '', '2020-02-16', '-1198295563', 0),
(4, 'david@afrileg.com', '1', 'david', '', '', '-492205150', '', '2020-02-17', '509238709', 0),
(5, 'testuser1234@afrileg.com', '1', 'testuser1234', '', '', '-286844814', '', '2020-02-17', '915746406', 0),
(6, 'okon@afrileg.com', '1', 'okon', '', '', '219249334', '', '2020-02-17', '1636868580', 0),
(7, 'willianekeh@gmail.com', '1', 'McWilliams', '', '', '-1476612749', '', '2020-02-19', '1589673888', 0),
(8, 'boobaby@afrileg.com', '1', 'BooBabyproMax', '', '', '222200324', '', '2020-02-19', '-66889626', 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_details`
--

CREATE TABLE `delivery_details` (
  `id` int(12) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address` longtext NOT NULL,
  `city` varchar(70) NOT NULL,
  `state` varchar(70) NOT NULL,
  `country` varchar(70) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_details`
--

INSERT INTO `delivery_details` (`id`, `firstname`, `lastname`, `customer_id`, `address`, `city`, `state`, `country`, `mobile`, `zip`, `email`) VALUES
(2, 'david', 'IKE-NJOKU', 1, 'plot 209 Fatima Gold Estate,\r\n\r\nby orange market junction', 'Abuja', 'F.C.T', 'Nigeria', '+2348086694386', '460', 'okoye@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `fund_wallet`
--

CREATE TABLE `fund_wallet` (
  `id` int(37) NOT NULL,
  `customer_id` int(37) NOT NULL,
  `amount` varchar(266) NOT NULL,
  `regdate` datetime NOT NULL,
  `paid` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fund_wallet`
--

INSERT INTO `fund_wallet` (`id`, `customer_id`, `amount`, `regdate`, `paid`) VALUES
(1, 8, '543', '2020-02-22 16:31:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` int(70) NOT NULL,
  `guest_id` varchar(225) NOT NULL,
  `guest_ip_address` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `firstname` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `subject` varchar(225) NOT NULL,
  `message` longtext NOT NULL,
  `viewed` int(1) NOT NULL DEFAULT '0',
  `regdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `firstname`, `email`, `subject`, `message`, `viewed`, `regdate`) VALUES
(1, 'david', 'david@gmail.com', 'nice work', 'youve done well so far', 1, '2020-02-22 09:29:27');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(30) NOT NULL,
  `tracking_id` varchar(32) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `regdate` datetime NOT NULL,
  `processing` int(4) NOT NULL,
  `shipped` int(30) NOT NULL,
  `fulfilled` int(4) NOT NULL,
  `grand_total` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `tracking_id`, `customer_id`, `regdate`, `processing`, `shipped`, `fulfilled`, `grand_total`) VALUES
(1, '-2082672713', 1, '2019-12-29 22:29:48', 0, 0, 0, ''),
(2, '450215437', 1, '2019-12-29 22:46:14', 0, 0, 0, ''),
(3, '1842515611', 1, '2019-12-29 22:50:05', 0, 0, 0, ''),
(4, '-206169288', 1, '2019-12-29 22:53:00', 0, 0, 0, ''),
(5, '-2068763730', 1, '2019-12-29 22:53:34', 0, 0, 0, ''),
(6, '498629140', 1, '2019-12-29 22:54:13', 0, 0, 0, ''),
(7, '1790921346', 1, '2019-12-29 23:08:11', 0, 0, 0, ''),
(8, '-100641005', 1, '2019-12-29 23:17:28', 0, 0, 0, ''),
(9, '-1928894587', 1, '2019-12-29 23:22:00', 0, 0, 0, ''),
(10, '-1587730975', 1, '2019-12-29 23:23:10', 0, 0, 0, ''),
(11, '-698739337', 1, '2019-12-29 23:26:45', 0, 0, 0, ''),
(12, '1330857165', 1, '2019-12-30 01:05:05', 0, 0, 0, ''),
(13, '945058907', 1, '2020-01-04 21:38:05', 0, 0, 0, ''),
(14, '-1506745864', 1, '2020-01-04 21:41:26', 0, 0, 0, ''),
(15, '-784871058', 1, '2020-01-04 21:42:33', 0, 0, 0, ''),
(16, '1212055764', 1, '2020-01-22 00:27:49', 0, 0, 0, ''),
(17, '1060745282', 1, '2020-01-26 00:02:19', 0, 0, 0, ''),
(18, '-1350128173', 1, '2020-01-31 18:07:00', 0, 0, 0, ''),
(19, '-662594235', 1, '2020-02-09 00:18:02', 0, 0, 0, ''),
(20, '-1972341214', 1, '2020-02-09 09:32:36', 0, 0, 0, ''),
(21, '-42514764', 1, '2020-02-09 09:32:58', 0, 0, 0, ''),
(22, '1685985038', 1, '2020-02-09 09:36:25', 0, 0, 0, ''),
(23, '326707096', 1, '2020-02-09 09:36:55', 0, 0, 0, ''),
(24, '-1927433669', 1, '2020-02-09 12:36:27', 0, 0, 0, ''),
(25, '-98925907', 1, '2020-02-09 12:43:42', 0, 0, 0, ''),
(26, '1662243607', 1, '2020-02-09 12:55:10', 0, 0, 0, ''),
(27, '336913281', 1, '2020-02-09 12:55:43', 0, 0, 0, ''),
(28, '-2069103088', 1, '2020-02-09 12:58:01', 0, 0, 0, ''),
(29, '-206778746', 1, '2020-02-09 13:10:34', 0, 0, 0, ''),
(30, '-1821685917', 1, '2020-02-09 13:15:38', 0, 0, 0, ''),
(31, '-462653451', 1, '2020-02-09 22:56:35', 0, 0, 0, ''),
(32, '2103780943', 1, '2020-02-11 12:12:21', 0, 0, 0, ''),
(33, '174200537', 1, '2020-02-16 16:51:08', 1, 0, 0, ''),
(34, '-1811512454', 8, '2020-02-22 16:40:20', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `sub_sub_category_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `image1` varchar(225) NOT NULL,
  `image2` varchar(225) NOT NULL,
  `image3` varchar(225) NOT NULL,
  `rating` int(1) NOT NULL,
  `price` varchar(10) NOT NULL,
  `inventory` int(11) NOT NULL,
  `discount` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sub_sub_category_id`, `name`, `description`, `image1`, `image2`, `image3`, `rating`, `price`, `inventory`, `discount`) VALUES
(1, 3, 'fine afrileg shoe', 'really wonderful shoes for sale', 'products/AFRILEG...jpg', 'products/AFRILEG..jpg', 'products/AFRILEG...jpg', 4, '1280.57', 787507, 0),
(2, 14, 'bar code.', 'i am using this to test somethings', 'products/afrileg.com barcode.png', 'products/afrileg.com barcode.png', 'products/afrileg3.jpg', 2, '570.20', 10280600, 0),
(3, 15, 'ankara duffle bag', 'very pretty ass ankara duffle bag', 'products/images (2).jpeg', 'products/images (2).jpeg', 'products/images (2).jpeg', 5, '150.56', 9007971, 0),
(4, 3, 'baseball jacket', 'ankara baseball jacket', 'products/ankara7.jpg', 'products/ankara5.jpg', 'products/ankara7.jpg', 0, '750.00', 129009491, 0);

-- --------------------------------------------------------

--
-- Table structure for table `saved_items`
--

CREATE TABLE `saved_items` (
  `id` int(12) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_type` varchar(225) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `name`, `category_id`) VALUES
(1, 'T-shirts', 1),
(2, 'Bags', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sub_sub_category`
--

CREATE TABLE `sub_sub_category` (
  `id` int(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_sub_category`
--

INSERT INTO `sub_sub_category` (`id`, `name`, `subcategory_id`, `category_id`) VALUES
(1, 'purses', 2, 0),
(2, 'wallets', 2, 0),
(3, 'long-sleved', 1, 0),
(14, 'african print', 1, 0),
(15, 'hand bags', 2, 0),
(16, 'ankara back packs', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id` int(225) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`id`, `customer_id`, `amount`) VALUES
(1, 1, '59936.95'),
(2, 8, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `delivery_details`
--
ALTER TABLE `delivery_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fund_wallet`
--
ALTER TABLE `fund_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saved_items`
--
ALTER TABLE `saved_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_sub_category`
--
ALTER TABLE `sub_sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `delivery_details`
--
ALTER TABLE `delivery_details`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fund_wallet`
--
ALTER TABLE `fund_wallet`
  MODIFY `id` int(37) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` int(70) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `saved_items`
--
ALTER TABLE `saved_items`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_sub_category`
--
ALTER TABLE `sub_sub_category`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
 

?>
