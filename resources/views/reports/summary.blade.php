@extends('layout.app')

@section('title', 'Laporan Ringkasan')

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
                                <i class="fas fa-chart-pie hero-icon bounce-animation"></i>
                                Laporan <span class="text-gradient">Ringkasan</span>
                            </h1>
                            <p class="hero-subtitle">Dashboard Analitik RelawanCare</p>
                            <p class="hero-description">Ringkasan komprehensif kinerja program distribusi bantuan dan aktivitas relawan</p>
                            <div class="hero-badges">
                                <span class="badge badge-modern">📊 Data Real-time</span>
                                <span class="badge badge-modern">📈 Analisis Tren</span>
                                <span class="badge badge-modern">🎯 KPI Tracking</span>
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
                                    <i class="fas fa-chart-line"></i>
                                    <span>Analytics Dashboard</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Date Range Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="card-body-modern">
                <form method="GET" action="{{ route('reports.summary') }}" class="date-filter-form">
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label for="start_date" class="modern-label">
                                <i class="fas fa-calendar-plus me-2"></i>Dari Tanggal
                            </label>
                            <input type="date" class="form-control modern-input" id="start_date" name="start_date" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="end_date" class="modern-label">
                                <i class="fas fa-calendar-minus me-2"></i>Sampai Tanggal
                            </label>
                            <input type="date" class="form-control modern-input" id="end_date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="submit" class="btn btn-gradient-primary btn-lg w-100">
                                <i class="fas fa-search me-2"></i>Generate Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Key Metrics -->
<div class="row mb-5">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card gradient-blue animate-scale-in" style="animation-delay: 0.1s;">
            <div class="stats-icon">
                <i class="fas fa-users pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $summary['total_volunteers'] }}">{{ $summary['total_volunteers'] }}</div>
                <div class="stats-label">Total Relawan</div>
                <div class="stats-trend">
                    <i class="fas fa-user-check"></i>
                    <span>{{ $summary['active_volunteers'] }} aktif</span>
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
                <div class="stats-number counter-animation" data-target="{{ $summary['total_beneficiaries'] }}">{{ $summary['total_beneficiaries'] }}</div>
                <div class="stats-label">Penerima Bantuan</div>
                <div class="stats-trend">
                    <i class="fas fa-heart"></i>
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
        <div class="modern-stats-card gradient-orange animate-scale-in" style="animation-delay: 0.3s;">
            <div class="stats-icon">
                <i class="fas fa-tasks pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $summary['total_activities'] }}">{{ $summary['total_activities'] }}</div>
                <div class="stats-label">Total Aktivitas</div>
                <div class="stats-trend">
                    <i class="fas fa-chart-line"></i>
                    <span>Periode dipilih</span>
                </div>
            </div>
            <div class="stats-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="modern-stats-card gradient-purple animate-scale-in" style="animation-delay: 0.4s;">
            <div class="stats-icon">
                <i class="fas fa-box-open pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $summary['total_aid_distributed'] }}">{{ $summary['total_aid_distributed'] }}</div>
                <div class="stats-label">Bantuan Disalurkan</div>
                <div class="stats-trend">
                    <i class="fas fa-gift"></i>
                    <span>Total unit</span>
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
    <!-- Monthly Activity Chart -->
    <div class="col-lg-8 mb-4">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-chart-line"></i>
                    Tren Aktivitas Bulanan
                </h5>
                <p class="card-subtitle-modern">Grafik perkembangan aktivitas relawan per bulan</p>
            </div>
            <div class="card-body-modern">
                @if($monthlyActivities->count() > 0)
                    <div class="chart-container">
                        <canvas id="monthlyChart" height="100"></canvas>
                    </div>
                @else
                    <div class="empty-state-chart">
                        <div class="empty-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h6>Belum Ada Data</h6>
                        <p>Belum ada aktivitas pada periode yang dipilih untuk ditampilkan dalam grafik</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Volunteers -->
    <div class="col-lg-4 mb-4">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.6s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-trophy"></i>
                    Relawan Terbaik
                </h5>
                <p class="card-subtitle-modern">10 relawan dengan aktivitas terbanyak</p>
            </div>
            <div class="card-body-modern">
                @if($topVolunteers->count() > 0)
                    <div class="top-volunteers-list">
                        @foreach($topVolunteers->take(10) as $volunteer)
                            <div class="volunteer-item {{ $loop->first ? 'top-performer' : '' }}">
                                <div class="rank-badge rank-{{ min($loop->iteration, 3) }}">
                                    @if($loop->iteration <= 3)
                                        <i class="fas fa-medal"></i>
                                    @endif
                                    #{{ $loop->iteration }}
                                </div>
                                <div class="volunteer-info">
                                    <div class="volunteer-name">{{ $volunteer->name }}</div>
                                    <div class="volunteer-stats">
                                        <span class="activity-count">{{ $volunteer->activities_count }} aktivitas</span>
                                    </div>
                                </div>
                                <div class="activity-score">
                                    {{ $volunteer->activities_count }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-small">
                        <div class="empty-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h6>Belum Ada Data</h6>
                        <p>Belum ada aktivitas relawan pada periode yang dipilih</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="row">
    <div class="col-12">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.7s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-info-circle"></i>
                    Informasi Periode Laporan
                </h5>
                <p class="card-subtitle-modern">Detail periode yang sedang ditampilkan</p>
            </div>
            <div class="card-body-modern">
                <div class="period-info-grid">
                    <div class="period-item">
                        <div class="period-label">
                            <i class="fas fa-calendar-plus me-2"></i>Tanggal Mulai
                        </div>
                        <div class="period-value">{{ \Carbon\Carbon::parse(request('start_date', now()->startOfMonth()))->format('d F Y') }}</div>
                    </div>
                    <div class="period-item">
                        <div class="period-label">
                            <i class="fas fa-calendar-minus me-2"></i>Tanggal Akhir
                        </div>
                        <div class="period-value">{{ \Carbon\Carbon::parse(request('end_date', now()))->format('d F Y') }}</div>
                    </div>
                    <div class="period-item">
                        <div class="period-label">
                            <i class="fas fa-clock me-2"></i>Durasi Periode
                        </div>
                        <div class="period-value">
                            {{ \Carbon\Carbon::parse(request('start_date', now()->startOfMonth()))->diffInDays(\Carbon\Carbon::parse(request('end_date', now()))) + 1 }} hari
                        </div>
                    </div>
                    <div class="period-item">
                        <div class="period-label">
                            <i class="fas fa-map-marked-alt me-2"></i>Wilayah Terjangkau
                        </div>
                        <div class="period-value">{{ $summary['regions_covered'] }} lokasi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.gradient-orange {
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
    color: white;
}

.gradient-purple {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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

/* Form Styles */
.date-filter-form {
    background: #f8faff;
    padding: 1.5rem;
    border-radius: 16px;
    border: 2px solid #e2e8f0;
}

.modern-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    font-size: 1rem;
}

.modern-label i {
    color: #667eea;
}

.modern-input {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.modern-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: white;
    outline: none;
}

.btn-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-gradient-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    color: white;
}

/* Chart Container */
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
}

.empty-state-chart {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-chart .empty-icon {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1.5rem;
}

.empty-state-chart h6 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1rem;
}

.empty-state-chart p {
    color: #718096;
    font-size: 1rem;
}

/* Top Volunteers */
.top-volunteers-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.volunteer-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f8faff;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.volunteer-item:hover {
    border-color: #667eea;
    background: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.volunteer-item.top-performer {
    border-color: #ffd700;
    background: linear-gradient(135deg, #fff9e6 0%, #fff3d9 100%);
}

.rank-badge {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    margin-right: 1rem;
    color: white;
}

.rank-1 {
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
}

.rank-2 {
    background: linear-gradient(135deg, #c0c0c0 0%, #e5e5e5 100%);
}

.rank-3 {
    background: linear-gradient(135deg, #cd7f32 0%, #d4af7a 100%);
}

.rank-badge:not(.rank-1):not(.rank-2):not(.rank-3) {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.volunteer-info {
    flex: 1;
}

.volunteer-name {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.volunteer-stats {
    color: #718096;
    font-size: 0.85rem;
}

.activity-score {
    font-size: 1.5rem;
    font-weight: 800;
    color: #667eea;
}

/* Period Info Grid */
.period-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.period-item {
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    background: #f8faff;
    border-radius: 16px;
    border-left: 4px solid #667eea;
    transition: all 0.3s ease;
}

.period-item:hover {
    background: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.period-label {
    display: flex;
    align-items: center;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.period-value {
    color: #4a5568;
    font-size: 1.2rem;
    font-weight: 600;
}

/* Empty State */
.empty-state-small {
    text-align: center;
    padding: 2rem;
}

.empty-state-small .empty-icon {
    font-size: 2.5rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.empty-state-small h6 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.empty-state-small p {
    color: #718096;
    font-size: 0.9rem;
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

.bounce-animation {
    animation: bounce 2s infinite;
}

.pulse-animation {
    animation: pulse 2s infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .period-info-grid {
        grid-template-columns: 1fr;
    }
    
    .volunteer-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .volunteer-info {
        flex: none;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Auto-update time
setInterval(function() {
    document.getElementById('current-time').textContent = new Date().toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit',
        timeZone: 'Asia/Jakarta'
    }) + ' WIB';
}, 1000);

// Monthly Activities Chart
@if($monthlyActivities->count() > 0)
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    const chartData = @json($monthlyActivities->map(function($item) use ($monthNames) {
        return [
            'label' => $monthNames[$item->month - 1] . ' ' . $item->year,
            'value' => $item->count
        ];
    }));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(item => item.label),
            datasets: [{
                label: 'Aktivitas Bulanan',
                data: chartData.map(item => item.value),
                borderColor: 'rgb(102, 126, 234)',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
});
@endif
</script>
@endsection