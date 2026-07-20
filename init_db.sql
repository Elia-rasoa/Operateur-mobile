-- Tables existantes
CREATE TABLE IF NOT EXISTS prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS types_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS baremes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_op_id INTEGER,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL,
    FOREIGN KEY(type_op_id) REFERENCES types_operation(id)
);

-- Table clients (manquante)
CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone TEXT NOT NULL UNIQUE,
    nom TEXT,
    solde REAL DEFAULT 0.00
);

-- Table transactions avec client_id
CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_op_id INTEGER,
    client_id INTEGER,
    montant REAL NOT NULL,
    frais_appliques REAL NOT NULL,
    date_transaction DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(type_op_id) REFERENCES types_operation(id),
    FOREIGN KEY(client_id) REFERENCES clients(id)
);

-- Données initiales
INSERT OR IGNORE INTO prefixes (code) VALUES ('033'), ('037');
INSERT OR IGNORE INTO types_operation (nom) VALUES ('depot'), ('retrait'), ('transfert');
INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais) VALUES (2, 100, 1000, 50);

-- Clients de démo
INSERT OR IGNORE INTO clients (telephone, nom, solde) VALUES ('0331000001', 'Alice', 15000);
INSERT OR IGNORE INTO clients (telephone, nom, solde) VALUES ('0331000002', 'Bob', 8500);
INSERT OR IGNORE INTO clients (telephone, nom, solde) VALUES ('0372000001', 'Charlie', 22000);

-- Transactions de démo
INSERT OR IGNORE INTO transactions (type_op_id, client_id, montant, frais_appliques) VALUES (2, 1, 500, 50);
INSERT OR IGNORE INTO transactions (type_op_id, client_id, montant, frais_appliques) VALUES (2, 2, 1000, 75);
INSERT OR IGNORE INTO transactions (type_op_id, client_id, montant, frais_appliques) VALUES (3, 1, 200, 25);
INSERT OR IGNORE INTO transactions (type_op_id, client_id, montant, frais_appliques) VALUES (2, 3, 300, 30);
INSERT OR IGNORE INTO transactions (type_op_id, client_id, montant, frais_appliques) VALUES (1, 2, 5000, 100);
