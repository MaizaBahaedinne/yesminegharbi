<?php

namespace App\Models;

use CodeIgniter\Model;

class ResourceOrderModel extends Model
{
    protected $table          = 'resource_orders';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'resource_id',
        'order_number',
        'base_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'promo_code',
        'payment_method',
        'payment_status',
        'status',
        'notes',
    ];
}
