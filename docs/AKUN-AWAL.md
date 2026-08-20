# Akun Awal — 20Mefree Super APP

Sistem ini **tidak memakai data dummy**. Yang di-seed hanya satu akun
**bootstrap Super Admin**, yang memang wajib ada supaya seseorang bisa login
pertama kali dan mulai membuat akun-akun asli lainnya lewat halaman
**Pengguna** di aplikasi.

| Email | Password awal |
|---|---|
| `admin@20mefree.com` | `GantiSegera#2026` |

## Wajib dilakukan setelah setup pertama kali

1. Login pakai akun di atas.
2. Buka menu **Pengguna** → buat akun asli untuk setiap anggota tim (dengan
   role & divisi masing-masing).
3. Ganti password akun bootstrap ini, atau nonaktifkan/hapus setelah ada
   Super Admin lain yang dibuat manual — sistem tidak mengizinkan menghapus
   Super Admin terakhir, jadi selalu pastikan minimal ada satu akun Super
   Admin yang Anda kuasai sebelum menghapus yang lain.

## Kenapa cuma 1 akun, bukan banyak akun contoh?

Supaya tidak ada data palsu yang harus dibersihkan manual, dan supaya tidak
ada kebingungan soal password mana yang "asli". Semua role (Manager,
Supervisor, Team Lead, Scriptwriter, dst.) dan akun penggunanya dibuat
sendiri oleh tim lewat aplikasi — bukan di-generate otomatis oleh sistem.

## Soal data yang dihapus

Setiap penghapusan (pengguna, role custom, dll.) di sistem ini adalah
**hard delete permanen** — data langsung dibuang dari database, bukan
ditandai "terhapus" lalu disembunyikan. Menjalankan `php artisan migrate`
atau `scripts\update.bat` **tidak** akan memunculkan kembali data yang sudah
dihapus, karena proses itu hanya menjalankan migration struktur tabel, bukan
seeder. Seeder (`php artisan db:seed`) hanya perlu dijalankan **sekali** saat
setup awal database baru.
