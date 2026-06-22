<?php

namespace App\Models;

use CodeIgniter\Model;

class ReadingTrackerModel extends Model
{
    protected $table            = 'reading_trackers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['book_id', 'user_id', 'status', 'progress', 'started_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

    public function getTracker($userId, $bookId)
    {
        return $this->where('user_id', $userId)
                    ->where('book_id', $bookId)
                    ->first();
    }

    public function getUserBookshelf($userId)
    {
        return $this->select('reading_trackers.*, books.title, books.author, books.cover_image')
                    ->join('books', 'books.id = reading_trackers.book_id')
                    ->where('reading_trackers.user_id', $userId)
                    ->findAll();
    }
}
