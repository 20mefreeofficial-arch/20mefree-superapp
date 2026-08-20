@extends('layouts.authenticated')

@section('title', 'Tambah Role - ' . config('app.name'))

@section('page-content')
<div class="mx-auto max-w-xl">
    <h1 class="text-lg font-semibold text-neutral-900 sm:text-xl">Tambah Role Custom</h1>
    <p class="mt-1 text-sm text-neutral-500">Setelah dibuat, atur permission modul/fungsi-nya dari halaman Role & Permission.</p>

    <div class="mt-6 rounded-xl border border-neutral-200 bg-white p-6">
        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-primary-100 bg-primary-50 px-4 py-3 text-sm text-primary-700">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('roles.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-1.5 block text-sm font-medium text-neutral-700">Nama Role</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">
            </div>

            <div>
                <label for="description" class="mb-1.5 block text-sm font-medium text-neutral-700">Deskripsi (opsional)</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">{{ old('description') }}</textarea>
            </div>

            <button type="submit"
                class="w-full rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                Simpan Role
            </button>
        </form>
    </div>
</div>
@endsection
