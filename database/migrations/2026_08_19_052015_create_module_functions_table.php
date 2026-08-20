<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fungsi (sub-bagian) di dalam sebuah modul, mis. modul "Creative
     * Production" punya fungsi "Project Management", "Content Calendar",
     * dst. Permission (CRUD) diberikan per fungsi ini, bukan per modul.
     */
    public function up(): void
    {
        Schema::create('module_functions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['module_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_functions');
    }
};
