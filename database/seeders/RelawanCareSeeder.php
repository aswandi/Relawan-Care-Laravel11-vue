<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AdministrativeRegion;
use App\Models\AidType;
use App\Models\AidSession;
use App\Models\AidSessionItem;
use App\Models\Volunteer;
use App\Models\Beneficiary;

class RelawanCareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Users are now seeded by UserSeeder
        
        // Seed administrative regions
        $this->call(AdministrativeRegionSeeder::class);

        // Create aid types
        $kalender = AidType::create([
            'name' => 'Kalender',
            'description' => 'Kalender tahun 2024',
            'has_nominal' => false,
            'unit' => 'pcs',
            'is_active' => true
        ]);

        $baju = AidType::create([
            'name' => 'Baju',
            'description' => 'Pakaian bekas layak pakai',
            'has_nominal' => false,
            'unit' => 'pcs',
            'is_active' => true
        ]);

        $beras = AidType::create([
            'name' => 'Beras',
            'description' => 'Beras premium kualitas baik',
            'has_nominal' => false,
            'unit' => 'kg',
            'is_active' => true
        ]);

        $uangTunai = AidType::create([
            'name' => 'Uang Tunai',
            'description' => 'Bantuan uang tunai',
            'has_nominal' => true,
            'unit' => 'rupiah',
            'is_active' => true
        ]);

        $minyakGoreng = AidType::create([
            'name' => 'Minyak Goreng',
            'description' => 'Minyak goreng kemasan 1 liter',
            'has_nominal' => false,
            'unit' => 'liter',
            'is_active' => true
        ]);

        // Create aid sessions
        $session1 = AidSession::create([
            'name' => 'Sesi Bantuan 1 - Januari 2024',
            'description' => 'Distribusi bantuan periode Januari 2024',
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-31',
            'is_active' => true
        ]);

        $session2 = AidSession::create([
            'name' => 'Sesi Bantuan 2 - Februari 2024',
            'description' => 'Distribusi bantuan periode Februari 2024',
            'start_date' => '2024-02-01',
            'end_date' => '2024-02-29',
            'is_active' => true
        ]);

        // Create aid session items
        AidSessionItem::create([
            'aid_session_id' => $session1->id,
            'aid_type_id' => $kalender->id,
            'quantity_available' => 1000,
            'nominal_amount' => null
        ]);

        AidSessionItem::create([
            'aid_session_id' => $session1->id,
            'aid_type_id' => $baju->id,
            'quantity_available' => 500,
            'nominal_amount' => null
        ]);

        AidSessionItem::create([
            'aid_session_id' => $session1->id,
            'aid_type_id' => $beras->id,
            'quantity_available' => 2000,
            'nominal_amount' => null
        ]);

        AidSessionItem::create([
            'aid_session_id' => $session1->id,
            'aid_type_id' => $uangTunai->id,
            'quantity_available' => null,
            'nominal_amount' => 500000.00
        ]);

        AidSessionItem::create([
            'aid_session_id' => $session2->id,
            'aid_type_id' => $beras->id,
            'quantity_available' => 1500,
            'nominal_amount' => null
        ]);

        AidSessionItem::create([
            'aid_session_id' => $session2->id,
            'aid_type_id' => $uangTunai->id,
            'quantity_available' => null,
            'nominal_amount' => 750000.00
        ]);

        AidSessionItem::create([
            'aid_session_id' => $session2->id,
            'aid_type_id' => $minyakGoreng->id,
            'quantity_available' => 800,
            'nominal_amount' => null
        ]);

        // Get administrative regions for volunteers and beneficiaries
        $bogor = AdministrativeRegion::where('code', '3201')->first();
        $nanggung = AdministrativeRegion::where('code', '320101')->first();
        $leuwiliang = AdministrativeRegion::where('code', '320102')->first();
        $desaNanggung = AdministrativeRegion::where('code', '32010101')->first();
        $desaLeuwiliang = AdministrativeRegion::where('code', '32010201')->first();

        // Create volunteers
        Volunteer::create([
            'volunteer_code' => 'REL001',
            'name' => 'Ahmad Santoso',
            'phone' => '08123456789',
            'password' => '12345', // 5 digit PIN
            'kabupaten_id' => $bogor->id,
            'kecamatan_id' => $nanggung->id,
            'desa_id' => $desaNanggung->id,
            'address' => 'Jl. Raya Nanggung No. 123',
            'is_active' => true
        ]);

        Volunteer::create([
            'volunteer_code' => 'REL002',
            'name' => 'Siti Nurhaliza',
            'phone' => '08198765432',
            'password' => '54321', // 5 digit PIN
            'kabupaten_id' => $bogor->id,
            'kecamatan_id' => $leuwiliang->id,
            'desa_id' => $desaLeuwiliang->id,
            'address' => 'Jl. Leuwiliang Raya No. 456',
            'is_active' => true
        ]);

        // Create beneficiaries
        Beneficiary::create([
            'family_card_number' => '3201012345678901',
            'national_id' => '3201011234567890',
            'name' => 'Budi Hartono',
            'phone' => '081234567890',
            'address' => 'Jl. Mawar No. 10',
            'rt' => '001',
            'rw' => '005',
            'kabupaten_id' => $bogor->id,
            'kecamatan_id' => $nanggung->id,
            'desa_id' => $desaNanggung->id,
            'age' => 45,
            'gender' => 'male',
            'is_active' => true
        ]);

        Beneficiary::create([
            'family_card_number' => '3201012345678902',
            'national_id' => '3201011234567891',
            'name' => 'Sari Dewi',
            'phone' => '081234567891',
            'address' => 'Jl. Melati No. 15',
            'rt' => '002',
            'rw' => '005',
            'kabupaten_id' => $bogor->id,
            'kecamatan_id' => $nanggung->id,
            'desa_id' => $desaNanggung->id,
            'age' => 38,
            'gender' => 'female',
            'is_active' => true
        ]);

        Beneficiary::create([
            'family_card_number' => '3201012345678903',
            'national_id' => '3201011234567892',
            'name' => 'Joni Iskandar',
            'phone' => '081234567892',
            'address' => 'Jl. Kenanga No. 20',
            'rt' => '003',
            'rw' => '006',
            'kabupaten_id' => $bogor->id,
            'kecamatan_id' => $leuwiliang->id,
            'desa_id' => $desaLeuwiliang->id,
            'age' => 52,
            'gender' => 'male',
            'is_active' => true
        ]);
    }
}