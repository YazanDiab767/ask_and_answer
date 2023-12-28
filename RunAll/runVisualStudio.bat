@echo off

echo Closing Visual Studio Code...
taskkill /F /IM Code.exe >nul 2>&1

echo Waiting for Visual Studio to start...
timeout /nobreak /t 8 >nul

echo Starting Visual Studio Code...
cd /d Y:\dev\projects\Campus_Link\CampusLink
start code .
