<?php

namespace App\Models\client;

use CodeIgniter\Model;

class PrefixModel extends Model
{
    protected $table         = 'prefixes';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = ['code', 'operateur_nom'];

    public function isPrefixAllowed(string $telephone): bool
    {
        $prefix = substr($telephone, 0, 3);
        return (bool) $this->where('code', $prefix)->first();
    }

    /**
     * Vérifie si le numéro de téléphone appartient à un opérateur externe
     * (son préfixe est dans la table prefixes)
     */
    public function isExternalOperator(string $telephone): bool
    {
        $prefix = substr($telephone, 0, 3);
        return (bool) $this->where('code', $prefix)->first();
    }
}
