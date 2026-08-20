<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RbacSeeder extends Seeder
{
    /**
     * Seed struktur RBAC dasar: 12 role sistem, 2 divisi (Sales/Non-Sales),
     * dan modul "User & RBAC" beserta fungsinya sendiri (modul bisnis lain
     * ditambahkan pada tahap pengerjaan masing-masing).
     *
     * Ini bukan data dummy — ini master data struktural yang memang jadi
     * dasar seluruh sistem permission, aman dijalankan berkali-kali
     * (idempotent lewat updateOrCreate) tanpa membuat duplikat.
     */
    public function run(): void
    {
        collect([
            ['name' => 'Super Admin', 'slug' => 'super_admin', 'is_system' => true, 'description' => 'Akses penuh ke seluruh sistem tanpa batasan.'],
            ['name' => 'Manager', 'slug' => 'manager', 'is_system' => true],
            ['name' => 'Supervisor', 'slug' => 'supervisor', 'is_system' => true],
            ['name' => 'Team Lead', 'slug' => 'team_lead', 'is_system' => true],
            ['name' => 'Scriptwriter', 'slug' => 'scriptwriter', 'is_system' => true],
            ['name' => 'Videographer', 'slug' => 'videographer', 'is_system' => true],
            ['name' => 'Editor', 'slug' => 'editor', 'is_system' => true],
            ['name' => 'Designer', 'slug' => 'designer', 'is_system' => true],
            ['name' => 'Media Buyer', 'slug' => 'media_buyer', 'is_system' => true],
            ['name' => 'Admin Sales/CS', 'slug' => 'admin_sales_cs', 'is_system' => true],
            ['name' => 'Administration', 'slug' => 'administration', 'is_system' => true],
            ['name' => 'People Management', 'slug' => 'people_management', 'is_system' => true],
        ])->each(fn ($role) => Role::updateOrCreate(['slug' => $role['slug']], $role));

        collect([
            ['name' => 'Sales', 'slug' => 'sales', 'description' => 'Iklan berorientasi penjualan (Facebook Ads, Shopee Ads, TikTok Ads). KPI: spend, omzet, ROAS, CPA/CPP, CTR, konversi.'],
            ['name' => 'Non-Sales', 'slug' => 'non-sales', 'description' => 'Awareness & pertumbuhan organik (Facebook, TikTok, Instagram). KPI: reach, impression, views, VTR, engagement rate, CPM, follower growth.'],
        ])->each(fn ($division) => Division::updateOrCreate(['slug' => $division['slug']], $division));

        $module = Module::updateOrCreate(
            ['slug' => 'user-rbac'],
            [
                'name' => 'Pengguna & Hak Akses',
                'description' => 'Manajemen akun pengguna, role, dan permission per modul/fungsi/divisi.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        collect([
            ['name' => 'Manajemen Pengguna', 'slug' => 'users', 'sort_order' => 1],
            ['name' => 'Manajemen Role & Permission', 'slug' => 'roles', 'sort_order' => 2],
        ])->each(fn ($function) => $module->functions()->updateOrCreate(['slug' => $function['slug']], $function));
    }
}
