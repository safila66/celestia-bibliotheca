<?php

namespace App\Controllers;

class AdminScannerController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'QR Scanner | Administrator Console'
        ];
        return view('admin/scanner', $data);
    }
}
