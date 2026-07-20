<?php

namespace App\Models\client;

use CodeIgniter\Model;

class PrefixModel extends Model
{
    protected $table         = 'prefixes';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = ['code'];
}