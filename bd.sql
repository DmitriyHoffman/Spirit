-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 22 2020 г., 17:35
-- Версия сервера: 5.5.62
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `engmn_bots`
--

CREATE TABLE `engmn_bots` (
  `id` int(11) NOT NULL,
  `bot_login` varchar(50) NOT NULL,
  `bot_min_bet` varchar(50) NOT NULL DEFAULT '1',
  `bot_max_bet` varchar(50) NOT NULL DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `engmn_config`
--

CREATE TABLE `engmn_config` (
  `id` int(11) NOT NULL,
  `sitename` varchar(50) NOT NULL DEFAULT 'KotDev',
  `sitedomen` varchar(50) NOT NULL,
  `sitegroup` varchar(50) NOT NULL,
  `sitesupport` varchar(150) NOT NULL,
  `sitekey` varchar(150) NOT NULL,
  `sitemail` varchar(50) NOT NULL,
  `min_bonus_size` varchar(50) NOT NULL DEFAULT '1',
  `max_bonus_size` varchar(50) NOT NULL DEFAULT '10',
  `minbonusdep` int(11) NOT NULL,
  `min_withdraw_sum` varchar(50) NOT NULL DEFAULT '50',
  `bonus_reg` varchar(50) NOT NULL DEFAULT '5',
  `ref_per` int(11) NOT NULL,
  `ref_sum` int(11) NOT NULL,
  `fk_id` varchar(50) NOT NULL,
  `fk_secret_1` varchar(50) NOT NULL,
  `fk_secret_2` varchar(50) NOT NULL,
  `fksecretkey` text NOT NULL,
  `dep_withdraw` varchar(50) NOT NULL DEFAULT '0',
  `min_bet` varchar(50) NOT NULL DEFAULT '1',
  `max_bet` varchar(50) NOT NULL DEFAULT '1000',
  `min_per` varchar(50) NOT NULL DEFAULT '1',
  `max_per` varchar(50) NOT NULL DEFAULT '95',
  `fake_online` varchar(50) NOT NULL DEFAULT '0',
  `fake_interval` varchar(50) NOT NULL DEFAULT '0',
  `min_sum_dep` varchar(50) NOT NULL DEFAULT '1',
  `betsum` int(11) NOT NULL,
  `bsum` int(11) NOT NULL,
  `workdata` text NOT NULL,
  `encpass` int(11) NOT NULL,
  `ytvideo` text NOT NULL,
  `betsumreload` int(11) NOT NULL,
  `min_rating` int(11) NOT NULL,
  `max_rating` int(11) NOT NULL,
  `min_top_rating` int(11) NOT NULL,
  `max_top_rating` int(11) NOT NULL,
  `sysmsgint` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `engmn_config`
--

INSERT INTO `engmn_config` (`id`, `sitename`, `sitedomen`, `sitegroup`, `sitesupport`, `sitekey`, `sitemail`, `min_bonus_size`, `max_bonus_size`, `minbonusdep`, `min_withdraw_sum`, `bonus_reg`, `ref_per`, `ref_sum`, `fk_id`, `fk_secret_1`, `fk_secret_2`, `fksecretkey`, `dep_withdraw`, `min_bet`, `max_bet`, `min_per`, `max_per`, `fake_online`, `fake_interval`, `min_sum_dep`, `betsum`, `bsum`, `workdata`, `encpass`, `ytvideo`, `betsumreload`, `min_rating`, `max_rating`, `min_top_rating`, `max_top_rating`, `sysmsgint`) VALUES
(1, 'Спасибо за покупку', 'Enigman', 'https://vk.cc/ah5wmt', 'https://vk.cc/ah5wmt', '', '', '1', '10', 10, '1', '10', 50, 5, '123', '123', '123', '', '50', '2', '99999', '1', '98', '4', '1000', '1', 0, 0, '2020-01-01', 0, 'RciTnNIC3Tg', 0, 1000, 50000, 55000, 1000000, 5000);

-- --------------------------------------------------------

--
-- Структура таблицы `engmn_games`
--

CREATE TABLE `engmn_games` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `number` varchar(50) NOT NULL,
  `cel` varchar(50) NOT NULL,
  `sum` varchar(50) NOT NULL,
  `chance` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `win_summa` varchar(50) NOT NULL,
  `bot` text NOT NULL,
  `color` text NOT NULL,
  `colordrop` text NOT NULL,
  `mode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `engmn_messages`
--

CREATE TABLE `engmn_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `text` text NOT NULL,
  `prefix` text NOT NULL,
  `admin_hide` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `engmn_payments`
--

CREATE TABLE `engmn_payments` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `suma` varchar(50) NOT NULL,
  `data` varchar(50) NOT NULL,
  `qiwi` varchar(50) NOT NULL,
  `transaction` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `engmn_promo`
--

CREATE TABLE `engmn_promo` (
  `id` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  `is_admin` varchar(1) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `sum` varchar(50) NOT NULL,
  `active` varchar(50) NOT NULL,
  `actived` varchar(50) NOT NULL DEFAULT '0',
  `id_active` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `engmn_sysmsg`
--

CREATE TABLE `engmn_sysmsg` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `engmn_user`
--

CREATE TABLE `engmn_user` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `vk_name` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `balance` varchar(50) NOT NULL,
  `img` varchar(250) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `social` varchar(150) NOT NULL,
  `bdate` varchar(50) NOT NULL,
  `online` varchar(1) NOT NULL DEFAULT '1',
  `admin` varchar(1) NOT NULL DEFAULT '0',
  `ban` varchar(1) NOT NULL DEFAULT '0',
  `chat_ban` int(11) DEFAULT '0',
  `sliv` varchar(1) NOT NULL DEFAULT '0',
  `win` varchar(1) NOT NULL DEFAULT '0',
  `ref_id` varchar(11) NOT NULL DEFAULT '0',
  `ref_code` text NOT NULL,
  `ip` varchar(50) NOT NULL,
  `date_reg` varchar(50) NOT NULL,
  `online_time` varchar(50) NOT NULL,
  `encpass` int(11) NOT NULL,
  `betsum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `engmn_withdraws`
--

CREATE TABLE `engmn_withdraws` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `ps` varchar(50) NOT NULL,
  `wallet` varchar(50) NOT NULL,
  `sum` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  `fake` varchar(1) NOT NULL DEFAULT '0',
  `login_fake` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `engmn_bots`
--
ALTER TABLE `engmn_bots`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `engmn_config`
--
ALTER TABLE `engmn_config`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `engmn_games`
--
ALTER TABLE `engmn_games`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `engmn_messages`
--
ALTER TABLE `engmn_messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `engmn_payments`
--
ALTER TABLE `engmn_payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `engmn_promo`
--
ALTER TABLE `engmn_promo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `engmn_sysmsg`
--
ALTER TABLE `engmn_sysmsg`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `engmn_user`
--
ALTER TABLE `engmn_user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `engmn_withdraws`
--
ALTER TABLE `engmn_withdraws`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `engmn_bots`
--
ALTER TABLE `engmn_bots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `engmn_config`
--
ALTER TABLE `engmn_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `engmn_games`
--
ALTER TABLE `engmn_games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `engmn_messages`
--
ALTER TABLE `engmn_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `engmn_payments`
--
ALTER TABLE `engmn_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `engmn_promo`
--
ALTER TABLE `engmn_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `engmn_sysmsg`
--
ALTER TABLE `engmn_sysmsg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `engmn_user`
--
ALTER TABLE `engmn_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `engmn_withdraws`
--
ALTER TABLE `engmn_withdraws`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
