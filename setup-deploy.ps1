# PowerShell Deployment Setup Script
Write-Host "Preparing your Laravel app for deployment..." -ForegroundColor Cyan

# 1. Create SQLite database if it doesn't exist
if (-not (Test-Path "database/database.sqlite")) {
    Write-Host "Creating SQLite database..." -ForegroundColor Yellow
    New-Item -ItemType File -Path "database/database.sqlite" -Force | Out-Null
}

# 2. Make sure storage directories exist
Write-Host "Creating storage directories..." -ForegroundColor Yellow
$directories = @(
    "storage/app/public",
    "storage/framework/cache/data",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/logs",
    "bootstrap/cache"
)

foreach ($dir in $directories) {
    if (-not (Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
    }
}

# 3. Clear caches
Write-Host "Clearing caches..." -ForegroundColor Yellow
$phpPath = "C:\laragon\bin\php\php-8.3.26-Win32-vs16-x64\php.exe"
if (Test-Path $phpPath) {
    & $phpPath artisan config:clear
    & $phpPath artisan cache:clear
    & $phpPath artisan view:clear
} else {
    Write-Host "PHP not found at $phpPath - skipping cache clear" -ForegroundColor Yellow
}

# 4. Run migrations
Write-Host "Running migrations..." -ForegroundColor Yellow
if (Test-Path $phpPath) {
    & $phpPath artisan migrate --force
} else {
    Write-Host "PHP not found - skipping migrations" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Setup complete! Your app is ready for deployment." -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Cyan
Write-Host "1. Commit your changes:" -ForegroundColor White
Write-Host "   git add ." -ForegroundColor Gray
Write-Host "   git commit -m Ready for deployment" -ForegroundColor Gray
Write-Host "   git push origin main" -ForegroundColor Gray
Write-Host ""
Write-Host "2. Choose a platform:" -ForegroundColor White
Write-Host "   - Railway.app (Easiest)" -ForegroundColor Green
Write-Host "   - Render.com" -ForegroundColor Yellow
Write-Host "   - Heroku.com" -ForegroundColor Magenta
Write-Host ""
Write-Host "3. Follow the guide in DEPLOYMENT.md" -ForegroundColor White
Write-Host ""
Write-Host "Need help? Read DEPLOYMENT.md for detailed instructions!" -ForegroundColor Cyan
