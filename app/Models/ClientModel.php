<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'clients';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['telephone', 'nom', 'solde'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Récupère tous les clients avec leur solde
    public function getAllWithSolde()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }

    // Récupère les transactions d'un client avec les détails
    public function getClientTransactions($client_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions t');
        $builder->select('t.*, tp.nom as type_nom');
        $builder->join('types_operation tp', 'tp.id = t.type_op_id', 'left');
        $builder->where('t.client_id', $client_id);
        $builder->orderBy('t.date_transaction', 'DESC');
        return $builder->get()->getResultArray();
    }
}
