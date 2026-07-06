<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table          = 'users';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $allowedFields  = [
        'prenom',
        'nom',
        'date_naissance',
        'email',
        'password_hash',
        'activation_token',
        'is_active',
    ];

    public function findByEmail(string $email): ?array
    {
        return $this->where('LOWER(email)', strtolower(trim($email)))->first();
    }
}
