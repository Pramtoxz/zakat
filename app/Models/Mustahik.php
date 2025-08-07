<?php

namespace App\Models;

use CodeIgniter\Model;

class Mustahik extends Model
{
    protected $table            = 'mustahik';
    protected $primaryKey       = 'id_mustahik';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_mustahik', 'nama', 'alamat', 'nohp', 'jenkel','tgllahir','iduser','foto'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}