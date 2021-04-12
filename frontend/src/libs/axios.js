import Vue from 'vue'

// axios
import axios from 'axios'

const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  baseURL: process.env.MIX_API_URL + '/',
  timeout: 1000,
  headers: {
    'Accept': 'application/json',
    'X-XSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  },
  withCredentials: true
})

Vue.prototype.$http = axiosIns

export default axiosIns
