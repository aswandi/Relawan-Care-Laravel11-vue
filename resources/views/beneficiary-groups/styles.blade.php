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
    background: linear-gradient(135deg, #9333ea 0%, #7c3aed 50%, #6366f1 100%);
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
    background: linear-gradient(45deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    font-weight: 500;
}

.hero-description {
    font-size: 1rem;
    opacity: 0.85;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.hero-icon {
    font-size: 4rem;
    margin-right: 2rem;
    background: linear-gradient(45deg, #fbbf24, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));
}

.bounce-animation {
    animation: bounce 2s infinite;
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

.hero-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.badge-modern {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: white;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.badge-modern:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.badge-modern.success {
    background: rgba(34, 197, 94, 0.2);
    border-color: rgba(34, 197, 94, 0.5);
}

.badge-modern.danger {
    background: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.5);
}

.weather-widget {
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.2) 100%);
}

/* Info Card */
.info-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 2rem;
    color: white;
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 0.95rem;
    font-weight: 500;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-icon {
    font-size: 1.2rem;
    margin-right: 0.75rem;
    opacity: 0.9;
}

/* Modern Statistics Cards */
.modern-stats-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: none;
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 160px;
    display: flex;
    align-items: center;
}

.modern-stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.gradient-purple {
    background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
    color: white;
}

.gradient-green {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.gradient-blue {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.gradient-orange {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.stats-icon {
    font-size: 3rem;
    margin-right: 1.5rem;
    opacity: 0.9;
}

.stats-content {
    flex: 1;
}

.stats-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stats-label {
    display: block;
    font-size: 0.95rem;
    font-weight: 600;
    opacity: 0.9;
    margin-bottom: 0.25rem;
}

.stats-trend {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
    opacity: 0.8;
}

.stats-trend i {
    margin-right: 0.25rem;
}

.stats-decoration {
    position: absolute;
    right: -20px;
    top: -20px;
    opacity: 0.1;
}

.decoration-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 2px solid currentColor;
    position: absolute;
}

.decoration-circle:nth-child(2) {
    width: 120px;
    height: 120px;
    top: -20px;
    right: -20px;
}

/* Modern Card */
.modern-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: none;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.modern-card:hover {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.card-header-modern {
    background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
    border-bottom: 2px solid #e2e8f0;
    padding: 2rem;
}

.card-title-modern {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.card-title-modern i {
    color: #9333ea;
    margin-right: 0.75rem;
}

.card-subtitle-modern {
    color: #64748b;
    font-size: 0.95rem;
    margin-bottom: 0;
}

.card-body-modern {
    padding: 2rem;
}

/* Action Buttons */
.action-button {
    background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
    color: white;
    border: none;
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    min-width: 160px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(147, 51, 234, 0.4);
}

.action-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(147, 51, 234, 0.6);
    color: white;
    text-decoration: none;
}

.action-button-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    min-width: 120px;
}

.action-button span {
    display: flex;
    align-items: center;
}

.action-button i:last-child {
    margin-left: 0.5rem;
    transition: transform 0.3s ease;
}

.action-button:hover i:last-child {
    transform: translateX(3px);
}

/* Search Box */
.search-box {
    position: relative;
}

.search-box .form-control {
    border-radius: 25px;
    border: 2px solid #e2e8f0;
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.search-box .form-control:focus {
    border-color: #9333ea;
    box-shadow: 0 0 0 0.2rem rgba(147, 51, 234, 0.25);
}

.search-box .btn {
    border-radius: 0 25px 25px 0;
    border: 2px solid #e2e8f0;
    border-left: none;
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
    color: #9333ea;
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

/* Group Info Styles */
.group-info {
    display: flex;
    align-items: center;
}

.group-avatar {
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
    font-size: 1.2rem;
}

.gradient-avatar-1 {
    background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
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

.group-details {
    display: flex;
    flex-direction: column;
}

.group-name {
    font-weight: 600;
    color: #2d3748;
    font-size: 1rem;
    line-height: 1.2;
}

.group-meta {
    color: #64748b;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

/* Description Text */
.description-text {
    color: #4a5568;
    font-size: 0.95rem;
    line-height: 1.4;
}

/* Count Badge */
.count-badge {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

.count-badge i {
    margin-right: 0.25rem;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    border: 1px solid transparent;
}

.status-badge.success {
    background: rgba(34, 197, 94, 0.1);
    color: #059669;
    border-color: rgba(34, 197, 94, 0.2);
}

.status-badge.danger {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    border-color: rgba(239, 68, 68, 0.2);
}

.status-badge i {
    margin-right: 0.25rem;
}

/* Date Info */
.date-info {
    display: flex;
    flex-direction: column;
}

.date-badge {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.action-btn.view {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.action-btn.edit {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.action-btn.delete {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    color: white;
    text-decoration: none;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #64748b;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.3;
}

.empty-state h6 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #374151;
}

.empty-state p {
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
}

/* Modern Pagination */
.modern-pagination {
    display: flex;
    justify-content: center;
    padding: 2rem;
    background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
}

/* Animations */
.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.animate-fade-in-right {
    animation: fadeInRight 0.6s ease-out 0.2s both;
}

.animate-scale-in {
    animation: scaleIn 0.5s ease-out;
}

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

/* Info Section Styles for Show Page */
.info-section {
    background: rgba(248, 250, 255, 0.5);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.info-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.info-details {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(226, 232, 240, 0.5);
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 500;
    color: #64748b;
    font-size: 0.9rem;
}

.info-value {
    font-weight: 600;
    color: #2d3748;
    font-size: 0.95rem;
    text-align: right;
}

.description-box {
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(226, 232, 240, 0.5);
    border-radius: 12px;
    padding: 1rem;
    color: #4a5568;
    line-height: 1.6;
    font-size: 0.95rem;
}

/* Beneficiary specific styles for show page */
.beneficiary-info {
    display: flex;
    align-items: center;
}

.beneficiary-avatar {
    margin-right: 1rem;
}

.beneficiary-details {
    display: flex;
    flex-direction: column;
}

.beneficiary-name {
    font-weight: 600;
    color: #2d3748;
    font-size: 1rem;
    line-height: 1.2;
}

.beneficiary-meta {
    color: #64748b;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

.beneficiary-nik {
    color: #4a5568;
    font-weight: 500;
    font-family: 'Courier New', monospace;
}

.phone-number {
    color: #4a5568;
    font-weight: 500;
}

.phone-number i {
    color: #9333ea;
}

.location-info {
    display: flex;
    flex-direction: column;
}

.location-badge {
    background: rgba(147, 51, 234, 0.1);
    color: #9333ea;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    border: 1px solid rgba(147, 51, 234, 0.2);
    margin-bottom: 0.25rem;
}

.age-badge {
    background: rgba(67, 233, 123, 0.1);
    color: #43e97b;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    border: 1px solid rgba(67, 233, 123, 0.2);
}

.gender-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    border: 1px solid transparent;
}

.gender-badge.female {
    background: rgba(236, 72, 153, 0.1);
    color: #ec4899;
    border-color: rgba(236, 72, 153, 0.2);
}

.gender-badge.male {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
    border-color: rgba(59, 130, 246, 0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-icon {
        font-size: 3rem;
        margin-right: 1rem;
    }
    
    .modern-stats-card {
        height: auto;
        padding: 1.5rem;
    }
    
    .stats-number {
        font-size: 2rem;
    }
    
    .card-header-modern,
    .card-body-modern {
        padding: 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .info-value {
        text-align: left;
    }
}
</style>