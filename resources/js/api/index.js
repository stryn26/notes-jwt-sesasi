import axios from 'axios';

// Mengecek apakah token tersedia di localStorage
const token = localStorage.getItem('token');

// Membuat instance Axios dengan konfigurasi header otomatis
const Api = axios.create({
  baseURL: 'http://localhost:8000/api/',
});

export default Api;
