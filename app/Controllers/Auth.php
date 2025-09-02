<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OtpModel;
use App\Libraries\EmailService;

class Auth extends BaseController
{
    protected $userModel;
    protected $otpModel;
    protected $emailService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->otpModel = new OtpModel();
        $this->emailService = new EmailService();
        
        // Load helper cookie
        helper('cookie');
        
        // Periksa cookie remember me
        $this->checkRememberMe();
    }

    // Fungsi untuk memeriksa cookie remember me
    protected function checkRememberMe()
    {
        // Jika sudah login, tidak perlu memeriksa cookie
        if (session()->get('logged_in')) {
            return;
        }
        
        // Ambil cookie remember me
        $rememberToken = get_cookie('remember_token');
        $userId = get_cookie('user_id');
        
        // Jika cookie ada, coba login otomatis
        if ($rememberToken && $userId) {
            $db = db_connect();
            $user = $db->table('users')
                ->select('users.*, mustahik.nama')
                ->join('mustahik', 'mustahik.iduser = users.id', 'left')
                ->where('users.id', $userId)
                ->where('users.remember_token', $rememberToken)
                ->where('users.status', 'active')
                ->get()
                ->getRowArray();
            
            if ($user) {
                // Set session untuk login
                $sessionData = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'name' => null, // Tidak menggunakan nama untuk admin dan pimpinan
                    'role' => $user['role'],
                    'logged_in' => true
                ];
                session()->set($sessionData);
                
                // Update last login menggunakan query builder
                $db = db_connect();
                $db->table('users')
                    ->where('id', $user['id'])
                    ->update([
                        'last_login' => date('Y-m-d H:i:s')
                    ]);
            }
        }
    }

    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to(session()->get('redirect_url') ?? 'dashboard');
        }

        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember') == 'on';

        $db = db_connect();
        $user = $db->table('users')
            ->select('users.*, mustahik.nama')
            ->join('mustahik', 'mustahik.iduser = users.id', 'left')
            ->where('users.username', $username)
            ->orWhere('users.email', $username)
            ->get()
            ->getRowArray();

        if ($user) {
            // Debug log

            if ($user['status'] !== 'active') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Akun Anda tidak aktif. Silakan hubungi administrator.'
                ]);
            }

            if (password_verify($password, $user['password'])) {
                // Update last login menggunakan query builder
                $db = db_connect();
                $db->table('users')
                    ->where('id', $user['id'])
                    ->update([
                        'last_login' => date('Y-m-d H:i:s')
                    ]);

                // Set session
                $sessionData = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'name' => null, // Tidak menggunakan nama untuk admin dan pimpinan
                    'role' => $user['role'],
                    'logged_in' => true
                ];
                session()->set($sessionData);

                // Set remember me cookie jika dipilih
                if ($remember) {
                    $this->setRememberMeCookie($user['id']);
                }

                // Redirect berdasarkan role
                $redirect = '';
                if ($user['role'] == 'mustahik' || $user['role'] == 'donatur') {
                    // Untuk mustahik dan donatur, cek dulu apakah profile sudah lengkap
                    $redirect = site_url('profile/check');
                } else if (in_array($user['role'], ['admin', 'program', 'keuangan','ketua'])) {
                    $redirect = site_url('dashboard'); // dashboard
                } else {
                    $redirect = site_url('dashboard'); // default
                }

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Login berhasil',
                    'redirect' => $redirect
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Username/Email atau Password salah'
        ]);
    }

    public function logout()
    {
        // Hapus remember me cookie
        if (get_cookie('remember_token')) {
            delete_cookie('remember_token');
            delete_cookie('user_id');
        }

        // Destroy session
        session()->destroy();

        return redirect()->to('/')->with('message', 'Anda telah berhasil logout');
    }

    protected function setRememberMeCookie($userId)
    {
        $token = bin2hex(random_bytes(32));

        // Simpan token di database menggunakan query builder
        $db = db_connect();
        $db->table('users')
            ->where('id', $userId)
            ->update([
                'remember_token' => $token
            ]);

        // Set cookies yang akan expired dalam 30 hari
        $expires = 30 * 24 * 60 * 60; // 30 hari
        $secure = isset($_SERVER['HTTPS']); // Set secure hanya jika HTTPS

        // Set cookie untuk remember token
        set_cookie(
            'remember_token',
            $token,
            $expires,
            '',  // domain
            '/', // path
            '', // prefix
            $secure, // secure - hanya set true jika HTTPS
            true  // httponly
        );

        // Set cookie untuk user ID
        set_cookie(
            'user_id',
            $userId,
            $expires,
            '',
            '/',
            '',
            $secure,
            true
        );
    }

    // ============ Fungsi Register dengan OTP ============

    public function registerForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        return view('auth/register');
    }

    public function register()
    {
        // Validasi input
        $rules = [
            'role'     => 'required|in_list[donatur,mustahik]',
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return view('auth/register', [
                'validation' => $this->validator
            ]);
        }

        // Jika validasi sukses, kirim OTP
        $email = $this->request->getPost('email');
        
        // Simpan data form di session sementara (termasuk role)
        $formData = [
            'role' => $this->request->getPost('role'),
            'username' => $this->request->getPost('username'),
            'email' => $email,
            'password' => $this->request->getPost('password')
        ];
        session()->set('register_data', $formData);

        
        // Generate OTP dan kirim email
        $otp = $this->otpModel->generateOTP($email, 'register');
        $emailSent = $this->emailService->sendOTP($email, $otp['otp_code'], 'register');
        
        // Redirect ke halaman verifikasi OTP
        return view('auth/verify_otp', [
            'email' => $email,
            'type' => 'register',
            'action' => 'auth/verify-register-otp'
        ]);
    }

    public function verifyRegisterOTP()
    {
        $email = $this->request->getPost('email');
        $otpInput = $this->request->getPost('otp');
        
        // Gabungkan array OTP menjadi string
        $otpCode = implode('', $otpInput);
        
        // Verifikasi OTP
        $otpValid = $this->otpModel->verifyOTP($email, $otpCode, 'register');
        
        if ($otpValid) {
            // Ambil data registrasi dari session
            $formData = session()->get('register_data');
            if (!$formData) {
                return redirect()->to(site_url('auth/register'))
                    ->with('error', 'Sesi pendaftaran telah kedaluarsa. Silakan daftar kembali.');
            }
            
            // Buat user baru dengan role yang dipilih
            $userData = [
                'username' => $formData['username'],
                'email' => $formData['email'],
                'password' => $formData['password'],
                'role' => $formData['role'], // Role dari form
                'status' => 'active'
            ];
            
            if ($this->userModel->save($userData)) {
                // Hapus data registrasi dari session
                session()->remove('register_data');
                
                return redirect()->to(site_url('auth'))
                    ->with('message', 'Pendaftaran berhasil! Silakan login dengan akun yang telah Anda buat.');
            } else {
                $errors = $this->userModel->errors();
                
                return view('auth/verify_otp', [
                    'email' => $email,
                    'type' => 'register', 
                    'action' => 'auth/verify-register-otp',
                    'error' => 'Gagal membuat akun: ' . implode(', ', $errors)
                ]);
            }
        } else {
            return view('auth/verify_otp', [
                'email' => $email,
                'type' => 'register',
                'action' => 'auth/verify-register-otp',
                'error' => 'Kode OTP tidak valid atau sudah kedaluarsa.'
            ]);
        }
    }

    // ============ Fungsi Forgot Password dengan OTP ============

    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            
            // Validasi email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return view('auth/forgot_password', [
                    'error' => 'Email tidak valid'
                ]);
            }
            
            // Cek apakah email terdaftar
            $user = $this->userModel->where('email', $email)->first();
            
            if (!$user) {
                return view('auth/forgot_password', [
                    'error' => 'Email tidak terdaftar di sistem kami'
                ]);
            }
            
            // Generate OTP dan kirim email
            $otp = $this->otpModel->generateOTP($email, 'forgot_password');
            $this->emailService->sendOTP($email, $otp['otp_code'], 'forgot_password');
            
            // Redirect ke halaman verifikasi OTP
            return view('auth/verify_otp', [
                'email' => $email,
                'type' => 'forgot_password',
                'action' => 'auth/verify-forgot-password-otp'
            ]);
        }
        
        return view('auth/forgot_password');
    }

    public function verifyForgotPasswordOTP()
    {
        $email = $this->request->getPost('email');
        $otpInput = $this->request->getPost('otp');
        
        // Gabungkan array OTP menjadi string
        $otpCode = implode('', $otpInput);
        
        // Verifikasi OTP
        if ($this->otpModel->verifyOTP($email, $otpCode, 'forgot_password')) {
            // Simpan email di session untuk form reset password
            session()->set('reset_password_email', $email);
            
            return view('auth/reset_password', [
                'email' => $email
            ]);
        } else {
            return view('auth/verify_otp', [
                'email' => $email,
                'type' => 'forgot_password',
                'action' => 'auth/verify-forgot-password-otp',
                'error' => 'Kode OTP tidak valid atau sudah kedaluarsa.'
            ]);
        }
    }

    public function resetPassword()
    {
        $email = $this->request->getPost('email');
        
        // Tambahkan debug untuk memeriksa masalah
        log_message('debug', 'Reset Password requested for email: ' . $email);
        
        // Pastikan email telah diverifikasi melalui OTP
        $verifiedEmail = session()->get('reset_password_email');
        log_message('debug', 'Verified email from session: ' . ($verifiedEmail ?? 'not set'));
        
        if ($email !== $verifiedEmail) {
            return redirect()->to(site_url('auth/forgot-password'))
                ->with('error', 'Silakan reset password kembali dari awal');
        }
        
        // Validasi password
        $rules = [
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]'
        ];
        
        if (!$this->validate($rules)) {
            return view('auth/reset_password', [
                'email' => $email,
                'validation' => $this->validator
            ]);
        }
        
        // Update password
        $user = $this->userModel->where('email', $email)->first();
        
        if ($user) {
            $this->userModel->update($user['id'], [
                'password' => $this->request->getPost('password')
            ]);
            
            // Hapus session reset password
            session()->remove('reset_password_email');
            
            return redirect()->to(site_url('auth'))
                ->with('message', 'Password berhasil direset. Silakan login dengan password baru Anda.');
        }
        
        return redirect()->to(site_url('auth/forgot-password'))
            ->with('error', 'Gagal mereset password. Email tidak ditemukan.');
    }

    // ============ Fungsi untuk resend OTP ============

    public function resendOTP()
    {
        if ($this->request->isAJAX()) {
            $email = $this->request->getPost('email');
            $type = $this->request->getPost('type');
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Email tidak valid'
                ]);
            }
            
            if (!in_array($type, ['register', 'forgot_password'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Tipe OTP tidak valid'
                ]);
            }
            
            // Generate OTP baru
            $otp = $this->otpModel->generateOTP($email, $type);
            
            // Kirim email OTP
            $sent = $this->emailService->sendOTP($email, $otp['otp_code'], $type);
            
            if ($sent) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Kode OTP baru telah dikirim ke email Anda'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal mengirim kode OTP. Silakan coba lagi.'
                ]);
            }
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid request'
        ]);
    }

    // ============ Fungsi untuk change password ============

    public function changePassword()
    {
        if ($this->request->isAJAX()) {
            // Cek apakah user sudah login
            if (!session()->get('logged_in')) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Anda harus login terlebih dahulu'
                ]);
            }

            // Ambil data dari request
            $input = json_decode($this->request->getBody(), true);
            $currentPassword = $input['currentPassword'] ?? '';
            $newPassword = $input['newPassword'] ?? '';

            // Validasi input
            if (empty($currentPassword)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Password lama harus diisi'
                ]);
            }

            if (empty($newPassword)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Password baru harus diisi'
                ]);
            }

            if (strlen($newPassword) < 6) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Password baru minimal 6 karakter'
                ]);
            }

            if ($currentPassword === $newPassword) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Password baru harus berbeda dengan password lama'
                ]);
            }

            // Ambil data user dari session
            $userId = session()->get('user_id');
            $user = $this->userModel->find($userId);

            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan'
                ]);
            }

            // Verifikasi password lama
            if (!password_verify($currentPassword, $user['password'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Password lama tidak sesuai'
                ]);
            }

            // Update password baru
            $this->userModel->update($userId, [
                'password' => $newPassword
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Password berhasil diubah'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid request'
        ]);
    }
}
