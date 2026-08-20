@extends('layouts.authenticated')

@section('title', 'Permission ' . $role->name . ' - ' . config('app.name'))

@section('page-content')
<div>
    <h1 class="text-lg font-semibold text-neutral-900 sm:text-xl">Permission — {{ $role->name }}</h1>
    <p class="mt-1 text-sm text-neutral-500">
        Centang akses per modul, fungsi, dan divisi. Baris "Semua Divisi" berlaku untuk semua konteks divisi.
    </p>

    <form method="POST" action="{{ route('roles.permissions.update', $role) }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        @php $rowIndex = 0; @endphp

        @foreach ($modules as $module)
            <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white">
                <div class="border-b border-neutral-200 bg-neutral-50 px-4 py-3">
                    <h2 class="text-sm font-semibold text-neutral-900">{{ $module->name }}</h2>
                    @if ($module->description)
                        <p class="mt-0.5 text-xs text-neutral-500">{{ $module->description }}</p>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[560px] text-left text-sm">
                        <thead class="text-xs font-medium uppercase tracking-wide text-neutral-500">
                            <tr>
                                <th class="px-4 py-2.5">Fungsi</th>
                                <th class="px-4 py-2.5">Divisi</th>
                                <th class="px-3 py-2.5 text-center">Lihat</th>
                                <th class="px-3 py-2.5 text-center">Tambah</th>
                                <th class="px-3 py-2.5 text-center">Ubah</th>
                                <th class="px-3 py-2.5 text-center">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @foreach ($module->functions as $function)
                                @php
                                    $scopeOptions = collect([['id' => null, 'label' => 'Semua Divisi']])
                                        ->merge($divisions->map(fn ($d) => ['id' => $d->id, 'label' => $d->name]));
                                @endphp
                                @foreach ($scopeOptions as $i => $scope)
                                    @php
                                        $existingRow = $existing->get($function->id.'-'.($scope['id'] ?? 'all'));
                                    @endphp
                                    <tr>
                                        @if ($i === 0)
                                            <td class="px-4 py-2.5 font-medium text-neutral-900" rowspan="{{ $scopeOptions->count() }}">
                                                {{ $function->name }}
                                            </td>
                                        @endif
                                        <td class="px-4 py-2.5 text-neutral-500">{{ $scope['label'] }}</td>
                                        <td class="px-3 py-2.5 text-center">
                                            <input type="hidden" name="permissions[{{ $rowIndex }}][module_function_id]" value="{{ $function->id }}">
                                            <input type="hidden" name="permissions[{{ $rowIndex }}][division_id]" value="{{ $scope['id'] }}">
                                            <input type="checkbox" name="permissions[{{ $rowIndex }}][can_view]" value="1"
                                                class="rounded border-neutral-300 text-primary focus:ring-primary-100"
                                                @checked($existingRow?->can_view)>
                                        </td>
                                        <td class="px-3 py-2.5 text-center">
                                            <input type="checkbox" name="permissions[{{ $rowIndex }}][can_create]" value="1"
                                                class="rounded border-neutral-300 text-primary focus:ring-primary-100"
                                                @checked($existingRow?->can_create)>
                                        </td>
                                        <td class="px-3 py-2.5 text-center">
                                            <input type="checkbox" name="permissions[{{ $rowIndex }}][can_update]" value="1"
                                                class="rounded border-neutral-300 text-primary focus:ring-primary-100"
                                                @checked($existingRow?->can_update)>
                                        </td>
                                        <td class="px-3 py-2.5 text-center">
                                            <input type="checkbox" name="permissions[{{ $rowIndex }}][can_delete]" value="1"
                                                class="rounded border-neutral-300 text-primary focus:ring-primary-100"
                                                @checked($existingRow?->can_delete)>
                                        </td>
                                    </tr>
                                    @php $rowIndex++; @endphp
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        <div class="flex justify-end gap-3">
            <a href="{{ route('roles.index') }}" class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50">Batal</a>
            <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">Simpan Permission</button>
        </div>
    </form>
</div>
@endsection
