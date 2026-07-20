<?php

namespace App\Models;

use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table            = 'baremes';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['type_op_id', 'montant_min', 'montant_max', 'frais'];

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
