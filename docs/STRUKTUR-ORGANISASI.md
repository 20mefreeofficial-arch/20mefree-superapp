# Struktur Organisasi & RBAC — 20Mefree Super APP

## Konteks Bisnis

20Mefree Super APP adalah ERP internal untuk tim yang memproduksi **konten
iklan dan konten organik**. Alur operasional inti: **produksi konten →
distribusi ke platform → pengukuran performa → evaluasi & keputusan
budget**. Bukan ERP manufaktur/distribusi.

## Divisi (2, dengan cara ukur berbeda)

| Divisi | Fokus | Platform | Output Utama | Metrik Penilaian |
|---|---|---|---|---|
| **Sales** | Iklan berorientasi penjualan | Facebook Ads, Shopee Ads, TikTok Ads | Omzet, order, konversi | Spend, Omzet, ROAS, CPA/CPP, CTR, Konversi |
| **Non-Sales** | Awareness & pertumbuhan organik | Facebook, TikTok, Instagram (ads awareness + organik) | Reach, views, engagement, followers | Reach, Impression, Views, VTR, Engagement Rate, CPM, Follower Growth, jumlah konten tayang |

**Aturan mutlak** (berlaku untuk seluruh sistem, termasuk modul yang akan
dibangun nanti): kedua divisi **tidak boleh** dinilai dengan metrik yang
sama. ROAS tidak pernah jadi KPI utama Non-Sales; divisi Sales tidak pernah
dinilai hanya dari jumlah konten. Setiap dashboard/laporan/perhitungan KPI
harus sadar konteks divisi.

## Role Sistem (12, tidak bisa dihapus, permission tetap bisa diatur)

1. Super Admin — akses penuh otomatis, permission tidak perlu diatur
2. Manager
3. Supervisor
4. Team Lead
5. Scriptwriter
6. Videographer
7. Editor
8. Designer
9. Media Buyer
10. Admin Sales/CS
11. Administration
12. People Management

Selain 12 role di atas, admin bisa membuat **Role Custom** lewat halaman
Role & Permission — dibuat, diatur permission-nya, dan dihapus bebas
(berbeda dari role sistem yang tidak bisa dihapus).

## Model Permission

Permission diberikan **per role → per modul → per fungsi di dalam modul →
per divisi (opsional) → per aksi CRUD** (Lihat/Tambah/Ubah/Hapus).

Contoh dari spesifikasi awal: role custom "Staff A" diberi akses ke modul
**Creative Production**; di dalam modul itu ada 5 fungsi; Staff A hanya
diberi akses ke fungsi **Project Management**, dengan permission **Lihat +
Tambah** saja (bukan Ubah/Hapus), dan bisa dibatasi hanya berlaku untuk
divisi tertentu.

**Default: tidak ada permission otomatis.** Kecuali Super Admin (selalu
full access), semua role — termasuk 12 role sistem di atas — dimulai
**tanpa** permission apapun. Admin harus mengatur secara eksplisit lewat
halaman **Role & Permission** modul mana, fungsi mana, dan aksi CRUD apa
yang boleh diakses role tersebut, per divisi kalau perlu.

## Modul & Fungsi (registry, bertambah seiring pengerjaan)

Saat ini baru ada modul yang sedang dibangun sendiri:

- **Pengguna & Hak Akses** (`user-rbac`)
  - Manajemen Pengguna (`users`)
  - Manajemen Role & Permission (`roles`)

Modul bisnis lain (Creative Production, dsb.) akan ditambahkan ke registry
`modules`/`module_functions` ini pada tahap pengerjaan masing-masing modul —
tanpa perlu mengubah struktur tabel yang sudah ada.

## Fondasi & Master Data — roadmap 6 fungsi

1. **User & RBAC** ← sedang dikerjakan (dokumen ini)
2. Master Produk & SKU
3. Master Akun (platform iklan/sosial)
4. Approval Engine
5. Audit Log
6. Naming Convention Engine

## Kebijakan Data

- **Tidak ada data dummy.** Satu-satunya data yang di-seed otomatis adalah
  master data struktural (role, divisi, modul/fungsi) dan **1 akun
  bootstrap Super Admin** — lihat [`AKUN-AWAL.md`](AKUN-AWAL.md).
- **Hard delete permanen.** Menghapus pengguna atau role custom (kalau user
  punya permission delete) langsung membuang datanya dari database — tidak
  ada soft-delete, tidak akan "muncul lagi" setelah migration/seeder
  dijalankan ulang.

## Database

MySQL, dikelola lewat phpMyAdmin. Struktur tabel ada di
`database/migrations/`.
