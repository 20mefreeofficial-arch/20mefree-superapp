<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Database\Seeder;

class OrgSeeder extends Seeder
{
    /**
     * Seed struktur organisasi 20Mefree: role hierarki, divisi, dan posisi staff.
     */
    public function run(): void
    {
        $roles = collect([
            ['name' => 'Super Admin', 'slug' => 'superadmin', 'level' => 1],
            ['name' => 'Manajer', 'slug' => 'manajer', 'level' => 2],
            ['name' => 'SPV', 'slug' => 'spv', 'level' => 3],
            ['name' => 'Leader', 'slug' => 'leader', 'level' => 4],
            ['name' => 'Staff', 'slug' => 'staff', 'level' => 5],
        ])->mapWithKeys(fn ($r) => [$r['slug'] => Role::updateOrCreate(['slug' => $r['slug']], $r)]);

        $divisions = collect([
            ['name' => 'Advertiser', 'slug' => 'adv'],
            ['name' => 'CRM', 'slug' => 'crm'],
            ['name' => 'Branding', 'slug' => 'branding'],
            ['name' => 'Creative', 'slug' => 'creative'],
        ])->mapWithKeys(fn ($d) => [$d['slug'] => Division::updateOrCreate(['slug' => $d['slug']], $d)]);

        $leaderRole = $roles['leader'];
        $staffRole = $roles['staff'];

        $positions = [
            // Advertiser
            ['division' => 'adv', 'role' => $leaderRole, 'name' => 'Leader Advertiser', 'code' => 'leader-adv'],
            ['division' => 'adv', 'role' => $staffRole, 'name' => 'Staff ADV', 'code' => 'staff-adv'],

            // CRM
            ['division' => 'crm', 'role' => $leaderRole, 'name' => 'Leader CRM', 'code' => 'leader-crm'],
            ['division' => 'crm', 'role' => $staffRole, 'name' => 'Staff CRM', 'code' => 'staff-crm'],

            // Branding
            ['division' => 'branding', 'role' => $leaderRole, 'name' => 'Leader Branding', 'code' => 'leader-branding'],
            ['division' => 'branding', 'role' => $staffRole, 'name' => 'Staff SEO', 'code' => 'staff-branding-seo'],
            ['division' => 'branding', 'role' => $staffRole, 'name' => 'Staff SMO', 'code' => 'staff-branding-smo'],
            ['division' => 'branding', 'role' => $staffRole, 'name' => 'Staff Community & Partnership', 'code' => 'staff-branding-community'],
            ['division' => 'branding', 'role' => $staffRole, 'name' => 'Staff CWN', 'code' => 'staff-branding-cwn'],

            // Creative
            ['division' => 'creative', 'role' => $leaderRole, 'name' => 'Leader Creative', 'code' => 'leader-creative'],
            ['division' => 'creative', 'role' => $staffRole, 'name' => 'Staff SMO', 'code' => 'staff-creative-smo'],
            ['division' => 'creative', 'role' => $staffRole, 'name' => 'Staff CWN', 'code' => 'staff-creative-cwn'],
            ['division' => 'creative', 'role' => $staffRole, 'name' => 'Staff CSE', 'code' => 'staff-creative-cse'],
            ['division' => 'creative', 'role' => $staffRole, 'name' => 'Staff Copywriting', 'code' => 'staff-creative-copywriting'],
            ['division' => 'creative', 'role' => $staffRole, 'name' => 'Staff Talent', 'code' => 'staff-creative-talent'],
        ];

        foreach ($positions as $p) {
            Position::updateOrCreate(
                ['code' => $p['code']],
                [
                    'division_id' => $divisions[$p['division']]->id,
                    'role_id' => $p['role']->id,
                    'name' => $p['name'],
                ]
            );
        }
    }
}
