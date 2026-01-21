-- seed.sql: Create database with products, users, and orders
CREATE DATABASE IF NOT EXISTS `catalog_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `catalog_db`;

CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(100),
  `customer_phone` varchar(20),
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `products` (`name`, `description`, `price`, `category`, `image`, `stock`) VALUES
('Кафе', 'Горещо еспресо от пресни зърна', 2.50, 'Напитки', '', 50),
('Уеб дизайн пакет', 'Пълен пакет от услуги за малък бизнес', 450.00, 'Услуги', '', 5),
('Слушалки', 'Безжични слушалки с шумопотискане', 89.99, 'Електроника', '', 12),
('Книга: "Властелинът на пръстените"', 'Фантастичен роман от Дж. Р. Р. Толкин', 15.00, 'Книги', '', 30),
('Йога постелка', 'Екологична йога постелка с добро сцепление', 25.00, 'Спортни стоки', '', 20),
('Смарт часовник', 'Многофункционален смарт часовник с мониторинг на здравето', 199.99, 'Електроника', '', 8),
('Ръчно изработена керамична чаша', 'Уникална чаша, изработена от местни занаятчии', 12.50, 'Дом и кухня', '', 15),
('Онлайн курс по програмиране', 'Интерактивен курс за начинаещи в уеб разработката', 99.00, 'Образование', '', 100),
('Градински инструменти комплект', 'Комплект от основни инструменти за градинарство', 45.00, 'Градина', '', 18),
('Bluetooth високоговорител', 'Портативен високоговорител с високо качество на звука', 59.99, 'Електроника', '', 25);

INSERT INTO `users` (`username`, `email`, `password_hash`, `role`) VALUES
('admin', 'admin@example.com', '$2y$10$3/jMTnXXVCcG8z0Z7xX7OOqK6XEzQnH/vqW2z6w3z6w3z6w3z6w3', 'admin'),
('customer1', 'customer@example.com', '$2y$10$3/jMTnXXVCcG8z0Z7xX7OOqK6XEzQnH/vqW2z6w3z6w3z6w3z6w3', 'customer');
