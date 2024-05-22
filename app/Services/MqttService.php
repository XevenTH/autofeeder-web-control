<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;

class MqttService
{
  protected $mqttClient;

  public function __construct()
  {
    $server = "broker.emqx.io";
    $port = 1883;
    $clientId = uniqid('php-mqtt-');
    $this->mqttClient = new MqttClient($server, $port, $clientId);
  }

  public function subscribe()
  {
    $message = "olol";
    $loop = true;

    try {
      $this->mqttClient->connect();
      if ($this->mqttClient->isConnected()) {
        echo "Broker Connected";
        $this->mqttClient->subscribe('xeventh/test', function ($topic, $msg) use (&$message) {
          if ($topic == "xeventh/test") {
            $json = json_decode($msg, true);
            // dump($message);
            if (($json['data']) != "") {
              $message = $json['data']['value'];
              // Menghentikan loop
              $this->mqttClient->interrupt();
            }
             else {
              $message = 'Temperature data not found';
            }
          }
        }, 0);
        $this->mqttClient->loop(true);
      } else {
        echo "Broker Not Connected";
      }
    } catch (MqttClientException $e) {
      throw $e;
    } finally {
      $this->mqttClient->disconnect();
    }
    return $message;
  }
}
