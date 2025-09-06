@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<!-- Modern Dashboard Header with Animation -->
<div class="row mb-5">
    <div class="col-12">
        <div class="hero-section">
            <div class="hero-background"></div>
            <div class="hero-content">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="hero-text animate-fade-in-up">
                            <h1 class="hero-title">
                                <i class="fas fa-hands-helping hero-icon bounce-animation"></i>
                                Selamat Datang di <span class="text-gradient">RelawanCare</span>
                            </h1>
                            <p class="hero-subtitle">Sistem Monitoring Relawan untuk Distribusi Bantuan</p>
                            <p class="hero-description">Kelola dan pantau aktivitas relawan dalam penyaluran bantuan kepada masyarakat dengan teknologi modern</p>
                            <div class="hero-badges">
                                <span class="badge badge-modern">🚀 Modern</span>
                                <span class="badge badge-modern">📱 Mobile Ready</span>
                                <span class="badge badge-modern">⚡ Fast</span>
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
                                    <i class="fas fa-sun"></i>
                                    <span>Cerah</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Statistics Cards with Animations -->
<div class="row mb-5">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card gradient-blue animate-scale-in" style="animation-delay: 0.1s;">
            <div class="stats-icon">
                <i class="fas fa-users pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $stats['total_volunteers'] ?? 0 }}">0</div>
                <div class="stats-label">Total Relawan</div>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12% dari bulan lalu</span>
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
                <i class="fas fa-user-friends pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $stats['total_beneficiaries'] ?? 0 }}">0</div>
                <div class="stats-label">Penerima Bantuan</div>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8% dari bulan lalu</span>
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
                <i class="fas fa-tasks pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $stats['today_activities'] ?? 0 }}">0</div>
                <div class="stats-label">Aktivitas Hari Ini</div>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15% dari kemarin</span>
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
                <i class="fas fa-calendar-alt pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $stats['active_sessions'] ?? 0 }}">0</div>
                <div class="stats-label">Sesi Aktif</div>
                <div class="stats-trend">
                    <i class="fas fa-check-circle"></i>
                    <span>Semua berjalan lancar</span>
                </div>
            </div>
            <div class="stats-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Quick Actions -->
<div class="row mb-5">
    <div class="col-12">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-bolt flash-animation"></i>
                    Aksi Cepat
                </h5>
                <p class="card-subtitle-modern">Akses cepat ke fungsi utama sistem</p>
            </div>
            <div class="card-body-modern">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="quick-action-card gradient-action-blue animate-hover-lift">
                            <div class="action-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="action-content">
                                <h6>Tambah Relawan</h6>
                                <p>Daftarkan relawan baru</p>
                                <a href="{{ route('volunteers.create') }}" class="action-button">
                                    <span>Mulai</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="quick-action-card gradient-action-green animate-hover-lift">
                            <div class="action-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="action-content">
                                <h6>Tambah Penerima</h6>
                                <p>Daftarkan penerima bantuan</p>
                                <a href="{{ route('beneficiaries.create') }}" class="action-button">
                                    <span>Mulai</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="quick-action-card gradient-action-purple animate-hover-lift">
                            <div class="action-icon">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="action-content">
                                <h6>Buat Sesi Bantuan</h6>
                                <p>Atur distribusi bantuan</p>
                                <a href="{{ route('aid-sessions.create') }}" class="action-button">
                                    <span>Mulai</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="quick-action-card gradient-action-orange animate-hover-lift">
                            <div class="action-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="action-content">
                                <h6>Lihat Aktivitas</h6>
                                <p>Monitor progress relawan</p>
                                <a href="{{ route('activities.index') }}" class="action-button">
                                    <span>Mulai</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Activity Dashboard -->
<div class="row">
    <div class="col-xl-8 mb-4">
        <div class="modern-card animate-fade-in-left" style="animation-delay: 0.6s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-clock rotate-animation"></i>
                    Aktivitas Terbaru
                </h5>
                <p class="card-subtitle-modern">10 aktivitas terbaru dari relawan</p>
            </div>
            <div class="card-body-modern">
                @if(isset($recent_activities) && $recent_activities->count() > 0)
                    <div class="activity-timeline">
                        @foreach($recent_activities as $index => $activity)
                            <div class="activity-item animate-slide-in-right" style="animation-delay: {{ 0.7 + ($index * 0.1) }}s;">
                                <div class="activity-avatar">
                                    <div class="avatar-circle gradient-avatar-{{ $index % 4 + 1 }}">
                                        {{ substr($activity->volunteer->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-header">
                                        <span class="activity-name">{{ $activity->volunteer->name }}</span>
                                        <span class="activity-time">{{ $activity->created_at->format('d/m H:i') }}</span>
                                    </div>
                                    <div class="activity-description">
                                        Melakukan kunjungan ke <strong>{{ $activity->beneficiary->name }}</strong> 
                                        di {{ $activity->beneficiary->desa->name }}
                                    </div>
                                    <div class="activity-status">
                                        <span class="status-badge success">
                                            <i class="fas fa-check"></i>
                                            Selesai
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h6>Belum Ada Aktivitas</h6>
                        <p>Aktivitas terbaru akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-4 mb-4">
        <div class="modern-card animate-fade-in-right" style="animation-delay: 0.6s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-bell shake-animation"></i>
                    Pemberitahuan
                </h5>
                <p class="card-subtitle-modern">Status sistem dan update</p>
            </div>
            <div class="card-body-modern">
                <div class="notification-list">
                    <div class="notification-item success animate-bounce-in" style="animation-delay: 0.7s;">
                        <div class="notification-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="notification-content">
                            <h6>Sistem Aktif</h6>
                            <p>RelawanCare berjalan dengan lancar</p>
                        </div>
                    </div>
                    
                    @if(isset($stats['inactive_volunteers']) && $stats['inactive_volunteers'] > 0)
                    <div class="notification-item warning animate-bounce-in" style="animation-delay: 0.8s;">
                        <div class="notification-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="notification-content">
                            <h6>{{ $stats['inactive_volunteers'] }} Relawan Tidak Aktif</h6>
                            <p>Perlu aktivasi ulang</p>
                        </div>
                    </div>
                    @endif

                    <div class="notification-item info animate-bounce-in" style="animation-delay: 0.9s;">
                        <div class="notification-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="notification-content">
                            <h6>API Mobile Ready</h6>
                            <p>Aplikasi mobile tersedia untuk relawan</p>
                        </div>
                    </div>

                    <div class="notification-item primary animate-bounce-in" style="animation-delay: 1.0s;">
                        <div class="notification-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="notification-content">
                            <h6>Statistik Update</h6>
                            <p>Data terbaru telah disinkronisasi</p>
                        </div>
                    </div>
                </div>

                <div class="quick-stats">
                    <div class="quick-stat-item">
                        <span class="stat-number">98%</span>
                        <span class="stat-label">Uptime</span>
                    </div>
                    <div class="quick-stat-item">
                        <span class="stat-number">{{ $stats['total_volunteers'] ?? 0 }}</span>
                        <span class="stat-label">Relawan</span>
                    </div>
                    <div class="quick-stat-item">
                        <span class="stat-number">{{ $stats['total_beneficiaries'] ?? 0 }}</span>
                        <span class="stat-label">Penerima</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Modern Dashboard Styles */
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Hero Section */
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

/* Quick Action Cards */
.quick-action-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.quick-action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.gradient-action-blue::before {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.gradient-action-green::before {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.gradient-action-purple::before {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.gradient-action-orange::before {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.action-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.gradient-action-green .action-icon {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.gradient-action-purple .action-icon {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.gradient-action-orange .action-icon {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.action-content h6 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.action-content p {
    color: #718096;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

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

/* Activity Timeline */
.activity-timeline {
    position: relative;
}

.activity-item {
    display: flex;
    margin-bottom: 2rem;
    position: relative;
}

.activity-avatar {
    margin-right: 1rem;
}

.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
    font-size: 1.2rem;
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

.activity-content {
    flex: 1;
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.activity-name {
    font-weight: 600;
    color: #2d3748;
}

.activity-time {
    font-size: 0.875rem;
    color: #718096;
}

.activity-description {
    color: #4a5568;
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-badge.success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.status-badge i {
    margin-right: 0.5rem;
}

/* Notification List */
.notification-list {
    margin-bottom: 2rem;
}

.notification-item {
    display: flex;
    align-items: flex-start;
    padding: 1rem;
    border-radius: 16px;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.notification-item:hover {
    transform: translateX(4px);
}

.notification-item.success {
    background: rgba(67, 233, 123, 0.1);
    border-color: rgba(67, 233, 123, 0.2);
}

.notification-item.warning {
    background: rgba(255, 193, 7, 0.1);
    border-color: rgba(255, 193, 7, 0.2);
}

.notification-item.info {
    background: rgba(79, 172, 254, 0.1);
    border-color: rgba(79, 172, 254, 0.2);
}

.notification-item.primary {
    background: rgba(102, 126, 234, 0.1);
    border-color: rgba(102, 126, 234, 0.2);
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.2rem;
}

.notification-item.success .notification-icon {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.notification-item.warning .notification-icon {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
    color: white;
}

.notification-item.info .notification-icon {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.notification-item.primary .notification-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.notification-content h6 {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
    font-size: 0.95rem;
}

.notification-content p {
    color: #718096;
    font-size: 0.875rem;
    margin: 0;
}

/* Quick Stats */
.quick-stats {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
    border-radius: 16px;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.quick-stat-item {
    text-align: center;
    flex: 1;
}

.stat-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 800;
    color: #667eea;
    line-height: 1;
}

.stat-label {
    display: block;
    font-size: 0.75rem;
    color: #718096;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.25rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.empty-state h6 {
    color: #4a5568;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #718096;
    margin: 0;
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

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes bounceIn {
    0% {
        opacity: 0;
        transform: scale(0.3) translateY(-20px);
    }
    50% {
        opacity: 0.7;
        transform: scale(1.05) translateY(0);
    }
    100% {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translateY(0);
    }
    40%, 43% {
        transform: translateY(-10px);
    }
    70% {
        transform: translateY(-5px);
    }
    90% {
        transform: translateY(-2px);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-2px); }
    75% { transform: translateX(2px); }
}

@keyframes flash {
    0%, 50%, 100% { opacity: 1; }
    25%, 75% { opacity: 0.5; }
}

/* Animation Classes */
.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
    opacity: 0;
}

.animate-fade-in-left {
    animation: fadeInLeft 0.8s ease-out forwards;
    opacity: 0;
}

.animate-fade-in-right {
    animation: fadeInRight 0.8s ease-out forwards;
    opacity: 0;
}

.animate-scale-in {
    animation: scaleIn 0.6s ease-out forwards;
    opacity: 0;
}

.animate-slide-in-right {
    animation: slideInRight 0.6s ease-out forwards;
    opacity: 0;
}

.animate-bounce-in {
    animation: bounceIn 0.8s ease-out forwards;
    opacity: 0;
}

.animate-hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.bounce-animation {
    animation: bounce 2s infinite;
}

.pulse-animation {
    animation: pulse 2s infinite;
}

.rotate-animation {
    animation: rotate 8s linear infinite;
}

.shake-animation {
    animation: shake 3s ease-in-out infinite;
}

.flash-animation {
    animation: flash 2s ease-in-out infinite;
}

.counter-animation {
    transition: all 0.3s ease;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-icon {
        font-size: 2rem;
        margin-right: 0.5rem;
    }
    
    .modern-stats-card {
        margin-bottom: 1.5rem;
    }
    
    .quick-stats {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .quick-action-card {
        margin-bottom: 1rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .modern-card {
        background: rgba(26, 32, 44, 0.95);
        border-color: rgba(255, 255, 255, 0.1);
    }
    
    .card-title-modern {
        color: #e2e8f0;
    }
    
    .card-subtitle-modern {
        color: #a0aec0;
    }
    
    .activity-name {
        color: #e2e8f0;
    }
    
    .activity-description {
        color: #cbd5e0;
    }
}
</style>
@endpush
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter Animation
    const counters = document.querySelectorAll('.counter-animation');
    
    const animateCounters = () => {
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const current = parseInt(counter.innerText);
            const increment = target / 100; // Adjust speed here
            
            if (current < target) {
                counter.innerText = Math.ceil(current + increment);
                setTimeout(animateCounters, 30);
            } else {
                counter.innerText = target;
            }
        });
    };
    
    // Start counter animation after page load
    setTimeout(animateCounters, 500);
    
    // Real-time clock update
    const updateClock = () => {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }) + ' WIB';
        
        const clockElement = document.getElementById('current-time');
        if (clockElement) {
            clockElement.textContent = timeString;
        }
    };
    
    // Update clock immediately and then every minute
    updateClock();
    setInterval(updateClock, 60000);
    
    // Add smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add hover effects for cards
    const cards = document.querySelectorAll('.modern-stats-card, .quick-action-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Intersection Observer for animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, {
        threshold: 0.1
    });
    
    // Observe all animated elements
    document.querySelectorAll('[class*="animate-"]').forEach(el => {
        observer.observe(el);
    });
    
    // Add particle effect on hero section
    const hero = document.querySelector('.hero-background');
    if (hero) {
        const particles = 30;
        
        for (let i = 0; i < particles; i++) {
            const particle = document.createElement('div');
            particle.style.cssText = `
                position: absolute;
                width: 4px;
                height: 4px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                animation: float ${3 + Math.random() * 4}s ease-in-out infinite;
                animation-delay: ${Math.random() * 5}s;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
            `;
            hero.appendChild(particle);
        }
    }
    
    // Add CSS for floating particles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }
            10%, 90% {
                opacity: 1;
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
                opacity: 0.7;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Add loading skeleton effect
    const addSkeletonEffect = () => {
        const skeletonStyle = document.createElement('style');
        skeletonStyle.textContent = `
            .skeleton {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: loading 1.5s infinite;
            }
            
            @keyframes loading {
                0% {
                    background-position: 200% 0;
                }
                100% {
                    background-position: -200% 0;
                }
            }
        `;
        document.head.appendChild(skeletonStyle);
    };
    
    addSkeletonEffect();
});

// Add dynamic background gradient change
let gradientAngle = 135;
setInterval(() => {
    gradientAngle += 1;
    if (gradientAngle > 360) gradientAngle = 0;
    
    document.body.style.background = `linear-gradient(${gradientAngle}deg, #667eea 0%, #764ba2 100%)`;
}, 100);

// Add cursor trail effect
document.addEventListener('mousemove', (e) => {
    const trail = document.createElement('div');
    trail.style.cssText = `
        position: fixed;
        left: ${e.clientX - 2}px;
        top: ${e.clientY - 2}px;
        width: 4px;
        height: 4px;
        background: rgba(102, 126, 234, 0.6);
        border-radius: 50%;
        pointer-events: none;
        animation: trailFade 0.8s ease-out forwards;
        z-index: 9999;
    `;
    
    document.body.appendChild(trail);
    
    setTimeout(() => {
        trail.remove();
    }, 800);
});

// Add trail fade animation
const trailStyle = document.createElement('style');
trailStyle.textContent = `
    @keyframes trailFade {
        0% {
            opacity: 1;
            transform: scale(1);
        }
        100% {
            opacity: 0;
            transform: scale(0);
        }
    }
`;
document.head.appendChild(trailStyle);

// Performance optimization: Throttle scroll events
let ticking = false;

function updateAnimations() {
    // Update any scroll-based animations here
    ticking = false;
}

document.addEventListener('scroll', () => {
    if (!ticking) {
        requestAnimationFrame(updateAnimations);
        ticking = true;
    }
});

// Add click ripple effect
document.addEventListener('click', (e) => {
    if (e.target.closest('.action-button, .modern-stats-card')) {
        const ripple = document.createElement('div');
        const rect = e.target.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: ripple 0.6s ease-out;
            pointer-events: none;
            z-index: 1000;
        `;
        
        e.target.style.position = 'relative';
        e.target.style.overflow = 'hidden';
        e.target.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
});

// Add ripple animation
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
    @keyframes ripple {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(2);
            opacity: 0;
        }
    }
`;
document.head.appendChild(rippleStyle);
</script>
@endpush