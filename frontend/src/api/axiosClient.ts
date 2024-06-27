// src/api/axiosClient.ts
import axios, { AxiosInstance } from "axios";

const axiosClient: AxiosInstance = axios.create({
  baseURL: "http://127.0.0.1:8000/api/v1",
  headers: {
    "Content-Type": "application/json",
  },
});

// Interceptor to handle request
axiosClient.interceptors.request.use(
  (config) => {
    // Add auth token here if needed
    // const token = localStorage.getItem('token');
    // if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Interceptor to handle responses
axiosClient.interceptors.response.use(
  (response) => {
    return response.data.data !== undefined
      ? response.data.data
      : response.data;
  },
  (error) => {
    const { response } = error;
    const errorMessage = response?.data?.message || error.message;
    console.error("API call error:", errorMessage);
    return Promise.reject(new Error(errorMessage));
  }
);

export default axiosClient;
