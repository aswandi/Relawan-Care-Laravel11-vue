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
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->foreignId('beneficiary_group_id')->nullable()->after('desa_id')->constrained('beneficiary_groups')->onDelete('set null');
            $table->index('beneficiary_group_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropForeign(['beneficiary_group_id']);
            $table->dropColumn('beneficiary_group_id');
        });
    }
};
