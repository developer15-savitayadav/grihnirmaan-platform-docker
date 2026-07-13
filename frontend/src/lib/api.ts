import axios from 'axios';

const baseURL = import.meta.env.VITE_API_URL;
if (!baseURL) throw new Error('VITE_API_URL is missing');

export const api = axios.create({
  baseURL: `${baseURL.replace(/\/$/, '')}/api`,
  timeout: 20000,
  headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token');
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});
