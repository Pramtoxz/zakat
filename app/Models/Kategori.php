<?php

namespace App\Models;

use CodeIgniter\Model;

class Kategori extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'idkategori';
    protected $protectFields    = true;
    protected $allowedFields    = ['idkategori', 'namakategori'];

    // Dates
    protected $useTimestamps = false;
}