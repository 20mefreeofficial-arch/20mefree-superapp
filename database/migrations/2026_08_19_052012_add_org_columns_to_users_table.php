<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('division_id')->nullable()->after('role_id')->constrained()->nullOnDelete();
            $table->foreignId('position_id')->nullable()->after('division_id')->constrained()->nullOnDelete();
            $table->foreignId('reports_to_id')->nullable()->after('position_id')
                ->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('reports_to_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reports_to_id');
            $table->dropConstrainedForeignId('position_id');
            $table->dropConstrainedForeignId('division_id');
            $table->dropConstrainedForeignId('role_id');
            $table->dropColumn('is_active');
        });
    }
};
