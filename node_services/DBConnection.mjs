import mysql from 'mysql2/promise';

const config = {
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'autofeeder'
};

const ConnectDB = async () => {
  try {
    const connection = await mysql.createConnection(config);
    console.log('Connected to MySQL');
    return connection;
  } catch (err) {
    console.error('Error connecting to MySQL:', err);
  }
};

const GetAllDevice = async () => {
  try {
    const connection = await ConnectDB();

    const [rows] = await connection.execute('SELECT * FROM devices');

    const resultArray = rows.map(row => ({
      id: row.id, // int
      user_id: row.user_id, // int
      name: row.name, // bool
      topic: row.topic,
      capacity: row.capacity, // String
    }));

      await connection.end();

      return resultArray;
  } catch (error) {
    
  }
}

const GetScheduleAndDeviceJoin = async () => {
  try {
    const connection = await ConnectDB();

    if (connection) {
      const [rows] = await connection.execute('SELECT schedules.*, devices.topic FROM schedules INNER JOIN devices ON schedules.device_id = devices.id ');

      const resultArray = rows.map(row => ({
        id: row.id, // int
        device_id: row.device_id, // int
        active: row.active, // bool
        days: row.days, // String
        time: row.time, // String
        grams_per_feeding: row.grams_per_feeding,  // int
        servo_seconds: row.servo_seconds, // int
        topic: row.topic
      }));

      await connection.end();

      return resultArray;
    }
  } catch (err) {
    console.error('Error fetching data:', err);
  }
}

const UpdateDeviceCapacity = async (capacity, id_device) => {
  try {
    const connection = await ConnectDB();

    if (connection) {
      let stringId = id_device.toString();
      await connection.execute(
        'UPDATE devices SET capacity = ? WHERE topic = ?',
        [capacity, stringId]
      );

      await connection.end();
    }
  } catch (err) {
    console.error('Error fetching data:', err);
  }
}

export { GetAllDevice, UpdateDeviceCapacity, GetScheduleAndDeviceJoin };