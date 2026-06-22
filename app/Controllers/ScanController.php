<?php

namespace App\Controllers;

use App\Models\FineModel;
use App\Models\RoomBookingModel;
use App\Models\MendeleyClassModel;
use App\Models\LanguageClassModel;

class ScanController extends BaseController
{
    // Mobile Scan Endpoints (Updates Status & Shows Success Page)
    
    public function scanFine($id)
    {
        $fineModel = new FineModel();
        $fineModel->update($id, ['status' => 'paid', 'payment_date' => date('Y-m-d')]);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Pembayaran berhasil dikonfirmasi.']);
        }

        return view('scan_success', [
            'title' => 'Pembayaran Berhasil',
            'message' => 'Pembayaran denda Anda telah berhasil diverifikasi secara otomatis.'
        ]);
    }

    public function scanRoomBooking($id)
    {
        $bookingModel = new RoomBookingModel();
        $booking = $bookingModel->find($id);
        if ($booking) {
            $bookingModel->update($id, ['status' => 'active']);
        }
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Ruangan telah digunakan.']);
        }

        return view('scan_success', [
            'title' => 'Check-in Ruangan Berhasil',
            'message' => 'Booking ruangan Anda telah diverifikasi. Selamat menggunakan ruangan!'
        ]);
    }

    public function scanMendeley($id)
    {
        $mendeleyModel = new MendeleyClassModel();
        $mendeleyModel->update($id, ['status' => 'Attended']);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Check-in Mendeley berhasil.']);
        }

        return view('scan_success', [
            'title' => 'Check-in Kelas Mendeley Berhasil',
            'message' => 'Kehadiran Anda di Kelas Mendeley telah tercatat.'
        ]);
    }

    public function scanLanguage($id)
    {
        $languageModel = new LanguageClassModel();
        $languageModel->update($id, ['status' => 'Attended']);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Check-in Bahasa berhasil.']);
        }

        return view('scan_success', [
            'title' => 'Check-in Kelas Bahasa Berhasil',
            'message' => 'Kehadiran Anda di Kelas Bahasa telah tercatat.'
        ]);
    }

    // Desktop Polling Endpoints (Returns JSON for real-time update)
    
    public function apiCheckFine($id)
    {
        $fineModel = new FineModel();
        $fine = $fineModel->find($id);
        return $this->response->setJSON(['status' => $fine['status'] ?? '']);
    }

    public function apiCheckRoomBooking($id)
    {
        $bookingModel = new RoomBookingModel();
        $booking = $bookingModel->find($id);
        
        // Auto-complete logic based on end_time
        if ($booking && in_array($booking['status'], ['approved', 'active'])) {
            $currentDate = date('Y-m-d');
            $currentTime = date('H:i:s');
            
            // If the booking date is in the past, or it's today and end time has passed
            if ($booking['booking_date'] < $currentDate || ($booking['booking_date'] == $currentDate && $booking['end_time'] < $currentTime)) {
                $bookingModel->update($id, ['status' => 'completed']);
                $booking['status'] = 'completed';
            }
        }
        
        return $this->response->setJSON(['status' => $booking['status'] ?? '']);
    }

    public function apiCheckMendeley($id)
    {
        $mendeleyModel = new MendeleyClassModel();
        $class = $mendeleyModel->find($id);
        return $this->response->setJSON(['status' => $class['status'] ?? '']);
    }

    public function apiCheckLanguage($id)
    {
        $languageModel = new LanguageClassModel();
        $class = $languageModel->find($id);
        return $this->response->setJSON(['status' => $class['status'] ?? '']);
    }
}
