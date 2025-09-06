# RelawanCare Mobile App

Aplikasi mobile Flutter untuk sistem monitoring relawan RelawanCare.

## Fitur Utama

### 🔐 Autentikasi
- Login dengan nomor HP dan password
- Sistem autentikasi berbasis token
- Auto-login untuk pengguna yang sudah login

### 📊 Dashboard
- Statistik aktivitas relawan
- 5 aktivitas terakhir
- Aksi cepat untuk menambah aktivitas baru
- Animasi dan transisi yang menarik

### ➕ Tambah Aktivitas Baru
- **Langkah 1**: Pencarian penerima bantuan berdasarkan NIK
- **Langkah 2**: Pemilihan jenis bantuan dan jumlah
- **Langkah 3**: Dokumentasi foto (minimal 1, maksimal 5)
- **Langkah 4**: Verifikasi lokasi GPS dengan akurasi tinggi
- **Langkah 5**: Review dan simpan data

### 🔍 Pencarian NIK
- Pencarian real-time berdasarkan NIK 16 digit
- Validasi data penerima bantuan
- Tampilan informasi lengkap penerima

### 📷 Dokumentasi Foto
- Ambil foto dari kamera atau galeri
- Preview foto sebelum dihapus
- Kompres foto otomatis untuk efisiensi
- Grid layout yang responsif

### 📍 GPS & Lokasi
- Tracking GPS dengan akurasi tinggi
- Geocoding untuk mendapatkan alamat
- Indikator akurasi lokasi
- Update lokasi manual

## Teknologi

- **Framework**: Flutter 3.x
- **State Management**: Provider
- **HTTP Client**: Dio & HTTP
- **Image Handling**: image_picker, camera
- **Location**: geolocator, geocoding
- **Permissions**: permission_handler
- **Animations**: flutter_animate
- **Storage**: shared_preferences

## Struktur Project

```
lib/
├── main.dart                 # Entry point aplikasi
├── models/                   # Data models
│   ├── volunteer.dart
│   ├── beneficiary.dart
│   └── volunteer_activity.dart
├── screens/                  # Layar utama aplikasi
│   ├── login_screen.dart
│   ├── dashboard_screen.dart
│   └── add_activity_screen.dart
├── services/                 # Service layer untuk API
│   ├── auth_service.dart
│   └── activity_service.dart
├── widgets/                  # Custom widgets
│   ├── stats_card.dart
│   ├── activity_card.dart
│   ├── beneficiary_search_widget.dart
│   ├── aid_selector_widget.dart
│   ├── photo_picker_widget.dart
│   └── location_widget.dart
└── utils/
    └── app_theme.dart        # Theme dan styling
```

## Instalasi & Development

### Prerequisites
- Flutter SDK 3.x
- Android Studio / VS Code
- Android SDK untuk development
- Device dengan GPS dan kamera

### Setup
1. Clone repository
2. Install dependencies:
   ```bash
   flutter pub get
   ```
3. Jalankan aplikasi:
   ```bash
   flutter run
   ```

### Build APK
```bash
flutter build apk --release
```

## Konfigurasi API

Pastikan Laravel backend berjalan di `http://localhost:8001` atau sesuaikan base URL di:
- `lib/services/auth_service.dart`
- `lib/services/activity_service.dart`

## Permissions

Aplikasi memerlukan permission berikut:
- **Camera**: Untuk mengambil foto dokumentasi
- **Storage**: Untuk menyimpan dan mengakses foto
- **Location**: Untuk tracking GPS aktivitas
- **Internet**: Untuk sinkronisasi data dengan server

## UI/UX Design

### Color Scheme
- **Primary**: `#667eea` (Biru)
- **Secondary**: `#764ba2` (Ungu)
- **Accent**: `#48bb78` (Hijau)
- **Warning**: `#ed8936` (Orange)
- **Danger**: `#e53e3e` (Merah)

### Typography
- **Font Family**: Inter
- **Heading**: Bold (700)
- **Body**: Medium (500) & Regular (400)

### Animations
- Fade transitions antar screen
- Slide animations untuk form steps
- Bounce effects untuk buttons
- Pulse animations untuk GPS indicator
- Scale animations untuk cards

## Data Flow

1. **Login**: Volunteer login dengan HP + password
2. **Dashboard**: Tampil aktivitas terbaru dan statistik
3. **Add Activity**: 
   - Search beneficiary by NIK
   - Select aid types and quantities
   - Capture photos (1-5)
   - Get GPS location
   - Review and submit
4. **Sync**: Data tersimpan ke Laravel backend
5. **Offline**: Basic offline support dengan local storage

## Security Features

- Token-based authentication
- Input validation dan sanitization
- Permission handling
- Secure HTTP requests
- Photo compression untuk efisiensi

## Performance Optimizations

- Lazy loading untuk lists
- Image compression otomatis
- Efficient state management
- Memory leak prevention
- Smooth animations dengan 60fps

## Future Enhancements

- [ ] Offline mode dengan SQLite
- [ ] Push notifications
- [ ] Barcode scanner untuk NIK
- [ ] Map integration
- [ ] Photo annotation
- [ ] Data export features
- [ ] Multi-language support

## Support & Maintenance

Untuk bug reports dan feature requests, hubungi tim development atau buat issue di repository.

## License

Copyright © 2025 RelawanCare. All rights reserved.