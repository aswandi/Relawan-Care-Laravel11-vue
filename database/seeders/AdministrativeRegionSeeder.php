<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdministrativeRegion;

class AdministrativeRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data based on pdpr_wil_kel structure
        AdministrativeRegion::create([
            'pro_id' => 191099,
            'dapil_id' => 7676,
            'kab_id' => 191351,
            'kec_id' => 150060,
            'kel_id' => 150061,
            'tps_id' => 0,
            'pro_kode' => '35',
            'dapil_kode' => '3509',
            'kab_kode' => '3522',
            'kec_kode' => '352201',
            'kel_kode' => '3522012001',
            'tps_kode' => '',
            'pro_nama' => 'JAWA TIMUR',
            'dapil_nama' => 'JAWA TIMUR IX', 
            'kab_nama' => 'BOJONEGORO',
            'kec_nama' => 'NGRAHO',
            'kel_nama' => 'LUWIHAJI',
            'tps_nama' => '',
            'tingkat' => 3,
            'url' => 'https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/pdpr/35/3509/3522/352201.json',
            'code' => '3522012001',
            'name' => 'LUWIHAJI'
        ]);

        // Add more sample data for different levels
        AdministrativeRegion::create([
            'pro_id' => 191099,
            'dapil_id' => 7676, 
            'kab_id' => 191351,
            'kec_id' => null,
            'kel_id' => null,
            'tps_id' => null,
            'pro_kode' => '35',
            'dapil_kode' => '3509',
            'kab_kode' => '3522',
            'kec_kode' => null,
            'kel_kode' => null,
            'tps_kode' => null,
            'pro_nama' => 'JAWA TIMUR',
            'dapil_nama' => 'JAWA TIMUR IX',
            'kab_nama' => 'BOJONEGORO', 
            'kec_nama' => null,
            'kel_nama' => null,
            'tps_nama' => null,
            'tingkat' => 1,
            'url' => 'https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/pdpr/35/3509/3522.json',
            'code' => '3522',
            'name' => 'BOJONEGORO'
        ]);

        AdministrativeRegion::create([
            'pro_id' => 191099,
            'dapil_id' => 7676,
            'kab_id' => 191351,
            'kec_id' => 150060,
            'kel_id' => null,
            'tps_id' => null,
            'pro_kode' => '35',
            'dapil_kode' => '3509', 
            'kab_kode' => '3522',
            'kec_kode' => '352201',
            'kel_kode' => null,
            'tps_kode' => null,
            'pro_nama' => 'JAWA TIMUR',
            'dapil_nama' => 'JAWA TIMUR IX',
            'kab_nama' => 'BOJONEGORO',
            'kec_nama' => 'NGRAHO',
            'kel_nama' => null,
            'tps_nama' => null,
            'tingkat' => 2,
            'url' => 'https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/pdpr/35/3509/3522/352201.json',
            'code' => '352201',
            'name' => 'NGRAHO'
        ]);
    }
}
