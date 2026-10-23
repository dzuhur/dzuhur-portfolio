# Dzuhur Portfolio

Website portfolio pribadi untuk menampilkan profil, project, dan informasi kontak. Dibangun menggunakan Laravel 13.

## Fitur

- Halaman utama portfolio
- Formulir kontak yang menyimpan pesan
- Halaman untuk mengunduh resume
- Panel admin untuk mengelola project dan pesan
- Pencatatan pengunjung
- `robots.txt` dan `sitemap.xml`

## Teknologi

- PHP 8.3+
- Laravel 13
- SQLite
- Node.js dan npm
- Vite

## Persyaratan

Pastikan perangkatmu sudah memiliki:

- PHP 8.3 atau lebih baru
- Composer
- Node.js dan npm

## Instalasi

1. Clone repository:

   ```bash
   git clone https://github.com/dzuhur/dzuhur-portfolio.git
   cd dzuhur-portfolio
   ```

2. Pasang dependency PHP dan JavaScript:

   ```bash
   composer install
   npm install
   ```

3. Buat file konfigurasi lokal `.env`:

   ```bash
   cp .env.example .env
   ```

   Di Windows PowerShell, gunakan:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Buat application key:

   ```bash
   php artisan key:generate
   ```

5. Siapkan database SQLite dan jalankan migrasi:

   ```bash
   php artisan migrate --seed
   ```

6. Buat asset frontend dan jalankan server:

   ```bash
   npm run build
   php artisan serve
   ```

7. Buka website di browser:

   ```text
   http://127.0.0.1:8000
   ```

## Pengembangan frontend

Untuk menjalankan Vite dalam mode development, buka terminal lain dan jalankan:

```bash
npm run dev
```

## URL

| Halaman | URL |
| --- | --- |
| Portfolio | `/` |
| Unduh resume | `/resume` |
| Login admin | `/admin/login` |
| Sitemap | `/sitemap.xml` |
| Robots | `/robots.txt` |

## Konfigurasi

Project menggunakan SQLite sesuai konfigurasi `.env.example`. Jangan unggah file `.env` ke repository karena file tersebut dapat berisi konfigurasi rahasia. Gunakan `.env.example` sebagai acuan konfigurasi lokal.

## Lisensi

Belum ditentukan.