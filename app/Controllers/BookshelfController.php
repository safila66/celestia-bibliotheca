<?php

namespace App\Controllers;

use App\Models\ReadingTrackerModel;
use App\Models\BookModel;
use App\Models\BookshelfModel;

class BookshelfController extends BaseController
{
    protected $trackerModel;
    protected $bookModel;
    protected $bookshelfModel;

    public function __construct()
    {
        $this->trackerModel = new ReadingTrackerModel();
        $this->bookModel      = new BookModel();
        $this->bookshelfModel = new BookshelfModel();
    }

    public function index()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $myBooks = $this->trackerModel->getUserBookshelf($userId);

        // Grouping by status
        $readBooks = [];
        $tbrBooks  = [];
        $crBooks   = [];
        $dnfBooks  = [];

        foreach ($myBooks as $book) {
            if ($book['status'] === 'read') $readBooks[] = $book;
            elseif ($book['status'] === 'to_read') $tbrBooks[] = $book;
            elseif ($book['status'] === 'currently_reading') $crBooks[] = $book;
            elseif ($book['status'] === 'dnf') $dnfBooks[] = $book;
        }

        // Data is real now, no seeder needed
        return view('user/bookshelf/index', [
            'title'     => 'My Bookshelf',
            'readBooks' => $readBooks,
            'tbrBooks'  => $tbrBooks,
            'crBooks'   => $crBooks,
            'dnfBooks'  => $dnfBooks,
            'allBooks'  => $myBooks
        ]);
    }

    public function addToBookshelf()
    {
        if (!$this->request->isAJAX()) return;
        
        $userId = session()->get('user_id');
        $bookId = $this->request->getPost('book_id');
        $status = $this->request->getPost('status'); // read, tbr, dnf

        $existing = $this->bookshelfModel->where('user_id', $userId)->where('book_id', $bookId)->first();
        if ($existing) {
            $this->bookshelfModel->update($existing['id'], ['status' => $status]);
        } else {
            $this->bookshelfModel->insert([
                'user_id' => $userId,
                'book_id' => $bookId,
                'status'  => $status,
                'format'  => 'Physical'
            ]);
        }
        return $this->response->setJSON(['success' => true]);
    }

    public function updateStatus()
    {
        if (!$this->request->isAJAX()) return;
        
        $userId = session()->get('user_id');
        $bookId = $this->request->getPost('id'); // we'll pass book_id as 'id' from JS
        $status = $this->request->getPost('status');
        
        $existing = $this->bookshelfModel->where('user_id', $userId)->where('book_id', $bookId)->first();
        if ($existing) {
            $this->bookshelfModel->update($existing['id'], ['status' => $status]);
        } else {
            $this->bookshelfModel->insert([
                'user_id' => $userId,
                'book_id' => $bookId,
                'status' => $status,
                'format' => 'Ebook'
            ]);
        }
        return $this->response->setJSON(['success' => true]);
    }

    public function saveDetails()
    {
        if (!$this->request->isAJAX()) return;
        
        $userId = session()->get('user_id');
        $bookId = $this->request->getPost('book_id');
        $moods = $this->request->getPost('moods'); // array
        $notes = $this->request->getPost('notes');
        $quotes = $this->request->getPost('favorite_quotes');
        $r_romance = $this->request->getPost('rating_romance');
        $r_spice   = $this->request->getPost('rating_spice');
        $r_sadness = $this->request->getPost('rating_sadness');
        $r_writing = $this->request->getPost('rating_writing');

        $data = [
            'user_id' => $userId,
            'book_id' => $bookId,
            'moods' => is_array($moods) ? json_encode($moods) : $moods,
            'notes' => $notes,
            'favorite_quotes' => $quotes,
            'rating_romance' => $r_romance,
            'rating_spice'   => $r_spice,
            'rating_sadness' => $r_sadness,
            'rating_writing' => $r_writing
        ];

        // Ensure status and format are retained if creating new
        $existing = $this->bookshelfModel->where('user_id', $userId)->where('book_id', $bookId)->first();
        if ($existing) {
            $this->bookshelfModel->update($existing['id'], $data);
        } else {
            $data['status'] = 'tbr';
            $data['format'] = 'Ebook';
            $this->bookshelfModel->insert($data);
        }

        return $this->response->setJSON(['success' => true]);
    }
}
