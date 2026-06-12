# Hostinger Deployment & Frontend Integration Guide for Transcripto

This guide explains how to connect your Figma React frontend (`frontend-transcripto-`) with your DDA Laravel backend (`transcripto`), and deploy the integrated system to **Hostinger**.

---

## Part 1: Connect Figma Frontend to Backend

### 1. Commit Your Figma Export Files
Currently, your `frontend-transcripto-` repository is a skeleton workspace missing its source files.
- Copy your exported Figma React code (especially the `src/` folder containing `main.tsx`, components, assets, etc.) into the `frontend-transcripto-` directory.
- Verify it runs locally by executing:
  ```bash
  pnpm install
  pnpm dev
  ```

### 2. Configure Vite Build Output to Laravel Public
To avoid CORS issues and simplify Hostinger shared hosting, configure Vite to output build assets directly into the Laravel backend's `public/` folder.

Modify `vite.config.ts` in your frontend project to include the `build` block:

```typescript
import { defineConfig } from 'vite'
import path from 'path'
import tailwindcss from '@tailwindcss/vite'
import react from '@vitejs/plugin-react'

export default defineConfig({
  plugins: [
    react(),
    tailwindcss(),
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src'),
    },
  },
  build: {
    // Builds files directly into the Laravel public folder
    outDir: '../transcripto/public',
    emptyOutDir: false, // Prevents deleting backend assets like preview.html
  }
})
```

Run the build command inside the frontend directory:
```bash
pnpm build
```
This compiles your React frontend directly into the Laravel public folder as `index.html` and assets.

---

## Part 2: Hosting on Hostinger (Shared or Cloud Hosting)

Hostinger shared hosting directs domain traffic to the `public_html` folder. We will point this to Laravel's `public/` directory.

### Step 1: Upload Files to Hostinger
You can deploy your code to Hostinger via **Git Integration** (recommended) or **File Manager/FTP**.

#### Option A: Git Deployment (hPanel)
1. Go to Hostinger **hPanel** -> **Website** -> **Git**.
2. Link your repository URL: `https://github.com/ajaypoonia29/transcripto.git` (branch: `main`).
3. Set the installation directory to `/public_html`.
4. Click **Create** to deploy.

#### Option B: Manual Upload
1. Zip the entire backend folder (`transcripto` containing the built frontend files inside `public/`).
2. Upload the zip file using hPanel **File Manager** under `public_html` and extract it.

---

### Step 2: Configure Directory Mappings
Since Laravel expects requests to start in the `/public` folder, you need to point Hostinger's domain root to `/public`.

Create an `.htaccess` file directly inside your root `public_html/` folder (not inside `public/`):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

### Step 3: Setup Database & Environment Variables (`.env`)
1. Go to hPanel -> **Databases** -> **MySQL Databases** and create a new database and user.
2. Open the **File Manager**, rename `.env.example` to `.env` in the root of your project, and edit it:
   ```env
   APP_NAME=Transcripto
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://transcripto.in

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_hostinger_database_name
   DB_USERNAME=your_hostinger_database_user
   DB_PASSWORD=your_database_password
   ```

---

### Step 4: Run Post-Deployment Commands
Access your server via SSH (available on Premium plans and above) and run:

```bash
# Install dependencies
composer install --no-dev --optimize-autoloader

# Run database migrations
php artisan migrate --force

# Optimize performance
php artisan config:cache
php artisan route:cache
```

Now, visiting `https://transcripto.in` will serve your Figma React frontend, and any API interactions will seamlessly route through the Laravel DDA backend!
