<?php

namespace App\Models\client;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table         = 'transactions';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'client_source_id',
        'client_destination_id',
        'type_op_id',
        'montant',
        'frais_appliques',
        'date_transaction'
    ];

    /**
     * Récupère toutes les transactions avec les infos clients.
     */
    public function getHistorique()
    {
        return $this->db->table('transactions t')
            ->select('
                t.id,
                t.montant,
                t.frais_appliques,
                t.date_transaction,
                t.type_op_id,
                source.numero_telephone AS source_phone,
                dest.numero_telephone AS dest_phone,
                toperation.nom AS type_operation
            ')
            ->join('clients source', 'source.id = t.client_source_id', 'left')
            ->join('clients dest', 'dest.id = t.client_destination_id', 'left')
            ->join('types_operation toperation', 'toperation.id = t.type_op_id', 'left')
            ->orderBy('t.date_transaction', 'DESC')
            ->get()
            ->getResultArray();
    }
}

