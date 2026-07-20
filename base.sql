-- ====================================================================
-- SECTION 1 : CONFIGURATION GLOBALE DE L'OPÉRATEUR
-- ====================================================================

-- 1. Table des préfixes acceptés (ex: 033, 037, etc.)
CREATE TABLE IF NOT EXISTS prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE
);

-- 2. Définition des catégories d'opérations (dépôt, retrait, transfert)
CREATE TABLE IF NOT EXISTS types_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE
);

-- 3. Définition des tranches de montant et des frais associés (Modifiables)
CREATE TABLE IF NOT EXISTS baremes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_op_id INTEGER NOT NULL,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL,
    FOREIGN KEY(type_op_id) REFERENCES types_operation(id)
);


-- ====================================================================
-- SECTION 2 : GESTION DES COMPTES ET HISTORIQUES (Côté Client & Communs)
-- ====================================================================

-- 4. Table des clients
CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone TEXT NOT NULL UNIQUE,
    solde REAL NOT NULL DEFAULT 0.0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 5. Table globale des transactions (Historique & situation des gains)
CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_source_id INTEGER NOT NULL,       -- Le client qui initie l'action
    client_destination_id INTEGER,          -- Utilisé UNIQUEMENT en cas de transfert
    type_op_id INTEGER NOT NULL,             -- ID lié à la table 'types_operation'
    montant REAL NOT NULL,                   -- Montant brut de la transaction
    frais_appliques REAL NOT NULL,           -- Les frais retenus par l'opérateur
    date_transaction DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(client_source_id) REFERENCES clients(id),
    FOREIGN KEY(client_destination_id) REFERENCES clients(id),
    FOREIGN KEY(type_op_id) REFERENCES types_operation(id)
);


-- ====================================================================
-- SECTION 3 : INSERTS INITIALES POUR VOS TESTS
-- ====================================================================

-- Remplissage des préfixes valides
INSERT OR IGNORE INTO prefixes (code) VALUES ('033'), ('037');

-- Remplissage des types d'opérations imposés par le sujet
INSERT OR IGNORE INTO types_operation (nom) VALUES ('depot'), ('retrait'), ('transfert');

-- Exemple du barème de l'image (pour les retraits)
-- Vous pouvez ajouter le reste via l'interface Admin de ton binôme
INSERT INTO baremes (type_op_id, montant_min, montant_max, frais) VALUES 
(2, 100, 1000, 50),
(2, 1001, 5000, 50),
(2, 5001, 10000, 100),
(2, 10001, 25000, 200),
(2, 25001, 50000, 400),
(2, 50001, 100000, 800),
(2, 100001, 250000, 1500),
(2, 250001, 500000, 1500),
(2, 500001, 1000000, 2500),
(2, 1000001, 2000000, 3000);

-- 0331234567
-- 0334455566