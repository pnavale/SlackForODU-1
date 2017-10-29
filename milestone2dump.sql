-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 23, 2017 at 04:00 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


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
drop database slack;
create database slack;

use slack;
--
-- Table structure for table `channel`
--

CREATE TABLE `channel` (
  `channel_id` int(20) NOT NULL,
  `channel_name` varchar(22) NOT NULL,
  `channel_creator` varchar(20) NOT NULL,
  `channel_created` datetime NOT NULL,
  `wk_id` varchar(20) NOT NULL,
  `purpose` text NOT NULL,
  `invites` text NOT NULL,
  `channel_type` varchar(10) NOT NULL,
  `joined` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel`
--

INSERT INTO `channel` (`channel_id`, `channel_name`, `channel_creator`, `channel_created`, `wk_id`, `purpose`, `invites`, `channel_type`, `joined`) VALUES
(1, 'general', 'default', '2017-09-04 09:27:20', '', '', '', 'public', ''),
(2, 'random', 'default', '2017-10-02 03:11:04', '', '', '', 'public', '1'),
(3, 'foodie', 'mcqueen', '2017-10-01 07:15:00', 'wk2', '', ',doc', 'public', 'mater'),
(4, 'travel', 'mater', '2017-09-04 05:15:26', 'wk1', '', ',doc,', 'public', 'mater,pnavale'),
(5, 'fitness', 'sally', '2017-10-13 04:17:00', 'wk1', '', ',doc,pnavale,', 'public', 'mater');

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
  `channel_id` varchar(22) DEFAULT NULL,
  `group_id` varchar(20) NOT NULL,
  `recipient_id` varchar(20) NOT NULL,
  `profile_pic` varchar(20) NOT NULL,
  `reaction` varchar(10) NOT NULL,
  `msg_type` varchar(10) NOT NULL,
  `reacted` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msg_id`, `subject`, `creator_id`, `msg_body`, `create_date`, `thread_id`, `channel_id`, `group_id`, `recipient_id`, `profile_pic`, `reaction`, `msg_type`, `reacted`) VALUES
(38, 'general', 'mater', 'hey', '2017-10-29 15:17:36', 0, '1', '', '', '1.png', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Reply`
--

CREATE TABLE `Reply` (
  `msg_id` int(11) NOT NULL,
  `reply_msg` text NOT NULL,
  `replied_by` varchar(50) NOT NULL,
  `replied_at` datetime NOT NULL,
  `reaction` varchar(22) NOT NULL,
  `reply_type` varchar(20) NOT NULL,
  `reply_id` int(11) NOT NULL,
  `profile_pic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Reply`
--

INSERT INTO `Reply` (`msg_id`, `reply_msg`, `replied_by`, `replied_at`, `reaction`, `reply_type`, `reply_id`, `profile_pic`) VALUES
(38, 'hey', 'mater', '2017-10-29 15:17:48', '', 'reply', 64, ''),
(38, '', 'mater', '2017-10-29 15:18:09', '+1', 'reaction', 65, ''),
(38, 'hey', 'mater', '2017-10-29 15:18:57', '', 'reply', 66, ''),
(38, 'hey', 'mater', '2017-10-29 15:20:08', '', 'reply', 67, ''),
(38, 'hey', 'mater', '2017-10-29 15:22:30', '', 'reply', 68, ''),
(38, 'hey', 'mater', '2017-10-29 15:23:51', '', 'reply', 69, '');

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
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email_id` varchar(30) NOT NULL,
  `group_id` varchar(20) DEFAULT NULL,
  `full_name` varchar(20) NOT NULL,
  `workspace_id` varchar(20) NOT NULL,
  `channel_id` varchar(20) NOT NULL,
  `profile_pic` text NOT NULL,
  `signup_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email_id`, `group_id`, `full_name`, `workspace_id`, `channel_id`, `profile_pic`, `signup_date`) VALUES
('agosa003', 'abc123', 'asmitagosavi92@gmail.com', '', 'Asmita Gosavi', 'wk1', '', '', '2017-10-22 21:52:30'),
('doc', 'abc123', 'hornet@rsprings.gov', 'g1', 'Doc Hudson', 'wk1', 'ch1', '3.png', '2017-09-04 09:00:00'),
('mater', 'abc123', 'mater@rsprings.gov', NULL, 'Tow Mater', 'wk1', 'ch1', '1.png', '0000-00-00 00:00:00'),
('mcmissile', 'abc123', 'topsecret@agent.org', NULL, 'Finn McMissile', 'wk2', 'ch1', '6.png', '2017-09-06 05:15:00'),
('mcqueen', 'abc123', 'kachow@rusteze.com', NULL, 'Lightning McQueen', 'wk2', 'ch1', '7.png', '2017-09-05 10:08:00'),
('pnavale', 'abc123', 'pratik@odu.edu', '', 'Pratik Navale', 'wk1', '', '', '2017-10-22 21:54:32'),
('sally', 'abc123', 'porsche@rsprings.gov', NULL, 'Sally Carrera', 'wk1', 'ch1', '2.png', '2017-09-01 03:00:00'),
('slackbot', '', '', NULL, '', '', '', 'slackbot.png', '2017-07-03 06:00:00');

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
  ADD PRIMARY KEY (`channel_id`),
  ADD UNIQUE KEY `channel_name` (`channel_name`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `Reply`
--
ALTER TABLE `Reply`
  ADD PRIMARY KEY (`reply_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `workspace`
--
ALTER TABLE `workspace`
  ADD PRIMARY KEY (`wk_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `channel`
--
ALTER TABLE `channel`
  MODIFY `channel_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `Reply`
--
ALTER TABLE `Reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
