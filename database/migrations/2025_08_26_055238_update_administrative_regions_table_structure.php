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
            // Drop existing foreign key and parent_id column
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
            
            // Drop existing level enum constraint
            $table->dropColumn('level');
            
            // Add new columns based on pdpr_wil_kel structure
            $table->integer('pro_id')->nullable()->after('id');
            $table->integer('dapil_id')->nullable()->after('pro_id');
            $table->integer('kab_id')->nullable()->after('dapil_id');
            $table->integer('kec_id')->nullable()->after('kab_id');
            $table->integer('kel_id')->nullable()->after('kec_id');
            $table->integer('tps_id')->nullable()->after('kel_id');
            
            $table->string('pro_kode', 30)->nullable()->after('tps_id');
            $table->string('dapil_kode', 30)->nullable()->after('pro_kode');
            $table->string('kab_kode', 30)->nullable()->after('dapil_kode');
            $table->string('kec_kode', 30)->nullable()->after('kab_kode');
            $table->string('kel_kode', 30)->nullable()->after('kec_kode');
            $table->string('tps_kode', 30)->nullable()->after('kel_kode');
            
            $table->string('pro_nama', 191)->nullable()->after('tps_kode');
            $table->string('dapil_nama', 191)->nullable()->after('pro_nama');
            $table->string('kab_nama', 191)->nullable()->after('dapil_nama');
            $table->string('kec_nama', 191)->nullable()->after('kab_nama');
            $table->string('kel_nama', 191)->nullable()->after('kec_nama');
            $table->string('tps_nama', 191)->nullable()->after('kel_nama');
            
            $table->integer('tingkat')->nullable()->after('tps_nama');
            $table->mediumText('url')->nullable()->after('tingkat');
            
            // Update existing code column to match varchar(30)
            $table->string('code', 30)->change();
            
            // Add indexes based on original structure
            $table->index('pro_nama', 'namaPro');
            $table->index('kab_nama', 'namaKab');
            $table->index('kec_nama', 'namaKec');
            $table->index('kel_nama', 'namaKel');
            $table->index('kel_id', 'idKel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administrative_regions', function (Blueprint $table) {
            // Drop new indexes
            $table->dropIndex('namaPro');
            $table->dropIndex('namaKab');
            $table->dropIndex('namaKec');
            $table->dropIndex('namaKel');
            $table->dropIndex('idKel');
            
            // Drop new columns
            $table->dropColumn([
                'pro_id', 'dapil_id', 'kab_id', 'kec_id', 'kel_id', 'tps_id',
                'pro_kode', 'dapil_kode', 'kab_kode', 'kec_kode', 'kel_kode', 'tps_kode',
                'pro_nama', 'dapil_nama', 'kab_nama', 'kec_nama', 'kel_nama', 'tps_nama',
                'tingkat', 'url'
            ]);
            
            // Restore original structure
            $table->string('code', 20)->change();
            $table->foreignId('parent_id')->nullable()->constrained('administrative_regions')->onDelete('cascade');
            $table->enum('level', ['kabupaten', 'kecamatan', 'desa']);
            
            // Restore original indexes
            $table->index(['parent_id', 'level']);
            $table->index('code');
        });
    }
};
