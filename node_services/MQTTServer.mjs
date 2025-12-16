import mqtt from 'mqtt';
import scheduleLib from 'node-schedule';
import Pusher from 'pusher';
import moment from 'moment-timezone';
import { promisify } from 'util';
import { GetAllDevice, UpdateDeviceCapacity, GetScheduleAndDeviceJoin } from './DBConnection.mjs';

const daysOfWeek = {
  'Monday': 1,
  'Tuesday': 2,
  'Wednesday': 3,
  'Thursday': 4,
  'Friday': 5,
  'Saturday': 6,
  'Sunday': 0
};

const options = {
  port: 1883,
  host: 'broker.emqx.io'
};

const pusher = new Pusher({
  appId: '2091635',
  key: 'fa1e07ae6a6933b947b3',
  secret: '58799729b1ff899cdd88',
  cluster: 'ap1',
});

let scheduledJob = [];

const client = mqtt.connect(options);

const publishAsync = promisify(client.publish).bind(client);
const subscribeAsync = promisify(client.subscribe).bind(client);

const mapDaysToNumbers = (days) => {
  return days.map(day => daysOfWeek[day]);
};

const cancelAllJob = async () => {
  scheduledJob.forEach(job => job.cancel());
  scheduledJob = [];

  await makeSchedulers();
}

const publishMessageServo = async (servo_seconds, topic) => {
  try {
    await publishAsync(`xeventh/${topic}/servo`, servo_seconds);
    await publishAsync(`xeventh/${topic}/signal`, '1');
    await subscribeAsync(`xeventh/${topic}/data`);
    console.log('Servo Seconds published:', servo_seconds);
  } catch (err) {
    console.error('Publish error:', err);
  }
};

const makeSchedulers = async () => {
  try {
    const schedules = await GetScheduleAndDeviceJoin();
    const timeZone = 'Asia/Jakarta';

    schedules.forEach(schedule => {
      if (schedule.active == 0) return;

      const targetTime = moment.tz(schedule.time, 'HH:mm:ss', timeZone);
      const hours = targetTime.hours();
      const minutes = targetTime.minutes();

      const daysArray = schedule.days.split(' ').map(day => day.trim());
      const daysNumbers = mapDaysToNumbers(daysArray);
      daysNumbers.pop();

      if (daysNumbers.length === 0) {
        console.error('Invalid days in schedule:', schedule.days);
        return;
      }

      daysNumbers.forEach(day => {
        const job = scheduleLib.scheduleJob({ hour: hours, minute: minutes, dayOfWeek: day }, () => {
          publishMessageServo(`${schedule.servo_seconds}`, schedule.topic);
        });
        scheduledJob.push(job);
        console.log(`Job scheduled to run at ${hours}:${minutes} on./, day ${day}`);
      });

      console.log(`Job scheduled to run every ${hours}:${minutes} on ${daysArray.join(', ')}`);
    });
  } catch (err) {
    console.error('Subscribe error:', err);
  }
}

client.on('connect', async function () {
  const devices = await GetAllDevice();

  for (const device of devices) {
    const { topic } = device;

    await publishAsync(`xeventh/${topic}/signal`, '1');
    await subscribeAsync(`xeventh/${topic}/data`);

    console.log(`Publish and Async at Topic ${topic}`);
  }

  console.log('Connected to MQTT broker');

  await makeSchedulers();
});

client.on('message', async (topic, message) => {
  console.log(`${message} on ${topic}`)

  try {
    const parsedMessage = JSON.parse(message.toString());
    
    const { id_device, data } = parsedMessage;
    
    await UpdateDeviceCapacity(data, id_device);

    pusher.trigger('devices', 'capacity.updated', {
      deviceId: id_device,
      capacity: data
    });

  } catch (err) {
    console.error('Error parsing message or updating device capacity:', err);
  }
});

client.on('error', function (error) {
  console.error('Connection error:', error);
});

/* =============================================================================== */

import ex from 'express';

const app = ex();
const port = 3000;

app.post('/api/refresh', async (req, res) => {
  try {
    await cancelAllJob();
    res.status(200).json({ message: 'Jobs rescheduled successfully' });
  } catch (error) {
    res.status(500).json({ message: 'Failed to reschedule jobs', error: error.message });
  }
});

app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});