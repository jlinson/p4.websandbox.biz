-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 23, 2013 at 12:32 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `websandb_p4_websandbox_biz`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_games`
--

CREATE TABLE IF NOT EXISTS `tbl_games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level_cd` tinyint(1) NOT NULL COMMENT 'Code value of 1 to 5  - decode in Levels code table. (Possibly 0 for undefined game difficulty.)',
  `grid_string` varchar(400) NOT NULL COMMENT 'Grid entry encoding should not take more than 36 cells at 8 char per cell, but allow for max of 50 cells or 400 char.',
  PRIMARY KEY (`id`),
  KEY `fk_tbl_games_tbl_levels1_idx` (`level_cd`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This holds the stored game grids (formerly held in hard-coded gameStore array in P3.)' AUTO_INCREMENT=32 ;

--
-- Dumping data for table `tbl_games`
--

INSERT INTO `tbl_games` (`id`, `level_cd`, `grid_string`) VALUES
(1, 1, '"c03:2","c04:4","c05:1","c06:8","c07:3","c10:4","c12:2","c16:5","c20:6","c23:5","c25:7","c27:4","c28:1","c32:4","c37:5","c41:8","c42:1","c43:9","c45:5","c46:3","c47:4","c51:2","c56:8","c60:6","c61:9","c63:4","c65:5","c68:3","c72:7","c76:2","c78:4","c81:3","c82:2","c83:7","c84:1","c85:6"'),
(2, 1, '"c01:3","c03:6","c08:8","c10:8","c12:2","c13:4","c14:9","c15:7","c21:6","c23:8","c26:7","c28:1","c32:5","c35:9","c36:7","c37:8","c40:6","c42:9","c46:2","c48:1","c51:8","c52:7","c53:5","c56:6","c60:2","c62:3","c65:1","c67:7","c73:5","c74:2","c75:4","c76:1","c78:8","c80:4","c85:6","c87:9"'),
(3, 1, '"c03:2","c04:4","c05:1","c06:8","c07:3","c10:4","c12:2","c16:5","c20:6","c23:5","c25:7","c27:4","c28:1","c32:4","c37:5","c41:8","c42:1","c43:9","c45:5","c46:3","c47:4","c51:2","c56:8","c60:6","c61:9","c63:4","c65:5","c68:3","c72:7","c76:2","c78:4","c81:3","c82:2","c83:7","c84:1","c85:6"'),
(4, 1, '"c00:4","c03:9","c05:3","c06:1","c12:8","c13:5","c17:3","c18:2","c20:3","c21:1","c22:6","c27:7","c30:8","c32:4","c35:1","c37:6","c41:5","c43:9","c45:7","c47:4","c51:2","c53:6","c56:9","c58:3","c61:3","c66:7","c67:4","c68:2","c70:1","c71:6","c75:5","c76:3","c82:7","c83:8","c85:4","c88:5"'),
(5, 1, '"c02:5","c03:2","c05:9","c11:7","c12:2","c16:9","c18:3","c20:1","c23:6","c25:7","c26:8","c28:5","c31:1","c34:9","c36:7","c38:6","c40:4","c43:3","c45:7","c48:5","c50:7","c52:2","c54:8","c57:1","c60:3","c62:4","c63:6","c65:1","c68:8","c70:1","c72:6","c76:2","c77:3","c83:9","c85:4","c86:5"'),
(6, 1, '"c02:7","c04:2","c06:5","c07:6","c11:5","c13:9","c14:1","c18:3","c20:8","c23:4","c24:5","c28:7","c32:6","c33:7","c34:8","c37:3","c41:3","c43:1","c45:9","c47:4","c51:9","c54:3","c55:4","c56:6","c60:3","c64:1","c65:9","c68:8","c70:6","c74:7","c75:5","c77:2","c81:7","c82:8","c84:4","c86:5"'),
(7, 1, '"c04:8","c05:3","c06:5","c07:4","c12:8","c13:5","c14:9","c18:2","c20:5","c23:4","c24:2","c27:9","c30:9","c32:2","c34:3","c37:7","c40:8","c42:5","c46:9","c48:1","c51:1","c54:5","c56:3","c58:6","c61:1","c64:2","c65:4","c68:6","c70:2","c74:7","c75:3","c76:4","c81:4","c82:7","c83:9","c84:6"'),
(8, 1, '"c00:3","c01:4","c03:2","c04:5","c11:5","c14:7","c16:1","c18:9","c21:7","c22:2","c24:8","c26:5","c27:3","c32:8","c35:3","c36:5","c38:4","c40:9","c48:2","c50:4","c52:7","c53:2","c56:8","c61:1","c62:5","c64:3","c66:8","c67:9","c70:2","c72:3","c74:9","c77:4","c84:2","c85:5","c87:6","c88:1"'),
(9, 1, '"c01:3","c02:4","c04:6","c06:7","c07:8","c10:1","c12:6","c13:2","c15:8","c20:7","c27:6","c28:9","c30:6","c31:9","c32:8","c34:7","c36:2","c43:9","c45:4","c52:2","c54:8","c56:3","c57:9","c58:1","c60:4","c61:1","c68:7","c73:8","c75:9","c76:5","c78:3","c81:5","c82:3","c84:1","c86:9","c87:4"'),
(10, 1, '"c01:9","c02:3","c04:6","c06:4","c13:3","c14:8","c15:9","c17:6","c21:5","c24:1","c28:2","c32:6","c33:5","c34:4","c36:8","c38:9","c42:7","c44:3","c46:5","c50:5","c52:1","c54:6","c55:8","c56:2","c60:1","c64:7","c67:3","c71:7","c73:9","c74:2","c75:1","c82:9","c84:3","c86:1","c87:2"'),
(11, 1, '"c00:6","c01:5","c07:7","c11:8","c13:6","c15:4","c17:9","c18:1","c22:1","c24:2","c27:4","c31:9","c32:5","c33:4","c35:8","c38:1","c41:6","c44:3","c47:7","c50:3","c53:7","c55:2","c56:5","c57:6","c61:4","c64:3","c66:1","c70:8","c71:1","c73:7","c75:5","c77:2","c81:7","c87:5","c88:6"'),
(12, 1, '"c01:2","c04:8","c05:3","c13:9","c14:4","c15:5","c16:8","c18:6","c21:4","c23:6","c27:1","c30:9","c34:6","c35:4","c36:8","c38:7","c41:3","c44:5","c47:9","c50:2","c52:8","c53:1","c54:3","c58:6","c61:9","c65:2","c67:4","c70:4","c72:7","c73:3","c74:6","c75:9","c83:7","c84:8","c87:9"'),
(13, 1, '"c00:8","c01:6","c02:9","c03:4","c05:5","c07:2","c10:1","c12:4","c16:8","c18:5","c21:3","c32:8","c34:1","c35:7","c38:3","c41:2","c42:1","c44:3","c46:6","c47:8","c50:6","c53:2","c54:8","c56:9","c67:9","c70:2","c72:6","c76:7","c78:3","c81:9","c83:4","c85:5","c86:8","c87:1","c88:6"'),
(14, 2, '"c04:8","c07:2","c10:3","c12:6","c14:4","c15:9","c21:8","c25:1","c26:9","c27:3","c28:4","c30:1","c33:5","c36:8","c37:4","c40:2","c43:9","c45:8","c48:3","c51:7","c52:8","c55:2","c58:6","c60:4","c61:7","c62:1","c63:3","c67:9","c73:8","c74:9","c76:4","c78:7","c81:2","c84:1"'),
(15, 2, '"c01:5","c04:2","c06:7","c07:6","c13:1","c14:6","c16:9","c18:4","c22:7","c27:2","c28:1","c32:1","c34:3","c35:9","c36:4","c38:5","c44:8","c50:8","c52:9","c53:6","c54:7","c56:2","c60:3","c61:4","c66:5","c70:7","c72:8","c74:1","c75:2","c81:5","c82:2","c84:3","c87:9"'),
(16, 3, '"c00:4","c04:6","c08:9","c12:5","c14:7","c16:8","c20:1","c24:2","c28:3","c32:5","c34:3","c36:2","c40:6","c41:1","c44:2","c47:8","c48:3","c52:4","c54:5","c56:7","c60:6","c64:9","c68:1","c72:4","c74:5","c76:7","c80:9","c84:6","c88:8"'),
(17, 3, '"c02:8","c03:6","c08:4","c10:1","c11:5","c12:9","c15:4","c25:9","c27:2","c31:8","c32:3","c33:2","c35:1","c42:2","c44:8","c46:9","c53:7","c54:5","c56:2","c63:7","c72:3","c73:6","c77:2","c78:1","c80:5","c81:8","c82:6","c84:9","c88:3"'),
(18, 4, '"c02:6","c05:9","c06:8","c10:8","c14:7","c16:2","c17:3","c18:4","c20:4","c30:5","c35:7","c36:2","c37:1","c44:2","c51:2","c52:7","c53:6","c58:5","c68:8","c70:9","c71:4","c72:2","c74:6","c78:1","c82:6","c83:3","c86:7"'),
(19, 4, '"c01:9","c03:2","c05:6","c08:1","c10:6","c13:1","c18:3","c27:4","c30:4","c32:5","c38:9","c41:7","c43:3","c45:5","c47:6","c50:6","c56:7","c58:8","c61:3","c70:2","c75:9","c78:8","c80:1","c83:8","c85:3","c87:2"'),
(20, 5, '"c01:5","c04:6","c06:9","c10:7","c14:5","c17:6","c22:6","c24:1","c27:7","c30:6","c36:3","c43:9","c44:4","c45:8","c52:5","c58:1","c61:9","c64:1","c66:5","c71:2","c74:3","c78:6","c82:4","c84:9","c87:8"'),
(21, 5, '"c03:5","c05:3","c08:9","c10:8","c14:4","c16:5","c18:1","c28:4","c30:9","c33:2","c34:5","c40:1","c48:6","c54:7","c55:3","c58:8","c60:1","c70:9","c72:8","c74:1","c78:3","c80:7","c83:9","c85:6"'),
(22, 5, '"c00:2","c02:1","c04:7","c14:5","c15:9","c16:4","c22:3","c25:1","c34:3","c37:5","c41:9","c43:7","c45:6","c47:8","c51:6","c54:4","c63:7","c66:6","c72:8","c73:9","c74:2","c84:3","c86:2","c88:9"'),
(24, 5, '"c00:5","c13:7","c14:6","c15:9","c21:7","c22:4","c24:5","c25:1","c30:2","c32:9","c33:4","c42:7","c44:8","c46:1","c55:9","c56:3","c58:6","c64:2","c66:8","c67:1","c73:8","c74:7","c75:1","c88:3"'),
(25, 5, '"c04:7","c05:6","c06:3","c08:8","c18:9","c25:5","c27:4","c28:2","c31:8","c33:5","c38:9","c40:7","c45:3","c46:2","c48:4","c51:1","c56:5","c63:2","c64:6","c68:4","c78:5","c83:8","c87:6","c88:3"'),
(26, 5, '"c01:4","c02:7","c03:2","c07:9","c10:9","c13:1","c17:6","c20:3","c27:8","c32:8","c33:5","c37:6","c38:2","c47:5","c50:9","c57:1","c61:3","c62:4","c63:6","c77:7","c80:2","c84:4","c86:8","c87:9"'),
(27, 5, '"c01:7","c07:1","c12:3","c13:4","c17:7","c18:2","c27:6","c35:9","c38:4","c45:7","c46:9","c48:1","c51:2","c53:3","c54:5","c58:8","c64:2","c70:2","c75:9","c77:5","c81:8","c85:7","c87:4"'),
(28, 5, '"c00:5","c08:9","c10:4","c17:5","c18:8","c22:3","c28:2","c32:3","c35:6","c37:1","c41:7","c42:9","c43:5","c47:3","c50:8","c58:5","c65:8","c66:4","c67:7","c72:2","c73:1","c74:6","c88:9"'),
(29, 5, '"c00:1","c01:5","c04:8","c11:4","c15:9","c27:8","c28:1","c31:3","c35:2","c43:7","c44:5","c45:8","c53:6","c57:5","c60:7","c61:6","c64:9","c71:1","c73:5","c77:3","c84:7","c87:2","c88:8"'),
(30, 5, '"c03:1","c08:4","c12:4","c14:3","c18:6","c20:7","c21:5","c25:8","c37:8","c38:9","c42:5","c50:2","c51:6","c57:4","c63:7","c67:5","c68:2","c70:5","c74:4","c76:9","c80:1","c85:9"'),
(31, 5, '"c02:7","c08:4","c11:3","c13:5","c17:2","c26:1","c28:7","c31:8","c37:9","c43:2","c44:1","c45:8","c51:4","c56:2","c57:1","c60:1","c62:5","c73:8","c75:3","c77:9","c80:7","c86:4"');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_games_played`
--

CREATE TABLE IF NOT EXISTS `tbl_games_played` (
  `users_id` int(11) NOT NULL,
  `games_id` int(10) unsigned NOT NULL,
  `datetime` int(10) unsigned NOT NULL COMMENT 'Unix timestamp of datetime game completed.  Unsigned because no game will have been played prior to beginninig of Unix time.',
  `total_time` int(11) NOT NULL COMMENT 'Seconds to complete game. Unlike saved game timer (saved as formatted string), this field should be integer seconds to facilitate average time calculations.',
  PRIMARY KEY (`users_id`,`games_id`,`datetime`),
  KEY `fk_tbl_games_played_tbl_users1_idx` (`users_id`),
  KEY `fk_tbl_games_played_tbl_games1_idx` (`games_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Records games played and time achieved for a registered user /* comment truncated */ /*. Used to show best time and average times.*/';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_games_saved`
--

CREATE TABLE IF NOT EXISTS `tbl_games_saved` (
  `users_id` int(11) NOT NULL,
  `games_id` int(10) unsigned NOT NULL,
  `timer` varchar(10) NOT NULL DEFAULT '00:00:00' COMMENT 'hh:mm:ss -  as formated string',
  `entries` varchar(512) NOT NULL COMMENT '81 total cells - 17 min starting cells = 64 max user entry cells at 8 char per cell  => size: 512 max',
  PRIMARY KEY (`users_id`,`games_id`),
  KEY `fk_tbl_games_saved_tbl_games1_idx` (`games_id`),
  KEY `fk_tbl_games_saved_tbl_users1_idx` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Holds incomplete game saved by player.  The initial game entries are recalled via the game_id. The user entries are saved in as a string.  The timer setting is saved as well.';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_levels`
--

CREATE TABLE IF NOT EXISTS `tbl_levels` (
  `level_cd` tinyint(1) NOT NULL COMMENT 'Value of 1 to 5 plus 0 for undefined level of difficulty.',
  `level_nm` varchar(25) NOT NULL COMMENT 'Levels defined as: Undefined, Beginner, Easy, Medium, Hard, Expert',
  PRIMARY KEY (`level_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Decode table for game difficulty levels.';

--
-- Dumping data for table `tbl_levels`
--

INSERT INTO `tbl_levels` (`level_cd`, `level_nm`) VALUES
(0, 'Undefined'),
(1, 'Beginner'),
(2, 'Easy'),
(3, 'Medium'),
(4, 'Hard'),
(5, 'Expert');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1387569375),
('m110805_153437_installYiiUser', 1387569400),
('m110810_162301_userTimestampFix', 1387569400);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;


--
-- Table structure for table `tbl_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `field_type` varchar(50) NOT NULL DEFAULT '',
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` text,
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` text,
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_profiles_fields`
--

INSERT INTO `tbl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'first_name', 'First Name', 'VARCHAR', 255, 3, 2, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'last_name', 'Last Name', 'VARCHAR', 255, 3, 2, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username` (`username`),
  UNIQUE KEY `user_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_games`
--
ALTER TABLE `tbl_games`
  ADD CONSTRAINT `fk_tbl_games_tbl_levels1` FOREIGN KEY (`level_cd`) REFERENCES `tbl_levels` (`level_cd`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_games_played`
--
ALTER TABLE `tbl_games_played`
  ADD CONSTRAINT `fk_tbl_games_played_tbl_users1` FOREIGN KEY (`users_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tbl_games_played_tbl_games1` FOREIGN KEY (`games_id`) REFERENCES `tbl_games` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_games_saved`
--
ALTER TABLE `tbl_games_saved`
  ADD CONSTRAINT `fk_tbl_games_saved_tbl_games1` FOREIGN KEY (`games_id`) REFERENCES `tbl_games` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_games_saved_tbl_users1` FOREIGN KEY (`users_id`) REFERENCES `tbl_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
