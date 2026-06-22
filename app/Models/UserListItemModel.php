<?php

namespace App\Models;

use CodeIgniter\Model;

class UserListItemModel extends Model
{
    protected $table            = 'user_list_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['list_id', 'book_id', 'notes', 'added_at'];

    // Dates
    protected $useTimestamps = false; // Using custom added_at
}
