<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomBookingModel extends Model
{
    protected $table            = 'roombookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'room_name',
        'booking_date',
        'start_time',
        'end_time',
        'purpose',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllBookings()
    {
        return $this->select('roombookings.*, users.name as user_name')
                    ->join('users', 'users.id = roombookings.user_id', 'left')
                    ->orderBy('roombookings.created_at', 'DESC')
                    ->findAll();
    }
}
