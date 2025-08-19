#!/bin/bash

# Filaforge Database Tools Setup Script
# This script automates the installation and setup process

set -e

echo "🚀 Filaforge Database Tools Setup Script"
echo "========================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if we're in the right directory
if [ ! -f "composer.json" ] || [ ! -f "src/FilaforgeDatabaseToolsServiceProvider.php" ]; then
    print_error "This script must be run from the plugin root directory"
    exit 1
fi

print_status "Starting setup process..."

# Step 1: Check prerequisites
print_status "Checking prerequisites..."

# Check PHP
if ! command -v php &> /dev/null; then
    print_error "PHP is not installed or not in PATH"
    exit 1
fi

PHP_VERSION=$(php -r "echo PHP_VERSION;")
PHP_MAJOR=$(echo $PHP_VERSION | cut -d. -f1)
PHP_MINOR=$(echo $PHP_VERSION | cut -d. -f2)

if [ "$PHP_MAJOR" -lt 8 ] || ([ "$PHP_MAJOR" -eq 8 ] && [ "$PHP_MINOR" -lt 1 ]); then
    print_error "PHP 8.1+ is required. Current version: $PHP_VERSION"
    exit 1
fi

print_success "PHP version: $PHP_VERSION ✓"

# Check Composer
if ! command -v composer &> /dev/null; then
    print_error "Composer is not installed or not in PATH"
    exit 1
fi

print_success "Composer found ✓"

# Check Node.js
if ! command -v node &> /dev/null; then
    print_warning "Node.js not found. Asset building will be skipped."
    NODE_AVAILABLE=false
else
    NODE_VERSION=$(node --version)
    print_success "Node.js version: $NODE_VERSION ✓"
    NODE_AVAILABLE=true
fi

# Check npm
if [ "$NODE_AVAILABLE" = true ] && ! command -v npm &> /dev/null; then
    print_warning "npm not found. Asset building will be skipped."
    NODE_AVAILABLE=false
fi

# Step 2: Install PHP dependencies
print_status "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

if [ $? -eq 0 ]; then
    print_success "PHP dependencies installed ✓"
else
    print_error "Failed to install PHP dependencies"
    exit 1
fi

# Step 3: Install Node.js dependencies and build assets
if [ "$NODE_AVAILABLE" = true ]; then
    print_status "Installing Node.js dependencies..."
    npm install --silent
    
    if [ $? -eq 0 ]; then
        print_success "Node.js dependencies installed ✓"
        
        print_status "Building assets..."
        npm run build --silent
        
        if [ $? -eq 0 ]; then
            print_success "Assets built successfully ✓"
        else
            print_warning "Asset building failed, but plugin will still work"
        fi
    else
        print_warning "Failed to install Node.js dependencies, but plugin will still work"
    fi
else
    print_warning "Skipping Node.js setup - plugin will work without custom styling"
fi

# Step 4: Create dist directory if it doesn't exist
if [ ! -d "resources/dist" ]; then
    print_status "Creating dist directory..."
    mkdir -p resources/dist
    print_success "Dist directory created ✓"
fi

# Step 5: Copy CSS to dist if it exists
if [ -f "resources/css/database-tools.css" ] && [ ! -f "resources/dist/database-tools.css" ]; then
    print_status "Copying CSS to dist directory..."
    cp resources/css/database-tools.css resources/dist/
    print_success "CSS copied to dist directory ✓"
fi

# Step 6: Set proper permissions
print_status "Setting file permissions..."
chmod -R 755 .
chmod +x bin/build.js 2>/dev/null || true

print_success "File permissions set ✓"

# Step 7: Generate setup summary
print_status "Generating setup summary..."

cat > SETUP_SUMMARY.md << EOF
# Setup Summary

## Installation Completed Successfully

**Date:** $(date)
**Plugin Version:** $(grep '"version"' package.json | cut -d'"' -f4 2>/dev/null || echo "1.0.0")

## What Was Installed

- ✅ PHP dependencies via Composer
- ✅ Node.js dependencies (if available)
- ✅ Assets built (if Node.js available)
- ✅ File permissions set
- ✅ Directory structure verified

## Next Steps

1. **Register the plugin** in your Filament panel provider:
   \`\`\`php
   use Filaforge\\DatabaseTools\\FilaforgeDatabaseToolsPlugin;
   
   public function panel(Panel \$panel): Panel
   {
       return \$panel
           ->plugin(FilaforgeDatabaseToolsPlugin::make());
   }
   \`\`\`

2. **Clear Laravel caches**:
   \`\`\`bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   \`\`\`

3. **Access the plugin** in your Filament panel

## Configuration

- Configuration file: \`config/database-tools.php\`
- Environment variables available in \`.env\`
- See INSTALLATION.md for detailed configuration options

## Support

- Documentation: README.md
- Installation Guide: INSTALLATION.md
- Issues: GitHub Issues
- Email: filaforger@gmail.com

---

*Generated automatically by setup script*
EOF

print_success "Setup summary generated ✓"

# Step 8: Final status
echo ""
echo "🎉 Setup completed successfully!"
echo "================================"
echo ""
echo "Next steps:"
echo "1. Register the plugin in your Filament panel provider"
echo "2. Clear Laravel caches"
echo "3. Access the plugin in your panel"
echo ""
echo "For detailed instructions, see:"
echo "- INSTALLATION.md (comprehensive guide)"
echo "- README.md (quick reference)"
echo "- SETUP_SUMMARY.md (this setup summary)"
echo ""
echo "Need help? Contact: filaforger@gmail.com"
echo ""

# Check if we should show the panel provider example
if [ -f "SETUP_SUMMARY.md" ]; then
    print_status "Setup summary saved to SETUP_SUMMARY.md"
fi

exit 0
