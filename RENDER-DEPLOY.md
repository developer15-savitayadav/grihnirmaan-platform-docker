# Deploy GrihNirmaan to Render with Docker

This package runs the existing `frontend` and `backend` in one Render Docker Web Service:

- `/` and React routes: compiled Vite frontend
- `/api/*`: Laravel API
- `/admin`: Filament admin
- `/livewire`, `/broadcasting`, `/sanctum`, `/webhooks`: Laravel

## 1. Push this folder to GitHub

Run these commands from the folder containing `Dockerfile`, `backend`, and `frontend`:

```powershell
git init
git add .
git commit -m "Prepare GrihNirmaan for Render Docker deployment"
git branch -M main
git remote add origin https://github.com/YOUR-USERNAME/YOUR-REPOSITORY.git
git push -u origin main
```

Never commit a real `.env` file.

## 2. Create the Render service

Recommended method:

1. Render Dashboard → **New** → **Blueprint**.
2. Connect the GitHub repository.
3. Render detects `render.yaml`.
4. Fill every variable marked `sync: false`.

Manual Web Service values:

- Runtime: **Docker**
- Root Directory: leave blank
- Dockerfile path: `./Dockerfile`
- Docker build context: `.`
- Build Command: blank
- Start Command: blank
- Instance: Free
- Health Check Path: `/api/health`

## 3. Required environment variables

```env
APP_NAME=GrihNirmaan
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_A_REAL_LARAVEL_KEY
APP_URL=https://YOUR-SERVICE.onrender.com
APP_TIMEZONE=Asia/Kolkata
LOG_CHANNEL=stderr
LOG_LEVEL=info

DB_CONNECTION=mysql
DB_HOST=YOUR_EXTERNAL_DATABASE_HOST
DB_PORT=3306
DB_DATABASE=YOUR_DATABASE
DB_USERNAME=YOUR_DATABASE_USER
DB_PASSWORD=YOUR_DATABASE_PASSWORD

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
MAIL_MAILER=log
RUN_MIGRATIONS=true
RUN_SEEDERS=false
```

Generate a Laravel key locally from the backend directory:

```powershell
cd backend
php artisan key:generate --show
```

## 4. Database requirement

Do not use `127.0.0.1` for a hosted database. Use an external MySQL/PostgreSQL service reachable by Render.

The startup script automatically runs:

```bash
php artisan migrate --force
```

Set `RUN_MIGRATIONS=false` only when you intentionally do not want automatic migrations.

## 5. Optional integrations

Add your existing Pusher, Twilio, SMTP, S3 and Sentry environment variables in Render. Do not place their secrets in GitHub.

## 6. Important free-tier limitation

The local filesystem is not permanent on a free Render Web Service. Customer documents, uploaded images and generated PDFs should eventually use S3-compatible external storage.
