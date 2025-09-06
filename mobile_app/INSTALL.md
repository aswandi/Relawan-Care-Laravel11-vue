# RelawanCare Mobile - Installation Guide

## 📱 Build APK Instructions

### Prerequisites
1. **Flutter SDK** (3.x atau lebih baru)
2. **Android SDK** dengan API level 21+ 
3. **Java JDK** 8 atau 11
4. **Git** untuk version control

### Quick Build (Recommended)

#### Windows:
```bash
# Double-click atau jalankan dari Command Prompt
build-apk.bat
```

#### Linux/macOS:
```bash
# Jalankan script build
./build-apk.sh
```

### Manual Build Steps

1. **Setup Environment**
   ```bash
   # Pastikan Flutter sudah terinstall
   flutter doctor
   
   # Masuk ke direktori project
   cd mobile_app
   ```

2. **Clean & Get Dependencies**
   ```bash
   flutter clean
   flutter pub get
   ```

3. **Build APK**
   ```bash
   # Build untuk semua architecture (Recommended)
   flutter build apk --release --split-per-abi
   
   # Atau build universal APK (file lebih besar)
   flutter build apk --release
   ```

## 📦 Output Files

Setelah build berhasil, APK files akan tersedia di:
```
build/app/outputs/flutter-apk/
├── app-armeabi-v7a-release.apk    (32-bit ARM - untuk device lama)
├── app-arm64-v8a-release.apk      (64-bit ARM - untuk device modern)
└── app-x86_64-release.apk         (x86 64-bit - untuk emulator/tablet x86)
```

## 🔧 Installation Options

### Option 1: Install via ADB (Recommended)
```bash
# Install ke device yang terhubung
adb install build/app/outputs/flutter-apk/app-arm64-v8a-release.apk

# Untuk device 32-bit ARM
adb install build/app/outputs/flutter-apk/app-armeabi-v7a-release.apk
```

### Option 2: Manual Install
1. Copy file APK ke device Android
2. Enable "Install from Unknown Sources" di Settings
3. Tap file APK dan install

### Option 3: Deploy via Firebase App Distribution
```bash
# Install Firebase CLI tools
npm install -g firebase-tools

# Login to Firebase
firebase login

# Deploy ke App Distribution
firebase appdistribution:distribute build/app/outputs/flutter-apk/app-arm64-v8a-release.apk \
    --app YOUR_FIREBASE_APP_ID \
    --groups testers
```

## 🛠️ Development Setup

### Setup Flutter
```bash
# Download Flutter SDK
git clone https://github.com/flutter/flutter.git -b stable

# Add Flutter to PATH
export PATH="$PATH:`pwd`/flutter/bin"

# Install dependencies
flutter doctor
```

### Setup Android SDK
1. Install Android Studio
2. Open Android Studio → SDK Manager
3. Install Android SDK (API level 21+)
4. Setup Android Virtual Device (AVD) untuk testing

### VS Code Extensions (Optional)
- Flutter
- Dart
- Android iOS Emulator

## 🧪 Testing

### Run on Emulator
```bash
# Start Android emulator
flutter emulators --launch android

# Run app in debug mode
flutter run
```

### Run on Physical Device
```bash
# Enable USB Debugging on device
# Connect via USB
adb devices

# Run app
flutter run
```

### Run Tests
```bash
# Unit tests
flutter test

# Integration tests
flutter drive --target=test_driver/app.dart
```

## 📋 Build Configurations

### Debug Build (Development)
```bash
flutter build apk --debug
```

### Profile Build (Performance Testing)
```bash
flutter build apk --profile
```

### Release Build (Production)
```bash
flutter build apk --release --split-per-abi
```

### Build with Specific Target
```bash
# Only ARM64 (most modern devices)
flutter build apk --release --target-platform android-arm64

# Only ARM32 (older devices)  
flutter build apk --release --target-platform android-arm
```

## 🔐 Code Signing

### Generate Keystore (Production)
```bash
keytool -genkey -v -keystore relawancare-keystore.jks \
    -keyalg RSA -keysize 2048 -validity 10000 \
    -alias relawancare
```

### Configure Signing (android/app/build.gradle)
```gradle
signingConfigs {
    release {
        keyAlias 'relawancare'
        keyPassword 'your-password'
        storeFile file('relawancare-keystore.jks')
        storePassword 'your-password'
    }
}
```

## 🚀 Deployment Checklist

- [ ] Update version in `pubspec.yaml`
- [ ] Test on physical device
- [ ] Verify all permissions work
- [ ] Test camera functionality
- [ ] Test GPS/location services
- [ ] Verify API connectivity
- [ ] Test offline functionality
- [ ] Check app performance
- [ ] Validate UI on different screen sizes
- [ ] Test install/uninstall process

## 🐛 Troubleshooting

### Common Issues

**Flutter not found:**
```bash
export PATH="$PATH:/path/to/flutter/bin"
```

**Android SDK not found:**
```bash
export ANDROID_HOME=/path/to/android-sdk
```

**Gradle build failed:**
```bash
cd android
./gradlew clean
cd ..
flutter clean
flutter pub get
```

**Permission denied (Linux/macOS):**
```bash
chmod +x build-apk.sh
```

### Build Errors
- Ensure Flutter and Android SDK are properly installed
- Check `flutter doctor` for any issues
- Clear build cache with `flutter clean`
- Restart Android Studio/VS Code

### Runtime Issues
- Check device logs: `adb logcat`
- Verify app permissions in device settings
- Ensure GPS is enabled for location features
- Check internet connectivity for API calls

## 📱 Device Compatibility

**Minimum Requirements:**
- Android 5.0 (API level 21)
- 2GB RAM
- 100MB storage space
- Camera (for photo capture)
- GPS (for location tracking)
- Internet connection

**Recommended:**
- Android 8.0+ (API level 26+)
- 4GB RAM
- ARM64 processor
- Fast internet connection

## 📞 Support

Untuk bantuan teknis atau bug reports:
1. Check existing issues di repository
2. Buat issue baru dengan detail:
   - Device model dan Android version
   - Steps to reproduce
   - Error messages/screenshots
   - Expected vs actual behavior

---
**RelawanCare Mobile v1.0.0**  
© 2025 RelawanCare. All rights reserved.