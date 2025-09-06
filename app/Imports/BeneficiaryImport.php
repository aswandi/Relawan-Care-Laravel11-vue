<?php

namespace App\Imports;

use App\Models\Beneficiary;
use App\Models\AdministrativeRegion;
use App\Models\BeneficiaryGroup;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class BeneficiaryImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Find administrative regions by name
        $kabupaten = AdministrativeRegion::where('name', $row['kabupaten'])
            ->where('level', 'kabupaten')
            ->first();
            
        $kecamatan = AdministrativeRegion::where('name', $row['kecamatan'])
            ->where('level', 'kecamatan')
            ->where('parent_id', $kabupaten?->id)
            ->first();
            
        $desa = AdministrativeRegion::where('name', $row['desa'])
            ->where('level', 'desa')
            ->where('parent_id', $kecamatan?->id)
            ->first();
            
        // Find beneficiary group by name if provided
        $beneficiaryGroup = null;
        if (!empty($row['kelompok'])) {
            $beneficiaryGroup = BeneficiaryGroup::where('name', $row['kelompok'])
                ->where('is_active', true)
                ->first();
        }

        return new Beneficiary([
            'family_card_number' => $row['nomor_kk'],
            'national_id' => $row['nik'],
            'name' => $row['nama'],
            'phone' => $row['telepon'] ?? null,
            'address' => $row['alamat'],
            'rt' => $row['rt'],
            'rw' => $row['rw'],
            'kabupaten_id' => $kabupaten?->id,
            'kecamatan_id' => $kecamatan?->id,
            'desa_id' => $desa?->id,
            'beneficiary_group_id' => $beneficiaryGroup?->id,
            'age' => $row['umur'],
            'gender' => strtolower($row['jenis_kelamin']) === 'laki-laki' ? 'male' : 'female',
            'is_active' => true,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nomor_kk' => 'required|string|max:20|unique:beneficiaries,family_card_number',
            'nik' => 'required|string|max:20|unique:beneficiaries,national_id',
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'required|string|max:500',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'kelompok' => 'nullable|string',
            'umur' => 'required|integer|min:1|max:120',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan,laki-laki,perempuan',
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'nomor_kk.required' => 'Nomor KK wajib diisi',
            'nomor_kk.unique' => 'Nomor KK sudah terdaftar',
            'nik.required' => 'NIK wajib diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama.required' => 'Nama wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'rt.required' => 'RT wajib diisi',
            'rw.required' => 'RW wajib diisi',
            'kabupaten.required' => 'Kabupaten wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'desa.required' => 'Desa wajib diisi',
            'umur.required' => 'Umur wajib diisi',
            'umur.integer' => 'Umur harus berupa angka',
            'umur.min' => 'Umur minimal 1 tahun',
            'umur.max' => 'Umur maksimal 120 tahun',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan',
        ];
    }
}