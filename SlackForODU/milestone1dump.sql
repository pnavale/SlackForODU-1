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
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('sampleuser1', 'samplepassword'),
('sampleuser2', 'testing'),
('testuser1', 'testpassword');

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
  `recipient_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msg_id`, `subject`, `creator_id`, `msg_body`, `create_date`, `thread_id`, `channel_id`, `group_id`, `recipient_id`) VALUES
(5, 'private', 'mcqueen', 'gfhhhh', '2017-10-09 17:29:45', 0, 'ch1', 'g1', 'mcqueen'),
(6, 'private', 'mcqueen', 'gfhhhh', '2017-10-09 17:31:17', 0, 'ch1', 'g1', 'mcqueen'),
(7, 'private', 'mcqueen', 'gfhhhh', '2017-10-09 17:31:48', 0, 'ch1', 'g1', 'mcqueen'),
(8, 'private', 'mcqueen', 'gfhhhh', '2017-10-09 17:32:13', 0, 'ch1', 'g1', 'mcqueen'),
(9, 'private', 'mcqueen', 'gfhhhh', '2017-10-09 17:33:19', 0, 'ch1', 'g1', 'mcqueen'),
(10, 'private', 'mcqueen', 'gfhhhh', '2017-10-09 17:33:59', 0, 'ch1', 'g1', 'mcqueen'),
(11, 'private', 'mcqueen', 'gfhhhh', '2017-10-09 17:34:11', 0, 'ch1', 'g1', 'mcqueen'),
(12, 'private', 'mcqueen', 'gfhhhh', '2017-10-09 17:34:12', 0, 'ch1', 'g1', 'mcqueen'),
(13, 'private', 'mcqueen', '', '2017-10-10 17:12:28', 0, 'ch1', 'g1', 'mcqueen'),
(14, 'private', 'mcqueen', '', '2017-10-10 17:12:36', 0, 'ch1', 'g1', 'mcqueen'),
(15, 'private', 'mcqueen', '&lt;!dsjd&gt;', '2017-10-10 17:16:03', 0, 'ch1', 'g1', 'mcqueen'),
(16, 'private', 'mcqueen', '&lt;!skdjksd&gt;', '2017-10-10 17:16:29', 0, 'ch1', 'g1', 'mcqueen'),
(17, 'private', 'mcqueen', '&lt;!skdjksd&gt;', '2017-10-10 17:16:34', 0, 'ch1', 'g1', 'mcqueen'),
(18, 'private', 'mcqueen', '&lt;!skdjksd&gt;', '2017-10-10 17:16:46', 0, 'ch1', 'g1', 'mcqueen'),
(19, 'private', 'mcqueen', '&lt;!skdjksd&gt;', '2017-10-10 17:17:33', 0, 'ch1', 'g1', 'mcqueen'),
(20, 'private', 'mcqueen', '&lt;!skdjksd&gt;', '2017-10-10 17:17:55', 0, 'ch1', 'g1', 'mcqueen'),
(21, 'private', 'mcqueen', '&lt;!skdjksd&gt;', '2017-10-10 17:19:09', 0, 'ch1', 'g1', 'mcqueen'),
(22, 'private', 'mcqueen', '&lt;djsjdkjskjkdjkdjckdcldlk&gt;', '2017-10-10 17:20:10', 0, 'ch1', 'g1', 'mcqueen'),
(23, 'private', 'mcqueen', '&lt;djsjdkjskjkdjkdjckdcldlk&gt;', '2017-10-10 17:20:19', 0, 'ch1', 'g1', 'mcqueen'),
(24, 'private', 'mcqueen', 'fgghgvhgv', '2017-10-11 16:30:22', 0, 'ch1', 'g1', 'mcqueen'),
(25, 'private', 'mcqueen', 'fgghgvhgv', '2017-10-11 16:48:13', 0, 'ch1', 'g1', 'mcqueen'),
(26, 'private', 'mcqueen', 'hsdjjsdje', '2017-10-11 16:48:46', 0, 'ch1', 'g1', 'mcqueen'),
(27, 'private', 'mcqueen', 'hsdjjsdje', '2017-10-11 16:49:32', 0, 'ch1', 'g1', 'mcqueen'),
(28, 'private', 'mcqueen', 'hsdjjsdje', '2017-10-11 16:50:37', 0, 'ch1', 'g1', 'mcqueen'),
(29, 'private', 'mcqueen', 'hsdjjsdje', '2017-10-11 16:51:17', 0, 'ch1', 'g1', 'mcqueen'),
(30, 'private', 'mcqueen', 'djkdjfkj', '2017-10-11 16:51:32', 0, 'ch1', 'g1', 'mcqueen'),
(31, 'private', 'mcqueen', 'asmita', '2017-10-11 16:51:40', 0, 'ch1', 'g1', 'mcqueen'),
(32, 'private', 'mcqueen', 'asmita', '2017-10-11 16:51:52', 0, 'ch1', 'g1', 'mcqueen'),
(33, 'private', 'mcqueen', 'asmita', '2017-10-11 16:53:13', 0, 'ch1', 'g1', 'mcqueen'),
(34, 'private', 'mcqueen', 'yghghkggjlk', '2017-10-11 16:53:32', 0, 'ch1', 'g1', 'mcqueen'),
(35, 'private', 'mcqueen', 'yghghkggjlk', '2017-10-11 16:55:14', 0, 'ch1', 'g1', 'mcqueen'),
(36, 'private', 'mcqueen', 'yghghkggjlk', '2017-10-11 16:59:21', 0, 'ch1', 'g1', 'mcqueen'),
(37, 'private', 'mcqueen', 'Hello there', '2017-10-11 16:59:46', 0, 'ch1', 'g1', 'mcqueen'),
(38, 'private', 'mcqueen', 'Hello there', '2017-10-11 17:01:43', 0, 'ch1', 'g1', 'mcqueen'),
(39, 'private', 'mcqueen', 'lovely !!!!!!!!!!!!', '2017-10-11 17:02:49', 0, 'ch1', 'g1', 'mcqueen'),
(40, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 17:08:02', 0, 'ch1', 'g1', 'mcqueen'),
(41, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 17:08:07', 0, 'ch1', 'g1', 'mcqueen'),
(42, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 17:10:28', 0, 'ch1', 'g1', 'mcqueen'),
(43, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 17:14:16', 0, 'ch1', 'g1', 'mcqueen'),
(44, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 17:16:13', 0, 'ch1', 'g1', 'mcqueen'),
(45, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 17:22:10', 0, 'ch1', 'g1', 'mcqueen'),
(46, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 17:23:32', 0, 'ch1', 'g1', 'mcqueen'),
(47, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 17:24:02', 0, 'ch1', 'g1', 'mcqueen'),
(48, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 18:00:33', 0, 'ch1', 'g1', 'mcqueen'),
(49, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 18:00:59', 0, 'ch1', 'g1', 'mcqueen'),
(50, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 18:01:15', 0, 'ch1', 'g1', 'mcqueen'),
(51, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 18:02:09', 0, 'ch1', 'g1', 'mcqueen'),
(52, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 18:03:15', 0, 'ch1', 'g1', 'mcqueen'),
(53, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 18:03:25', 0, 'ch1', 'g1', 'mcqueen'),
(54, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 18:18:46', 0, 'ch1', 'g1', 'mcqueen'),
(55, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 18:19:33', 0, 'ch1', 'g1', 'mcqueen'),
(56, 'private', 'mcqueen', 'dkjjkj', '2017-10-11 18:20:26', 0, 'ch1', 'g1', 'mcqueen'),
(57, 'private', 'mcqueen', 'sdkjskj', '2017-10-13 18:19:39', 0, 'ch1', 'g1', 'mcqueen'),
(58, 'private', 'mcqueen', 'sdkjskj', '2017-10-13 18:19:42', 0, 'ch1', 'g1', 'mcqueen'),
(59, 'private', 'mcmissile', 'sdkjskj', '2017-10-13 18:22:48', 0, '', '', 'mcqueen'),
(60, 'private', 'mcmissile', 'djsdkjkjk', '2017-10-13 18:22:59', 0, '', '', 'mcqueen'),
(61, 'private', 'mcmissile', '&lt;!jdhjshdjhsdjd&gt;', '2017-10-13 18:23:08', 0, '', '', 'mcqueen'),
(62, 'private', 'mcmissile', '&lt;!kjskdjkdk&gt;', '2017-10-13 18:23:19', 0, '', '', 'mcqueen'),
(63, 'private', 'mcmissile', '&lt;!kjskdjkdk&gt;', '2017-10-13 18:24:14', 0, '', '', 'mcqueen'),
(64, 'private', '', '&lt;!kjskdjkdk&gt;', '2017-10-13 18:25:33', 0, '', '', 'mcqueen'),
(65, 'private', 'slackbot', '', '2017-10-13 18:49:56', 0, '', '', 'mcqueen');

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
('u2', 'sally', 'abcabc', 'porsche@rsprings.gov', NULL, 'Sally Carrera', 'wk1', 'ch1', '2.png', '2017-09-01 03:00:00'),
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
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

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
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
