<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MqttService;

class MqttController extends Controller
{
    protected $mqttService;

    public function __construct(MqttService $mqttService) {
        $this->mqttService = $mqttService;
    }

    public function GetSubsMessage() {
        $this->mqttService->PublishSinyalToRun();
        sleep(3);
        $message = $this->mqttService->Subscribe();
        return view('MqttView', ['message' => $message]);
    }

    // public function PublishSinyal() {
        
    // }
}
