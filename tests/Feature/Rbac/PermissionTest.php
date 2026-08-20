<?php

namespace Tests\Feature\Rbac;

use App\Models\Division;
use App\Models\Module;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    private function makeModuleFunction(string $moduleSlug = 'user-rbac', string $functionSlug = 'users')
    {
        $module = Module::create(['name' => 'Pengguna & Hak Akses', 'slug' => $moduleSlug]);

        return $module->functions()->create(['name' => 'Manajemen Pengguna', 'slug' => $functionSlug]);
    }

    public function test_super_admin_bypasses_permission_checks(): void
    {
        $role = Role::create(['name' => 'Super Admin', 'slug' => 'super_admin', 'is_system' => true]);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->assertTrue($user->hasPermission('user-rbac', 'users', 'delete'));
    }

    public function test_role_without_granted_permission_is_denied_by_default(): void
    {
        $role = Role::create(['name' => 'Editor', 'slug' => 'editor', 'is_system' => true]);
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->makeModuleFunction();

        $this->assertFalse($user->hasPermission('user-rbac', 'users', 'view'));
    }

    public function test_explicit_permission_grant_allows_access(): void
    {
        $role = Role::create(['name' => 'Administration', 'slug' => 'administration', 'is_system' => true]);
        $function = $this->makeModuleFunction();
        $user = User::factory()->create(['role_id' => $role->id]);

        RolePermission::create([
            'role_id' => $role->id,
            'module_function_id' => $function->id,
            'can_view' => true,
        ]);

        $this->assertTrue($user->hasPermission('user-rbac', 'users', 'view'));
        $this->assertFalse($user->hasPermission('user-rbac', 'users', 'delete'));
    }

    public function test_permission_scoped_to_one_division_does_not_apply_to_another(): void
    {
        $role = Role::create(['name' => 'Supervisor', 'slug' => 'supervisor', 'is_system' => true]);
        $function = $this->makeModuleFunction();
        $sales = Division::create(['name' => 'Sales', 'slug' => 'sales']);
        $nonSales = Division::create(['name' => 'Non-Sales', 'slug' => 'non-sales']);

        RolePermission::create([
            'role_id' => $role->id,
            'module_function_id' => $function->id,
            'division_id' => $sales->id,
            'can_view' => true,
        ]);

        $salesUser = User::factory()->create(['role_id' => $role->id, 'division_id' => $sales->id]);
        $nonSalesUser = User::factory()->create(['role_id' => $role->id, 'division_id' => $nonSales->id]);

        $this->assertTrue($salesUser->hasPermission('user-rbac', 'users', 'view'));
        $this->assertFalse($nonSalesUser->hasPermission('user-rbac', 'users', 'view'));
    }

    public function test_route_denies_403_without_permission(): void
    {
        $role = Role::create(['name' => 'Designer', 'slug' => 'designer', 'is_system' => true]);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->actingAs($user)->get('/users');

        $response->assertForbidden();
    }

    public function test_user_can_be_permanently_deleted_and_stays_deleted(): void
    {
        $superAdminRole = Role::create(['name' => 'Super Admin', 'slug' => 'super_admin', 'is_system' => true]);
        $admin = User::factory()->create(['role_id' => $superAdminRole->id]);

        $otherRole = Role::create(['name' => 'Editor', 'slug' => 'editor', 'is_system' => true]);
        $target = User::factory()->create(['role_id' => $otherRole->id]);

        $this->actingAs($admin)->delete("/users/{$target->id}");

        $this->assertDatabaseMissing('users', ['id' => $target->id]);
    }

    public function test_cannot_delete_the_last_super_admin(): void
    {
        $superAdminRole = Role::create(['name' => 'Super Admin', 'slug' => 'super_admin', 'is_system' => true]);
        $onlySuperAdmin = User::factory()->create(['role_id' => $superAdminRole->id]);

        // Actor dengan permission delete tapi bukan super admin, supaya
        // yang teruji murni proteksi "last super admin", bukan proteksi
        // "tidak bisa hapus diri sendiri".
        $adminRole = Role::create(['name' => 'Administration', 'slug' => 'administration', 'is_system' => true]);
        $function = $this->makeModuleFunction();
        RolePermission::create([
            'role_id' => $adminRole->id,
            'module_function_id' => $function->id,
            'can_view' => true,
            'can_delete' => true,
        ]);
        $actor = User::factory()->create(['role_id' => $adminRole->id]);

        $this->actingAs($actor)->delete("/users/{$onlySuperAdmin->id}");

        $this->assertDatabaseHas('users', ['id' => $onlySuperAdmin->id]);
    }
}
