# Menjalankan 20Mefree Super APP di Komputer Sendiri

Panduan ini untuk menjalankan aplikasi dari GitHub di laptop/PC Anda (Windows/Mac/Linux),
menggunakan phpMyAdmin lokal.

> **Kalau sebelumnya sudah pernah setup** (database sudah ada dari versi
> lama, dengan tabel `positions` dan 18 akun dummy): struktur database
> berubah total di update ini (role & permission per modul/fungsi/divisi).
> Jalankan `php artisan migrate:fresh --seed` (bukan `migrate --seed` biasa)
> **sekali ini saja** supaya tabel lama ikut terhapus bersih. Setelah itu,
> update-update berikutnya cukup pakai `scripts\update.bat` seperti biasa
> (tidak akan menghapus data lagi).

## 1. Install prasyarat

| Kebutuhan       | Rekomendasi                                                         |
|-----------------|-----------------------------------------------------------------------|
| PHP + MySQL + phpMyAdmin | **Laragon** (Windows, paling mudah) atau **XAMPP** (Windows/Mac/Linux) |
| Composer        | https://getcomposer.org/download/                                    |
| Node.js (v20+)  | https://nodejs.org (untuk compile Tailwind CSS)                      |
| Git             | https://git-scm.com/downloads                                        |

> Laragon/XAMPP sudah termasuk PHP, MySQL, dan phpMyAdmin sekaligus — jalankan
> service **Apache/Nginx** dan **MySQL** dari aplikasinya sebelum lanjut.

## 2. Clone repo dari GitHub

```bash
git clone https://github.com/20mefreeofficial-arch/20mefree-superapp.git
cd 20mefree-superapp
git checkout claude/magical-newton-bi2m41
```

## 3. Install dependency

```bash
composer install
npm install
```

## 4. Siapkan file .env

```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env`, pastikan bagian database sesuai dengan MySQL lokal Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=20mefree_superapp
DB_USERNAME=root
DB_PASSWORD=
```

(Default Laragon/XAMPP: user `root`, password kosong — sesuaikan jika berbeda.)

## 5. Buat database lewat phpMyAdmin

1. Buka `http://localhost/phpmyadmin`
2. Klik **New**, buat database bernama `20mefree_superapp` (harus sama persis dengan `DB_DATABASE` di `.env`)
3. Tidak perlu bikin tabel manual — akan dibuat otomatis di langkah berikutnya

## 6. Jalankan migration + seeder

```bash
php artisan migrate --seed
```

Perintah ini otomatis membuat semua tabel, 12 role sistem, 2 divisi
(Sales/Non-Sales), dan **1 akun bootstrap Super Admin** (bukan data dummy —
lihat [`docs/AKUN-AWAL.md`](AKUN-AWAL.md)). Semua akun lain dibuat sendiri
lewat halaman **Pengguna** di aplikasi.

## 7. Compile tampilan (Tailwind CSS)

```bash
npm run build
```

## 8. Jalankan aplikasi

```bash
php artisan serve
```

Buka browser ke **http://127.0.0.1:8000** → otomatis diarahkan ke halaman login.

Login dengan akun bootstrap:

- Email: `admin@20mefree.com`
- Password: `GantiSegera#2026`

(Detail & alasan di `docs/AKUN-AWAL.md` — setelah login, buat akun asli tim
Anda lewat menu **Pengguna**.)

## Update ke versi terbaru (setelah setup pertama kali beres)

Setiap kali ada perubahan/fitur baru yang sudah di-push ke GitHub, Anda tidak
perlu mengulang semua langkah di atas dari awal. Cukup gunakan 2 script yang
sudah disiapkan di folder `scripts/` (klik dua kali file-nya di File Explorer,
atau jalankan lewat terminal):

- **`scripts\update.bat`** — menarik kode terbaru dari GitHub, update
  dependency (composer & npm), jalankan migration database yang baru (aman,
  tidak menghapus data yang sudah ada), dan compile ulang tampilan.
- **`scripts\start.bat`** — menjalankan aplikasi (sama seperti `php artisan
  serve`), buka `http://127.0.0.1:8000` di browser setelahnya.

Alur kerja rutinnya:

1. Beri tahu saya perubahan yang diinginkan → saya kerjakan & push ke GitHub
2. Anda jalankan `scripts\update.bat` (tunggu sampai selesai)
3. Jalankan `scripts\start.bat`, lalu buka/refresh browser

## Mode pengembangan (opsional)

Kalau ingin mengedit tampilan dan langsung lihat perubahan tanpa `npm run build`
berulang kali, jalankan di terminal terpisah:

```bash
npm run dev
```

lalu tetap buka aplikasi lewat `php artisan serve` seperti biasa.

## Troubleshooting singkat

| Masalah                                   | Solusi                                                              |
|--------------------------------------------|------------------------------------------------------------------------|
| `SQLSTATE[HY000] [1049] Unknown database`  | Database belum dibuat di phpMyAdmin, ulangi langkah 5                 |
| Tampilan polos tanpa styling               | Jalankan `npm install && npm run build` (langkah 3 & 7)               |
| `could not find driver`                    | Extension `pdo_mysql` belum aktif di `php.ini` — aktifkan lalu restart |
| Port 8000 sudah dipakai                    | `php artisan serve --port=8001`                                       |
