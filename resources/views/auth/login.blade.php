@extends('layouts.app')

@section('title', 'Login - ' . config('app.name'))

@section('content')
<div class="flex min-h-screen items-center justify-center px-4">
    <div class="w-full max-w-sm">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-semibold tracking-tight">20Mefree Super APP</h1>
            <p class="mt-1 text-sm text-neutral-500">Masuk ke akun Anda</p>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-neutral-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:border-neutral-900 focus:outline-none focus:ring-1 focus:ring-neutral-900">
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-neutral-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:border-neutral-900 focus:outline-none focus:ring-1 focus:ring-neutral-900">
                </div>

                <label class="flex items-center gap-2 text-sm text-neutral-600">
                    <input type="checkbox" name="remember" class="rounded border-neutral-300">
                    Ingat saya
                </label>

                <button type="submit"
                    class="w-full rounded-lg bg-neutral-900 px-4 py-2 text-sm font-medium text-white hover:bg-neutral-800">
                    Masuk
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-neutral-400">
            Akun dummy tersedia untuk setiap role/posisi &mdash; lihat <code>docs/AKUN-DUMMY.md</code>.
        </p>
    </div>
</div>
@endsection
