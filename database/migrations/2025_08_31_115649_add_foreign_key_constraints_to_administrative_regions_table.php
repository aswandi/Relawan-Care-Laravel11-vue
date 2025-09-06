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
        Schema::table('administrative_regions', function (Blueprint $table) {
            // Add foreign key constraint for kab_id referencing id when tingkat=3 (kecamatan)
            $table->foreign('kab_id')
                ->references('id')
                ->on('administrative_regions')
                ->onDelete('cascade')
                ->name('fk_administrative_regions_kab_id');

            // Add foreign key constraint for kec_id referencing id when tingkat=4 (kelurahan/desa)
            $table->foreign('kec_id')
                ->references('id')
                ->on('administrative_regions')
                ->onDelete('cascade')
                ->name('fk_administrative_regions_kec_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administrative_regions', function (Blueprint $table) {
            $table->dropForeign('fk_administrative_regions_kab_id');
            $table->dropForeign('fk_administrative_regions_kec_id');
        });
    }
};
