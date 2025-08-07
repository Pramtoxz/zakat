<?php

namespace App\Models;

use CodeIgniter\Model;

class Donatur extends Model
{
    protected $table            = 'donatur';
    protected $primaryKey       = 'id_donatur';
    protected $useAutoIncrement = false; // Primary key bukan auto increment
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_donatur', 'nama', 'alamat', 'nohp', 'jenkel','tgllahir','iduser','foto'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Cek apakah user sudah memiliki profile donatur
     */
    public function hasProfile($iduser)
    {
        return $this->where('iduser', $iduser)->first() !== null;
    }

    /**
     * Get profile donatur berdasarkan iduser
     */
    public function getByUserId($iduser)
    {
        return $this->where('iduser', $iduser)->first();
    }
}