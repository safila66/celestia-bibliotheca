<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table            = 'books';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title', 'author', 'publisher', 'year', 'isbn', 'call_number', 
        'category_id', 'description', 'cover_image', 'language', 'pages', 
        'edition', 'stock', 'stock_available', 'type', 'file_pdf', 'status', 'genres'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Diubah menjadi true agar CI4 otomatis mengisi 'created_at' dan 'updated_at'
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Fungsi ini dipanggil secara rahasia oleh AJAX
    public function ajaxTable()
    {
        // Ambil pencarian jika ada
        $keyword  = $this->request->getGet('q');
        $category = $this->request->getGet('kategori');

        $data = [
            // Ambil data buku dari model
            'books' => $this->bookModel->search($keyword, $category)
        ];

        // MENGEMBALIKAN POTONGAN HTML (Tidak memuat template header/sidebar admin lagi)
        return view('admin/books/_table', $data);
    }


    // ════════════════════════════════════════════
    //   ADDED FUNCTIONS (CUSTOM METHODS)
    // ════════════════════════════════════════════

    /**
     * take featured books for homepage
     * this function is called in HomeController to get featured books for homepage
     */
    public function getFeatured(int $limit = 8)
    {
        return $this->where('status', 'active')
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }

    public function getNewArrivals($limit = 4)
    {return $this->orderBy('id', 'DESC')->findAll($limit);}

    /**
     * counting active books for stats bar
     * this function is called in HomeController to get total active books for stats bar
     */
    public function countActive()
    {
        return $this->where('status', 'active')->countAllResults();
    }

// ════════════════════════════════════════════
    //   FUNGSI STATISTIK UNTUK DASHBOARD ADMIN
    // ════════════════════════════════════════════

    public function getMostBorrowed($limit = 5)
    {
        // Menampilkan 5 buku urutan teratas (sebagai pengganti fitur most loaned)
        return $this->orderBy('id', 'DESC')->findAll($limit);
    }

// ══════════════════════════════════════════════════════════
    // FUNGSI PENCARIAN BUKU (Untuk Admin & User)
    // ══════════════════════════════════════════════════════════
    public function search($keyword = null, $category = null)
    {
        // Hubungkan (Join) ke tabel categories agar kita bisa melihat nama kategorinya
        $this->select('books.*, categories.name as category_name')
             ->join('categories', 'categories.id = books.category_id', 'left');

        // Jika ada pencarian kata kunci (keyword)
        if (!empty($keyword)) {
            $this->groupStart()
                 ->like('books.title', $keyword)
                 ->orLike('books.author', $keyword)
                 ->orLike('books.isbn', $keyword)
                 ->orLike('books.publisher', $keyword)
                 ->groupEnd();
        }

        // Jika ada filter berdasarkan kategori DDC
        if (!empty($category)) {
            // Bisa mencari berdasarkan ID Kategori atau Slug Kategori
            if (is_numeric($category)) {
                $this->where('books.category_id', $category);
            } else {
                $this->where('categories.slug', $category);
            }
        }

        // Urutkan dari buku yang paling baru ditambahkan
        $this->orderBy('books.created_at', 'DESC');

        // Kembalikan semua hasilnya
        return $this->findAll();
    }

}

