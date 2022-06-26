import axios from 'axios';
import useAsync from '../composables/useAsync';

const API = axios.create({
  baseURL: ""
//   baseURL: process.env.VUE_APP_API_URL,
});


export default API;