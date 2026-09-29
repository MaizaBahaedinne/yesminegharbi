<?php

namespace App\Models;

use CodeIgniter\Model;

class CvAtsTestModel extends Model
{
    public const FREE_TESTS_PER_DAY = 3;

    protected $table         = 'cv_ats_tests';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['user_id', 'cv_id', 'job_title', 'offer_text', 'score', 'result'];
    protected $useTimestamps = true;
    protected $updatedField  = '';

    public function countToday(int $userId): int
    {
        return $this->where('user_id', $userId)
            ->where('created_at >=', date('Y-m-d 00:00:00'))
            ->countAllResults();
    }

    public function forCv(int $cvId, int $userId, int $limit = 10): array
    {
        return $this->select('id, job_title, score, created_at')
            ->where('cv_id', $cvId)->where('user_id', $userId)
            ->orderBy('id', 'DESC')->findAll($limit);
    }
}
