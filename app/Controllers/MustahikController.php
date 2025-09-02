<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Mustahik as ModelMustahik;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class MustahikController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Mustahik'
        ];
        return view('mustahik/datamustahik', $title);
    }

    public function viewMustahik()
    {
        $db = db_connect();
        $query = $db->table('mustahik')
                    ->select('id_mustahik, nama, nohp, jenkel, iduser');

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-id_mustahik="' . $row->id_mustahik . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-id_mustahik="' . $row->id_mustahik . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id_mustahik="' . $row->id_mustahik . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            // Tambahkan tombol kunci untuk membuat user jika iduser NULL
            $button4 = '';
            if ($row->iduser === null) {
                $button4 = '<button type="button" class="btn btn-warning btn-sm btn-create-user" data-id_mustahik="' . $row->id_mustahik . '" data-toggle="modal" data-target="#createUserModal" style="margin-left: 5px;"><i class="fas fa-key"></i></button>';
            }
            
            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . $button4 . '</div>';
            return $buttonsGroup;
            }, 'last')
            ->edit('jenkel', function ($row) {
                return $row->jenkel == 'L' ? 'Laki-laki' : 'Perempuan';
            })
            ->addNumbering()
            ->hide('iduser')
            ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('MS', LPAD(IFNULL(MAX(SUBSTRING(id_mustahik, 3)) + 1, 1), 4, '0')) AS next_number FROM mustahik");
        $row = $query->getRow();
        $next_number = $row->next_number;
        $data = [
            'next_number' => $next_number,
        ];
        return view('mustahik/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $id_mustahik = $this->request->getPost('id_mustahik');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');
            $jenkel = $this->request->getPost('jenkel');
            $tgllahir = $this->request->getPost('tgllahir');
            $foto = $this->request->getFile('cover');

            $rules = [
                'nama' => [
                    'label' => 'Nama Mustahik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nohp' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jenkel' => [
                    'label' => 'Jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgllahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
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
                $modelMustahik = new ModelMustahik();
                $fotoName = null;
                
                if ($foto->isValid() && !$foto->hasMoved()) {
                    // User uploaded a photo
                    $newName = 'foto-' . date('Ymd') . '-' . $id_mustahik . '.' . $foto->getClientExtension();
                    $foto->move('assets/img/mustahik/', $newName);
                    $fotoName = $newName;
                } else {
                    // No photo uploaded, use default image
                    $defaultSource = 'assets/img/defaultuser.png';
                    $defaultDestination = 'assets/img/mustahik/foto-' . date('Ymd') . '-' . $id_mustahik . '.png';
                    
                    if (file_exists($defaultSource)) {
                        copy($defaultSource, $defaultDestination);
                        $fotoName = 'foto-' . date('Ymd') . '-' . $id_mustahik . '.png';
                    }
                }

                $modelMustahik->insert([
                    'id_mustahik' => $id_mustahik,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'nohp' => $nohp,
                    'jenkel' => $jenkel,
                    'tgllahir' => $tgllahir,
                    'foto' => $fotoName,
                ]);

                $json = [
                    'sukses' => 'Berhasil Simpan Data'
                ];
            }
            echo json_encode($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id_mustahik = $this->request->getPost('id_mustahik');

            $model = new ModelMustahik();
            $model->where('id_mustahik', $id_mustahik)->delete();

            $json = [
                'sukses' => 'Data Mustahik Berhasil Dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($id_mustahik)
    {
        $model = new ModelMustahik();
        $mustahik = $model->find($id_mustahik);

        if (!$mustahik) {
            return redirect()->to('/mustahik')->with('error', 'Data Mustahik tidak ditemukan');
        }
        
        $user = null;
        if (!empty($mustahik['iduser'])) {
            $userModel = new UserModel();
            $user = $userModel->find($mustahik['iduser']);
        }
        
        $data = [
            'mustahik' => $mustahik,
            'user' => $user
        ];

        return view('mustahik/formedit', $data);
    }

    public function updatedata($id_mustahik)
    {
        if ($this->request->isAJAX()) {
            $id_mustahik = $this->request->getPost('id_mustahik');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');
            $jenkel = $this->request->getPost('jenkel');
            $tgllahir = $this->request->getPost('tgllahir');
            $foto = $this->request->getFile('cover');
            $password = $this->request->getPost('password');
            
            $rules = [
                'nama' => [
                    'label' => 'Nama Mustahik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nohp' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jenkel' => [
                    'label' => 'Jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgllahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'cover' => [
                    'label' => 'Foto',
                    'rules' => 'mime_in[cover,image/jpg,image/jpeg,image/gif,image/png]|max_size[cover,4096]',
                    'errors' => [
                        'mime_in' => 'File harus berformat jpg, jpeg, atau png',
                        'max_size' => 'Ukuran file maksimal adalah 4MB'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'permit_empty|min_length[6]',
                    'errors' => [
                        'min_length' => 'Password minimal 6 karakter'
                    ]
                ]
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
                $model = new ModelMustahik();
                $dataMustahik = $model->where('id_mustahik', $id_mustahik)->first();
                
                if ($foto->isValid() && !$foto->hasMoved()) {
                    $random = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
                    $newName = 'foto-' . date('Ymd') . '-' . $id_mustahik . '.' . $random . '.' . $foto->getClientExtension();
                    $foto->move('assets/img/mustahik/', $newName);

                    // Hapus foto lama jika ada
                    if (!empty($datamustahik['foto']) && file_exists('assets/img/mustahik/' . $dataMustahik['foto'])) {
                        unlink('assets/img/mustahik/' . $dataMustahik['foto']);
                    }

                    $dataUpdate = [
                        'nama' => $nama,
                        'alamat' => $alamat,
                        'nohp' => $nohp,
                        'jenkel' => $jenkel,
                        'tgllahir' => $tgllahir,
                        'foto' => $newName,
                    ];
                } else {
                    $dataUpdate = [
                        'nama' => $nama,
                        'alamat' => $alamat,
                        'nohp' => $nohp,
                        'jenkel' => $jenkel,
                        'tgllahir' => $tgllahir,
                    ];
                    
                    // Jika update tanpa mengubah foto, tetap gunakan foto yang ada (jika ada)
                    if (isset($dataMustahik['foto'])) {
                        $dataUpdate['foto'] = $dataMustahik['foto'];
                    }
                }
                
                $model->update($id_mustahik, $dataUpdate);
                
                // Update password jika ada
                if (!empty($password) && !empty($dataMustahik['iduser'])) {
                    $userModel = new \App\Models\UserModel();
                    $userModel->save([
                        'id' => $dataMustahik['iduser'],
                        'password' => $password
                    ]);
                }
                
                $json = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            return $this->response->setJSON($json);
        }
    }
    public function detail($id_mustahik)
    {
        $db = db_connect();
        $mustahik = $db->table('mustahik')->select('*')
        ->where('id_mustahik', $id_mustahik)->get()->getRowArray();

        if (!$mustahik) {
            return redirect()->back()->with('error', 'Data Mustahik tidak ditemukan');
        }

        $data = [
            'mustahik' => $mustahik
        ];

        return view('mustahik/detail', $data);
}

    public function createUser($id_mustahik = null)
    {
        // Pastikan id_mustahik tidak null
        if ($id_mustahik === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID Mustahik tidak ditemukan'
            ]);
        }
        
        $mustahikModel = new ModelMustahik();
        $userModel = new \App\Models\UserModel();
        $mustahik = $mustahikModel->find($id_mustahik);
        
        if (!$mustahik) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Mustahik tidak ditemukan'
            ]);
        }
        
        // Validasi input
        $rules = [
            'username' => [
                'rules' => 'required|min_length[5]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'min_length' => 'Username minimal 5 karakter',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah digunakan'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Buat user baru
        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => 'mustahik',
            'status' => 'active'
        ];
        
        $userModel->insert($userData);
        $userId = $userModel->getInsertID();
        
        // Update data mustahik dengan ID user baru
        $mustahikModel->update($id_mustahik, ['iduser' => $userId]);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Akun user untuk mustahik berhasil dibuat'
        ]);
    }
    
    public function updatePassword($id_mustahik = null)
    {
        // Pastikan id_mustahik tidak null
        if ($id_mustahik === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID Mustahik tidak ditemukan'
            ]);
        }
        
        $mustahikModel = new ModelMustahik();
        $userModel = new \App\Models\UserModel();
        $mustahik = $mustahikModel->find($id_mustahik);
        
        if (!$mustahik) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data mustahik tidak ditemukan'
            ]);
        }
        
        if (!$mustahik['iduser']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'mustahik belum memiliki akun user'
            ]);
        }
        
        // Validasi input
        $rules = [
            'password' => [
                'rules' => 'permit_empty|min_length[6]',
                'errors' => [
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $password = $this->request->getPost('password');
        
        // Jika password kosong, abaikan update password
        if (empty($password)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Tidak ada perubahan pada password'
            ]);
        }
        
        // Update password user
        $userData = [
            'id' => $mustahik['iduser'],
            'password' => $password
        ];
        
        $userModel->save($userData);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Password berhasil diperbarui'
        ]);
    }
}
