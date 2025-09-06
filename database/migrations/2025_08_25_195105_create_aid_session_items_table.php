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
        Schema::create('aid_session_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aid_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('aid_type_id')->constrained()->onDelete('cascade');
            $table->integer('quantity_available')->nullable();
            $table->decimal('nominal_amount', 12, 2)->nullable();
            $table->timestamps();
            
            $table->unique(['aid_session_id', 'aid_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aid_session_items');
    }
};
