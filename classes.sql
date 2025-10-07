CREATE DATABASE classes;

USE classes;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    firstname VARCHAR(100),
    lastname VARCHAR(100)
);
use classes;
ALTER TABLE utilisateurs MODIFY COLUMN login VARCHAR(50) NOT NULL;