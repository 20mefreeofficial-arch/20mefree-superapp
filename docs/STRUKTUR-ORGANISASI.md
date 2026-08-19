# Struktur Organisasi & Role — 20Mefree Super APP

Dokumen ini menjadi acuan desain tabel role/akses pada tahap awal (structure) ERP.

## Hierarki Level (dari tertinggi ke terendah)

| Level | Role         | Cakupan                                                            |
|-------|--------------|---------------------------------------------------------------------|
| 1     | Super Admin  | Akses penuh ke seluruh sistem (data, user, pengaturan, semua divisi) |
| 2     | Manajer      | Setara Super Admin, namun dibatasi (tidak bisa kelola sistem inti / role Super Admin) |
| 3     | SPV          | Membawahi semua Leader (lintas divisi)                              |
| 4     | Leader       | Memimpin 1 divisi tertentu, membawahi staff di divisinya             |
| 5     | Staff        | Eksekutor tugas sesuai posisi/jabatan di divisinya                   |

## Divisi & Posisi

### Divisi: Advertiser (ADV)
- Leader ADV
- Staff ADV

### Divisi: CRM
- Leader CRM
- Staff CRM

### Divisi: Branding
- Leader Branding
- Staff SEO (Search Engine Optimization)
- Staff SMO (Social Media Officer)
- Staff Community & Partnership
- Staff CWN (Content Web Marketing / Designer / Editor)

### Divisi: Creative
- Leader Creative
- Staff SMO (Social Media Officer)
- Staff CWN (Content Web Marketing / Designer / Editor)
- Staff CSE (Content Support / Take Video / Editing)
- Staff Copywriting
- Staff Talent

> Catatan: SMO dan CWN muncul di dua divisi (Branding & Creative) sebagai posisi yang berbeda konteks kerja — dipisahkan lewat `division_id`, bukan digabung jadi satu posisi global.

## Aturan Akses (ringkas)

- **Super Admin**: full access — kelola user, role, divisi, posisi, seluruh modul, pengaturan sistem.
- **Manajer**: akses hampir sama dengan Super Admin, tapi **tidak boleh**:
  - mengelola/menghapus akun Super Admin lain
  - mengubah pengaturan inti sistem (konfigurasi role/permission dasar)
- **SPV**: melihat & mengelola data seluruh Leader dan staff di bawah semua divisi (lintas divisi), tidak punya akses ke pengaturan sistem.
- **Leader**: hanya mengelola divisinya sendiri (staff & data di bawah `division_id` miliknya).
- **Staff**: hanya mengakses data/tugas miliknya sendiri sesuai posisi.

## Kebijakan Media (Foto/Video)

Sistem **tidak menyimpan file foto/video** di server (menghemat storage).
Setiap record media hanya menyimpan **link/URL eksternal** (mis. Google Drive, YouTube, CDN) via kolom `url` pada tabel `media_links`.

## Database

Menggunakan MySQL, dikelola lewat phpMyAdmin. Struktur tabel awal ada di `database/migrations/`.
