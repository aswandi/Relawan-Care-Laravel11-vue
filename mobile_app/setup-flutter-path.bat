@echo off
echo ========================================
echo Flutter PATH Setup for Windows
echo ========================================

echo.
echo Step 1: Adding Flutter to System PATH...

:: Add Flutter to PATH permanently
setx PATH "%PATH%;C:\flutter\bin" /M

echo ✓ Flutter path added to system environment

echo.
echo Step 2: Setting up Android SDK path (if needed)...

:: Check if ANDROID_HOME exists
if defined ANDROID_HOME (
    echo ✓ ANDROID_HOME already set: %ANDROID_HOME%
) else (
    echo Setting ANDROID_HOME to default location...
    setx ANDROID_HOME "%USERPROFILE%\AppData\Local\Android\Sdk" /M
    setx PATH "%PATH%;%USERPROFILE%\AppData\Local\Android\Sdk\platform-tools" /M
)

echo.
echo Step 3: Creating flutter-env.bat for current session...

:: Create temporary batch file for current session
echo @echo off > flutter-env.bat
echo set PATH=%%PATH%%;C:\flutter\bin >> flutter-env.bat
echo set ANDROID_HOME=%%USERPROFILE%%\AppData\Local\Android\Sdk >> flutter-env.bat
echo set PATH=%%PATH%%;%%ANDROID_HOME%%\platform-tools >> flutter-env.bat
echo echo Flutter environment configured for this session >> flutter-env.bat

echo.
echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo IMPORTANT: 
echo 1. Close this Command Prompt window
echo 2. Open a NEW Command Prompt window
echo 3. Run: flutter --version
echo.
echo For current session only, run: flutter-env.bat
echo.
pause