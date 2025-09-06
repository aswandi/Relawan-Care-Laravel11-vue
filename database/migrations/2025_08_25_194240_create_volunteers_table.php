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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('volunteer_code', 20)->unique();
            $table->string('name');
            $table->string('phone', 20)->unique();
            $table->string('password');
            $table->foreignId('kabupaten_id')->constrained('administrative_regions');
            $table->foreignId('kecamatan_id')->constrained('administrative_regions');
            $table->foreignId('desa_id')->constrained('administrative_regions');
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('phone');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
