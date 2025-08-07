<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanUsers extends BaseController
{

    public function LaporanMustahik()
    {
        $data['title'] = 'Laporan Mustahik';
        return view('laporan/users/mustahik', $data);
    }

    public function viewallLaporanMustahik()
    {
        $db = db_connect();
        $mustahik = $db
            ->table('mustahik')
            ->select('id_mustahik, nama, alamat, nohp, jenkel, tgllahir,users.email') 
            ->join('users', 'users.id = mustahik.iduser', 'left')
            ->groupBy('mustahik.id_mustahik, mustahik.nama, mustahik.alamat, mustahik.nohp')
            ->get()
            ->getResultArray();
        $data = [
            'mustahik' => $mustahik,
        ];
        $response = [
            'data' => view('laporan/users/viewallmustahik', $data),
        ];

        echo json_encode($response);
    }


    public function LaporanDonatur()
    {
        $data['title'] = 'Laporan Donatur';
        return view('laporan/users/donatur', $data);
    }

    public function viewallLaporanDonatur()
    {
        $db = db_connect();
        $donatur = $db
             ->table('donatur')
            ->select('id_donatur, nama, alamat, nohp, jenkel, tgllahir,users.email') 
            ->join('users', 'users.id = donatur.iduser', 'left')
            ->groupBy('donatur.id_donatur, donatur.nama, donatur.alamat, donatur.nohp')
            ->get()
            ->getResultArray();
        $data = [
            'donatur' => $donatur,
        ];
        $response = [
            'data' => view('laporan/users/viewalldonatur', $data),
        ];

        echo json_encode($response);
    }
}
