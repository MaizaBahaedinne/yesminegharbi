<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsletterModel extends Model
{
    protected $table      = 'newsletter_subscribers';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['email', 'prenom', 'tag'];
    protected $useTimestamps = true;

    public function isSubscribed(string $email): bool
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }
}
