# Filaforge Database Tools

A comprehensive FilamentPHP plugin that combines database viewing and query building capabilities in a single, user-friendly interface. This plugin merges the functionality of database viewer and query builder into one cohesive tool.

## ✨ Features

- **🔍 Database Viewer**: Browse database tables and view their contents with pagination
- **⚡ Query Builder**: Execute custom SQL queries with real-time results
- **🔄 Toggle Interface**: Switch between viewer and query modes with intuitive header buttons
- **🎨 Responsive Design**: Works seamlessly on all device sizes
- **🌙 Dark Mode Support**: Full compatibility with Filament's dark mode
- **🔒 Security**: Only SELECT queries allowed for safety
- **📊 Preset Queries**: Common database operations available as presets
- **📱 Modern UI**: Built with Filament's latest design patterns

## 🚀 Installation

### Quick Install (Recommended)

```bash
# Install via Composer
composer require filaforge/database-tools

# Register in your panel provider
# Add this line to your panel configuration:
->plugin(FilaforgeDatabaseToolsPlugin::make())
```

### Manual Installation

1. Clone this repository to your `plugins` directory
2. Add the service provider to your `composer.json`:

```json
"extra": {
    "laravel": {
        "providers": [
            "Filaforge\\DatabaseTools\\FilaforgeDatabaseToolsServiceProvider"
        ]
    }
}
```

### 📖 Detailed Installation Guide

For comprehensive installation instructions, troubleshooting, and configuration options, see [INSTALLATION.md](INSTALLATION.md).

## 📖 Usage

### 1. Register the Plugin

In your panel provider:

```php
use Filaforge\DatabaseTools\FilaforgeDatabaseToolsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(FilaforgeDatabaseToolsPlugin::make());
}
```

### 2. Access the Tools

Navigate to the "Database Tools" page in your Filament panel. You'll see two main sections:

#### Database Viewer
- Select database connection
- Browse available tables
- View table data with pagination
- Sort and filter data

#### Query Builder
- Execute custom SQL queries
- Use preset queries for common operations
- View results in formatted tables
- Error handling and validation

### 3. Toggle Between Modes

Use the header buttons to switch between viewer and query modes:
- **Blue button** indicates the active mode
- **Gray buttons** are available for switching

## ⚙️ Configuration

The plugin automatically detects your database connections and tables. No additional configuration is required.

### Database Connections

The plugin will automatically detect all configured database connections from your `config/database.php` file.

### Security Settings

- Only SELECT queries are allowed for security
- Results are limited to prevent performance issues
- Database connection validation

## 🛡️ Security Considerations

⚠️ **Important**: This plugin provides direct database access. Ensure proper user permissions and authentication are in place before use in production environments.

### Recommended Security Measures

1. **User Authentication**: Ensure only authorized users can access the plugin
2. **Database Permissions**: Limit database user permissions to read-only access
3. **Environment Restrictions**: Consider disabling in production or limiting to specific user roles
4. **Query Logging**: Monitor and log all database queries for audit purposes

## 📋 Requirements

- **PHP**: 8.1 or higher
- **Laravel**: 12.x
- **Filament**: 4.x
- **Database**: MySQL/MariaDB, PostgreSQL, SQLite, SQL Server

## 🧪 Testing

```bash
# Run tests
composer test

# Run with coverage
composer test -- --coverage
```

## 🔧 Development

### Local Development

1. Clone the repository
2. Install dependencies: `composer install`
3. Link to your Laravel project for testing

### Building Assets

```bash
# Install Node.js dependencies
npm install

# Build CSS
npm run build
```

## 📁 File Structure

```
filaforge-database-tools/
├── src/
│   ├── FilaforgeDatabaseToolsServiceProvider.php
│   ├── FilaforgeDatabaseToolsPlugin.php
│   └── Pages/
│       └── DatabaseTools.php
├── resources/
│   ├── views/
│   │   └── pages/
│   │       ├── database-tools.blade.php
│   │       ├── database-viewer.blade.php
│   │       └── database-query.blade.php
│   ├── lang/
│   │   └── en/
│   │       └── database-tools.php
│   └── css/
│       └── database-tools.css
├── composer.json
├── README.md
└── CHANGELOG.md
```

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

### Development Workflow

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## 📝 Changelog

See [CHANGELOG.md](CHANGELOG.md) for a complete list of changes.

## 🐛 Bug Reports

If you find a bug, please report it using the [GitHub issue tracker](https://github.com/filaforge/database-tools/issues).

## 💡 Feature Requests

Have an idea for a new feature? We'd love to hear it! Please create an issue or submit a pull request.

## 📄 License

This plugin is open-sourced software licensed under the [MIT license](LICENSE).

## 🙏 Acknowledgments

- [FilamentPHP](https://filamentphp.com/) for the amazing admin panel framework
- [Laravel](https://laravel.com/) for the robust PHP framework
- [Spatie](https://spatie.be/) for the excellent package tools

## 📞 Support

- **Email**: filaforger@gmail.com
- **Issues**: [GitHub Issues](https://github.com/filaforge/database-tools/issues)
- **Source**: [GitHub Repository](https://github.com/filaforge/database-tools)
- **Documentation**: [GitHub Wiki](https://github.com/filaforge/database-tools/wiki)

---

**Made with ❤️ by the Filaforge Team**
