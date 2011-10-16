-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 16. Oktober 2011 um 23:35
-- Server Version: 5.1.53
-- PHP-Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `fs2`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fs2_captcha_config`
--

DROP TABLE IF EXISTS `fs2_captcha_config`;
CREATE TABLE `fs2_captcha_config` (
  `id` tinyint(1) NOT NULL,
  `captcha_bg_color` varchar(6) NOT NULL DEFAULT 'FFFFFF',
  `captcha_bg_transparent` tinyint(1) NOT NULL DEFAULT '0',
  `captcha_text_color` varchar(6) NOT NULL DEFAULT '000000',
  `captcha_first_lower` smallint(3) NOT NULL DEFAULT '1',
  `captcha_first_upper` smallint(3) NOT NULL DEFAULT '5',
  `captcha_second_lower` smallint(3) NOT NULL DEFAULT '1',
  `captcha_second_upper` smallint(3) NOT NULL DEFAULT '5',
  `captcha_use_addition` tinyint(1) NOT NULL DEFAULT '1',
  `captcha_use_subtraction` tinyint(1) NOT NULL DEFAULT '0',
  `captcha_use_multiplication` tinyint(1) NOT NULL DEFAULT '0',
  `captcha_create_easy_arithmetics` tinyint(1) NOT NULL DEFAULT '1',
  `captcha_x` smallint(3) NOT NULL DEFAULT '80',
  `captcha_y` smallint(2) NOT NULL DEFAULT '15',
  `captcha_show_questionmark` tinyint(1) NOT NULL DEFAULT '1',
  `captcha_use_spaces` tinyint(1) NOT NULL DEFAULT '1',
  `captcha_show_multiplication_as_x` tinyint(1) NOT NULL DEFAULT '1',
  `captcha_start_text_x` smallint(3) NOT NULL DEFAULT '0',
  `captcha_start_text_y` smallint(2) NOT NULL DEFAULT '0',
  `captcha_font_size` smallint(2) NOT NULL DEFAULT '3',
  `captcha_font_file` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fs2_captcha_config`
--

INSERT INTO `fs2_captcha_config` (`id`, `captcha_bg_color`, `captcha_bg_transparent`, `captcha_text_color`, `captcha_first_lower`, `captcha_first_upper`, `captcha_second_lower`, `captcha_second_upper`, `captcha_use_addition`, `captcha_use_subtraction`, `captcha_use_multiplication`, `captcha_create_easy_arithmetics`, `captcha_x`, `captcha_y`, `captcha_show_questionmark`, `captcha_use_spaces`, `captcha_show_multiplication_as_x`, `captcha_start_text_x`, `captcha_start_text_y`, `captcha_font_size`, `captcha_font_file`) VALUES
(1, 'F505F5', 0, 'FFFFFF', 1, 5, 1, 5, 1, 1, 0, 1, 58, 18, 0, 1, 1, 0, 0, 5, '');
