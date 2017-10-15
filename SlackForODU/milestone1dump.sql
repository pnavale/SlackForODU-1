-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2017 at 11:59 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

INSERT INTO `message` (`msg_id`, `subject`, `creator_id`, `msg_body`, `create_date`, `thread_id`, `channel_id`, `group_id`, `recipient_id`, `profile_pic`) VALUES
(105, 'travel', 'mater', 'Hey', '2017-10-14 19:29:20', 0, 'ch4', '', '', '1.png'),
(106, 'travel', 'sally', 'hey', '2017-10-14 19:29:59', 0, 'ch4', '', '', '2.png'),
(107, 'travel', 'doc', 'hey', '2017-10-14 19:30:23', 0, 'ch4', '', '', '3.png'),
(108, 'travel', 'sally', 'what is the plan for today ?', '2017-10-14 19:31:31', 0, 'ch4', '', '', '2.png'),
(109, '', 'sally', 'Hey', '2017-10-14 19:57:20', 0, '', '', 'sally', '2.png'),
(110, '', 'mater', 'Hey', '2017-10-15 13:37:00', 0, '', '', 'mater', '1.png'),
(111, '', 'mater', 'Hey', '2017-10-15 13:37:06', 0, '', '', 'mater', '1.png'),
(112, '', 'mater', 'Hey', '2017-10-15 13:39:24', 0, '', '', 'doc', '1.png'),
(113, 'travel', 'doc', '&lt;form name=&quot;sub&quot; method=&quot;post&quot; action=&quot;index.php?act=show_chars_info&quot;&gt;', '2017-10-15 13:49:41', 0, 'ch4', '', '', '3.png'),
(114, 'travel', 'doc', '&lt;form name=&quot;sub&quot; method=&quot;post&quot; action=&quot;index.php?act=show_chars_info&quot;&gt;', '2017-10-15 13:49:45', 0, 'ch4', '', '', '3.png'),
(115, 'travel', 'doc', '&lt;form name=&quot;sub&quot; method=&quot;post&quot; action=&quot;index.php?act=show_chars_info&quot;&gt;', '2017-10-15 14:03:43', 0, 'ch4', '', '', '3.png'),
(116, 'travel', 'doc', '&lt;form name=&quot;sub&quot; method=&quot;post&quot; action=&quot;index.php?act=show_chars_info&quot;&gt;', '2017-10-15 14:04:02', 0, 'ch4', '', '', '3.png'),
(117, 'travel', 'doc', '&lt;form name=&quot;sub&quot; method=&quot;post&quot; action=&quot;index.php?act=show_chars_info&quot;&gt;', '2017-10-15 14:05:02', 0, 'ch4', '', '', '3.png'),
(118, 'travel', 'doc', '&lt;form name=&quot;sub&quot; method=&quot;post&quot; action=&quot;index.php?act=show_chars_info&quot;&gt;', '2017-10-15 14:05:30', 0, 'ch4', '', '', '3.png'),
(119, 'travel', 'doc', '&lt;form name=&quot;sub&quot; method=&quot;post&quot; action=&quot;index.php?act=show_chars_info&quot;&gt;', '2017-10-15 14:06:06', 0, 'ch4', '', '', '3.png'),
(120, 'travel', 'doc', '&lt;form name=&quot;sub&quot; method=&quot;post&quot; action=&quot;index.php?act=show_chars_info&quot;&gt;', '2017-10-15 14:06:21', 0, 'ch4', '', '', '3.png'),
(121, 'travel', 'doc', '&lt;form name=&quot;sub&quot; method=&quot;post&quot; action=&quot;index.php?act=show_chars_info&quot;&gt;', '2017-10-15 14:07:02', 0, 'ch4', '', '', '3.png'),
(122, 'travel', 'doc', '&lt;form name=&quot;sub&quot; method=&quot;post&quot; action=&quot;index.php?act=show_chars_info&quot;&gt;', '2017-10-15 14:08:16', 0, 'ch4', '', '', '3.png'),
(123, 'travel', 'mater', 'hey', '2017-10-15 17:30:19', 0, 'ch4', '', '', '1.png'),
(124, 'travel', 'mater', 'hey', '2017-10-15 17:30:22', 0, 'ch4', '', '', '1.png'),
(125, '', 'mater', 'hey', '2017-10-15 17:51:52', 0, '', '', 'sally', '1.png'),
(126, '', 'mater', 'hey', '2017-10-15 17:33:57', 0, '', '', 'sally', '1.png'),
(127, '', 'sally', 'hey', '2017-10-15 17:53:09', 0, '', '', 'mater', '2.png'),
(128, '', 'sally', 'Hello there', '2017-10-15 19:36:41', 0, '', '', 'mater', '2.png'),
(129, '', 'sally', 'gsdhwwh', '2017-10-15 19:36:56', 0, '', '', 'mater', '2.png'),
(130, '', 'sally', 'gsdhwwh', '2017-10-15 19:37:39', 0, '', '', 'mater', '2.png');

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
