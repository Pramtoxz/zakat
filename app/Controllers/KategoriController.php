<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kategori as ModelKategoris;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class KategoriController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Kategori'
        ];
        return view('kategori/datakategori', $title);
    }

    public function view()
    {
        $db = db_connect();
        $query = $db->table('kategori')
                    ->select('idkategori, namakategori');
        return DataTable::of($query)
        ->add('action', function ($row) {
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idkategori="' . $row->idkategori . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idkategori="' . $row->idkategori . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            $buttonsGroup = '<div style="display: flex;">' . $button2 . $button3  . '</div>';
            return $buttonsGroup;
            }, 'last')
            ->addNumbering()
            ->hide('idkategori')
            ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('KT', LPAD(IFNULL(MAX(SUBSTRING(idkategori, 3)) + 1, 1), 4, '0')) AS next_number FROM kategori");
        $row = $query->getRow();
        $next_number = $row->next_number;
        $data = [
            'next_number' => $next_number,
        ];
        return view('kategori/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idkategori = $this->request->getPost('idkategori');
            $namakategori = $this->request->getPost('namakategori');

            $rules = [
                'namakategori' => [
                    'label' => 'Nama Kategori',
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
                $modelKategori = new ModelKategoris();
                $modelKategori->insert([
                    'idkategori' => $idkategori,
                    'namakategori' => $namakategori
                ]);

                $json = [
                    'sukses' => 'Data kategori berhasil disimpan'
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idkategori = $this->request->getPost('idkategori');

            $model = new ModelKategoris();
            $model->where('idkategori', $idkategori)->delete();

            $json = [
                'sukses' => 'Data kategori berhasil dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idkategori)
    {
        $model = new ModelKategoris();
        $kategori = $model->find($idkategori);

        if (!$kategori) {
            return redirect()->to('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }
        
        $data = [
            'kategori' => $kategori
        ];

        return view('kategori/formedit', $data);
    }

    public function updatedata($idkategori)
    {
        if ($this->request->isAJAX()) {
            $idkategori = $this->request->getPost('idkategori');
            $namakategori = $this->request->getPost('namakategori');
            
            $rules = [
                'namakategori' => [
                    'label' => 'Nama Kategori',
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
                $model = new ModelKategoris();
                $dataUpdate = [
                    'namakategori' => $namakategori
                ];
                
                $model->update($idkategori, $dataUpdate);
                
                $json = [
                    'sukses' => 'Data kategori berhasil diupdate'
                ];
            }
            return $this->response->setJSON($json);
        }
    }
}
