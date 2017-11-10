-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 09, 2017 at 03:32 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";




--
-- Database: `db_csm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_portfolio`
--

CREATE TABLE `tb_portfolio` (
  `i_portf` int(10) NOT NULL,
  `s_img_p1` varchar(100) NOT NULL,
  `s_img_p2` varchar(100) NOT NULL,
  `i_index` int(11) NOT NULL,
  `s_subject` text NOT NULL,
  `s_detail` text NOT NULL,
  `i_view` int(10) NOT NULL,
  `i_vote` int(10) NOT NULL,
  `d_create` datetime NOT NULL,
  `d_update` datetime NOT NULL,
  `s_create_by` varchar(50) NOT NULL,
  `s_update_by` varchar(50) NOT NULL,
  `s_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_portfolio`
--
ALTER TABLE `tb_portfolio`
  ADD PRIMARY KEY (`i_portf`),
  ADD KEY `index_tb_portfolio` (`i_vote`,`i_view`,`s_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_portfolio`
--
ALTER TABLE `tb_portfolio`
  MODIFY `i_portf` int(10) NOT NULL AUTO_INCREMENT;COMMIT;


