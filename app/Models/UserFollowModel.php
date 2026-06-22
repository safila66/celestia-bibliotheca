<?php

namespace App\Models;

use CodeIgniter\Model;

class UserFollowModel extends Model
{
    protected $table            = 'user_follows';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['follower_id', 'following_id', 'created_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function isFollowing($followerId, $followedId)
    {
        return $this->where('follower_id', $followerId)
                    ->where('following_id', $followedId)
                    ->countAllResults() > 0;
    }

    public function toggleFollow($followerId, $followedId)
    {
        if ($this->isFollowing($followerId, $followedId)) {
            $this->where('follower_id', $followerId)
                 ->where('following_id', $followedId)
                 ->delete();
            return false; // Not following anymore
        } else {
            $this->insert([
                'follower_id' => $followerId,
                'following_id' => $followedId,
                'created_at'  => date('Y-m-d H:i:s')
            ]);
            return true; // Now following
        }
    }
}
