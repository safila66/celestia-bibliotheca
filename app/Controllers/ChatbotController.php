<?php

namespace App\Controllers;

class ChatbotController extends BaseController
{
    public function ask()
    {
        $input = $this->request->getJSON();
        $message = strtolower($input->message ?? '');
        
        // Simple heuristic library chatbot logic
        $response = "Maaf, aku tidak mengerti pertanyaanmu. Coba tanyakan tentang jam buka, cara pinjam buku, atau layanan kami.";
        
        if (strpos($message, 'jam buka') !== false || strpos($message, 'operasional') !== false) {
            $response = "Celestia Bibliotheca buka setiap Senin-Jumat (08:00 - 20:00) dan Sabtu (09:00 - 15:00). Minggu kami tutup untuk pemeliharaan konstelasi pengetahuan.";
        } elseif (strpos($message, 'pinjam') !== false || strpos($message, 'buku') !== false) {
            $response = "Untuk meminjam buku, kamu bisa mencari di Katalog dan memencet tombol 'Pinjam', atau gunakan layanan Book Delivery jika ingin dikirim langsung ke rumahmu!";
        } elseif (strpos($message, 'ai') !== false || strpos($message, 'sitasi') !== false) {
            $response = "Ya! Kami menyediakan alat Pengecekan Sitasi & AI secara nyata menggunakan algoritma pemrosesan bahasa khusus di layanan 'Panduan Sitasi'.";
        } elseif (strpos($message, 'halo') !== false || strpos($message, 'hai') !== false) {
            $response = "Halo! Saya adalah Asisten AI Celestia. Ada yang bisa saya bantu terkait penelusuran pustaka hari ini?";
        } elseif (strpos($message, 'ruang') !== false || strpos($message, 'booking') !== false || strpos($message, 'baca') !== false) {
            $response = "Kamu bisa memesan ruang baca eksklusif (seperti Private Room atau Meeting Room) melalui tab Layanan Anggota > Room Booking.";
        }

        // Simulate a slight delay for realism
        sleep(1);

        return $this->response->setJSON(['reply' => $response]);
    }
}
