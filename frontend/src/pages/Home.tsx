import { Link } from 'react-router-dom';

export default function Home() {
  return (
    <main className="min-h-screen bg-[#FDFAF5] px-6 py-20 text-[#1C1C1C]">
      <div className="mx-auto max-w-4xl rounded-3xl border border-black/10 bg-white p-10">
        <p className="font-semibold text-[#C4623A]">GrihNirmaan</p>
        <h1 className="mt-3 text-4xl font-bold text-[#1F4E79]">Vercel React frontend is ready</h1>
        <p className="mt-5 leading-7 text-black/70">Your original Inertia pages are preserved in <code>src/legacy-inertia</code>. Convert them page-by-page to React Router and Laravel JSON APIs.</p>
        <Link className="mt-8 inline-flex rounded-xl bg-[#1F4E79] px-5 py-3 font-semibold text-white" to="/api-status">Test Laravel API</Link>
      </div>
    </main>
  );
}
