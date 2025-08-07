<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanTransaksi extends BaseController
{

    public function LaporanZakat()
    {
        $data['title'] = 'Laporan Zakat';
        return view('laporan/zakat/laporanzakat', $data);
    }


    public function viewLaporanZakat()
    {
        $db = db_connect();
        $booking = $db
            ->table('zakat')
            ->select('zakat.idzakat,zakat.created_at, zakat.nominal, zakat.jeniszakat, donatur.nama as nama_donatur, zakat.online')
            ->join('donatur', 'donatur.id_donatur = zakat.id_donatur')
            ->where('zakat.status', 'diterima')
            ->orderBy('zakat.idzakat', 'DESC')
            ->get()
            ->getResultArray();
        $data = [
            'booking' => $booking,
        ];
        $response = [
            'data' => view('laporan/zakat/viewallzakat', $data),
        ];

        echo json_encode($response);
    }

    public function viewLaporanZakatTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        $query = $db
        ->table('zakat')
        ->select('zakat.idzakat,zakat.created_at, zakat.nominal, zakat.jeniszakat, donatur.nama as nama_donatur, zakat.online')
        ->join('donatur', 'donatur.id_donatur = zakat.id_donatur')
        ->where('zakat.status', 'diterima')
            ->orderBy('zakat.idzakat', 'DESC')
           ->where('zakat.created_at >=', $tglmulai)
            ->where('zakat.created_at <=', $tglakhir)
            ->getCompiledSelect();
        $booking = $db->query($query)->getResultArray();
        $data = [
            'booking' => $booking,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/zakat/viewallzakattanggal', $data),
        ];

        echo json_encode($response);
    }

    public function viewLaporanZakatBulan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $db = db_connect();
        $query = $db
            ->table('zakat')
            ->select('zakat.idzakat,zakat.created_at, zakat.nominal, zakat.jeniszakat, donatur.nama as nama_donatur, zakat.online')
            ->join('donatur', 'donatur.id_donatur = zakat.id_donatur')
            ->where('zakat.status', 'diterima')
            ->orderBy('zakat.idzakat', 'DESC')
            ->where('month(zakat.created_at)', $bulan)
            ->where('year(zakat.created_at)', $tahun)
            ->getCompiledSelect();
        $booking = $db->query($query)->getResultArray();
        $data = [
            'booking' => $booking,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
        $response = [
            'data' => view('laporan/zakat/viewallzakatbulan', $data),
        ];

        echo json_encode($response);
    }
    public function LaporanDonasi()
    {
        $data['title'] = 'Laporan Donasi';
        return view('laporan/donasi/laporandonasi', $data);
    }


    public function viewLaporanDonasi()
    {
        $db = db_connect();
        $donasi = $db
            ->table('donasi')
            ->select('donasi.iddonasi,donasi.created_at, donasi.nominal, program.namaprogram, donatur.nama as nama_donatur, donasi.online, donasi.status')
            ->join('donatur', 'donatur.id_donatur = donasi.id_donatur', 'left')
            ->join('program', 'program.idprogram = donasi.idprogram', 'left')
            ->where('donasi.status', 'diterima')
            ->orderBy('donasi.iddonasi', 'DESC')
            ->get()
            ->getResultArray();
        $data = [
            'donasi' => $donasi,
        ];
        $response = [
            'data' => view('laporan/donasi/viewalldonasi', $data),
        ];

        echo json_encode($response);
    }

    public function viewLaporanDonasiTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        $query = $db
        ->table('donasi')
        ->select('donasi.iddonasi,donasi.created_at, donasi.nominal, program.namaprogram, donatur.nama as nama_donatur, donasi.online, donasi.status')
        ->join('donatur', 'donatur.id_donatur = donasi.id_donatur')
        ->join('program', 'program.idprogram = donasi.idprogram')
        ->where('donasi.status', 'diterima')
            ->orderBy('donasi.iddonasi', 'DESC')
           ->where('donasi.created_at >=', $tglmulai)
            ->where('donasi.created_at <=', $tglakhir)
            ->getCompiledSelect();
        $donasi = $db->query($query)->getResultArray();
        $data = [
            'donasi' => $donasi,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/donasi/viewalldonasitanggal', $data),
        ];

        echo json_encode($response);
    }

    public function viewLaporanDonasiBulan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $db = db_connect();
        $query = $db
            ->table('donasi')
            ->select('donasi.iddonasi,donasi.created_at, donasi.nominal, program.namaprogram, donatur.nama as nama_donatur, donasi.online, donasi.status')
            ->join('donatur', 'donatur.id_donatur = donasi.id_donatur')
            ->join('program', 'program.idprogram = donasi.idprogram')
            ->where('donasi.status', 'diterima')
            ->orderBy('donasi.iddonasi', 'DESC')
            ->where('month(donasi.created_at)', $bulan)
            ->where('year(donasi.created_at)', $tahun)
            ->getCompiledSelect();
        $donasi = $db->query($query)->getResultArray();
        $data = [
            'donasi' => $donasi,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
        $response = [
            'data' => view('laporan/donasi/viewalldonasibulan', $data),
        ];

        echo json_encode($response);
    }

    public function LaporanPenyaluran()
    {
        $data['title'] = 'Laporan Penyaluran Dana';
        return view('laporan/penyaluran/laporanpenyaluran', $data);
    }

    public function viewLaporanPenyaluranZakat()
    {
        $db = db_connect();
        $penyaluran = $db
            ->table('penyaluran_dana')
            ->select('penyaluran_dana.id, penyaluran_dana.tglpenyaluran, penyaluran_dana.jenisdana, penyaluran_dana.nominal, 
                     penyaluran_dana.idpermohonan, mustahik.nama as nama_mustahik, 
                     permohonan.kategoriasnaf, permohonan.jenisbantuan')
            ->join('mustahik', 'mustahik.id_mustahik = penyaluran_dana.id_mustahik', 'left')
            ->join('permohonan', 'permohonan.idpermohonan = penyaluran_dana.idpermohonan', 'left')
            ->where('penyaluran_dana.jenisdana', 'zakat')
            ->orderBy('penyaluran_dana.id', 'DESC')
            ->get()
            ->getResultArray();
        $data = [
            'penyaluran' => $penyaluran,
        ];
        $response = [
            'data' => view('laporan/penyaluran/viewallpenyaluranzakat', $data),
        ];

        echo json_encode($response);
    }

    public function viewLaporanPenyaluranDonasi()
    {
        $db = db_connect();
        $penyaluran = $db
            ->table('penyaluran_dana')
            ->select('penyaluran_dana.id, penyaluran_dana.tglpenyaluran, penyaluran_dana.jenisdana, penyaluran_dana.nominal, 
                     mustahik.nama as nama_mustahik, program.namaprogram')
            ->join('mustahik', 'mustahik.id_mustahik = penyaluran_dana.id_mustahik', 'left')
            ->join('program', 'program.idprogram = penyaluran_dana.idprogram', 'left')
            ->where('penyaluran_dana.jenisdana', 'donasi')
            ->orderBy('penyaluran_dana.id', 'DESC')
            ->get()
            ->getResultArray();
        $data = [
            'penyaluran' => $penyaluran,
        ];
        $response = [
            'data' => view('laporan/penyaluran/viewallpenyalurandonasi', $data),
        ];

        echo json_encode($response);
    }

    public function viewLaporanPenyaluranTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $jenisdana = $this->request->getPost('jenisdana');
        
        $db = db_connect();
        
        if ($jenisdana == 'zakat') {
            $query = $db
                ->table('penyaluran_dana')
                ->select('penyaluran_dana.id, penyaluran_dana.tglpenyaluran, penyaluran_dana.jenisdana, penyaluran_dana.nominal, 
                         penyaluran_dana.idpermohonan, mustahik.nama as nama_mustahik, 
                         permohonan.kategoriasnaf, permohonan.jenisbantuan')
                ->join('mustahik', 'mustahik.id_mustahik = penyaluran_dana.id_mustahik', 'left')
                ->join('permohonan', 'permohonan.idpermohonan = penyaluran_dana.idpermohonan', 'left')
                ->where('penyaluran_dana.jenisdana', 'zakat')
                ->where('penyaluran_dana.tglpenyaluran >=', $tglmulai)
                ->where('penyaluran_dana.tglpenyaluran <=', $tglakhir)
                ->orderBy('penyaluran_dana.id', 'DESC')
                ->getCompiledSelect();
            $viewFile = 'laporan/penyaluran/viewallpenyaluranzakattanggal';
        } else {
            $query = $db
                ->table('penyaluran_dana')
                ->select('penyaluran_dana.id, penyaluran_dana.tglpenyaluran, penyaluran_dana.jenisdana, penyaluran_dana.nominal, 
                         mustahik.nama as nama_mustahik, program.namaprogram')
                ->join('mustahik', 'mustahik.id_mustahik = penyaluran_dana.id_mustahik', 'left')
                ->join('program', 'program.idprogram = penyaluran_dana.idprogram', 'left')
                ->where('penyaluran_dana.jenisdana', 'donasi')
                ->where('penyaluran_dana.tglpenyaluran >=', $tglmulai)
                ->where('penyaluran_dana.tglpenyaluran <=', $tglakhir)
                ->orderBy('penyaluran_dana.id', 'DESC')
                ->getCompiledSelect();
            $viewFile = 'laporan/penyaluran/viewallpenyalurandonasitanggal';
        }
        
        $penyaluran = $db->query($query)->getResultArray();
        $data = [
            'penyaluran' => $penyaluran,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
            'jenisdana' => $jenisdana,
        ];
        $response = [
            'data' => view($viewFile, $data),
        ];

        echo json_encode($response);
    }

    public function viewLaporanPenyaluranBulan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $jenisdana = $this->request->getPost('jenisdana');
        
        $db = db_connect();
        
        if ($jenisdana == 'zakat') {
            $query = $db
                ->table('penyaluran_dana')
                ->select('penyaluran_dana.id, penyaluran_dana.tglpenyaluran, penyaluran_dana.jenisdana, penyaluran_dana.nominal, 
                         penyaluran_dana.idpermohonan, mustahik.nama as nama_mustahik, 
                         permohonan.kategoriasnaf, permohonan.jenisbantuan')
                ->join('mustahik', 'mustahik.id_mustahik = penyaluran_dana.id_mustahik', 'left')
                ->join('permohonan', 'permohonan.idpermohonan = penyaluran_dana.idpermohonan', 'left')
                ->where('penyaluran_dana.jenisdana', 'zakat')
                ->where('month(penyaluran_dana.tglpenyaluran)', $bulan)
                ->where('year(penyaluran_dana.tglpenyaluran)', $tahun)
                ->orderBy('penyaluran_dana.id', 'DESC')
                ->getCompiledSelect();
            $viewFile = 'laporan/penyaluran/viewallpenyaluranzakatbulan';
        } else {
            $query = $db
                ->table('penyaluran_dana')
                ->select('penyaluran_dana.id, penyaluran_dana.tglpenyaluran, penyaluran_dana.jenisdana, penyaluran_dana.nominal, 
                         mustahik.nama as nama_mustahik, program.namaprogram')
                ->join('mustahik', 'mustahik.id_mustahik = penyaluran_dana.id_mustahik', 'left')
                ->join('program', 'program.idprogram = penyaluran_dana.idprogram', 'left')
                ->where('penyaluran_dana.jenisdana', 'donasi')
                ->where('month(penyaluran_dana.tglpenyaluran)', $bulan)
                ->where('year(penyaluran_dana.tglpenyaluran)', $tahun)
                ->orderBy('penyaluran_dana.id', 'DESC')
                ->getCompiledSelect();
            $viewFile = 'laporan/penyaluran/viewallpenyalurandonasibulan';
        }
        
        $penyaluran = $db->query($query)->getResultArray();
        $data = [
            'penyaluran' => $penyaluran,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jenisdana' => $jenisdana,
        ];
        $response = [
            'data' => view($viewFile, $data),
        ];

        echo json_encode($response);
    }

    }
