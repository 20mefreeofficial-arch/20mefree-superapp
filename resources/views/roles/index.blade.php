@extends('layouts.authenticated')

@section('title', 'Role & Permission - ' . config('app.name'))

@section('page-content')
<div class="flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-lg font-semibold text-neutral-900 sm:text-xl">Role & Permission</h1>
        <p class="mt-1 text-sm text-neutral-500">Kelola role sistem dan role custom beserta hak aksesnya.</p>
    </div>

    @if (auth()->user()->hasPermission('user-rbac', 'roles', 'create'))
        <a href="{{ route('roles.create') }}"
            class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
            + Tambah Role Custom
        </a>
    @endif
</div>

<div class="mt-6 overflow-x-auto rounded-xl border border-neutral-200 bg-white">
    <table class="w-full min-w-[560px] text-left text-sm">
        <thead class="border-b border-neutral-200 bg-neutral-50 text-xs font-medium uppercase tracking-wide text-neutral-500">
            <tr>
                <th class="px-4 py-3">Nama Role</th>
                <th class="px-4 py-3">Tipe</th>
                <th class="px-4 py-3">Jumlah Pengguna</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
            @forelse ($roles as $role)
                <tr>
                    <td class="px-4 py-3 font-medium text-neutral-900">{{ $role->name }}</td>
                    <td class="px-4 py-3">
                        @if ($role->is_system)
                            <span class="inline-flex items-center rounded-full bg-neutral-100 px-2.5 py-0.5 text-xs font-medium text-neutral-700">Sistem</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-primary-50 px-2.5 py-0.5 text-xs font-medium text-primary">Custom</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-neutral-500">{{ $role->users_count }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            @if (auth()->user()->hasPermission('user-rbac', 'roles', 'update'))
                                @if ($role->isSuperAdmin())
                                    <span class="text-sm text-neutral-400">Full access otomatis</span>
                                @else
                                    <a href="{{ route('roles.permissions.edit', $role) }}" class="text-sm font-medium text-neutral-600 hover:text-primary">Atur Permission</a>
                                @endif
                            @endif
                            @if (auth()->user()->hasPermission('user-rbac', 'roles', 'delete') && ! $role->is_system)
                                <form method="POST" action="{{ route('roles.destroy', $role) }}"
                                    onsubmit="return confirm('Hapus role {{ $role->name }} secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-neutral-600 hover:text-primary">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-sm text-neutral-400">Belum ada role.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
