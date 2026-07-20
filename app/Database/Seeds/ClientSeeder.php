<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // Obtention de la date actuelle au bon format SQLite
        $now = date('Y-m-d H:i:s');

        // Création de clients fictifs pour les tests avec toutes les données requises
        $dataClients = [
            [
                'numero_telephone' => '0331122334', 
                'solde'            => 50000.0, 
                'created_at'       => $now
            ],
            [
                'numero_telephone' => '0374455667', 
                'solde'            => 120000.0, 
                'created_at'       => $now
            ],
        ];

        // Insertion groupée sécurisée
        $this->db->table('clients')->insertBatch($dataClients);
    }
}