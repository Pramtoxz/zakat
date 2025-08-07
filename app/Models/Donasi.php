<?php

namespace App\Models;

use CodeIgniter\Model;

class Donasi extends Model
{
    protected $table            = 'donasi';
    protected $primaryKey       = 'iddonasi';
    protected $protectFields    = true;
    protected $allowedFields    = ['iddonasi', 'id_donatur','idprogram', 'nominal','online','buktibayar','tgltransfer','status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';


}