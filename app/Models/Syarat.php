<?php

namespace App\Models;

use CodeIgniter\Model;

class Syarat extends Model
{
    protected $table            = 'syarat_bantuan';
    protected $primaryKey       = 'id_syarat';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_syarat', 'kategori_asnaf', 'isi_syarat'];

    // Dates
    protected $useTimestamps = false;

}