# 🚀 Quick Reference Card

## 📋 Essential Commands

### Installation
```bash
# Quick install via Composer
composer require filaforge/database-tools

# Manual setup (if downloaded)
cd plugins/filaforge-database-tools
./setup.sh                    # Linux/Mac
setup.bat                     # Windows
```

### Asset Building
```bash
# Install dependencies
npm install

# Build for production
npm run build

# Development with watch
npm run dev
npm run watch
```

### Laravel Commands
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear Filament caches
php artisan filament:cache-components
php artisan filament:cache-panels

# Check routes
php artisan route:list | grep database
```

### Plugin Management
```bash
# Check if installed
composer show filaforge/database-tools

# Update plugin
composer update filaforge/database-tools

# Remove plugin
composer remove filaforge/database-tools
```

## ⚙️ Configuration

### Environment Variables (.env)
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

### Panel Provider Registration
```php
use Filaforge\DatabaseTools\FilaforgeDatabaseToolsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(FilaforgeDatabaseToolsPlugin::make());
}
```

## 🔍 Troubleshooting

### Common Issues

| Issue | Solution |
|-------|----------|
| Plugin not found | `composer dump-autoload` |
| Class not found | `composer clear-cache && composer dump-autoload` |
| Assets not loading | `npm run build` in plugin directory |
| Database connection | Check `.env` and database permissions |
| Permission denied | `chmod -R 755 plugins/filaforge-database-tools/` |

### Debug Commands
```bash
# Check PHP version
php --version

# Check Composer
composer --version

# Check Node.js
node --version

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo()

# List all providers
php artisan config:show app.providers
```

## 📁 File Structure

```
filaforge-database-tools/
├── src/                          # PHP source code
├── resources/                    # Views, CSS, translations
├── config/                       # Configuration files
├── bin/                          # Build scripts
├── composer.json                 # Package configuration
├── package.json                  # Node.js dependencies
├── setup.sh                      # Linux/Mac setup script
├── setup.bat                     # Windows setup script
├── README.md                     # Main documentation
├── INSTALLATION.md               # Detailed installation guide
└── QUICK_REFERENCE.md            # This file
```

## 🎯 Quick Start Checklist

- [ ] Install plugin: `composer require filaforge/database-tools`
- [ ] Register in panel provider: `->plugin(FilaforgeDatabaseToolsPlugin::make())`
- [ ] Clear caches: `php artisan cache:clear`
- [ ] Access plugin in Filament panel
- [ ] Test database connection
- [ ] Try both viewer and query modes

## 📞 Support

- **Email**: filaforger@gmail.com
- **Documentation**: README.md, INSTALLATION.md
- **Issues**: GitHub Issues
- **Quick Help**: This reference card

## 🔗 Related Files

- **README.md** - Main documentation and features
- **INSTALLATION.md** - Comprehensive installation guide
- **setup.sh/setup.bat** - Automated setup scripts
- **composer.json** - Package dependencies
- **package.json** - Node.js dependencies

---

**💡 Tip**: Run `./setup.sh` (Linux/Mac) or `setup.bat` (Windows) for automated installation!
