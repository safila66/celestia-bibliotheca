<?php

namespace App\Controllers;

class ServiceController extends BaseController
{
    public function bookDelivery()
    {
        return view('user/services/book_delivery', ['title' => 'Book Delivery']);
    }

    public function roomBooking()
    {
        return view('user/services/room_booking', ['title' => 'Booking Ruang Baca']);
    }

    public function libcafe()
    {
        return view('user/services/libcafe', ['title' => 'LibCafé']);
    }

    public function referensi()
    {
        return view('user/services/referensi', ['title' => 'Layanan Referensi']);
    }

    public function sitasi()
    {
        return view('user/services/sitasi', ['title' => 'Panduan Sitasi']);
    }

    public function konsultasi()
    {
        return view('user/services/konsultasi', ['title' => 'Konsultasi Pustakawan']);
    }

    public function mendeleyClass()
    {
        return view('user/services/mendeley_class', ['title' => 'Mendeley Class']);
    }

    public function languageClass()
    {
        return view('user/services/language_class', ['title' => 'Language Class']);
    }
}