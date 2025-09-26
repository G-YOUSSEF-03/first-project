-- Create the database
CREATE DATABASE IF NOT EXISTS gestion_stagiaire CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gestion_stagiaire;

-- Table: Administrateurs (for login and session)
CREATE TABLE administrateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Table: Stagiaires 
CREATE TABLE stagiaire (
    code INT AUTO_INCREMENT PRIMARY KEY,
    cin VARCHAR(20) NOT NULL UNIQUE,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    adresse TEXT,
    filiere VARCHAR(100) NOT NULL
);

-- Table: Historique 
CREATE TABLE historique (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_email VARCHAR(150) NOT NULL,
    operation VARCHAR(100) NOT NULL,
    prenom_ST VARCHAR(100) NOT NULL,
    nom_ST VARCHAR(100) NOT NULL,
    filiere_ST VARCHAR(100) NOT NULL,
    date_operation DATE NOT NULL,
    time_operation TIME NOT NULL
);

-- Table: Posts (admin publications)
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu TEXT NOT NULL,
    date_post DATETIME DEFAULT CURRENT_TIMESTAMP
);