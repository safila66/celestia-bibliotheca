<?php

namespace App\Controllers;

class ServiceController extends BaseController
{
    public function index()
    {
        $bookModel = new \App\Models\BookModel();
        $deliveryModel = new \App\Models\DeliveryModel();
        $roomModel = new \App\Models\RoomBookingModel();
        $refLoanModel = new \App\Models\ReferenceLoanModel();
        $citationModel = new \App\Models\CitationCheckModel();
        $mendeleyModel = new \App\Models\MendeleyClassModel();
        $consultationModel = new \App\Models\ConsultationModel();
        $langModel = new \App\Models\LanguageClassModel();
        
        $userId = session()->get('user_id');

        $availableBooks = $bookModel->where('stock_available >', 0)->findAll();
        $userDeliveries = $userId ? $deliveryModel->select('deliveries.*, books.title as book_title, books.cover_image, books.author')->join('books', 'books.id = deliveries.book_id')->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll() : [];

        $rooms = [
            ['id' => 'common', 'name' => 'Common Room', 'capacity' => 12, 'image' => 'common_room.png'],
            ['id' => 'private', 'name' => 'Private Room', 'capacity' => 2, 'image' => 'private_room.png'],
            ['id' => 'meeting', 'name' => 'Meeting Room', 'capacity' => 15, 'image' => 'meeting_room.png'],
            ['id' => 'class', 'name' => 'Class Room', 'capacity' => 150, 'image' => 'class_room.png'],
            ['id' => 'artwork', 'name' => 'Artwork Room', 'capacity' => 8, 'image' => 'artwork_room.png'],
        ];
        $userBookings = $userId ? $roomModel->where('user_id', $userId)->orderBy('booking_date', 'DESC')->findAll() : [];

        $librarians = [
            ['name' => 'Dr. Arina Widiastuti, M.Hum.', 'specialty' => 'Humaniora & Sejarah', 'schedule' => 'Senin & Rabu (09:00 - 14:00)'],
            ['name' => 'Bima Sanjaya, M.Si.', 'specialty' => 'Sains & Teknologi', 'schedule' => 'Selasa & Kamis (10:00 - 15:00)'],
            ['name' => 'Prof. Kartika Sari', 'specialty' => 'Ilmu Sosial & Hukum', 'schedule' => 'Jumat (08:00 - 11:30)'],
        ];
        // Fetch reference books from DB (IDs 901-906)
        $referenceBooks = $bookModel->whereIn('id', [901, 902, 903, 904, 905, 906])->findAll();
        if(empty($referenceBooks)) {
            // Fallback if not seeded
            $referenceBooks = $bookModel->limit(6)->findAll();
        }
        $myLoans = $userId ? $refLoanModel->select('reference_loans.*, books.title, books.cover_image')->join('books', 'books.id = reference_loans.book_id', 'left')->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll() : [];

        $myChecks = $userId ? $citationModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll() : [];
        $myClasses = $userId ? $mendeleyModel->where('user_id', $userId)->orderBy('schedule_date', 'DESC')->findAll() : [];
        $myConsultations = $userId ? $consultationModel->where('user_id', $userId)->orderBy('consultation_date', 'DESC')->findAll() : [];
        $myLangClasses = $userId ? $langModel->where('user_id', $userId)->orderBy('schedule_date', 'DESC')->findAll() : [];

        return view('user/services/index', [
            'title' => 'Layanan Anggota',
            'availableBooks' => $availableBooks, 'userDeliveries' => $userDeliveries,
            'rooms' => $rooms, 'userBookings' => $userBookings,
            'librarians' => $librarians, 'referenceBooks' => $referenceBooks, 'myLoans' => $myLoans,
            'myChecks' => $myChecks, 'myClasses' => $myClasses,
            'myConsultations' => $myConsultations, 'myLangClasses' => $myLangClasses
        ]);
    }

    public function seed()
    {
        $db = \Config\Database::connect();
        $sql = "INSERT INTO `books` (`id`, `title`, `author`, `category_id`, `description`, `isbn`, `year`, `stock_total`, `stock_available`, `cover_image`, `created_at`, `updated_at`) VALUES
        (901, 'Kamus Besar Bahasa Indonesia (KBBI) Edisi V', 'Badan Pengembangan Bahasa', 1, 'Kamus resmi bahasa Indonesia.', '978-979-111-111-1', 2016, 5, 5, 'kbbi.jpg', '2026-06-20 10:00:00', '2026-06-20 10:00:00'),
        (902, 'Encyclopedia Britannica', 'Britannica Editors', 1, 'Ensiklopedia pengetahuan umum internasional.', '978-979-222-222-2', 2020, 2, 2, 'britannica.jpg', '2026-06-20 10:00:00', '2026-06-20 10:00:00'),
        (903, 'Oxford Advanced Learner''s Dictionary', 'A. S. Hornby', 5, 'Kamus bahasa Inggris tingkat lanjut.', '978-979-333-333-3', 2022, 10, 10, 'oxford.jpg', '2026-06-20 10:00:00', '2026-06-20 10:00:00'),
        (904, 'Atlas Dunia & Geografi Nasional', 'Bakti Pertiwi', 9, 'Atlas lengkap geografis dunia.', '978-979-444-444-4', 2019, 4, 4, 'atlas.jpg', '2026-06-20 10:00:00', '2026-06-20 10:00:00'),
        (905, 'The Chicago Manual of Style', 'University of Chicago', 10, 'Panduan gaya penulisan dan sitasi standar.', '978-979-555-555-5', 2017, 3, 3, 'chicago.jpg', '2026-06-20 10:00:00', '2026-06-20 10:00:00'),
        (906, 'Buku Pintar Seri Senior', 'Iwan Gayo', 1, 'Kumpulan pengetahuan umum populer.', '978-979-666-666-6', 2015, 6, 6, 'pintar.jpg', '2026-06-20 10:00:00', '2026-06-20 10:00:00')
        ON DUPLICATE KEY UPDATE title=VALUES(title);";
        $db->query($sql);
        return 'Seeded reference books!';
    }

    public function bookDelivery()
    {
        $bookModel = new \App\Models\BookModel();
        $deliveryModel = new \App\Models\DeliveryModel();

        // Ambil buku fisik saja (file_pdf is null)
        $availableBooks = $bookModel->where('file_pdf', null)->findAll();

        $userDeliveries = [];
        if (session()->get('user_id')) {
            $userDeliveries = $deliveryModel->select('deliveries.*, books.title as book_title, books.cover_image, books.author')
                                            ->join('books', 'books.id = deliveries.book_id')
                                            ->where('user_id', session()->get('user_id'))
                                            ->orderBy('created_at', 'DESC')
                                            ->findAll();
        }

        return view('user/services/book_delivery', [
            'title' => 'Book Delivery',
            'availableBooks' => $availableBooks,
            'userDeliveries' => $userDeliveries
        ]);
    }
    public function requestDelivery()
    {
        $deliveryModel = new \App\Models\DeliveryModel();
        $loanModel = new \App\Models\LoanModel();
        
        // Randomly generate tracking number for mockup purposes
        $trackingNumber = 'CB-' . strtoupper(substr(md5(uniqid()), 0, 8));

        // Insert into deliveries
        $deliveryModel->save([
            'user_id' => session()->get('user_id'),
            'book_id' => $this->request->getPost('book_id'),
            'delivery_address' => $this->request->getPost('address'),
            'status' => 'pending',
            'tracking_number' => $trackingNumber
        ]);

        // Integrate with Sirkulasi Peminjaman (loans)
        $loanModel->save([
            'user_id' => session()->get('user_id'),
            'book_id' => $this->request->getPost('book_id'),
            'status'  => 'pending'
        ]);

        return redirect()->to('/book-delivery')->with('success', 'Permintaan delivery berhasil diajukan dan terintegrasi dengan Sirkulasi Peminjaman.');
    }

    public function roomBooking()
    {
        $roomModel = new \App\Models\RoomBookingModel();
        
        $rooms = [
            ['id' => 'common', 'name' => 'Common Room', 'capacity' => 12, 'image' => 'common_room.png'],
            ['id' => 'private', 'name' => 'Private Room', 'capacity' => 2, 'image' => 'private_room.png'],
            ['id' => 'meeting', 'name' => 'Meeting Room', 'capacity' => 15, 'image' => 'meeting_room.png'],
            ['id' => 'class', 'name' => 'Class Room', 'capacity' => 150, 'image' => 'class_room.png'],
            ['id' => 'artwork', 'name' => 'Artwork Room', 'capacity' => 8, 'image' => 'artwork_room.png']
        ];

        $userBookings = [];
        if (session()->get('user_id')) {
            $userBookings = $roomModel->where('user_id', session()->get('user_id'))
                                      ->orderBy('booking_date', 'DESC')
                                      ->findAll();
        }

        return view('user/services/room_booking', [
            'title' => 'Booking Ruang Baca',
            'rooms' => $rooms,
            'userBookings' => $userBookings
        ]);
    }

    public function bookRoom()
    {
        $roomModel = new \App\Models\RoomBookingModel();
        
        $roomName = $this->request->getPost('room_name');
        $date = $this->request->getPost('booking_date');
        $start = $this->request->getPost('start_time');
        $end = $this->request->getPost('end_time');

        // Validasi bentrok jadwal
        // Booking bertabrakan jika: (start_baru < end_lama) AND (end_baru > start_lama)
        $conflicts = $roomModel->where('room_name', $roomName)
                               ->where('booking_date', $date)
                               ->where('status !=', 'cancelled')
                               ->where('status !=', 'rejected')
                               ->where('start_time <', $end)
                               ->where('end_time >', $start)
                               ->countAllResults();

        if ($conflicts > 0) {
            return redirect()->to('/room-booking')->with('error', 'Gagal booking: Ruangan sudah dipakai pada rentang waktu tersebut.');
        }

        $roomModel->save([
            'user_id' => session()->get('user_id'),
            'room_name' => $roomName,
            'booking_date' => $date,
            'start_time' => $start,
            'end_time' => $end,
            'purpose' => $this->request->getPost('purpose'),
            'status' => 'pending', // Menunggu persetujuan admin
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/room-booking')->with('success', 'Ruangan berhasil dibooking. Menunggu persetujuan admin.');
    }

    public function checkRoomAvailability()
    {
        $roomModel = new \App\Models\RoomBookingModel();
        $date = $this->request->getGetPost('date');
        $start = $this->request->getGetPost('start_time');
        $end = $this->request->getGetPost('end_time');

        if (!$date || !$start || !$end) {
            return $this->response->setJSON(['booked_rooms' => []]);
        }

        $bookings = $roomModel->select('room_name')
                              ->where('booking_date', $date)
                              ->where('status !=', 'cancelled')
                              ->where('status !=', 'rejected')
                              ->where('start_time <', $end)
                              ->where('end_time >', $start)
                              ->findAll();

        $bookedRooms = array_map(function($b) { return $b['room_name']; }, $bookings);
        return $this->response->setJSON(['booked_rooms' => array_unique($bookedRooms)]);
    }



    public function referensi()
    {
        $journalModel = new \App\Models\JournalModel();
        $refLoanModel = new \App\Models\ReferenceLoanModel();
        
        $librarians = [
            ['name' => 'Dr. Arina Widiastuti, M.Hum.', 'specialty' => 'Humaniora & Sejarah', 'schedule' => 'Senin & Rabu (09:00 - 14:00)'],
            ['name' => 'Bima Sanjaya, M.Si.', 'specialty' => 'Sains & Teknologi', 'schedule' => 'Selasa & Kamis (10:00 - 15:00)'],
            ['name' => 'Prof. Kartika Sari', 'specialty' => 'Ilmu Sosial & Hukum', 'schedule' => 'Jumat (08:00 - 11:30)'],
        ];

        $keyword = $this->request->getGet('q') ?? 'technology';

        // Fetch from CrossRef API instead of DOAJ (DOAJ was blocked by Cloudflare)
        $crossrefUrl = "https://api.crossref.org/works?query=" . urlencode($keyword) . "&filter=type:journal-article&rows=6";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $crossrefUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'CelestiaBibliotheca/1.0 (mailto:library@celestia.edu)');
        
        $response = curl_exec($ch);
        $curl_err = curl_error($ch);
        curl_close($ch);

        $doajArticles = [];
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['message']['items'])) {
                foreach ($data['message']['items'] as $res) {
                    $authors = [];
                    if (isset($res['author'])) {
                        foreach ($res['author'] as $a) {
                            $name = trim(($a['given'] ?? '') . ' ' . ($a['family'] ?? ''));
                            if ($name) $authors[] = $name;
                        }
                    }
                    $authorStr = !empty($authors) ? implode(', ', $authors) : 'Unknown Author';
                    
                    $title = $res['title'][0] ?? 'Untitled Article';
                    $journal = $res['container-title'][0] ?? 'Unknown Journal';
                    $year = $res['published-print']['date-parts'][0][0] ?? ($res['created']['date-parts'][0][0] ?? 'N/A');
                    
                    $abstract = $res['abstract'] ?? 'Tidak ada abstrak yang tersedia untuk artikel ini.';
                    $abstract = strip_tags($abstract);
                    
                    $link = $res['URL'] ?? '#';

                    $doajArticles[] = [
                        'id' => $res['DOI'] ?? uniqid(),
                        'title' => $title,
                        'author' => $authorStr,
                        'journal' => $journal,
                        'year' => $year,
                        'abstract' => $abstract,
                        'link' => $link
                    ];
                }
            }
        }
        
        $myLoans = [];
        if (session()->get('user_id')) {
            $myLoans = $refLoanModel->select('reference_loans.*, journals.title, journals.cover_image')
                                    ->join('journals', 'journals.id = reference_loans.book_id', 'left')
                                    ->where('reference_loans.user_id', session()->get('user_id'))
                                    ->orderBy('reference_loans.created_at', 'DESC')
                                    ->findAll();
        }

        $data = [
            'title' => 'Layanan Referensi & Penelusuran Jurnal',
            'librarians' => $librarians,
            'doajArticles' => $doajArticles,
            'myLoans' => $myLoans,
            'keyword' => $keyword,
            'curl_err' => $curl_err
        ];
        return view('user/services/referensi', $data);
    }

    public function borrowReference()
    {
        $refLoanModel = new \App\Models\ReferenceLoanModel();
        $refLoanModel->save([
            'user_id' => session()->get('user_id'),
            'book_id' => $this->request->getPost('book_id'),
            'type'    => $this->request->getPost('type'),
            'status'  => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/referensi')->with('success', 'Koleksi referensi berhasil ditambahkan ke akun Anda.');
    }

    public function sitasi()
    {
        $citationModel = new \App\Models\CitationCheckModel();
        
        $myChecks = [];
        if (session()->get('user_id')) {
            $myChecks = $citationModel->where('user_id', session()->get('user_id'))
                                      ->orderBy('created_at', 'DESC')
                                      ->findAll();
        }

        return view('user/services/sitasi', [
            'title' => 'Panduan Sitasi & Pengecekan AI',
            'myChecks' => $myChecks
        ]);
    }

    public function checkCitation()
    {
        $citationModel = new \App\Models\CitationCheckModel();
        
        $file = $this->request->getFile('document');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $filepath = WRITEPATH . 'uploads/' . $newName;
            
            // Execute the real python AI checker!
            $pythonScript = ROOTPATH . 'app/ThirdParty/ai_checker.py';
            $command = escapeshellcmd("python \"$pythonScript\" \"$filepath\"");
            $output = shell_exec($command);
            
            $aiPercentage = intval(trim($output));
            if($aiPercentage < 0) $aiPercentage = 0;
            if($aiPercentage > 100) $aiPercentage = 100;
        } else {
            return redirect()->to('/sitasi')->with('error', 'Gagal mengunggah dokumen.');
        }

        $citationModel->save([
            'user_id' => session()->get('user_id'),
            'title' => $this->request->getPost('title'),
            'file_path' => $newName ?? 'mock_document.pdf',
            'ai_percentage' => $aiPercentage,
            'status' => 'Checking', // Diperiksa Pustakawan
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/sitasi')->with('success', 'Dokumen berhasil diunggah. Sedang dalam antrean pengecekan AI dan Pustakawan.');
    }

    public function konsultasi()
    {
        $consultationModel = new \App\Models\ConsultationModel();
        
        $myConsultations = [];
        if (session()->get('user_id')) {
            $myConsultations = $consultationModel->where('user_id', session()->get('user_id'))
                                                 ->orderBy('consultation_date', 'DESC')
                                                 ->findAll();
        }

        return view('user/services/konsultasi', [
            'title' => 'Konsultasi Pustakawan (Umum)',
            'myConsultations' => $myConsultations
        ]);
    }

    public function bookConsultation()
    {
        $consultationModel = new \App\Models\ConsultationModel();
        
        $consultationModel->save([
            'user_id' => session()->get('user_id'),
            'topic' => $this->request->getPost('topic'),
            'consultation_date' => $this->request->getPost('consultation_date'),
            'consultation_time' => $this->request->getPost('consultation_time'),
            'notes' => $this->request->getPost('notes'),
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/konsultasi')->with('success', 'Jadwal konsultasi berhasil diajukan.');
    }

    public function mendeleyClass()
    {
        $mendeleyModel = new \App\Models\MendeleyClassModel();
        
        $myClasses = [];
        if (session()->get('user_id')) {
            $myClasses = $mendeleyModel->where('user_id', session()->get('user_id'))
                                       ->orderBy('schedule_date', 'DESC')
                                       ->findAll();
        }

        return view('user/services/mendeley_class', [
            'title' => 'Mendeley Class',
            'myClasses' => $myClasses
        ]);
    }

    public function registerMendeley()
    {
        $mendeleyModel = new \App\Models\MendeleyClassModel();
        
        $date = $this->request->getPost('schedule_date');
        $session = $this->request->getPost('session'); // Pagi / Sore
        
        $dayOfWeek = date('N', strtotime($date)); // 1=Mon, 3=Wed, 5=Fri
        
        if (!in_array($dayOfWeek, [1, 3, 5])) {
            return redirect()->back()->with('error', 'Mendeley Class hanya tersedia di hari Senin, Rabu, dan Jumat.');
        }

        $format = ($dayOfWeek == 5) ? 'Online' : 'Offline';
        $qrCode = null;
        $zoomLink = null;
        $zoomPasscode = null;

        if ($format == 'Online') {
            $zoomLink = 'https://zoom.us/j/' . rand(100000000, 999999999);
            $zoomPasscode = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        } else {
            $qrCode = 'QR-' . strtoupper(substr(md5(uniqid()), 0, 8));
        }

        $mendeleyModel->save([
            'user_id' => session()->get('user_id'),
            'schedule_date' => $date,
            'session' => $session,
            'format' => $format,
            'qr_code' => $qrCode,
            'zoom_link' => $zoomLink,
            'zoom_passcode' => $zoomPasscode,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/mendeley-class')->with('success', 'Berhasil mendaftar ke kelas Mendeley.');
    }

    public function languageClass()
    {
        $langModel = new \App\Models\LanguageClassModel();
        
        $myClasses = [];
        if (session()->get('user_id')) {
            $myClasses = $langModel->where('user_id', session()->get('user_id'))
                                   ->orderBy('schedule_date', 'DESC')
                                   ->findAll();
        }

        $languages = [
            ['id' => 'Cina', 'name' => 'Bahasa Cina', 'continent' => 'Asia', 'color' => '#E53935', 'image' => 'cina.jpg'],
            ['id' => 'Jepang', 'name' => 'Bahasa Jepang', 'continent' => 'Asia', 'color' => '#E91E63', 'image' => 'jepang.jpg'],
            ['id' => 'Thailand', 'name' => 'Bahasa Thailand', 'continent' => 'Asia', 'color' => '#8E24AA', 'image' => 'thailand.jpg'],
            ['id' => 'Korea', 'name' => 'Bahasa Korea', 'continent' => 'Asia', 'color' => '#3949AB', 'image' => 'korea.jpg'],
            ['id' => 'Indonesia', 'name' => 'Bahasa Indonesia', 'continent' => 'Asia', 'color' => '#00897B', 'image' => 'indonesia.jpg'],
            ['id' => 'Inggris', 'name' => 'Bahasa Inggris', 'continent' => 'Eropa', 'color' => '#1E88E5', 'image' => 'inggris.jpg'],
            ['id' => 'Spanyol', 'name' => 'Bahasa Spanyol', 'continent' => 'Eropa', 'color' => '#FDD835', 'image' => 'spanyol.jpg'],
            ['id' => 'Perancis', 'name' => 'Bahasa Perancis', 'continent' => 'Eropa', 'color' => '#039BE5', 'image' => 'perancis.jpg'],
            ['id' => 'Italia', 'name' => 'Bahasa Italia', 'continent' => 'Eropa', 'color' => '#43A047', 'image' => 'italia.jpg']
        ];

        return view('user/services/language_class', [
            'title' => 'Language Class',
            'myClasses' => $myClasses,
            'languages' => $languages
        ]);
    }

    public function languageClassDetail($lang)
    {
        $scheduleMap = [
            'Cina'      => ['days' => [1,3,5], 'time' => '08.00 - 10.30', 'room' => 'Ruang Asia 1'],
            'Jepang'    => ['days' => [1,3,5], 'time' => '08.00 - 10.30', 'room' => 'Ruang Asia 2'],
            'Thailand'  => ['days' => [1,3,5], 'time' => '11.00 - 13.30', 'room' => 'Ruang Asia 3'],
            'Korea'     => ['days' => [1,3,5], 'time' => '11.00 - 13.30', 'room' => 'Ruang Asia 4'],
            'Indonesia' => ['days' => [1,3,5], 'time' => '15.00 - 16.30', 'room' => 'Ruang Nusantara'],
            
            'Inggris'   => ['days' => [2,4,6], 'time' => '09.00 - 11.30', 'room' => 'Ruang Eropa 1'],
            'Spanyol'   => ['days' => [2,4,6], 'time' => '09.00 - 11.30', 'room' => 'Ruang Eropa 2'],
            'Perancis'  => ['days' => [2,4,6], 'time' => '13.00 - 15.30', 'room' => 'Ruang Eropa 3'],
            'Italia'    => ['days' => [2,4,6], 'time' => '13.00 - 15.30', 'room' => 'Ruang Eropa 4'],
        ];

        if (!isset($scheduleMap[$lang])) {
            return redirect()->to('/language-class')->with('error', 'Bahasa tidak ditemukan.');
        }

        // Generate next 14 days
        $upcomingDates = [];
        $today = new \DateTime();
        $daysIndo = [1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 7 => 'Min'];
        for ($i = 0; $i < 14; $i++) {
            $dt = clone $today;
            $dt->modify("+$i days");
            $dayNum = $dt->format('N');
            if (in_array($dayNum, $scheduleMap[$lang]['days'])) {
                $upcomingDates[] = [
                    'date' => $dt->format('Y-m-d'),
                    'dayName' => $i === 0 ? 'Hari Ini' : ($i === 1 ? 'Besok' : $daysIndo[$dayNum]),
                    'dayNum' => $dt->format('d'),
                    'month' => $dt->format('M')
                ];
            }
        }

        return view('user/services/language_class_detail', [
            'title' => 'Jadwal ' . $lang,
            'lang' => $lang,
            'schedule' => $scheduleMap[$lang],
            'upcomingDates' => $upcomingDates
        ]);
    }

    public function languageClassSeats()
    {
        $lang = $this->request->getGet('lang');
        $date = $this->request->getGet('date');
        $time = $this->request->getGet('time');

        if (!$lang || !$date || !$time) {
            return redirect()->to('/language-class')->with('error', 'Parameter tidak lengkap.');
        }

        $langModel = new \App\Models\LanguageClassModel();
        // Cari kursi yang sudah di-booking untuk kelas ini pada jadwal ini
        $booked = $langModel->where('language', $lang)
                            ->where('schedule_date', $date)
                            ->where('session_time', $time)
                            ->where('status !=', 'Cancelled')
                            ->findColumn('seat_number');
        
        $bookedSeats = $booked ? $booked : [];

        return view('user/services/language_class_seats', [
            'title' => 'Pilih Tempat Duduk',
            'lang' => $lang,
            'date' => $date,
            'time' => $time,
            'bookedSeats' => $bookedSeats
        ]);
    }

    public function registerLanguage()
    {
        $langModel = new \App\Models\LanguageClassModel();
        
        $lang = $this->request->getPost('language');
        $date = $this->request->getPost('schedule_date');
        $time = $this->request->getPost('session_time');
        $seat = $this->request->getPost('seat_number');
        
        $scheduleMap = [
            'Cina'      => ['days' => [1,3,5], 'time' => '08.00 - 10.30', 'room' => 'Ruang Asia 1'],
            'Jepang'    => ['days' => [1,3,5], 'time' => '08.00 - 10.30', 'room' => 'Ruang Asia 2'],
            'Thailand'  => ['days' => [1,3,5], 'time' => '11.00 - 13.30', 'room' => 'Ruang Asia 3'],
            'Korea'     => ['days' => [1,3,5], 'time' => '11.00 - 13.30', 'room' => 'Ruang Asia 4'],
            'Indonesia' => ['days' => [1,3,5], 'time' => '15.00 - 16.30', 'room' => 'Ruang Nusantara'],
            
            'Inggris'   => ['days' => [2,4,6], 'time' => '09.00 - 11.30', 'room' => 'Ruang Eropa 1'],
            'Spanyol'   => ['days' => [2,4,6], 'time' => '09.00 - 11.30', 'room' => 'Ruang Eropa 2'],
            'Perancis'  => ['days' => [2,4,6], 'time' => '13.00 - 15.30', 'room' => 'Ruang Eropa 3'],
            'Italia'    => ['days' => [2,4,6], 'time' => '13.00 - 15.30', 'room' => 'Ruang Eropa 4'],
        ];

        if (!isset($scheduleMap[$lang])) {
            return redirect()->to('/language-class')->with('error', 'Bahasa tidak valid.');
        }

        $conf = $scheduleMap[$lang];

        // Validasi kursi
        $exists = $langModel->where('language', $lang)
                            ->where('schedule_date', $date)
                            ->where('session_time', $time)
                            ->where('seat_number', $seat)
                            ->where('status !=', 'Cancelled')
                            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Kursi tersebut baru saja dipesan oleh orang lain. Silakan pilih kursi lain.');
        }

        // Generate QR Code mockup (hash)
        $qrCodeData = 'LC-' . strtoupper(substr(md5(uniqid($lang . $seat, true)), 0, 10));

        $data = [
            'user_id' => session()->get('user_id'),
            'language' => $lang,
            'schedule_date' => $date,
            'session_time' => $time,
            'room' => $conf['room'],
            'seat_number' => $seat,
            'qr_code' => $qrCodeData,
            'status' => 'Confirmed',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($langModel->save($data)) {
            $insertId = $langModel->getInsertID();
            return redirect()->to('/language-class/ticket/' . $insertId)->with('success', 'Pendaftaran kelas berhasil!');
        } else {
            return redirect()->to('/language-class')->with('error', 'Gagal mendaftar kelas.');
        }
    }

    public function languageClassTicket($id)
    {
        $langModel = new \App\Models\LanguageClassModel();
        $ticket = $langModel->where('id', $id)
                            ->where('user_id', session()->get('user_id'))
                            ->first();

        if (!$ticket) {
            return redirect()->to('/language-class')->with('error', 'Tiket tidak ditemukan.');
        }

        return view('user/services/language_class_ticket', [
            'title' => 'E-Ticket Language Class',
            'ticket' => $ticket
        ]);
    }
}