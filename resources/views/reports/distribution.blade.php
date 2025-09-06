@extends('layout.app')

@section('title', 'Laporan Distribusi Bantuan')

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
                                <i class="fas fa-chart-bar hero-icon bounce-animation"></i>
                                Laporan <span class="text-gradient">Distribusi Bantuan</span>
                            </h1>
                            <p class="hero-subtitle">Analisis Penyaluran Bantuan RelawanCare</p>
                            <p class="hero-description">Laporan komprehensif distribusi bantuan berdasarkan jenis bantuan dan wilayah penerima</p>
                            <div class="hero-badges">
                                <span class="badge badge-modern">📦 Distribusi per Jenis</span>
                                <span class="badge badge-modern">🗺️ Sebaran Wilayah</span>
                                <span class="badge badge-modern">💰 Analisis Nominal</span>
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
                                    <i class="fas fa-chart-pie"></i>
                                    <span>Distribution Analytics</span>
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
                <form method="GET" action="{{ route('reports.distribution') }}" class="date-filter-form">
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
                                <i class="fas fa-chart-bar me-2"></i>Generate Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Aid Distribution by Type -->
    <div class="col-lg-7 mb-4">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.4s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-box-open"></i>
                    Distribusi per Jenis Bantuan
                </h5>
                <p class="card-subtitle-modern">Breakdown bantuan yang disalurkan berdasarkan jenis dan jumlah</p>
            </div>
            <div class="card-body-modern">
                @if($aidDistribution->count() > 0)
                    <div class="aid-distribution-list">
                        @foreach($aidDistribution as $aid)
                            <div class="aid-distribution-item">
                                <div class="aid-header">
                                    <div class="aid-icon">
                                        <i class="fas fa-gift"></i>
                                    </div>
                                    <div class="aid-info">
                                        <h6 class="aid-name">{{ $aid->name }}</h6>
                                        @if($aid->unit)
                                            <span class="aid-unit">Satuan: {{ $aid->unit }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="aid-metrics">
                                    <div class="metric-item">
                                        <div class="metric-label">Total Kuantitas</div>
                                        <div class="metric-value quantity">
                                            {{ number_format($aid->total_quantity ?: 0) }}
                                            @if($aid->unit) {{ $aid->unit }} @endif
                                        </div>
                                    </div>
                                    @if($aid->total_nominal > 0)
                                        <div class="metric-item">
                                            <div class="metric-label">Total Nominal</div>
                                            <div class="metric-value nominal">
                                                Rp {{ number_format($aid->total_nominal, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="aid-progress">
                                    @php
                                        $maxQuantity = $aidDistribution->max('total_quantity') ?: 1;
                                        $percentage = ($aid->total_quantity / $maxQuantity) * 100;
                                    @endphp
                                    <div class="progress modern-progress">
                                        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="progress-text">{{ number_format($percentage, 1) }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h6>Belum Ada Distribusi</h6>
                        <p>Belum ada data distribusi bantuan pada periode yang dipilih</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Distribution Summary -->
    <div class="col-lg-5 mb-4">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-chart-pie"></i>
                    Ringkasan Distribusi
                </h5>
                <p class="card-subtitle-modern">Statistik ringkas distribusi bantuan</p>
            </div>
            <div class="card-body-modern">
                @php
                    $totalTypes = $aidDistribution->count();
                    $totalQuantity = $aidDistribution->sum('total_quantity');
                    $totalNominal = $aidDistribution->sum('total_nominal');
                    $averageQuantity = $totalTypes > 0 ? $totalQuantity / $totalTypes : 0;
                @endphp

                <div class="summary-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $totalTypes }}</div>
                            <div class="stat-label">Jenis Bantuan</div>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ number_format($totalQuantity) }}</div>
                            <div class="stat-label">Total Unit</div>
                        </div>
                    </div>

                    @if($totalNominal > 0)
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">Rp {{ number_format($totalNominal, 0, ',', '.') }}</div>
                                <div class="stat-label">Total Nominal</div>
                            </div>
                        </div>
                    @endif

                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ number_format($averageQuantity, 1) }}</div>
                            <div class="stat-label">Rata-rata per Jenis</div>
                        </div>
                    </div>
                </div>

                @if($aidDistribution->count() > 0)
                    <div class="chart-container">
                        <canvas id="distributionChart" height="200"></canvas>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Distribution by Region -->
<div class="row">
    <div class="col-12">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.6s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-map-marked-alt"></i>
                    Distribusi per Wilayah
                </h5>
                <p class="card-subtitle-modern">Sebaran aktivitas bantuan berdasarkan wilayah administrasi</p>
            </div>
            <div class="card-body-modern">
                @if($regionDistribution->count() > 0)
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead class="modern-table-header">
                                <tr>
                                    <th><i class="fas fa-hashtag me-2"></i>No</th>
                                    <th><i class="fas fa-map me-2"></i>Kabupaten/Kota</th>
                                    <th><i class="fas fa-map-pin me-2"></i>Kecamatan</th>
                                    <th><i class="fas fa-home me-2"></i>Desa/Kelurahan</th>
                                    <th><i class="fas fa-chart-line me-2"></i>Jumlah Aktivitas</th>
                                    <th><i class="fas fa-percentage me-2"></i>Persentase</th>
                                </tr>
                            </thead>
                            <tbody class="modern-table-body">
                                @php $totalActivities = $regionDistribution->sum('activity_count'); @endphp
                                @foreach($regionDistribution as $region)
                                    <tr class="modern-table-row animate-fade-in" style="animation-delay: {{ 0.1 * $loop->index }}s;">
                                        <td class="modern-table-cell">
                                            <span class="record-number">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="modern-table-cell">
                                            <div class="region-info">
                                                <div class="region-icon kabupaten">
                                                    <i class="fas fa-city"></i>
                                                </div>
                                                <span class="region-name">{{ $region->kabupaten_name ?: '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="modern-table-cell">
                                            <div class="region-info">
                                                <div class="region-icon kecamatan">
                                                    <i class="fas fa-map"></i>
                                                </div>
                                                <span class="region-name">{{ $region->kecamatan_name ?: '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="modern-table-cell">
                                            <div class="region-info">
                                                <div class="region-icon desa">
                                                    <i class="fas fa-home"></i>
                                                </div>
                                                <span class="region-name">{{ $region->desa_name ?: '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="modern-table-cell">
                                            <div class="activity-count">
                                                <span class="count-badge">{{ $region->activity_count }}</span>
                                                <span class="count-text">aktivitas</span>
                                            </div>
                                        </td>
                                        <td class="modern-table-cell">
                                            @php $percentage = $totalActivities > 0 ? ($region->activity_count / $totalActivities) * 100 : 0; @endphp
                                            <div class="percentage-display">
                                                <div class="percentage-bar">
                                                    <div class="percentage-fill" style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span class="percentage-text">{{ number_format($percentage, 1) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Region Summary -->
                    <div class="region-summary mt-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="summary-card">
                                    <div class="summary-icon">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </div>
                                    <div class="summary-content">
                                        <div class="summary-number">{{ $regionDistribution->pluck('kabupaten_name')->unique()->count() }}</div>
                                        <div class="summary-label">Kabupaten/Kota</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-card">
                                    <div class="summary-icon">
                                        <i class="fas fa-map"></i>
                                    </div>
                                    <div class="summary-content">
                                        <div class="summary-number">{{ $regionDistribution->pluck('kecamatan_name')->unique()->count() }}</div>
                                        <div class="summary-label">Kecamatan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-card">
                                    <div class="summary-icon">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="summary-content">
                                        <div class="summary-number">{{ $regionDistribution->count() }}</div>
                                        <div class="summary-label">Desa/Kelurahan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-card">
                                    <div class="summary-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div class="summary-content">
                                        <div class="summary-number">{{ $totalActivities }}</div>
                                        <div class="summary-label">Total Aktivitas</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h6>Belum Ada Data Wilayah</h6>
                        <p>Belum ada data distribusi berdasarkan wilayah pada periode yang dipilih</p>
                    </div>
                @endif
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
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
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
    color: #43e97b;
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
    color: #43e97b;
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
    border-color: #43e97b;
    box-shadow: 0 0 0 0.2rem rgba(67, 233, 123, 0.25);
    background: white;
    outline: none;
}

.btn-gradient-primary {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(67, 233, 123, 0.4);
}

.btn-gradient-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(67, 233, 123, 0.6);
    color: white;
}

/* Aid Distribution List */
.aid-distribution-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.aid-distribution-item {
    background: #f8faff;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.aid-distribution-item:hover {
    border-color: #43e97b;
    background: white;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.aid-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.aid-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin-right: 1rem;
}

.aid-info h6 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.aid-unit {
    color: #718096;
    font-size: 0.9rem;
}

.aid-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.metric-item {
    display: flex;
    flex-direction: column;
}

.metric-label {
    font-size: 0.9rem;
    color: #718096;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.metric-value {
    font-size: 1.1rem;
    font-weight: 700;
}

.metric-value.quantity {
    color: #43e97b;
}

.metric-value.nominal {
    color: #ffd89b;
}

.aid-progress {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.modern-progress {
    flex: 1;
    height: 8px;
    background: #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border-radius: 10px;
    transition: width 0.5s ease;
}

.progress-text {
    font-size: 0.9rem;
    font-weight: 600;
    color: #43e97b;
    min-width: 50px;
    text-align: right;
}

/* Summary Stats */
.summary-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border-radius: 50%;
    color: white;
    font-size: 1rem;
    margin-right: 1rem;
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 1.3rem;
    font-weight: 800;
    color: #2d3748;
    line-height: 1;
}

.stat-label {
    color: #718096;
    font-size: 0.8rem;
    font-weight: 500;
    margin-top: 0.25rem;
}

/* Chart Container */
.chart-container {
    position: relative;
    height: 200px;
    width: 100%;
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
    color: #43e97b;
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

.record-number {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.region-info {
    display: flex;
    align-items: center;
}

.region-icon {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.8rem;
    margin-right: 0.75rem;
}

.region-icon.kabupaten {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.region-icon.kecamatan {
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
}

.region-icon.desa {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.region-name {
    font-weight: 600;
    color: #2d3748;
}

.activity-count {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.count-badge {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 700;
    font-size: 1.1rem;
}

.count-text {
    color: #718096;
    font-size: 0.8rem;
    margin-top: 0.25rem;
}

.percentage-display {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.percentage-bar {
    flex: 1;
    height: 6px;
    background: #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
}

.percentage-fill {
    height: 100%;
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border-radius: 10px;
    transition: width 0.5s ease;
}

.percentage-text {
    font-weight: 600;
    color: #43e97b;
    font-size: 0.9rem;
    min-width: 45px;
}

/* Region Summary */
.region-summary {
    background: #f8faff;
    padding: 1.5rem;
    border-radius: 16px;
    border: 2px solid #e2e8f0;
}

.summary-card {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.summary-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border-radius: 50%;
    color: white;
    font-size: 1rem;
    margin-right: 1rem;
}

.summary-content {
    display: flex;
    flex-direction: column;
}

.summary-number {
    font-size: 1.5rem;
    font-weight: 800;
    color: #2d3748;
    line-height: 1;
}

.summary-label {
    color: #718096;
    font-size: 0.8rem;
    font-weight: 500;
    margin-top: 0.25rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state .empty-icon {
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

.animate-fade-in {
    animation: fadeInUp 0.6s ease-out;
}

.bounce-animation {
    animation: bounce 2s infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .aid-metrics {
        grid-template-columns: 1fr;
    }
    
    .aid-progress {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .percentage-display {
        flex-direction: column;
        gap: 0.5rem;
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

// Distribution Chart
@if($aidDistribution->count() > 0)
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('distributionChart').getContext('2d');
    
    const chartData = @json($aidDistribution->map(function($item) {
        return [
            'label' => $item->name,
            'value' => $item->total_quantity ?: 0
        ];
    }));

    const colors = [
        'rgba(67, 233, 123, 0.8)',
        'rgba(79, 172, 254, 0.8)', 
        'rgba(255, 216, 155, 0.8)',
        'rgba(240, 147, 251, 0.8)',
        'rgba(102, 126, 234, 0.8)'
    ];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: chartData.map(item => item.label),
            datasets: [{
                data: chartData.map(item => item.value),
                backgroundColor: colors.slice(0, chartData.length),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
});
@endif
</script>
@endsection