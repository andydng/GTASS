-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 05, 2016 at 08:06 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GTASS`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`username`, `password`) VALUES
('administrator', 'Maggie12');

-- --------------------------------------------------------

--
-- Table structure for table `chair`
--

CREATE TABLE `chair` (
  `session_name` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chair`
--

INSERT INTO `chair` (`session_name`, `email`) VALUES
('Spring2017', 'alex.h.doan@Knights.ucf.edu');

-- --------------------------------------------------------

--
-- Table structure for table `committee`
--

CREATE TABLE `committee` (
  `email` text NOT NULL,
  `session_name` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `committee`
--

INSERT INTO `committee` (`email`, `session_name`, `password`) VALUES
('alex.h.doan@Knights.ucf.edu', 'Spring2018', 'alex.h.doan@Knights.ucf.edu');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `email` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`email`, `first_name`, `last_name`, `password`) VALUES
('alex.h.doan@Knights.ucf.edu', 'Alex', 'Doan', 'Doan'),
('wgsobess@gmail.com', 'Whitney', 'Greene', 'Greene');

-- --------------------------------------------------------

--
-- Table structure for table `nomination`
--

CREATE TABLE `nomination` (
  `sid` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `student_email` text NOT NULL,
  `faculty_email` text NOT NULL,
  `session_name` text NOT NULL,
  `rank` text NOT NULL,
  `is_phd` text NOT NULL,
  `new_phd` text NOT NULL,
  `complete` text NOT NULL,
  `verified` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `session_name` text NOT NULL,
  `nom_deadline` date NOT NULL,
  `comp_deadline` date NOT NULL,
  `ver_deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`session_name`, `nom_deadline`, `comp_deadline`, `ver_deadline`) VALUES
('Spring2017', '2017-01-01', '2016-05-31', '2017-02-27'),
('Spring2018', '2017-01-01', '2017-01-07', '2016-06-05'),
('Spring2019', '2017-01-01', '2017-01-29', '2017-02-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`username`(16));

--
-- Indexes for table `chair`
--
ALTER TABLE `chair`
  ADD PRIMARY KEY (`session_name`(10));

--
-- Indexes for table `committee`
--
ALTER TABLE `committee`
  ADD PRIMARY KEY (`email`(10),`session_name`(30)),
  ADD KEY `fk` (`email`(30)),
  ADD KEY `foreign` (`session_name`(10));

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`email`(25));

--
-- Indexes for table `nomination`
--
ALTER TABLE `nomination`
  ADD PRIMARY KEY (`sid`(10),`student_email`(25),`faculty_email`(25),`session_name`(10));

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_name`(10)),
  ADD UNIQUE KEY `pri_key` (`session_name`(10));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
