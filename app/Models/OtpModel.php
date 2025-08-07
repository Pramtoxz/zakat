<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpModel extends Model
{
    protected $table            = 'otp_codes';
    protected $primaryKey        = 'id';
    protected $useAutoIncrement  = true;
    protected $returnType        = 'array';
    protected $useSoftDeletes    = false;
    protected $protectFields     = true;
    protected $allowedFields     = ['email', 'otp_code', 'type', 'is_used', 'expires_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Generate OTP untuk email dan type tertentu
     *
     * @param string $email
     * @param string $type
     * @return array
     */
    public function generateOTP(string $email, string $type): array
    {
        // Generate 6-digit random OTP
        $otpCode = rand(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        
        $data = [
            'email'      => $email,
            'otp_code'   => $otpCode,
            'type'       => $type,
            'is_used'    => 0,
            'expires_at' => $expiresAt,
        ];
        
        $this->insert($data);
        
        return [
            'email'      => $email,
            'otp_code'   => $otpCode,
            'expires_at' => $expiresAt,
        ];
    }
    
    /**
     * Verifikasi OTP yang dimasukkan pengguna
     *
     * @param string $email
     * @param string $otpCode
     * @param string $type
     * @return bool
     */
    public function verifyOTP(string $email, string $otpCode, string $type): bool
    {
        $now = date('Y-m-d H:i:s');
        
        $otp = $this->where('email', $email)
            ->where('otp_code', $otpCode)
            ->where('type', $type)
            ->where('is_used', 0)
            ->where('expires_at >', $now)
            ->first();
            
        if ($otp) {
            // Tandai OTP sebagai sudah digunakan
            $this->update($otp['id'], ['is_used' => 1]);
            return true;
        }
        
        return false;
    }
    
    /**
     * Cek apakah email sudah memiliki OTP yang valid
     *
     * @param string $email
     * @param string $type
     * @return bool
     */
    public function hasValidOTP(string $email, string $type): bool
    {
        $now = date('Y-m-d H:i:s');
        
        $otp = $this->where('email', $email)
            ->where('type', $type)
            ->where('is_used', 0)
            ->where('expires_at >', $now)
            ->first();
        
        return $otp !== null;
    }
    
    /**
     * Hapus OTP yang sudah kedaluarsa
     *
     * @return int
     */
    public function cleanExpiredOTP(): int
    {
        $now = date('Y-m-d H:i:s');
        
        return $this->where('expires_at <', $now)
            ->orWhere('is_used', 1)
            ->delete();
    }
    
    /**
     * Batalkan semua OTP yang belum digunakan untuk email dan type tertentu
     *
     * @param string $email
     * @param string $type
     * @return bool
     */
    public function cancelPendingOTP(string $email, string $type): bool
    {
        return $this->where('email', $email)
            ->where('type', $type)
            ->where('is_used', 0)
            ->set(['is_used' => 1])
            ->update();
    }
}