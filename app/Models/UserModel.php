<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'email', 'password', 'role', 'status', 'last_login', 'remember_token'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    public function __construct()
    {
        parent::__construct();
        $this->initValidationRules();
    }

    protected function initValidationRules()
    {
        $this->validationRules = [
            'id' => 'permit_empty|is_natural_no_zero',
            'username' => [
                'rules' => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,{id}]',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'alpha_numeric_space' => 'Username hanya boleh berisi huruf, angka dan spasi',
                    'min_length' => 'Username minimal 3 karakter',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email,id,{id}]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah digunakan'
                ]
            ],
            'role' => [
                'rules' => 'required|in_list[admin,ketua,program,keuangan,mustahik,donatur]',
                'errors' => [
                    'required' => 'Role harus dipilih',
                    'in_list' => 'Role tidak valid'
                ]
            ],

            'status' => [
                'rules' => 'required|in_list[active,inactive]',
                'errors' => [
                    'required' => 'Status harus dipilih',
                    'in_list' => 'Status tidak valid'
                ]
            ],

        ];
    }

    public function getValidationRules(array $options = []): array
    {
        return $this->validationRules;
    }

    public function save($data): bool
    {
        // Jika ini adalah update, ubah validasi password menjadi opsional
        if (!empty($data['id'])) {
            $this->validationRules['password']['rules'] = 'permit_empty|min_length[6]';
        }

        return parent::save($data);
    }

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password']) || empty($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }
}
