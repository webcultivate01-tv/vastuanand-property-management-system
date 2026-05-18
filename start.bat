@echo off
REM ─────────────────────────────────────────────
REM  VASTU ANAND — ONE-CLICK LAUNCHER
REM  Starts the PHP dev server and opens the site
REM ─────────────────────────────────────────────
title Vastu Anand · Local Server
color 0E
cd /d "%~dp0"

echo.
echo  ============================================================
echo    VASTU ANAND  -  Luxury Real Estate Mumbai
echo    Local development server
echo  ============================================================
echo.

REM ── Find PHP ────────────────────────────────────────────────
set "PHP_BIN="
where php >nul 2>nul && set "PHP_BIN=php"
if "%PHP_BIN%"=="" if exist "C:\xampp\php\php.exe"  set "PHP_BIN=C:\xampp\php\php.exe"
if "%PHP_BIN%"=="" if exist "C:\laragon\bin\php\php.exe" set "PHP_BIN=C:\laragon\bin\php\php.exe"
if "%PHP_BIN%"=="" if exist "C:\wamp64\bin\php\php8.0.30\php.exe" set "PHP_BIN=C:\wamp64\bin\php\php8.0.30\php.exe"
if "%PHP_BIN%"=="" if exist "C:\php\php.exe"        set "PHP_BIN=C:\php\php.exe"

if "%PHP_BIN%"=="" (
    echo  [ERROR] PHP not found. Install XAMPP or add PHP to your PATH.
    echo  Download: https://www.apachefriends.org/  or  https://windows.php.net/download/
    pause
    exit /b 1
)
echo  [OK] PHP : %PHP_BIN%

REM ── Ensure .env exists ──────────────────────────────────────
if not exist ".env" (
    if exist ".env.example" (
        copy /Y ".env.example" ".env" >nul
        echo  [OK] Created .env from .env.example
    )
)

REM ── Free port 8000 if a previous run is still alive ─────────
for /f "tokens=5" %%a in ('netstat -ano ^| findstr ":8000.*LISTENING"') do (
    echo  [..] Stopping previous server on :8000 (PID %%a)
    taskkill /F /PID %%a >nul 2>nul
)

REM ── Launch ──────────────────────────────────────────────────
echo  [OK] Starting server on http://localhost:8000
echo  [OK] Admin: http://localhost:8000/admin/login
echo.
echo  Press CTRL+C in this window to stop the server.
echo.

start "" "http://localhost:8000"
"%PHP_BIN%" -S localhost:8000 -t public
