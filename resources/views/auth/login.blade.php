@extends('layouts.app')

@section('title', 'Masuk - ' . config('app.name'))

@section('content')
<div class="flex min-h-screen items-center justify-center px-4 py-10 sm:px-6">
    <div class="w-full max-w-sm">
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-11 w-11 items-center justify-center rounded-full bg-primary text-sm font-semibold text-white sm:h-12 sm:w-12">
                20M
            </div>
            <h1 class="text-xl font-semibold tracking-tight text-neutral-900 sm:text-2xl">20Mefree Super APP</h1>
            <p class="mt-1 text-sm text-neutral-500">Masuk ke akun Anda</p>
        </div>

        <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm sm:p-8">
            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-primary-100 bg-primary-50 px-4 py-3 text-sm text-primary-700" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
                @csrf

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-neutral-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username"
                        class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-neutral-700">Password</label>
                    <input id="password" type="password" name="password" required
                        autocomplete="current-password"
                        class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">
                </div>

                <label class="flex items-center gap-2 text-sm text-neutral-600">
                    <input type="checkbox" name="remember" class="rounded border-neutral-300 text-primary focus:ring-primary-100">
                    Ingat saya
                </label>

                <button type="submit"
                    class="w-full rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary-100 focus:ring-offset-2">
                    Masuk
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-neutral-400">
            &copy; {{ now()->year }} 20Mefree Super APP
        </p>
    </div>
</div>
@endsection
