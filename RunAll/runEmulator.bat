@echo off

echo Starting Android emulator...
cd /d C:\Users\EASY LIFE\AppData\Local\Android\Sdk\tools
start cmd /T /k emulator -avd Pixel_7_Pro_API_33

echo Waiting for Emulator to start...
timeout /nobreak /t 15 >nul

echo Starting Flutter application...
start cmd /T /k flutter run

echo Waiting for Flutter to start...
timeout /nobreak /t 5 >nul