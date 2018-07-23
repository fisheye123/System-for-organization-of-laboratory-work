-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июл 23 2018 г., 13:59
-- Версия сервера: 10.1.31-MariaDB
-- Версия PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `labservis`
--

-- --------------------------------------------------------

--
-- Структура таблицы `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` varchar(600) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `course`
--

INSERT INTO `course` (`id`, `title`, `description`, `login`, `password`) VALUES
(1, 'Экономика', 'Экономика — это такая наука,которая изучает использование различных ограниченных ресурсов с целью обеспечения удовлетворения потребностей человека и людей в целом а так же взаимоотношения между сторонами хозяйственной деятельности; а так же само хозяйство, как совокупность средств производства, которые используют люди с целью удовлетворения потребностей.', 'economy', 'economypass'),
(2, 'Методы и технологии программирования', 'Метод программирования – способ, средство, определяющие стиль написания, откладки и сопровождения программ.\r\nТехнология программирования – технологии разработки программ для ЭВМ, которые будут использоваться людьми для решения задач на ЭВМ.', 'mitp-login', 'mitp-pass'),
(3, 'Организация баз данных', 'Организация базы данных в среде MS Access', 'obd-login', 'obd-pass'),
(4, 'Методы контроля оценки качества программного обеспечения', '\r\nКак контролировать качество системы? Как точно узнать, что программа делает именно то, что нужно, и ничего другого? Как определить, что она достаточно надежна, переносима, удобна в использовании?', 'mkokpo', 'mkokpo'),
(5, 'Управление ИТ-сервисами и контентом', 'Курс предназначен для контент-менеджеров и редакторов контента, менеджеров по электронным продажам и маркетологов, веб-дизайнеров и программистов, а также блогеров и любителей.', 'uITsik', 'uITsik');

-- --------------------------------------------------------

--
-- Структура таблицы `lab`
--

CREATE TABLE `lab` (
  `id` int(11) NOT NULL,
  `number` tinyint(4) NOT NULL,
  `title` varchar(60) NOT NULL,
  `task` text NOT NULL,
  `attachment` varchar(600) NOT NULL,
  `access` tinyint(1) NOT NULL DEFAULT '0',
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lab`
--

INSERT INTO `lab` (`id`, `number`, `title`, `task`, `attachment`, `access`, `course_id`) VALUES
(1, 1, 'Обзор возможностей ECM-систем', 'Цель работы: познакомиться с функциональными возможностями коробочных систем управления корпоративным контентом.', '', 1, 5),
(2, 2, 'Управление каталогом ИТ-услуг', 'Задание приведено в учебно-методическом пособии по выполнению лабораторных работ.', '', 0, 5),
(3, 3, 'Разработка Service Legal Agreement (SLA)', 'Цель работы. Получить практические навыки разработки соглашения об уровне предоставления услуги (SLA)', '', 0, 5),
(4, 4, 'Анализ возможностей Helpdesk систем', 'Цель работы: закрепление теоретических знаний и формирование практических навыков по обоснованному выбору Helpdesk систем для автоматизации работы Service Desk. В процессе выполнения работы студент должен продемонстрировать способность поиска, анализа существующих на рынке решений и обоснованного выбора help desk системы.', '', 0, 5),
(5, 1, 'Кошачьи лапки', '', '', 0, 1),
(7, 2, 'Расчёт и анализ использования оборотных средств', 'Цель работы - приобретение практических навыков расчета величины оборотных средств и анализа показателей их использования.', '', 0, 1),
(8, 1, 'Организация хранения данных в СУБД MS Access', 'Тема: Построение структуры базы данных \nЦель работы: разработать структуру базы данных (БД) для выбранной предметной области, содержащую не менее пяти взаимосвязанных таблиц. ', '', 0, 3),
(9, 2, 'Создание запросов с помощью построителя запросов в среде MS ', 'Тема: Создание запросов с помощью построителя запросов в среде MS Access \nЦель работы: создать запросы на выборку, на выборку с параметрами, на обновление записей, на удаление записей в созданных ранее таблицах.', '', 0, 3),
(10, 3, 'Работа с формами', 'Тема: Работа с формами \nЦель работы: создать ленточную, табличную и сложную формы в базе данных MS Access, используя в качестве источника записей созданные ранее таблицы и запросы.', '', 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `lab_exec`
--

CREATE TABLE `lab_exec` (
  `id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `lab_history`
--

CREATE TABLE `lab_history` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `answer` text NOT NULL,
  `attachment` varchar(600) NOT NULL,
  `lab_exec_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `learn_group` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `student_course`
--

CREATE TABLE `student_course` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `student_lab_exec`
--

CREATE TABLE `student_lab_exec` (
  `student_id` int(11) NOT NULL,
  `lab_exec_id` int(11) NOT NULL,
  `mark` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `email`, `login`, `password`) VALUES
(13, 'Афанасьевна Нина Юрьевна', 'anu@gmail.com', 'anu', '89a4b5bd7d02ad1e342c960e6a98365c'),
(14, 'Троцкий Николай Анатольевич', 'tnc@gmail.com', 'tnc', 'c775cf954921a129a65eb929476de911'),
(16, 'Дампилова Виктория', 'dampilovavika@yandex.ru', 'vika', 'c341b1783290bc3b03a82b50485332f1'),
(18, 'Петров Николай Васильевич', 'pnv@yandex.ru', 'pnv', '4ea16acee0908d1f3554a179c3758edb'),
(19, 'Семенова Анна Владимировна', 'sav@yandex.ru', 'sav', 'cb20cb3deebe08865c976143b319efc5'),
(20, 'Савченко Юлия Васильевна', 'suv@mail.ru', 'suv', 'c0276be2e060fea8d3c26d0159c6e920');

-- --------------------------------------------------------

--
-- Структура таблицы `teacher_course`
--

CREATE TABLE `teacher_course` (
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teacher_course`
--

INSERT INTO `teacher_course` (`teacher_id`, `course_id`) VALUES
(13, 4),
(13, 1),
(14, 3),
(18, 2),
(20, 5),
(19, 5);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `lab`
--
ALTER TABLE `lab`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Индексы таблицы `lab_exec`
--
ALTER TABLE `lab_exec`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `lab_id` (`lab_id`);

--
-- Индексы таблицы `lab_history`
--
ALTER TABLE `lab_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_exec_id` (`lab_exec_id`);

--
-- Индексы таблицы `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_2` (`id`);

--
-- Индексы таблицы `student_course`
--
ALTER TABLE `student_course`
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Индексы таблицы `student_lab_exec`
--
ALTER TABLE `student_lab_exec`
  ADD KEY `student_id` (`student_id`),
  ADD KEY `lab_exec_id` (`lab_exec_id`);

--
-- Индексы таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `teacher_course`
--
ALTER TABLE `teacher_course`
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `lab`
--
ALTER TABLE `lab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `lab_exec`
--
ALTER TABLE `lab_exec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `lab_history`
--
ALTER TABLE `lab_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `lab`
--
ALTER TABLE `lab`
  ADD CONSTRAINT `lab_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- Ограничения внешнего ключа таблицы `lab_exec`
--
ALTER TABLE `lab_exec`
  ADD CONSTRAINT `lab_exec_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `lab` (`id`);

--
-- Ограничения внешнего ключа таблицы `lab_history`
--
ALTER TABLE `lab_history`
  ADD CONSTRAINT `lab_history_ibfk_1` FOREIGN KEY (`lab_exec_id`) REFERENCES `lab_exec` (`id`);

--
-- Ограничения внешнего ключа таблицы `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `student_course_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `student_course_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Ограничения внешнего ключа таблицы `student_lab_exec`
--
ALTER TABLE `student_lab_exec`
  ADD CONSTRAINT `student_lab_exec_ibfk_1` FOREIGN KEY (`lab_exec_id`) REFERENCES `lab_exec` (`id`),
  ADD CONSTRAINT `student_lab_exec_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Ограничения внешнего ключа таблицы `teacher_course`
--
ALTER TABLE `teacher_course`
  ADD CONSTRAINT `teacher_course_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`),
  ADD CONSTRAINT `teacher_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
