import axios from 'axios'
const http = axios.create({
  baseURL: '/zfmapi/',
  timeout: 1000,
  headers: {
    accept: 'application/json'
  }
});


