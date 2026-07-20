<?php

namespace App\Models;

use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table            = 'baremes';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['type_op_id', 'montant_min', 'montant_max', 'frais', 'commission_externe_pct'];

    // Récupère les barèmes avec le nom du type (dépôt, retrait, etc.)
    public function getBaremesWithTypes()
    {
        return $this->select('baremes.*, types_operation.nom as type_nom')
                    ->join('types_operation', 'types_operation.id = baremes.type_op_id')
                    ->findAll();
    }

    // Récupère tous les types d'opération
    public function getTypesOperation()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('types_operation');
        return $builder->get()->getResultArray();
    }

    public function getBaremeForOperation(string $operationName, float $montant): ?array
    {
        $typeOpId = $this->getTypeOperationId($operationName);
        if ($typeOpId === null) {
            return null;
        }

        $baremes = $this->where('type_op_id', $typeOpId)->findAll();

        foreach ($baremes as $bareme) {
            $montantMin = (float) $bareme['montant_min'];
            $montantMax = isset($bareme['montant_max']) && $bareme['montant_max'] !== null
                ? (float) $bareme['montant_max']
                : null;

            if ($montant >= $montantMin && ($montantMax === null || $montant <= $montantMax)) {
                return $bareme;
            }
        }

        return null;
    }

    public function getTypeOperationId(string $operationName): ?int
    {
        $db = \Config\Database::connect();
        $row = $db->table('types_operation')
            ->where('LOWER(nom)', strtolower($operationName))
            ->get()
            ->getRowArray();

        return $row ? (int) $row['id'] : null;
    }

    // Ajouter une nouvelle tranche de barème
    public function addBareme($data)
    {
        return $this->insert($data);
    }

    // Supprimer une tranche de barème
    public function deleteBareme($id)
    {
        return $this->delete($id);
    }
}
