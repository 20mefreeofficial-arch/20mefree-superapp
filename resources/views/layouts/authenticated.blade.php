@extends('layouts.app')

@php
    $currentUser = auth()->user();
    $navItems = collect([
        ['label' => 'Dashboard', 'route' => 'dashboard', 'visible' => true],
        ['label' => 'Pengguna', 'route' => 'users.index', 'visible' => $currentUser->hasPermission('user-rbac', 'users', 'view')],
        ['label' => 'Role & Permission', 'route' => 'roles.index', 'visible' => $currentUser->hasPermission('user-rbac', 'roles', 'view')],
    ])->where('visible', true);
@endphp

@section('content')
<div class="min-h-screen">
    <header class="border-b border-neutral-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-4 py-3 sm:px-6">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-primary text-xs font-semibold text-white">20M</span>
                    <span class="hidden truncate font-semibold tracking-tight text-neutral-900 sm:inline">20Mefree Super APP</span>
                </a>

                <nav class="flex items-center gap-1">
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                            class="rounded-lg px-3 py-1.5 text-sm font-medium transition {{ request()->routeIs(explode('.', $item['route'])[0].'*') ? 'bg-primary-50 text-primary' : 'text-neutral-600 hover:bg-neutral-100' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="flex items-center gap-3">
                <span class="hidden text-sm text-neutral-500 sm:inline">{{ $currentUser->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-neutral-500 transition hover:text-primary">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-10">
        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-lg border border-primary-100 bg-primary-50 px-4 py-3 text-sm text-primary-700">
                {{ session('error') }}
            </div>
        @endif

        @yield('page-content')
    </main>
</div>
@endsection
