<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomParticipantModel extends Model
{
    protected $table = 'online_room_participants';
    protected $primaryKey = 'id';
    protected $allowedFields = ['room_id', 'user_id', 'join_reason', 'joined_at'];
    protected $useTimestamps = false;
}
