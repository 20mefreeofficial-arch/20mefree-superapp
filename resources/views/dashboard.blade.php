@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="min-h-screen">
    <header class="border-b border-neutral-200 bg-white">
        <div class="mx-auto flex max-w-4xl items-center justify-between px-4 py-4">
            <span class="font-semibold tracking-tight">20Mefree Super APP</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-neutral-500 hover:text-neutral-900">Keluar</button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-4 py-8">
        <h1 class="text-xl font-semibold">Halo, {{ $user->name }} 👋</h1>
        <p class="mt-1 text-sm text-neutral-500">Ini adalah dashboard placeholder tahap awal struktur.</p>

        <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 bg-white p-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Role</dt>
                <dd class="mt-1 text-sm font-medium">{{ $user->role->name ?? '-' }}</dd>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Divisi</dt>
                <dd class="mt-1 text-sm font-medium">{{ $user->division->name ?? '-' }}</dd>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Posisi</dt>
                <dd class="mt-1 text-sm font-medium">{{ $user->position->name ?? '-' }}</dd>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Melapor ke</dt>
                <dd class="mt-1 text-sm font-medium">{{ $user->reportsTo->name ?? '-' }}</dd>
            </div>
        </dl>

        <div class="mt-8 rounded-xl border border-dashed border-neutral-300 p-4 text-sm text-neutral-500">
            Modul bisnis (task, campaign, laporan) akan tampil di sini pada tahap berikutnya,
            disesuaikan dengan hak akses role <strong>{{ $user->role->name ?? '-' }}</strong>.
        </div>
    </main>
</div>
@endsection
