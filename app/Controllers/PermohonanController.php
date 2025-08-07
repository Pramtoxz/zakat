<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Permohonan as ModelPermohonan;
use App\Models\Mustahik as ModelMustahik;
use App\Models\Syarat as ModelSyarat;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class PermohonanController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Permohonan'
        ];
        return view('permohonan/datapermohonan', $title);
    }

    public function viewPermohonan()
    {
        $db = db_connect();
        $query = $db->table('permohonan p')
                    ->select('p.idpermohonan, m.nama, p.kategoriasnaf, p.jenisbantuan, p.tglpengajuan, p.status')
                    ->join('mustahik m', 'm.id_mustahik = p.id_mustahik', 'left');

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idpermohonan="' . $row->idpermohonan . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idpermohonan="' . $row->idpermohonan . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idpermohonan="' . $row->idpermohonan . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
            return $buttonsGroup;
            }, 'last')
            ->edit('tglpengajuan', function ($row) {
                return $row->tglpengajuan ? date('d-m-Y', strtotime($row->tglpengajuan)) : '-';
            })
           
            ->edit('status', function ($row) {
                $badges = [
                    'diproses' => '<span class="badge badge-warning">Diproses</span>',
                    'diterima' => '<span class="badge badge-success">Diterima</span>',
                    'ditolak' => '<span class="badge badge-danger">Ditolak</span>',
                    'selesai' => '<span class="badge badge-info">Selesai</span>'
                ];
                return $badges[$row->status] ?? '<span class="badge badge-secondary">Unknown</span>';
            })
            ->edit('kategoriasnaf', function ($row) {
                return ucfirst($row->kategoriasnaf);
            })

            ->addNumbering()
            ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('PM', LPAD(IFNULL(MAX(SUBSTRING(idpermohonan, 3)) + 1, 1), 4, '0')) AS next_number FROM permohonan");
        $row = $query->getRow();
        $next_number = $row->next_number;
        
        // Ambil data mustahik untuk dropdown
        $modelMustahik = new ModelMustahik();
        $mustahiks = $modelMustahik->findAll();
        
        // Ambil data syarat untuk dropdown kategori asnaf
        $modelSyarat = new ModelSyarat();
        $syarats = $modelSyarat->findAll();
        
        $data = [
            'next_number' => $next_number,
            'mustahiks' => $mustahiks,
            'syarats' => $syarats
        ];
        return view('permohonan/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idpermohonan = $this->request->getPost('idpermohonan');
            $id_mustahik = $this->request->getPost('id_mustahik');
            $kategoriasnaf = $this->request->getPost('kategoriasnaf');
            $jenisbantuan = $this->request->getPost('jenisbantuan');
            $tglpengajuan = $this->request->getPost('tglpengajuan');
            $alasan = $this->request->getPost('alasan');
            $dokumen = $this->request->getFile('dokumen');

            // Validasi kategori asnaf berdasarkan data dari database
            $modelSyarat = new ModelSyarat();
            $syarats = $modelSyarat->findAll();
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
                'id_mustahik' => [
                    'label' => 'Mustahik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
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

                    $modelPermohonan = new ModelPermohonan();
                    $modelPermohonan->insert([
                        'idpermohonan' => $idpermohonan,
                        'id_mustahik' => $id_mustahik,
                        'kategoriasnaf' => $kategoriasnaf,
                        'jenisbantuan' => $jenisbantuan,
                        'tglpengajuan' => $tglpengajuan,
                        'alasan' => $alasan,
                        'dokumen' => $newName,
                        'status' => 'diproses', // Default status
                    ]);

                    $json = [
                        'sukses' => 'Berhasil Simpan Data'
                    ];
                } else {
                    // Jika tidak ada dokumen, tetap simpan data tanpa dokumen
                    $modelPermohonan = new ModelPermohonan();
                    $modelPermohonan->insert([
                        'idpermohonan' => $idpermohonan,
                        'id_mustahik' => $id_mustahik,
                        'kategoriasnaf' => $kategoriasnaf,
                        'jenisbantuan' => $jenisbantuan,
                        'tglpengajuan' => $tglpengajuan,
                        'alasan' => $alasan,
                        'status' => 'diproses', // Default status
                    ]);

                    $json = [
                        'sukses' => 'Berhasil Simpan Data'
                    ];
                }
            }
            echo json_encode($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idpermohonan = $this->request->getPost('idpermohonan');

            $model = new ModelPermohonan();
            $permohonan = $model->find($idpermohonan);
            
            // Hapus file dokumen jika ada
            if ($permohonan && !empty($permohonan['dokumen'])) {
                $filePath = 'uploads/permohonan/' . $permohonan['dokumen'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            $model->where('idpermohonan', $idpermohonan)->delete();

            $json = [
                'sukses' => 'Data Permohonan Berhasil Dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idpermohonan)
    {
        $model = new ModelPermohonan();
        $permohonan = $model->find($idpermohonan);

        if (!$permohonan) {
            return redirect()->to('/permohonan')->with('error', 'Data Permohonan tidak ditemukan');
        }
        
        // Ambil data mustahik untuk dropdown
        $modelMustahik = new ModelMustahik();
        $mustahiks = $modelMustahik->findAll();
        
        // Ambil data syarat untuk dropdown kategori asnaf
        $modelSyarat = new ModelSyarat();
        $syarats = $modelSyarat->findAll();
        
        $data = [
            'permohonan' => $permohonan,
            'mustahiks' => $mustahiks,
            'syarats' => $syarats
        ];

        return view('permohonan/formedit', $data);
    }

    public function updatedata($idpermohonan)
    {
        if ($this->request->isAJAX()) {
            $id_mustahik = $this->request->getPost('id_mustahik');
            $kategoriasnaf = $this->request->getPost('kategoriasnaf');
            $jenisbantuan = $this->request->getPost('jenisbantuan');
            $tglpengajuan = $this->request->getPost('tglpengajuan');
            $alasan = $this->request->getPost('alasan');
            $dokumen = $this->request->getFile('dokumen');
            
            // Validasi kategori asnaf berdasarkan data dari database
            $modelSyarat = new ModelSyarat();
            $syarats = $modelSyarat->findAll();
            $validKategori = array_column($syarats, 'kategori_asnaf');
            $kategoriList = implode(',', $validKategori);
            
            $rules = [
                'id_mustahik' => [
                    'label' => 'Mustahik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
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
                $model = new ModelPermohonan();
                $dataPermohonan = $model->where('idpermohonan', $idpermohonan)->first();
                
                if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
                    $newName = 'dokumen-' . date('Ymd') . '-' . $idpermohonan . '.' . $dokumen->getClientExtension();
                    $dokumen->move('uploads/permohonan/', $newName);

                    // Hapus dokumen lama jika ada
                    if (!empty($dataPermohonan['dokumen']) && file_exists('uploads/permohonan/' . $dataPermohonan['dokumen'])) {
                        unlink('uploads/permohonan/' . $dataPermohonan['dokumen']);
                    }

                    $dataUpdate = [
                        'id_mustahik' => $id_mustahik,
                        'kategoriasnaf' => $kategoriasnaf,
                        'jenisbantuan' => $jenisbantuan,
                        'tglpengajuan' => $tglpengajuan,
                        'alasan' => $alasan,
                        'dokumen' => $newName,
                    ];
                } else {
                    $dataUpdate = [
                        'id_mustahik' => $id_mustahik,
                        'kategoriasnaf' => $kategoriasnaf,
                        'jenisbantuan' => $jenisbantuan,
                        'tglpengajuan' => $tglpengajuan,
                        'alasan' => $alasan,
                    ];
                    
                    // Jika update tanpa mengubah dokumen, tetap gunakan dokumen yang ada (jika ada)
                    if (isset($dataPermohonan['dokumen'])) {
                        $dataUpdate['dokumen'] = $dataPermohonan['dokumen'];
                    }
                }
                
                $model->update($idpermohonan, $dataUpdate);
                
                $json = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function detail($idpermohonan)
    {
        $db = db_connect();
        $permohonan = $db->table('permohonan p')
            ->select('p.*, m.nama as nama_mustahik, m.alamat, m.nohp')
            ->join('mustahik m', 'm.id_mustahik = p.id_mustahik', 'left')
            ->where('p.idpermohonan', $idpermohonan)
            ->get()
            ->getRowArray();

        if (!$permohonan) {
            return redirect()->back()->with('error', 'Data Permohonan tidak ditemukan');
        }

        $data = [
            'permohonan' => $permohonan
        ];

        return view('permohonan/detail', $data);
    }

    public function updateStatus()
    {
        if ($this->request->isAJAX()) {
            $idpermohonan = $this->request->getPost('idpermohonan');
            $status = $this->request->getPost('status');

            if (!in_array($status, ['diproses', 'diterima', 'ditolak'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Status tidak valid'
                ]);
            }

            $model = new ModelPermohonan();
            $dataUpdate = [
                'status' => $status
            ];

            // Jika status diterima atau ditolak, set tanggal disetujui
            if ($status === 'diterima' || $status === 'ditolak') {
                $dataUpdate['tgldisetujui'] = date('Y-m-d');
            } else {
                $dataUpdate['tgldisetujui'] = null;
            }

            $model->update($idpermohonan, $dataUpdate);

            $json = [
                'sukses' => 'Status permohonan berhasil diupdate'
            ];
            
            return $this->response->setJSON($json);
        }
    }

    public function getSyaratByKategori()
    {
        if ($this->request->isAJAX()) {
            $kategori = $this->request->getPost('kategori');
            
            $modelSyarat = new ModelSyarat();
            $syarat = $modelSyarat->where('kategori_asnaf', $kategori)->first();
            
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
