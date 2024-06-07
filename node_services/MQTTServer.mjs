import mqtt from 'mqtt';
import later from 'later';
import { promisify } from 'util';

// Konfigurasi koneksi MQTT
const options = {
  port: 1883,
  host: 'broker.emqx.io'
};

const client = mqtt.connect(options);

// Membuat versi promisified dari publish dan subscribe
const publishAsync = promisify(client.publish).bind(client);
const subscribeAsync = promisify(client.subscribe).bind(client);

// Fungsi untuk mempublikasikan pesan
const publishMessage = async () => {
  try {
    const message = 'Hello MQTT at ' + new Date().toISOString();
    await publishAsync('my/test/topic2', message);
    console.log('Message published:', message);
  } catch (err) {
    console.error('Publish error:', err);
  }
};

// Event handler untuk koneksi MQTT
client.on('connect', async function () {
  console.log('Connected to MQTT broker');
  try {
    await subscribeAsync('my/test/topic');
    console.log('Subscribed to topic');
    // Publikasi pesan pertama kali setelah koneksi berhasil
    publishMessage();
  } catch (err) {
    console.error('Subscribe error:', err);
  }
});

// Menjadwalkan publikasi pesan setiap 10 detik
const schedule = later.parse.text('every 10 seconds');
later.setInterval(publishMessage, schedule);

// Event handler untuk menerima pesan
client.on('message', function (topic, message) {
  console.log(`Received message: ${message.toString()} on topic: ${topic}`);
});

// Event handler untuk kesalahan koneksi
client.on('error', function (error) {
  console.error('Connection error:', error);
});
