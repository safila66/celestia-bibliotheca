<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table            = 'reviews';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['book_id', 'user_id', 'rating', 'review_text', 'moods', 'pace', 'plot_or_character', 'strong_dev', 'loveable', 'diverse', 'flaws_focus', 'themes', 'content_warnings'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    public function getReviewsWithUser($bookId)
    {
        return $this->select('reviews.*, users.name')
                    ->join('users', 'users.id = reviews.user_id')
                    ->where('reviews.book_id', $bookId)
                    ->orderBy('reviews.created_at', 'DESC')
                    ->findAll();
    }
}
