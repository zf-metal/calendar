import axios from 'axios'

export const HTTP = axios.create({
  baseURL: process.env.VUE_APP_BASE_API_URL,
  timeout: 60000,
  headers: {
    accept: 'application/json'
  }
})