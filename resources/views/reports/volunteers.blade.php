@extends('layouts.app')

@section('content')
<div class="volunteers-report-container">
    <!-- Header Section -->
    <div class="report-header">
        <div class="header-content">
            <div class="header-text">
                <h1 class="report-title">
                    <i class="fas fa-users"></i>
                    Laporan Kinerja Relawan
                </h1>
                <p class="report-subtitle">Analisis performa dan kontribusi relawan dalam program distribusi bantuan</p>
            </div>
            
            <!-- Date Filter -->
            <div class="date-filter-section">
                <form method="GET" class="date-filter-form">
                    <div class="filter-group">
                        <label>Periode Laporan:</label>
                        <input type="date" name="start_date" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}" class="form-control">
                        <span class="filter-separator">s/d</span>
                        <input type="date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}" class="form-control">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards-grid">
        <div class="stat-card primary">
            <div class="stat-content">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-details">
                    <h3 class="stat-value">{{ $volunteerStats->count() }}</h3>
                    <p class="stat-label">Total Relawan</p>
                </div>
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-content">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-details">
                    <h3 class="stat-value">{{ $volunteerStats->where('activities_count', '>', 0)->count() }}</h3>
                    <p class="stat-label">Relawan Aktif</p>
                </div>
            </div>
        </div>

        <div class="stat-card warning">
            <div class="stat-content">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-details">
                    <h3 class="stat-value">{{ number_format($volunteerStats->sum('activities_count')) }}</h3>
                    <p class="stat-label">Total Aktivitas</p>
                </div>
            </div>
        </div>

        <div class="stat-card info">
            <div class="stat-content">
                <div class="stat-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="stat-details">
                    <h3 class="stat-value">{{ number_format($volunteerStats->sum('total_aids_distributed')) }}</h3>
                    <p class="stat-label">Total Bantuan Disalurkan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers Section -->
    <div class="top-performers-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-trophy"></i>
                Top 10 Relawan Terbaik
            </h2>
        </div>

        <div class="top-performers-grid">
            @foreach($volunteerStats->take(10) as $index => $stats)
            <div class="performer-card rank-{{ $index + 1 }}">
                <div class="rank-badge">
                    @if($index === 0)
                        <i class="fas fa-crown"></i>
                    @elseif($index === 1)
                        <i class="fas fa-medal"></i>
                    @elseif($index === 2)
                        <i class="fas fa-award"></i>
                    @else
                        {{ $index + 1 }}
                    @endif
                </div>
                
                <div class="performer-info">
                    <h4 class="performer-name">{{ $stats['volunteer']->name }}</h4>
                    <p class="performer-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $stats['volunteer']->desa->kel_nama ?? 'N/A' }}, {{ $stats['volunteer']->kecamatan->kec_nama ?? 'N/A' }}
                    </p>
                </div>

                <div class="performance-metrics">
                    <div class="metric">
                        <span class="metric-value">{{ $stats['activities_count'] }}</span>
                        <span class="metric-label">Aktivitas</span>
                    </div>
                    <div class="metric">
                        <span class="metric-value">{{ number_format($stats['total_aids_distributed']) }}</span>
                        <span class="metric-label">Bantuan</span>
                    </div>
                    <div class="metric">
                        <span class="metric-value">{{ $stats['unique_beneficiaries'] }}</span>
                        <span class="metric-label">Penerima</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Detailed Volunteers Table -->
    <div class="volunteers-table-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-table"></i>
                Detail Kinerja Semua Relawan
            </h2>
        </div>

        <div class="table-container">
            <table class="volunteers-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Relawan</th>
                        <th>Wilayah</th>
                        <th>Kontak</th>
                        <th>Aktivitas</th>
                        <th>Bantuan Disalurkan</th>
                        <th>Penerima Unik</th>
                        <th>Aktivitas Terakhir</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($volunteerStats as $index => $stats)
                    <tr class="volunteer-row">
                        <td class="row-number">{{ $index + 1 }}</td>
                        
                        <td class="volunteer-info">
                            <div class="volunteer-details">
                                <span class="volunteer-name">{{ $stats['volunteer']->name }}</span>
                                <small class="volunteer-id">ID: {{ $stats['volunteer']->id }}</small>
                            </div>
                        </td>
                        
                        <td class="location-info">
                            <div class="location-hierarchy">
                                <div class="location-level">{{ $stats['volunteer']->kabupaten->kab_nama ?? 'N/A' }}</div>
                                <div class="location-level">{{ $stats['volunteer']->kecamatan->kec_nama ?? 'N/A' }}</div>
                                <div class="location-level">{{ $stats['volunteer']->desa->kel_nama ?? 'N/A' }}</div>
                            </div>
                        </td>
                        
                        <td class="contact-info">
                            <div class="contact-details">
                                <span class="phone">
                                    <i class="fas fa-phone"></i>
                                    {{ $stats['volunteer']->phone ?? 'N/A' }}
                                </span>
                            </div>
                        </td>
                        
                        <td class="activities-count">
                            <div class="count-badge {{ $stats['activities_count'] > 10 ? 'high' : ($stats['activities_count'] > 5 ? 'medium' : 'low') }}">
                                {{ $stats['activities_count'] }}
                            </div>
                        </td>
                        
                        <td class="aids-distributed">
                            <span class="aids-value">{{ number_format($stats['total_aids_distributed']) }}</span>
                        </td>
                        
                        <td class="unique-beneficiaries">
                            <span class="beneficiaries-count">{{ $stats['unique_beneficiaries'] }}</span>
                        </td>
                        
                        <td class="last-activity">
                            @if($stats['last_activity'])
                                <span class="activity-date">{{ \Carbon\Carbon::parse($stats['last_activity'])->format('d/m/Y') }}</span>
                                <small class="activity-ago">({{ \Carbon\Carbon::parse($stats['last_activity'])->diffForHumans() }})</small>
                            @else
                                <span class="no-activity">Belum ada aktivitas</span>
                            @endif
                        </td>
                        
                        <td class="status">
                            @if($stats['activities_count'] > 0)
                                @if($stats['last_activity'] && \Carbon\Carbon::parse($stats['last_activity'])->isAfter(now()->subDays(30)))
                                    <span class="status-badge active">Aktif</span>
                                @else
                                    <span class="status-badge inactive">Tidak Aktif</span>
                                @endif
                            @else
                                <span class="status-badge new">Belum Mulai</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.volunteers-report-container {
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.report-header {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.report-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.report-title i {
    color: #667eea;
}

.report-subtitle {
    color: #718096;
    margin: 0.5rem 0 0 0;
    font-size: 1.1rem;
}

.date-filter-form {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-group label {
    font-weight: 600;
    color: #4a5568;
    white-space: nowrap;
}

.filter-separator {
    color: #a0aec0;
    font-weight: 500;
}

.stats-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.stat-card.primary { border-left: 5px solid #667eea; }
.stat-card.success { border-left: 5px solid #48bb78; }
.stat-card.warning { border-left: 5px solid #ed8936; }
.stat-card.info { border-left: 5px solid #4299e1; }

.stat-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.primary .stat-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.success .stat-icon { background: linear-gradient(135deg, #48bb78, #38a169); }
.warning .stat-icon { background: linear-gradient(135deg, #ed8936, #dd6b20); }
.info .stat-icon { background: linear-gradient(135deg, #4299e1, #3182ce); }

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.stat-label {
    color: #718096;
    margin: 0;
    font-weight: 500;
}

.top-performers-section {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.section-header {
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}

.section-title i {
    color: #ed8936;
}

.top-performers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}

.performer-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    position: relative;
    transition: transform 0.2s ease;
}

.performer-card:hover {
    transform: translateY(-2px);
}

.performer-card.rank-1 { border-left: 4px solid #ffd700; }
.performer-card.rank-2 { border-left: 4px solid #c0c0c0; }
.performer-card.rank-3 { border-left: 4px solid #cd7f32; }

.rank-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.rank-1 .rank-badge {
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    color: #744210;
}

.rank-2 .rank-badge {
    background: linear-gradient(135deg, #c0c0c0, #e2e8f0);
    color: #4a5568;
}

.rank-3 .rank-badge {
    background: linear-gradient(135deg, #cd7f32, #dd6b20);
    color: white;
}

.performer-card:not(.rank-1):not(.rank-2):not(.rank-3) .rank-badge {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.performer-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 0.25rem 0;
}

.performer-location {
    color: #718096;
    font-size: 0.9rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.performance-metrics {
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.metric {
    text-align: center;
}

.metric-value {
    display: block;
    font-size: 1.2rem;
    font-weight: 700;
    color: #667eea;
}

.metric-label {
    font-size: 0.8rem;
    color: #a0aec0;
    font-weight: 500;
}

.volunteers-table-section {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.table-container {
    overflow-x: auto;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.volunteers-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.volunteers-table th {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 1rem 0.75rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.9rem;
    border: none;
}

.volunteers-table th:first-child {
    border-top-left-radius: 12px;
}

.volunteers-table th:last-child {
    border-top-right-radius: 12px;
}

.volunteer-row {
    border-bottom: 1px solid #e2e8f0;
    transition: background-color 0.2s ease;
}

.volunteer-row:hover {
    background-color: #f7fafc;
}

.volunteers-table td {
    padding: 1rem 0.75rem;
    vertical-align: top;
}

.row-number {
    font-weight: 600;
    color: #667eea;
    text-align: center;
}

.volunteer-name {
    font-weight: 600;
    color: #2d3748;
}

.volunteer-id {
    color: #a0aec0;
    font-size: 0.8rem;
}

.location-hierarchy {
    font-size: 0.9rem;
}

.location-level {
    color: #4a5568;
    margin: 0.1rem 0;
}

.location-level:first-child {
    font-weight: 600;
}

.contact-details .phone {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: #4a5568;
    font-size: 0.9rem;
}

.count-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    text-align: center;
    color: white;
}

.count-badge.high { background: linear-gradient(135deg, #48bb78, #38a169); }
.count-badge.medium { background: linear-gradient(135deg, #ed8936, #dd6b20); }
.count-badge.low { background: linear-gradient(135deg, #e53e3e, #c53030); }

.aids-value, .beneficiaries-count {
    font-weight: 600;
    color: #2d3748;
}

.activity-date {
    font-weight: 500;
    color: #2d3748;
}

.activity-ago {
    color: #a0aec0;
    display: block;
}

.no-activity {
    color: #a0aec0;
    font-style: italic;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-badge.active {
    background: #c6f6d5;
    color: #22543d;
}

.status-badge.inactive {
    background: #fed7d7;
    color: #742a2a;
}

.status-badge.new {
    background: #bee3f8;
    color: #2a4365;
}

@media (max-width: 768px) {
    .volunteers-report-container {
        padding: 1rem;
    }
    
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .date-filter-form {
        flex-wrap: wrap;
    }
    
    .top-performers-grid {
        grid-template-columns: 1fr;
    }
    
    .table-container {
        font-size: 0.9rem;
    }
    
    .volunteers-table th,
    .volunteers-table td {
        padding: 0.5rem 0.375rem;
    }
}
</style>
@endsection