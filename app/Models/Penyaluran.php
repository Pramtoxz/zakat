<?php

namespace App\Models;

use CodeIgniter\Model;

class Penyaluran extends Model
{
    protected $table            = 'penyaluran_dana';
    protected $primaryKey       = 'id';
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_mustahik', 'jenisdana', 'idpermohonan', 'idprogram', 'nominal','tglpenyaluran','deskripsi','foto'];

    // Dates
    protected $useTimestamps = false;

}