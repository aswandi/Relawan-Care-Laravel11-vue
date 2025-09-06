#!/bin/bash

echo "===================================="
echo "Building RelawanCare Mobile APK"
echo "===================================="

echo ""
echo "Step 1: Cleaning previous builds..."
flutter clean

echo ""
echo "Step 2: Getting dependencies..."
flutter pub get

echo ""
echo "Step 3: Building release APK..."
flutter build apk --release --split-per-abi

echo ""
echo "===================================="
echo "Build Complete!"
echo "===================================="
echo ""
echo "APK files can be found in:"
echo "build/app/outputs/flutter-apk/"
echo ""

if [ -f "build/app/outputs/flutter-apk/app-armeabi-v7a-release.apk" ]; then
    echo "✓ ARM 32-bit APK: app-armeabi-v7a-release.apk"
fi

if [ -f "build/app/outputs/flutter-apk/app-arm64-v8a-release.apk" ]; then
    echo "✓ ARM 64-bit APK: app-arm64-v8a-release.apk"
fi

if [ -f "build/app/outputs/flutter-apk/app-x86_64-release.apk" ]; then
    echo "✓ x86 64-bit APK: app-x86_64-release.apk"
fi

echo ""
echo "To install on device: adb install build/app/outputs/flutter-apk/app-arm64-v8a-release.apk"
echo ""