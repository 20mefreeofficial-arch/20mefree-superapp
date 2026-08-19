<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(OrgSeeder::class);

        $superadmin = Role::where('slug', 'superadmin')->first();

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@20mefree.com',
            'role_id' => $superadmin?->id,
        ]);
    }
}
