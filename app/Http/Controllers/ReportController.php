<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Device;
use App\Models\Schedule;
use GuzzleHttp\Client;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Activitylog\Models\Activity;

class ReportController extends Controller
{
    
    // function countServoSeconds($gram)
    // {
    //     // Asumsi: 30 gram per 1 detik
    //     return (number_format(($gram / 30), 1) * 1000); 
    // }
    
    public function log_activity_index()
    {
        // $title = 'Hapus Data?';
        // $text = "Harap konfirmasi penghapusan data";
        // confirmDelete($title, $text);

        $activities = Activity::all();
        return view('report.activity_index', ['activities' => $activities]);
    }
    public function log_activity_detail(Activity $activity)
    {
        return view('report.activity_detail', ['activity' => $activity]);
    }
    public function log_activity_export()
    {
        
    }
    
}
