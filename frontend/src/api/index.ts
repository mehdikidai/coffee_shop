import axios from 'axios'

const apiUri = import.meta.env.VITE_API_URI

const API = axios.create({
  baseURL: apiUri,
  headers: {
    'Content-Type': 'application/json',
  },
})


API.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.clear() // try 3 time and reset
      window.location.href = '/login'
    }

    return Promise.reject(error)
  },
)


export default API
