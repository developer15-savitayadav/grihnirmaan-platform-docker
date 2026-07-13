import { useEffect, useState } from 'react';
import { api } from '../lib/api';

export default function ApiStatus() {
  const [message, setMessage] = useState('Checking Laravel API...');
  useEffect(() => { api.get('/health').then(() => setMessage('Laravel API is connected.')).catch(() => setMessage('API not connected. Check VITE_API_URL and backend /api/health route.')); }, []);
  return <main className="grid min-h-screen place-items-center bg-[#FDFAF5] p-6"><div className="rounded-2xl bg-white p-8 shadow"><h1 className="text-2xl font-bold text-[#1F4E79]">{message}</h1></div></main>;
}
