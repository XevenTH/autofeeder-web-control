<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MqttService;

class MqttController extends Controller
{
    private $mqttService;


    public function __construct(MqttService $mqttService) {
        $this->mqttService = $mqttService;
    }

    public function GetSubsMessage() {
        $message = [];

        $this->mqttService->subscribe('/xeventh', function ($topic, $msg) use(&$message) {
            $message[] = $msg;
        });

        return view('MqttView', ['message' => $message]);
    }
}
