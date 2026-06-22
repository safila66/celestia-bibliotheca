<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserFollowModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $userFollowModel = new UserFollowModel();
        $currentUserId = session()->get('user_id');

        $query = $this->request->getGet('q');
        
        $builder = $userModel->where('role', 'user')->where('status', 'active');
        
        if (!empty($query)) {
            $builder->like('name', $query);
        }

        $users = $builder->orderBy('name', 'ASC')->findAll();

        // Check follow status for each user
        foreach ($users as &$user) {
            $user['is_following'] = $currentUserId ? $userFollowModel->isFollowing($currentUserId, $user['id']) : false;
        }

        $data = [
            'title' => 'Readers Community',
            'users' => $users,
            'searchQuery' => $query
        ];

        return view('user/readers/index', $data);
    }

    public function publicProfile($id)
    {
        $userModel = new UserModel();
        $userFollowModel = new UserFollowModel();
        $db = \Config\Database::connect();
        $currentUserId = session()->get('user_id');

        $user = $userModel->find($id);
        
        if (!$user || $user['role'] !== 'user' || $user['status'] !== 'active') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        // Fetch stats
        $booksRead = $db->table('reading_trackers')
            ->where('user_id', $id)
            ->where('status', 'read')
            ->countAllResults();

        $booksThisYear = $db->table('reading_trackers')
            ->where('user_id', $id)
            ->where('status', 'read')
            ->where('YEAR(updated_at)', date('Y'))
            ->countAllResults();

        $wishlistCount = $db->table('wishlist')
            ->where('user_id', $id)
            ->countAllResults();

        $followingCount = $db->table('user_follows')->where('follower_id', $id)->countAllResults();
        $followersCount = $db->table('user_follows')->where('following_id', $id)->countAllResults();

        // Get reviews
        $reviews = $db->table('reviews')
            ->select('reviews.*, books.title, books.cover_image')
            ->join('books', 'books.id = reviews.book_id')
            ->where('reviews.user_id', $id)
            ->orderBy('reviews.created_at', 'DESC')
            ->limit(10)
            ->get()->getResultArray();

        $isFollowing = $currentUserId ? $userFollowModel->isFollowing($currentUserId, $id) : false;

        $data = [
            'title' => esc($user['name']) . ' - Profile',
            'user' => $user,
            'stats' => [
                'read' => $booksRead,
                'this_year' => $booksThisYear,
                'wishlist' => $wishlistCount,
                'following' => $followingCount,
                'followers' => $followersCount
            ],
            'reviews' => $reviews,
            'isFollowing' => $isFollowing,
            'currentUserId' => $currentUserId
        ];

        return view('user/readers/public_profile', $data);
    }

    public function toggleFollow($followedId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setBody('Direct access not allowed');
        }

        $followerId = session()->get('user_id');
        if (!$followerId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Please login first.']);
        }

        if ($followerId == $followedId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'You cannot follow yourself.']);
        }

        $userFollowModel = new UserFollowModel();
        $isFollowingNow = $userFollowModel->toggleFollow($followerId, $followedId);

        return $this->response->setJSON([
            'status' => 'success',
            'isFollowing' => $isFollowingNow,
            'message' => $isFollowingNow ? 'Followed user.' : 'Unfollowed user.'
        ]);
    }
}
