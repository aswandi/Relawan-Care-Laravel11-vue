@extends('layout.app')

@section('title', 'Edit Relawan')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit me-2"></i>
                    Edit Relawan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('volunteers.update', $volunteer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $volunteer->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $volunteer->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">PIN Baru (5 digit)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" maxlength="5" pattern="[0-9]{5}">
                        <div class="form-text">Kosongkan jika tidak ingin mengubah PIN</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="kabupaten_id" class="form-label">Kabupaten <span class="text-danger">*</span></label>
                            <select class="form-select @error('kabupaten_id') is-invalid @enderror" 
                                    id="kabupaten_id" name="kabupaten_id" required>
                                <option value="">Pilih Kabupaten</option>
                                @foreach($kabupatenList as $kabupaten)
                                    <option value="{{ $kabupaten->id }}" 
                                            {{ old('kabupaten_id', $volunteer->kabupaten_id) == $kabupaten->id ? 'selected' : '' }}>
                                        {{ $kabupaten->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kabupaten_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="kecamatan_id" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                            <select class="form-select @error('kecamatan_id') is-invalid @enderror" 
                                    id="kecamatan_id" name="kecamatan_id" required>
                                <option value="">Pilih Kecamatan</option>
                                @foreach($kecamatanList as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" 
                                            {{ old('kecamatan_id', $volunteer->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>
                                        {{ $kecamatan->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kecamatan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="desa_id" class="form-label">Desa <span class="text-danger">*</span></label>
                            <select class="form-select @error('desa_id') is-invalid @enderror" 
                                    id="desa_id" name="desa_id" required>
                                <option value="">Pilih Desa</option>
                                @foreach($desaList as $desa)
                                    <option value="{{ $desa->id }}" 
                                            {{ old('desa_id', $volunteer->desa_id) == $desa->id ? 'selected' : '' }}>
                                        {{ $desa->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('desa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" required>{{ old('address', $volunteer->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   {{ old('is_active', $volunteer->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Status Aktif
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('volunteers.show', $volunteer->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
            fetch(`/volunteers/kecamatan/${kabupatenId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(kecamatan => {
                        const option = document.createElement('option');
                        option.value = kecamatan.id;
                        option.textContent = kecamatan.name;
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
            fetch(`/volunteers/desa/${kecamatanId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(desa => {
                        const option = document.createElement('option');
                        option.value = desa.id;
                        option.textContent = desa.name;
                        desaSelect.appendChild(option);
                    });
                });
        }
    });
});
</script>
@endpush