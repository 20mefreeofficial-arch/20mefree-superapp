# Keamanan — 20Mefree Super APP

## Yang sudah diterapkan

- **Password di-hash** dengan bcrypt (default Laravel, via cast `hashed` di model `User`) — password tidak pernah tersimpan dalam bentuk teks biasa.
- **Rate limiting / anti brute-force login**: percobaan login gagal dibatasi 5x per kombinasi email+IP, dikunci sementara (lockout) 60 detik setelah melebihi batas. Ditambah pembatasan umum 10 request/menit per route login di level middleware `throttle`.
- **Session security**: session ID di-regenerate setiap login (mencegah session fixation), di-invalidate total setiap logout, cookie `HttpOnly` (tidak bisa diakses JavaScript) dan `SameSite=Lax` (mitigasi CSRF).
- **CSRF protection**: semua form (login, logout) memakai `@csrf` token bawaan Laravel.
- **Security headers** (`app/Http/Middleware/SecurityHeaders.php`) pada setiap response:
  - `X-Frame-Options: DENY` — mencegah clickjacking
  - `X-Content-Type-Options: nosniff` — mencegah MIME-sniffing
  - `Referrer-Policy: strict-origin-when-cross-origin`
  - `Permissions-Policy` — nonaktifkan akses kamera/mikrofon/lokasi browser secara default
  - `Content-Security-Policy` (aktif di luar mode local/dev) — membatasi sumber script/style/gambar hanya dari domain sendiri
  - `Strict-Transport-Security` — otomatis aktif saat diakses lewat HTTPS
- **Role-based access control**: setiap route dibatasi middleware `role:<slug>` sesuai hierarki (superadmin/manajer/spv/leader/staff).
- **Mass-assignment protection**: setiap model memakai atribut `#[Fillable]` eksplisit, bukan `$guarded = []`.

## Checklist WAJIB sebelum dipakai untuk data sungguhan (production)

Jangan skip bagian ini — ini yang membedakan environment development (aman untuk demo/testing) dari environment yang siap dipakai tim beneran.

1. **Ganti/hapus 18 akun dummy** (`docs/AKUN-DUMMY.md`) — password `password123` diketahui publik di repo ini. Buat akun asli dengan password kuat & unik per orang.
2. **Set di file `.env` server production:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   SESSION_SECURE_COOKIE=true
   ```
   `APP_DEBUG=false` **wajib** — kalau `true`, error apapun akan menampilkan detail kode/query database ke publik.
3. **Akses lewat HTTPS**, bukan HTTP biasa — supaya `SESSION_SECURE_COOKIE` dan header `Strict-Transport-Security` berfungsi.
4. **`APP_KEY` jangan dibagikan/di-commit** — file `.env` sudah otomatis di-ignore git, pastikan tetap begitu.
5. Backup database MySQL secara berkala (lewat phpMyAdmin → Export, atau `mysqldump` terjadwal).
6. Batasi akses phpMyAdmin hanya dari jaringan internal/VPN, jangan expose ke internet publik tanpa proteksi tambahan.

## Kalau ke depan butuh lebih ketat lagi

- Two-factor authentication (2FA) untuk role Super Admin & Manajer
- Audit log (siapa mengubah data apa, kapan)
- Kebijakan kompleksitas password saat pembuatan user baru (huruf besar/kecil/angka/simbol, minimal panjang)
