<?php

namespace App\Http\Controllers;

use App\Exports\ActivitiesExport;
use App\Http\Resources\ActivityResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Device;
use App\Models\Schedule;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;
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

        // $activities = Activity::paginate(2);
        $activities = Activity::join('users', 'activity_log.causer_id', '=', 'users.id')
                                ->select('activity_log.*', 'users.name as causer_name')
                                ->orderBy('created_at', 'desc')
                                ->paginate(5);
        // dd(ActivityResource::collection($activities));
        // return view('report.activity-index', ['activities' => ActivityResource::collection($activities)]);
        return view('report.activity-index', ['activities' => $activities]);
        // return view('report.activity-index', compact('activities'));
    }
    public function log_activity_detail(Activity $activity)
    {
        return view('report.activity-detail', ['activity' => $activity]);
    }
    public function log_activity_export()
    {
        $activities = Activity::join('users', 'activity_log.causer_id', '=', 'users.id')
                                ->select('activity_log.*', 'users.name as causer_name')
                                ->get();
        $time = now()->format('Y-m-d_H-i-s');
        return Excel::download(new ActivitiesExport($activities), ('activities_'.$time.'.xlsx'));
        // return Excel::download(new ActivitiesExport($activities), ('activities_'.$time.'.pdf'), \Maatwebsite\Excel\Excel::DOMPDF);
    }
    
}
