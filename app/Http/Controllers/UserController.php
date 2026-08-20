<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Division;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizePermission($request, 'view');

        $users = User::with(['role', 'division'])
            ->orderBy('name')
            ->paginate(20);

        return view('users.index', ['users' => $users]);
    }

    public function create(Request $request): View
    {
        $this->authorizePermission($request, 'create');

        return view('users.create', [
            'roles' => Role::orderBy('name')->get(),
            'divisions' => Division::orderBy('name')->get(),
            'potentialManagers' => User::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()->route('users.index')->with('status', 'Pengguna baru berhasil dibuat.');
    }

    public function edit(Request $request, User $user): View
    {
        $this->authorizePermission($request, 'update');

        return view('users.edit', [
            'targetUser' => $user,
            'roles' => Role::orderBy('name')->get(),
            'divisions' => Division::orderBy('name')->get(),
            'potentialManagers' => User::where('id', '!=', $user->id)->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('status', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorizePermission($request, 'delete');

        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        if ($user->isSuperAdmin() && User::whereHas('role', fn ($q) => $q->where('slug', 'super_admin'))->count() <= 1) {
            return back()->with('error', 'Tidak bisa menghapus Super Admin terakhir.');
        }

        // Hard delete permanen — tidak ada soft-delete, data tidak akan
        // "muncul lagi" setelah dihapus.
        $user->delete();

        return redirect()->route('users.index')->with('status', 'Pengguna berhasil dihapus permanen.');
    }

    private function authorizePermission(Request $request, string $action): void
    {
        abort_unless($request->user()->hasPermission('user-rbac', 'users', $action), 403);
    }
}
