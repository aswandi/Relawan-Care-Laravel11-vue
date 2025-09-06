@echo off
echo ========================================
echo Flutter Installation Check
echo ========================================

echo.
echo Step 1: Checking if Flutter is in PATH...

where flutter >nul 2>&1
if %errorlevel% equ 0 (
    echo ✓ Flutter found in PATH
    flutter --version
) else (
    echo ✗ Flutter NOT found in PATH
    echo Running temporary environment setup...
    call flutter-env.bat
    where flutter >nul 2>&1
    if %errorlevel% equ 0 (
        echo ✓ Flutter now available (temporary session)
        flutter --version
    ) else (
        echo ✗ Flutter still not found. Please check installation.
    )
)

echo.
echo Step 2: Running Flutter Doctor...
flutter doctor

echo.
echo Step 3: Checking Flutter configuration...
flutter config --list

echo.
echo ========================================
echo Check Complete!
echo ========================================
pause