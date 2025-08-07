<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Donatur as ModelDonatur;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class DonaturController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Donatur'
        ];
        return view('donatur/datadonatur', $title);
    }

    public function viewDonatur()
    {
        $db = db_connect();
        $query = $db->table('donatur')
                    ->select('id_donatur, nama, nohp, jenkel, iduser');

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-id_donatur="' . $row->id_donatur . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-id_donatur="' . $row->id_donatur . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id_donatur="' . $row->id_donatur . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            // Tambahkan tombol kunci untuk membuat user jika iduser NULL
            $button4 = '';
            if ($row->iduser === null) {
                $button4 = '<button type="button" class="btn btn-warning btn-sm btn-create-user" data-id_donatur="' . $row->id_donatur . '" data-toggle="modal" data-target="#createUserModal" style="margin-left: 5px;"><i class="fas fa-key"></i></button>';
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
        $query = $db->query("SELECT CONCAT('DN', LPAD(IFNULL(MAX(SUBSTRING(id_donatur, 3)) + 1, 1), 4, '0')) AS next_number FROM donatur");
        $row = $query->getRow();
        $next_number = $row->next_number;
        $data = [
            'next_number' => $next_number,
        ];
        return view('donatur/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $id_donatur = $this->request->getPost('id_donatur');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');
            $jenkel = $this->request->getPost('jenkel');
            $tgllahir = $this->request->getPost('tgllahir');
            $foto = $this->request->getFile('cover');

            $rules = [
                'nama' => [
                    'label' => 'Nama Donatur',
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
                if ($foto->isValid() && !$foto->hasMoved()) {
                    $newName = 'foto-' . date('Ymd') . '-' . $id_donatur . '.' . $foto->getClientExtension();
                    $foto->move('assets/img/donatur/', $newName);

                    $modelDonatur = new ModelDonatur();
                    $modelDonatur->insert([
                        'id_donatur' => $id_donatur,
                        'nama' => $nama,
                        'alamat' => $alamat,
                        'nohp' => $nohp,
                        'jenkel' => $jenkel,
                        'tgllahir' => $tgllahir,
                        'foto' => $newName,
                    ]);

                    $json = [
                        'sukses' => 'Berhasil Simpan Data'
                    ];
                } else {
                    $json = [
                        'error' => ['foto' => $foto->getErrorString() . '(' . $foto->getError() . ')']
                    ];
                }
            }
            echo json_encode($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id_donatur = $this->request->getPost('id_donatur');

            $model = new ModelDonatur();
            $model->where('id_donatur', $id_donatur)->delete();

            $json = [
                'sukses' => 'Data Donatur Berhasil Dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($id_donatur)
    {
        $model = new ModelDonatur();
        $donatur = $model->find($id_donatur);

        if (!$donatur) {
            return redirect()->to('/donatur')->with('error', 'Data donatur tidak ditemukan');
        }
        
        $user = null;
        if (!empty($donatur['iduser'])) {
            $userModel = new UserModel();
            $user = $userModel->find($donatur['iduser']);
        }
        
        $data = [
            'donatur' => $donatur,
            'user' => $user
        ];

        return view('donatur/formedit', $data);
    }

    public function updatedata($id_donatur)
    {
        if ($this->request->isAJAX()) {
            $id_donatur = $this->request->getPost('id_donatur');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');
            $jenkel = $this->request->getPost('jenkel');
            $tgllahir = $this->request->getPost('tgllahir');
            $foto = $this->request->getFile('cover');
            $password = $this->request->getPost('password');
            
            $rules = [
                'nama' => [
                    'label' => 'Nama donatur',
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
                $model = new ModelDonatur();
                $dataDonatur = $model->where('id_donatur', $id_donatur)->first();
                
                if ($foto->isValid() && !$foto->hasMoved()) {
                    $random = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
                    $newName = 'foto-' . date('Ymd') . '-' . $id_donatur . '.' . $random . '.' . $foto->getClientExtension();
                    $foto->move('assets/img/donatur/', $newName);

                    // Hapus foto lama jika ada
                    if (!empty($datadonatur['foto']) && file_exists('assets/img/donatur/' . $dataDonatur['foto'])) {
                        unlink('assets/img/donatur/' . $dataDonatur['foto']);
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
                    if (isset($dataDonatur['foto'])) {
                        $dataUpdate['foto'] = $dataDonatur['foto'];
                    }
                }
                
                $model->update($id_donatur, $dataUpdate);
                
                // Update password jika ada
                if (!empty($password) && !empty($dataDonatur['iduser'])) {
                    $userModel = new \App\Models\UserModel();
                    $userModel->save([
                        'id' => $dataDonatur['iduser'],
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
    public function detail($id_donatur)
    {
        $db = db_connect();
        $donatur = $db->table('donatur')->select('*')
        ->where('id_donatur', $id_donatur)->get()->getRowArray();

        if (!$donatur) {
            return redirect()->back()->with('error', 'Data Donatur tidak ditemukan');
        }

        $data = [
            'donatur' => $donatur
        ];

        return view('donatur/detail', $data);
}

    public function createUser($id_donatur = null)
    {
        // Pastikan id_donatur tidak null
        if ($id_donatur === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID Donatur tidak ditemukan'
            ]);
        }
        
        $donaturModel = new ModelDonatur();
        $userModel = new \App\Models\UserModel();
        $donatur = $donaturModel->find($id_donatur);
        
        if (!$donatur) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Donatur tidak ditemukan'
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
            'role' => 'donatur',
            'status' => 'active'
        ];
        
        $userModel->insert($userData);
        $userId = $userModel->getInsertID();
        
        // Update data donatur dengan ID user baru
        $donaturModel->update($id_donatur, ['iduser' => $userId]);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Akun user untuk donatur berhasil dibuat'
        ]);
    }
    
    public function updatePassword($id_donatur = null)
    {
        // Pastikan id_donatur tidak null
        if ($id_donatur === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID Donatur tidak ditemukan'
            ]);
        }
        
        $donaturModel = new ModelDonatur();
        $userModel = new \App\Models\UserModel();
        $donatur = $donaturModel->find($id_donatur);
        
        if (!$donatur) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data donatur tidak ditemukan'
            ]);
        }
        
        if (!$donatur['iduser']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'donatur belum memiliki akun user'
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
            'id' => $donatur['iduser'],
            'password' => $password
        ];
        
        $userModel->save($userData);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Password berhasil diperbarui'
        ]);
    }
}
