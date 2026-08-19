# Menjalankan 20Mefree Super APP di Komputer Sendiri

Panduan ini untuk menjalankan aplikasi dari GitHub di laptop/PC Anda (Windows/Mac/Linux),
menggunakan phpMyAdmin lokal.

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

Perintah ini otomatis membuat semua tabel dan **18 akun dummy** (lihat
[`docs/AKUN-DUMMY.md`](AKUN-DUMMY.md)) — bisa dicek juga hasilnya lewat phpMyAdmin
di tabel `users`, `roles`, `divisions`, `positions`.

## 7. Compile tampilan (Tailwind CSS)

```bash
npm run build
```

## 8. Jalankan aplikasi

```bash
php artisan serve
```

Buka browser ke **http://127.0.0.1:8000** → otomatis diarahkan ke halaman login.

Login dengan salah satu akun dummy, contoh:

- Email: `superadmin@20mefree.com`
- Password: `password123`

(Daftar lengkap 18 akun ada di `docs/AKUN-DUMMY.md`)

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
