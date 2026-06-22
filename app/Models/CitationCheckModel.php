<?php

namespace App\Models;

use CodeIgniter\Model;

class CitationCheckModel extends Model
{
    protected $table            = 'citation_checks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'title', 'file_path', 'ai_percentage', 'status', 'librarian_notes'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
