-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 22 2017 г., 21:16
-- Версия сервера: 5.7.14
-- Версия PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `election`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `google_auth` varchar(999) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id_admin`, `name`, `email`, `password`, `google_auth`) VALUES
(3, 'ÐÐ½Ð´Ñ€ÐµÐ¹ ÐœÐ°Ñ€Ñ‚Ñ‹Ð½ÐµÐ½ÐºÐ¾', 'admin@a', '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', 'EKPVATIAPS3SD5JE');

-- --------------------------------------------------------

--
-- Структура таблицы `cands`
--

CREATE TABLE `cands` (
  `id_cand` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `id_el` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `pic_url` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `votes` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `cands`
--

INSERT INTO `cands` (`id_cand`, `name`, `id_el`, `description`, `pic_url`, `votes`) VALUES
(1, 'Nest test', 21, 'test', 'uploads/1.jpg', 0),
(8, 'Kolyan', 26, 'Toha', 'uploads/0OOPTw5vcr8.jpg', 5),
(9, 'test', 24, 'test', '', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `els`
--

CREATE TABLE `els` (
  `id_elect` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `organisation` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `pic_url` varchar(999) COLLATE utf8_unicode_ci NOT NULL,
  `finishdate` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1 if finished'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `els`
--

INSERT INTO `els` (`id_elect`, `name`, `organisation`, `description`, `pic_url`, `finishdate`, `status`) VALUES
(28, 'Yatsura', 'vinogradar', 'lol', 'uploads/0OOPTw5vcr8.jpg', '2017-06-23', 1),
(26, 'Ð’Ð¸Ð±Ð¾Ñ€Ð¸ Ð² ÑÐº', 'Ð¡Ñ‚ÑƒÐ´ÐµÐ½Ñ‚ÑÑŒÐºÐ° ÐºÐ¾Ð»ÐµÐ³Ñ–Ñ', 'Ð¢ÐµÑÑ‚', 'uploads/3Lo9-2zhw2o.jpg', '2017-06-19', 1),
(27, 'alon mor', 'MRIA', 'sadf', 'uploads/0OOPTw5vcr8.jpg', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `voters`
--

CREATE TABLE `voters` (
  `id_voter` int(11) NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `student_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1 if voted',
  `id_elect` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `voters`
--

INSERT INTO `voters` (`id_voter`, `email`, `name`, `student_id`, `status`, `id_elect`) VALUES
(1, 'voter@voter.com', 'Voter', '123', 0, 1),
(2, 'vot@vot', 'vot', '12345', 0, 24),
(6, 'vot@vot', 'vot', '1234', 0, 26),
(4, 'zhenya@ua', 'Ð–ÐµÐ½Ñ', '1234567', 0, 26),
(5, 'lauren@surf-style.com', 'alon mor', 'af', 0, 25);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Индексы таблицы `cands`
--
ALTER TABLE `cands`
  ADD PRIMARY KEY (`id_cand`);

--
-- Индексы таблицы `els`
--
ALTER TABLE `els`
  ADD PRIMARY KEY (`id_elect`);

--
-- Индексы таблицы `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`id_voter`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `cands`
--
ALTER TABLE `cands`
  MODIFY `id_cand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `els`
--
ALTER TABLE `els`
  MODIFY `id_elect` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT для таблицы `voters`
--
ALTER TABLE `voters`
  MODIFY `id_voter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
DELIMITER $$
--
-- События
--
CREATE DEFINER=`root`@`localhost` EVENT `makenotactive` ON SCHEDULE EVERY 1 MINUTE STARTS '2017-06-19 22:41:43' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE els SET status = 1 WHERE finishdate = CURDATE()$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
