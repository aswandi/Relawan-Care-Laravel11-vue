@extends('layout.app')

@section('title', 'Tambah Penerima Bantuan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <h4 class="card-title-modern">
                        <i class="fas fa-user-plus"></i>
                        Tambah Penerima Bantuan Baru
                    </h4>
                    <p class="card-subtitle-modern">Lengkapi form di bawah untuk menambahkan penerima bantuan baru</p>
                </div>
                <div class="card-body-modern">
                    <form action="{{ route('beneficiaries.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="family_card_number" class="form-label">Nomor Kartu Keluarga</label>
                                    <input type="text" class="form-control @error('family_card_number') is-invalid @enderror" 
                                           id="family_card_number" name="family_card_number" 
                                           value="{{ old('family_card_number') }}" required>
                                    @error('family_card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="national_id" class="form-label">NIK</label>
                                    <input type="text" class="form-control @error('national_id') is-invalid @enderror" 
                                           id="national_id" name="national_id" 
                                           value="{{ old('national_id') }}" required>
                                    @error('national_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" 
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" 
                                           value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="rt" class="form-label">RT</label>
                                    <input type="text" class="form-control @error('rt') is-invalid @enderror" 
                                           id="rt" name="rt" 
                                           value="{{ old('rt') }}" required>
                                    @error('rt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="rw" class="form-label">RW</label>
                                    <input type="text" class="form-control @error('rw') is-invalid @enderror" 
                                           id="rw" name="rw" 
                                           value="{{ old('rw') }}" required>
                                    @error('rw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="age" class="form-label">Umur</label>
                                    <input type="number" class="form-control @error('age') is-invalid @enderror" 
                                           id="age" name="age" min="1" max="120"
                                           value="{{ old('age') }}" required>
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                            id="gender" name="gender" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kabupaten_id" class="form-label">Kabupaten</label>
                                    <select class="form-control @error('kabupaten_id') is-invalid @enderror" 
                                            id="kabupaten_id" name="kabupaten_id" required>
                                        <option value="">Pilih Kabupaten</option>
                                        @foreach($kabupatenList as $kabupaten)
                                            <option value="{{ $kabupaten->id }}" {{ old('kabupaten_id') == $kabupaten->id ? 'selected' : '' }}>
                                                {{ $kabupaten->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kabupaten_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kecamatan_id" class="form-label">Kecamatan</label>
                                    <select class="form-control @error('kecamatan_id') is-invalid @enderror" 
                                            id="kecamatan_id" name="kecamatan_id" required>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    @error('kecamatan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="desa_id" class="form-label">Desa</label>
                                    <select class="form-control @error('desa_id') is-invalid @enderror" 
                                            id="desa_id" name="desa_id" required>
                                        <option value="">Pilih Desa</option>
                                    </select>
                                    @error('desa_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="beneficiary_group_id" class="form-label">Kelompok Penerima Bantuan</label>
                                    <select class="form-control @error('beneficiary_group_id') is-invalid @enderror" 
                                            id="beneficiary_group_id" name="beneficiary_group_id">
                                        <option value="">Pilih Kelompok (Opsional)</option>
                                        @foreach($beneficiaryGroups as $group)
                                            <option value="{{ $group->id }}" {{ old('beneficiary_group_id') == $group->id ? 'selected' : '' }}>
                                                {{ $group->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('beneficiary_group_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('beneficiaries.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="action-button">
                                <i class="fas fa-save"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('beneficiaries.styles')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kabupatenSelect = document.getElementById('kabupaten_id');
    const kecamatanSelect = document.getElementById('kecamatan_id');
    const desaSelect = document.getElementById('desa_id');

    kabupatenSelect.addEventListener('change', function() {
        const kabupatenId = this.value;
        
        // Reset kecamatan and desa
        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
        
        if (kabupatenId) {
            fetch(`/beneficiaries/kecamatan/${kabupatenId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(kecamatan => {
                        const option = document.createElement('option');
                        option.value = kecamatan.id;
                        option.textContent = kecamatan.display_name;
                        kecamatanSelect.appendChild(option);
                    });
                });
        }
    });

    kecamatanSelect.addEventListener('change', function() {
        const kecamatanId = this.value;
        
        // Reset desa
        desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
        
        if (kecamatanId) {
            fetch(`/beneficiaries/desa/${kecamatanId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(desa => {
                        const option = document.createElement('option');
                        option.value = desa.id;
                        option.textContent = desa.display_name;
                        desaSelect.appendChild(option);
                    });
                });
        }
    });
});
</script>
@endpush