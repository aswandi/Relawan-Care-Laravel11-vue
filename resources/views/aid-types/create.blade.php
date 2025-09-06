@extends('layout.app')

@section('title', 'Tambah Jenis Bantuan')

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
            <i class="fas fa-plus me-1"></i>Tambah Jenis Bantuan
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
                                <i class="fas fa-plus-circle hero-icon bounce-animation"></i>
                                Tambah <span class="text-gradient">Jenis Bantuan</span>
                            </h1>
                            <p class="hero-subtitle">Buat Jenis Bantuan Baru</p>
                            <p class="hero-description">Daftarkan jenis bantuan baru untuk memperluas layanan RelawanCare kepada masyarakat</p>
                            <div class="hero-badges">
                                <span class="badge badge-modern">📝 Form Input</span>
                                <span class="badge badge-modern">💾 Auto Save</span>
                                <span class="badge badge-modern">✅ Validasi</span>
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
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Mode Input</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Section -->
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-edit"></i>
                    Form Tambah Jenis Bantuan
                </h5>
                <p class="card-subtitle-modern">Lengkapi informasi jenis bantuan yang akan ditambahkan ke sistem</p>
            </div>
            <div class="card-body-modern">
                <form action="{{ route('aid-types.store') }}" method="POST" id="aidTypeForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="modern-form-group">
                                <label for="name" class="modern-label">
                                    <i class="fas fa-gift me-2"></i>Nama Jenis Bantuan
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control modern-input @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Contoh: Bantuan Sembako, Bantuan Tunai, dll"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Nama jenis bantuan yang akan ditampilkan dalam sistem</small>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="modern-form-group">
                                <label for="description" class="modern-label">
                                    <i class="fas fa-info-circle me-2"></i>Deskripsi
                                </label>
                                <textarea class="form-control modern-textarea @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Deskripsikan jenis bantuan ini secara detail...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Penjelasan detail tentang jenis bantuan ini (opsional)</small>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="modern-form-group">
                                <label for="has_nominal" class="modern-label">
                                    <i class="fas fa-dollar-sign me-2"></i>Memiliki Nilai Nominal
                                </label>
                                <div class="modern-switch-container">
                                    <div class="form-check form-switch modern-switch">
                                        <input class="form-check-input" type="checkbox" id="has_nominal" name="has_nominal" value="1" {{ old('has_nominal') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="has_nominal">
                                            Ya, bantuan ini memiliki nilai nominal (uang)
                                        </label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Centang jika bantuan ini berupa uang dengan nilai tertentu</small>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="modern-form-group">
                                <label for="unit" class="modern-label">
                                    <i class="fas fa-ruler me-2"></i>Satuan
                                </label>
                                <input type="text" 
                                       class="form-control modern-input @error('unit') is-invalid @enderror" 
                                       id="unit" 
                                       name="unit" 
                                       value="{{ old('unit') }}" 
                                       placeholder="Contoh: paket, kg, liter, rupiah">
                                @error('unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">Satuan untuk mengukur bantuan ini (opsional)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons-form">
                        <button type="submit" class="btn btn-gradient-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Simpan Jenis Bantuan
                        </button>
                        <a href="{{ route('aid-types.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

/* Modern Form Styles */
.modern-form-group {
    position: relative;
    margin-bottom: 1.5rem;
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

.modern-input, .modern-textarea {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8faff;
}

.modern-input:focus, .modern-textarea:focus {
    border-color: #43e97b;
    box-shadow: 0 0 0 0.2rem rgba(67, 233, 123, 0.25);
    background: white;
    outline: none;
}

.modern-textarea {
    resize: vertical;
    min-height: 120px;
}

/* Modern Switch */
.modern-switch-container {
    background: #f8faff;
    padding: 1.5rem;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.modern-switch-container:hover {
    border-color: #43e97b;
    background: white;
}

.modern-switch .form-check-input {
    width: 3rem;
    height: 1.5rem;
    border-radius: 1rem;
    background-color: #e2e8f0;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modern-switch .form-check-input:checked {
    background-color: #43e97b;
    border-color: #43e97b;
}

.modern-switch .form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(67, 233, 123, 0.25);
}

.modern-switch .form-check-label {
    font-weight: 500;
    color: #2d3748;
    margin-left: 0.75rem;
    cursor: pointer;
}

/* Action Buttons */
.action-buttons-form {
    display: flex;
    gap: 1rem;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    padding-top: 2rem;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
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

/* Error States */
.is-invalid {
    border-color: #e53e3e !important;
}

.invalid-feedback {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    font-weight: 500;
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
    
    .action-buttons-form {
        flex-direction: column;
    }
    
    .action-buttons-form .btn {
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

// Form validation
document.getElementById('aidTypeForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    
    if (!name) {
        e.preventDefault();
        alert('Nama jenis bantuan harus diisi!');
        document.getElementById('name').focus();
        return false;
    }
});
</script>
@endsection