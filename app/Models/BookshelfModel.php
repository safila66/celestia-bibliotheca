<?php

namespace App\Models;

use CodeIgniter\Model;

class BookshelfModel extends Model
{
    protected $table            = 'user_bookshelf_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 'book_id', 'status', 'format', 
        'read_start_date', 'read_end_date', 'moods', 
        'notes', 'favorite_quotes', 
        'rating_romance', 'rating_spice', 'rating_sadness', 'rating_writing'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUserBookshelf($userId)
    {
        return $this->select('user_bookshelf_details.*, books.title, books.author, books.cover_image')
                    ->join('books', 'books.id = user_bookshelf_details.book_id')
                    ->where('user_bookshelf_details.user_id', $userId)
                    ->findAll();
    }
}
