CREATE DATABASE IF NOT EXISTS cesta;

USE cesta;

CREATE TABLE IF NOT EXISTS navidad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    cesta VARCHAR(255) NOT NULL
);

INSERT INTO navidad (nombre,direccion,cesta) VALUES
    ('alex','alexaljarilla@gmail.com','con'),
    ('manolo','jve@ieslasfuentezuelas.com','con'),
    ('dani','daniarmenteros18@gmail.com','con');