<?php

namespace App\Models;

use CodeIgniter\Model;

class LanguageClassModel extends Model
{
    protected $table            = 'language_classes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'language', 'schedule_date', 'session_time', 'room', 'seat_number', 'qr_code', 'status'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
