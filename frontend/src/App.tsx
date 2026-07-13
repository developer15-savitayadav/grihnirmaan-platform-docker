import { Navigate, Route, Routes } from 'react-router-dom';
import Home from './pages/Home';
import ApiStatus from './pages/ApiStatus';

export default function App() {
  return (
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="/api-status" element={<ApiStatus />} />
      <Route path="*" element={<Navigate to="/" replace />} />
    </Routes>
  );
}
