# Akun Dummy — 20Mefree Super APP

Dibuat otomatis oleh `database/seeders/UserSeeder.php` saat `php artisan migrate --seed`.

**Password untuk semua akun di bawah:** `password123`

> ⚠️ Akun & password ini hanya untuk kebutuhan development/demo tahap awal.
> Wajib dihapus/diganti sebelum sistem dipakai secara nyata (produksi).

| Email                                      | Role        | Divisi     | Posisi                          |
|---------------------------------------------|-------------|------------|----------------------------------|
| superadmin@20mefree.com                      | Super Admin | -          | -                                |
| manajer@20mefree.com                         | Manajer     | -          | -                                |
| spv@20mefree.com                             | SPV         | -          | -                                |
| leader.adv@20mefree.com                      | Leader      | Advertiser | Leader Advertiser                |
| leader.crm@20mefree.com                      | Leader      | CRM        | Leader CRM                       |
| leader.branding@20mefree.com                 | Leader      | Branding   | Leader Branding                  |
| leader.creative@20mefree.com                 | Leader      | Creative   | Leader Creative                  |
| staff.adv@20mefree.com                       | Staff       | Advertiser | Staff ADV                        |
| staff.crm@20mefree.com                       | Staff       | CRM        | Staff CRM                        |
| staff.branding.seo@20mefree.com              | Staff       | Branding   | Staff SEO                        |
| staff.branding.smo@20mefree.com              | Staff       | Branding   | Staff SMO                        |
| staff.branding.community@20mefree.com        | Staff       | Branding   | Staff Community & Partnership    |
| staff.branding.cwn@20mefree.com              | Staff       | Branding   | Staff CWN                        |
| staff.creative.smo@20mefree.com              | Staff       | Creative   | Staff SMO                        |
| staff.creative.cwn@20mefree.com              | Staff       | Creative   | Staff CWN                        |
| staff.creative.cse@20mefree.com              | Staff       | Creative   | Staff CSE                        |
| staff.creative.copywriting@20mefree.com      | Staff       | Creative   | Staff Copywriting                |
| staff.creative.talent@20mefree.com           | Staff       | Creative   | Staff Talent                     |

Setiap akun leader/staff otomatis diberi `reports_to_id` sesuai hierarki
(staff → leader divisinya, leader → SPV, SPV → Manajer, Manajer → Super Admin)
sehingga bisa langsung dites di halaman dashboard setelah login.
