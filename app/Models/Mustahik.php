<?php

namespace App\Models;

use CodeIgniter\Model;

class Mustahik extends Model
{
    protected $table            = 'mustahik';
    protected $primaryKey       = 'id_mustahik';
    protected $useAutoIncrement = false; // Primary key bukan auto increment
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_mustahik', 'nama', 'alamat', 'nohp', 'jenkel','tgllahir','iduser','foto'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Cek apakah user sudah memiliki profile mustahik
     */
    public function hasProfile($iduser)
    {
        return $this->where('iduser', $iduser)->first() !== null;
    }

    /**
     * Get profile mustahik berdasarkan iduser
     */
    public function getByUserId($iduser)
    {
        return $this->where('iduser', $iduser)->first();
    }
}