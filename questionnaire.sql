-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 05 2012 г., 06:30
-- Версия сервера: 5.5.25
-- Версия PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `questionnaire`
--

-- --------------------------------------------------------

--
-- Структура таблицы `questionnaires`
--

CREATE TABLE `questionnaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` set('active','draft','closed','') NOT NULL DEFAULT 'draft',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `questionnaires`
--

INSERT INTO `questionnaires` (`id`, `name`, `status`) VALUES
(1, 'Лояльность пользователей сайта', 'active'),
(2, 'Кто вы - лох или амфибия?', 'draft');

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(300) NOT NULL,
  `id_questionnaire` int(11) NOT NULL,
  `checkbox` set('true','false') NOT NULL DEFAULT 'true',
  `required` set('true','false') NOT NULL DEFAULT 'true',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `text`, `id_questionnaire`, `checkbox`, `required`) VALUES
(1, 'Что вы ели сегодня на завтрак?', 1, 'true', '');

-- --------------------------------------------------------

--
-- Структура таблицы `results`
--

CREATE TABLE `results` (
  `pid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `aid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `variants`
--

CREATE TABLE `variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(400) NOT NULL,
  `id_question` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
