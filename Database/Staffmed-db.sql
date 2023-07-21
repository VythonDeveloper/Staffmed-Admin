-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2023 at 01:45 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `staffmed`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `address` text NOT NULL,
  `recipient` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `isDefault` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `userId`, `pincode`, `address`, `recipient`, `phone`, `isDefault`) VALUES
(8, 1, '713201', 'A-84, Aesby more, Near Hanumaan Mandir, Station Bazaar, Durgapur, West Bengal', 'Vivek Verma ', '8653826902', 'false'),
(10, 2, '657573', 'utsutstidyidi ydyidyidxkgxgkgkxjgxgjxgjxxjgjxgjxgjxgjxgxjgxgk kxgkxgkx gxkgxgkxkgkgxkxgxkgxkg', 'gord', '6576576755', 'false'),
(11, 5, '979494', 'jhaba', '', '', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `phone`, `username`, `password`) VALUES
(2, 'Vython', '8653826902', '1234567890', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `remark` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`, `remark`) VALUES
(1, 'https://img.freepik.com/premium-vector/medicine-pharmacy-hospital-set-medicines-with-labels-banner-website-with-medical-items_313437-426.jpg', '1'),
(2, 'https://blog-images-1.pharmeasy.in/blog/production/wp-content/uploads/2021/05/04135802/01-2.jpg', '2'),
(3, 'https://img.freepik.com/free-vector/flat-design-medical-center-sale-banner-template_23-2150122482.jpg', '3');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `userId`, `productId`, `date`) VALUES
(45, 6, 9, '2023-07-14 18:51:41'),
(59, 8, 4, '2023-07-17 16:09:17'),
(60, 8, 5, '2023-07-17 16:09:26'),
(61, 8, 7, '2023-07-17 16:09:29');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `dose` int(11) NOT NULL,
  `availability` varchar(30) NOT NULL,
  `price` double(9,2) NOT NULL,
  `discount` double(9,2) NOT NULL,
  `image` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `company`, `dose`, `availability`, `price`, `discount`, `image`, `date`) VALUES
(4, 'KT500 Jure', 'Alfa', 300, 'In-Stock', 500.00, 2.00, 'https://indiatvonline.in/staffmed/medicine-assets/assets/64a5954d13c59.jpeg', '2023-07-05 09:37:41'),
(5, 'Ni8KK', 'Delta', 50, 'In-Stock', 80.00, 5.00, 'https://indiatvonline.in/staffmed/medicine-assets/assets/64a59581bbf32.webp', '2023-07-05 09:38:33'),
(6, 'PIJ 090', 'Tetra', 40, 'Out-of-Stock', 30.00, 10.00, 'https://indiatvonline.in/staffmed/medicine-assets/assets/64a595cc3c9f3.jpg', '2023-07-05 09:39:48'),
(7, 'Paracetamol', 'FACCI', 500, 'In-Stock', 30.00, 1.00, 'https://indiatvonline.in/staffmed/medicine-assets/assets/64a595fd0aec7.jpg', '2023-07-05 09:40:37'),
(8, 'Hepbleen', 'Nan', 300, 'In-Stock', 300.00, 5.00, 'https://indiatvonline.in/staffmed/medicine-assets/assets/64a59630af550.webp', '2023-07-16 09:41:44'),
(9, 'Amlodipin', 'Amlogard', 10, 'In-Stock', 350.00, 16.00, 'https://indiatvonline.in/staffmed/medicine-assets/assets/64a80fcd16434.jpg', '2023-07-17 12:06:34');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_products`
--

CREATE TABLE `ordered_products` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `salePrice` double(9,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordered_products`
--

INSERT INTO `ordered_products` (`id`, `orderId`, `productId`, `salePrice`, `quantity`) VALUES
(10, 19, 5, 76.00, 1),
(11, 19, 4, 490.00, 1),
(12, 19, 9, 322.00, 2),
(13, 20, 9, 322.00, 2),
(14, 20, 7, 29.70, 3),
(15, 21, 9, 322.00, 1),
(16, 22, 9, 322.00, 1),
(17, 23, 9, 322.00, 1),
(18, 24, 7, 29.70, 1),
(19, 24, 4, 490.00, 3),
(20, 24, 5, 76.00, 1),
(21, 24, 9, 322.00, 2),
(22, 25, 7, 29.70, 1),
(23, 25, 4, 490.00, 4),
(24, 25, 5, 76.00, 1),
(25, 25, 9, 322.00, 3),
(26, 26, 4, 490.00, 1),
(27, 27, 5, 76.00, 1),
(28, 28, 7, 29.70, 1),
(29, 28, 9, 322.00, 2),
(30, 28, 5, 76.00, 1),
(31, 28, 4, 490.00, 2),
(32, 29, 7, 29.70, 1),
(33, 29, 9, 322.00, 1),
(34, 29, 5, 76.00, 1),
(35, 29, 4, 490.00, 1),
(36, 30, 7, 29.70, 1),
(37, 30, 9, 322.00, 1),
(38, 30, 5, 76.00, 1),
(39, 30, 4, 490.00, 1),
(40, 31, 7, 29.70, 1),
(41, 31, 8, 285.00, 1),
(42, 31, 4, 490.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `refId` varchar(10) NOT NULL,
  `userId` int(11) NOT NULL,
  `amount` double(9,2) NOT NULL,
  `timeSlot` varchar(30) NOT NULL,
  `dateRange` varchar(30) NOT NULL,
  `shippingAddress` text NOT NULL,
  `isPaid` varchar(20) NOT NULL,
  `status` varchar(30) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `refId`, `userId`, `amount`, `timeSlot`, `dateRange`, `shippingAddress`, `isPaid`, `status`, `date`) VALUES
(19, 'BIW2DNZX8Q', 2, 1210.00, '10:00 PM', '2023-07-09', 'Vivek Verma, 8653826902, Aesby More, 713201', 'Pending', 'Pending', '2023-07-09 13:35:09'),
(20, '7KT1JM4FUI', 2, 733.10, '8:00 AM', '2023-07-12', 'avishek verma, 5347656756,fohafoyaydi - 713201', 'Approved', 'Delivered', '2023-07-09 13:41:58'),
(21, 'Z815S6XJP0', 2, 322.00, '6:00 AM', '2023-07-10', 'ek do to, 7565675766,iydfoydyouof - 976784', 'Pending', 'Pending', '2023-07-09 18:47:26'),
(22, 'XCS89JZFL3', 2, 322.00, '6:00 AM', '2023-07-10', 'ek do to, 7565675766,iydfoydyouof - 976784', 'Pending', 'Pending', '2023-07-09 18:55:36'),
(23, 'UZGACT5QER', 2, 322.00, '4:00 PM', '2023-07-10', 'ek do to, 7565675766,iydfoydyouof - 976784', 'Approved', 'Pending', '2023-07-09 18:56:54'),
(24, 'D3XYTFVLEM', 2, 2219.70, '10:00 PM', '2023-07-12', 'avishek verma, 5347656756,fohafoyaydi - 713201', 'Pending', 'Pending', '2023-07-09 19:16:12'),
(25, 'IR5PQF26ZG', 2, 3031.70, '10:00 PM', '2023-07-10', 'avishek verma, 5347656756,fohafoyaydi - 713201', 'Pending', 'Pending', '2023-07-09 19:24:32'),
(26, 'NPOD81XYGH', 2, 490.00, '22:00', '2023-07-17', 'ahcklahaljva, 5676575676, aluczpugpsljac - 713201', 'Pending', 'Pending', '2023-07-16 20:54:08'),
(27, 'NPODQECT68', 2, 76.00, '6:00', '2023-07-17', 'gord, 6576576755, utsutstidyidi ydyidyidxkgxgkgkxjgxgjxgjxxjgjxgjxgjxgjxgxjgxgk kxgkxgkx gxkgxgkxkgkgxkxgxkgxkg - 657573', 'Pending', 'Pending', '2023-07-16 21:00:46'),
(28, 'NPOD2D7NMQ', 2, 1729.70, '14:00', '2023-07-19', 'gord, 6576576755, utsutstidyidi ydyidyidxkgxgkgkxjgxgjxgjxxjgjxgjxgjxgjxgxjgxgk kxgkxgkx gxkgxgkxkgkgxkxgxkgxkg - 657573', 'Pending', 'Pending', '2023-07-16 21:03:35'),
(29, 'NPODASHREZ', 2, 917.70, '14:00', '2023-07-20', 'gord, 6576576755, utsutstidyidi ydyidyidxkgxgkgkxjgxgjxgjxxjgjxgjxgjxgjxgxjgxgk kxgkxgkx gxkgxgkxkgkgxkxgxkgxkg - 657573', 'Pending', 'Pending', '2023-07-16 21:04:02'),
(30, 'NPOD5A1FQU', 2, 917.70, '6:00', '2023-07-17', 'gord, 6576576755, utsutstidyidi ydyidyidxkgxgkgkxjgxgjxgjxxjgjxgjxgjxgjxgxjgxgk kxgkxgkx gxkgxgkxkgkgxkxgxkgxkg - 657573', 'Pending', 'Pending', '2023-07-16 21:05:15'),
(31, 'NPODHI39ON', 1, 804.70, '14:00', '2023-07-19', 'Vivek Verma , 8653826902, A-84, Aesby more, Near Hanumaan Mandir, Station Bazaar, Durgapur, West Bengal - 713201', 'Pending', 'Pending', '2023-07-16 21:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `presId` int(11) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `presId`, `image`) VALUES
(2, 6, 'https://indiatvonline.in/staffmed/medicine-assets/prescriptions/64b37ab725b24.jpg'),
(3, 6, 'https://indiatvonline.in/staffmed/medicine-assets/prescriptions/64b37ab725c59.jpg'),
(4, 7, 'https://indiatvonline.in/staffmed/medicine-assets/prescriptions/64b3981268874.jpg'),
(5, 8, 'https://indiatvonline.in/staffmed/medicine-assets/prescriptions/64b40ceecfe5e.jpg'),
(6, 9, 'https://indiatvonline.in/staffmed/medicine-assets/prescriptions/64b41a0e0fff3.jpg'),
(7, 9, 'https://indiatvonline.in/staffmed/medicine-assets/prescriptions/64b41a0e10114.jpg'),
(8, 10, 'https://indiatvonline.in/staffmed/medicine-assets/prescriptions/64b587b5d70b4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_orders`
--

CREATE TABLE `prescription_orders` (
  `id` int(11) NOT NULL,
  `refId` varchar(10) NOT NULL,
  `userId` int(11) NOT NULL,
  `amount` double(9,2) NOT NULL,
  `timeSlot` varchar(30) NOT NULL,
  `dateRange` varchar(30) NOT NULL,
  `shippingAddress` text NOT NULL,
  `isPaid` varchar(20) NOT NULL,
  `status` varchar(30) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prescription_orders`
--

INSERT INTO `prescription_orders` (`id`, `refId`, `userId`, `amount`, `timeSlot`, `dateRange`, `shippingAddress`, `isPaid`, `status`, `date`) VALUES
(6, 'PROD9MT15H', 2, 0.00, '4:00 PM', '2023-07-20', 'avishek verma, 5347656756, fohafoyaydi - 713201', 'Pending', 'Pending', '2023-07-16 10:35:59'),
(7, 'PRODDN1O75', 1, 55.00, '6:00 AM', '2023-07-20', 'Vivek Verma , 8653826902, A-84, Aesby more, Near Hanumaan Mandir, Station Bazaar, Durgapur, West Bengal - 713201', 'Approved', 'Pending', '2023-07-16 12:41:15'),
(8, 'PRODQJZYN5', 2, 900.00, '10:00', '2023-07-17', 'gord, 6576576755, utsutstidyidi ydyidyidxkgxgkgkxjgxgjxgjxxjgjxgjxgjxgjxgxjgxgk kxgkxgkx gxkgxgkxkgkgxkxgxkgxkg - 657573', 'Approved', 'Pending', '2023-07-16 20:59:51'),
(9, 'PRODT35B1E', 1, 0.00, '14:00', '2023-07-20', 'Vivek Verma , 8653826902, A-84, Aesby more, Near Hanumaan Mandir, Station Bazaar, Durgapur, West Bengal - 713201', 'Pending', 'Pending', '2023-07-16 21:55:50'),
(10, 'PRODAV3PJN', 5, 0.00, '10:00', '2023-07-19', ', , jhaba - 979494', 'Pending', 'Pending', '2023-07-17 23:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_products`
--

CREATE TABLE `prescription_products` (
  `id` int(11) NOT NULL,
  `presId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `dose` int(11) NOT NULL,
  `salePrice` double(9,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prescription_products`
--

INSERT INTO `prescription_products` (`id`, `presId`, `name`, `company`, `dose`, `salePrice`, `quantity`) VALUES
(1, 6, 'Dummy', 'Lorem', 10, 100.00, 2),
(2, 8, 'KT500 Jure', 'Alfa', 200, 300.00, 3),
(3, 7, 'Lamonate', 'Nan', 30, 45.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `tokenId` varchar(20) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `phone`, `email`, `password`, `status`, `tokenId`, `date`) VALUES
(1, 'Vivek', '8653826902', 'vivekdgp01@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Active', 'PYQ4EmeBJlAMsNf7', '2023-07-05 22:02:37'),
(2, 'Avishek verma', '9093086276', 'avishekverma79@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Active', 'c17iTKEoUI9XSOwW', '2023-07-05 22:31:38'),
(3, 'srvfer', '9093086256', 'dfgbfrt', 'b59c67bf196a4758191e42f76670ceba', 'Active', '', '2023-07-06 09:26:32'),
(4, 'skb', '9193827567', 'bsadon262@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Active', '6p4XklQNvrCwUf9y', '2023-07-06 21:47:21'),
(5, 'Subrata Midya', '8967993014', 'subratamidya2056@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Active', 'e4WnZA1TYBSKUJFf', '2023-07-07 19:08:20'),
(6, 'Sayan Maity', '8101208996', '02sayan.maity@gmail.com', '32297904f501e68710764d14975a35c7', 'Active', 'XR0GJj58ngIWwASL', '2023-07-08 07:09:17'),
(7, 'Kritidhriti Midya', '7029350061', 'kritidhritimidya2000@gmail.com', '7ba474d7204671addcc4911671b3d949', 'Active', 'yvP9CHhVktFWUNIz', '2023-07-08 22:01:17'),
(8, 'dk', '9721098721', 'shreehanstaxi@gmail.com', 'bc9dcb837506c3d5892bec66b1dba936', 'Active', 'FaAd2WQ6gIkJhoj5', '2023-07-17 16:08:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `refId` (`refId`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription_orders`
--
ALTER TABLE `prescription_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription_products`
--
ALTER TABLE `prescription_products`
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
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prescription_orders`
--
ALTER TABLE `prescription_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prescription_products`
--
ALTER TABLE `prescription_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
