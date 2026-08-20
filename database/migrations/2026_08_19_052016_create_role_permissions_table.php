<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hak akses CRUD sebuah role terhadap satu fungsi modul.
     * division_id NULL = berlaku di semua divisi; diisi = permission ini
     * hanya berlaku ketika user sedang beroperasi dalam konteks divisi itu.
     * Super Admin tidak butuh baris di sini — selalu full access (lihat
     * User::hasPermission()), baris untuk super_admin hanya untuk tampilan
     * matrix permission di UI supaya konsisten terlihat "semua tercentang".
     */
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('module_function_id')->constrained()->cascadeOnDelete();
            $table->foreignId('division_id')->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('can_view')->default(false);
            $table->boolean('can_create')->default(false);
            $table->boolean('can_update')->default(false);
            $table->boolean('can_delete')->default(false);
            $table->timestamps();

            $table->unique(['role_id', 'module_function_id', 'division_id'], 'role_function_division_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
