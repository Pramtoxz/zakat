<?php

namespace App\Models;

use CodeIgniter\Model;

class Permohonan extends Model
{
    protected $table            = 'permohonan';
    protected $primaryKey       = 'idpermohonan';
    protected $protectFields    = true;
    protected $allowedFields    = ['idpermohonan', 'id_mustahik', 'kategoriasnaf', 'jenisbantuan','tglpengajuan','tgldisetujui','dokumen','alasan','status'];

    // Dates
    protected $useTimestamps = false;

}