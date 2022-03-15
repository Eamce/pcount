-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2020 at 09:31 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books`
--

CREATE TABLE `tbl_books` (
  `book_id` int(11) NOT NULL,
  `book_pic` varchar(200) NOT NULL,
  `booktype` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` varchar(400) NOT NULL,
  `author` varchar(200) NOT NULL,
  `publisher` varchar(200) NOT NULL,
  `yrpublished` year(4) NOT NULL,
  `edition` varchar(200) NOT NULL,
  `volume` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `status` int(11) NOT NULL,
  `date_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`book_id`, `book_pic`, `booktype`, `title`, `description`, `author`, `publisher`, `yrpublished`, `edition`, `volume`, `quantity`, `price`, `status`, `date_input`) VALUES
(1, 'Book_IMG_1754-1-e1481474081467.jpg', 'Sample', 'Sample', 'Asdasdasd', 'Sample', 'Sample', 2019, 'Sample', 'Sample', 100, 100, 1, '0000-00-00 00:00:00'),
(2, 'blue-book.png', 'Qweqwe', 'Qweq', 'Asdasdasd', 'Qweqwe', 'Asda', 1980, '12313', '12asd', 5, 12312.31, 1, '0000-00-00 00:00:00'),
(3, 'images.jpg', 'Asddef', 'Ertert', 'Asdasdasd', 'Fgdg', 'Wrwer', 2000, 'Rqweq', '1231wqsr', 12, 12.31, 1, '0000-00-00 00:00:00'),
(5, 'images.png', 'Data2', 'Sample', 'Asdasdasda', 'Jose Rizal', 'Asdasd', 0000, 'Asdasd', 'Qweqwe', 23, 200, 1, '2019-12-31 10:29:49'),
(6, 'open-book-clipart-07-300x300.png', 'Asdasd', 'Asdadfgf', 'Ergerg', 'Fger', 'Ergter', 2000, 'Asda', 'Sdasda', 21, 1231.23, 1, '2019-12-31 10:30:53'),
(11, 'blue-book.png', 'Asdasd', 'Sdfsf', 'Werwerw', 'Erter', 'Fghfgh', 2011, 'Sdfsdf', 'Dfgdfg', 12, 12313.21, 1, '2019-12-31 11:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discounts`
--

CREATE TABLE `tbl_discounts` (
  `discount_id` int(11) NOT NULL,
  `discount` varchar(200) NOT NULL,
  `percentage` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_discounts`
--

INSERT INTO `tbl_discounts` (`discount_id`, `discount`, `percentage`, `status`) VALUES
(1, 'Senior Discount', 20, 1),
(2, 'Senior Citizen', 20, 1),
(3, 'asdas', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pages`
--

CREATE TABLE `tbl_pages` (
  `page_id` int(11) NOT NULL,
  `page_heading` varchar(200) NOT NULL,
  `page_root` varchar(200) NOT NULL,
  `page_route` varchar(200) NOT NULL,
  `header_title` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pages`
--

INSERT INTO `tbl_pages` (`page_id`, `page_heading`, `page_root`, `page_route`, `header_title`) VALUES
(1, 'Dashboard', 'Dashboard', 'dashboard', ''),
(2, 'Book Setup', 'File / Book Setup', 'book_setup', 'Book/s List'),
(3, 'Discount Setup', 'File / Discount Setup', 'discount_setup', 'Discount/s List'),
(4, 'User Setup', 'File / User Setup', 'user_setup', 'user/s List'),
(5, 'Point Of Sale', 'Transaction / Point Of Sale', 'point_of_sale', ''),
(6, 'Stock In', 'Transaction / Stock In', 'stock_in', ''),
(7, 'Adjustment', 'Transaction / Adjustment', 'adjustment', ''),
(8, 'Reservation', 'Transaction / Reservation', 'reservation', ''),
(9, 'Books Inquiry', 'Inquiry / Books Inquiry', 'books_inquiry', 'List of Book/s'),
(10, 'Sold Books', 'Inquiry / Sold Books', 'sold_books', 'List of Sold Book/s'),
(11, 'Customers Log', 'Inquiry / Customers Log', 'customers_log', 'List of Customer/s Log'),
(12, 'Sales Report', 'Report / Sales Report', 'sales_report', 'Sales List'),
(13, 'Stocks Report', 'Report / Stocks Report', 'stocks_report', 'Stock/s List'),
(14, 'Quick Search', 'Quick Search Engine', 'book_quick_search', 'Book Quick Search');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `usertype` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `name`, `username`, `password`, `usertype`, `profile_pic`, `status`) VALUES
(1, 'Spencer Agosto', 'spencer', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'assets/images/profile/user.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `tbl_discounts`
--
ALTER TABLE `tbl_discounts`
  ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_discounts`
--
ALTER TABLE `tbl_discounts`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
