@echo off
echo ========================================
echo Complete Flutter Setup Guide
echo ========================================

echo.
echo STEP 1: Manual PATH Setup (Permanent)
echo ========================================
echo 1. Press Win + R, type: sysdm.cpl
echo 2. Click "Environment Variables"
echo 3. Under "System Variables", find "Path"
echo 4. Click "Edit" then "New"
echo 5. Add: C:\flutter\bin
echo 6. Click OK to save
echo.
echo OR run as Administrator: setup-flutter-path.bat

echo.
echo STEP 2: Current Session Setup (Temporary)
echo ========================================
echo For this Command Prompt session only:
echo Run: flutter-env.bat
echo.

echo.
echo STEP 3: Verify Installation
echo ========================================
echo Run: check-flutter.bat
echo.

echo.
echo STEP 4: Build APK
echo ========================================
echo After Flutter is working:
echo cd mobile_app
echo build-apk.bat
echo.

echo.
echo ========================================
echo Quick Commands Reference:
echo ========================================
echo flutter --version          (Check Flutter version)
echo flutter doctor             (Check setup issues)
echo flutter pub get            (Get dependencies)
echo flutter build apk --release   (Build release APK)
echo flutter run                (Run on connected device)
echo.

echo ========================================
echo Available Scripts:
echo ========================================
echo setup-flutter-path.bat     (Add to PATH permanently - Run as Admin)
echo flutter-env.bat           (Setup for current session)
echo check-flutter.bat         (Verify installation)
echo build-apk.bat             (Build APK files)
echo.

pause