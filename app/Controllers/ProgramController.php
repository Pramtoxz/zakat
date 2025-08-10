<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Program as ModelProgram;
use App\Models\Kategori as ModelKategori;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class ProgramController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Program'
        ];
        return view('program/dataprogram', $title);
    }

    public function view()
    {
        $db = db_connect();
        $query = $db->table('program p')
            ->select('p.idprogram, p.namaprogram, k.namakategori, p.tglmulai, p.tglselesai, p.status')
            ->join('kategori k', 'k.idkategori = p.idkategori', 'left');

        return DataTable::of($query)
            // Format tanggal mulai
            ->edit('tglmulai', function ($row) {
                if ($row->tglmulai) {
                    return date('d-m-Y', strtotime($row->tglmulai));
                }
                return '-';
            })
            // Format tanggal selesai
            ->edit('tglselesai', function ($row) {
                if ($row->tglselesai) {
                    return date('d-m-Y', strtotime($row->tglselesai));
                }
                return '-';
            })
            // Badge status
            ->edit('status', function ($row) {
                if ($row->status == 'biasa') {
                    return '<span class="badge badge-success">Biasa</span>';
                } else {
                    return '<span class="badge badge-danger">Urgent</span>';
                }
            })
            // Tombol aksi
            ->add('action', function ($row) {
                $button1 = '<button type="button" class="btn btn-info btn-sm btn-detail" data-idprogram="' . $row->idprogram . '" style="margin-right: 5px;"><i class="fas fa-eye"></i></button>';
                $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idprogram="' . $row->idprogram . '" style="margin-right: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                $button3 = '<button type="button" class="btn btn-warning btn-sm btn-status" data-idprogram="' . $row->idprogram . '" style="margin-right: 5px;"><i class="fas fa-sync"></i></button>';
                $button4 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idprogram="' . $row->idprogram . '"><i class="fas fa-trash"></i></button>';
                $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . $button4 . '</div>';
                return $buttonsGroup;
            }, 'last')
            ->addNumbering()
            ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('PR', LPAD(IFNULL(MAX(SUBSTRING(idprogram, 3)) + 1, 1), 4, '0')) AS next_number FROM program");
        $row = $query->getRow();
        $next_number = $row->next_number;
        
        // Ambil data kategori untuk dropdown
        $modelKategori = new ModelKategori();
        $kategoris = $modelKategori->findAll();
        
        $data = [
            'next_number' => $next_number,
            'kategoris' => $kategoris
        ];
        return view('program/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idprogram = $this->request->getPost('idprogram');
            $namaprogram = $this->request->getPost('namaprogram');
            $idkategori = $this->request->getPost('idkategori');
            $deskripsi = $this->request->getPost('deskripsi');
            $tglmulai = $this->request->getPost('tglmulai');
            $tglselesai = $this->request->getPost('tglselesai');
            $foto = $this->request->getFile('foto');

            $rules = [
                'namaprogram' => [
                    'label' => 'Nama Program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'idkategori' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'foto' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[foto]|mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]|max_size[foto,4096]',
                    'errors' => [
                        'uploaded' => 'Foto harus diunggah',
                        'mime_in' => 'File harus berformat jpg, jpeg, gif, atau png',
                        'max_size' => 'Ukuran file maksimal adalah 4MB'
                    ]
                ],
                'tglmulai' => [
                    'label' => 'Tanggal Mulai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tglselesai' => [
                    'label' => 'Tanggal Selesai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
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
                if ($foto->isValid() && !$foto->hasMoved()) {
                    $newName = 'program-' . date('Ymd') . '-' . $idprogram . '.' . $foto->getClientExtension();
                    $foto->move('assets/img/program/', $newName);

                    $modelProgram = new ModelProgram();
                    $modelProgram->insert([
                        'idprogram' => $idprogram,
                        'namaprogram' => $namaprogram,
                        'idkategori' => $idkategori,
                        'deskripsi' => $deskripsi,
                        'foto' => $newName,
                        'tglmulai' => $tglmulai,
                        'tglselesai' => $tglselesai,
                        'status' => 'biasa'
                    ]);

                    $json = [
                        'sukses' => 'Data program berhasil disimpan'
                    ];
                } else {
                    $json = [
                        'error' => ['error_foto' => $foto->getErrorString() . '(' . $foto->getError() . ')']
                    ];
                }
            }
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idprogram = $this->request->getPost('idprogram');

            $model = new ModelProgram();
            $program = $model->find($idprogram);
            
            if ($program) {
                // Hapus foto jika ada
                if (!empty($program['foto']) && file_exists('assets/img/program/' . $program['foto'])) {
                    unlink('assets/img/program/' . $program['foto']);
                }
                
                $model->where('idprogram', $idprogram)->delete();
                
                $json = [
                    'sukses' => 'Data program berhasil dihapus'
                ];
            } else {
                $json = [
                    'error' => 'Data program tidak ditemukan'
                ];
            }
            
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idprogram)
    {
        $model = new ModelProgram();
        $program = $model->find($idprogram);

        if (!$program) {
            return redirect()->to('/program')->with('error', 'Data program tidak ditemukan');
        }
        
        // Ambil data kategori untuk dropdown
        $modelKategori = new ModelKategori();
        $kategoris = $modelKategori->findAll();
        
        $data = [
            'program' => $program,
            'kategoris' => $kategoris
        ];

        return view('program/formedit', $data);
    }

    public function updatedata($idprogram)
    {
        if ($this->request->isAJAX()) {
            $idprogram = $this->request->getPost('idprogram');
            $namaprogram = $this->request->getPost('namaprogram');
            $idkategori = $this->request->getPost('idkategori');
            $deskripsi = $this->request->getPost('deskripsi');
            $tglmulai = $this->request->getPost('tglmulai');
            $tglselesai = $this->request->getPost('tglselesai');
            $foto = $this->request->getFile('foto');
            
            $rules = [
                'namaprogram' => [
                    'label' => 'Nama Program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'idkategori' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'foto' => [
                    'label' => 'Foto',
                    'rules' => 'permit_empty|mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]|max_size[foto,4096]',
                    'errors' => [
                        'mime_in' => 'File harus berformat jpg, jpeg, gif, atau png',
                        'max_size' => 'Ukuran file maksimal adalah 4MB'
                    ]
                ],
                'tglmulai' => [
                    'label' => 'Tanggal Mulai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tglselesai' => [
                    'label' => 'Tanggal Selesai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
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
                $model = new ModelProgram();
                $dataProgram = $model->where('idprogram', $idprogram)->first();
                
                $dataUpdate = [
                    'namaprogram' => $namaprogram,
                    'idkategori' => $idkategori,
                    'deskripsi' => $deskripsi,
                    'tglmulai' => $tglmulai,
                    'tglselesai' => $tglselesai
                ];
                
                if ($foto->isValid() && !$foto->hasMoved()) {
                    $newName = 'program-' . date('Ymd') . '-' . $idprogram . '.' . $foto->getClientExtension();
                    $foto->move('assets/img/program/', $newName);

                    // Hapus foto lama jika ada
                    if (!empty($dataProgram['foto']) && file_exists('assets/img/program/' . $dataProgram['foto'])) {
                        unlink('assets/img/program/' . $dataProgram['foto']);
                    }

                    $dataUpdate['foto'] = $newName;
                }
                
                $model->update($idprogram, $dataUpdate);
                
                $json = [
                    'sukses' => 'Data program berhasil diupdate'
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function detail($idprogram)
    {
        $db = db_connect();
        $program = $db->table('program p')
                     ->select('p.*, k.namakategori')
                     ->join('kategori k', 'k.idkategori = p.idkategori', 'left')
                     ->where('p.idprogram', $idprogram)
                     ->get()
                     ->getRowArray();

        if (!$program) {
            return redirect()->back()->with('error', 'Data program tidak ditemukan');
        }

        $data = [
            'program' => $program
        ];

        return view('program/detail', $data);
    }

 

    public function status($idprogram)
    {
        $model = new ModelProgram();
        $program = $model->find($idprogram);

        if (!$program) {
            return redirect()->back()->with('error', 'Data program tidak ditemukan');
        }

        // Toggle status: jika 'biasa' jadi 'urgent', jika 'urgent' jadi 'biasa'
        $newStatus = ($program['status'] == 'biasa') ? 'urgent' : 'biasa';

        $model->update($idprogram, ['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status program berhasil diubah menjadi ' . ucfirst($newStatus));
    }
}