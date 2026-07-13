# GrihNirmaan: Vercel + Laravel API split

## Structure
- `frontend/`: standalone React + Vite app for Vercel.
- `backend/`: Laravel API + Filament + queues for Railway/VPS/Laravel Cloud.

## Important
The original Inertia React code is preserved under `frontend/src/legacy-inertia/`. It is not included in the initial TypeScript build because Inertia pages depend on Laravel-provided props, `@inertiajs/react`, and Inertia routing. Convert each page to React Router + API calls before adding it to `App.tsx`.

## Local run
Backend:
```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

Frontend:
```bash
cd frontend
cp .env.example .env
npm install
npm run dev
```

## Vercel
Root directory: `frontend`
Build command: `npm run build`
Output: `dist`
Environment: `VITE_API_URL=https://api.yourdomain.com`

## Laravel host
Deploy `backend` to Railway/VPS. Add MySQL, Redis, S3 and all production environment variables. Run a separate worker using `php artisan horizon`.
