@extends('layouts.authenticated')

@section('title', 'Pengguna - ' . config('app.name'))

@section('page-content')
<div class="flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-lg font-semibold text-neutral-900 sm:text-xl">Pengguna</h1>
        <p class="mt-1 text-sm text-neutral-500">Kelola akun, role, dan divisi anggota tim.</p>
    </div>

    @if (auth()->user()->hasPermission('user-rbac', 'users', 'create'))
        <a href="{{ route('users.create') }}"
            class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
            + Tambah Pengguna
        </a>
    @endif
</div>

<div class="mt-6 overflow-x-auto rounded-xl border border-neutral-200 bg-white">
    <table class="w-full min-w-[640px] text-left text-sm">
        <thead class="border-b border-neutral-200 bg-neutral-50 text-xs font-medium uppercase tracking-wide text-neutral-500">
            <tr>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Divisi</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
            @forelse ($users as $user)
                <tr>
                    <td class="px-4 py-3 font-medium text-neutral-900">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-neutral-500">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center rounded-full bg-neutral-100 px-2.5 py-0.5 text-xs font-medium text-neutral-700">
                            {{ $user->role->name ?? '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-neutral-500">{{ $user->division->name ?? 'Semua divisi' }}</td>
                    <td class="px-4 py-3">
                        @if ($user->is_active)
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Aktif</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-neutral-100 px-2.5 py-0.5 text-xs font-medium text-neutral-500">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            @if (auth()->user()->hasPermission('user-rbac', 'users', 'update'))
                                <a href="{{ route('users.edit', $user) }}" class="text-sm font-medium text-neutral-600 hover:text-primary">Edit</a>
                            @endif
                            @if (auth()->user()->hasPermission('user-rbac', 'users', 'delete') && $user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user) }}"
                                    onsubmit="return confirm('Hapus pengguna {{ $user->name }} secara permanen? Tindakan ini tidak bisa dibatalkan.');">
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
                    <td colspan="6" class="px-4 py-8 text-center text-sm text-neutral-400">Belum ada pengguna.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
