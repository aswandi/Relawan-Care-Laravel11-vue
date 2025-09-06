<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('administrative_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('administrative_regions')->onDelete('cascade');
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->enum('level', ['kabupaten', 'kecamatan', 'desa']);
            $table->timestamps();
            
            $table->index(['parent_id', 'level']);
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_regions');
    }
};
