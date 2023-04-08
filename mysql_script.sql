CREATE DATABASE `railway` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

CREATE TABLE `Images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` longblob NOT NULL,
  `name` varchar(1024) NOT NULL,
  `userId` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `image_userId_idx` (`userId`),
  CONSTRAINT `image_userId` FOREIGN KEY (`userId`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `note` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `userId` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `notes_userId_idx` (`userId`),
  CONSTRAINT `notes_userId` FOREIGN KEY (`userId`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'inactive',
  `Token` varchar(255) NOT NULL,
  `attempts` int DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
