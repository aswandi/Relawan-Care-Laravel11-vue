<?php

namespace Database\Seeders;

use App\Models\BeneficiaryGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeneficiaryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Keluarga Miskin',
                'description' => 'Kelompok penerima bantuan untuk keluarga dengan kondisi ekonomi kurang mampu',
                'is_active' => true
            ],
            [
                'name' => 'Lansia',
                'description' => 'Kelompok penerima bantuan untuk lanjut usia',
                'is_active' => true
            ],
            [
                'name' => 'Difabel',
                'description' => 'Kelompok penerima bantuan untuk penyandang disabilitas',
                'is_active' => true
            ],
            [
                'name' => 'Anak Yatim',
                'description' => 'Kelompok penerima bantuan untuk anak yatim piatu',
                'is_active' => true
            ],
            [
                'name' => 'Janda',
                'description' => 'Kelompok penerima bantuan untuk ibu rumah tangga janda',
                'is_active' => true
            ],
            [
                'name' => 'Korban Bencana',
                'description' => 'Kelompok penerima bantuan untuk korban bencana alam',
                'is_active' => true
            ]
        ];

        foreach ($groups as $group) {
            BeneficiaryGroup::create($group);
        }
    }
}
