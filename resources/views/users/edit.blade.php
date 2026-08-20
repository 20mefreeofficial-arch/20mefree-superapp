@extends('layouts.authenticated')

@section('title', 'Edit Pengguna - ' . config('app.name'))

@section('page-content')
<div class="mx-auto max-w-xl">
    <h1 class="text-lg font-semibold text-neutral-900 sm:text-xl">Edit Pengguna</h1>
    <p class="mt-1 text-sm text-neutral-500">Perbarui data, role, atau divisi {{ $targetUser->name }}.</p>

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

        <form method="POST" action="{{ route('users.update', $targetUser) }}" class="space-y-5">
            @csrf
            @method('PUT')
            @include('users._form', ['targetUser' => $targetUser])

            <button type="submit"
                class="w-full rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
