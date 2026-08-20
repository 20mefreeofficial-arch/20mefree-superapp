<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Models\Division;
use App\Models\Module;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizePermission($request, 'view');

        $roles = Role::withCount('users')->orderBy('is_system', 'desc')->orderBy('name')->get();

        return view('roles.index', ['roles' => $roles]);
    }

    public function create(Request $request): View
    {
        $this->authorizePermission($request, 'create');

        return view('roles.create');
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        Role::create([
            'name' => $request->validated('name'),
            'slug' => $request->input('slug'),
            'description' => $request->validated('description'),
            'is_system' => false,
        ]);

        return redirect()->route('roles.index')->with('status', 'Role baru berhasil dibuat.');
    }

    public function editPermissions(Request $request, Role $role): View
    {
        $this->authorizePermission($request, 'update');

        $modules = Module::with('functions')->where('is_active', true)->orderBy('sort_order')->get();
        $divisions = Division::orderBy('name')->get();

        $existing = RolePermission::where('role_id', $role->id)->get()
            ->keyBy(fn ($permission) => $permission->module_function_id.'-'.($permission->division_id ?? 'all'));

        return view('roles.permissions', [
            'role' => $role,
            'modules' => $modules,
            'divisions' => $divisions,
            'existing' => $existing,
        ]);
    }

    public function updatePermissions(Request $request, Role $role): RedirectResponse
    {
        $this->authorizePermission($request, 'update');

        if ($role->isSuperAdmin()) {
            return back()->with('error', 'Permission Super Admin selalu penuh dan tidak bisa diubah.');
        }

        $rows = $request->input('permissions', []);

        DB::transaction(function () use ($role, $rows) {
            RolePermission::where('role_id', $role->id)->delete();

            foreach ($rows as $row) {
                $canView = ! empty($row['can_view']);
                $canCreate = ! empty($row['can_create']);
                $canUpdate = ! empty($row['can_update']);
                $canDelete = ! empty($row['can_delete']);

                if (! $canView && ! $canCreate && ! $canUpdate && ! $canDelete) {
                    continue;
                }

                RolePermission::create([
                    'role_id' => $role->id,
                    'module_function_id' => $row['module_function_id'],
                    'division_id' => $row['division_id'] ?: null,
                    'can_view' => $canView,
                    'can_create' => $canCreate,
                    'can_update' => $canUpdate,
                    'can_delete' => $canDelete,
                ]);
            }
        });

        return redirect()->route('roles.index')->with('status', 'Permission role berhasil disimpan.');
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $this->authorizePermission($request, 'delete');

        if ($role->is_system) {
            return back()->with('error', 'Role sistem tidak bisa dihapus.');
        }

        if ($role->users()->exists()) {
            return back()->with('error', 'Role ini masih dipakai oleh pengguna, pindahkan pengguna ke role lain dahulu.');
        }

        // Hard delete permanen (cascade menghapus role_permissions terkait).
        $role->delete();

        return redirect()->route('roles.index')->with('status', 'Role berhasil dihapus permanen.');
    }

    private function authorizePermission(Request $request, string $action): void
    {
        abort_unless($request->user()->hasPermission('user-rbac', 'roles', $action), 403);
    }
}
