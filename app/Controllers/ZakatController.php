<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Zakat as ModelZakat;
use App\Models\Donatur as ModelDonatur;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class ZakatController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Zakat'
        ];
        return view('zakat/datazakat', $title);
    }

    public function viewZakat()
    {
        $db = db_connect();
        $query = $db->table('zakat z')
                    ->select('z.idzakat, d.nama, z.nominal, p.namaprogram, z.status, z.online')
                    ->join('donatur d', 'd.id_donatur = z.id_donatur', 'left')
                    ->join('program p', 'p.idprogram = z.jeniszakat', 'left')
                    ->where('p.idkategori', 2);

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idzakat="' . $row->idzakat . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idzakat="' . $row->idzakat . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idzakat="' . $row->idzakat . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            // Tombol verifikasi untuk online = 1
            $button4 = '';
            if ($row->online == 1) {
                $button4 = '<button type="button" class="btn btn-warning btn-sm btn-verify" data-idzakat="' . $row->idzakat . '" data-toggle="modal" data-target="#verifyModal" style="margin-left: 5px;"><i class="fas fa-check-circle"></i></button>';
            }
            
            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . $button4 . '</div>';
            return $buttonsGroup;
            }, 'last')
            ->edit('nominal', function ($row) {
                return 'Rp ' . number_format($row->nominal, 0, ',', '.');
            })
            ->edit('online', function ($row) {
                return $row->online == 1 ? '<span class="badge badge-info">Online</span>' : '<span class="badge badge-secondary">Offline</span>';
            })
            ->edit('status', function ($row) {
                $badges = [
                    'diterima' => '<span class="badge badge-success">Diterima</span>',
                    'ditolak' => '<span class="badge badge-danger">Ditolak</span>',
                    'pending' => '<span class="badge badge-warning">Pending</span>'
                ];
                return $badges[$row->status] ?? '<span class="badge badge-secondary">Unknown</span>';
            })
            ->hide('online')
            ->edit('namaprogram', function ($row) {
                // Sekarang jeniszakat berisi idprogram, tampilkan namaprogram
                return $row->namaprogram ? '<span class="badge badge-info">' . $row->namaprogram . '</span>' : '<span class="badge badge-secondary">-</span>';
            })

            ->addNumbering()
            ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('ZK', LPAD(IFNULL(MAX(SUBSTRING(idzakat, 3)) + 1, 1), 4, '0')) AS next_number FROM zakat");
        $row = $query->getRow();
        $next_number = $row->next_number;

        // Ambil data program untuk jenis zakat berdasarkan idkategori = 2
        $db = db_connect();
        $programs = $db->table('program')
                    ->select('idprogram, namaprogram, program.idkategori')
                    ->join('kategori', 'kategori.idkategori = program.idkategori', 'left')
                    ->where('program.idkategori', 2)
                    ->get()
                    ->getResultArray();
        
        // Ambil data donatur untuk dropdown
        $modelDonatur = new ModelDonatur();
        $donaturs = $modelDonatur->findAll();
        
        
        $data = [
            'next_number' => $next_number,
            'donaturs' => $donaturs,
            'programs' => $programs
        ];
        return view('zakat/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $id_donatur = $this->request->getPost('id_donatur');
            $idzakat = $this->request->getPost('idzakat');
            $jeniszakat = $this->request->getPost('jeniszakat'); // ini sekarang berisi idprogram
            $nominal = $this->request->getPost('nominal');

            $rules = [
                'id_donatur' => [
                    'label' => 'Donatur',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'idzakat' => [
                    'label' => 'Kode Zakat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jeniszakat' => [
                    'label' => 'Jenis Zakat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nominal' => [
                    'label' => 'Nominal',
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
            $model = new ModelZakat();
            $model->insert([
                'id_donatur' => $id_donatur,
                'idzakat' => $idzakat,
                'jeniszakat' => $jeniszakat,
                'nominal' => $nominal,
                'online' => 0,
                'status' => 'diterima',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $json = [
                'sukses' => 'Data Zakat Berhasil Disimpan'
            ];
            }
            echo json_encode($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idzakat = $this->request->getPost('idzakat');

            $model = new ModelZakat();
            $zakat = $model->find($idzakat);
            
            // Hapus file bukti bayar jika ada
            if ($zakat && !empty($zakat['buktibayar'])) {
                $filePath = 'uploads/zakat/' . $zakat['buktibayar'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            $model->where('idzakat', $idzakat)->delete();

            $json = [
                'sukses' => 'Data Zakat Berhasil Dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idzakat)
    {
        $model = new ModelZakat();
        $zakat = $model->find($idzakat);

        if (!$zakat) {
            return redirect()->to('/zakat')->with('error', 'Data Zakat tidak ditemukan');
        }
        
        // Ambil data donatur untuk dropdown
        $modelDonatur = new ModelDonatur();
        $donaturs = $modelDonatur->findAll();
        
        // Ambil data program untuk jenis zakat berdasarkan idkategori = 2
        $db = db_connect();
        $programs = $db->table('program')
                    ->select('idprogram, namaprogram, kategori.namakategori')
                    ->join('kategori', 'kategori.idkategori = program.idkategori', 'left')
                    ->where('program.idkategori', 2)
                    ->get()
                    ->getResultArray();
        
        $data = [
            'zakat' => $zakat,
            'donaturs' => $donaturs,
            'programs' => $programs
        ];

        return view('zakat/formedit', $data);
    }

    public function updatedata($idzakat)
    {
        if ($this->request->isAJAX()) {
            $id_donatur = $this->request->getPost('id_donatur');
            $idzakat = $this->request->getPost('idzakat');
            $jeniszakat = $this->request->getPost('jeniszakat');
            $nominal = $this->request->getPost('nominal');

            $rules = [
                'id_donatur' => [
                    'label' => 'Donatur',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'idzakat' => [
                    'label' => 'Kode Zakat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jeniszakat' => [
                    'label' => 'Jenis Zakat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nominal' => [
                    'label' => 'Nominal',
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
            $model = new ModelZakat();
            $model->update($idzakat, [  
                'idzakat' => $idzakat,
                'jeniszakat' => $jeniszakat,
                'nominal' => $nominal,
                'online' => 0,
                'status' => 'diterima', 
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $json = [
                'sukses' => 'Data Zakat Berhasil Di Update'
            ];
            }
            echo json_encode($json);
        }
    }

    public function detail($idzakat)
    {
        $db = db_connect();
        $zakat = $db->table('zakat')
        ->select('zakat.*, donatur.nama as nama_donatur, donatur.alamat, donatur.nohp, donatur.jenkel, donatur.tgllahir, donatur.foto')
        ->join('donatur', 'donatur.id_donatur = zakat.id_donatur', 'left')
        ->where('idzakat', $idzakat)
        ->get()
        ->getRowArray();

        if (!$zakat) {
            return redirect()->back()->with('error', 'Data Zakat tidak ditemukan');
        }

        $data = [
            'zakat' => $zakat
        ];

        return view('zakat/detail', $data);
    }

    public function verifyPayment()
    {
        if ($this->request->isAJAX()) {
            $idzakat = $this->request->getPost('idzakat');
            $status = $this->request->getPost('status');

            if (!in_array($status, ['diterima', 'ditolak'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Status tidak valid'
                ]);
            }

            $model = new ModelZakat();
            $dataUpdate = [
                'status' => $status
            ];

            $model->update($idzakat, $dataUpdate);

            $json = [
                'sukses' => 'Status pembayaran berhasil diverifikasi'
            ];
            
            return $this->response->setJSON($json);
        }
    }

    public function getBuktiBayar()
    {
        if ($this->request->isAJAX()) {
            $idzakat = $this->request->getPost('idzakat');
            
            $db = db_connect();
            $zakat = $db->table('zakat z')
                ->select('z.*, d.nama as nama_donatur')
                ->join('donatur d', 'd.id_donatur = z.id_donatur', 'left')
                ->where('z.idzakat', $idzakat)
                ->get()
                ->getRowArray();

            if ($zakat) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $zakat
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
}