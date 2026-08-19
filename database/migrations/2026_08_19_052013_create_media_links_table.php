<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sistem tidak menyimpan file foto/video secara fisik (hemat storage),
     * hanya menyimpan link/URL eksternal (Drive, YouTube, CDN, dll).
     */
    public function up(): void
    {
        Schema::create('media_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('division_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['photo', 'video', 'document', 'other'])->default('other');
            $table->string('title');
            $table->string('url', 2048);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_links');
    }
};
