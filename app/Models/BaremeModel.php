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
}