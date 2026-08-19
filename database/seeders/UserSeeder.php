<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Password dummy yang sama untuk semua akun contoh — hanya untuk
     * kebutuhan development/demo, wajib diganti sebelum produksi.
     */
    public const DUMMY_PASSWORD = 'password123';

    public function run(): void
    {
        $superadmin = $this->createUser(
            name: 'Super Admin',
            email: 'superadmin@20mefree.com',
            role: Role::where('slug', 'superadmin')->firstOrFail(),
        );

        $manajer = $this->createUser(
            name: 'Manajer',
            email: 'manajer@20mefree.com',
            role: Role::where('slug', 'manajer')->firstOrFail(),
            reportsTo: $superadmin,
        );

        $spv = $this->createUser(
            name: 'SPV',
            email: 'spv@20mefree.com',
            role: Role::where('slug', 'spv')->firstOrFail(),
            reportsTo: $manajer,
        );

        $leaders = [];

        foreach (Position::with('division', 'role')->whereHas('role', fn ($q) => $q->where('slug', 'leader'))->get() as $position) {
            $leaders[$position->division->slug] = $this->createUser(
                name: $position->name,
                email: str_replace('-', '.', $position->code).'@20mefree.com',
                role: $position->role,
                division: $position->division,
                position: $position,
                reportsTo: $spv,
            );
        }

        foreach (Position::with('division', 'role')->whereHas('role', fn ($q) => $q->where('slug', 'staff'))->get() as $position) {
            $this->createUser(
                name: $position->name,
                email: str_replace('-', '.', $position->code).'@20mefree.com',
                role: $position->role,
                division: $position->division,
                position: $position,
                reportsTo: $leaders[$position->division->slug] ?? null,
            );
        }
    }

    private function createUser(
        string $name,
        string $email,
        Role $role,
        ?Division $division = null,
        ?Position $position = null,
        ?User $reportsTo = null,
    ): User {
        return User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => self::DUMMY_PASSWORD,
                'role_id' => $role->id,
                'division_id' => $division?->id,
                'position_id' => $position?->id,
                'reports_to_id' => $reportsTo?->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
