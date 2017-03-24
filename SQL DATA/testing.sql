-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 24 2017 г., 22:59
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
-- Структура таблицы `algorithms`
--

CREATE TABLE `algorithms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `algorithms`
--

INSERT INTO `algorithms` (`id`, `name`, `desc`) VALUES
(1, 'Классический тест', 'Обычный тест, где поочередно показываются вопросы с вариантами ответов, либо строка для ввода значения'),
(2, 'Тест-сопоставление', 'В этом тесте студенту выдается список вопросов и список всех ответов на одном листе. И каждому вопросу нужно сопоставить правильные варианты ответа.');

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_question` int(10) UNSIGNED NOT NULL,
  `answer` text COLLATE utf8_unicode_ci NOT NULL,
  `iscorrect` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_test` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id`, `id_question`, `answer`, `iscorrect`, `created_at`, `updated_at`, `id_test`) VALUES
(160, 98, 'создание', 1, '2017-03-17 23:57:34', '2017-03-17 23:57:34', 25),
(161, 98, 'обновление', 0, '2017-03-17 23:57:39', '2017-03-17 23:57:39', 25),
(162, 98, 'удаление', 0, '2017-03-17 23:57:44', '2017-03-17 23:57:44', 25),
(163, 98, 'добавление', 0, '2017-03-17 23:57:48', '2017-03-17 23:57:48', 25),
(164, 99, 'числовой (целое), текстовый, дата/время, числовой (с плавающей точкой), текстовый ', 1, '2017-03-17 23:58:26', '2017-03-17 23:58:26', 25),
(165, 99, 'числовой (целое), текстовый, дата/время, числовой (с плавающей точкой), числовой (с плавающей точкой)', 0, '2017-03-17 23:58:31', '2017-03-17 23:58:31', 25),
(166, 99, 'числовой (целое), текстовый, дата, время, текстовый', 0, '2017-03-17 23:58:55', '2017-03-17 23:58:55', 25),
(167, 99, 'числовой (целое), текстовый, дата/время, дата/время, текстовый', 0, '2017-03-18 00:04:32', '2017-03-18 00:04:32', 25),
(168, 100, 'первичный ключ может принимать нулевое значение ', 1, '2017-03-18 00:05:04', '2017-03-18 00:05:04', 25),
(169, 100, 'в таблице может быть назначен только один первичный ключ', 0, '2017-03-18 00:05:08', '2017-03-18 00:05:08', 25),
(170, 100, 'первичный ключ может быть простым и составным', 0, '2017-03-18 00:05:12', '2017-03-18 00:05:12', 25),
(171, 100, 'первичный ключ однозначно определяет каждую запись в таблице', 0, '2017-03-18 00:05:17', '2017-03-18 00:05:17', 25),
(176, 102, 'запроса', 1, '2017-03-18 00:38:34', '2017-03-18 20:02:24', 25),
(177, 102, 'схемы данных', 0, '2017-03-18 00:38:40', '2017-03-18 00:38:40', 25),
(178, 102, 'главной кнопочной формы', 0, '2017-03-18 00:38:44', '2017-03-18 00:38:44', 25),
(179, 102, 'составной формы', 0, '2017-03-18 00:38:50', '2017-03-18 00:38:50', 25),
(180, 104, 'некоторая модель, устанавливающая состав, порядок и принципы взаимодействия входящих в нее компонентов', 1, '2017-03-18 22:36:59', '2017-03-18 23:07:43', 27),
(181, 105, 'принцип программного управления', 1, '2017-03-18 22:38:00', '2017-03-18 23:08:39', 27),
(182, 106, 'системного блока', 1, '2017-03-18 22:38:55', '2017-03-18 23:08:44', 27),
(183, 106, 'монитора', 1, '2017-03-18 22:38:59', '2017-03-18 23:08:45', 27),
(184, 106, 'клавиатуры', 1, '2017-03-18 22:39:03', '2017-03-18 23:08:46', 27),
(185, 107, 'управления работой компьютера и обработки данных', 1, '2017-03-18 22:39:30', '2017-03-18 23:08:49', 27),
(186, 108, 'количество битов, которое воспринимается микропроцессором как единое целое', 1, '2017-03-18 22:39:51', '2017-03-18 23:08:53', 27),
(187, 109, 'мегагерцах', 1, '2017-03-18 22:40:39', '2017-03-18 23:08:56', 27),
(188, 110, '25', 1, '2017-03-23 12:24:46', '2017-03-23 12:24:46', 25);

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

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(43, '2014_10_12_000000_create_users_table', 1),
(44, '2014_10_12_100000_create_password_resets_table', 1),
(45, '2016_11_28_141635_create_tests_table', 1),
(46, '2016_11_28_152957_create_questions_table', 1),
(47, '2016_11_28_153008_create_answers_table', 1),
(49, '2016_11_28_153038_create_user_test_q_as_table', 2),
(52, '2016_12_22_160525_create_results_table', 3),
(53, '2017_01_30_195439_change_answer_table', 4),
(63, '2017_02_05_175128_change_questions_table', 5),
(64, '2017_02_06_194513_change_tests_table', 5),
(66, '2017_02_26_200936_change_user_test_qas_table', 6),
(68, '2017_02_27_013033_change_results_table', 7),
(71, '2017_03_04_205239_create_user_test_questions_table', 8),
(72, '2017_03_04_205256_create_user_test_answers_table', 8),
(79, '2017_03_06_215249_create_groups_table', 9),
(80, '2017_03_06_215336_change_users_table', 9),
(82, '2017_03_07_022443_create_test_groups_table', 10),
(83, '2017_03_11_210003_change_tests_table_2', 11),
(84, '2017_03_14_125234_create_algorythms_table', 12),
(85, '2017_03_14_150751_change_test_table_3', 13),
(88, '2017_03_16_221731_change_questions_table_2', 14),
(89, '2017_03_16_224931_change_questions_table_3', 15);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_test` int(10) UNSIGNED NOT NULL,
  `question` longtext COLLATE utf8_unicode_ci NOT NULL,
  `word` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` double(8,2) DEFAULT '1.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `id_test`, `question`, `word`, `created_at`, `updated_at`, `weight`) VALUES
(98, 25, '<p><span style="color: rgb(68, 68, 68);">В СУБД MS Access не существует запрос на _________ данных.</span></p>', 0, '2017-03-17 23:57:26', '2017-03-18 00:35:42', 2.00),
(99, 25, '<p><span style="color: rgb(68, 68, 68);">Реляционная база данных задана тремя таблицами. Поля Код спортсмена, Код дистанции, Дата соревнования, Время, Телефон соответственно должны иметь типы …</span></p><p><br></p>', 0, '2017-03-17 23:58:15', '2017-03-17 23:58:15', 2.00),
(100, 25, '<p><span style="color: rgb(68, 68, 68);">Для первичного ключа ложно утверждение, что …</span></p><p><br></p>', 0, '2017-03-18 00:04:55', '2017-03-18 00:04:55', 5.00),
(102, 25, '<p><span style="color: rgb(68, 68, 68);">Выбрать необходимые данные из одной или нескольких взаимосвязанных таблиц в MS Access, отобрать нужные поля, произвести вычисления и получить результат в виде новой таблицы можно с помощью …</span></p>', 0, '2017-03-18 00:38:24', '2017-03-18 00:38:24', 3.00),
(104, 27, '<p><span style="color: rgb(51, 51, 51);">Структура компьютера — это:</span></p>', 0, '2017-03-18 22:36:42', '2017-03-18 22:36:42', 1.00),
(105, 27, '<p><span style="color: rgb(51, 51, 51);">Основная функция ЭВМ:</span></p>', 0, '2017-03-18 22:37:50', '2017-03-18 22:37:50', 1.00),
(106, 27, '<p><span style="color: rgb(51, 51, 51);">Персональный компьютер состоит из:</span></p>', 0, '2017-03-18 22:38:52', '2017-03-18 22:38:52', 2.00),
(107, 27, '<p><span style="color: rgb(51, 51, 51);">Микропроцессор предназначен для:</span></p>', 0, '2017-03-18 22:39:24', '2017-03-18 22:39:24', 1.00),
(108, 27, '<p><span style="color: rgb(51, 51, 51);">Разрядность микропроцессора — это</span></p>', 0, '2017-03-18 22:39:45', '2017-03-18 22:39:45', 1.00),
(109, 27, '<p><span style="color: rgb(51, 51, 51);">Тактовая частота микропроцессора измеряется в:</span></p>', 0, '2017-03-18 22:40:11', '2017-03-18 22:40:11', 1.00),
(110, 25, '<p><span style="color: rgb(68, 68, 68);">В таблицу базы данных СКЛАД, содержащую 5 столбцов информации о товаре (наименование, поставщик, количество, дата окончания срока хранения, цена), внесена информация о 25 видах товара. Количество записей в таблице равно …</span></p>', 1, '2017-03-23 12:24:41', '2017-03-23 12:24:41', 1.00);

-- --------------------------------------------------------

--
-- Структура таблицы `results`
--

CREATE TABLE `results` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_test` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `percent` int(11) DEFAULT '0',
  `mark` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `results`
--

INSERT INTO `results` (`id`, `id_test`, `id_user`, `percent`, `mark`, `created_at`, `updated_at`, `passed`) VALUES
(96, 25, 2, 100, 25, NULL, '2017-03-23 22:19:29', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tests`
--

CREATE TABLE `tests` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `maxmark` int(11) NOT NULL DEFAULT '10',
  `id_alg` int(11) NOT NULL DEFAULT '1',
  `published_at` timestamp NULL DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `count_answers` int(11) DEFAULT NULL,
  `count_questions` int(11) DEFAULT NULL,
  `shuffle_questions` tinyint(1) DEFAULT '0',
  `shuffle_answers` tinyint(1) DEFAULT '0',
  `view_right_answers` tinyint(1) DEFAULT '1',
  `view_more_1_answer` tinyint(1) DEFAULT '0',
  `pass_other_questions` tinyint(1) DEFAULT '1',
  `time` varchar(255) COLLATE utf8_unicode_ci DEFAULT '00:30:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ended_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tests`
--

INSERT INTO `tests` (`id`, `name`, `id_user`, `desc`, `maxmark`, `id_alg`, `published_at`, `published`, `archive`, `count_answers`, `count_questions`, `shuffle_questions`, `shuffle_answers`, `view_right_answers`, `view_more_1_answer`, `pass_other_questions`, `time`, `created_at`, `updated_at`, `ended_at`) VALUES
(25, 'Базы данных', 1, '2 курс 1 семестр, 1 модуль', 25, 1, '2017-03-23 12:25:11', 1, 0, 24, 6, 1, 1, 1, 1, 1, '00:30:00', '2017-03-17 23:34:14', '2017-03-23 12:25:11', NULL),
(27, 'Общая информатика', 1, '1 курс 1 семестр 1 модуль', 20, 2, '2017-03-18 23:11:34', 1, 0, 8, 4, 1, 1, 0, 0, 0, '00:30:00', '2017-03-18 22:34:46', '2017-03-18 23:11:34', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `test_groups`
--

CREATE TABLE `test_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_test` int(10) UNSIGNED NOT NULL,
  `id_group` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `test_groups`
--

INSERT INTO `test_groups` (`id`, `id_test`, `id_group`) VALUES
(68, 27, 1),
(69, 27, 3),
(72, 25, 1),
(73, 25, 3);

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

-- --------------------------------------------------------

--
-- Структура таблицы `user_test_answers`
--

CREATE TABLE `user_test_answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_test` int(10) UNSIGNED NOT NULL,
  `id_answer` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_test_qas`
--

CREATE TABLE `user_test_qas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_test` int(10) UNSIGNED NOT NULL,
  `id_question` int(10) UNSIGNED NOT NULL,
  `id_answer` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user_test_qas`
--

INSERT INTO `user_test_qas` (`id`, `id_user`, `id_test`, `id_question`, `id_answer`, `created_at`, `updated_at`, `answer`) VALUES
(345, 2, 25, 99, 164, '2017-03-23 22:19:16', '2017-03-23 22:19:16', NULL),
(346, 2, 25, 110, 188, '2017-03-23 22:19:19', '2017-03-23 22:19:19', '25'),
(347, 2, 25, 98, 160, '2017-03-23 22:19:21', '2017-03-23 22:19:21', NULL),
(348, 2, 25, 100, 168, '2017-03-23 22:19:25', '2017-03-23 22:19:25', NULL),
(349, 2, 25, 102, 176, '2017-03-23 22:19:29', '2017-03-23 22:19:29', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_test_questions`
--

CREATE TABLE `user_test_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_test` int(10) UNSIGNED NOT NULL,
  `id_question` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `algorithms`
--
ALTER TABLE `algorithms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_id_question_foreign` (`id_question`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_id_test_foreign` (`id_test`);

--
-- Индексы таблицы `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `results_id_test_foreign` (`id_test`),
  ADD KEY `results_id_user_foreign` (`id_user`);

--
-- Индексы таблицы `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests_id_user_foreign` (`id_user`);

--
-- Индексы таблицы `test_groups`
--
ALTER TABLE `test_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_groups_id_test_foreign` (`id_test`),
  ADD KEY `test_groups_id_group_foreign` (`id_group`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `user_test_answers`
--
ALTER TABLE `user_test_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_test_answers_id_user_foreign` (`id_user`),
  ADD KEY `user_test_answers_id_test_foreign` (`id_test`),
  ADD KEY `user_test_answers_id_answer_foreign` (`id_answer`);

--
-- Индексы таблицы `user_test_qas`
--
ALTER TABLE `user_test_qas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_test_qas_id_user_foreign` (`id_user`),
  ADD KEY `user_test_qas_id_test_foreign` (`id_test`),
  ADD KEY `user_test_qas_id_question_foreign` (`id_question`),
  ADD KEY `user_test_qas_id_answer_foreign` (`id_answer`);

--
-- Индексы таблицы `user_test_questions`
--
ALTER TABLE `user_test_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_test_questions_id_user_foreign` (`id_user`),
  ADD KEY `user_test_questions_id_test_foreign` (`id_test`),
  ADD KEY `user_test_questions_id_question_foreign` (`id_question`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `algorithms`
--
ALTER TABLE `algorithms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;
--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT для таблицы `results`
--
ALTER TABLE `results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT для таблицы `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT для таблицы `test_groups`
--
ALTER TABLE `test_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `user_test_answers`
--
ALTER TABLE `user_test_answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `user_test_qas`
--
ALTER TABLE `user_test_qas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=350;
--
-- AUTO_INCREMENT для таблицы `user_test_questions`
--
ALTER TABLE `user_test_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_id_question_foreign` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_id_test_foreign` FOREIGN KEY (`id_test`) REFERENCES `tests` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_id_test_foreign` FOREIGN KEY (`id_test`) REFERENCES `tests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `test_groups`
--
ALTER TABLE `test_groups`
  ADD CONSTRAINT `test_groups_id_group_foreign` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_groups_id_test_foreign` FOREIGN KEY (`id_test`) REFERENCES `tests` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_test_answers`
--
ALTER TABLE `user_test_answers`
  ADD CONSTRAINT `user_test_answers_id_answer_foreign` FOREIGN KEY (`id_answer`) REFERENCES `answers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_answers_id_test_foreign` FOREIGN KEY (`id_test`) REFERENCES `tests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_answers_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_test_qas`
--
ALTER TABLE `user_test_qas`
  ADD CONSTRAINT `user_test_qas_id_answer_foreign` FOREIGN KEY (`id_answer`) REFERENCES `answers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_qas_id_question_foreign` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_qas_id_test_foreign` FOREIGN KEY (`id_test`) REFERENCES `tests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_qas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_test_questions`
--
ALTER TABLE `user_test_questions`
  ADD CONSTRAINT `user_test_questions_id_question_foreign` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_questions_id_test_foreign` FOREIGN KEY (`id_test`) REFERENCES `tests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_questions_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
