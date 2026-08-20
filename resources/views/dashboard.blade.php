@extends('layouts.authenticated')

@section('title', 'Dashboard - ' . config('app.name'))

@section('page-content')
<h1 class="text-lg font-semibold text-neutral-900 sm:text-xl">Halo, {{ $user->name }}</h1>
<p class="mt-1 text-sm text-neutral-500">Ini adalah dashboard placeholder tahap awal struktur.</p>

<dl class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-3 sm:gap-4">
    <div class="rounded-xl border border-neutral-200 bg-white p-4">
        <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Role</dt>
        <dd class="mt-1 text-sm font-medium text-neutral-900">{{ $user->role->name ?? '-' }}</dd>
    </div>
    <div class="rounded-xl border border-neutral-200 bg-white p-4">
        <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Divisi</dt>
        <dd class="mt-1 text-sm font-medium text-neutral-900">{{ $user->division->name ?? 'Semua divisi' }}</dd>
    </div>
    <div class="rounded-xl border border-neutral-200 bg-white p-4">
        <dt class="text-xs font-medium uppercase tracking-wide text-neutral-400">Melapor ke</dt>
        <dd class="mt-1 text-sm font-medium text-neutral-900">{{ $user->reportsTo->name ?? '-' }}</dd>
    </div>
</dl>

<div class="mt-6 rounded-xl border border-dashed border-neutral-300 p-4 text-sm text-neutral-500 sm:mt-8">
    Modul bisnis (produksi konten, campaign, laporan) akan tampil di sini pada tahap berikutnya,
    disesuaikan dengan hak akses role <strong class="text-neutral-700">{{ $user->role->name ?? '-' }}</strong>.
</div>
@endsection
