-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Хост: 10.0.0.153:3308
-- Время создания: Фев 27 2017 г., 11:18
-- Версия сервера: 10.1.21-MariaDB
-- Версия PHP: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ferzzz123`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(20) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Мебель'),
(2, 'Продукты'),
(3, 'Канцтовары'),
(4, 'Дизайн');

-- --------------------------------------------------------

--
-- Структура таблицы `table_modify`
--

CREATE TABLE IF NOT EXISTS `table_modify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL,
  `category_id` int(50) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Дамп данных таблицы `table_modify`
--

INSERT INTO `table_modify` (`id`, `product_name`, `category_id`, `price`) VALUES
(4, 'asd', 1, '0.00'),
(24, 'Пончикиg', 4, '10.23'),
(25, 'asd', 1, '0.00'),
(26, 'ghh', 1, '0.00'),
(29, 'asd', 2, '104.00'),
(31, 'KJK', 2, '210.06'),
(32, 'fggтттk', 2, '99999999.99'),
(33, 'dfsgdfdjjsfgsвgg', 1, '1116660.01'),
(38, 'sdf', 2, '0.00'),
(39, 'sgs', 2, '0.00'),
(40, 'afasf', 2, '0.00'),
(41, 'asdasf', 2, '0.00'),
(42, 'asd', 2, '0.00'),
(43, 'asdfasgg', 1, '0.00'),
(44, 'iiii', 4, '110.00'),
(45, 'sfasf', 3, '0.00'),
(46, 'asfasfa', 3, '0.00'),
(47, 'fhd', 2, '0.00'),
(48, 'asdfasdf', 2, '0.00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
