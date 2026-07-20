<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        // Exécution du script SQL complet pour créer toutes les tables
        $sql = "
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
                type_op_id INTEGER NOT NULL,
                montant_min REAL NOT NULL,
                montant_max REAL NOT NULL,
                frais REAL NOT NULL,
                FOREIGN KEY(type_op_id) REFERENCES types_operation(id)
            );

            CREATE TABLE IF NOT EXISTS clients (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                numero_telephone TEXT NOT NULL UNIQUE,
                solde REAL NOT NULL DEFAULT 0.0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS transactions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                client_source_id INTEGER NOT NULL,
                client_destination_id INTEGER,
                type_op_id INTEGER NOT NULL,
                montant REAL NOT NULL,
                frais_appliques REAL NOT NULL,
                date_transaction DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY(client_source_id) REFERENCES clients(id),
                FOREIGN KEY(client_destination_id) REFERENCES clients(id),
                FOREIGN KEY(type_op_id) REFERENCES types_operation(id)
            );
        ";

        $this->db->query($sql);
    }

    public function down()
    {
        // Supprime les tables dans l'ordre inverse pour respecter les clés étrangères
        $this->db->query("DROP TABLE IF EXISTS transactions");
        $this->db->query("DROP TABLE IF EXISTS clients");
        $this->db->query("DROP TABLE IF EXISTS baremes");
        $this->db->query("DROP TABLE IF EXISTS types_operation");
        $this->db->query("DROP TABLE IF EXISTS prefixes");
    }
}