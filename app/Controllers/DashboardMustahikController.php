<?php

namespace App\Controllers;

use App\Models\Mustahik;
use App\Models\UserModel;
use App\Models\Permohonan as ModelPermohonan;
use App\Models\Syarat as ModelSyarat;
use Hermawan\DataTables\DataTable;

class DashboardMustahikController extends BaseController
{
    protected $mustahikModel;
    protected $userModel;
    protected $permohonanModel;
    protected $syaratModel;

    public function __construct()
    {
        $this->mustahikModel = new Mustahik();
        $this->userModel = new UserModel();
        $this->permohonanModel = new ModelPermohonan();
        $this->syaratModel = new ModelSyarat();
    }

    public function index()
    {
        // Pastikan user sudah login dan role mustahik
        if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $mustahikData = $this->mustahikModel->getByUserId($userId);

        // Jika belum ada profile, redirect ke completion
        if (!$mustahikData) {
            return redirect()->to(site_url('profile/complete/mustahik'));
        }

        $data = [
            'title' => 'Dashboard Mustahik',
            'mustahik' => $mustahikData,
            'user' => session()->get()
        ];

        return view('dashboard/mustahik/index', $data);
    }

    public function editProfile()
    {
        // Pastikan user sudah login dan role mustahik
        if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $mustahikData = $this->mustahikModel->getByUserId($userId);

        // Jika belum ada profile, redirect ke completion
        if (!$mustahikData) {
            return redirect()->to(site_url('profile/complete/mustahik'));
        }

        $data = [
            'title' => 'Edit Profile Mustahik',
            'mustahik' => $mustahikData,
            'user' => session()->get()
        ];

        return view('dashboard/mustahik/edit_profile', $data);
    }

    public function updateProfile()
    {
        // Pastikan user sudah login dan role mustahik
        if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $mustahikData = $this->mustahikModel->getByUserId($userId);

        if (!$mustahikData) {
            return redirect()->to(site_url('profile/complete/mustahik'));
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
            return view('dashboard/mustahik/edit_profile', [
                'title' => 'Edit Profile Mustahik',
                'mustahik' => $mustahikData,
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

        if ($this->mustahikModel->update($mustahikData['id_mustahik'], $updateData)) {
            session()->setFlashdata('message', 'Profile berhasil diupdate!');
            return redirect()->to(site_url('dashboard/mustahik'));
        } else {
            $errors = $this->mustahikModel->errors();
            session()->setFlashdata('error', 'Gagal update profile: ' . implode(', ', $errors));
            return redirect()->back()->withInput();
        }
    }

    // PERMOHONAN METHODS FOR MUSTAHIK
    public function permohonan()
    {
        // Pastikan user sudah login dan role mustahik
        if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $mustahikData = $this->mustahikModel->getByUserId($userId);

        // Jika belum ada profile, redirect ke completion
        if (!$mustahikData) {
            return redirect()->to(site_url('profile/complete/mustahik'));
        }

        $data = [
            'title' => 'Permohonan Bantuan',
            'mustahik' => $mustahikData,
            'user' => session()->get()
        ];

        return view('dashboard/mustahik/permohonan', $data);
    }

    public function viewPermohonan()
    {
        // Pastikan user sudah login dan role mustahik
        if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $mustahikData = $this->mustahikModel->getByUserId($userId);

        if (!$mustahikData) {
            return redirect()->to(site_url('profile/complete/mustahik'));
        }

        $db = db_connect();
        $query = $db->table('permohonan p')
                    ->select('p.idpermohonan, p.kategoriasnaf, p.jenisbantuan, p.tglpengajuan, p.tgldisetujui, p.status')
                    ->where('p.id_mustahik', $mustahikData['id_mustahik']);

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm btn-detail" data-idpermohonan="' . $row->idpermohonan . '"><i class="fas fa-eye mr-1"></i>Detail</button>';
            
            // Hanya bisa edit jika status masih diproses
            if ($row->status === 'diproses') {
                $button2 = '<button type="button" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm btn-edit ml-2" data-idpermohonan="' . $row->idpermohonan . '"><i class="fas fa-pencil-alt mr-1"></i>Edit</button>';
                $button3 = '<button type="button" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm btn-delete ml-2" data-idpermohonan="' . $row->idpermohonan . '"><i class="fas fa-trash mr-1"></i>Hapus</button>';
                $buttonsGroup = '<div class="flex flex-wrap gap-1">' . $button1 . $button2 . $button3 . '</div>';
            } else {
                $buttonsGroup = '<div class="flex">' . $button1 . '</div>';
            }
            
            return $buttonsGroup;
            }, 'last')
            ->edit('tglpengajuan', function ($row) {
                return $row->tglpengajuan ? date('d-m-Y', strtotime($row->tglpengajuan)) : '-';
            })
            ->edit('tgldisetujui', function ($row) {
                return $row->tgldisetujui ? date('d-m-Y', strtotime($row->tgldisetujui)) : '-';
            })
            ->edit('status', function ($row) {
                $badges = [
                    'diproses' => '<span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Diproses</span>',
                    'diterima' => '<span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Diterima</span>',
                    'ditolak' => '<span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Ditolak</span>',
                    'selesai' => '<span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Selesai</span>'
                ];
                return $badges[$row->status] ?? '<span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Unknown</span>';
            })
            ->edit('kategoriasnaf', function ($row) {
                return ucfirst($row->kategoriasnaf);
            })
            ->addNumbering()
            ->toJson();
    }

    public function formtambahPermohonan()
    {
        // Pastikan user sudah login dan role mustahik
        if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $mustahikData = $this->mustahikModel->getByUserId($userId);

        if (!$mustahikData) {
            return redirect()->to(site_url('profile/complete/mustahik'));
        }

        $db = db_connect();
        $query = $db->query("SELECT CONCAT('PM', LPAD(IFNULL(MAX(SUBSTRING(idpermohonan, 3)) + 1, 1), 4, '0')) AS next_number FROM permohonan");
        $row = $query->getRow();
        $next_number = $row->next_number;
        
        // Ambil data syarat untuk dropdown kategori asnaf
        $syarats = $this->syaratModel->findAll();
        
        $data = [
            'title' => 'Tambah Permohonan Bantuan',
            'next_number' => $next_number,
            'mustahik' => $mustahikData,
            'syarats' => $syarats,
            'user' => session()->get()
        ];

        return view('dashboard/mustahik/formtambah_permohonan', $data);
    }

    public function savePermohonan()
    {
        if ($this->request->isAJAX()) {
            // Pastikan user sudah login dan role mustahik
            if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
                return $this->response->setJSON(['error' => 'Unauthorized']);
            }

            $userId = session()->get('user_id');
            $mustahikData = $this->mustahikModel->getByUserId($userId);

            if (!$mustahikData) {
                return $this->response->setJSON(['error' => 'Profile mustahik tidak ditemukan']);
            }

            $idpermohonan = $this->request->getPost('idpermohonan');
            $kategoriasnaf = $this->request->getPost('kategoriasnaf');
            $jenisbantuan = $this->request->getPost('jenisbantuan');
            $tglpengajuan = $this->request->getPost('tglpengajuan');
            $alasan = $this->request->getPost('alasan');
            $dokumen = $this->request->getFile('dokumen');

            // Validasi kategori asnaf berdasarkan data dari database
            $syarats = $this->syaratModel->findAll();
            $validKategori = array_column($syarats, 'kategori_asnaf');
            $kategoriList = implode(',', $validKategori);

            $rules = [
                'idpermohonan' => [
                    'label' => 'ID Permohonan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kategoriasnaf' => [
                    'label' => 'Kategori Asnaf',
                    'rules' => 'required|in_list[' . $kategoriList . ']',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                        'in_list' => '{field} tidak valid'
                    ]
                ],
                'jenisbantuan' => [
                    'label' => 'Jenis Bantuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tglpengajuan' => [
                    'label' => 'Tanggal Pengajuan',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_date' => '{field} harus berupa tanggal yang valid'
                    ]
                ],
                'alasan' => [
                    'label' => 'Alasan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'dokumen' => [
                    'label' => 'Dokumen',
                    'rules' => 'mime_in[dokumen,application/pdf]|max_size[dokumen,5120]', 
                    'errors' => [
                        'mime_in' => 'File harus berformat PDF',
                        'max_size' => 'Ukuran file maksimal adalah 5MB'
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }

                $json = [
                    'error' => $errors
                ];
            } else {
                if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
                    $newName = 'dokumen-' . date('Ymd') . '-' . $idpermohonan . '.' . $dokumen->getClientExtension();
                    $dokumen->move('uploads/permohonan/', $newName);

                    $this->permohonanModel->insert([
                        'idpermohonan' => $idpermohonan,
                        'id_mustahik' => $mustahikData['id_mustahik'],
                        'kategoriasnaf' => $kategoriasnaf,
                        'jenisbantuan' => $jenisbantuan,
                        'tglpengajuan' => $tglpengajuan,
                        'alasan' => $alasan,
                        'dokumen' => $newName,
                        'status' => 'diproses', // Default status
                    ]);

                    $json = [
                        'sukses' => 'Permohonan berhasil diajukan'
                    ];
                } else {
                    // Jika tidak ada dokumen, tetap simpan data tanpa dokumen
                    $this->permohonanModel->insert([
                        'idpermohonan' => $idpermohonan,
                        'id_mustahik' => $mustahikData['id_mustahik'],
                        'kategoriasnaf' => $kategoriasnaf,
                        'jenisbantuan' => $jenisbantuan,
                        'tglpengajuan' => $tglpengajuan,
                        'alasan' => $alasan,
                        'status' => 'diproses', // Default status
                    ]);

                    $json = [
                        'sukses' => 'Permohonan berhasil diajukan'
                    ];
                }
            }
            echo json_encode($json);
        }
    }

    public function formeditPermohonan($idpermohonan)
    {
        // Pastikan user sudah login dan role mustahik
        if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $mustahikData = $this->mustahikModel->getByUserId($userId);

        if (!$mustahikData) {
            return redirect()->to(site_url('profile/complete/mustahik'));
        }

        $permohonan = $this->permohonanModel->find($idpermohonan);

        if (!$permohonan) {
            return redirect()->to(site_url('dashboard/mustahik/permohonan'))->with('error', 'Data Permohonan tidak ditemukan');
        }

        // Pastikan permohonan ini milik mustahik yang sedang login
        if ($permohonan['id_mustahik'] != $mustahikData['id_mustahik']) {
            return redirect()->to(site_url('dashboard/mustahik/permohonan'))->with('error', 'Akses ditolak');
        }

        // Hanya bisa edit jika status masih diproses
        if ($permohonan['status'] !== 'diproses') {
            return redirect()->to(site_url('dashboard/mustahik/permohonan'))->with('error', 'Permohonan tidak dapat diedit karena sudah diproses');
        }
        
        // Ambil data syarat untuk dropdown kategori asnaf
        $syarats = $this->syaratModel->findAll();
        
        $data = [
            'title' => 'Edit Permohonan Bantuan',
            'permohonan' => $permohonan,
            'mustahik' => $mustahikData,
            'syarats' => $syarats,
            'user' => session()->get()
        ];

        return view('dashboard/mustahik/formedit_permohonan', $data);
    }

    public function updatePermohonan($idpermohonan)
    {
        if ($this->request->isAJAX()) {
            // Pastikan user sudah login dan role mustahik
            if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
                return $this->response->setJSON(['error' => 'Unauthorized']);
            }

            $userId = session()->get('user_id');
            $mustahikData = $this->mustahikModel->getByUserId($userId);

            if (!$mustahikData) {
                return $this->response->setJSON(['error' => 'Profile mustahik tidak ditemukan']);
            }

            $permohonan = $this->permohonanModel->find($idpermohonan);

            if (!$permohonan || $permohonan['id_mustahik'] != $mustahikData['id_mustahik']) {
                return $this->response->setJSON(['error' => 'Permohonan tidak ditemukan atau akses ditolak']);
            }

            // Hanya bisa edit jika status masih diproses
            if ($permohonan['status'] !== 'diproses') {
                return $this->response->setJSON(['error' => 'Permohonan tidak dapat diedit karena sudah diproses']);
            }

            $kategoriasnaf = $this->request->getPost('kategoriasnaf');
            $jenisbantuan = $this->request->getPost('jenisbantuan');
            $tglpengajuan = $this->request->getPost('tglpengajuan');
            $alasan = $this->request->getPost('alasan');
            $dokumen = $this->request->getFile('dokumen');
            
            // Validasi kategori asnaf berdasarkan data dari database
            $syarats = $this->syaratModel->findAll();
            $validKategori = array_column($syarats, 'kategori_asnaf');
            $kategoriList = implode(',', $validKategori);
            
            $rules = [
                'kategoriasnaf' => [
                    'label' => 'Kategori Asnaf',
                    'rules' => 'required|in_list[' . $kategoriList . ']',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                        'in_list' => '{field} tidak valid'
                    ]
                ],
                'jenisbantuan' => [
                    'label' => 'Jenis Bantuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tglpengajuan' => [
                    'label' => 'Tanggal Pengajuan',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_date' => '{field} harus berupa tanggal yang valid'
                    ]
                ],
                'alasan' => [
                    'label' => 'Alasan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'dokumen' => [
                    'label' => 'Dokumen',
                    'rules' => 'mime_in[dokumen,application/pdf]|max_size[dokumen,5120]',
                    'errors' => [
                        'mime_in' => 'File harus berformat PDF',
                        'max_size' => 'Ukuran file maksimal adalah 5MB'
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }

                $json = [
                    'error' => $errors
                ];
            } else {
                if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
                    $newName = 'dokumen-' . date('Ymd') . '-' . $idpermohonan . '.' . $dokumen->getClientExtension();
                    $dokumen->move('uploads/permohonan/', $newName);

                    // Hapus dokumen lama jika ada
                    if (!empty($permohonan['dokumen']) && file_exists('uploads/permohonan/' . $permohonan['dokumen'])) {
                        unlink('uploads/permohonan/' . $permohonan['dokumen']);
                    }

                    $dataUpdate = [
                        'kategoriasnaf' => $kategoriasnaf,
                        'jenisbantuan' => $jenisbantuan,
                        'tglpengajuan' => $tglpengajuan,
                        'alasan' => $alasan,
                        'dokumen' => $newName,
                    ];
                } else {
                    $dataUpdate = [
                        'kategoriasnaf' => $kategoriasnaf,
                        'jenisbantuan' => $jenisbantuan,
                        'tglpengajuan' => $tglpengajuan,
                        'alasan' => $alasan,
                    ];
                    
                    // Jika update tanpa mengubah dokumen, tetap gunakan dokumen yang ada (jika ada)
                    if (isset($permohonan['dokumen'])) {
                        $dataUpdate['dokumen'] = $permohonan['dokumen'];
                    }
                }
                
                $this->permohonanModel->update($idpermohonan, $dataUpdate);
                
                $json = [
                    'sukses' => 'Permohonan berhasil diupdate'
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function deletePermohonan()
    {
        if ($this->request->isAJAX()) {
            // Pastikan user sudah login dan role mustahik
            if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
                return $this->response->setJSON(['error' => 'Unauthorized']);
            }

            $userId = session()->get('user_id');
            $mustahikData = $this->mustahikModel->getByUserId($userId);

            if (!$mustahikData) {
                return $this->response->setJSON(['error' => 'Profile mustahik tidak ditemukan']);
            }

            $idpermohonan = $this->request->getPost('idpermohonan');
            $permohonan = $this->permohonanModel->find($idpermohonan);

            if (!$permohonan || $permohonan['id_mustahik'] != $mustahikData['id_mustahik']) {
                return $this->response->setJSON(['error' => 'Permohonan tidak ditemukan atau akses ditolak']);
            }

            // Hanya bisa hapus jika status masih diproses
            if ($permohonan['status'] !== 'diproses') {
                return $this->response->setJSON(['error' => 'Permohonan tidak dapat dihapus karena sudah diproses']);
            }
            
            // Hapus file dokumen jika ada
            if (!empty($permohonan['dokumen'])) {
                $filePath = 'uploads/permohonan/' . $permohonan['dokumen'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            $this->permohonanModel->where('idpermohonan', $idpermohonan)->delete();

            $json = [
                'sukses' => 'Permohonan berhasil dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function detailPermohonan($idpermohonan)
    {
        // Pastikan user sudah login dan role mustahik
        if (!session()->get('logged_in') || session()->get('role') !== 'mustahik') {
            return redirect()->to(site_url('auth'));
        }

        $userId = session()->get('user_id');
        $mustahikData = $this->mustahikModel->getByUserId($userId);

        if (!$mustahikData) {
            return redirect()->to(site_url('profile/complete/mustahik'));
        }

        $db = db_connect();
        $permohonan = $db->table('permohonan p')
            ->select('p.*, m.nama as nama_mustahik, m.alamat, m.nohp')
            ->join('mustahik m', 'm.id_mustahik = p.id_mustahik', 'left')
            ->where('p.idpermohonan', $idpermohonan)
            ->where('p.id_mustahik', $mustahikData['id_mustahik']) // Pastikan hanya bisa lihat permohonan sendiri
            ->get()
            ->getRowArray();

        if (!$permohonan) {
            return redirect()->to(site_url('dashboard/mustahik/permohonan'))->with('error', 'Data Permohonan tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Permohonan',
            'permohonan' => $permohonan,
            'mustahik' => $mustahikData,
            'user' => session()->get()
        ];

        return view('dashboard/mustahik/detail_permohonan', $data);
    }

    public function getSyaratByKategori()
    {
        if ($this->request->isAJAX()) {
            $kategori = $this->request->getPost('kategori');
            
            $syarat = $this->syaratModel->where('kategori_asnaf', $kategori)->first();
            
            if ($syarat) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $syarat
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Syarat tidak ditemukan'
                ]);
            }
        }
    }
}
