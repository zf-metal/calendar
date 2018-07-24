import axios from 'axios'

export const HTTP = axios.create({
  baseURL: '/zfmc/api/',
  timeout: 30000,
  headers: {
    accept: 'application/json'
  }
})