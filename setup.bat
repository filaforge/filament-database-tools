@echo off
REM Filaforge Database Tools Setup Script for Windows
REM This script automates the installation and setup process

echo 🚀 Filaforge Database Tools Setup Script
echo ========================================

REM Check if we're in the right directory
if not exist "composer.json" (
    echo [ERROR] This script must be run from the plugin root directory
    pause
    exit /b 1
)

if not exist "src\FilaforgeDatabaseToolsServiceProvider.php" (
    echo [ERROR] This script must be run from the plugin root directory
    pause
    exit /b 1
)

echo [INFO] Starting setup process...

REM Step 1: Check prerequisites
echo [INFO] Checking prerequisites...

REM Check PHP
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] PHP is not installed or not in PATH
    pause
    exit /b 1
)

for /f "tokens=2" %%i in ('php --version 2^>^&1 ^| findstr "PHP"') do set PHP_VERSION=%%i
echo [SUCCESS] PHP version: %PHP_VERSION% ✓

REM Check Composer
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Composer is not installed or not in PATH
    pause
    exit /b 1
)

echo [SUCCESS] Composer found ✓

REM Check Node.js
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [WARNING] Node.js not found. Asset building will be skipped.
    set NODE_AVAILABLE=false
) else (
    for /f %%i in ('node --version') do set NODE_VERSION=%%i
    echo [SUCCESS] Node.js version: %NODE_VERSION% ✓
    set NODE_AVAILABLE=true
)

REM Check npm
if "%NODE_AVAILABLE%"=="true" (
    npm --version >nul 2>&1
    if %errorlevel% neq 0 (
        echo [WARNING] npm not found. Asset building will be skipped.
        set NODE_AVAILABLE=false
    )
)

REM Step 2: Install PHP dependencies
echo [INFO] Installing PHP dependencies...
composer install --no-dev --optimize-autoloader

if %errorlevel% equ 0 (
    echo [SUCCESS] PHP dependencies installed ✓
) else (
    echo [ERROR] Failed to install PHP dependencies
    pause
    exit /b 1
)

REM Step 3: Install Node.js dependencies and build assets
if "%NODE_AVAILABLE%"=="true" (
    echo [INFO] Installing Node.js dependencies...
    npm install --silent
    
    if %errorlevel% equ 0 (
        echo [SUCCESS] Node.js dependencies installed ✓
        
        echo [INFO] Building assets...
        npm run build --silent
        
        if %errorlevel% equ 0 (
            echo [SUCCESS] Assets built successfully ✓
        ) else (
            echo [WARNING] Asset building failed, but plugin will still work
        )
    ) else (
        echo [WARNING] Failed to install Node.js dependencies, but plugin will still work
    )
) else (
    echo [WARNING] Skipping Node.js setup - plugin will work without custom styling
)

REM Step 4: Create dist directory if it doesn't exist
if not exist "resources\dist" (
    echo [INFO] Creating dist directory...
    mkdir "resources\dist"
    echo [SUCCESS] Dist directory created ✓
)

REM Step 5: Copy CSS to dist if it exists
if exist "resources\css\database-tools.css" (
    if not exist "resources\dist\database-tools.css" (
        echo [INFO] Copying CSS to dist directory...
        copy "resources\css\database-tools.css" "resources\dist\"
        echo [SUCCESS] CSS copied to dist directory ✓
    )
)

REM Step 6: Generate setup summary
echo [INFO] Generating setup summary...

echo # Setup Summary > SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo ## Installation Completed Successfully >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo **Date:** %date% %time% >> SETUP_SUMMARY.md
echo **Plugin Version:** 1.0.0 >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo ## What Was Installed >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo - ✅ PHP dependencies via Composer >> SETUP_SUMMARY.md
echo - ✅ Node.js dependencies (if available) >> SETUP_SUMMARY.md
echo - ✅ Assets built (if Node.js available) >> SETUP_SUMMARY.md
echo - ✅ Directory structure verified >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo ## Next Steps >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo 1. **Register the plugin** in your Filament panel provider: >> SETUP_SUMMARY.md
echo    ```php >> SETUP_SUMMARY.md
echo    use Filaforge\DatabaseTools\FilaforgeDatabaseToolsPlugin; >> SETUP_SUMMARY.md
echo    >> SETUP_SUMMARY.md
echo    public function panel(Panel $panel): Panel >> SETUP_SUMMARY.md
echo    { >> SETUP_SUMMARY.md
echo        return $panel >> SETUP_SUMMARY.md
echo            ->plugin(FilaforgeDatabaseToolsPlugin::make()); >> SETUP_SUMMARY.md
echo    } >> SETUP_SUMMARY.md
echo    ``` >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo 2. **Clear Laravel caches**: >> SETUP_SUMMARY.md
echo    ```bash >> SETUP_SUMMARY.md
echo    php artisan cache:clear >> SETUP_SUMMARY.md
echo    php artisan config:clear >> SETUP_SUMMARY.md
echo    php artisan view:clear >> SETUP_SUMMARY.md
echo    ``` >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo 3. **Access the plugin** in your Filament panel >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo ## Configuration >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo - Configuration file: `config/database-tools.php` >> SETUP_SUMMARY.md
echo - Environment variables available in `.env` >> SETUP_SUMMARY.md
echo - See INSTALLATION.md for detailed configuration options >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo ## Support >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo - Documentation: README.md >> SETUP_SUMMARY.md
echo - Installation Guide: INSTALLATION.md >> SETUP_SUMMARY.md
echo - Issues: GitHub Issues >> SETUP_SUMMARY.md
echo - Email: filaforger@gmail.com >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo --- >> SETUP_SUMMARY.md
echo. >> SETUP_SUMMARY.md
echo *Generated automatically by setup script* >> SETUP_SUMMARY.md

echo [SUCCESS] Setup summary generated ✓

REM Step 7: Final status
echo.
echo 🎉 Setup completed successfully!
echo ================================
echo.
echo Next steps:
echo 1. Register the plugin in your Filament panel provider
echo 2. Clear Laravel caches
echo 3. Access the plugin in your panel
echo.
echo For detailed instructions, see:
echo - INSTALLATION.md (comprehensive guide)
echo - README.md (quick reference)
echo - SETUP_SUMMARY.md (this setup summary)
echo.
echo Need help? Contact: filaforger@gmail.com
echo.

if exist "SETUP_SUMMARY.md" (
    echo [INFO] Setup summary saved to SETUP_SUMMARY.md
)

pause
