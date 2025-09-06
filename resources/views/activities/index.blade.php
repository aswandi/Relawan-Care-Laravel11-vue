@extends('layout.app')

@section('title', 'Aktivitas Relawan')

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
                                <i class="fas fa-tasks hero-icon bounce-animation"></i>
                                Monitoring <span class="text-gradient">Aktivitas Relawan</span>
                            </h1>
                            <p class="hero-subtitle">Pantau Kegiatan Relawan di Lapangan</p>
                            <p class="hero-description">Monitor dan evaluasi aktivitas distribusi bantuan yang dilakukan relawan kepada masyarakat</p>
                            <div class="hero-badges">
                                <span class="badge badge-modern">📊 {{ $activities->total() }} Aktivitas</span>
                                <span class="badge badge-modern">📍 GPS Tracking</span>
                                <span class="badge badge-modern">📷 Photo Reports</span>
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
                                    <span>Live Monitoring</span>
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
                <i class="fas fa-tasks pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $activities->total() }}">{{ $activities->total() }}</div>
                <div class="stats-label">Total Aktivitas</div>
                <div class="stats-trend">
                    <i class="fas fa-chart-line"></i>
                    <span>Semua aktivitas relawan</span>
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
                <i class="fas fa-calendar-day pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $activities->where('activity_date', '>=', now()->startOfDay())->count() }}">{{ $activities->where('activity_date', '>=', now()->startOfDay())->count() }}</div>
                <div class="stats-label">Hari Ini</div>
                <div class="stats-trend">
                    <i class="fas fa-calendar-check"></i>
                    <span>Aktivitas terbaru</span>
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
                <i class="fas fa-users pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $activities->pluck('volunteer_id')->unique()->count() }}">{{ $activities->pluck('volunteer_id')->unique()->count() }}</div>
                <div class="stats-label">Relawan Aktif</div>
                <div class="stats-trend">
                    <i class="fas fa-user-check"></i>
                    <span>Relawan terlibat</span>
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
                <i class="fas fa-camera pulse-animation"></i>
            </div>
            <div class="stats-content">
                <div class="stats-number counter-animation" data-target="{{ $activities->sum(function($activity) { return $activity->photos->count(); }) }}">{{ $activities->sum(function($activity) { return $activity->photos->count(); }) }}</div>
                <div class="stats-label">Total Foto</div>
                <div class="stats-trend">
                    <i class="fas fa-image"></i>
                    <span>Dokumentasi lapangan</span>
                </div>
            </div>
            <div class="stats-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-circle"></div>
            </div>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-filter"></i>
                    Filter Aktivitas
                </h5>
                <p class="card-subtitle-modern">Gunakan filter untuk mempersempit hasil pencarian aktivitas</p>
            </div>
            <div class="card-body-modern">
                <form method="GET" action="{{ route('activities.index') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="volunteer_id" class="modern-label">
                                <i class="fas fa-user me-2"></i>Relawan
                            </label>
                            <select class="form-control modern-select" id="volunteer_id" name="volunteer_id">
                                <option value="">-- Semua Relawan --</option>
                                @foreach($volunteers as $volunteer)
                                    <option value="{{ $volunteer->id }}" {{ request('volunteer_id') == $volunteer->id ? 'selected' : '' }}>
                                        {{ $volunteer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="aid_session_id" class="modern-label">
                                <i class="fas fa-calendar-alt me-2"></i>Sesi Bantuan
                            </label>
                            <select class="form-control modern-select" id="aid_session_id" name="aid_session_id">
                                <option value="">-- Semua Sesi --</option>
                                @foreach($aidSessions as $session)
                                    <option value="{{ $session->id }}" {{ request('aid_session_id') == $session->id ? 'selected' : '' }}>
                                        {{ $session->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="start_date" class="modern-label">
                                <i class="fas fa-calendar-plus me-2"></i>Dari Tanggal
                            </label>
                            <input type="date" class="form-control modern-input" id="start_date" name="start_date" value="{{ request('start_date') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="end_date" class="modern-label">
                                <i class="fas fa-calendar-minus me-2"></i>Sampai Tanggal
                            </label>
                            <input type="date" class="form-control modern-input" id="end_date" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>

                    <div class="filter-buttons">
                        <button type="submit" class="btn btn-gradient-primary">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                        <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="row">
    <div class="col-12">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.6s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-list"></i>
                    Daftar Aktivitas Relawan
                </h5>
                <p class="card-subtitle-modern">Monitor semua aktivitas distribusi bantuan yang dilakukan relawan</p>
            </div>
            <div class="card-body-modern">
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead class="modern-table-header">
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>No</th>
                                <th><i class="fas fa-calendar-day me-2"></i>Tanggal</th>
                                <th><i class="fas fa-user me-2"></i>Relawan</th>
                                <th><i class="fas fa-user-friends me-2"></i>Penerima</th>
                                <th><i class="fas fa-map-marker-alt me-2"></i>Lokasi</th>
                                <th><i class="fas fa-box me-2"></i>Bantuan</th>
                                <th><i class="fas fa-camera me-2"></i>Foto</th>
                                <th><i class="fas fa-eye me-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="modern-table-body">
                            @forelse($activities as $activity)
                                <tr class="modern-table-row animate-fade-in" style="animation-delay: {{ 0.1 * $loop->index }}s;">
                                    <td class="modern-table-cell">
                                        <span class="record-number">{{ $activities->firstItem() + $loop->index }}</span>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="date-info">
                                            <div class="date-primary">
                                                {{ $activity->activity_date->format('d M Y') }}
                                            </div>
                                            <div class="date-secondary">
                                                {{ $activity->created_at->format('H:i') }} WIB
                                            </div>
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="volunteer-info">
                                            <div class="volunteer-avatar">
                                                <div class="avatar-circle gradient-avatar-{{ ($loop->index % 4) + 1 }}">
                                                    {{ substr($activity->volunteer->name ?? 'N', 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="volunteer-details">
                                                <span class="volunteer-name">{{ $activity->volunteer->name ?? 'N/A' }}</span>
                                                <small class="volunteer-meta">{{ $activity->volunteer->phone ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="beneficiary-info">
                                            <span class="beneficiary-name">{{ $activity->beneficiary->name ?? 'N/A' }}</span>
                                            @if($activity->beneficiary)
                                                <small class="beneficiary-meta">{{ $activity->beneficiary->nik ?? '' }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="location-info">
                                            @if($activity->beneficiary && $activity->beneficiary->desa)
                                                <span class="location-name">{{ $activity->beneficiary->desa->kel_nama }}</span>
                                            @else
                                                <span class="location-name">-</span>
                                            @endif
                                            @if($activity->latitude && $activity->longitude)
                                                <div class="gps-coordinates">
                                                    <i class="fas fa-map-pin me-1"></i>
                                                    GPS: {{ number_format($activity->latitude, 4) }}, {{ number_format($activity->longitude, 4) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="aid-summary">
                                            @if($activity->aids && $activity->aids->count() > 0)
                                                @foreach($activity->aids->take(2) as $aid)
                                                    <span class="aid-badge">
                                                        <i class="fas fa-gift me-1"></i>
                                                        {{ $aid->aidType->name ?? 'Unknown' }}
                                                        @if($aid->quantity > 0)
                                                            ({{ $aid->quantity }})
                                                        @endif
                                                    </span>
                                                @endforeach
                                                @if($activity->aids->count() > 2)
                                                    <span class="more-aids">+{{ $activity->aids->count() - 2 }} lagi</span>
                                                @endif
                                            @else
                                                <span class="no-aids">Belum ada bantuan</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="photo-summary">
                                            @if($activity->photos && $activity->photos->count() > 0)
                                                <span class="photo-count">
                                                    <i class="fas fa-camera me-1"></i>
                                                    {{ $activity->photos->count() }} foto
                                                </span>
                                            @else
                                                <span class="no-photos">
                                                    <i class="fas fa-camera-slash me-1"></i>
                                                    Belum ada foto
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="modern-table-cell">
                                        <div class="action-buttons-sm">
                                            <a href="{{ route('activities.show', $activity) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($activity->latitude && $activity->longitude)
                                                <a href="https://www.google.com/maps?q={{ $activity->latitude }},{{ $activity->longitude }}" target="_blank" class="btn btn-success btn-sm" title="Lihat di Maps">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="modern-table-cell">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-tasks"></i>
                                            </div>
                                            <h6>Belum Ada Aktivitas</h6>
                                            <p>Belum ada aktivitas relawan yang tercatat dalam sistem</p>
                                            @if(request()->hasAny(['volunteer_id', 'aid_session_id', 'start_date', 'end_date']))
                                                <a href="{{ route('activities.index') }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-times me-2"></i>Reset Filter
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($activities->hasPages())
                    <div class="modern-pagination">
                        {{ $activities->withQueryString()->links() }}
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

/* Modern Form Styles */
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

.modern-input, .modern-select {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8faff;
}

.modern-input:focus, .modern-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: white;
    outline: none;
}

.filter-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    margin-top: 1rem;
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

.btn-outline-secondary {
    border: 2px solid #e2e8f0;
    color: #718096;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #f8faff;
    border-color: #cbd5e0;
    color: #2d3748;
}

.btn-outline-primary {
    border: 2px solid #667eea;
    color: #667eea;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #667eea;
    border-color: #667eea;
    color: white;
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

/* Table Cell Specific Styles */
.record-number {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.date-info {
    display: flex;
    flex-direction: column;
}

.date-primary {
    font-weight: 600;
    color: #2d3748;
    font-size: 1rem;
}

.date-secondary {
    color: #718096;
    font-size: 0.8rem;
}

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

.beneficiary-info {
    display: flex;
    flex-direction: column;
}

.beneficiary-name {
    font-weight: 600;
    color: #2d3748;
    font-size: 1rem;
}

.beneficiary-meta {
    color: #718096;
    font-size: 0.8rem;
}

.location-info {
    display: flex;
    flex-direction: column;
}

.location-name {
    font-weight: 600;
    color: #2d3748;
    font-size: 0.95rem;
}

.gps-coordinates {
    color: #43e97b;
    font-size: 0.75rem;
    font-weight: 500;
    margin-top: 0.25rem;
}

.aid-summary {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.aid-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
    color: #667eea;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid #e2e8f0;
}

.more-aids {
    color: #718096;
    font-size: 0.8rem;
    font-style: italic;
}

.no-aids {
    color: #a0aec0;
    font-size: 0.9rem;
    font-style: italic;
}

.photo-summary {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.photo-count {
    display: flex;
    align-items: center;
    color: #43e97b;
    font-weight: 600;
    font-size: 0.9rem;
}

.no-photos {
    display: flex;
    align-items: center;
    color: #a0aec0;
    font-size: 0.9rem;
}

.action-buttons-sm {
    display: flex;
    gap: 0.5rem;
}

.action-buttons-sm .btn {
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    transition: all 0.3s ease;
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

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .filter-buttons {
        flex-direction: column;
    }
    
    .filter-buttons .btn {
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
</script>
@endsection