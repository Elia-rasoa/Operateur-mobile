<?php

namespace App\Models\client;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table         = 'clients';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    
    // Autorise CodeIgniter à manipuler ces colonnes
    protected $allowedFields = ['numero_telephone', 'solde', 'created_at'];

    // Gestion automatique de la date de création par CodeIgniter
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // On laisse vide car absent de la base de données
    protected $dateFormat    = 'datetime'; // Format compatible avec DATETIME de SQLite
}