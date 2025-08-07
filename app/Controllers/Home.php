<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Program as ModelProgram;
use App\Models\Kategori as ModelKategori;

class Home extends BaseController
{
    public function index()
    {
        $db = db_connect();
        
        // Ambil program urgent dengan join kategori
        $programUrgent = $db->table('program p')
                           ->select('p.*, k.namakategori')
                           ->join('kategori k', 'k.idkategori = p.idkategori', 'left')
                           ->where('p.status', 'urgent')
                           ->orderBy('p.tglmulai', 'ASC')
                           ->limit(6)
                           ->get()
                           ->getResultArray();
        
        // Ambil program biasa dengan join kategori
        $programBiasa = $db->table('program p')
                          ->select('p.*, k.namakategori')
                          ->join('kategori k', 'k.idkategori = p.idkategori', 'left')
                          ->where('p.status', 'biasa')
                          ->limit(6)
                          ->get()
                          ->getResultArray();
        
        $data = [
            'programUrgent' => $programUrgent,
            'programBiasa' => $programBiasa
        ];

        return view('home/index', $data);
    }
}