@extends('layout.app')

@section('title', 'Daftar Relawan')

@section('content')
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
                                <i class="fas fa-users hero-icon bounce-animation"></i>
                                Manajemen <span class="text-gradient">Relawan</span>
                            </h1>
                            <p class="hero-subtitle">Kelola Data Relawan RelawanCare</p>
                            <p class="hero-description">Pantau dan kelola informasi lengkap relawan yang terlibat dalam distribusi bantuan kepada masyarakat</p>
                            <div class="hero-badges">
                                <span class="badge badge-modern">👥 {{ $volunteers->total() }} Relawan</span>
                                <span class="badge badge-modern">📱 Mobile Ready</span>
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
                                    <i class="fas fa-user-check"></i>
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
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card gradient-blue animate-scale-in" style="animation-delay: 0.1s;">
            <div class="stats-icon">
                <i class="fas fa-users pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $volunteers->total() }}">{{ $volunteers->total() }}</div>
                <div class="stats-label">Total Relawan</div>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>Terdaftar dalam sistem</span>
                </div>
            </div>
            <div class="stats-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card gradient-green animate-scale-in" style="animation-delay: 0.2s;">
            <div class="stats-icon">
                <i class="fas fa-user-check pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $volunteers->where('is_active', true)->count() }}">{{ $volunteers->where('is_active', true)->count() }}</div>
                <div class="stats-label">Relawan Aktif</div>
                <div class="stats-trend">
                    <i class="fas fa-check-circle"></i>
                    <span>Siap bertugas</span>
                </div>
            </div>
            <div class="stats-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card gradient-purple animate-scale-in" style="animation-delay: 0.3s;">
            <div class="stats-icon">
                <i class="fas fa-user-times pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $volunteers->where('is_active', false)->count() }}">{{ $volunteers->where('is_active', false)->count() }}</div>
                <div class="stats-label">Tidak Aktif</div>
                <div class="stats-trend">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Perlu aktivasi</span>
                </div>
            </div>
            <div class="stats-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card gradient-orange animate-scale-in" style="animation-delay: 0.4s;">
            <div class="stats-icon">
                <i class="fas fa-plus pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="1">1</div>
                <div class="stats-label">Aksi Cepat</div>
                <div class="stats-trend">
                    <i class="fas fa-bolt"></i>
                    <span>Tambah relawan baru</span>
                </div>
            </div>
            <div class="stats-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
            <a href="{{ route('volunteers.create') }}" class="stretched-link"></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-users"></i>
                    Daftar Relawan
                </h5>
                <p class="card-subtitle-modern">Kelola dan pantau data relawan yang terdaftar dalam sistem</p>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('volunteers.create') }}" class="action-button">
                        <span><i class="fas fa-plus me-1"></i>Tambah Relawan</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="card-body-modern">
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead class="modern-table-header">
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>Kode</th>
                                <th><i class="fas fa-user me-2"></i>Nama</th>
                                <th><i class="fas fa-phone me-2"></i>Telepon</th>
                                <th><i class="fas fa-map-marker-alt me-2"></i>Kabupaten</th>
                                <th><i class="fas fa-map me-2"></i>Kecamatan</th>
                                <th><i class="fas fa-home me-2"></i>Desa</th>
                                <th><i class="fas fa-toggle-on me-2"></i>Status</th>
                                <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="modern-table-body">
                            @forelse($volunteers as $volunteer)
                                <tr class="modern-table-row animate-fade-in" style="animation-delay: {{ 0.1 * $loop->index }}s;">
                                    <td class="modern-table-cell">
                                        <span class="volunteer-code">{{ $volunteer->volunteer_code ?? 'V' . str_pad($volunteer->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="volunteer-info">
                                            <div class="volunteer-avatar">
                                                <div class="avatar-circle gradient-avatar-{{ ($loop->index % 4) + 1 }}">
                                                    {{ substr($volunteer->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="volunteer-details">
                                                <span class="volunteer-name">{{ $volunteer->name }}</span>
                                                <small class="volunteer-meta">ID: {{ $volunteer->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="phone-number">
                                            <i class="fas fa-phone-alt me-1"></i>
                                            {{ $volunteer->phone }}
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="location-badge kabupaten">
                                            {{ $volunteer->kabupaten->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="location-badge kecamatan">
                                            {{ $volunteer->kecamatan->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <span class="location-badge desa">
                                            {{ $volunteer->desa->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="modern-table-cell">
                                        @if($volunteer->is_active)
                                            <span class="status-badge success">
                                                <i class="fas fa-check-circle"></i>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="status-badge danger">
                                                <i class="fas fa-times-circle"></i>
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="action-buttons">
                                            <a href="{{ route('volunteers.show', $volunteer->id) }}" class="action-btn view" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('volunteers.edit', $volunteer->id) }}" class="action-btn edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('volunteers.destroy', $volunteer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus relawan ini?')">
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
                                    <td colspan="8" class="modern-table-cell">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <h6>Belum Ada Data Relawan</h6>
                                            <p>Mulai dengan menambahkan relawan pertama ke dalam sistem</p>
                                            <a href="{{ route('volunteers.create') }}" class="action-button mt-3">
                                                <span><i class="fas fa-plus me-1"></i>Tambah Relawan Pertama</span>
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
                @if($volunteers->hasPages())
                    <div class="modern-pagination">
                        {{ $volunteers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Hero Section Styles */
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

.gradient-blue {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.gradient-green {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.gradient-purple {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.gradient-orange {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
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

/* Action Button */
.action-button {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    border: none;
}

.action-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    color: white;
    text-decoration: none;
}

.action-button i {
    margin-left: 0.5rem;
    transition: transform 0.3s ease;
}

.action-button:hover i {
    transform: translateX(3px);
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

/* Volunteer Info Styles */
.volunteer-info {
    display: flex;
    align-items: center;
}

.volunteer-avatar {
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

.volunteer-details {
    display: flex;
    flex-direction: column;
}

.volunteer-name {
    font-weight: 600;
    color: #2d3748;
    font-size: 1rem;
}

.volunteer-meta {
    color: #718096;
    font-size: 0.8rem;
}

.volunteer-code {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.phone-number {
    color: #4a5568;
    font-weight: 500;
}

.phone-number i {
    color: #667eea;
}

/* Location Badges */
.location-badge {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    border: 1px solid rgba(102, 126, 234, 0.2);
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-badge.success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.status-badge.danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
    color: white;
}

.status-badge i {
    margin-right: 0.5rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}

.action-btn.view {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.action-btn.edit {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
    color: white;
}

.action-btn.delete {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
    color: white;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    color: white;
    text-decoration: none;
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

/* Modern Pagination */
.modern-pagination {
    padding: 2rem;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
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

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
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

.animate-fade-in-left {
    animation: fadeInLeft 0.6s ease-out;
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

.stretched-link::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    content: "";
}
</style>
@endsection