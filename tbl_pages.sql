-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2019 at 05:17 AM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_pages`
--
ALTER TABLE `tbl_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
