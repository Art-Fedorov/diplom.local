-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 24 2017 г., 22:53
-- Версия сервера: 10.1.19-MariaDB
-- Версия PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testing`
--

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `start_year` date NOT NULL DEFAULT '2017-09-01',
  `end_year` date NOT NULL DEFAULT '2021-09-01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `group`, `desc`, `start_year`, `end_year`) VALUES
(1, '13ПИ1', 'Программная инженерия', '2013-09-01', '2017-09-01'),
(3, '13ИС1', 'Информационные системы и технологии', '2013-09-01', '2017-09-01'),
(4, '13ИВ1', 'Информатика и вычислительная техника', '2013-09-01', '2017-09-01'),
(7, '14ИС1', 'Информационные системы и технологии', '2014-09-01', '2018-09-01'),
(8, '14ПИ1', 'Программная инженерия', '2014-09-01', '2018-09-01'),
(9, '15ПИ1', 'Программная инженерия', '2015-09-01', '2019-09-01'),
(10, '14ИВ1', 'Информатика и вычислительная техника', '2017-03-21', '2017-06-29'),
(11, '15ИВ1', 'Информатика и вычислительная техника', '2017-03-21', '2017-06-29');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
