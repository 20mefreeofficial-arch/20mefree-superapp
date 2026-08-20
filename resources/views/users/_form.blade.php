@php
    $isEdit = $targetUser !== null;
@endphp

<div>
    <label for="name" class="mb-1.5 block text-sm font-medium text-neutral-700">Nama</label>
    <input id="name" type="text" name="name" value="{{ old('name', $targetUser->name ?? '') }}" required
        class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">
</div>

<div>
    <label for="email" class="mb-1.5 block text-sm font-medium text-neutral-700">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email', $targetUser->email ?? '') }}" required
        class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">
</div>

<div>
    <label for="password" class="mb-1.5 block text-sm font-medium text-neutral-700">
        Password {{ $isEdit ? '(kosongkan jika tidak diganti)' : '' }}
    </label>
    <input id="password" type="password" name="password" {{ $isEdit ? '' : 'required' }}
        class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">
</div>

<div>
    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-neutral-700">Konfirmasi Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" {{ $isEdit ? '' : 'required' }}
        class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">
</div>

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <label for="role_id" class="mb-1.5 block text-sm font-medium text-neutral-700">Role</label>
        <select id="role_id" name="role_id" required
            class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">
            <option value="">Pilih role</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" @selected(old('role_id', $targetUser->role_id ?? '') == $role->id)>{{ $role->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="division_id" class="mb-1.5 block text-sm font-medium text-neutral-700">Divisi</label>
        <select id="division_id" name="division_id"
            class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">
            <option value="">Semua divisi</option>
            @foreach ($divisions as $division)
                <option value="{{ $division->id }}" @selected(old('division_id', $targetUser->division_id ?? '') == $division->id)>{{ $division->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div>
    <label for="reports_to_id" class="mb-1.5 block text-sm font-medium text-neutral-700">Melapor ke</label>
    <select id="reports_to_id" name="reports_to_id"
        class="w-full rounded-lg border border-neutral-300 px-3 py-2.5 text-sm text-neutral-900 transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary-100">
        <option value="">Tidak ada</option>
        @foreach ($potentialManagers as $manager)
            <option value="{{ $manager->id }}" @selected(old('reports_to_id', $targetUser->reports_to_id ?? '') == $manager->id)>{{ $manager->name }}</option>
        @endforeach
    </select>
</div>

<label class="flex items-center gap-2 text-sm text-neutral-600">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" class="rounded border-neutral-300 text-primary focus:ring-primary-100"
        @checked(old('is_active', $targetUser->is_active ?? true))>
    Akun aktif
</label>
