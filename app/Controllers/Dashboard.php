<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Donatur;
use App\Models\Mustahik;
use App\Models\UserModel;
use App\Models\Permohonan;
use App\Models\Kategori;
use App\Models\Program;
use App\Models\Zakat;
use App\Models\Donasi;
use App\Models\Penyaluran;

class Dashboard extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('auth'));
        }

        // Redirect based on role to specific dashboards
        $role = session()->get('role');
        
        switch($role) {
            case 'donatur':
                return redirect()->to(site_url('dashboard/donatur'));
            case 'mustahik':
                return redirect()->to(site_url('dashboard/mustahik'));
            case 'admin':
            case 'program':
            case 'keuangan':
            case 'ketua':
                // Get real data from database
                $data = $this->getDashboardData($role);
                return view('dashboard/index', $data);
            default:
                return redirect()->to(site_url('auth'));
        }
    }

    private function getDashboardData($role)
    {
        $data = [];

        // Common models
        $donaturModel = new Donatur();
        $mustahikModel = new Mustahik();
        $userModel = new UserModel();
        $permohonanModel = new Permohonan();
        $kategoriModel = new Kategori();
        $programModel = new Program();
        $zakatModel = new Zakat();
        $donasiModel = new Donasi();
        $penyaluranModel = new Penyaluran();

        switch($role) {
            case 'admin':
                $data = [
                    'total_mustahik' => $mustahikModel->countAll(),
                    'total_donatur' => $donaturModel->countAll(),
                    'total_users' => $userModel->countAll(),
                    'total_permohonan' => $permohonanModel->where('status', 'pending')->countAllResults()
                ];
                break;

            case 'program':
                $data = [
                    'total_kategori' => $kategoriModel->countAll(),
                    'total_program' => $programModel->countAll(),
                    'permohonan_baru' => $permohonanModel->where('status', 'pending')->countAllResults()
                ];
                break;

            case 'keuangan':
                // Get total amounts
                $totalZakat = $zakatModel->selectSum('nominal')->where('status', 'diterima')->get()->getRow()->nominal ?? 0;
                $totalDonasi = $donasiModel->selectSum('nominal')->where('status', 'diterima')->get()->getRow()->nominal ?? 0;
                $totalPenyaluran = $penyaluranModel->selectSum('nominal')->get()->getRow()->nominal ?? 0;
                $saldo = $totalZakat + $totalDonasi - $totalPenyaluran;

                $data = [
                    'total_zakat' => $totalZakat,
                    'total_donasi' => $totalDonasi,
                    'total_penyaluran' => $totalPenyaluran,
                    'saldo' => $saldo
                ];
                break;

            case 'ketua':
                // Get financial overview
                $totalZakat = $zakatModel->selectSum('nominal')->where('status', 'diterima')->get()->getRow()->nominal ?? 0;
                $totalDonasi = $donasiModel->selectSum('nominal')->where('status', 'diterima')->get()->getRow()->nominal ?? 0;
                $totalPenyaluran = $penyaluranModel->selectSum('nominal')->get()->getRow()->nominal ?? 0;
                $danaMasuk = $totalZakat + $totalDonasi;
                $danaKeluar = $totalPenyaluran;
                $totalBeneficiary = $mustahikModel->countAll() + $donaturModel->countAll();
                $efektivitas = $danaMasuk > 0 ? round(($danaKeluar / $danaMasuk) * 100) : 0;

                $data = [
                    'dana_masuk' => $danaMasuk,
                    'dana_keluar' => $danaKeluar,
                    'total_beneficiary' => $totalBeneficiary,
                    'efektivitas' => $efektivitas
                ];
                break;
        }

        return $data;
    }
}