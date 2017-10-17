-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2017 at 11:59 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "-05:00";
SET time_zone = 'US/Eastern';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slack`
--

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--
create database slack;

use slack;

CREATE TABLE `channel` (
  `channel_id` varchar(20) NOT NULL,
  `channel_name` varchar(20) NOT NULL,
  `channel_creator` varchar(20) NOT NULL,
  `channel_created` datetime NOT NULL,
  `wk_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel`
--

INSERT INTO `channel` (`channel_id`, `channel_name`, `channel_creator`, `channel_created`, `wk_id`) VALUES
('ch1', 'general', 'default', '2017-09-04 09:27:20', ''),
('ch2', 'random', 'default', '2017-10-02 03:11:04', ''),
('ch3', 'foodie', 'mcqueen', '2017-10-01 07:15:00', 'wk2'),
('ch4', 'travel', 'mater', '2017-09-04 05:15:26', 'wk1'),
('ch5', 'fitness', 'sally', '2017-10-13 04:17:00', 'wk1');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msg_id` int(11) NOT NULL,
  `subject` varchar(40) NOT NULL,
  `creator_id` varchar(20) NOT NULL,
  `msg_body` text NOT NULL,
  `create_date` datetime NOT NULL,
  `thread_id` int(11) NOT NULL,
  `channel_id` varchar(20) DEFAULT NULL,
  `group_id` varchar(20) NOT NULL,
  `recipient_id` varchar(20) NOT NULL,
  `profile_pic` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

-- --------------------------------------------------------

--
-- Table structure for table `slack_group`
--

CREATE TABLE `slack_group` (
  `group_id` varchar(20) NOT NULL,
  `group_name` varchar(20) NOT NULL,
  `group_creator` varchar(20) NOT NULL,
  `group_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email_id` varchar(30) NOT NULL,
  `group_id` varchar(20) DEFAULT NULL,
  `full_name` varchar(20) NOT NULL,
  `workspace_id` varchar(20) NOT NULL,
  `channel_id` varchar(20) NOT NULL,
  `profile_pic` varchar(50) NOT NULL,
  `signup_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email_id`, `group_id`, `full_name`, `workspace_id`, `channel_id`, `profile_pic`, `signup_date`) VALUES
('u1', 'mater', 'abc123', 'mater@rsprings.gov', NULL, 'Tow Mater', 'wk1', 'ch1', '1.png', '0000-00-00 00:00:00'),
('u2', 'sally', 'abc123', 'porsche@rsprings.gov', NULL, 'Sally Carrera', 'wk1', 'ch1', '2.png', '2017-09-01 03:00:00'),
('u3', 'doc', 'abc123', 'hornet@rsprings.gov', 'g1', 'Doc Hudson', 'wk1', 'ch1', '3.png', '2017-09-04 09:00:00'),
('u4', 'mcmissile', 'abc123', 'topsecret@agent.org', NULL, 'Finn McMissile', 'wk2', 'ch1', '6.png', '2017-09-06 05:15:00'),
('u5', 'mcqueen', 'abc123', 'kachow@rusteze.com', NULL, 'Lightning McQueen', 'wk2', 'ch1', '7.png', '2017-09-05 10:08:00'),
('u6', 'slackbot', '', '', NULL, '', '', '', 'slackbot.png', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `workspace`
--

CREATE TABLE `workspace` (
  `wk_id` varchar(20) NOT NULL,
  `url` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `wk_created` datetime NOT NULL,
  `wk_creator` varchar(20) NOT NULL,
  `channel_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workspace`
--

INSERT INTO `workspace` (`wk_id`, `url`, `purpose`, `wk_created`, `wk_creator`, `channel_id`) VALUES
('wk1', 'odu-its-students', 'Education', '2017-09-01 05:35:00', 'mater', 'ch4,ch5'),
('wk2', 'prasmik', 'Office', '2017-09-08 08:16:08', 'mcqueen', 'ch3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`channel_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `workspace`
--
ALTER TABLE `workspace`
  ADD PRIMARY KEY (`wk_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
