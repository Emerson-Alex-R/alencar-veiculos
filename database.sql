-- Script para criação do banco de dados e tabelas para o sistema de veículos

CREATE DATABASE IF NOT EXISTS alencar_veiculos;
USE alencar_veiculos;

-- Tabela de veículos
CREATE TABLE IF NOT EXISTS vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    price VARCHAR(50) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    year YEAR NOT NULL,
    km VARCHAR(50) NOT NULL,
    fuel VARCHAR(50) NOT NULL,
    transmission VARCHAR(50) NOT NULL,
    description TEXT NOT NULL
);

-- Tabela de imagens dos veículos
CREATE TABLE IF NOT EXISTS vehicle_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_id INT NOT NULL,
    image_url TEXT NOT NULL,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE
);
