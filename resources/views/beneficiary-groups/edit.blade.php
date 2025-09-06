@extends('layout.app')

@section('title', 'Edit Kelompok Penerima')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <h4 class="card-title-modern">
                        <i class="fas fa-edit"></i>
                        Edit Kelompok Penerima Bantuan
                    </h4>
                    <p class="card-subtitle-modern">Perbarui informasi kelompok: {{ $beneficiaryGroup->name }}</p>
                </div>
                <div class="card-body-modern">
                    <form action="{{ route('beneficiary-groups.update', $beneficiaryGroup) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Kelompok</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-layer-group text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" 
                                               value="{{ old('name', $beneficiaryGroup->name) }}" 
                                               placeholder="Masukkan nama kelompok penerima bantuan"
                                               required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" 
                                               id="is_active" name="is_active" 
                                               {{ old('is_active', $beneficiaryGroup->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <i class="fas fa-toggle-on me-1 text-success"></i>
                                            Status Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-align-left text-primary"></i>
                                </span>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4"
                                          placeholder="Masukkan deskripsi kelompok penerima bantuan (opsional)">{{ old('description', $beneficiaryGroup->description) }}</textarea>
                            </div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Deskripsi akan membantu dalam mengidentifikasi karakteristik kelompok ini.
                            </div>
                        </div>

                        <!-- Warning if group has beneficiaries -->
                        @if($beneficiaryGroup->beneficiaries()->count() > 0)
                            <div class="alert alert-warning">
                                <div class="d-flex">
                                    <i class="fas fa-exclamation-triangle me-3 mt-1"></i>
                                    <div>
                                        <h6>Perhatian!</h6>
                                        <p class="mb-0">
                                            Kelompok ini memiliki <strong>{{ $beneficiaryGroup->beneficiaries()->count() }} penerima bantuan</strong>. 
                                            Perubahan yang Anda lakukan akan mempengaruhi semua penerima dalam kelompok ini.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <div class="d-flex">
                                <i class="fas fa-lightbulb me-3 mt-1"></i>
                                <div>
                                    <h6>Tips Edit Kelompok:</h6>
                                    <ul class="mb-0">
                                        <li>Pastikan nama kelompok tetap deskriptif dan mudah dipahami</li>
                                        <li>Jika mengubah karakteristik kelompok, pastikan penerima masih sesuai</li>
                                        <li>Nonaktifkan kelompok jika tidak akan digunakan lagi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('beneficiary-groups.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="action-button">
                                <span><i class="fas fa-save me-1"></i>Update Kelompok</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('beneficiary-groups.styles')
@endsection