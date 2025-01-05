import axios from 'axios';

axios.defaults.withCredentials = true;

const apiClient = axios.create({
    baseURL: "http://127.0.0.1:8000/api/",
});

export default apiClient;