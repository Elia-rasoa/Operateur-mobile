<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // Création de clients fictifs pour les tests
        $dataClients = [
            ['numero_telephone' => '0331122334', 'solde' => 50000],
            ['numero_telephone' => '0374455667', 'solde' => 120000],
        ];
        $this->db->table('clients')->insertBatch($dataClients);
    }
}