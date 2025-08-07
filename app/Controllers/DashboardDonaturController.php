<?php

namespace App\Controllers;

use App\Models\Donatur;
use App\Models\UserModel;
use App\Models\Donasi as ModelDonasi;
use App\Models\Zakat as ModelZakat;
use App\Models\Program as ModelProgram;
use Hermawan\DataTables\DataTable;

class DashboardDonaturController extends BaseController
{
    protected $donaturModel;
    protected $userModel;
    protected $donasiModel;
    protected $zakatModel;
    protected $programModel;

    public function __construct()
    {
        $this->donaturModel = new Donatur();
        $this->userModel = new UserModel();
        $this->donasiModel = new ModelDonasi();
        $this->zakatModel = new ModelZakat();
        $this->programModel = new ModelProgram();
    }

    public function index()
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        // Jika belum ada profile, redirect ke completion
        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        $data = [
            'title' => 'Dashboard Donatur',
            'donatur' => $donaturData,
            'user' => session()->get()
        ];

        return view('dashboard/donatur/index', $data);
    }

    public function editProfile()
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        // Jika belum ada profile, redirect ke completion
        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        $data = [
            'title' => 'Edit Profile Donatur',
            'donatur' => $donaturData,
            'user' => session()->get()
        ];

        return view('dashboard/donatur/edit_profile', $data);
    }

    public function updateProfile()
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        // Validation rules
        $rules = [
            'nama' => 'required|min_length[3]|max_length[50]',
            'alamat' => 'required|min_length[10]',
            'nohp' => 'required|min_length[10]|max_length[30]',
            'jenkel' => 'required|in_list[L,P]',
            'tgllahir' => 'required|valid_date[Y-m-d]'
        ];

        if (!$this->validate($rules)) {
            return view('dashboard/donatur/edit_profile', [
                'title' => 'Edit Profile Donatur',
                'donatur' => $donaturData,
                'user' => session()->get(),
                'validation' => $this->validator
            ]);
        }

        $updateData = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'nohp' => $this->request->getPost('nohp'),
            'jenkel' => $this->request->getPost('jenkel'),
            'tgllahir' => $this->request->getPost('tgllahir')
        ];

        if ($this->donaturModel->update($donaturData['id_donatur'], $updateData)) {
            session()->setFlashdata('message', 'Profile berhasil diupdate!');
            return redirect()->to(site_url('dashboard/donatur'));
        } else {
            $errors = $this->donaturModel->errors();
            session()->setFlashdata('error', 'Gagal update profile: ' . implode(', ', $errors));
            return redirect()->back()->withInput();
        }
    }

    // DONASI METHODS FOR DONATUR
    public function donasi()
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        // Jika belum ada profile, redirect ke completion
        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        $data = [
            'title' => 'Donasi Saya',
            'donatur' => $donaturData,
            'user' => session()->get()
        ];

        return view('dashboard/donatur/donasi', $data);
    }

    public function viewDonasi()
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        $db = db_connect();
        $query = $db->table('donasi d')
                    ->select('d.iddonasi, p.namaprogram, d.nominal, d.status, d.online, d.tgltransfer, d.created_at')
                    ->join('program p', 'p.idprogram = d.idprogram', 'left')
                    ->where('d.id_donatur', $donaturData['id_donatur']);

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 btn-detail" data-iddonasi="' . $row->iddonasi . '"><i class="fas fa-eye"></i></button>';
            
            // Hanya bisa upload bukti jika status pending dan online
            $button2 = '';
            if ($row->status === 'pending' && $row->online == 1) {
                $button2 = '<button type="button" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 btn-upload ml-2" data-iddonasi="' . $row->iddonasi . '"><i class="fas fa-upload"></i></button>';
            }
            
            return '<div class="flex space-x-1">' . $button1 . $button2 . '</div>';
            }, 'last')
            ->edit('nominal', function ($row) {
                return 'Rp ' . number_format($row->nominal, 0, ',', '.');
            })
            ->edit('status', function ($row) {
                $badges = [
                    'pending' => '<span class="badge badge-warning">Pending</span>',
                    'diterima' => '<span class="badge badge-success">Diterima</span>',
                    'ditolak' => '<span class="badge badge-danger">Ditolak</span>'
                ];
                return $badges[$row->status] ?? '<span class="badge badge-secondary">Unknown</span>';
            })
            ->edit('online', function ($row) {
                return $row->online == 1 ? '<span class="badge badge-info">Online</span>' : '<span class="badge badge-secondary">Offline</span>';
            })
            ->edit('tgltransfer', function ($row) {
                return $row->tgltransfer ? date('d-m-Y H:i', strtotime($row->tgltransfer)) : '-';
            })
            ->edit('created_at', function ($row) {
                return date('d-m-Y H:i', strtotime($row->created_at));
            })
            ->addNumbering()
            ->toJson();
    }

    public function formDonasi($idprogram = null)
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        // Ambil program donasi (bukan zakat, idkategori != 2)
        $db = db_connect();
        $programs = $db->table('program')
                    ->select('idprogram, namaprogram, deskripsi, foto, program.status')
                    ->join('kategori', 'kategori.idkategori = program.idkategori', 'left')
                    ->where('program.idkategori !=', 2)
                    ->get()
                    ->getResultArray();

        // Debug: Log program data
        log_message('info', 'Programs found: ' . count($programs));
        log_message('info', 'Programs data: ' . json_encode($programs));

        $data = [
            'title' => 'Form Donasi',
            'donatur' => $donaturData,
            'programs' => $programs,
            'selected_program' => $idprogram,
            'user' => session()->get()
        ];

        return view('dashboard/donatur/form_donasi', $data);
    }

    public function saveDonasi()
    {
        if ($this->request->isAJAX()) {
            // Pastikan user sudah login dan role donatur
            if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
                return $this->response->setJSON(['error' => 'Unauthorized']);
            }

            $userId = session()->get('user_id');
            $donaturData = $this->donaturModel->getByUserId($userId);

            if (!$donaturData) {
                return $this->response->setJSON(['error' => 'Profile donatur tidak ditemukan']);
            }

            $idprogram = $this->request->getPost('idprogram');
            $nominal = $this->request->getPost('nominal');
            $buktibayar = $this->request->getFile('buktibayar');

            // Generate ID donasi
            $db = db_connect();
            $query = $db->query("SELECT CONCAT('DN', LPAD(IFNULL(MAX(SUBSTRING(iddonasi, 3)) + 1, 1), 4, '0')) AS next_number FROM donasi");
            $row = $query->getRow();
            $iddonasi = $row->next_number;

            $rules = [
                'idprogram' => [
                    'label' => 'Program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'nominal' => [
                    'label' => 'Nominal',
                    'rules' => 'required|numeric|greater_than[0]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                        'greater_than' => '{field} harus lebih besar dari 0'
                    ]
                ],
                'buktibayar' => [
                    'label' => 'Bukti Bayar',
                    'rules' => 'uploaded[buktibayar]|mime_in[buktibayar,image/jpg,image/jpeg,image/png]|max_size[buktibayar,5120]',
                    'errors' => [
                        'uploaded' => '{field} harus diupload',
                        'mime_in' => '{field} harus berformat JPG, JPEG, atau PNG',
                        'max_size' => 'Ukuran {field} maksimal adalah 5MB'
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }

                return $this->response->setJSON([
                    'error' => $errors
                ]);
            } else {
                // Upload bukti bayar
                if ($buktibayar && $buktibayar->isValid() && !$buktibayar->hasMoved()) {
                    $newName = 'donasi-' . date('Ymd') . '-' . $iddonasi . '.' . $buktibayar->getClientExtension();
                    $buktibayar->move('uploads/donasi/', $newName);

                    $this->donasiModel->insert([
                        'iddonasi' => $iddonasi,
                        'id_donatur' => $donaturData['id_donatur'],
                        'idprogram' => $idprogram,
                        'nominal' => $nominal,
                        'online' => 1, // Online payment
                        'buktibayar' => $newName,
                        'tgltransfer' => date('Y-m-d H:i:s'),
                        'status' => 'pending' // Pending verification
                    ]);

                    return $this->response->setJSON([
                        'sukses' => 'Donasi berhasil diajukan! Menunggu verifikasi admin.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => 'Gagal upload bukti bayar'
                    ]);
                }
            }
        }
    }

    public function detailDonasi($iddonasi)
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        $db = db_connect();
        $donasi = $db->table('donasi d')
            ->select('d.*, p.namaprogram, p.deskripsi as deskripsi_program')
            ->join('program p', 'p.idprogram = d.idprogram', 'left')
            ->where('d.iddonasi', $iddonasi)
            ->where('d.id_donatur', $donaturData['id_donatur']) // Pastikan hanya bisa lihat donasi sendiri
            ->get()
            ->getRowArray();

        if (!$donasi) {
            return redirect()->to(site_url('dashboard/donatur/donasi'))->with('error', 'Data Donasi tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Donasi',
            'donasi' => $donasi,
            'donatur' => $donaturData,
            'user' => session()->get()
        ];

        return view('dashboard/donatur/detail_donasi', $data);
    }

    public function uploadBuktiDonasi()
    {
        if ($this->request->isAJAX()) {
            // Pastikan user sudah login dan role donatur
            if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
                return $this->response->setJSON(['error' => 'Unauthorized']);
            }

            $userId = session()->get('user_id');
            $donaturData = $this->donaturModel->getByUserId($userId);

            if (!$donaturData) {
                return $this->response->setJSON(['error' => 'Profile donatur tidak ditemukan']);
            }

            $iddonasi = $this->request->getPost('iddonasi');
            $buktibayar = $this->request->getFile('buktibayar');

            // Cek apakah donasi milik donatur yang login
            $donasi = $this->donasiModel->where('iddonasi', $iddonasi)
                                       ->where('id_donatur', $donaturData['id_donatur'])
                                       ->first();

            if (!$donasi) {
                return $this->response->setJSON(['error' => 'Donasi tidak ditemukan']);
            }

            // Hanya bisa upload jika status pending dan online
            if ($donasi['status'] !== 'pending' || $donasi['online'] != 1) {
                return $this->response->setJSON(['error' => 'Tidak dapat mengupload bukti bayar']);
            }

            $rules = [
                'buktibayar' => [
                    'label' => 'Bukti Bayar',
                    'rules' => 'uploaded[buktibayar]|mime_in[buktibayar,image/jpg,image/jpeg,image/png]|max_size[buktibayar,5120]',
                    'errors' => [
                        'uploaded' => '{field} harus diupload',
                        'mime_in' => '{field} harus berformat JPG, JPEG, atau PNG',
                        'max_size' => 'Ukuran {field} maksimal adalah 5MB'
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'error' => $this->validator->getError('buktibayar')
                ]);
            } else {
                // Hapus bukti lama jika ada
                if (!empty($donasi['buktibayar']) && file_exists('uploads/donasi/' . $donasi['buktibayar'])) {
                    unlink('uploads/donasi/' . $donasi['buktibayar']);
                }

                // Upload bukti baru
                if ($buktibayar && $buktibayar->isValid() && !$buktibayar->hasMoved()) {
                    $newName = 'donasi-' . date('Ymd') . '-' . $iddonasi . '.' . $buktibayar->getClientExtension();
                    $buktibayar->move('uploads/donasi/', $newName);

                    $this->donasiModel->update($iddonasi, [
                        'buktibayar' => $newName,
                        'tgltransfer' => date('Y-m-d H:i:s')
                    ]);

                    return $this->response->setJSON([
                        'sukses' => 'Bukti bayar berhasil diupload!'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => 'Gagal upload bukti bayar'
                    ]);
                }
            }
        }
    }

    // ZAKAT METHODS FOR DONATUR
    public function zakat()
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        // Jika belum ada profile, redirect ke completion
        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        $data = [
            'title' => 'Zakat Saya',
            'donatur' => $donaturData,
            'user' => session()->get()
        ];

        return view('dashboard/donatur/zakat', $data);
    }

    public function viewZakat()
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        $db = db_connect();
        $query = $db->table('zakat z')
                    ->select('z.idzakat, p.namaprogram, z.nominal, z.status, z.online, z.tgltransfer, z.created_at')
                    ->join('program p', 'p.idprogram = z.jeniszakat', 'left')
                    ->where('z.id_donatur', $donaturData['id_donatur'])
                    ->where('p.idkategori', 2); // Hanya program zakat

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 btn-detail" data-idzakat="' . $row->idzakat . '"><i class="fas fa-eye"></i></button>';
            
            // Hanya bisa upload bukti jika status pending dan online
            $button2 = '';
            if ($row->status === 'pending' && $row->online == 1) {
                $button2 = '<button type="button" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 btn-upload ml-2" data-idzakat="' . $row->idzakat . '"><i class="fas fa-upload"></i></button>';
            }
            
            return '<div class="flex space-x-1">' . $button1 . $button2 . '</div>';
            }, 'last')
            ->edit('nominal', function ($row) {
                return 'Rp ' . number_format($row->nominal, 0, ',', '.');
            })
            ->edit('status', function ($row) {
                $badges = [
                    'pending' => '<span class="badge badge-warning">Pending</span>',
                    'diterima' => '<span class="badge badge-success">Diterima</span>',
                    'ditolak' => '<span class="badge badge-danger">Ditolak</span>'
                ];
                return $badges[$row->status] ?? '<span class="badge badge-secondary">Unknown</span>';
            })
            ->edit('online', function ($row) {
                return $row->online == 1 ? '<span class="badge badge-info">Online</span>' : '<span class="badge badge-secondary">Offline</span>';
            })
            ->edit('tgltransfer', function ($row) {
                return $row->tgltransfer ? date('d-m-Y H:i', strtotime($row->tgltransfer)) : '-';
            })
            ->edit('created_at', function ($row) {
                return date('d-m-Y H:i', strtotime($row->created_at));
            })
            ->addNumbering()
            ->toJson();
    }

    public function formZakat()
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        // Ambil program zakat (idkategori = 2)
        $db = db_connect();
        $programs = $db->table('program')
                    ->select('idprogram, namaprogram, deskripsi, foto, program.status')
                    ->join('kategori', 'kategori.idkategori = program.idkategori', 'left')
                    ->where('program.idkategori', 2)
                    ->get()
                    ->getResultArray();

        $data = [
            'title' => 'Form Zakat',
            'donatur' => $donaturData,
            'programs' => $programs,
            'user' => session()->get()
        ];

        return view('dashboard/donatur/form_zakat', $data);
    }

    public function saveZakat()
    {
        if ($this->request->isAJAX()) {
            // Pastikan user sudah login dan role donatur
            if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
                return $this->response->setJSON(['error' => 'Unauthorized']);
            }

            $userId = session()->get('user_id');
            $donaturData = $this->donaturModel->getByUserId($userId);

            if (!$donaturData) {
                return $this->response->setJSON(['error' => 'Profile donatur tidak ditemukan']);
            }

            $jeniszakat = $this->request->getPost('jeniszakat'); // idprogram
            $nominal = $this->request->getPost('nominal');
            $buktibayar = $this->request->getFile('buktibayar');

            // Generate ID zakat
            $db = db_connect();
            $query = $db->query("SELECT CONCAT('ZK', LPAD(IFNULL(MAX(SUBSTRING(idzakat, 3)) + 1, 1), 4, '0')) AS next_number FROM zakat");
            $row = $query->getRow();
            $idzakat = $row->next_number;

            $rules = [
                'jeniszakat' => [
                    'label' => 'Jenis Zakat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'nominal' => [
                    'label' => 'Nominal',
                    'rules' => 'required|numeric|greater_than[0]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                        'greater_than' => '{field} harus lebih besar dari 0'
                    ]
                ],
                'buktibayar' => [
                    'label' => 'Bukti Bayar',
                    'rules' => 'uploaded[buktibayar]|mime_in[buktibayar,image/jpg,image/jpeg,image/png]|max_size[buktibayar,5120]',
                    'errors' => [
                        'uploaded' => '{field} harus diupload',
                        'mime_in' => '{field} harus berformat JPG, JPEG, atau PNG',
                        'max_size' => 'Ukuran {field} maksimal adalah 5MB'
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }

                return $this->response->setJSON([
                    'error' => $errors
                ]);
            } else {
                // Upload bukti bayar
                if ($buktibayar && $buktibayar->isValid() && !$buktibayar->hasMoved()) {
                    $newName = 'zakat-' . date('Ymd') . '-' . $idzakat . '.' . $buktibayar->getClientExtension();
                    $buktibayar->move('uploads/zakat/', $newName);

                    $this->zakatModel->insert([
                        'idzakat' => $idzakat,
                        'id_donatur' => $donaturData['id_donatur'],
                        'jeniszakat' => $jeniszakat, // idprogram
                        'nominal' => $nominal,
                        'online' => 1, // Online payment
                        'buktibayar' => $newName,
                        'tgltransfer' => date('Y-m-d H:i:s'),
                        'status' => 'pending' // Pending verification
                    ]);

                    return $this->response->setJSON([
                        'sukses' => 'Zakat berhasil diajukan! Menunggu verifikasi admin.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => 'Gagal upload bukti bayar'
                    ]);
                }
            }
        }
    }

    public function detailZakat($idzakat)
    {
        // Pastikan user sudah login dan role donatur
        if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $donaturData = $this->donaturModel->getByUserId($userId);

        if (!$donaturData) {
            return redirect()->to(site_url('profile/complete/donatur'));
        }

        $db = db_connect();
        $zakat = $db->table('zakat z')
            ->select('z.*, p.namaprogram, p.deskripsi as deskripsi_program')
            ->join('program p', 'p.idprogram = z.jeniszakat', 'left')
            ->where('z.idzakat', $idzakat)
            ->where('z.id_donatur', $donaturData['id_donatur']) // Pastikan hanya bisa lihat zakat sendiri
            ->get()
            ->getRowArray();

        if (!$zakat) {
            return redirect()->to(site_url('dashboard/donatur/zakat'))->with('error', 'Data Zakat tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Zakat',
            'zakat' => $zakat,
            'donatur' => $donaturData,
            'user' => session()->get()
        ];

        return view('dashboard/donatur/detail_zakat', $data);
    }

    public function uploadBuktiZakat()
    {
        if ($this->request->isAJAX()) {
            // Pastikan user sudah login dan role donatur
            if (!session()->get('logged_in') || session()->get('role') !== 'donatur') {
                return $this->response->setJSON(['error' => 'Unauthorized']);
            }

            $userId = session()->get('user_id');
            $donaturData = $this->donaturModel->getByUserId($userId);

            if (!$donaturData) {
                return $this->response->setJSON(['error' => 'Profile donatur tidak ditemukan']);
            }

            $idzakat = $this->request->getPost('idzakat');
            $buktibayar = $this->request->getFile('buktibayar');

            // Cek apakah zakat milik donatur yang login
            $zakat = $this->zakatModel->where('idzakat', $idzakat)
                                     ->where('id_donatur', $donaturData['id_donatur'])
                                     ->first();

            if (!$zakat) {
                return $this->response->setJSON(['error' => 'Zakat tidak ditemukan']);
            }

            // Hanya bisa upload jika status pending dan online
            if ($zakat['status'] !== 'pending' || $zakat['online'] != 1) {
                return $this->response->setJSON(['error' => 'Tidak dapat mengupload bukti bayar']);
            }

            $rules = [
                'buktibayar' => [
                    'label' => 'Bukti Bayar',
                    'rules' => 'uploaded[buktibayar]|mime_in[buktibayar,image/jpg,image/jpeg,image/png]|max_size[buktibayar,5120]',
                    'errors' => [
                        'uploaded' => '{field} harus diupload',
                        'mime_in' => '{field} harus berformat JPG, JPEG, atau PNG',
                        'max_size' => 'Ukuran {field} maksimal adalah 5MB'
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'error' => $this->validator->getError('buktibayar')
                ]);
            } else {
                // Hapus bukti lama jika ada
                if (!empty($zakat['buktibayar']) && file_exists('uploads/zakat/' . $zakat['buktibayar'])) {
                    unlink('uploads/zakat/' . $zakat['buktibayar']);
                }

                // Upload bukti baru
                if ($buktibayar && $buktibayar->isValid() && !$buktibayar->hasMoved()) {
                    $newName = 'zakat-' . date('Ymd') . '-' . $idzakat . '.' . $buktibayar->getClientExtension();
                    $buktibayar->move('uploads/zakat/', $newName);

                    $this->zakatModel->update($idzakat, [
                        'buktibayar' => $newName,
                        'tgltransfer' => date('Y-m-d H:i:s')
                    ]);

                    return $this->response->setJSON([
                        'sukses' => 'Bukti bayar berhasil diupload!'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => 'Gagal upload bukti bayar'
                    ]);
                }
            }
        }
    }

    public function kalkulatorZakat()
    {
        $data = [
            'title' => 'Kalkulator Zakat'
        ];
        
        return view('dashboard/donatur/kalkulator_zakat', $data);
    }
}
