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
        'situation_actuelle',
        'email',
        'password_hash',
        'activation_token',
        'activation_code',
        'activation_code_expires_at',
        'reset_token_hash',
        'reset_token_expires_at',
        'is_active',
        'role',
    ];

    public function findByEmail(string $email): ?array
    {
        return $this->where('LOWER(email)', strtolower(trim($email)))->first();
    }
}
