import mysql from 'mysql2/promise';

const config = {
  host: 'localhost',
  user: '',
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

const FetchData = async () => {
    try {
      const connection = await ConnectDB();

      if (connection) {
        const [rows] = await connection.execute('SELECT * FROM Jadwal');
  
        const resultArray = rows.map(row => ({
          field1: row.field1,
          field2: row.field2,
        }));
  
        console.log('Data:', resultArray);

        await connection.end();
  
        return resultArray;
      }
    } catch (err) {
      console.error('Error fetching data:', err);
    }
  };

export default FetchData;