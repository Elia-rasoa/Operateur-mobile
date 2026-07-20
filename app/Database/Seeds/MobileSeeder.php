<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MobileSeeder extends Seeder
{
    public function run()
    {
        $this->db->transStart();

        $this->db->query("INSERT OR IGNORE INTO prefixes (code) VALUES ('033'), ('037')");
        $this->db->query("INSERT OR IGNORE INTO types_operation (nom) VALUES ('depot'), ('retrait'), ('transfert')");

        $typeIds = $this->getIds('types_operation', 'nom');
        $bareme = [
            'type_op_id'  => $typeIds['retrait'],
            'montant_min' => 100,
            'montant_max' => 1000,
            'frais'       => 50,
        ];

        if ($this->db->table('baremes')->where($bareme)->countAllResults() === 0) {
            $this->db->table('baremes')->insert($bareme);
        }

        $this->db->query(
            "INSERT OR IGNORE INTO clients (numero_telephone, solde) VALUES
            ('0331000001', 15000),
            ('0331000002', 8500),
            ('0372000001', 22000)"
        );

        if ($this->db->table('transactions')->countAllResults() === 0) {
            $clientIds = $this->getIds('clients', 'numero_telephone');
            $this->db->table('transactions')->insertBatch([
                ['type_op_id' => $typeIds['retrait'], 'client_source_id' => $clientIds['0331000001'], 'client_destination_id' => null, 'montant' => 500, 'frais_appliques' => 50],
                ['type_op_id' => $typeIds['retrait'], 'client_source_id' => $clientIds['0331000002'], 'client_destination_id' => null, 'montant' => 1000, 'frais_appliques' => 75],
                ['type_op_id' => $typeIds['transfert'], 'client_source_id' => $clientIds['0331000001'], 'client_destination_id' => $clientIds['0331000002'], 'montant' => 200, 'frais_appliques' => 25],
                ['type_op_id' => $typeIds['retrait'], 'client_source_id' => $clientIds['0372000001'], 'client_destination_id' => null, 'montant' => 300, 'frais_appliques' => 30],
                ['type_op_id' => $typeIds['depot'], 'client_source_id' => $clientIds['0331000002'], 'client_destination_id' => null, 'montant' => 5000, 'frais_appliques' => 100],
            ]);
        }

        $this->db->transComplete();
    }

    /**
     * @return array<string, int>
     */
    private function getIds(string $table, string $column): array
    {
        $result = [];

        foreach ($this->db->table($table)->select("id, {$column}")->get()->getResultArray() as $row) {
            $result[$row[$column]] = (int) $row['id'];
        }

        return $result;
    }
}
