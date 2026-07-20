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
    protected $allowedFields    = ['type_op_id', 'client_source_id', 'client_destination_id', 'montant', 'frais_appliques', 'type_reseau'];

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
        $builder->select('t.*, c.numero_telephone as telephone, c.numero_telephone as client_nom, tp.nom as type_nom');
        $builder->join('clients c', 'c.id = t.client_source_id', 'left');
        $builder->join('types_operation tp', 'tp.id = t.type_op_id', 'left');
        $builder->orderBy('t.date_transaction', 'DESC');
        return $builder->get()->getResultArray();
    }

    // Récupère les transactions avec filtres (type opération + période + type_reseau)
    public function getFilteredTransactions($type_op_id = null, $date_debut = null, $date_fin = null, $type_reseau = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions t');
        $builder->select('t.*, c.numero_telephone as telephone, c.numero_telephone as client_nom, tp.nom as type_nom');
        $builder->join('clients c', 'c.id = t.client_source_id', 'left');
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
        if (!empty($type_reseau)) {
            $builder->where('t.type_reseau', $type_reseau);
        }

        $builder->orderBy('t.date_transaction', 'DESC');
        return $builder->get()->getResultArray();
    }

    // Calcule le total des gains (somme des frais_appliques)
    public function getTotalGains($type_op_id = null, $type_reseau = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions');
        $builder->select('COALESCE(SUM(frais_appliques), 0) as total');

        if (!empty($type_op_id)) {
            $builder->where('type_op_id', $type_op_id);
        }
        if (!empty($type_reseau)) {
            $builder->where('type_reseau', $type_reseau);
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
        $builder->where('t.client_source_id', $client_id);
        $builder->orderBy('t.date_transaction', 'DESC');
        return $builder->get()->getResultArray();
    }

    /**
     * Calcule le total des montants transférés vers un opérateur (par préfixe)
     */
    public function getTotalTransfertsVersOperateur($operateurPrefixe)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions t');
        $builder->select('COALESCE(SUM(t.montant), 0) as total');
        $builder->join('clients c', 'c.id = t.client_destination_id', 'left');
        $builder->where('t.type_op_id', 3); // transfert
        $builder->where('t.type_reseau', 'externe');
        $builder->where('c.numero_telephone LIKE', $operateurPrefixe . '%');
        return $builder->get()->getRowArray()['total'];
    }

    /**
     * Calcule les gains par type de réseau
     */
    public function getGainsParReseau()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions');
        $builder->select('type_reseau, COALESCE(SUM(frais_appliques), 0) as total_gains');
        $builder->groupBy('type_reseau');
        return $builder->get()->getResultArray();
    }

    /**
     * Récapitulatif des reversements par opérateur
     */
    public function getReversementParOperateur($prefixeOperateur)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transactions t');
        $builder->select('
            COALESCE(SUM(t.montant), 0) as total_montant,
            COALESCE(SUM(t.frais_appliques), 0) as total_frais,
            COUNT(t.id) as nombre_transactions
        ');
        $builder->join('clients c', 'c.id = t.client_destination_id', 'left');
        $builder->where('t.type_op_id', 3); // transfert
        $builder->where('t.type_reseau', 'externe');
        $builder->where('c.numero_telephone LIKE', $prefixeOperateur . '%');
        return $builder->get()->getRowArray();
    }
}
