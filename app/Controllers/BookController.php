<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookModel; 
use App\Models\ReviewModel;
use App\Models\ReadingTrackerModel;

class BookController extends BaseController
{
    protected $bookModel;
    protected $reviewModel;
    protected $trackerModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->reviewModel = new ReviewModel();
        $this->trackerModel = new ReadingTrackerModel();
    }

    public function detail($id = null)
    {
        $data['book'] = $this->bookModel->find($id);
        
        if (!$data['book']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku tidak ditemukan di arsip.");
        }
        
        // Fetch Reviews
        $reviews = $this->reviewModel->getReviewsWithUser($id);
        $data['reviews'] = $reviews;
        $totalRating = 0;
        foreach ($reviews as $r) {
            $totalRating += $r['rating'];
        }
        $data['avg_rating'] = count($reviews) > 0 ? round($totalRating / count($reviews), 1) : 0;
        
        // Calculate Moods
        $moodCounts = [];
        $totalMoods = 0;
        foreach ($reviews as $r) {
            if (!empty($r['moods'])) {
                $mList = explode(',', $r['moods']);
                foreach ($mList as $m) {
                    $m = trim($m);
                    if (!isset($moodCounts[$m])) $moodCounts[$m] = 0;
                    $moodCounts[$m]++;
                    $totalMoods++;
                }
            }
        }
        
        $moodsPercent = [];
        if ($totalMoods > 0) {
            foreach ($moodCounts as $m => $count) {
                $moodsPercent[$m] = round(($count / $totalMoods) * 100);
            }
            arsort($moodsPercent);
        }
        $data['moods'] = $moodsPercent;

        // Stats Calculation
        $stats = [
            'pace' => ['fast' => 0, 'medium' => 0, 'slow' => 0],
            'plot_char' => ['plot' => 0, 'mix' => 0, 'character' => 0],
            'dev' => ['yes' => 0, 'complicated' => 0, 'no' => 0],
            'lov' => ['yes' => 0, 'complicated' => 0, 'no' => 0],
            'div' => ['yes' => 0, 'complicated' => 0, 'no' => 0],
        ];
        
        $totalStats = 0;
        foreach ($reviews as $r) {
            if (!empty($r['pace'])) {
                $totalStats++;
                if (isset($stats['pace'][$r['pace']])) $stats['pace'][$r['pace']]++;
                if (isset($stats['plot_char'][$r['plot_or_character']])) $stats['plot_char'][$r['plot_or_character']]++;
                if (isset($stats['dev'][$r['strong_dev']])) $stats['dev'][$r['strong_dev']]++;
                if (isset($stats['lov'][$r['loveable']])) $stats['lov'][$r['loveable']]++;
                if (isset($stats['div'][$r['diverse']])) $stats['div'][$r['diverse']]++;
            }
        }
        $data['stats'] = $stats;
        $data['total_stats'] = $totalStats;
        
        if (session()->get('user_id')) {
            $userId = session()->get('user_id');
            
            $wishlistModel = new \App\Models\WishlistModel();
            $data['inWishlist'] = $wishlistModel->where('user_id', $userId)->where('book_id', $id)->first() ? true : false;
            
            $data['tracker'] = $this->trackerModel->getTracker($userId, $id);
            
            $userListModel = new \App\Models\UserListModel();
            $data['userLists'] = $userListModel->where('user_id', $userId)->findAll();
            
            return view('user/book_storygraph', $data);
        } else {
            return view('user/bookdetail', $data);
        }
    }

    public function submitReview($id)
    {
        $userId = session()->get('user_id');
        if (!$userId) return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);

        $ratingInput = $this->request->getPost('rating');
        if ($ratingInput !== null) {
            $rating = floatval($ratingInput);
        } else {
            $ratingWhole = $this->request->getPost('rating_whole') ?? 0;
            $ratingFraction = $this->request->getPost('rating_fraction') ?? '.00';
            $rating = floatval($ratingWhole . $ratingFraction);
        }

        $reviewText = $this->request->getPost('review_text');
        $moods = $this->request->getPost('moods');

        $this->reviewModel->insert([
            'book_id' => $id,
            'user_id' => $userId,
            'rating' => $rating,
            'review_text' => $reviewText,
            'moods' => $moods ? implode(',', $moods) : '',
            'pace' => $this->request->getPost('pace'),
            'plot_or_character' => $this->request->getPost('plot_or_character'),
            'strong_dev' => $this->request->getPost('strong_dev'),
            'loveable' => $this->request->getPost('loveable'),
            'diverse' => $this->request->getPost('diverse'),
            'flaws_focus' => $this->request->getPost('flaws_focus'),
            'themes' => $this->request->getPost('themes'),
            'content_warnings' => $this->request->getPost('content_warnings'),
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Review submitted!']);
        }
        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    public function updateTracker($id)
    {
        $userId = session()->get('user_id');
        if (!$userId) return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);

        $status = $this->request->getPost('status');
        $progress = $this->request->getPost('progress') ?? 0;
        
        $day = $this->request->getPost('started_day');
        $month = $this->request->getPost('started_month');
        $year = $this->request->getPost('started_year');
        $startedAt = null;
        if (!empty($day) && !empty($month) && !empty($year)) {
            $startedAt = "$year-$month-$day";
        }

        $existing = $this->trackerModel->getTracker($userId, $id);
        if ($existing) {
            if ($status === 'remove') {
                $this->trackerModel->delete($existing['id']);
            } else {
                $this->trackerModel->update($existing['id'], [
                    'status' => $status,
                    'progress' => $progress,
                    'started_at' => $startedAt
                ]);
            }
        } else {
            if ($status !== 'remove') {
                $this->trackerModel->insert([
                    'user_id' => $userId,
                    'book_id' => $id,
                    'status' => $status,
                    'progress' => $progress,
                    'started_at' => $startedAt
                ]);
            }
        }

        return $this->response->setJSON(['status' => 'success']);
    }
}