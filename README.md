# 20Mefree Super APP

Sistem Enterprise Resource Planning (ERP) internal untuk tim 20Mefree — tim
kreatif yang memproduksi konten iklan & organik. Alur operasional inti yang
dikelola sistem ini: **produksi konten → distribusi ke platform → pengukuran
performa → evaluasi & keputusan budget**, bukan ERP manufaktur/distribusi.

Repo ini sedang dibangun bertahap. Tahap sekarang: **Fondasi & Master Data
— fungsi User & RBAC** (manajemen pengguna, role, dan permission per
modul/fungsi/divisi). Fungsi fondasi lain (Master Produk & SKU, Master
Akun, Approval Engine, Audit Log, Naming Convention Engine) serta modul
bisnis akan menyusul di tahap berikutnya.

## Stack

- **Framework**: Laravel 12 (PHP 8.4)
- **Database**: MySQL, dikelola lewat phpMyAdmin
- **Tema**: warna primer `#71002c`, desain elegant & minim warna, responsive
  penuh (desktop/tablet/handphone)

## Struktur Divisi

Dua divisi dengan cara ukur performa yang **berbeda** — sistem sadar
konteks divisi ini di setiap perhitungan KPI ke depannya:

| Divisi | Fokus | Platform | KPI |
|---|---|---|---|
| **Sales** | Iklan berorientasi penjualan | Facebook Ads, Shopee Ads, TikTok Ads | Spend, Omzet, ROAS, CPA/CPP, CTR, Konversi |
| **Non-Sales** | Awareness & pertumbuhan organik | Facebook, TikTok, Instagram | Reach, Impression, Views, VTR, Engagement Rate, CPM, Follower Growth |

## Role Sistem

Super Admin, Manager, Supervisor, Team Lead, Scriptwriter, Videographer,
Editor, Designer, Media Buyer, Admin Sales/CS, Administration, People
Management — plus **Role Custom** yang bisa dibuat lewat UI dengan
permission-nya sendiri.

## Model Permission (RBAC)

Permission diatur **per modul → per fungsi → per divisi**, dengan hak CRUD
(Lihat/Tambah/Ubah/Hapus) terpisah untuk masing-masing kombinasi. Contoh:
role "Team Lead" bisa diberi akses modul Creative Production, fungsi
Project Management, hanya permission Lihat+Tambah, khusus divisi Non-Sales.

Super Admin selalu full access (bypass otomatis, tidak butuh diatur).
Role lain — termasuk role sistem — **tidak punya permission apapun secara
default**, harus diatur eksplisit lewat halaman **Role & Permission**.

## Struktur Database (tahap ini)

| Tabel | Fungsi |
|---|---|
| `roles` | Role sistem (`is_system=true`) & role custom buatan admin |
| `divisions` | Sales, Non-Sales |
| `modules` | Registry modul sistem (baru ada "Pengguna & Hak Akses") |
| `module_functions` | Fungsi di dalam modul, tempat permission diberikan |
| `role_permissions` | Permission CRUD per role + fungsi + (opsional) divisi |
| `users` | Akun, terhubung ke `role_id`, `division_id`, `reports_to_id` |

## Setup

> Ingin menjalankan langsung dari GitHub di komputer sendiri (Laragon/XAMPP +
> phpMyAdmin)? Ikuti panduan lengkap step-by-step di
> [`docs/JALANKAN-LOKAL.md`](docs/JALANKAN-LOKAL.md).

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Buat database MySQL (mis. lewat phpMyAdmin) sesuai `DB_DATABASE` di `.env`,
lalu jalankan:

```bash
npm install && npm run build
php artisan migrate --seed
php artisan serve
```

**Tidak ada data dummy.** Seeder hanya membuat: 12 role sistem, 2 divisi,
modul "Pengguna & Hak Akses", dan **1 akun bootstrap Super Admin** —
lihat [`docs/AKUN-AWAL.md`](docs/AKUN-AWAL.md). Semua akun lain dibuat sendiri
lewat halaman **Pengguna** di aplikasi. Setiap penghapusan data adalah
**hard delete permanen** (tidak akan "muncul lagi").

## Login & Permission

Buka `/login`. Setelah masuk, menu navigasi (Dashboard/Pengguna/Role &
Permission) otomatis menyesuaikan hak akses user yang login — menu yang
tidak diizinkan tidak akan tampil, dan mengakses URL-nya langsung akan
ditolak (403).

## Keamanan

Lihat [`docs/KEAMANAN.md`](docs/KEAMANAN.md) — rate limiting login, security
headers, session hardening, dan checklist sebelum dipakai untuk data
sungguhan (production).

## Tahap Selanjutnya

Setelah User & RBAC ini stabil: Master Produk & SKU, Master Akun (platform
iklan/sosial), Approval Engine, Audit Log, Naming Convention Engine — baru
kemudian modul bisnis (produksi konten, campaign, laporan performa).
