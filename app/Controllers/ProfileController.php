<?php

namespace App\Controllers;

use App\Models\Donatur;
use App\Models\Mustahik;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $donaturModel;
    protected $mustahikModel;
    protected $userModel;

    public function __construct()
    {
        $this->donaturModel = new Donatur();
        $this->mustahikModel = new Mustahik();
        $this->userModel = new UserModel();
    }

    /**
     * Cek apakah user perlu melengkapi profile
     */
    public function checkProfileCompletion()
    {
        // Pastikan user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $userRole = session()->get('role');

        // Cek berdasarkan role
        if ($userRole === 'donatur') {
            if (!$this->donaturModel->hasProfile($userId)) {
                return redirect()->to(site_url('profile/complete/donatur'));
            }
        } elseif ($userRole === 'mustahik') {
            if (!$this->mustahikModel->hasProfile($userId)) {
                return redirect()->to(site_url('profile/complete/mustahik'));
            }
        }

        // Jika profile sudah lengkap, redirect ke dashboard
        return redirect()->to(site_url('/'));
    }

    /**
     * Form untuk melengkapi profile donatur
     */
    public function completeProfileDonatur()
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        
        // Jika sudah ada profile, redirect ke dashboard
        if ($this->donaturModel->hasProfile($userId)) {
            return redirect()->to(site_url('/'));
        }

        $data = [
            'title' => 'Lengkapi Profile Donatur',
            'user_id' => $userId
        ];

        return view('profile/complete_donatur', $data);
    }

    /**
     * Form untuk melengkapi profile mustahik
     */
    public function completeProfileMustahik()
    {
        // Pastikan user sudah login dan role mustahik
        if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        
        // Jika sudah ada profile, redirect ke dashboard
        if ($this->mustahikModel->hasProfile($userId)) {
            return redirect()->to(site_url('/'));
        }

        $data = [
            'title' => 'Lengkapi Profile Mustahik',
            'user_id' => $userId
        ];

        return view('profile/complete_mustahik', $data);
    }

    /**
     * Simpan profile donatur
     */
    public function saveProfileDonatur()
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');

        // Validation rules
        $rules = [
            'nama' => 'required|min_length[3]|max_length[50]',
            'alamat' => 'required|min_length[10]',
            'nohp' => 'required|min_length[10]|max_length[30]',
            'jenkel' => 'required|in_list[L,P]',
            'tgllahir' => 'required|valid_date[Y-m-d]'
        ];

        if (!$this->validate($rules)) {
            return view('profile/complete_donatur', [
                'title' => 'Lengkapi Profile Donatur',
                'user_id' => $userId,
                'validation' => $this->validator,
                'old_input' => $this->request->getPost()
            ]);
        }

        // Generate ID donatur dengan format DN0001
        $lastDonatur = $this->donaturModel->orderBy('id_donatur', 'DESC')->first();
        if ($lastDonatur) {
            $lastNumber = (int)substr($lastDonatur['id_donatur'], 2); // Ambil angka setelah "DN"
            $newNumber = $lastNumber + 1;
            $newId = 'DN' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        } else {
            $newId = 'DN0001';
        }

        $data = [
            'id_donatur' => $newId,
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'nohp' => $this->request->getPost('nohp'),
            'jenkel' => $this->request->getPost('jenkel'),
            'tgllahir' => $this->request->getPost('tgllahir'),
            'iduser' => $userId
        ];

        log_message('debug', 'Saving Donatur Data: ' . print_r($data, true));
        
        if ($this->donaturModel->save($data)) {
            log_message('info', 'Donatur profile saved successfully for user: ' . $userId);
            session()->setFlashdata('message', 'Profile berhasil dilengkapi!');
            return redirect()->to(site_url('/'));
        } else {
            $errors = $this->donaturModel->errors();
            log_message('error', 'Failed to save Donatur profile: ' . print_r($errors, true));
            session()->setFlashdata('error', 'Gagal menyimpan profile: ' . implode(', ', $errors));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Simpan profile mustahik
     */
    public function saveProfileMustahik()
    {
        // Pastikan user sudah login dan role mustahik
        if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');

        // Validation rules
        $rules = [
            'nama' => 'required|min_length[3]|max_length[50]',
            'alamat' => 'required|min_length[10]',
            'nohp' => 'required|min_length[10]|max_length[30]',
            'jenkel' => 'required|in_list[L,P]',
            'tgllahir' => 'required|valid_date[Y-m-d]'
        ];

        if (!$this->validate($rules)) {
            return view('profile/complete_mustahik', [
                'title' => 'Lengkapi Profile Mustahik',
                'user_id' => $userId,
                'validation' => $this->validator,
                'old_input' => $this->request->getPost()
            ]);
        }

        // Generate ID mustahik dengan format M0001  
        $lastMustahik = $this->mustahikModel->orderBy('id_mustahik', 'DESC')->first();
        if ($lastMustahik) {
            $lastNumber = (int)substr($lastMustahik['id_mustahik'], 1); // Ambil angka setelah "M"
            $newNumber = $lastNumber + 1;
            $newId = 'M' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        } else {
            $newId = 'M0001';
        }

        $data = [
            'id_mustahik' => $newId,
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'nohp' => $this->request->getPost('nohp'),
            'jenkel' => $this->request->getPost('jenkel'),
            'tgllahir' => $this->request->getPost('tgllahir'),
            'iduser' => $userId
        ];

        log_message('debug', 'Saving Mustahik Data: ' . print_r($data, true));
        
        if ($this->mustahikModel->save($data)) {
            log_message('info', 'Mustahik profile saved successfully for user: ' . $userId);
            session()->setFlashdata('message', 'Profile berhasil dilengkapi!');
            return redirect()->to(site_url('/'));
        } else {
            $errors = $this->mustahikModel->errors();
            log_message('error', 'Failed to save Mustahik profile: ' . print_r($errors, true));
            session()->setFlashdata('error', 'Gagal menyimpan profile: ' . implode(', ', $errors));
            return redirect()->back()->withInput();
        }
    }
}
