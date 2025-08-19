🚀 Installation Methods
Method 1: Quick Install (Recommended)

# Install via Composer
composer require filaforge/database-tools

# Register in your panel provider
->plugin(FilaforgeDatabaseToolsPlugin::make())

--------------------------

Method 2: Automated Setup

# Navigate to plugin directory
cd plugins_publish/filaforge-database-tools

# Run automated setup
./setup.sh                    # Linux/Mac
setup.bat                     # Windows


--------------------------

Method 3: Manual Installation

# Download and extract plugin
# Add to composer.json repositories
# Install dependencies
composer install
npm install
npm run build


--------------------------

Essential Commands to Run:

# 1. Install plugin
composer require filaforge/database-tools

# 2. Clear Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan filament:cache-components

# 3. Register in panel provider (add to your panel configuration)
->plugin(FilaforgeDatabaseToolsPlugin::make())

--------------------------

Asset Building (Optional but Recommended):

# Navigate to plugin directory
cd plugins_publish/filaforge-database-tools

# Install Node.js dependencies
npm install

# Build assets
npm run build


--------------------------

1. Environment Variables (.env)

# Database Tools Configuration
DATABASE_TOOLS_MAX_RESULTS=1000
DATABASE_TOOLS_DEFAULT_PAGE_SIZE=50
DATABASE_TOOLS_DEFAULT_TAB=viewer
DATABASE_TOOLS_SHOW_HELP=true
DATABASE_TOOLS_DARK_MODE=true
DATABASE_TOOLS_LOG_QUERIES=false
DATABASE_TOOLS_REQUIRE_AUTH=true

--------------------------

2. Panel Provider Registration

use Filaforge\DatabaseTools\FilaforgeDatabaseToolsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(FilaforgeDatabaseToolsPlugin::make());
}


--------------------------

🆘 Troubleshooting Quick Command


# Plugin not found
composer dump-autoload

# Class not found
composer clear-cache && composer dump-autoload

# Assets not loading
cd plugins/filaforge-database-tools && npm run build

# Database connection issues
php artisan tinker
>>> DB::connection()->getPdo()

# Check routes
php artisan route:list | grep database