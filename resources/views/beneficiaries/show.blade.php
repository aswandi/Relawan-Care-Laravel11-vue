@extends('layout.app')

@section('title', 'Detail Penerima Bantuan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <h4 class="card-title-modern">
                        <i class="fas fa-user"></i>
                        Detail Penerima Bantuan
                    </h4>
                    <p class="card-subtitle-modern">Informasi lengkap penerima bantuan</p>
                </div>
                <div class="card-body-modern">
                    <div class="row">
                        <!-- Profile Section -->
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                <div class="beneficiary-avatar mx-auto mb-3">
                                    <div class="avatar-circle gradient-avatar-{{ ($beneficiary->id % 4) + 1 }}">
                                        {{ strtoupper(substr($beneficiary->name, 0, 2)) }}
                                    </div>
                                </div>
                                <h5 class="beneficiary-name">{{ $beneficiary->name }}</h5>
                                <div class="mb-2">
                                    <span class="beneficiary-code">{{ $beneficiary->family_card_number }}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="beneficiary-nik">{{ $beneficiary->national_id }}</span>
                                </div>
                                <div class="mb-3">
                                    @if($beneficiary->is_active)
                                        <span class="status-badge success">
                                            <i class="fas fa-check-circle"></i> Aktif
                                        </span>
                                    @else
                                        <span class="status-badge danger">
                                            <i class="fas fa-times-circle"></i> Tidak Aktif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Information Section -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Informasi Personal</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Umur:</td>
                                            <td>
                                                <span class="age-badge">{{ $beneficiary->age }} tahun</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Jenis Kelamin:</td>
                                            <td>
                                                <span class="gender-badge {{ $beneficiary->gender }}">
                                                    <i class="fas fa-{{ $beneficiary->gender == 'male' ? 'mars' : 'venus' }}"></i>
                                                    {{ $beneficiary->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Telepon:</td>
                                            <td>
                                                @if($beneficiary->phone)
                                                    <span class="phone-number">
                                                        <i class="fas fa-phone"></i> {{ $beneficiary->phone }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Tidak ada</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Informasi Alamat</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">RT/RW:</td>
                                            <td>{{ $beneficiary->rt }}/{{ $beneficiary->rw }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Desa:</td>
                                            <td>
                                                <span class="location-badge">{{ $beneficiary->desa->name ?? '-' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Kecamatan:</td>
                                            <td>
                                                <span class="location-badge">{{ $beneficiary->kecamatan->name ?? '-' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Kabupaten:</td>
                                            <td>
                                                <span class="location-badge">{{ $beneficiary->kabupaten->name ?? '-' }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="text-muted mb-3">Alamat Lengkap</h6>
                                    <div class="p-3 bg-light rounded">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        {{ $beneficiary->address }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('beneficiaries.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                                <div>
                                    <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="action-btn edit me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penerima bantuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Activity History Section -->
                    @if($beneficiary->activities && $beneficiary->activities->count() > 0)
                    <div class="row mt-5">
                        <div class="col-12">
                            <h6 class="text-muted mb-3">Riwayat Aktivitas</h6>
                            <div class="activity-timeline">
                                @foreach($beneficiary->activities->take(5) as $activity)
                                <div class="activity-item">
                                    <div class="activity-avatar">
                                        <div class="avatar-circle gradient-avatar-{{ ($loop->index % 4) + 1 }}">
                                            <i class="fas fa-hands-helping"></i>
                                        </div>
                                    </div>
                                    <div class="activity-content">
                                        <h6 class="activity-title">{{ $activity->description ?? 'Aktivitas Bantuan' }}</h6>
                                        <p class="activity-meta">
                                            <i class="fas fa-calendar"></i> {{ $activity->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('beneficiaries.styles')
@endsection