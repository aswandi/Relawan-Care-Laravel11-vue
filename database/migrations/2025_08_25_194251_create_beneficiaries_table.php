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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('family_card_number', 20)->unique();
            $table->string('national_id', 20)->unique();
            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->text('address');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->foreignId('kabupaten_id')->constrained('administrative_regions');
            $table->foreignId('kecamatan_id')->constrained('administrative_regions');
            $table->foreignId('desa_id')->constrained('administrative_regions');
            $table->integer('age');
            $table->enum('gender', ['male', 'female']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('family_card_number');
            $table->index('national_id');
            $table->index(['kabupaten_id', 'kecamatan_id', 'desa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
