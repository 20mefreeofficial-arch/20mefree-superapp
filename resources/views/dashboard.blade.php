@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="min-h-screen">
    <header class="border-b border-neutral-200 bg-white">
        <div class="mx-auto flex max-w-4xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
            <div class="flex items-center gap-2.5">
                <span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-primary text-xs font-semibold text-white">20M</span>
                <span class="truncate font-semibold tracking-tight text-neutral-900">20Mefree Super APP</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex-shrink-0 text-sm text-neutral-500 transition hover:text-primary">Keluar</button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 sm:py-10">
        <h1 class="text-lg font-semibold text-neutral-900 sm:text-xl">Halo, {{ $user->name }}</h1>
        <p class="mt-1 text-sm text-neutral-500">Ini adalah dashboard placeholder tahap awal struktur.</p>

        <dl class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Role</dt>
                <dd class="mt-1 text-sm font-medium text-neutral-900">{{ $user->role->name ?? '-' }}</dd>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Divisi</dt>
                <dd class="mt-1 text-sm font-medium text-neutral-900">{{ $user->division->name ?? '-' }}</dd>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Posisi</dt>
                <dd class="mt-1 text-sm font-medium text-neutral-900">{{ $user->position->name ?? '-' }}</dd>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4">
                <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Melapor ke</dt>
                <dd class="mt-1 text-sm font-medium text-neutral-900">{{ $user->reportsTo->name ?? '-' }}</dd>
            </div>
        </dl>

        <div class="mt-6 rounded-xl border border-dashed border-neutral-300 p-4 text-sm text-neutral-500 sm:mt-8">
            Modul bisnis (task, campaign, laporan) akan tampil di sini pada tahap berikutnya,
            disesuaikan dengan hak akses role <strong class="text-neutral-700">{{ $user->role->name ?? '-' }}</strong>.
        </div>
    </main>
</div>
@endsection
