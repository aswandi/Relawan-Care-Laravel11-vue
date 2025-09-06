@extends('layout.app')

@section('title', 'Detail Jenis Bantuan')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb modern-breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('aid-types.index') }}">
                <i class="fas fa-gift me-1"></i>Jenis Bantuan
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="fas fa-eye me-1"></i>Detail Jenis Bantuan
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
                                <i class="fas fa-gift hero-icon bounce-animation"></i>
                                Detail <span class="text-gradient">{{ $aidType->name }}</span>
                            </h1>
                            <p class="hero-subtitle">Informasi Lengkap Jenis Bantuan</p>
                            <p class="hero-description">Lihat detail lengkap dari jenis bantuan {{ $aidType->name }} dalam sistem RelawanCare</p>
                            <div class="hero-badges">
                                <span class="badge badge-modern">👁️ Mode Lihat</span>
                                <span class="badge badge-modern">📊 Detail Info</span>
                                @if($aidType->is_active)
                                    <span class="badge badge-success-modern">✅ Aktif</span>
                                @else
                                    <span class="badge badge-danger-modern">⏸️ Tidak Aktif</span>
                                @endif
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
                                    <i class="fas fa-eye"></i>
                                    <span>Mode Detail</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mb-4">
    <div class="col-12">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="card-body-modern text-center py-3">
                <div class="action-buttons">
                    <a href="{{ route('aid-types.edit', $aidType) }}" class="btn btn-gradient-warning btn-lg me-2">
                        <i class="fas fa-edit me-2"></i>Edit Jenis Bantuan
                    </a>
                    <a href="{{ route('aid-types.index') }}" class="btn btn-outline-secondary btn-lg me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                    <button class="btn btn-outline-danger btn-lg" onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Information -->
<div class="row">
    <!-- Main Information Card -->
    <div class="col-lg-8 mb-4">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.4s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-info-circle"></i>
                    Informasi Dasar
                </h5>
                <p class="card-subtitle-modern">Detail lengkap tentang jenis bantuan {{ $aidType->name }}</p>
            </div>
            <div class="card-body-modern">
                <div class="detail-group">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-gift detail-icon"></i>
                            Nama Jenis Bantuan
                        </div>
                        <div class="detail-value">
                            {{ $aidType->name }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-info-circle detail-icon"></i>
                            Deskripsi
                        </div>
                        <div class="detail-value">
                            {{ $aidType->description ?: 'Tidak ada deskripsi' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-ruler detail-icon"></i>
                            Satuan
                        </div>
                        <div class="detail-value">
                            {{ $aidType->unit ?: 'Tidak ada satuan' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-dollar-sign detail-icon"></i>
                            Memiliki Nilai Nominal
                        </div>
                        <div class="detail-value">
                            @if($aidType->has_nominal)
                                <span class="status-badge success">
                                    <i class="fas fa-check-circle me-1"></i>Ya
                                </span>
                            @else
                                <span class="status-badge secondary">
                                    <i class="fas fa-times-circle me-1"></i>Tidak
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-toggle-on detail-icon"></i>
                            Status
                        </div>
                        <div class="detail-value">
                            @if($aidType->is_active)
                                <span class="status-badge active">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="status-badge inactive">
                                    <i class="fas fa-pause-circle me-1"></i>Tidak Aktif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics and Meta Info -->
    <div class="col-lg-4">
        <!-- Meta Information -->
        <div class="modern-card animate-fade-in-up mb-4" style="animation-delay: 0.5s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-clock"></i>
                    Informasi Sistem
                </h5>
                <p class="card-subtitle-modern">Metadata jenis bantuan</p>
            </div>
            <div class="card-body-modern">
                <div class="meta-info">
                    <div class="meta-item">
                        <div class="meta-label">
                            <i class="fas fa-hashtag me-2"></i>ID
                        </div>
                        <div class="meta-value">{{ $aidType->id }}</div>
                    </div>

                    <div class="meta-item">
                        <div class="meta-label">
                            <i class="fas fa-calendar-plus me-2"></i>Dibuat
                        </div>
                        <div class="meta-value">
                            {{ $aidType->created_at->format('d F Y') }}
                            <small class="text-muted d-block">{{ $aidType->created_at->format('H:i') }} WIB</small>
                        </div>
                    </div>

                    <div class="meta-item">
                        <div class="meta-label">
                            <i class="fas fa-calendar-edit me-2"></i>Diperbarui
                        </div>
                        <div class="meta-value">
                            {{ $aidType->updated_at->format('d F Y') }}
                            <small class="text-muted d-block">{{ $aidType->updated_at->format('H:i') }} WIB</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usage Statistics -->
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.6s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-chart-bar"></i>
                    Statistik Penggunaan
                </h5>
                <p class="card-subtitle-modern">Data penggunaan jenis bantuan ini</p>
            </div>
            <div class="card-body-modern">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $aidType->sessionItems()->count() }}</div>
                        <div class="stat-label">Total Item Sesi</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $aidType->sessionItems()->distinct('aid_session_id')->count() }}</div>
                        <div class="stat-label">Sesi Bantuan</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">
                            {{ $aidType->sessionItems()->join('aid_sessions', 'aid_session_items.aid_session_id', '=', 'aid_sessions.id')->distinct('aid_sessions.id')->count() }}
                        </div>
                        <div class="stat-label">Penerima Bantuan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden delete form -->
<form id="delete-form" action="{{ route('aid-types.destroy', $aidType) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
/* Modern Breadcrumb */
.modern-breadcrumb {
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
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

/* Modern Hero Section */
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
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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

.badge-success-modern {
    background: rgba(67, 233, 123, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    border: 1px solid rgba(67, 233, 123, 0.5);
    backdrop-filter: blur(10px);
    font-weight: 500;
}

.badge-danger-modern {
    background: rgba(245, 87, 108, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    border: 1px solid rgba(245, 87, 108, 0.5);
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

/* Modern Card */
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
    color: #4facfe;
}

.card-subtitle-modern {
    color: #718096;
    font-size: 0.95rem;
    margin: 0;
}

.card-body-modern {
    padding: 1rem 2rem 2rem 2rem;
}

/* Detail Information Styles */
.detail-group {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    background: #f8faff;
    border-radius: 16px;
    border-left: 4px solid #4facfe;
    transition: all 0.3s ease;
}

.detail-item:hover {
    background: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.detail-label {
    display: flex;
    align-items: center;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-icon {
    margin-right: 0.75rem;
    color: #4facfe;
    font-size: 1.1rem;
}

.detail-value {
    color: #4a5568;
    font-size: 1.1rem;
    font-weight: 500;
    line-height: 1.6;
}

/* Meta Information */
.meta-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.meta-item {
    display: flex;
    justify-content: space-between;
    align-items: start;
    padding: 1rem;
    background: #f8faff;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.meta-item:hover {
    background: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.meta-label {
    font-weight: 600;
    color: #2d3748;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
}

.meta-value {
    color: #4a5568;
    font-weight: 500;
    text-align: right;
    font-size: 0.95rem;
}

/* Statistics */
.stat-item {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
    border-radius: 16px;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stat-item:last-child {
    margin-bottom: 0;
}

.stat-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    border-radius: 50%;
    color: white;
    font-size: 1.5rem;
    margin-right: 1.5rem;
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: #2d3748;
    line-height: 1;
}

.stat-label {
    color: #718096;
    font-size: 0.9rem;
    font-weight: 500;
    margin-top: 0.25rem;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-badge.active {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.status-badge.inactive {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.status-badge.success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.status-badge.secondary {
    background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
    color: white;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}

.btn-gradient-warning {
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 216, 155, 0.4);
}

.btn-gradient-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 216, 155, 0.6);
    color: white;
}

.btn-outline-secondary, .btn-outline-danger {
    border: 2px solid #e2e8f0;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-danger {
    border-color: #e53e3e;
    color: #e53e3e;
}

.btn-outline-secondary:hover {
    background: #f8faff;
    border-color: #cbd5e0;
    color: #2d3748;
}

.btn-outline-danger:hover {
    background: #e53e3e;
    border-color: #e53e3e;
    color: white;
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

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.animate-fade-in-right {
    animation: fadeInRight 0.6s ease-out;
}

.bounce-animation {
    animation: bounce 2s infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        width: 100%;
    }
}
</style>

<script>
// Auto-update time
setInterval(function() {
    document.getElementById('current-time').textContent = new Date().toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit',
        timeZone: 'Asia/Jakarta'
    }) + ' WIB';
}, 1000);

// Confirm delete
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus jenis bantuan "{{ $aidType->name }}"?\n\nTindakan ini tidak dapat dibatalkan!')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection