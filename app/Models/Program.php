<?php

namespace App\Models;

use CodeIgniter\Model;

class Program extends Model
{
    protected $table            = 'program';
    protected $primaryKey       = 'idprogram';
    protected $protectFields    = true;
    protected $allowedFields    = ['idprogram', 'namaprogram','idkategori','deskripsi','foto','tglmulai','tglselesai','status'];

    // Dates
    protected $useTimestamps = false;
}