-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 20, 2011 at 05:58 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `friendface_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE IF NOT EXISTS `tbl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `author_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_comment`
--

INSERT INTO `tbl_comment` (`id`, `content`, `author_id`, `post_id`, `create_time`, `update_time`) VALUES
(1, 'Pro aperuit in deinde cepit roseo commendavit fideliter harena in.', 1, 1, 1311173552, 1311173552),
(2, 'Ephesiorum illius est in modo.', 2, 2, 1311173553, 1311173553),
(3, 'Eiusdem ordo quos ducem at actus cotidie hoc contra me testatur in.', 1, 2, 1311173554, 1311173554),
(4, 'Filiam vel per dicis eo.', 2, 1, 1311173555, 1311173555);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_connection`
--

CREATE TABLE IF NOT EXISTS `tbl_connection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) DEFAULT NULL,
  `followed_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_connection`
--

INSERT INTO `tbl_connection` (`id`, `follower_id`, `followed_id`, `create_time`, `update_time`) VALUES
(1, 1, 3, NULL, NULL),
(2, 1, 4, NULL, NULL),
(3, 2, 4, NULL, NULL),
(4, 4, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1310894607),
('m110712_072318_create_user', 1310894609),
('m110712_072831_create_profile', 1310894609),
('m110716_095905_create_post', 1310894609),
('m110719_142517_create_comment', 1311085635),
('m110719_161302_create_connection', 1311092084);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post`
--

CREATE TABLE IF NOT EXISTS `tbl_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `author_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_post`
--

INSERT INTO `tbl_post` (`id`, `content`, `author_id`, `recipient_id`, `create_time`, `update_time`) VALUES
(1, 'Pro aperuit in deinde cepit roseo commendavit fideliter harena in.', 1, 1, 1311173552, 1311173552),
(2, 'Ephesiorum illius est in modo.', 2, 2, 1311173553, 1311173553),
(3, 'Eiusdem ordo quos ducem at actus cotidie hoc contra me testatur in.', 1, 2, 1311173554, 1311173554),
(4, 'Filiam vel per dicis eo.', 2, 1, 1311173555, 1311173555);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profile`
--

CREATE TABLE IF NOT EXISTS `tbl_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `home_town` varchar(255) DEFAULT NULL,
  `current_town` varchar(255) DEFAULT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_profile`
--

INSERT INTO `tbl_profile` (`id`, `user_id`, `username`, `first_name`, `last_name`, `home_town`, `current_town`, `date_of_birth`, `profile_picture`, `create_time`, `update_time`) VALUES
(1, 1, 'profile_one', 'John', 'Smith', 'Bandung', 'Bandung', '1983-04-19 00:00:00', '8964f255b1a561d5efd7241b5c3af78f.jpg', NULL, NULL),
(2, 2, 'profile_two', 'Jane', 'Doe', 'Jakarta', 'Jakarta', '1984-02-20 00:00:00', NULL, NULL, NULL),
(3, 3, 'profile_three', 'Michael', 'Denver', 'Semarang', 'Bandung', '1985-08-11 00:00:00', '8964f255b1a561d5efd7241b5c3af78f.jpg', NULL, NULL),
(4, 4, 'profile_four', 'Virginia', 'Texas', 'Jakarta', 'Bogor', '1984-09-10 00:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` char(8) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `encrypted_password` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `last_login_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `uid`, `email`, `encrypted_password`, `salt`, `last_login_time`, `create_time`, `update_time`) VALUES
(1, '', 'test1@notanaddress.com', 'be25f39cdd0d3577d1e5d56807ca9b6e', '48b082ab3bb110bf9a7d05c1eb9d3837', NULL, NULL, NULL),
(2, '', 'test2@notanaddress.com', '32ea0c8aabd7175612db92cdbb102ff5', '48b082ab3bb110bf9a7d05c1eb9d3837', NULL, NULL, NULL),
(3, '', 'test3@notanaddress.com', '2d91af300f6495bc28d3982505b06b6c', '48b082ab3bb110bf9a7d05c1eb9d3837', NULL, NULL, NULL),
(4, '', 'test4@notanaddress.com', '395b7a3dce82dad4f7fe0cee2b444718', '48b082ab3bb110bf9a7d05c1eb9d3837', NULL, NULL, NULL);
