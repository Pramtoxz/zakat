<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Program as ModelProgram;
use App\Models\Kategori as ModelKategori;
use App\Models\Mustahik as ModelMustahik;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class PenyaluranController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Penyaluran Dana'
        ];
        return view('penyaluran/datapenyaluran', $title);
    }

    public function view()
    {
        $db = db_connect();
        $query = $db->table('penyaluran_dana')
            ->select('penyaluran_dana.id, penyaluran_dana.tglpenyaluran, mustahik.nama as nama_mustahik, penyaluran_dana.jenisdana, penyaluran_dana.nominal')
            ->join('mustahik', 'mustahik.id_mustahik = penyaluran_dana.id_mustahik', 'left');

        return DataTable::of($query)
            // Format tanggal penyaluran
            ->edit('tglpenyaluran', function ($row) {
                if ($row->tglpenyaluran) {
                    return date('d-m-Y', strtotime($row->tglpenyaluran));
                }
                return '-';
            })
            // Format nominal ke format Rupiah
            ->edit('nominal', function ($row) {
                return 'Rp ' . number_format($row->nominal, 0, ',', '.');
            })
            // Badge untuk jenis dana
            ->edit('jenisdana', function ($row) {
                if ($row->jenisdana == 'zakat') {
                    return '<span class="badge badge-success">Zakat</span>';
                } elseif ($row->jenisdana == 'donasi') {
                    return '<span class="badge badge-primary">Donasi</span>';
                } else {
                    return '<span class="badge badge-secondary">' . ucfirst($row->jenisdana) . '</span>';
                }
            })
            // Tombol aksi
            ->add('action', function ($row) {
                $button1 = '<button type="button" class="btn btn-info btn-sm btn-detail" data-id="' . $row->id . '" style="margin-right: 5px;"><i class="fas fa-eye"></i></button>';
                $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-id="' . $row->id . '" style="margin-right: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '"><i class="fas fa-trash"></i></button>';
                $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
                return $buttonsGroup;
            }, 'last')
            ->addNumbering()
            ->hide('id')
            ->toJson();
    }

    public function formtambah()
    {
        // Ambil data mustahik untuk dropdown
        $modelMustahik = new ModelMustahik();
        $mustahiks = $modelMustahik->findAll();
        
        // Ambil data program untuk donasi berdasarkan idkategori != 2 (selain zakat)
        $db = db_connect();
        $programs = $db->table('program')
                    ->select('idprogram, namaprogram, program.idkategori')
                    ->join('kategori', 'kategori.idkategori = program.idkategori', 'left')
                    ->where('program.idkategori !=', 2)
                    ->get()
                    ->getResultArray();
        
        $data = [
            'mustahiks' => $mustahiks,
            'programs' => $programs
        ];
        return view('penyaluran/formtambah', $data);
    }

    public function getPermohonan()
    {
        return view('penyaluran/getPermohonan');
    }

    public function getMustahik()
    {
        return view('penyaluran/getMustahik');
    }

    public function viewGetPermohonan()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $query = $db->table('permohonan p')
                ->select('p.idpermohonan, m.nama as nama_mustahik, p.kategoriasnaf, p.jenisbantuan, p.tglpengajuan, p.status')
                ->join('mustahik m', 'm.id_mustahik = p.id_mustahik', 'left')
                ->where('p.status', 'diterima'); // Hanya permohonan yang sudah diterima
                
            return DataTable::of($query)
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-primary btn-sm btn-pilih-permohonan" 
                            data-id="' . $row->idpermohonan . '" 
                            data-nama="' . $row->nama_mustahik . ' - ' . $row->jenisbantuan . '">
                            <i class="fas fa-check mr-1"></i>Pilih
                            </button>';
                }, 'last')
                ->edit('tglpengajuan', function ($row) {
                    return $row->tglpengajuan ? date('d-m-Y', strtotime($row->tglpengajuan)) : '-';
                })
                ->edit('status', function ($row) {
                    return '<span class="badge badge-success">Diterima</span>';
                })
                ->edit('kategoriasnaf', function ($row) {
                    return ucfirst($row->kategoriasnaf);
                })
                ->addNumbering()
                ->toJson();
        }
    }

    public function viewGetMustahik()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $query = $db->table('mustahik')
                        ->select('id_mustahik, nama, alamat, nohp, jenkel');

            return DataTable::of($query)
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-success btn-sm btn-pilih-mustahik" 
                            data-id="' . $row->id_mustahik . '" 
                            data-nama="' . $row->nama . '">
                            <i class="fas fa-check mr-1"></i>Pilih
                            </button>';
                }, 'last')
                ->edit('alamat', function ($row) {
                    return strlen($row->alamat) > 50 ? substr($row->alamat, 0, 50) . '...' : $row->alamat;
                })
                ->edit('jenkel', function ($row) {
                    return $row->jenkel == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->addNumbering()
                ->toJson();
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $jenisdana = $this->request->getPost('jenisdana');
            $idpermohonan = $this->request->getPost('idpermohonan');
            $id_mustahik = $this->request->getPost('id_mustahik');
            $nominal = $this->request->getPost('nominal');
            $tglpenyaluran = $this->request->getPost('tglpenyaluran');
            $deskripsi = $this->request->getPost('deskripsi');
            $foto = $this->request->getFile('foto');

            // Base validation rules
            $rules = [
                'jenisdana' => [
                    'label' => 'Jenis Dana',
                    'rules' => 'required|in_list[zakat,donasi]',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                        'in_list' => '{field} tidak valid'
                    ]
                ],
                'nominal' => [
                    'label' => 'Nominal',
                    'rules' => 'required|numeric|greater_than[0]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                        'greater_than' => '{field} harus lebih dari 0'
                    ]
                ],
                'tglpenyaluran' => [
                    'label' => 'Tanggal Penyaluran',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_date' => '{field} harus berupa tanggal yang valid'
                    ]
                ]
            ];

            // Conditional validation based on jenisdana
            if ($jenisdana === 'zakat') {
                $rules['idpermohonan'] = [
                    'label' => 'Permohonan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ];
            } elseif ($jenisdana === 'donasi') {
                $rules['id_mustahik'] = [
                    'label' => 'Mustahik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ];
                $rules['idprogram'] = [
                    'label' => 'Program Donasi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ];
            }

            // Optional foto validation
            if ($foto && $foto->isValid()) {
                $rules['foto'] = [
                    'label' => 'Foto',
                    'rules' => 'mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]|max_size[foto,2048]',
                    'errors' => [
                        'mime_in' => 'File harus berformat jpg, jpeg, gif, atau png',
                        'max_size' => 'Ukuran file maksimal adalah 2MB'
                    ]
                ];
            }

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }

                $json = [
                    'error' => $errors
                ];
            } else {
                // Prepare data untuk insert
                $dataInsert = [
                    'jenisdana' => $jenisdana,
                    'nominal' => $nominal,
                    'tglpenyaluran' => $tglpenyaluran,
                    'deskripsi' => $deskripsi,
                ];

                // Logic berdasarkan jenis dana
                if ($jenisdana === 'zakat') {
                    // Jika zakat: idprogram = null, ada idpermohonan
                    $dataInsert['idpermohonan'] = $idpermohonan;
                    $dataInsert['idprogram'] = null;
                    // Ambil id_mustahik dari permohonan
                    $db = db_connect();
                    $permohonan = $db->table('permohonan')->where('idpermohonan', $idpermohonan)->get()->getRowArray();
                    if ($permohonan) {
                        $dataInsert['id_mustahik'] = $permohonan['id_mustahik'];
                    }
                } elseif ($jenisdana === 'donasi') {
                    // Jika donasi: idpermohonan = null, ada idprogram dan id_mustahik
                    $dataInsert['id_mustahik'] = $id_mustahik;
                    $dataInsert['idpermohonan'] = null;
                    $dataInsert['idprogram'] = $this->request->getPost('idprogram');
                }

                // Handle foto upload
                $fotoName = null;
                if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                    $fotoName = 'penyaluran-' . date('Ymd') . '-' . time() . '.' . $foto->getClientExtension();
                    $foto->move('uploads/penyaluran/', $fotoName);
                    $dataInsert['foto'] = $fotoName;
                }

                // Import model dan simpan
                $modelPenyaluran = new \App\Models\Penyaluran();
                $modelPenyaluran->insert($dataInsert);

                // Jika jenis dana adalah zakat, update status permohonan menjadi 'selesai'
                if ($jenisdana === 'zakat' && !empty($idpermohonan)) {
                    $db = db_connect();
                    $db->table('permohonan')
                       ->where('idpermohonan', $idpermohonan)
                       ->update(['status' => 'selesai']);
                }

                $json = [
                    'sukses' => 'Data penyaluran dana berhasil disimpan' . ($jenisdana === 'zakat' ? ' dan status permohonan diupdate menjadi selesai' : '')
                ];
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

    public function formedit($id)
    {
        $db = db_connect();
        $penyaluran = $db->table('penyaluran_dana')
                        ->select('penyaluran_dana.*, mustahik.nama as nama_mustahik, permohonan.kategoriasnaf, program.namaprogram')
                        ->join('mustahik', 'mustahik.id_mustahik = penyaluran_dana.id_mustahik', 'left')
                        ->join('permohonan', 'permohonan.idpermohonan = penyaluran_dana.idpermohonan', 'left')
                        ->join('program', 'program.idprogram = penyaluran_dana.idprogram', 'left')
                        ->where('penyaluran_dana.id', $id)
                        ->get()
                        ->getRowArray();

        if (!$penyaluran) {
            return redirect()->to('/penyaluran')->with('error', 'Data penyaluran tidak ditemukan');
        }
        
        // Ambil data program untuk donasi berdasarkan idkategori != 2 (selain zakat)
        $programs = $db->table('program')
                    ->select('idprogram, namaprogram, program.idkategori')
                    ->join('kategori', 'kategori.idkategori = program.idkategori', 'left')
                    ->where('program.idkategori !=', 2)
                    ->get()
                    ->getResultArray();
        
        $data = [
            'penyaluran' => $penyaluran,
            'programs' => $programs
        ];

        return view('penyaluran/formedit', $data);
    }

    public function detail($id)
    {
        $db = db_connect();
        $penyaluran = $db->table('penyaluran_dana')
                        ->select('penyaluran_dana.*, mustahik.nama as nama_mustahik, mustahik.alamat as alamat_mustahik, 
                                 permohonan.kategoriasnaf, permohonan.jenisbantuan, program.namaprogram, kategori.namakategori')
                        ->join('mustahik', 'mustahik.id_mustahik = penyaluran_dana.id_mustahik', 'left')
                        ->join('permohonan', 'permohonan.idpermohonan = penyaluran_dana.idpermohonan', 'left')
                        ->join('program', 'program.idprogram = penyaluran_dana.idprogram', 'left')
                        ->join('kategori', 'kategori.idkategori = program.idkategori', 'left')
                        ->where('penyaluran_dana.id', $id)
                        ->get()
                        ->getRowArray();

        if (!$penyaluran) {
            return redirect()->to('/penyaluran')->with('error', 'Data penyaluran tidak ditemukan');
        }
        
        $data = [
            'penyaluran' => $penyaluran
        ];

        return view('penyaluran/detail', $data);
    }

    public function updatedata($id)
    {
        if ($this->request->isAJAX()) {
            $jenisdana = $this->request->getPost('jenisdana');
            $idpermohonan = $this->request->getPost('idpermohonan');
            $id_mustahik = $this->request->getPost('id_mustahik');
            $nominal = $this->request->getPost('nominal');
            $tglpenyaluran = $this->request->getPost('tglpenyaluran');
            $deskripsi = $this->request->getPost('deskripsi');
            $foto = $this->request->getFile('foto');
            
            // Ambil data penyaluran yang lama untuk perbandingan
            $db = db_connect();
            $penyaluranLama = $db->table('penyaluran_dana')->where('id', $id)->get()->getRowArray();
            
            if (!$penyaluranLama) {
                return $this->response->setJSON([
                    'error' => 'Data penyaluran tidak ditemukan'
                ]);
            }
            
            // Base validation rules (sama seperti save)
            $rules = [
                'jenisdana' => [
                    'label' => 'Jenis Dana',
                    'rules' => 'required|in_list[zakat,donasi]',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                        'in_list' => '{field} tidak valid'
                    ]
                ],
                'nominal' => [
                    'label' => 'Nominal',
                    'rules' => 'required|numeric|greater_than[0]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                        'greater_than' => '{field} harus lebih dari 0'
                    ]
                ],
                'tglpenyaluran' => [
                    'label' => 'Tanggal Penyaluran',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_date' => '{field} harus berupa tanggal yang valid'
                    ]
                ]
            ];

            // Conditional validation based on jenisdana
            if ($jenisdana === 'zakat') {
                $rules['idpermohonan'] = [
                    'label' => 'Permohonan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ];
            } elseif ($jenisdana === 'donasi') {
                $rules['id_mustahik'] = [
                    'label' => 'Mustahik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ];
                $rules['idprogram'] = [
                    'label' => 'Program Donasi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ];
            }

            // Optional foto validation
            if ($foto && $foto->isValid()) {
                $rules['foto'] = [
                    'label' => 'Foto',
                    'rules' => 'mime_in[foto,image/jpg,image/jpeg,image/gif,image/png]|max_size[foto,2048]',
                    'errors' => [
                        'mime_in' => 'File harus berformat jpg, jpeg, gif, atau png',
                        'max_size' => 'Ukuran file maksimal adalah 2MB'
                    ]
                ];
            }

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }

                $json = [
                    'error' => $errors
                ];
            } else {
                // Prepare data untuk update
                $dataUpdate = [
                    'jenisdana' => $jenisdana,
                    'nominal' => $nominal,
                    'tglpenyaluran' => $tglpenyaluran,
                    'deskripsi' => $deskripsi,
                ];

                // Logic berdasarkan jenis dana
                if ($jenisdana === 'zakat') {
                    $dataUpdate['idpermohonan'] = $idpermohonan;
                    $dataUpdate['idprogram'] = null;
                    // Ambil id_mustahik dari permohonan
                    $permohonan = $db->table('permohonan')->where('idpermohonan', $idpermohonan)->get()->getRowArray();
                    if ($permohonan) {
                        $dataUpdate['id_mustahik'] = $permohonan['id_mustahik'];
                    }
                } elseif ($jenisdana === 'donasi') {
                    $dataUpdate['id_mustahik'] = $id_mustahik;
                    $dataUpdate['idpermohonan'] = null;
                    $dataUpdate['idprogram'] = $this->request->getPost('idprogram');
                }

                // Handle foto upload
                if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                    $fotoName = 'penyaluran-' . date('Ymd') . '-' . time() . '.' . $foto->getClientExtension();
                    $foto->move('uploads/penyaluran/', $fotoName);
                    
                    // Hapus foto lama jika ada
                    if (!empty($penyaluranLama['foto']) && file_exists('uploads/penyaluran/' . $penyaluranLama['foto'])) {
                        unlink('uploads/penyaluran/' . $penyaluranLama['foto']);
                    }
                    
                    $dataUpdate['foto'] = $fotoName;
                }

                // Update data penyaluran
                $modelPenyaluran = new \App\Models\Penyaluran();
                $modelPenyaluran->update($id, $dataUpdate);

                // Update status permohonan berdasarkan perubahan jenis dana
                // 1. Jika dahulu bukan zakat, sekarang jadi zakat -> set status 'selesai'
                if ($penyaluranLama['jenisdana'] !== 'zakat' && $jenisdana === 'zakat' && !empty($idpermohonan)) {
                    $db->table('permohonan')
                       ->where('idpermohonan', $idpermohonan)
                       ->update(['status' => 'selesai']);
                }
                // 2. Jika dahulu zakat, sekarang bukan zakat -> kembalikan status 'diterima'
                elseif ($penyaluranLama['jenisdana'] === 'zakat' && $jenisdana !== 'zakat' && !empty($penyaluranLama['idpermohonan'])) {
                    $db->table('permohonan')
                       ->where('idpermohonan', $penyaluranLama['idpermohonan'])
                       ->update(['status' => 'diterima']);
                }
                // 3. Jika tetap zakat tapi ganti permohonan
                elseif ($penyaluranLama['jenisdana'] === 'zakat' && $jenisdana === 'zakat') {
                    if ($penyaluranLama['idpermohonan'] != $idpermohonan) {
                        // Reset permohonan lama ke 'diterima'
                        if (!empty($penyaluranLama['idpermohonan'])) {
                            $db->table('permohonan')
                               ->where('idpermohonan', $penyaluranLama['idpermohonan'])
                               ->update(['status' => 'diterima']);
                        }
                        // Set permohonan baru ke 'selesai'
                        if (!empty($idpermohonan)) {
                            $db->table('permohonan')
                               ->where('idpermohonan', $idpermohonan)
                               ->update(['status' => 'selesai']);
                        }
                    }
                }

                $statusMessage = '';
                if ($jenisdana === 'zakat') {
                    $statusMessage = ' dan status permohonan diupdate menjadi selesai';
                } elseif ($penyaluranLama['jenisdana'] === 'zakat' && $jenisdana !== 'zakat') {
                    $statusMessage = ' dan status permohonan dikembalikan ke diterima';
                }

                $json = [
                    'sukses' => 'Data penyaluran dana berhasil diupdate' . $statusMessage
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function updateStatus()
    {
        if ($this->request->isAJAX()) {
            $idprogram = $this->request->getPost('idprogram');
            $status = $this->request->getPost('status');

            $model = new ModelProgram();
            $program = $model->find($idprogram);

            if (!$program) {
                return $this->response->setJSON([
                    'error' => 'Data program tidak ditemukan'
                ]);
            }

            $model->update($idprogram, ['status' => $status]);

            return $this->response->setJSON([
                'sukses' => 'Status program berhasil diubah menjadi ' . $status
            ]);
        }
    }

    public function getPermohonanAjax()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $query = $db->table('permohonan p')
                        ->select('p.idpermohonan, m.nama as nama_mustahik, p.kategoriasnaf, p.jenisbantuan, p.tglpengajuan, p.status')
                        ->join('mustahik m', 'm.id_mustahik = p.id_mustahik', 'left')
                        ->where('p.status', 'diterima'); // Hanya permohonan yang sudah diterima

            return DataTable::of($query)
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-primary btn-sm btn-pilih-permohonan" 
                            data-id="' . $row->idpermohonan . '" 
                            data-nama="' . $row->nama_mustahik . ' - ' . $row->jenisbantuan . '">
                            <i class="fas fa-check mr-1"></i>Pilih
                            </button>';
                }, 'last')
                ->edit('tglpengajuan', function ($row) {
                    return $row->tglpengajuan ? date('d-m-Y', strtotime($row->tglpengajuan)) : '-';
                })
                ->edit('status', function ($row) {
                    return '<span class="badge badge-success">Diterima</span>';
                })
                ->edit('kategoriasnaf', function ($row) {
                    return ucfirst($row->kategoriasnaf);
                })
                ->addNumbering()
                ->toJson();
        }
    }

    public function getMustahikAjax()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $query = $db->table('mustahik')
                        ->select('id_mustahik, nama, alamat, nohp, jenkel');

            return DataTable::of($query)
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-success btn-sm btn-pilih-mustahik" 
                            data-id="' . $row->id_mustahik . '" 
                            data-nama="' . $row->nama . '">
                            <i class="fas fa-check mr-1"></i>Pilih
                            </button>';
                }, 'last')
                ->edit('alamat', function ($row) {
                    return strlen($row->alamat) > 50 ? substr($row->alamat, 0, 50) . '...' : $row->alamat;
                })
                ->edit('jenkel', function ($row) {
                    return $row->jenkel == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->addNumbering()
                ->toJson();
        }
    }
}