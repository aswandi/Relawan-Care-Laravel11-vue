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
        Schema::create('activity_aids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_activity_id')->constrained()->onDelete('cascade');
            $table->foreignId('aid_type_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('nominal_amount', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('volunteer_activity_id');
            $table->index('aid_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_aids');
    }
};
