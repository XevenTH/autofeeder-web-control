<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;

class MqttService
{
    protected $mqttClient;

    public function __construct()
    {
        $server = 'public.cloud.shifter.io';
        $port = 1883;
        $this->mqttClient = new MqttClient($server, $port);
    }

    public function subscribe($topic, $callback)
    {
        try {
            $this->mqttClient->connect();
            $this->mqttClient->subscribe($topic, $callback);
            $this->mqttClient->loop(true);
          } catch (MqttClientException $e) {
            throw $e;
          } finally {
          // $this->mqttClient->disconnect();
        }
    }
}