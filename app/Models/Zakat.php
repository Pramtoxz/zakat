<?php

namespace App\Models;

use CodeIgniter\Model;

class Zakat extends Model
{
    protected $table            = 'zakat';
    protected $primaryKey       = 'idzakat';
    protected $protectFields    = true;
    protected $allowedFields    = ['idzakat', 'id_donatur','jeniszakat', 'nominal', 'kategoriasnaf','online','buktibayar','tgltransfer','status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

}