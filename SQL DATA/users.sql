-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 24 2017 г., 22:54
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
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_group` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `id_group`) VALUES
(1, 'Artem Fedorov', 'pomoshhuk@gmail.com', '$2y$10$qnE2XlCStTn5Jf.FOHVG1ORX8dEeL76XFAek8PSAlt6Wgt6rJ9YGe', 'teacher', 'XJUnZDC2pHtYN9zkyB1h9r4p8i3wlNKNuC1etzbXl9PqBrXr7XOEJO4bAXsP', '2016-12-17 19:49:11', '2017-03-23 23:18:01', 1),
(2, 'Second user', 'second@gmail.com', '$2y$10$TZIXr/YbrlCBuT6Xt56AYO3kQL7M3JYDxnshzHKSEKETasAyYbWOW', 'user', 'cGtJu4kC4SEkK3U1XX8HM5nPBUAfD911r6mxJLggP5QO9xkCS5reEkdb4ZNa', '2017-01-03 18:39:48', '2017-03-23 22:28:09', 1),
(12, 'Александр Палецкий', 'palec@mail.ru', '$2y$10$NtqrbEp/qHLjPpFqDPHIeO2lBhmY.9vjtMptPfkspLNjt9rV3cUBy', 'user', 'UAMlT2Ni29VrkL2o9RfwApbqRXOHyETFHq5psdm8DSiKnYZl6GCI3DNizQ1w', '2017-03-06 22:54:50', '2017-03-23 12:20:26', 4),
(13, 'Дмитрий Кушнир', 'hecmatyar@anime.ru', '$2y$10$TCRVIA/dh.uoAsdWaqyuJu.efhYHpS3cGqhAk6cY4M02d1Z3NseMm', 'user', 'l0LO0W9mzzYi2ija73qOX8MylRDqGLaJLX9AOytqMcqMzGyOgOKg3TNoY4wx', '2017-03-11 12:26:20', '2017-03-12 15:50:51', 8),
(14, 'Евгений Шелков', 'shelkov@mail.ru', '$2y$10$gs4NsRiSpzJTW0dSFYN2T.vjpLEmdk/qw3WrXIiGm8A0Qks2oUyWy', 'user', 'rA04ZfqgY019igTluvfbHqTpUDMuc5cjH9zuVM6lyra2JKaOqc3ZtmdW81en', '2017-03-12 14:05:16', '2017-03-12 15:05:02', 1),
(15, 'Нижегородова Маргарита Владимирована', 'margarita@mail.ru', '$2y$10$qUuPtxpURfHT/fvd49soFu/62jsWsZAFC2LePFxe.XrcOmSbc8yJ2', 'admin', 'FUNOiktRvVRqIE3lSaOZd8fJp4WWx1FoU3z4r81Esy8ve8ZBetZz5vE2WDKe', '2017-03-12 14:10:48', '2017-03-21 18:41:54', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
