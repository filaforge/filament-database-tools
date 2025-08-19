# 🚀 Detailed Installation Guide

This guide provides step-by-step instructions for installing and setting up the Filaforge Database Tools plugin in your Laravel/Filament project.

## 📋 Prerequisites

Before installing the plugin, ensure you have:

- **PHP**: 8.1 or higher
- **Laravel**: 12.x
- **Filament**: 4.x (Panel Builder)
- **Composer**: Latest version
- **Node.js**: 16+ (for asset building)
- **Database**: MySQL/MariaDB, PostgreSQL, SQLite, or SQL Server

### Check Your Environment

```bash
# Check PHP version
php --version

# Check Laravel version
php artisan --version

# Check Composer version
composer --version

# Check Node.js version
node --version

# Check npm version
npm --version
```

## 🔧 Installation Methods

### Method 1: Composer Installation (Recommended)

#### Step 1: Install via Composer

```bash
# Navigate to your Laravel project root
cd /path/to/your/laravel/project

# Install the plugin
composer require filaforge/database-tools
```

#### Step 2: Verify Installation

```bash
# Check if the package is installed
composer show filaforge/database-tools

# List all installed packages
composer list | grep database-tools
```

### Method 2: Manual Installation (Development/Testing)

#### Step 1: Clone or Download the Plugin

```bash
# Option A: Clone from repository
git clone https://github.com/filaforge/database-tools.git plugins/filaforge-database-tools

# Option B: Download and extract to plugins directory
# Download the plugin and extract to: plugins/filaforge-database-tools/
```

#### Step 2: Add to Composer Autoload

Add this to your project's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "plugins/filaforge-database-tools"
        }
    ]
}
```

#### Step 3: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
cd plugins/filaforge-database-tools
npm install

# Build assets
npm run build

# Return to project root
cd ../..
```

#### Step 4: Update Composer

```bash
# Update composer autoload
composer dump-autoload
```

## ⚙️ Plugin Registration

### Step 1: Locate Your Panel Provider

Find your Filament panel provider file, typically located at:
- `app/Providers/Filament/AdminPanelProvider.php` (for admin panel)
- `app/Providers/Filament/YourPanelProvider.php` (for custom panels)

### Step 2: Register the Plugin

Add the plugin to your panel provider:

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filaforge\DatabaseTools\FilaforgeDatabaseToolsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            // Add this line to register the plugin
            ->plugin(FilaforgeDatabaseToolsPlugin::make());
    }
}
```

### Step 3: Alternative Registration Methods

#### Method A: Using Plugin Class

```php
use Filaforge\DatabaseTools\FilaforgeDatabaseToolsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... other configuration
        ->plugin(FilaforgeDatabaseToolsPlugin::make());
}
```

#### Method B: Using Service Provider

```php
use Filaforge\DatabaseTools\FilaforgeDatabaseToolsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... other configuration
        ->plugin(app(FilaforgeDatabaseToolsPlugin::class));
}
```

## 🔐 Configuration

### Step 1: Publish Configuration (Optional)

```bash
# Publish the configuration file
php artisan vendor:publish --tag="database-tools-config"

# This will create: config/database-tools.php
```

### Step 2: Environment Variables

Add these to your `.env` file:

```env
# Database Tools Configuration
DATABASE_TOOLS_MAX_RESULTS=1000
DATABASE_TOOLS_DEFAULT_PAGE_SIZE=50
DATABASE_TOOLS_DEFAULT_TAB=viewer
DATABASE_TOOLS_SHOW_HELP=true
DATABASE_TOOLS_DARK_MODE=true
DATABASE_TOOLS_LOG_QUERIES=false
DATABASE_TOOLS_LOG_CHANNEL=daily
DATABASE_TOOLS_REQUIRE_AUTH=true
```

### Step 3: Customize Configuration

Edit `config/database-tools.php` to customize:

```php
<?php

return [
    'default_connection' => env('DB_CONNECTION', 'mysql'),
    'max_results' => env('DATABASE_TOOLS_MAX_RESULTS', 1000),
    'default_page_size' => env('DATABASE_TOOLS_DEFAULT_PAGE_SIZE', 50),
    'allowed_query_types' => ['SELECT', 'SHOW', 'DESCRIBE', 'EXPLAIN'],
    // ... other options
];
```

## 🎨 Asset Building

### Step 1: Install Node.js Dependencies

```bash
# Navigate to plugin directory
cd plugins/filaforge-database-tools

# Install dependencies
npm install

# Or if using yarn
yarn install
```

### Step 2: Build Assets

```bash
# Build for production
npm run build

# Build for development (with source maps)
npm run dev

# Watch for changes during development
npm run watch
```

### Step 3: Verify Asset Building

```bash
# Check if dist directory was created
ls -la resources/dist/

# Should contain:
# - database-tools.css
# - Any other compiled assets
```

## 🧪 Testing the Installation

### Step 1: Clear Caches

```bash
# Clear all Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear Filament caches
php artisan filament:cache-components
php artisan filament:cache-panels
```

### Step 2: Check Routes

```bash
# List all routes to verify plugin routes are registered
php artisan route:list | grep database
```

### Step 3: Access the Plugin

1. **Start your development server**:
   ```bash
   php artisan serve
   ```

2. **Navigate to your Filament panel**:
   ```
   http://localhost:8000/admin
   ```

3. **Look for "Database Tools" in the navigation**

4. **Click on "Database Tools" to access the plugin**

## 🔍 Troubleshooting

### Common Issues and Solutions

#### Issue 1: Plugin Not Found

```bash
# Check if the package is properly installed
composer show filaforge/database-tools

# Verify autoload files
composer dump-autoload

# Check if service provider is registered
php artisan config:show app.providers
```

#### Issue 2: Class Not Found Errors

```bash
# Clear composer autoload cache
composer clear-cache

# Regenerate autoload files
composer dump-autoload

# Check namespace in plugin files
grep -r "namespace" plugins/filaforge-database-tools/src/
```

#### Issue 3: Assets Not Loading

```bash
# Check if assets were built
ls -la plugins/filaforge-database-tools/resources/dist/

# Rebuild assets
cd plugins/filaforge-database-tools
npm run build

# Check asset registration in service provider
grep -r "FilamentAsset::register" src/
```

#### Issue 4: Database Connection Issues

```bash
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo()
>>> exit

# Check database configuration
php artisan config:show database

# Verify database permissions
mysql -u username -p -e "SHOW GRANTS;"
```

#### Issue 5: Permission Denied Errors

```bash
# Check file permissions
ls -la plugins/filaforge-database-tools/

# Fix permissions if needed
chmod -R 755 plugins/filaforge-database-tools/
chown -R www-data:www-data plugins/filaforge-database-tools/
```

## 📱 Production Deployment

### Step 1: Build Production Assets

```bash
# Build optimized assets
cd plugins/filaforge-database-tools
npm run build

# Verify production build
ls -la resources/dist/
```

### Step 2: Environment Configuration

```env
# Production settings
APP_ENV=production
APP_DEBUG=false
DATABASE_TOOLS_LOG_QUERIES=true
DATABASE_TOOLS_REQUIRE_AUTH=true
```

### Step 3: Security Considerations

1. **Database Permissions**: Ensure database user has read-only access
2. **User Authentication**: Verify only authorized users can access
3. **Query Logging**: Enable query logging for audit purposes
4. **Rate Limiting**: Consider adding rate limiting to prevent abuse

## 🔄 Updates and Maintenance

### Updating the Plugin

```bash
# If installed via Composer
composer update filaforge/database-tools

# If installed manually
cd plugins/filaforge-database-tools
git pull origin main
composer install
npm install
npm run build
```

### Checking for Updates

```bash
# Check outdated packages
composer outdated

# Check specific package
composer show filaforge/database-tools
```

## 📞 Support and Help

### Getting Help

- **Documentation**: Check this README and other plugin files
- **Issues**: Report bugs on GitHub Issues
- **Discussions**: Use GitHub Discussions for questions
- **Email**: Contact filaforger@gmail.com

### Useful Commands Reference

```bash
# Plugin management
composer show filaforge/database-tools
composer update filaforge/database-tools
composer remove filaforge/database-tools

# Asset building
npm run build
npm run dev
npm run watch

# Laravel commands
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan filament:cache-components

# Database testing
php artisan tinker
php artisan migrate:status
```

## ✅ Installation Checklist

- [ ] Prerequisites met (PHP 8.1+, Laravel 12+, Filament 4+)
- [ ] Plugin installed via Composer or manually
- [ ] Dependencies installed (composer install, npm install)
- [ ] Assets built (npm run build)
- [ ] Plugin registered in panel provider
- [ ] Configuration published (optional)
- [ ] Environment variables set
- [ ] Caches cleared
- [ ] Plugin accessible in Filament panel
- [ ] Database connection working
- [ ] Tables visible in viewer mode
- [ ] Queries executing in query mode

## 🎯 Next Steps

After successful installation:

1. **Explore the Interface**: Try both viewer and query modes
2. **Test Database Access**: Verify you can see your tables and data
3. **Customize Configuration**: Adjust settings in `config/database-tools.php`
4. **Set Up Security**: Configure user permissions and access control
5. **Monitor Usage**: Enable query logging for production use

---

**🎉 Congratulations!** You've successfully installed the Filaforge Database Tools plugin. If you encounter any issues, refer to the troubleshooting section or contact support.
