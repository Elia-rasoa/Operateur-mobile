<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Préfixes (INSERT OR IGNORE pour éviter les doublons)
        $this->db->query("INSERT OR IGNORE INTO prefixes (code) VALUES ('033')");
        $this->db->query("INSERT OR IGNORE INTO prefixes (code) VALUES ('037')");

        // 2. Types d'opérations
        $this->db->query("INSERT OR IGNORE INTO types_operation (nom) VALUES ('depot')");
        $this->db->query("INSERT OR IGNORE INTO types_operation (nom) VALUES ('retrait')");
        $this->db->query("INSERT OR IGNORE INTO types_operation (nom) VALUES ('transfert')");

        // 3. Barèmes (Tranches de montants et frais)
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (1, 0, 1000000, 0, 0)");

        // Retraits (type_op_id = 2)
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (2, 100, 1000, 50, 0)");
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (2, 1001, 5000, 50, 0)");
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (2, 5001, 10000, 100, 0)");
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (2, 10001, 25000, 200, 0)");
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (2, 25001, 50000, 400, 0)");
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (2, 50001, 100000, 800, 0)");

        // Transferts (type_op_id = 3) - avec commission externe par défaut à 5%
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (3, 100, 5000, 100, 5)");
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (3, 5001, 10000, 200, 5)");
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (3, 10001, 50000, 500, 5)");
        $this->db->query("INSERT OR IGNORE INTO baremes (type_op_id, montant_min, montant_max, frais, commission_externe_pct) VALUES (3, 50001, 100000, 1000, 5)");
    }
}
