<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReadingRoomModel;
use App\Models\RoomParticipantModel;

class ReadingRoomController extends BaseController
{
    protected $roomModel;
    protected $participantModel;

    public function __construct()
    {
        $this->roomModel = new ReadingRoomModel();
        $this->participantModel = new RoomParticipantModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Reading Rooms',
            'rooms' => $this->roomModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('user/reading_rooms/index', $data);
    }

    public function join($roomId)
    {
        $room = $this->roomModel->find($roomId);
        if (!$room) {
            return redirect()->to('/reading-rooms')->with('error', 'Ruangan tidak ditemukan.');
        }

        // Check if already joined
        $userId = session()->get('user_id');
        $isJoined = $this->participantModel->where('room_id', $roomId)->where('user_id', $userId)->first();
        if ($isJoined) {
            return redirect()->to('/reading-rooms/room/' . $roomId);
        }

        $data = [
            'title' => 'Join ' . $room['title'],
            'room'  => $room
        ];
        return view('user/reading_rooms/register', $data);
    }

    public function processJoin($roomId)
    {
        $userId = session()->get('user_id');
        $reason = $this->request->getPost('join_reason');

        $this->participantModel->insert([
            'room_id'     => $roomId,
            'user_id'     => $userId,
            'join_reason' => $reason,
            'joined_at'   => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/reading-rooms/room/' . $roomId)->with('success', 'Berhasil bergabung ke Reading Room.');
    }

    public function room($roomId)
    {
        $userId = session()->get('user_id');
        $isJoined = $this->participantModel->where('room_id', $roomId)->where('user_id', $userId)->first();

        if (!$isJoined) {
            return redirect()->to('/reading-rooms/join/' . $roomId)->with('error', 'Silakan mendaftar terlebih dahulu.');
        }

        $room = $this->roomModel->find($roomId);
        $data = [
            'title' => $room['title'],
            'room'  => $room
        ];

        return view('user/reading_rooms/room', $data);
    }
}
