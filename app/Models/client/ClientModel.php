<?php

namespace App\Models\client;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table         = 'clients';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';

    protected $allowedFields = ['numero_telephone', 'solde', 'created_at'];
    protected $useTimestamps = false;

    public function findByTelephone(string $telephone): ?array
    {
        return $this->where('numero_telephone', $telephone)->first();
    }

    public function getOrCreateByTelephone(string $telephone): array
    {
        $client = $this->findByTelephone($telephone);

        if ($client) {
            return $client;
        }

        $this->insert([
            'numero_telephone' => $telephone,
            'solde' => 0.0,
        ]);

        return $this->findByTelephone($telephone) ?? [];
    }
}