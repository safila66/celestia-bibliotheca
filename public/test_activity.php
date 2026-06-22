<?php

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Location of the Paths config file.
// This is the line that might need to be changed, depending on your folder structure.
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
require $pathsPath;
$paths = new Config\Paths();

// Location of the framework bootstrap file.
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = Config\Services::codeigniter();
$app->initialize();

$db = \Config\Database::connect();

try {
    $bookshelf = $db->table('user_bookshelf_details')
        ->select('user_bookshelf_details.*, books.title, books.cover_image, \'bookshelf\' as type', false)
        ->join('books', 'books.id = user_bookshelf_details.book_id')
        ->where('user_bookshelf_details.user_id', 1)
        ->orderBy('user_bookshelf_details.updated_at', 'DESC')
        ->limit(10)
        ->get()->getResultArray();
    
    $reviews = $db->table('reviews')
        ->select('reviews.*, books.title, books.cover_image, \'review\' as type', false)
        ->join('books', 'books.id = reviews.book_id')
        ->where('reviews.user_id', 1)
        ->orderBy('reviews.created_at', 'DESC')
        ->limit(10)
        ->get()->getResultArray();
    
    $activities = array_merge($bookshelf, $reviews);
    usort($activities, function($a, $b) {
        $timeA = isset($a['created_at']) ? strtotime($a['created_at']) : strtotime($a['updated_at']);
        $timeB = isset($b['created_at']) ? strtotime($b['created_at']) : strtotime($b['updated_at']);
        return $timeB - $timeA;
    });
    
    echo "SUCCESS\n";
    print_r(count($activities));
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
