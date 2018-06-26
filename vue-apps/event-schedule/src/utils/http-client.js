import axios from 'axios'

export const HTTP = axios.create({
  baseURL: '/zfmc/api/',
  timeout: 15000,
  headers: {
    accept: 'application/json'
  }
})