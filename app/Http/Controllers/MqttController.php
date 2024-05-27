<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MqttService;

class MqttController extends Controller
{
    private $mqttService;


    public function __construct() {
        $this->mqttService = new MqttService();
    }

    public function GetSubsMessage() {
        $message = $this->mqttService->subscribe();
        sleep(5);
        return view('MqttView', ['message' => $message]);
    }
}
