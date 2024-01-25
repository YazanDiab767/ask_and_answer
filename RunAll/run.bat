@echo off

echo Closing Visual Studio Code...
taskkill /F /IM Code.exe >nul 2>&1

echo Starting Android emulator...
cd /d C:\Users\EASY LIFE\AppData\Local\Android\Sdk\tools
start cmd /T /k emulator -avd Pixel_7_Pro_API_34

echo Waiting for Emulator to start...
timeout /nobreak /t 8 >nul

cd /d D:\laragon\www\ask_and_answer
echo Starting Laravel WebSocket server...
start cmd /T /k php artisan websocket:serve

echo Waiting for Laravel WebSocket server to start...
timeout /nobreak /t 5 >nul

echo Starting Visual Studio Code...
cd /d Y:\dev\projects\Campus_Link\CampusLink
start code .

echo Waiting for Visual Studio Code to start...
timeout /nobreak /t 5 >nul

echo Starting Flutter application...
start cmd /T /k flutter run

echo Waiting for Flutter to start...
timeout /nobreak /t 5 >nul