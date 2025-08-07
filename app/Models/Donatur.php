<?php

namespace App\Models;

use CodeIgniter\Model;

class Donatur extends Model
{
    protected $table            = 'donatur';
    protected $primaryKey       = 'id_donatur';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_donatur', 'nama', 'alamat', 'nohp', 'jenkel','tgllahir','iduser','foto'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}