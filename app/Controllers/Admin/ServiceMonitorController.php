<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ServiceMonitorController extends BaseController
{
    public function index()
    {
        $refModel = new \App\Models\ReferenceLoanModel();
        $citModel = new \App\Models\CitationCheckModel();
        $consModel = new \App\Models\ConsultationModel();
        $mendeleyModel = new \App\Models\MendeleyClassModel();
        $langModel = new \App\Models\LanguageClassModel();

        // Join with users to get names
        $referensi = $refModel->select('reference_loans.*, users.name as user_name')
                              ->join('users', 'users.id = reference_loans.user_id', 'left')
                              ->orderBy('created_at', 'DESC')
                              ->findAll();
        
        $sitasi = $citModel->select('citation_checks.*, users.name as user_name')
                           ->join('users', 'users.id = citation_checks.user_id', 'left')
                           ->orderBy('created_at', 'DESC')
                           ->findAll();
                           
        $konsultasi = $consModel->select('consultations.*, users.name as user_name')
                                ->join('users', 'users.id = consultations.user_id', 'left')
                                ->orderBy('created_at', 'DESC')
                                ->findAll();
                                
        $mendeley = $mendeleyModel->select('mendeley_classes.*, users.name as user_name')
                                  ->join('users', 'users.id = mendeley_classes.user_id', 'left')
                                  ->orderBy('created_at', 'DESC')
                                  ->findAll();
                                  
        $language = $langModel->select('language_classes.*, users.name as user_name')
                              ->join('users', 'users.id = language_classes.user_id', 'left')
                              ->orderBy('created_at', 'DESC')
                              ->findAll();

        $data = [
            'title' => 'Monitor Layanan',
            'referensi' => $referensi,
            'sitasi' => $sitasi,
            'konsultasi' => $konsultasi,
            'mendeley' => $mendeley,
            'language' => $language
        ];

        return view('admin/services/index', $data);
    }

    public function updateStatus($type, $id)
    {
        $status = $this->request->getPost('status');
        
        if (!$status) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        switch($type) {
            case 'referensi':
                $model = new \App\Models\ReferenceLoanModel();
                break;
            case 'sitasi':
                $model = new \App\Models\CitationCheckModel();
                break;
            case 'konsultasi':
                $model = new \App\Models\ConsultationModel();
                break;
            case 'mendeley':
                $model = new \App\Models\MendeleyClassModel();
                break;
            case 'language':
                $model = new \App\Models\LanguageClassModel();
                break;
            default:
                return redirect()->back()->with('error', 'Tipe layanan tidak valid.');
        }

        if ($model->update($id, ['status' => $status])) {
            return redirect()->back()->with('success', 'Status berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui status.');
    }
}
