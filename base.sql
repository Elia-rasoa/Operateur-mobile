CREATE DATABASE IF NOT EXISTS operateur_mobile;
USE operateur_mobile;

-- Permet de configurer quels réseaux sont acceptés
CREATE TABLE IF NOT EXISTS prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE
);

-- Définit les catégories d'opérations (ex: dépôt, retrait, transfert)
CREATE TABLE IF NOT EXISTS types_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE
);

-- Permet de définir les tranches de montant et les frais associés
CREATE TABLE IF NOT EXISTS baremes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_op_id INTEGER,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL,
    FOREIGN KEY(type_op_id) REFERENCES types_operation(id)
);

-- Enregistre les opérations pour calculer la situation des gains
CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_op_id INTEGER,
    montant REAL NOT NULL,
    frais_appliques REAL NOT NULL,
    date_transaction DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(type_op_id) REFERENCES types_operation(id)
);

-- DONNÉES DE CONFIGURATION INITIALE
-- Configuration des préfixes
INSERT INTO prefixes (code) VALUES ('033'), ('037');

-- Définition des types d'opérations
INSERT INTO types_operation (nom) VALUES ('depot'), ('retrait'), ('transfert');

-- Exemple de barème (à modifier via votre interface Admin)
INSERT INTO baremes (type_op_id, montant_min, montant_max, frais) VALUES (2, 100, 1000, 50);