-- MONEV RELAWAN Database Structure
-- Laravel 11 Compatible MySQL Structure
-- Created for RelawanCare Application

SET FOREIGN_KEY_CHECKS = 0;
DROP DATABASE IF EXISTS monev_relawan;
CREATE DATABASE monev_relawan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE monev_relawan;

-- Users table for web dashboard login
CREATE TABLE users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id)
);

-- Administrative regions table (Kabupaten, Kecamatan, Desa in one table)
CREATE TABLE administrative_regions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    parent_id BIGINT UNSIGNED NULL,
    code VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    level ENUM('kabupaten', 'kecamatan', 'desa') NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (parent_id) REFERENCES administrative_regions(id) ON DELETE CASCADE,
    INDEX idx_parent_level (parent_id, level),
    INDEX idx_code (code)
);

-- Volunteers table
CREATE TABLE volunteers (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    volunteer_code VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- 5 digit PIN
    kabupaten_id BIGINT UNSIGNED NOT NULL,
    kecamatan_id BIGINT UNSIGNED NOT NULL,
    desa_id BIGINT UNSIGNED NOT NULL,
    address TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kabupaten_id) REFERENCES administrative_regions(id),
    FOREIGN KEY (kecamatan_id) REFERENCES administrative_regions(id),
    FOREIGN KEY (desa_id) REFERENCES administrative_regions(id),
    INDEX idx_phone (phone),
    INDEX idx_active (is_active)
);

-- Aid types table
CREATE TABLE aid_types (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    has_nominal BOOLEAN DEFAULT FALSE, -- TRUE for cash aid
    unit VARCHAR(50) NULL, -- kg, pcs, etc.
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    INDEX idx_active (is_active)
);

-- Aid sessions table
CREATE TABLE aid_sessions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    INDEX idx_dates (start_date, end_date),
    INDEX idx_active (is_active)
);

-- Aid session items (what aids are available in each session)
CREATE TABLE aid_session_items (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    aid_session_id BIGINT UNSIGNED NOT NULL,
    aid_type_id BIGINT UNSIGNED NOT NULL,
    quantity_available INT NULL,
    nominal_amount DECIMAL(12,2) NULL, -- for cash aid
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (aid_session_id) REFERENCES aid_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (aid_type_id) REFERENCES aid_types(id) ON DELETE CASCADE,
    UNIQUE KEY unique_session_aid (aid_session_id, aid_type_id)
);

-- Beneficiaries table (Masyarakat penerima bantuan)
CREATE TABLE beneficiaries (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    family_card_number VARCHAR(20) NOT NULL UNIQUE, -- Nomor KK
    national_id VARCHAR(20) NOT NULL UNIQUE, -- NIK
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    address TEXT NOT NULL,
    rt VARCHAR(5) NOT NULL,
    rw VARCHAR(5) NOT NULL,
    kabupaten_id BIGINT UNSIGNED NOT NULL,
    kecamatan_id BIGINT UNSIGNED NOT NULL,
    desa_id BIGINT UNSIGNED NOT NULL,
    age INT NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (kabupaten_id) REFERENCES administrative_regions(id),
    FOREIGN KEY (kecamatan_id) REFERENCES administrative_regions(id),
    FOREIGN KEY (desa_id) REFERENCES administrative_regions(id),
    INDEX idx_family_card (family_card_number),
    INDEX idx_national_id (national_id),
    INDEX idx_location (kabupaten_id, kecamatan_id, desa_id)
);

-- Volunteer activities/visits table
CREATE TABLE volunteer_activities (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    volunteer_id BIGINT UNSIGNED NOT NULL,
    beneficiary_id BIGINT UNSIGNED NOT NULL,
    aid_session_id BIGINT UNSIGNED NOT NULL,
    visit_date DATETIME NOT NULL,
    latitude DECIMAL(10, 8) NULL,
    longitude DECIMAL(11, 8) NULL,
    notes TEXT NULL,
    status ENUM('visited', 'not_home', 'rejected', 'completed') DEFAULT 'visited',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (volunteer_id) REFERENCES volunteers(id) ON DELETE CASCADE,
    FOREIGN KEY (beneficiary_id) REFERENCES beneficiaries(id) ON DELETE CASCADE,
    FOREIGN KEY (aid_session_id) REFERENCES aid_sessions(id) ON DELETE CASCADE,
    INDEX idx_volunteer_date (volunteer_id, visit_date),
    INDEX idx_beneficiary (beneficiary_id),
    INDEX idx_session (aid_session_id)
);

-- Activity photos table
CREATE TABLE activity_photos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    volunteer_activity_id BIGINT UNSIGNED NOT NULL,
    photo_path VARCHAR(500) NOT NULL,
    caption TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (volunteer_activity_id) REFERENCES volunteer_activities(id) ON DELETE CASCADE,
    INDEX idx_activity (volunteer_activity_id)
);

-- Activity aids (what aids were given in each activity)
CREATE TABLE activity_aids (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    volunteer_activity_id BIGINT UNSIGNED NOT NULL,
    aid_type_id BIGINT UNSIGNED NOT NULL,
    quantity INT DEFAULT 1,
    nominal_amount DECIMAL(12,2) NULL, -- for cash aid
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (volunteer_activity_id) REFERENCES volunteer_activities(id) ON DELETE CASCADE,
    FOREIGN KEY (aid_type_id) REFERENCES aid_types(id) ON DELETE CASCADE,
    INDEX idx_activity (volunteer_activity_id),
    INDEX idx_aid_type (aid_type_id)
);

SET FOREIGN_KEY_CHECKS = 1;

-- Sample data for administrative regions
INSERT INTO administrative_regions (parent_id, code, name, level) VALUES
(NULL, '3201', 'Kabupaten Bogor', 'kabupaten'),
(NULL, '3202', 'Kabupaten Sukabumi', 'kabupaten'),
(1, '320101', 'Kecamatan Nanggung', 'kecamatan'),
(1, '320102', 'Kecamatan Leuwiliang', 'kecamatan'),
(2, '320201', 'Kecamatan Sukabumi', 'kecamatan'),
(3, '32010101', 'Desa Nanggung', 'desa'),
(3, '32010102', 'Desa Curugbitung', 'desa'),
(4, '32010201', 'Desa Leuwiliang', 'desa'),
(5, '32020101', 'Desa Sukabumi Selatan', 'desa');

-- Sample data for aid types
INSERT INTO aid_types (name, description, has_nominal, unit, is_active) VALUES
('Kalender', 'Kalender tahun 2024', FALSE, 'pcs', TRUE),
('Baju', 'Pakaian bekas layak pakai', FALSE, 'pcs', TRUE),
('Beras', 'Beras premium kualitas baik', FALSE, 'kg', TRUE),
('Uang Tunai', 'Bantuan uang tunai', TRUE, 'rupiah', TRUE),
('Minyak Goreng', 'Minyak goreng kemasan 1 liter', FALSE, 'liter', TRUE);

-- Sample data for users (web dashboard)
INSERT INTO users (name, email, password, created_at, updated_at) VALUES
('Administrator', 'admin@relawancare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Sample data for aid sessions
INSERT INTO aid_sessions (name, description, start_date, end_date, is_active) VALUES
('Sesi Bantuan 1 - Januari 2024', 'Distribusi bantuan periode Januari 2024', '2024-01-01', '2024-01-31', TRUE),
('Sesi Bantuan 2 - Februari 2024', 'Distribusi bantuan periode Februari 2024', '2024-02-01', '2024-02-29', TRUE);

-- Sample data for aid session items
INSERT INTO aid_session_items (aid_session_id, aid_type_id, quantity_available, nominal_amount) VALUES
(1, 1, 1000, NULL), -- Kalender
(1, 2, 500, NULL),  -- Baju
(1, 3, 2000, NULL), -- Beras
(1, 4, NULL, 500000.00), -- Uang Tunai
(2, 3, 1500, NULL), -- Beras
(2, 4, NULL, 750000.00), -- Uang Tunai
(2, 5, 800, NULL);  -- Minyak Goreng

-- Sample data for volunteers
INSERT INTO volunteers (volunteer_code, name, phone, password, kabupaten_id, kecamatan_id, desa_id, address, is_active) VALUES
('REL001', 'Ahmad Santoso', '08123456789', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 3, 6, 'Jl. Raya Nanggung No. 123', TRUE),
('REL002', 'Siti Nurhaliza', '08198765432', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 4, 8, 'Jl. Leuwiliang Raya No. 456', TRUE);

-- Sample data for beneficiaries
INSERT INTO beneficiaries (family_card_number, national_id, name, phone, address, rt, rw, kabupaten_id, kecamatan_id, desa_id, age, gender, is_active) VALUES
('3201012345678901', '3201011234567890', 'Budi Hartono', '081234567890', 'Jl. Mawar No. 10', '001', '005', 1, 3, 6, 45, 'male', TRUE),
('3201012345678902', '3201011234567891', 'Sari Dewi', '081234567891', 'Jl. Melati No. 15', '002', '005', 1, 3, 6, 38, 'female', TRUE),
('3201012345678903', '3201011234567892', 'Joni Iskandar', '081234567892', 'Jl. Kenanga No. 20', '003', '006', 1, 4, 8, 52, 'male', TRUE);