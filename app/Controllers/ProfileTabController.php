<?php

namespace App\Controllers;

use App\Models\BookshelfModel;
use App\Models\ReviewModel;
use App\Models\WishlistModel;
use App\Models\ReadingTrackerModel;
use App\Models\FavoriteBookModel;
use App\Models\UserListModel;

class ProfileTabController extends BaseController
{
    public function getTab($tabName)
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return "Unauthorized";
        }

        $db = \Config\Database::connect();

        switch ($tabName) {
            case 'activity':
                // Recent books and reviews (excluding fines)
                $bookshelf = $db->table('user_bookshelf_details')
                    ->select('user_bookshelf_details.*, books.title, books.cover_image, \'bookshelf\' as type', false)
                    ->join('books', 'books.id = user_bookshelf_details.book_id')
                    ->where('user_bookshelf_details.user_id', $userId)
                    ->orderBy('user_bookshelf_details.updated_at', 'DESC')
                    ->limit(10)
                    ->get()->getResultArray();
                
                $reviews = $db->table('reviews')
                    ->select('reviews.*, books.title, books.cover_image, \'review\' as type', false)
                    ->join('books', 'books.id = reviews.book_id')
                    ->where('reviews.user_id', $userId)
                    ->orderBy('reviews.created_at', 'DESC')
                    ->limit(10)
                    ->get()->getResultArray();
                
                $activities = array_merge($bookshelf, $reviews);
                usort($activities, function($a, $b) {
                    $timeA = isset($a['created_at']) ? strtotime($a['created_at']) : strtotime($a['updated_at']);
                    $timeB = isset($b['created_at']) ? strtotime($b['created_at']) : strtotime($b['updated_at']);
                    return $timeB - $timeA; // DESC
                });
                $data = ['activities' => array_slice($activities, 0, 10)];
                return view('user/tabs/activity', $data);

            case 'books':
                // Books with status 'read'
                $books = $db->table('user_bookshelf_details')
                    ->select('user_bookshelf_details.*, books.title, books.cover_image')
                    ->join('books', 'books.id = user_bookshelf_details.book_id')
                    ->where('user_bookshelf_details.user_id', $userId)
                    ->where('user_bookshelf_details.status', 'read')
                    ->orderBy('user_bookshelf_details.read_end_date', 'DESC')
                    ->get()->getResultArray();
                return view('user/tabs/books', ['books' => $books]);

            case 'bookshelf':
                // All categorized
                $bookshelfItems = $db->table('user_bookshelf_details')
                    ->select('user_bookshelf_details.*, books.title, books.cover_image')
                    ->join('books', 'books.id = user_bookshelf_details.book_id')
                    ->where('user_bookshelf_details.user_id', $userId)
                    ->orderBy('user_bookshelf_details.updated_at', 'DESC')
                    ->get()->getResultArray();
                return view('user/tabs/bookshelf', ['books' => $bookshelfItems]);

            case 'diary':
                // Logs from reading_trackers
                $diary = $db->table('reading_trackers')
                    ->select('reading_trackers.*, books.title, books.cover_image')
                    ->join('books', 'books.id = reading_trackers.book_id')
                    ->where('reading_trackers.user_id', $userId)
                    ->orderBy('reading_trackers.updated_at', 'DESC')
                    ->get()->getResultArray();
                return view('user/tabs/diary', ['diary' => $diary]);

            case 'reviews':
                $reviews = $db->table('reviews')
                    ->select('reviews.*, books.title, books.cover_image')
                    ->join('books', 'books.id = reviews.book_id')
                    ->where('reviews.user_id', $userId)
                    ->orderBy('reviews.created_at', 'DESC')
                    ->get()->getResultArray();
                return view('user/tabs/reviews', ['reviews' => $reviews]);

            case 'wishlist':
                $wishlist = $db->table('wishlists')
                    ->select('wishlists.*, books.title, books.cover_image')
                    ->join('books', 'books.id = wishlists.book_id')
                    ->where('wishlists.user_id', $userId)
                    ->orderBy('wishlists.created_at', 'DESC')
                    ->get()->getResultArray();
                return view('user/tabs/wishlist', ['wishlist' => $wishlist]);

            case 'tickets':
                $userId = session()->get('user_id');
                if (!$userId) return "Unauthorized";

                $roomBookings = $db->table('roombookings')
                    ->where('user_id', $userId)
                    ->whereIn('status', ['approved', 'active'])
                    ->orderBy('booking_date', 'DESC')
                    ->get()->getResultArray();
                    
                $classRegistrations = $db->table('language_classes')
                    ->where('user_id', $userId)
                    ->whereIn('status', ['registered', 'approved', 'active'])
                    ->get()->getResultArray();
                    
                return view('user/tabs/tickets', [
                    'roomBookings' => $roomBookings,
                    'classRegistrations' => $classRegistrations
                ]);

            case 'lists':
                $lists = $db->table('user_lists')->where('user_id', $userId)->orderBy('created_at', 'DESC')->get()->getResultArray();
                return view('user/tabs/lists', ['lists' => $lists]);

            case 'likes':
                $likes = $db->table('favorite_books')
                    ->select('favorite_books.*, books.title, books.cover_image')
                    ->join('books', 'books.id = favorite_books.book_id')
                    ->where('favorite_books.user_id', $userId)
                    ->orderBy('favorite_books.created_at', 'DESC')
                    ->get()->getResultArray();
                return view('user/tabs/likes', ['likes' => $likes]);

            case 'my-journal':
                $myJournals = $db->table('journals')
                    ->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->get()->getResultArray();
                return view('user/tabs/my-journal', ['myJournals' => $myJournals]);

            case 'profile':
            default:
                $userModel = new \App\Models\UserModel();
                $loanModel = new \App\Models\LoanModel();
                
                // Ambil data follower/following asli dari DB
                $followersCount = $db->table('user_follows')->where('following_id', $userId)->countAllResults();
                $followingCount = $db->table('user_follows')->where('follower_id', $userId)->countAllResults();
                
                // Ambil buku favorit dari DB
                $favoriteBooks = $db->table('favorite_books')
                                    ->select('books.*')
                                    ->join('books', 'books.id = favorite_books.book_id')
                                    ->where('favorite_books.user_id', $userId)
                                    ->limit(4)
                                    ->get()->getResultArray();
                
                // Ambil denda user yang belum dibayar
                $fineModel = new \App\Models\FineModel();
                $unpaidFines = $fineModel->where('user_id', $userId)->where('status', 'unpaid')->findAll();

                // Layanan Tambahan User
                $refModel = new \App\Models\ReferenceLoanModel();
                $citModel = new \App\Models\CitationCheckModel();
                $consModel = new \App\Models\ConsultationModel();
                $mendeleyModel = new \App\Models\MendeleyClassModel();
                $langModel = new \App\Models\LanguageClassModel();
                $roomModel = new \App\Models\RoomBookingModel();

                $myServices = [
                    'referensi' => $refModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
                    'sitasi'    => $citModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
                    'konsultasi'=> $consModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
                    'mendeley'  => $mendeleyModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
                    'language'  => $langModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
                    'room'      => $roomModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll()
                ];

                $data = [
                    'user'  => $userModel->find($userId),
                    'stats' => $loanModel->getUserStats($userId),
                    'favoriteBooks'  => $favoriteBooks,
                    'followersCount' => $followersCount,
                    'followingCount' => $followingCount,
                    'unpaidFines'    => $unpaidFines,
                    'myServices'     => $myServices
                ];
                return view('user/tabs/profile', $data);
        }
    }
}
