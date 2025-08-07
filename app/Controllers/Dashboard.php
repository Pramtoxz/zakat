<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Booking;
use App\Models\Perawatan;
use App\Models\Obat;
use App\Models\Jadwal;
use App\Models\Jenis;
use App\Models\ObatMasuk;

class Dashboard extends BaseController
{
    public function index()
    {
              return view('dashboard/index');
    }
}