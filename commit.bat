@echo off
REM Script untuk commit dan push otomatis (Windows)
REM Usage: commit.bat "pesan commit"

echo 🚀 JasaLaundry Git Helper
echo ==================================

if "%~1"=="" (
    echo ❌ Error: Pesan commit diperlukan
    echo Usage: commit.bat "pesan commit"
    pause
    exit /b 1
)

set COMMIT_MESSAGE=%~1

echo 📝 Checking git status...
git status

echo.
echo 📦 Adding all changes...
git add .

echo.
echo 💾 Committing with message: "%COMMIT_MESSAGE%"
git commit -m "%COMMIT_MESSAGE%"

if %errorlevel% equ 0 (
    echo ✅ Commit berhasil!
    
    echo.
    echo 🌐 Pushing to GitHub...
    git push origin main
    
    if %errorlevel% equ 0 (
        echo 🎉 Push berhasil! Perubahan sudah di GitHub.
        echo.
        echo 🔗 Repository: https://github.com/Novandrya1/jasalaundry-system
    ) else (
        echo ❌ Push gagal. Cek koneksi atau credentials.
    )
) else (
    echo ❌ Commit gagal. Tidak ada perubahan atau ada error.
)

echo.
echo 📊 Git log terakhir:
git log --oneline -3

pause