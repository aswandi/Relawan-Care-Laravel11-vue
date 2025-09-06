@extends('layout.app')

@section('title', 'Edit Sesi Bantuan')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb modern-breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('aid-sessions.index') }}">
                <i class="fas fa-calendar-alt me-1"></i>Sesi Bantuan
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="fas fa-edit me-1"></i>Edit Sesi Bantuan
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
                                <i class="fas fa-edit hero-icon bounce-animation"></i>
                                Edit <span class="text-gradient">{{ $aidSession->name }}</span>
                            </h1>
                            <p class="hero-subtitle">Perbarui Sesi Bantuan</p>
                            <p class="hero-description">Modifikasi informasi sesi bantuan, periode pelaksanaan, dan item bantuan sesuai kebutuhan</p>
                            <div class="hero-badges">
                                <span class="badge badge-modern">✏️ Mode Edit</span>
                                <span class="badge badge-modern">📅 Update Periode</span>
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
                                    <i class="fas fa-edit"></i>
                                    <span>Mode Edit</span>
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
    <div class="col-lg-10">
        <div class="modern-card animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="card-header-modern">
                <h5 class="card-title-modern">
                    <i class="fas fa-edit"></i>
                    Form Edit Sesi Bantuan
                </h5>
                <p class="card-subtitle-modern">Perbarui informasi sesi bantuan {{ $aidSession->name }}</p>
            </div>
            <div class="card-body-modern">
                <form action="{{ route('aid-sessions.update', $aidSession) }}" method="POST" id="aidSessionForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <h6 class="section-title">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Dasar
                            </h6>
                            <p class="section-subtitle">Data dasar sesi bantuan</p>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="modern-form-group">
                                    <label for="name" class="modern-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Nama Sesi Bantuan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control modern-input @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $aidSession->name) }}" 
                                           placeholder="Contoh: Bantuan Ramadhan 2024, Bantuan Bencana Banjir, dll"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Nama yang akan digunakan untuk mengidentifikasi sesi bantuan</small>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="modern-form-group">
                                    <label for="description" class="modern-label">
                                        <i class="fas fa-align-left me-2"></i>Deskripsi
                                    </label>
                                    <textarea class="form-control modern-textarea @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Deskripsikan tujuan dan detail sesi bantuan ini...">{{ old('description', $aidSession->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Penjelasan detail tentang sesi bantuan ini (opsional)</small>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="modern-form-group">
                                    <label for="start_date" class="modern-label">
                                        <i class="fas fa-calendar-plus me-2"></i>Tanggal Mulai
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control modern-input @error('start_date') is-invalid @enderror" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ old('start_date', $aidSession->start_date->format('Y-m-d')) }}" 
                                           required>
                                    @error('start_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Tanggal mulai pelaksanaan sesi bantuan</small>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="modern-form-group">
                                    <label for="end_date" class="modern-label">
                                        <i class="fas fa-calendar-minus me-2"></i>Tanggal Selesai
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control modern-input @error('end_date') is-invalid @enderror" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="{{ old('end_date', $aidSession->end_date->format('Y-m-d')) }}" 
                                           required>
                                    @error('end_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Tanggal berakhir pelaksanaan sesi bantuan</small>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="modern-form-group">
                                    <label for="is_active" class="modern-label">
                                        <i class="fas fa-toggle-on me-2"></i>Status Aktif
                                    </label>
                                    <div class="modern-switch-container">
                                        <div class="form-check form-switch modern-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $aidSession->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Ya, sesi bantuan ini aktif
                                            </label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Centang untuk mengaktifkan sesi bantuan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aid Items Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <h6 class="section-title">
                                <i class="fas fa-box me-2"></i>
                                Item Bantuan
                            </h6>
                            <p class="section-subtitle">Kelola jenis bantuan yang akan didistribusikan</p>
                        </div>

                        <div id="aid-items-container">
                            <!-- Existing aid items will be loaded here -->
                        </div>

                        <div class="add-item-section">
                            <button type="button" class="btn btn-outline-primary btn-lg" onclick="addAidItem()">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Item Bantuan
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons-form">
                        <button type="submit" class="btn btn-gradient-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Sesi Bantuan
                        </button>
                        <a href="{{ route('aid-sessions.show', $aidSession) }}" class="btn btn-outline-info btn-lg">
                            <i class="fas fa-eye me-2"></i>Lihat Detail
                        </a>
                        <a href="{{ route('aid-sessions.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Aid Item Template -->
<template id="aid-item-template">
    <div class="aid-item-card">
        <div class="card-header-aid-item">
            <h6 class="aid-item-title">
                <i class="fas fa-gift me-2"></i>
                Item Bantuan #<span class="item-number"></span>
            </h6>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAidItem(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="card-body-aid-item">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="modern-label">
                        <i class="fas fa-gift me-2"></i>Jenis Bantuan
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control modern-select aid-type-select" name="aid_items[][aid_type_id]" required onchange="toggleNominalField(this)">
                        <option value="">-- Pilih Jenis Bantuan --</option>
                        @foreach($aidTypes as $aidType)
                            <option value="{{ $aidType->id }}" data-has-nominal="{{ $aidType->has_nominal ? 'true' : 'false' }}" data-unit="{{ $aidType->unit }}">
                                {{ $aidType->name }}
                                @if($aidType->unit) ({{ $aidType->unit }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3 quantity-field">
                    <label class="modern-label">
                        <i class="fas fa-hashtag me-2"></i>Jumlah Tersedia
                    </label>
                    <input type="number" 
                           class="form-control modern-input" 
                           name="aid_items[][quantity_available]" 
                           min="1" 
                           placeholder="Contoh: 100">
                    <small class="form-text text-muted">Jumlah item yang tersedia untuk didistribusikan</small>
                </div>

                <div class="col-md-6 mb-3 nominal-field" style="display: none;">
                    <label class="modern-label">
                        <i class="fas fa-money-bill-wave me-2"></i>Nominal per Item (Rp)
                    </label>
                    <input type="number" 
                           class="form-control modern-input" 
                           name="aid_items[][nominal_amount]" 
                           min="0" 
                           step="1000"
                           placeholder="Contoh: 100000">
                    <small class="form-text text-muted">Nilai nominal dalam rupiah (untuk bantuan tunai)</small>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Reuse styles from create.blade.php */
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
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
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
    background: linear-gradient(45deg, #4facfe 0%, #00f2fe 100%);
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
    color: #4facfe;
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
    color: #ffd89b;
}

.card-subtitle-modern {
    color: #718096;
    font-size: 0.95rem;
    margin: 0;
}

.card-body-modern {
    padding: 1rem 2rem 2rem 2rem;
}

/* Form Sections */
.form-section {
    margin-bottom: 3rem;
    padding: 2rem;
    border: 2px solid #f0f4ff;
    border-radius: 16px;
    background: #f8faff;
    transition: all 0.3s ease;
}

.form-section:hover {
    border-color: #e2e8f0;
    background: white;
}

.section-header {
    margin-bottom: 2rem;
    text-align: center;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.section-title i {
    color: #ffd89b;
}

.section-subtitle {
    color: #718096;
    font-size: 0.95rem;
    margin: 0;
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
    color: #ffd89b;
}

.modern-input, .modern-textarea, .modern-select {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8faff;
}

.modern-input:focus, .modern-textarea:focus, .modern-select:focus {
    border-color: #ffd89b;
    box-shadow: 0 0 0 0.2rem rgba(255, 216, 155, 0.25);
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
    border-color: #ffd89b;
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
    background-color: #ffd89b;
    border-color: #ffd89b;
}

.modern-switch .form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 216, 155, 0.25);
}

.modern-switch .form-check-label {
    font-weight: 500;
    color: #2d3748;
    margin-left: 0.75rem;
    cursor: pointer;
}

/* Aid Item Cards */
.aid-item-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.aid-item-card:hover {
    border-color: #ffd89b;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.card-header-aid-item {
    padding: 1.5rem 2rem 1rem 2rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.aid-item-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
}

.aid-item-title i {
    color: #ffd89b;
}

.card-body-aid-item {
    padding: 1rem 2rem 2rem 2rem;
}

.add-item-section {
    text-align: center;
    padding: 2rem;
    border: 2px dashed #e2e8f0;
    border-radius: 16px;
    background: #f8faff;
    transition: all 0.3s ease;
    margin-top: 1.5rem;
}

.add-item-section:hover {
    border-color: #ffd89b;
    background: white;
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
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 216, 155, 0.4);
}

.btn-gradient-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 216, 155, 0.6);
    color: white;
}

.btn-outline-secondary, .btn-outline-info {
    border: 2px solid #e2e8f0;
    color: #718096;
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-info {
    border-color: #4facfe;
    color: #4facfe;
}

.btn-outline-secondary:hover {
    background: #f8faff;
    border-color: #cbd5e0;
    color: #2d3748;
}

.btn-outline-info:hover {
    background: #4facfe;
    border-color: #4facfe;
    color: white;
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
let itemCount = 0;
const existingItems = @json($aidSession->items);

// Auto-update time
setInterval(function() {
    document.getElementById('current-time').textContent = new Date().toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit',
        timeZone: 'Asia/Jakarta'
    }) + ' WIB';
}, 1000);

// Add aid item
function addAidItem(existingItem = null) {
    itemCount++;
    const template = document.getElementById('aid-item-template');
    const clone = template.content.cloneNode(true);
    
    // Update item number
    clone.querySelector('.item-number').textContent = itemCount;
    
    // Update field names with proper array notation
    const selects = clone.querySelectorAll('select');
    const inputs = clone.querySelectorAll('input');
    
    selects[0].name = `aid_items[${itemCount-1}][aid_type_id]`;
    inputs[0].name = `aid_items[${itemCount-1}][quantity_available]`;
    inputs[1].name = `aid_items[${itemCount-1}][nominal_amount]`;
    
    // Pre-populate if editing existing item
    if (existingItem) {
        selects[0].value = existingItem.aid_type_id;
        inputs[0].value = existingItem.quantity_available;
        inputs[1].value = existingItem.nominal_amount;
        
        // Trigger nominal field toggle
        toggleNominalField(selects[0]);
    }
    
    document.getElementById('aid-items-container').appendChild(clone);
}

// Remove aid item
function removeAidItem(button) {
    button.closest('.aid-item-card').remove();
}

// Toggle nominal field based on aid type
function toggleNominalField(select) {
    const aidItemCard = select.closest('.aid-item-card');
    const option = select.options[select.selectedIndex];
    const hasNominal = option.getAttribute('data-has-nominal') === 'true';
    
    const quantityField = aidItemCard.querySelector('.quantity-field');
    const nominalField = aidItemCard.querySelector('.nominal-field');
    const nominalInput = nominalField.querySelector('input');
    
    if (hasNominal) {
        nominalField.style.display = 'block';
        nominalInput.required = true;
    } else {
        nominalField.style.display = 'none';
        nominalInput.required = false;
        nominalInput.value = '';
    }
}

// Form validation
document.getElementById('aidSessionForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const aidItems = document.querySelectorAll('.aid-item-card');
    
    if (!name) {
        e.preventDefault();
        alert('Nama sesi bantuan harus diisi!');
        document.getElementById('name').focus();
        return false;
    }
    
    if (!startDate || !endDate) {
        e.preventDefault();
        alert('Tanggal mulai dan selesai harus diisi!');
        return false;
    }
    
    if (new Date(startDate) > new Date(endDate)) {
        e.preventDefault();
        alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai!');
        return false;
    }
    
    if (aidItems.length === 0) {
        e.preventDefault();
        alert('Minimal harus ada satu item bantuan!');
        return false;
    }
    
    // Validate each aid item
    for (let i = 0; i < aidItems.length; i++) {
        const aidTypeSelect = aidItems[i].querySelector('.aid-type-select');
        if (!aidTypeSelect.value) {
            e.preventDefault();
            alert(`Item bantuan #${i + 1}: Jenis bantuan harus dipilih!`);
            aidTypeSelect.focus();
            return false;
        }
    }
});

// Load existing items on page load
document.addEventListener('DOMContentLoaded', function() {
    // Load existing aid items
    existingItems.forEach(function(item) {
        addAidItem(item);
    });
    
    // Add one empty item if no existing items
    if (existingItems.length === 0) {
        addAidItem();
    }
});
</script>
@endsection