-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июл 14 2021 г., 09:22
-- Версия сервера: 10.4.17-MariaDB
-- Версия PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mvc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts`
(
    `id`    int(11)      NOT NULL,
    `title` varchar(255) NOT NULL,
    `text`  text         NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `title`, `text`)
VALUES (1, '10 ловушек, связанных с требованиями, которых следует избегать',
        'Небрежное отношение к разработке и управлению требованиями часто приводит к тому, что проекты по разработке программного обеспечения оказываются сложными или проваливаются. Вот десять распространенных ловушек, с которыми можно столкнуться, если не принимать требования всерьез. Я описываю симптомы, которые могут указывать на то, что вы стали жертвой одной из ловушек, а также некоторые возможные решения. Более подробную информацию обо всех этих ловушках можно найти в книге \"Требования к программному обеспечению\", 3-е издание, авторы Karl Wiegers и Joy Beatty.'),
       (2, 'Как ИИ превосходит человека в разработке квантовых экспериментов и причём здесь графы',
        'Система машинного обучения, изначально созданная для ускорения вычислений, сегодня делает удивительные успехи на границах экспериментальной квантовой физики. Квантовый физик Марио Кренн помнит, как в начале 2016 года он сидел в кафе в Вене и просматривал компьютерные распечатки, пытаясь понять смысл того, что обнаружил MELVIN. MELVIN — написанный Кренном алгоритм машинного обучения, своего рода искусственный интеллект. Его задача — смешивать и сопоставлять строительные блоки стандартных квантовых экспериментов и находить решения новых проблем; он нашёл много интересного, но имело место и одно странное решение. К старту курса о глубоком и машинном обучении делимся переводом статьи о квантовых экспериментах при помощи ИИ.\r\n\r\n«За несколько часов программа нашла решение, к которому мы, учёные — три экспериментатора и один теоретик — не могли прийти месяцами, — рассказывает Кренн. — День был сумасшедшим. Не мог поверить, что это произошло».'),
       (3, 'Техническое сервисное обслуживание оборудования: как перестать «тушить пожары» и считать заявки',
        'Как гарантийное, так и постгарантийное (постпродажное) выездное техническое обслуживание – это сложный технический процесс, требующий соблюдения технологических операций и регламентов ТОиР. В данной статье речь пойдет прежде всего о компаниях, которые управляют выездным (мобильным) персоналом, выполняющим такие работы.\r\n\r\nПостарался собрать основные принципы \"настройки\" гарантийного и постгарантийного сервиса оборудования с помощью автоматизированных систем класса FSM (Field Service Management / Управление выездным сервисным обслуживанием).');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles`
(
    `id`   int(11)      NOT NULL,
    `code` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `code`, `name`)
VALUES (1, 'admin', 'Администратор'),
       (2, 'user', 'Зарегистрированный пользователь');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users`
(
    `id`       int(11)      NOT NULL,
    `role_id`  int(11)      NOT NULL DEFAULT 2,
    `name`     varchar(255) NOT NULL,
    `login`    varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `login`, `password`)
VALUES (10, 1, 'Грушевский Юрий', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
       (11, 2, 'Пользователь', 'user', 'ee11cbb19052e40b07aac0ca060c23ee'),
       (21, 2, '&lt;script&gt;alert(111)&lt;/script&gt;', 'admintt', '21232f297a57a5a743894a0e4a801fc3'),
       (22, 2, '&lt;script&gt;alert(111)&lt;/script&gt;', 'admin1', 'c4ca4238a0b923820dcc509a6f75849b');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
    ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
    ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `login` (`login`),
    ADD KEY `id_role` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 23;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
    ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
