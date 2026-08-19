@echo off
echo ============================================
echo   20Mefree Super APP - Update
echo ============================================

echo.
echo [1/5] Menarik update terbaru dari GitHub...
git pull origin claude/magical-newton-bi2m41
if errorlevel 1 goto :error

echo.
echo [2/5] Update dependency PHP (composer)...
call composer install --no-interaction
if errorlevel 1 goto :error

echo.
echo [3/5] Update dependency JS (npm)...
call npm install
if errorlevel 1 goto :error

echo.
echo [4/5] Menjalankan migration database (aman, tidak menghapus data)...
call php artisan migrate --force
if errorlevel 1 goto :error

echo.
echo [5/5] Compile ulang tampilan (Tailwind CSS)...
call npm run build
if errorlevel 1 goto :error

echo.
echo ============================================
echo   Update selesai! Jalankan start.bat untuk membuka aplikasi.
echo ============================================
pause
exit /b 0

:error
echo.
echo ============================================
echo   TERJADI ERROR - lihat pesan di atas.
echo ============================================
pause
exit /b 1
