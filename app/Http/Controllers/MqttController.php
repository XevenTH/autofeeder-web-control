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
        $message = "";

        $this->mqttService->subscribe('/xeventh', function ($topic, $msg) use(&$message) {
            $json = json_decode($msg, true);

            if (isset($json->sensor)) {
                $message = $json->sensor;
            } else {
                $message = 'Temperature data not found';
            }
        });

        return view('MqttView', ['message' => $message]);
    }
}
