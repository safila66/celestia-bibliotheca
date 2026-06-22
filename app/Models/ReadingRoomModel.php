<?php

namespace App\Models;

use CodeIgniter\Model;

class ReadingRoomModel extends Model
{
    protected $table = 'online_reading_rooms';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'schedule_time', 'zoom_link', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
