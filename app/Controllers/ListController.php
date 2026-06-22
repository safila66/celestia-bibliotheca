<?php

namespace App\Controllers;

use App\Models\UserListModel;
use App\Models\UserListItemModel;
use App\Models\BookModel;

class ListController extends BaseController
{
    protected $listModel;
    protected $listItemModel;
    protected $bookModel;

    public function __construct()
    {
        $this->listModel = new UserListModel();
        $this->listItemModel = new UserListItemModel();
        $this->bookModel = new BookModel();
    }

    public function create()
    {
        if (!$this->request->isAJAX()) return;

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu.']);
        }

        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $isPublic = $this->request->getPost('is_public') == '1' ? 1 : 0;

        if (empty($title)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Judul list tidak boleh kosong.']);
        }

        $this->listModel->save([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'is_public' => $isPublic,
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'List berhasil dibuat.']);
    }

    public function detail($id)
    {
        $userId = session()->get('user_id');
        $list = $this->listModel->find($id);

        if (!$list) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('List tidak ditemukan.');
        }

        if (!$list['is_public'] && $list['user_id'] != $userId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('List ini bersifat privat.');
        }

        $items = $this->listItemModel
            ->select('user_list_items.*, books.title as book_title, books.author, books.cover_image, books.description')
            ->join('books', 'books.id = user_list_items.book_id')
            ->where('list_id', $id)
            ->orderBy('added_at', 'DESC')
            ->findAll();

        $data = [
            'title' => $list['title'],
            'list' => $list,
            'items' => $items,
            'isOwner' => ($list['user_id'] == $userId)
        ];

        return view('user/list_detail', $data);
    }

    public function addBook()
    {
        if (!$this->request->isAJAX()) return;

        $userId = session()->get('user_id');
        $listId = $this->request->getPost('list_id');
        $bookId = $this->request->getPost('book_id');

        if (!$userId) return $this->response->setJSON(['success' => false, 'message' => 'Unauthenticated']);

        $list = $this->listModel->find($listId);
        if (!$list || $list['user_id'] != $userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'List tidak valid.']);
        }

        // Check if book already in list
        $exists = $this->listItemModel->where('list_id', $listId)->where('book_id', $bookId)->first();
        if ($exists) {
            return $this->response->setJSON(['success' => false, 'message' => 'Buku sudah ada di list ini.']);
        }

        $this->listItemModel->save([
            'list_id' => $listId,
            'book_id' => $bookId,
            'added_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Buku berhasil ditambahkan ke list.']);
    }

    public function removeBook($id)
    {
        $userId = session()->get('user_id');
        $item = $this->listItemModel->find($id);

        if (!$item) return redirect()->back()->with('error', 'Item tidak ditemukan.');

        $list = $this->listModel->find($item['list_id']);
        if (!$list || $list['user_id'] != $userId) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $this->listItemModel->delete($id);
        return redirect()->back()->with('success', 'Buku berhasil dihapus dari list.');
    }

    public function deleteList($id)
    {
        $userId = session()->get('user_id');
        $list = $this->listModel->find($id);

        if (!$list || $list['user_id'] != $userId) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        // Delete all items first
        $this->listItemModel->where('list_id', $id)->delete();
        $this->listModel->delete($id);

        return redirect()->to('/profil')->with('success', 'List berhasil dihapus.');
    }
}
