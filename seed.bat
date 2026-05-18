@echo off
REM Seed MongoDB with real Vastu Anand business data
title Vastu Anand · Seed
cd /d "%~dp0"

set "PHP_BIN="
where php >nul 2>nul && set "PHP_BIN=php"
if "%PHP_BIN%"=="" if exist "C:\xampp\php\php.exe" set "PHP_BIN=C:\xampp\php\php.exe"
if "%PHP_BIN%"=="" if exist "C:\laragon\bin\php\php.exe" set "PHP_BIN=C:\laragon\bin\php\php.exe"
if "%PHP_BIN%"=="" if exist "C:\php\php.exe" set "PHP_BIN=C:\php\php.exe"

if "%PHP_BIN%"=="" (echo PHP not found & pause & exit /b 1)

"%PHP_BIN%" database\seed.php
pause
