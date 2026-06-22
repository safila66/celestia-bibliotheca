<?php

namespace App\Models;

use CodeIgniter\Model;

class DeliveryModel extends Model
{
    protected $table            = 'deliveries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'book_id',
        'delivery_address',
        'status',
        'shipping_date',
        'tracking_number'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllDeliveries()
    {
        return $this->select('deliveries.*, users.name as user_name, books.title as book_title')
                    ->join('users', 'users.id = deliveries.user_id', 'left')
                    ->join('books', 'books.id = deliveries.book_id', 'left')
                    ->orderBy('deliveries.created_at', 'DESC')
                    ->findAll();
    }
}
