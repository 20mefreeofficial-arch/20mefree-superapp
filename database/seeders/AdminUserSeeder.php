<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Bootstrap SATU akun Super Admin awal — bukan data dummy/testing,
     * tapi akun operasional yang memang wajib ada supaya seseorang bisa
     * login pertama kali dan mulai membuat akun asli lainnya lewat UI.
     *
     * Hanya jalan kalau BELUM ADA super admin sama sekali di database
     * (mis. database baru pertama kali di-setup). Kalau sudah ada minimal
     * satu (baik akun bootstrap ini atau yang sudah diganti/dibuat admin),
     * seeder ini tidak melakukan apa-apa — tidak akan menimpa password
     * yang sudah diganti, dan tidak akan "menghidupkan kembali" akun yang
     * sengaja dihapus, karena sistem selalu menjaga minimal satu Super
     * Admin tetap ada (lihat UserController::destroy).
     */
    public function run(): void
    {
        $superAdminRole = Role::where('slug', 'super_admin')->first();

        if (! $superAdminRole) {
            return;
        }

        $hasSuperAdmin = User::where('role_id', $superAdminRole->id)->exists();

        if ($hasSuperAdmin) {
            return;
        }

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@20mefree.com',
            'password' => 'GantiSegera#2026',
            'role_id' => $superAdminRole->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
