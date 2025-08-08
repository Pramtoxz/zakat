<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Donatur as ModelDonatur;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use App\Models\Program as ModelProgram;
use App\Models\Donasi as ModelDonasi;
use PhpParser\Node\Expr\AssignOp\Mod;

class DonasiController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Donasi'
        ];
        return view('donasi/datadonasi', $title);
    }

    public function viewDonasi()
    {
        $db = db_connect();
        $query = $db->table('donasi')
                    ->select('donasi.iddonasi, donatur.nama as nama_donatur,program.namaprogram, donasi.nominal, donasi.status, donasi.online')
                    ->join('donatur', 'donatur.id_donatur = donasi.id_donatur', 'left')
                    ->join('program', 'program.idprogram = donasi.idprogram', 'left');

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-iddonasi="' . $row->iddonasi . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-iddonasi="' . $row->iddonasi . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-iddonasi="' . $row->iddonasi . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            // Tombol verifikasi untuk online = 1
            $button4 = '';
            if ($row->online == 1) {
                $button4 = '<button type="button" class="btn btn-warning btn-sm btn-verify" data-iddonasi="' . $row->iddonasi . '" data-toggle="modal" data-target="#verifyModal" style="margin-left: 5px;"><i class="fas fa-check-circle"></i></button>';
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
            ->addNumbering()
            ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('DN', LPAD(IFNULL(MAX(SUBSTRING(iddonasi, 3)) + 1, 1), 4, '0')) AS next_number FROM donasi");
        $row = $query->getRow();
        $next_number = $row->next_number;
        
        // Ambil data donatur untuk dropdown
        $modelDonatur = new ModelDonatur();
        $donaturs = $modelDonatur->findAll();

        // Ambil data program untuk donasi berdasarkan idkategori != 2 (selain zakat)
        $db = db_connect();
        $programs = $db->table('program')
                    ->select('idprogram, namaprogram, program.idkategori')
                    ->join('kategori', 'kategori.idkategori = program.idkategori', 'left')
                    ->where('program.idkategori !=', 2)
                    ->get()
                    ->getResultArray();
        
        $data = [
            'next_number' => $next_number,
            'donaturs' => $donaturs,
            'programs' => $programs
        ];
        return view('donasi/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $iddonasi = $this->request->getPost('iddonasi');
            $id_donatur = $this->request->getPost('id_donatur');
            $idprogram = $this->request->getPost('idprogram');
            $nominal = $this->request->getPost('nominal');

            $rules = [
                'id_donatur' => [
                    'label' => 'Donatur',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'idprogram' => [
                    'label' => 'Program',
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
            $model = new ModelDonasi();
            $model->insert([
                'iddonasi' => $iddonasi,
                'id_donatur' => $id_donatur,
                'idprogram' => $idprogram,
                'nominal' => $nominal,
                'online' => 0,
                'status' => 'diterima',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $json = [
                'sukses' => 'Data Donasi Berhasil Disimpan'
            ];
            }
            echo json_encode($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $iddonasi = $this->request->getPost('iddonasi');

            $model = new ModelDonasi();
            $donasi = $model->find($iddonasi);
            
            // Hapus file bukti bayar jika ada
            if ($donasi && !empty($donasi['buktibayar'])) {
                $filePath = 'uploads/donasi/' . $donasi['buktibayar'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            $model->where('iddonasi', $iddonasi)->delete();

            $json = [
                'sukses' => 'Data Donasi Berhasil Dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($iddonasi)
    {
        $model = new ModelDonasi();
        $donasi = $model->find($iddonasi);

        if (!$donasi) {
            return redirect()->to('/donasi')->with('error', 'Data Donasi tidak ditemukan');
        }

        // Ambil data program untuk donasi berdasarkan idkategori != 2 (selain zakat)
        $db = db_connect();
        $programs = $db->table('program')
                    ->select('idprogram, namaprogram, kategori.idkategori')
                    ->join('kategori', 'kategori.idkategori = program.idkategori', 'left')
                    ->where('program.idkategori !=', 2)
                    ->get()
                    ->getResultArray();
        
        // Ambil data donatur untuk dropdown
        $modelDonatur = new ModelDonatur();
        $donaturs = $modelDonatur->findAll();

        
        $data = [
            'donasi' => $donasi,
            'donaturs' => $donaturs,
            'programs' => $programs
        ];

        return view('donasi/formedit', $data);
    }

    public function updatedata($idzakat)
    {
        if ($this->request->isAJAX()) {
            $iddonasi = $this->request->getPost('iddonasi');
            $id_donatur = $this->request->getPost('id_donatur');
            $idprogram = $this->request->getPost('idprogram');
            $nominal = $this->request->getPost('nominal');

            $rules = [
                'id_donatur' => [
                    'label' => 'Donatur',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'idprogram' => [
                    'label' => 'Program',
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
            $model = new ModelDonasi();
            $model->update($iddonasi, [  
                'id_donatur' => $id_donatur,
                'idprogram' => $idprogram,
                'nominal' => $nominal,
                'online' => 0,
                'status' => 'diterima',
                'updated_at' => date('Y-m-d H:i:s'),
                ]);

            $json = [
                'sukses' => 'Data Donasi Berhasil Di Update'
            ];
            }
            echo json_encode($json);
        }
    }

    public function detail($iddonasi)
    {
        $db = db_connect();
        $donasi = $db->table('donasi')
        ->select('donasi.*, donatur.nama as nama_donatur, donatur.alamat, donatur.nohp, donatur.jenkel, donatur.tgllahir, donatur.foto, program.namaprogram')
        ->join('donatur', 'donatur.id_donatur = donasi.id_donatur', 'left')
        ->join('program', 'program.idprogram = donasi.idprogram', 'left')
        ->where('iddonasi', $iddonasi)
        ->get()
        ->getRowArray();

        if (!$donasi) {
            return redirect()->back()->with('error', 'Data Donasi tidak ditemukan');
        }

        $data = [
            'donasi' => $donasi
        ];

        return view('donasi/detail', $data);
    }

    public function verifyPayment()
    {
        if ($this->request->isAJAX()) {
            $iddonasi = $this->request->getPost('iddonasi');
            $status = $this->request->getPost('status');

            if (!in_array($status, ['diterima', 'ditolak'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Status tidak valid'
                ]);
            }

            $model = new ModelDonasi();
            $dataUpdate = [
                'status' => $status
            ];

            $model->update($iddonasi, $dataUpdate);

            $json = [
                'sukses' => 'Status pembayaran berhasil diverifikasi'
            ];
            
            return $this->response->setJSON($json);
        }
    }

    public function getBuktiBayar()
    {
        if ($this->request->isAJAX()) {
            $iddonasi = $this->request->getPost('iddonasi');
            
            $db = db_connect();
            $donasi = $db->table('donasi')
                ->select('donasi.*, donatur.nama as nama_donatur')
                ->join('donatur', 'donatur.id_donatur = donasi.id_donatur', 'left')
                ->where('donasi.iddonasi', $iddonasi)
                ->get()
                ->getRowArray();

            if ($donasi) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $donasi
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