<?php

namespace App\Models;

use CodeIgniter\Model;

class MendeleyClassModel extends Model
{
    protected $table            = 'mendeley_classes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'schedule_date', 'session', 'format', 'qr_code', 'zoom_link', 'zoom_passcode'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
