<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $title = [
            'title' => 'Kelola Data User'
        ];
        return view('user/datauser', $title);
    }

    public function view()
    {
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'error' => 'Akses ditolak'
            ])->setStatusCode(403);
        }

        $db = db_connect();
        $query = $db->table('users u')
            ->select('u.id, u.username, u.email, u.role, u.status, u.last_login, u.created_at');

        return DataTable::of($query)
            // Format role
            ->edit('role', function ($row) {
                $badges = [
                    'admin' => '<span class="badge badge-danger">Admin</span>',
                    'ketua' => '<span class="badge badge-primary">Ketua</span>',
                    'program' => '<span class="badge badge-info">Program</span>',
                    'keuangan' => '<span class="badge badge-warning">Keuangan</span>',
                    'mustahik' => '<span class="badge badge-success">Mustahik</span>',
                    'donatur' => '<span class="badge badge-dark">Donatur</span>'
                ];
                return $badges[$row->role] ?? '<span class="badge badge-secondary">Unknown</span>';
            })
            // Format status
            ->edit('status', function ($row) {
                if ($row->status == 'active') {
                    return '<span class="badge badge-success">Aktif</span>';
                } else {
                    return '<span class="badge badge-secondary">Tidak Aktif</span>';
                }
            })
            // Format last login
            ->edit('last_login', function ($row) {
                if ($row->last_login) {
                    return date('d-m-Y H:i', strtotime($row->last_login));
                }
                return '-';
            })
            // Format created_at
            ->edit('created_at', function ($row) {
                if ($row->created_at) {
                    return date('d-m-Y H:i', strtotime($row->created_at));
                }
                return '-';
            })
            // Tombol aksi
            ->add('action', function ($row) {
                $button1 = '<button type="button" class="btn btn-info btn-sm btn-detail" data-id="' . $row->id . '" style="margin-right: 5px;"><i class="fas fa-eye"></i></button>';
                $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-id="' . $row->id . '" style="margin-right: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '"><i class="fas fa-trash"></i></button>';
                $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
                return $buttonsGroup;
            }, 'last')
            ->hide('id')
            ->addNumbering()
            ->toJson();
    }

    public function formtambah()
    {
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Tambah User Baru'
        ];
        return view('user/formtambah', $data);
    }

    public function save()
    {
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ])->setStatusCode(403);
        }

        if ($this->request->isAJAX()) {
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $role = $this->request->getPost('role');
            $status = $this->request->getPost('status');

            $data = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => $role,
                'status' => $status
            ];

            $validation = \Config\Services::validation();
            $validation->setRules($this->userModel->getValidationRules());

            if (!$validation->run($data)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validation->getErrors()
                ]);
            }

            try {
                if ($this->userModel->save($data)) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'User berhasil ditambahkan'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Gagal menambahkan user',
                        'errors' => $this->userModel->errors()
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    public function formedit($id)
    {
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];
        return view('user/formedit', $data);
    }

    public function updatedata($id)
    {
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ])->setStatusCode(403);
        }

        if ($this->request->isAJAX()) {
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $role = $this->request->getPost('role');
            $status = $this->request->getPost('status');

            $data = [
                'id' => $id,
                'username' => $username,
                'email' => $email,
                'role' => $role,
                'status' => $status
            ];

            // Jika password diisi, tambahkan ke data
            if (!empty($password)) {
                $data['password'] = $password;
            }

            $validation = \Config\Services::validation();
            $validation->setRules($this->userModel->getValidationRules());

            if (!$validation->run($data)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validation->getErrors()
                ]);
            }

            try {
                if ($this->userModel->save($data)) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'User berhasil diupdate'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Gagal mengupdate user',
                        'errors' => $this->userModel->errors()
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    public function detail()
    {
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ])->setStatusCode(403);
        }

        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            
            $user = $this->userModel->find($id);
            if ($user) {
                // Format data untuk ditampilkan
                $user['last_login_formatted'] = $user['last_login'] ? date('d-m-Y H:i:s', strtotime($user['last_login'])) : 'Belum pernah login';
                $user['created_at_formatted'] = $user['created_at'] ? date('d-m-Y H:i:s', strtotime($user['created_at'])) : '-';
                $user['updated_at_formatted'] = $user['updated_at'] ? date('d-m-Y H:i:s', strtotime($user['updated_at'])) : '-';
                
                // Hapus password dari response
                unset($user['password']);
                unset($user['remember_token']);

                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $user
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan'
                ]);
            }
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    public function delete()
    {
        // Cek apakah user adalah admin
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ])->setStatusCode(403);
        }

        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            
            // Cek apakah user yang akan dihapus bukan user yang sedang login
            if ($id == session()->get('user_id')) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak dapat menghapus akun sendiri'
                ]);
            }

            try {
                if ($this->userModel->delete($id)) {
                    return $this->response->setJSON([
                        'status' => 'success',
                        'message' => 'User berhasil dihapus'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Gagal menghapus user'
                    ]);
                }
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
}