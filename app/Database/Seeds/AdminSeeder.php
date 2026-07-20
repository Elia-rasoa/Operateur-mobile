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

        // 3. Barèmes (Retraits - ID 2)
        $this->db->table('baremes')->insertBatch([
            ['type_op_id' => 2, 'montant_min' => 100, 'montant_max' => 1000, 'frais' => 50],
            ['type_op_id' => 2, 'montant_min' => 1001, 'montant_max' => 5000, 'frais' => 50],
            ['type_op_id' => 2, 'montant_min' => 5001, 'montant_max' => 10000, 'frais' => 100],
            ['type_op_id' => 2, 'montant_min' => 10001, 'montant_max' => 25000, 'frais' => 200],
            ['type_op_id' => 2, 'montant_min' => 25001, 'montant_max' => 50000, 'frais' => 400],
            ['type_op_id' => 2, 'montant_min' => 50001, 'montant_max' => 100000, 'frais' => 800],
            ['type_op_id' => 2, 'montant_min' => 100001, 'montant_max' => 250000, 'frais' => 1500],
            ['type_op_id' => 2, 'montant_min' => 250001, 'montant_max' => 500000, 'frais' => 1500],
            ['type_op_id' => 2, 'montant_min' => 500001, 'montant_max' => 1000000, 'frais' => 2500],
            ['type_op_id' => 2, 'montant_min' => 1000001, 'montant_max' => 2000000, 'frais' => 3000],
        ]);
    }
}