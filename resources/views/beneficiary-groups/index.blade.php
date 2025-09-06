@extends('layout.app')

@section('title', 'Kelompok Penerima Bantuan')

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
                                Manajemen <span class="text-gradient">Kelompok Penerima</span>
                            </h1>
                            <p class="hero-subtitle mb-0">Kelola kategorisasi penerima bantuan berdasarkan kelompok</p>
                        </div>
                    </div>
                    <p class="hero-description">
                        Sistem manajemen kelompok penerima bantuan untuk kategorisasi dan segmentasi 
                        yang lebih baik dalam distribusi bantuan sosial.
                    </p>
                    <div class="hero-badges">
                        <span class="badge-modern">
                            <i class="fas fa-users me-2"></i>Kategorisasi
                        </span>
                        <span class="badge-modern">
                            <i class="fas fa-chart-bar me-2"></i>Segmentasi
                        </span>
                        <span class="badge-modern weather-widget">
                            <i class="fas fa-layer-group me-2"></i>{{ date('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="info-card animate-fade-in-right">
                    <div class="info-item">
                        <i class="fas fa-layer-group info-icon"></i>
                        <span>Total: {{ $groups->total() }} Kelompok</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-check-circle info-icon"></i>
                        <span>Kelompok Aktif: {{ $groups->where('is_active', true)->count() }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-shield-alt info-icon"></i>
                        <span>Data Terorganisir</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="modern-stats-card gradient-purple animate-scale-in">
                <i class="fas fa-layer-group stats-icon"></i>
                <div class="stats-content">
                    <span class="stats-number">{{ $groups->total() }}</span>
                    <span class="stats-label">Total Kelompok</span>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>Semua kategori</span>
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
                    <span class="stats-number">{{ $groups->where('is_active', true)->count() }}</span>
                    <span class="stats-label">Kelompok Aktif</span>
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
            <div class="modern-stats-card gradient-blue animate-scale-in">
                <i class="fas fa-users stats-icon"></i>
                <div class="stats-content">
                    <span class="stats-number">{{ $groups->sum('beneficiaries_count') }}</span>
                    <span class="stats-label">Total Penerima</span>
                    <div class="stats-trend">
                        <i class="fas fa-user-friends"></i>
                        <span>Dalam kelompok</span>
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
                <i class="fas fa-calendar-plus stats-icon"></i>
                <div class="stats-content">
                    <span class="stats-number">{{ $groups->where('created_at', '>=', now()->startOfMonth())->count() }}</span>
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
    </div>

    <!-- Modern Card for Groups List -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card animate-fade-in-up">
                <div class="card-header-modern">
                    <h4 class="card-title-modern">
                        <i class="fas fa-list"></i>
                        Daftar Kelompok Penerima Bantuan
                    </h4>
                    <p class="card-subtitle-modern">Kelola dan pantau kelompok penerima bantuan</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('beneficiary-groups.create') }}" class="action-button">
                                <span><i class="fas fa-plus me-1"></i>Tambah Kelompok</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="search-box">
                            <form method="GET" action="{{ route('beneficiary-groups.index') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Cari kelompok..." value="{{ request('search') }}">
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
                                <th><i class="fas fa-layer-group me-2"></i>Nama Kelompok</th>
                                <th><i class="fas fa-align-left me-2"></i>Deskripsi</th>
                                <th><i class="fas fa-users me-2"></i>Jumlah Penerima</th>
                                <th><i class="fas fa-toggle-on me-2"></i>Status</th>
                                <th><i class="fas fa-calendar me-2"></i>Dibuat</th>
                                <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="modern-table-body">
                            @forelse($groups as $index => $group)
                                <tr class="modern-table-row">
                                    <td class="modern-table-cell">
                                        <div class="group-info">
                                            <div class="group-avatar">
                                                <div class="avatar-circle gradient-avatar-{{ ($index % 4) + 1 }}">
                                                    <i class="fas fa-layer-group"></i>
                                                </div>
                                            </div>
                                            <div class="group-details">
                                                <div class="group-name">{{ $group->name }}</div>
                                                <div class="group-meta">ID: {{ $group->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="description-text">
                                            {{ Str::limit($group->description, 60) ?: 'Tidak ada deskripsi' }}
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="count-badge">
                                            <i class="fas fa-users me-1"></i>
                                            {{ $group->beneficiaries_count }} orang
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="status-badge {{ $group->is_active ? 'success' : 'danger' }}">
                                            <i class="fas fa-{{ $group->is_active ? 'check-circle' : 'times-circle' }}"></i>
                                            {{ $group->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="date-info">
                                            <div class="date-badge">{{ $group->created_at->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $group->created_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="action-buttons">
                                            <a href="{{ route('beneficiary-groups.show', $group) }}" class="action-btn view" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('beneficiary-groups.edit', $group) }}" class="action-btn edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('beneficiary-groups.destroy', $group) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kelompok ini? Data akan hilang permanen.')">
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
                                    <td colspan="6" class="modern-table-cell">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-layer-group"></i>
                                            </div>
                                            <h6>Belum Ada Kelompok Penerima</h6>
                                            <p>Mulai dengan menambahkan kelompok penerima bantuan ke dalam sistem</p>
                                            <a href="{{ route('beneficiary-groups.create') }}" class="action-button mt-3">
                                                <span><i class="fas fa-plus me-1"></i>Tambah Kelompok Pertama</span>
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
                @if($groups->hasPages())
                    <div class="modern-pagination">
                        {{ $groups->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('beneficiary-groups.styles')
@endsection