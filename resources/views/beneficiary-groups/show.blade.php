@extends('layout.app')

@section('title', 'Detail Kelompok Penerima')

@section('content')
<div class="container-fluid px-4">
    <!-- Modern Hero Section -->
    <div class="hero-section animate-fade-in-up">
        <div class="hero-background"></div>
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hero-content">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-layer-group hero-icon bounce-animation"></i>
                        <div>
                            <h1 class="hero-title mb-0">
                                Detail <span class="text-gradient">{{ $beneficiaryGroup->name }}</span>
                            </h1>
                            <p class="hero-subtitle mb-0">Informasi lengkap kelompok penerima bantuan</p>
                        </div>
                    </div>
                    <p class="hero-description">
                        {{ $beneficiaryGroup->description ?: 'Tidak ada deskripsi untuk kelompok ini.' }}
                    </p>
                    <div class="hero-badges">
                        <span class="badge-modern {{ $beneficiaryGroup->is_active ? 'success' : 'danger' }}">
                            <i class="fas fa-{{ $beneficiaryGroup->is_active ? 'check-circle' : 'times-circle' }} me-2"></i>
                            {{ $beneficiaryGroup->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        <span class="badge-modern">
                            <i class="fas fa-users me-2"></i>{{ $beneficiaryGroup->beneficiaries_count }} Penerima
                        </span>
                        <span class="badge-modern weather-widget">
                            <i class="fas fa-calendar me-2"></i>{{ $beneficiaryGroup->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="info-card animate-fade-in-right">
                    <div class="info-item">
                        <i class="fas fa-users info-icon"></i>
                        <span>{{ $beneficiaryGroup->beneficiaries_count }} Penerima</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar-plus info-icon"></i>
                        <span>Dibuat {{ $beneficiaryGroup->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-edit info-icon"></i>
                        <span>Update {{ $beneficiaryGroup->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Group Information Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card animate-fade-in-up">
                <div class="card-header-modern">
                    <h4 class="card-title-modern">
                        <i class="fas fa-info-circle"></i>
                        Informasi Kelompok
                    </h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('beneficiary-groups.edit', $beneficiaryGroup) }}" class="action-button action-button-sm">
                            <span><i class="fas fa-edit me-1"></i>Edit</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="{{ route('beneficiary-groups.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body-modern">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="info-title">
                                    <i class="fas fa-layer-group text-primary me-2"></i>
                                    Detail Kelompok
                                </h6>
                                <div class="info-details">
                                    <div class="info-row">
                                        <span class="info-label">ID Kelompok:</span>
                                        <span class="info-value">#{{ $beneficiaryGroup->id }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Nama Kelompok:</span>
                                        <span class="info-value">{{ $beneficiaryGroup->name }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Status:</span>
                                        <span class="status-badge {{ $beneficiaryGroup->is_active ? 'success' : 'danger' }}">
                                            <i class="fas fa-{{ $beneficiaryGroup->is_active ? 'check-circle' : 'times-circle' }}"></i>
                                            {{ $beneficiaryGroup->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Jumlah Penerima:</span>
                                        <span class="count-badge">
                                            <i class="fas fa-users me-1"></i>
                                            {{ $beneficiaryGroup->beneficiaries_count }} orang
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="info-title">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Informasi Waktu
                                </h6>
                                <div class="info-details">
                                    <div class="info-row">
                                        <span class="info-label">Dibuat:</span>
                                        <span class="info-value">
                                            {{ $beneficiaryGroup->created_at->format('d M Y H:i') }}
                                            <small class="text-muted">({{ $beneficiaryGroup->created_at->diffForHumans() }})</small>
                                        </span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Terakhir Update:</span>
                                        <span class="info-value">
                                            {{ $beneficiaryGroup->updated_at->format('d M Y H:i') }}
                                            <small class="text-muted">({{ $beneficiaryGroup->updated_at->diffForHumans() }})</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($beneficiaryGroup->description)
                        <div class="info-section mt-4">
                            <h6 class="info-title">
                                <i class="fas fa-align-left text-primary me-2"></i>
                                Deskripsi Kelompok
                            </h6>
                            <div class="description-box">
                                {{ $beneficiaryGroup->description }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Beneficiaries List -->
    @if($beneficiaryGroup->beneficiaries->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="modern-card animate-fade-in-up">
                    <div class="card-header-modern">
                        <h4 class="card-title-modern">
                            <i class="fas fa-users"></i>
                            Penerima Bantuan dalam Kelompok
                        </h4>
                        <p class="card-subtitle-modern">
                            Menampilkan {{ $beneficiaryGroup->beneficiaries->count() }} dari {{ $beneficiaryGroup->beneficiaries_count }} penerima
                        </p>
                    </div>
                    <div class="card-body-modern">
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead class="modern-table-header">
                                    <tr>
                                        <th><i class="fas fa-user me-2"></i>Nama</th>
                                        <th><i class="fas fa-id-card me-2"></i>NIK</th>
                                        <th><i class="fas fa-phone me-2"></i>Telepon</th>
                                        <th><i class="fas fa-map-marker-alt me-2"></i>Wilayah</th>
                                        <th><i class="fas fa-birthday-cake me-2"></i>Usia</th>
                                        <th><i class="fas fa-venus-mars me-2"></i>Gender</th>
                                        <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="modern-table-body">
                                    @foreach($beneficiaryGroup->beneficiaries as $index => $beneficiary)
                                        <tr class="modern-table-row">
                                            <td class="modern-table-cell">
                                                <div class="beneficiary-info">
                                                    <div class="beneficiary-avatar">
                                                        <div class="avatar-circle gradient-avatar-{{ ($index % 4) + 1 }}">
                                                            {{ strtoupper(substr($beneficiary->name, 0, 2)) }}
                                                        </div>
                                                    </div>
                                                    <div class="beneficiary-details">
                                                        <div class="beneficiary-name">{{ $beneficiary->name }}</div>
                                                        <div class="beneficiary-meta">{{ $beneficiary->family_card_number }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="modern-table-cell">
                                                <span class="beneficiary-nik">{{ $beneficiary->national_id }}</span>
                                            </td>
                                            <td class="modern-table-cell">
                                                <span class="phone-number">
                                                    <i class="fas fa-phone me-1"></i>
                                                    {{ $beneficiary->phone ?: '-' }}
                                                </span>
                                            </td>
                                            <td class="modern-table-cell">
                                                <div class="location-info">
                                                    <div class="location-badge">{{ $beneficiary->desa->name ?? '-' }}</div>
                                                    <small class="text-muted">{{ $beneficiary->kecamatan->name ?? '-' }}</small>
                                                </div>
                                            </td>
                                            <td class="modern-table-cell">
                                                <span class="age-badge">{{ $beneficiary->age }} tahun</span>
                                            </td>
                                            <td class="modern-table-cell">
                                                <span class="gender-badge {{ $beneficiary->gender === 'female' ? 'female' : 'male' }}">
                                                    <i class="fas fa-{{ $beneficiary->gender === 'female' ? 'venus' : 'mars' }} me-1"></i>
                                                    {{ $beneficiary->gender === 'female' ? 'P' : 'L' }}
                                                </span>
                                            </td>
                                            <td class="modern-table-cell">
                                                <div class="action-buttons">
                                                    <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="action-btn view" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($beneficiaryGroup->beneficiaries_count > 10)
                            <div class="text-center mt-3">
                                <a href="{{ route('beneficiaries.index', ['group' => $beneficiaryGroup->id]) }}" class="action-button">
                                    <span><i class="fas fa-eye me-1"></i>Lihat Semua Penerima</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="modern-card animate-fade-in-up">
                    <div class="card-body-modern text-center py-5">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h6>Belum Ada Penerima dalam Kelompok Ini</h6>
                            <p>Kelompok ini belum memiliki penerima bantuan. Anda dapat menambahkan penerima dengan mengedit data penerima dan memilih kelompok ini.</p>
                            <a href="{{ route('beneficiaries.create') }}" class="action-button mt-3">
                                <span><i class="fas fa-plus me-1"></i>Tambah Penerima Baru</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@include('beneficiary-groups.styles')
@endsection