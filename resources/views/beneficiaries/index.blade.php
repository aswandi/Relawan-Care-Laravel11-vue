@extends('layout.app')

@section('title', 'Daftar Penerima Bantuan')

@section('content')
<div class="container-fluid px-4">
    <!-- Modern Hero Section -->
    <div class="hero-section animate-fade-in-up">
        <div class="hero-background"></div>
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hero-content">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-user-friends hero-icon bounce-animation"></i>
                        <div>
                            <h1 class="hero-title mb-0">
                                Manajemen <span class="text-gradient">Penerima Bantuan</span>
                            </h1>
                            <p class="hero-subtitle mb-0">Kelola data penerima bantuan dengan mudah</p>
                        </div>
                    </div>
                    <p class="hero-description">
                        Sistem manajemen penerima bantuan yang terintegrasi untuk memudahkan pendataan, 
                        monitoring, dan distribusi bantuan kepada masyarakat yang membutuhkan.
                    </p>
                    <div class="hero-badges">
                        <span class="badge-modern">
                            <i class="fas fa-database me-2"></i>Data Terpusat
                        </span>
                        <span class="badge-modern">
                            <i class="fas fa-chart-line me-2"></i>Analisis Real-time
                        </span>
                        <span class="badge-modern weather-widget">
                            <i class="fas fa-cloud-sun me-2"></i>{{ date('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="info-card animate-fade-in-right">
                    <div class="info-item">
                        <i class="fas fa-users info-icon"></i>
                        <span>Total: {{ $beneficiaries->total() }} Penerima</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt info-icon"></i>
                        <span>Multi Wilayah</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-shield-alt info-icon"></i>
                        <span>Data Terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="modern-stats-card gradient-blue animate-scale-in">
                <i class="fas fa-user-friends stats-icon"></i>
                <div class="stats-content">
                    <span class="stats-number">{{ $beneficiaries->total() }}</span>
                    <span class="stats-label">Total Penerima</span>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>Semua data</span>
                    </div>
                </div>
                <div class="stats-decoration">
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="modern-stats-card gradient-green animate-scale-in">
                <i class="fas fa-check-circle stats-icon"></i>
                <div class="stats-content">
                    <span class="stats-number">{{ $beneficiaries->where('is_active', true)->count() }}</span>
                    <span class="stats-label">Penerima Aktif</span>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>Status aktif</span>
                    </div>
                </div>
                <div class="stats-decoration">
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="modern-stats-card gradient-purple animate-scale-in">
                <i class="fas fa-calendar-plus stats-icon"></i>
                <div class="stats-content">
                    <span class="stats-number">{{ $beneficiaries->where('created_at', '>=', now()->startOfMonth())->count() }}</span>
                    <span class="stats-label">Baru Bulan Ini</span>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ date('M Y') }}</span>
                    </div>
                </div>
                <div class="stats-decoration">
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="modern-stats-card gradient-orange animate-scale-in">
                <i class="fas fa-chart-pie stats-icon"></i>
                <div class="stats-content">
                    <span class="stats-number">{{ number_format(($beneficiaries->where('gender', 'female')->count() / max($beneficiaries->count(), 1)) * 100, 1) }}%</span>
                    <span class="stats-label">Perempuan</span>
                    <div class="stats-trend">
                        <i class="fas fa-venus"></i>
                        <span>Rasio gender</span>
                    </div>
                </div>
                <div class="stats-decoration">
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Card for Beneficiaries List -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card animate-fade-in-up">
                <div class="card-header-modern">
                    <h4 class="card-title-modern">
                        <i class="fas fa-list"></i>
                        Daftar Penerima Bantuan
                    </h4>
                    <p class="card-subtitle-modern">Kelola dan pantau data penerima bantuan</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('beneficiaries.create') }}" class="action-button">
                                <span><i class="fas fa-plus me-1"></i>Tambah Penerima</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <button type="button" class="action-button" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);" data-bs-toggle="modal" data-bs-target="#importModal">
                                <span><i class="fas fa-file-excel me-1"></i>Import Excel</span>
                                <i class="fas fa-upload"></i>
                            </button>
                        </div>
                        <div class="search-box">
                            <form method="GET" action="{{ route('beneficiaries.index') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Cari penerima..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern">
                    <table class="table modern-table">
                        <thead class="modern-table-header">
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>No KK</th>
                                <th><i class="fas fa-id-card me-2"></i>NIK</th>
                                <th><i class="fas fa-user me-2"></i>Nama</th>
                                <th><i class="fas fa-phone me-2"></i>Telepon</th>
                                <th><i class="fas fa-map-marker-alt me-2"></i>Wilayah</th>
                                <th><i class="fas fa-users me-2"></i>Kelompok</th>
                                <th><i class="fas fa-birthday-cake me-2"></i>Usia</th>
                                <th><i class="fas fa-venus-mars me-2"></i>Gender</th>
                                <th><i class="fas fa-toggle-on me-2"></i>Status</th>
                                <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="modern-table-body">
                            @forelse($beneficiaries as $index => $beneficiary)
                                <tr class="modern-table-row">
                                    <td class="modern-table-cell">
                                        <span class="beneficiary-code">{{ $beneficiary->family_card_number }}</span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="beneficiary-nik">{{ $beneficiary->national_id }}</span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="beneficiary-info">
                                            <div class="beneficiary-avatar">
                                                <div class="avatar-circle gradient-avatar-{{ ($index % 4) + 1 }}">
                                                    {{ strtoupper(substr($beneficiary->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="beneficiary-details">
                                                <div class="beneficiary-name">{{ $beneficiary->name }}</div>
                                                <div class="beneficiary-meta">RT {{ $beneficiary->rt }}/RW {{ $beneficiary->rw }}</div>
                                            </div>
                                        </div>
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
                                        <span class="group-badge">
                                            <i class="fas fa-users me-1"></i>
                                            {{ $beneficiary->beneficiaryGroup->name ?? 'Tidak Ada Kelompok' }}
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="age-badge">{{ $beneficiary->age }} tahun</span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="gender-badge {{ $beneficiary->gender === 'female' ? 'female' : 'male' }}">
                                            <i class="fas fa-{{ $beneficiary->gender === 'female' ? 'venus' : 'mars' }} me-1"></i>
                                            {{ $beneficiary->gender === 'female' ? 'Perempuan' : 'Laki-laki' }}
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="status-badge {{ $beneficiary->is_active ? 'success' : 'danger' }}">
                                            <i class="fas fa-{{ $beneficiary->is_active ? 'check-circle' : 'times-circle' }}"></i>
                                            {{ $beneficiary->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="action-buttons">
                                            <a href="{{ route('beneficiaries.show', $beneficiary) }}" class="action-btn view" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="action-btn edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="modern-table-cell">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-user-friends"></i>
                                            </div>
                                            <h6>Belum Ada Data Penerima Bantuan</h6>
                                            <p>Mulai dengan menambahkan penerima bantuan pertama ke dalam sistem</p>
                                            <a href="{{ route('beneficiaries.create') }}" class="action-button mt-3">
                                                <span><i class="fas fa-plus me-1"></i>Tambah Penerima Pertama</span>
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Modern Pagination -->
                @if($beneficiaries->hasPages())
                    <div class="modern-pagination">
                        {{ $beneficiaries->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Import Excel Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-file-excel me-2"></i>Import Data Penerima Bantuan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('beneficiaries.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="excel_file" class="form-label">File Excel</label>
                                <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xlsx,.xls" required>
                                <div class="form-text">Format yang didukung: .xlsx, .xls (Maksimal 10MB)</div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Format File Excel:</h6>
                        <p class="mb-2">File Excel harus memiliki kolom berikut (sesuai urutan):</p>
                        <ol class="mb-0">
                            <li>No KK (family_card_number)</li>
                            <li>NIK (national_id)</li>
                            <li>Nama (name)</li>
                            <li>Telepon (phone)</li>
                            <li>Alamat (address)</li>
                            <li>RT (rt)</li>
                            <li>RW (rw)</li>
                            <li>Kabupaten (kabupaten_name)</li>
                            <li>Kecamatan (kecamatan_name)</li>
                            <li>Desa (desa_name)</li>
                            <li>Kelompok (group_name - opsional)</li>
                            <li>Usia (age)</li>
                            <li>Gender (male/female)</li>
                        </ol>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('beneficiaries.template') }}" class="btn btn-outline-success">
                            <i class="fas fa-download me-1"></i>Download Template Excel
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i>Import Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('beneficiaries.styles')
@endsection