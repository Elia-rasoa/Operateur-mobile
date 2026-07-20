<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['type_op_id', 'client_id', 'montant', 'frais_appliques'];

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

    // Récupère toutes les transactions avec les infos liées (client, type opération)
    public function getTransactionsWithDetails()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions t');
        $builder->select('t.*, c.telephone, c.nom as client_nom, tp.nom as type_nom');
        $builder->join('clients c', 'c.id = t.client_id', 'left');
        $builder->join('types_operation tp', 'tp.id = t.type_op_id', 'left');
        $builder->orderBy('t.date_transaction', 'DESC');
        return $builder->get()->getResultArray();
    }

    // Récupère les transactions avec filtres (type opération + période)
    public function getFilteredTransactions($type_op_id = null, $date_debut = null, $date_fin = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions t');
        $builder->select('t.*, c.telephone, c.nom as client_nom, tp.nom as type_nom');
        $builder->join('clients c', 'c.id = t.client_id', 'left');
        $builder->join('types_operation tp', 'tp.id = t.type_op_id', 'left');

        if (!empty($type_op_id)) {
            $builder->where('t.type_op_id', $type_op_id);
        }
        if (!empty($date_debut)) {
            $builder->where('t.date_transaction >=', $date_debut);
        }
        if (!empty($date_fin)) {
            $builder->where('t.date_transaction <=', $date_fin . ' 23:59:59');
        }

        $builder->orderBy('t.date_transaction', 'DESC');
        return $builder->get()->getResultArray();
    }

    // Calcule le total des gains (somme des frais_appliques)
    public function getTotalGains($type_op_id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions');
        $builder->select('COALESCE(SUM(frais_appliques), 0) as total');

        if (!empty($type_op_id)) {
            $builder->where('type_op_id', $type_op_id);
        }

        return $builder->get()->getRowArray()['total'];
    }

    // Récupère les transactions d'un client spécifique
    public function getTransactionsByClient($client_id)
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
