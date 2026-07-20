<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Préfixes
        $this->db->table('prefixes')->insertBatch([
            ['code' => '033'],
            ['code' => '037']
        ]);

        // 2. Types d'opérations
        $this->db->table('types_operation')->insertBatch([
            ['nom' => 'depot'],
            ['nom' => 'retrait'],
            ['nom' => 'transfert']
        ]);

        // 3. Barèmes (Tranches de montants et frais)
        $this->db->table('baremes')->insertBatch([
            // Exemples pour Dépôt (ID 1) - Souvent gratuit ou très bas
            ['type_op_id' => 1, 'montant_min' => 0, 'montant_max' => 1000000, 'frais' => 0],

            // Exemples pour Retrait (ID 2)
            ['type_op_id' => 2, 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 50],
            ['type_op_id' => 2, 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 50],
            ['type_op_id' => 2, 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 100],
            ['type_op_id' => 2, 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 200],
            ['type_op_id' => 2, 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 400],
            ['type_op_id' => 2, 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 800],

            // Exemples pour Transfert (ID 3) - Généralement plus cher que le retrait
            ['type_op_id' => 3, 'montant_min' => 100, 'montant_max' => 5000, 'frais' => 100],
            ['type_op_id' => 3, 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 200],
            ['type_op_id' => 3, 'montant_min' => 10001, 'montant_max' => 50000, 'frais' => 500],
            ['type_op_id' => 3, 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 1000],
        ]);
    }
}