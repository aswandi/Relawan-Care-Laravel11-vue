<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenSeeder extends Seeder
{
    public function run(): void
    {
        $kabupatenData = [
            [
                'id' => 191351,
                'name' => 'BOJONEGORO',
                'code' => '3522',
                'pro_id' => 191099,
                'dapil_id' => 7676,
                'kab_id' => 191351,
                'kec_id' => 0,
                'kel_id' => 0,
                'tps_id' => 0,
                'pro_kode' => '35',
                'dapil_kode' => '3509',
                'kab_kode' => '3522',
                'kec_kode' => '0',
                'kel_kode' => '0',
                'tps_kode' => '0',
                'pro_nama' => 'JAWA TIMUR',
                'dapil_nama' => 'JAWA TIMUR IX',
                'kab_nama' => 'BOJONEGORO',
                'kec_nama' => '',
                'kel_nama' => '',
                'tps_nama' => '',
                'tingkat' => 2,
                'url' => 'https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/pdpr/35/3509.json',
                'created_at' => '2025-01-01 17:39:43',
                'updated_at' => null
            ],
            [
                'id' => 191352,
                'name' => 'TUBAN',
                'code' => '3523',
                'pro_id' => 191099,
                'dapil_id' => 7676,
                'kab_id' => 191352,
                'kec_id' => 0,
                'kel_id' => 0,
                'tps_id' => 0,
                'pro_kode' => '35',
                'dapil_kode' => '3509',
                'kab_kode' => '3523',
                'kec_kode' => '0',
                'kel_kode' => '0',
                'tps_kode' => '0',
                'pro_nama' => 'JAWA TIMUR',
                'dapil_nama' => 'JAWA TIMUR IX',
                'kab_nama' => 'TUBAN',
                'kec_nama' => '',
                'kel_nama' => '',
                'tps_nama' => '',
                'tingkat' => 2,
                'url' => 'https://sirekap-obj-data.kpu.go.id/wilayah/pemilu/pdpr/35/3509.json',
                'created_at' => '2025-01-01 17:39:43',
                'updated_at' => null
            ]
        ];

        DB::table('administrative_regions')->insert($kabupatenData);
    }
}