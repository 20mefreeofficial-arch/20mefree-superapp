# 20Mefree Super APP

Sistem Enterprise Resource Planning (ERP) internal untuk tim 20Mefree. Repo ini
adalah **tahap awal (structure)** — fondasi backend, struktur role/hierarki
organisasi, dan skema database, sebelum modul-modul bisnis (campaign, konten,
laporan, dsb.) dibangun di atasnya.

## Stack

- **Framework**: Laravel 12 (PHP 8.4)
- **Database**: MySQL, dikelola lewat phpMyAdmin
- **Media**: file foto/video tidak disimpan di server — hanya disimpan sebagai
  link/URL eksternal (lihat tabel `media_links`)

## Struktur Organisasi

Lihat [`docs/STRUKTUR-ORGANISASI.md`](docs/STRUKTUR-ORGANISASI.md) untuk detail
hierarki role, divisi, posisi, dan aturan akses.

Ringkasan level:

1. **Super Admin** — akses penuh
2. **Manajer** — setara Super Admin, dengan batasan tertentu
3. **SPV** — membawahi semua Leader lintas divisi
4. **Leader** — memimpin satu divisi (ADV, CRM, Branding, Creative)
5. **Staff** — posisi spesifik sesuai divisi

## Struktur Database (awal)

| Tabel          | Fungsi                                                             |
|----------------|---------------------------------------------------------------------|
| `roles`        | 5 level role (superadmin, manajer, spv, leader, staff)              |
| `divisions`    | Advertiser, CRM, Branding, Creative                                 |
| `positions`    | Jabatan spesifik per divisi (mis. Staff SEO, Staff CWN)              |
| `users`        | User + relasi `role_id`, `division_id`, `position_id`, `reports_to_id` |
| `media_links`  | Link foto/video eksternal (bukan file fisik)                        |

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Buat database MySQL (mis. lewat phpMyAdmin) sesuai `DB_DATABASE` di `.env`,
lalu jalankan:

```bash
php artisan migrate --seed
```

Seeder akan mengisi role, divisi, posisi, dan 1 akun Super Admin awal
(`superadmin@20mefree.com`).

## Kontrol Akses (Role Middleware)

Middleware `role:<slug1>,<slug2>,...` tersedia untuk membatasi route
berdasarkan role user yang login. Contoh struktur pembagian route ada di
`routes/web.php` (`/superadmin`, `/manajemen`, `/spv`, `/leader`, `/staff`).

## Tahap Selanjutnya

Tahap ini baru mencakup fondasi (struktur database + role). Modul bisnis
(manajemen campaign, laporan kinerja per divisi, task management, dsb.) akan
dibangun pada tahap berikutnya di atas struktur ini.
