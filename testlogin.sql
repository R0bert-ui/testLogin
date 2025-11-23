-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 23 2025 г., 20:43
-- Версия сервера: 5.5.50
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testlogin`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image_product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `image_product_id`) VALUES
(1, 'Ноутбуки', 11),
(2, 'Смартфоны', 17),
(3, 'Аксессуары', 22);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category_id`, `description`) VALUES
(11, 'Lenovo IdeaPad 3 15ITL6', '350000.00', 'https://crdms.images.consumerreports.org/f_auto,w_600/prod/products/cr/models/405545-15-to-16-inch-laptops-lenovo-ideapad-3-15itl6-2022-10026797.png', 1, 'Ноутбук Lenovo IdeaPad 3 15ITL6 с Intel Core i5 11-го поколения, 8 ГБ RAM, 512 ГБ SSD. Идеально для работы и учебы.'),
(12, 'HP Pavilion 15-eg2083ur', '400000.00', 'https://cdn.pandashop.md/i/?i=/i/products/159/1598214.jpg&w=1220&h=1220', 1, 'Ноутбук HP Pavilion 15 с Intel Core i7, 16 ГБ RAM, 512 ГБ SSD. Отличный выбор для мультимедиа и работы.'),
(13, 'Asus VivoBook 15 X515EA', '320000.00', 'https://images-cdn.ubuy.qa/646704680a1e8a0f28602891-asus-vivobook-15-x515ja-15-6-full-hd.jpg', 1, 'Asus VivoBook 15 X515EA с процессором Intel Core i5, 8 ГБ RAM, 256 ГБ SSD. Компактный и лёгкий для повседневных задач.'),
(14, 'Acer Aspire 5 A515-56', '330000.00', 'https://m.media-amazon.com/images/I/71pvhTrmZDL._AC_SX679_.jpg', 1, 'Acer Aspire 5 с Intel Core i5, 8 ГБ RAM, 512 ГБ SSD. Отличное сочетание мощности и цены.'),
(15, 'Dell Inspiron 15 3520', '370000.00', 'https://nout.kz/upload/iblock/f29/p144zbvv13krmbnmcj67od40m8ycw3nm/67297c982619725e7025a8551cc0d84d_1000.webp', 1, 'Dell Inspiron 15 3520 с Intel Core i7, 16 ГБ RAM, 512 ГБ SSD. Подходит для работы и развлечений.'),
(16, 'Samsung Galaxy S23', '220000.00', 'https://static.tildacdn.pro/tild3963-3739-4832-b631-633237386465/image.png', 2, 'Samsung Galaxy S23 с AMOLED дисплеем, 8 ГБ RAM, 256 ГБ памяти. Отличная камера.'),
(17, 'iPhone 15 256GB', '300000.00', 'https://object.pscloud.io/cms/cms/Photo/img_0_77_5090_0_6_9AzafD.png', 2, 'iPhone 15 с экраном Super Retina XDR, процессором A16 Bionic, 256 ГБ памяти. Стиль и производительность.'),
(18, 'Xiaomi 13 8/256GB', '180000.00', 'https://cdn.dsmcdn.com/mnresize/420/620/ty1399/product/media/images/prod/QC/20240703/12/564b66c1-a47b-3373-bef7-018dbb044631/1_org_zoom.jpg', 2, 'Xiaomi 13 с процессором Snapdragon 8 Gen 2, 8 ГБ RAM, 256 ГБ памяти. Высокая производительность и камера.'),
(19, 'Google Pixel 8', '200000.00', 'https://static.tildacdn.pro/tild3863-6630-4434-b163-666266356233/image.png', 2, 'Google Pixel 8 с процессором Google Tensor, 8 ГБ RAM, 128 ГБ памяти. Отличный выбор для фото и видео.'),
(20, 'OnePlus 11', '190000.00', 'https://oneplus.com.ru/uploads/product/11/images/11-marble.png', 2, 'OnePlus 11 с Snapdragon 8 Gen 2, 12 ГБ RAM, 256 ГБ памяти. Быстрая зарядка и плавный интерфейс.'),
(21, 'Apple AirPods Pro 2', '35000.00', 'https://2cent.ru/storage/photo/resized/xy_866x866/h/10zmv86q9n7ddva_70a34e45.jpg.webp', 3, 'Беспроводные наушники Apple AirPods Pro 2 с шумоподавлением и адаптивным эквалайзером.'),
(22, 'Чехол Spigen для iPhone 15', '2500.00', 'https://зубные-щетки.укр/image/cache/webp/catalog/OBSCHAYA/PRODUKTY/05-Opisanie/Spigen-Ultra-Hybrid-do-IPHONE-15-Pro-Frost-Natural-Titanium-ACS07215-O-3-600x600.webp', 3, 'Прочный чехол Spigen для iPhone 15, защищает устройство от ударов и царапин.');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'admin'),
(2, 'user', 'user123', 'user'),
(3, '123123123', '123123123', 'user'),
(4, '123123123123', '123123123123', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
