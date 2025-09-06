@extends('layout.app')

@section('title', 'Data Kecamatan - ' . $kabupaten->kab_nama)

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb modern-breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('administrative-regions.index') }}">
                <i class="fas fa-building me-1"></i>Kabupaten/Kota
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="fas fa-map me-1"></i>{{ $kabupaten->kab_nama }}
        </li>
    </ol>
</nav>

<!-- Modern Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="hero-section">
            <div class="hero-background"></div>
            <div class="hero-content">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="hero-text animate-fade-in-up">
                            <h1 class="hero-title">
                                <i class="fas fa-map hero-icon bounce-animation"></i>
                                Kecamatan di <span class="text-gradient">{{ $kabupaten->kab_nama }}</span>
                            </h1>
                            <p class="hero-subtitle">Data Kecamatan di {{ $kabupaten->kab_nama }}</p>
                            <p class="hero-description">Pantau dan kelola informasi lengkap kecamatan untuk monitoring distribusi bantuan</p>
                            <div class="hero-badges">
                                <span class="badge badge-modern">🗺️ {{ $kecamatan->count() }} Kecamatan</span>
                                <span class="badge badge-modern">📍 {{ $kabupaten->kab_nama }}</span>
                                <span class="badge badge-modern">⚡ Real-time</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="hero-info animate-fade-in-right">
                            <div class="info-card">
                                <div class="info-item">
                                    <i class="fas fa-calendar-day info-icon"></i>
                                    <span>{{ now()->format('d F Y') }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-clock info-icon"></i>
                                    <span id="current-time">{{ now()->format('H:i') }} WIB</span>
                                </div>
                                <div class="weather-widget">
                                    <i class="fas fa-map-check"></i>
                                    <span>Sistem Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Statistics Cards -->
<div class="row mb-5">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="modern-stats-card gradient-green animate-scale-in" style="animation-delay: 0.1s;">
            <div class="stats-icon">
                <i class="fas fa-map pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $kecamatan->count() }}">{{ $kecamatan->count() }}</div>
                <div class="stats-label">Total Kecamatan</div>
                <div class="stats-trend">
                    <i class="fas fa-check-circle"></i>
                    <span>Di {{ $kabupaten->kab_nama }}</span>
                </div>
            </div>
            <div class="stats-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="modern-stats-card gradient-purple animate-scale-in" style="animation-delay: 0.2s;">
            <div class="stats-icon">
                <i class="fas fa-home pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $kecamatan->sum('jumlah_kelurahan') }}">{{ $kecamatan->sum('jumlah_kelurahan') }}</div>
                <div class="stats-label">Total Desa/Kelurahan</div>
                <div class="stats-trend">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Di semua kecamatan</span>
                </div>
            </div>
            <div class="stats-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="modern-stats-card gradient-yellow animate-scale-in" style="animation-delay: 0.3s;">
            <div class="stats-icon">
                <i class="fas fa-users pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $kecamatan->sum('jumlah_relawan') }}">{{ $kecamatan->sum('jumlah_relawan') }}</div>
                <div class="stats-label">Total Relawan</div>
                <div class="stats-trend">
                    <i class="fas fa-user-check"></i>
                    <span>Relawan terdaftar</span>
                </div>
            </div>
            <div class="stats-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-map"></i>
                    Daftar Kecamatan di {{ $kabupaten->kab_nama }}
                </h5>
                <p class="card-subtitle-modern">Data kecamatan dengan statistik lengkap desa/kelurahan, relawan dan penerima bantuan</p>
            </div>
            <div class="card-body-modern">
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead class="modern-table-header">
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>No</th>
                                <th><i class="fas fa-map me-2"></i>Nama Kecamatan</th>
                                <th><i class="fas fa-home me-2"></i>Jumlah Kelurahan/Desa</th>
                                <th><i class="fas fa-users me-2"></i>Jumlah Relawan</th>
                                <th><i class="fas fa-user-friends me-2"></i>Jumlah Penduduk</th>
                            </tr>
                        </thead>
                        <tbody class="modern-table-body">
                            @forelse($kecamatan as $kec)
                                <tr class="modern-table-row animate-fade-in" style="animation-delay: {{ 0.1 * $loop->index }}s;">
                                    <td class="modern-table-cell">
                                        <span class="region-number">{{ $loop->iteration }}</span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="region-info">
                                            <div class="region-avatar">
                                                <div class="avatar-circle gradient-avatar-{{ ($loop->index % 4) + 1 }}">
                                                    {{ substr($kec->kec_nama, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="region-details">
                                                <a href="{{ route('administrative-regions.desa', $kec->kec_id) }}" class="region-name-link">
                                                    <span class="region-name">{{ $kec->kec_nama }}</span>
                                                </a>
                                                <small class="region-meta">Kode: {{ $kec->kec_kode }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="count-badge desa">
                                            <i class="fas fa-home me-1"></i>
                                            {{ number_format($kec->jumlah_kelurahan) }}
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="count-badge relawan">
                                            <i class="fas fa-users me-1"></i>
                                            {{ number_format($kec->jumlah_relawan) }}
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="count-badge penduduk">
                                            <i class="fas fa-user-friends me-1"></i>
                                            {{ number_format($kec->jumlah_penduduk) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="modern-table-cell">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-map"></i>
                                            </div>
                                            <h6>Belum Ada Data Kecamatan</h6>
                                            <p>Data kecamatan di {{ $kabupaten->kab_nama }} belum tersedia dalam sistem</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Breadcrumb Styles */
.modern-breadcrumb {
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.modern-breadcrumb .breadcrumb-item a {
    color: #667eea;
    text-decoration: none;
    transition: all 0.3s ease;
}

.modern-breadcrumb .breadcrumb-item a:hover {
    color: #764ba2;
    font-weight: 600;
}

.modern-breadcrumb .breadcrumb-item.active {
    color: #2d3748;
    font-weight: 600;
}

/* Copy all styles from index.blade.php */
.hero-section {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    margin-bottom: 2rem;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    opacity: 0.95;
}

.hero-background::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
}

.hero-content {
    position: relative;
    z-index: 2;
    padding: 3rem 2rem;
    color: white;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.text-gradient {
    background: linear-gradient(45deg, #ffd89b 0%, #19547b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-icon {
    font-size: 3rem;
    margin-right: 1rem;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
}

.hero-subtitle {
    font-size: 1.4rem;
    font-weight: 600;
    opacity: 0.9;
    margin-bottom: 0.5rem;
}

.hero-description {
    font-size: 1.1rem;
    opacity: 0.8;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.hero-badges {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.badge-modern {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
    font-weight: 500;
}

.info-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.info-icon {
    margin-right: 0.75rem;
    font-size: 1.2rem;
}

.weather-widget {
    display: flex;
    align-items: center;
    color: #ffd89b;
    font-weight: 600;
}

/* Modern Statistics Cards */
.modern-stats-card {
    background: white;
    border-radius: 24px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    cursor: pointer;
}

.modern-stats-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.gradient-green {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.gradient-purple {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.gradient-yellow {
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
    color: white;
}

.stats-icon {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    font-size: 2.5rem;
    opacity: 0.3;
}

.stats-content {
    position: relative;
    z-index: 2;
}

.stats-number {
    font-size: 2.8rem;
    font-weight: 800;
    line-height: 1;
    display: block;
    margin-bottom: 0.5rem;
}

.stats-label {
    font-size: 1rem;
    font-weight: 600;
    opacity: 0.9;
    display: block;
    margin-bottom: 1rem;
}

.stats-trend {
    display: flex;
    align-items: center;
    font-size: 0.875rem;
    opacity: 0.8;
}

.stats-trend i {
    margin-right: 0.5rem;
}

.stats-decoration {
    position: absolute;
    top: -50px;
    right: -50px;
    width: 150px;
    height: 150px;
}

.decoration-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
}

.decoration-circle:first-child {
    width: 80px;
    height: 80px;
    top: 20px;
    right: 20px;
}

.decoration-circle:last-child {
    width: 120px;
    height: 120px;
    top: 0;
    right: 0;
}

/* Modern Card Styles */
.modern-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    transition: all 0.3s ease;
}

.modern-card:hover {
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.card-header-modern {
    padding: 2rem 2rem 1rem 2rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.card-title-modern {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.card-title-modern i {
    margin-right: 0.75rem;
    color: #667eea;
}

.card-subtitle-modern {
    color: #718096;
    font-size: 0.95rem;
    margin: 0;
}

.card-body-modern {
    padding: 1rem 2rem 2rem 2rem;
}

/* Modern Table Styles */
.modern-table {
    border: none;
    border-collapse: separate;
    border-spacing: 0;
}

.modern-table-header {
    background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
    border-bottom: 2px solid #e2e8f0;
}

.modern-table-header th {
    padding: 1.5rem 1rem;
    font-weight: 600;
    color: #2d3748;
    border: none;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-table-header th i {
    color: #667eea;
}

.modern-table-row {
    transition: all 0.3s ease;
    border-bottom: 1px solid #e2e8f0;
}

.modern-table-row:hover {
    background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.modern-table-cell {
    padding: 1.5rem 1rem;
    border: none;
    vertical-align: middle;
}

/* Region Info Styles */
.region-info {
    display: flex;
    align-items: center;
}

.region-avatar {
    margin-right: 1rem;
}

.avatar-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
    font-size: 1.1rem;
}

.gradient-avatar-1 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.gradient-avatar-2 {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.gradient-avatar-3 {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.gradient-avatar-4 {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.region-details {
    display: flex;
    flex-direction: column;
}

.region-name-link {
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}

.region-name-link:hover {
    color: #667eea;
    text-decoration: none;
}

.region-name-link:hover .region-name {
    color: #667eea;
    font-weight: 700;
}

.region-name {
    font-weight: 600;
    color: #2d3748;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.region-meta {
    color: #718096;
    font-size: 0.8rem;
}

.region-number {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

/* Count Badges */
.count-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.count-badge.desa {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.count-badge.relawan {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.count-badge.penduduk {
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1.5rem;
}

.empty-state h6 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #718096;
    font-size: 1rem;
    margin-bottom: 2rem;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.animate-fade-in-right {
    animation: fadeInRight 0.6s ease-out;
}

.animate-scale-in {
    animation: scaleIn 0.6s ease-out;
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out;
}

.bounce-animation {
    animation: bounce 2s infinite;
}

.pulse-animation {
    animation: pulse 2s infinite;
}
</style>
@endsection