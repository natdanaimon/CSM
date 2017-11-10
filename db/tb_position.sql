-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2017 at 04:59 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



--
-- Database: `admin_root`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_position`
--

CREATE TABLE `tb_position` (
  `i_position` int(10) NOT NULL,
  `s_app` varchar(50) NOT NULL,
  `s_detail_th` varchar(100) NOT NULL,
  `s_detail_en` varchar(100) NOT NULL,
  `s_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_position`
--

INSERT INTO `tb_position` (`i_position`, `s_app`, `s_detail_th`, `s_detail_en`, `s_status`) VALUES
(1, 'CS', 'สไลด์หน้าแรกด้านบน', 'SLIDE HOME TOP', 'A'),
(2, 'GL', 'แกลลอรี่ หน้าแรก', 'GALLERY HOME', 'A'),
(3, 'PP', 'รูปภาพหน้าแรก', 'PICTURE HOME', 'A'),
(4, 'PV', 'วิดีโอหน้าแรก', 'VIDEO HOME', 'A'),
(5, 'PN', 'ข่าวแสดงทุกหน้า', 'NEWS ALL PAGE', 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_position`
--
ALTER TABLE `tb_position`
  ADD PRIMARY KEY (`i_position`),
  ADD KEY `index_tb_position` (`s_app`,`s_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_position`
--
ALTER TABLE `tb_position`
  MODIFY `i_position` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

