# Filaforge Database Tools

A comprehensive Filament plugin that provides essential database management tools directly in your admin panel.

## Features

- **Database Backup**: Create and manage database backups
- **Schema Management**: View and modify database structure
- **Data Import/Export**: Bulk data operations with multiple formats
- **Query Optimization**: Analyze and optimize database queries
- **Table Management**: Create, modify, and drop database tables
- **Index Management**: Manage database indexes for performance
- **User Management**: Database user and permission management
- **Monitoring**: Real-time database performance monitoring
- **Migration Tools**: Advanced migration management utilities

## Installation

### 1. Install via Composer

```bash
composer require filaforge/database-tools
```

### 2. Publish & Migrate

```bash
# Publish provider groups (config, views, migrations)
php artisan vendor:publish --provider="Filaforge\\DatabaseTools\\Providers\\DatabaseToolsServiceProvider"

# Run migrations
php artisan migrate
```

### 3. Register Plugin

Add the plugin to your Filament panel provider:

```php
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... other configuration
        ->plugin(\Filaforge\DatabaseTools\DatabaseToolsPlugin::make());
}
```

## Setup

### Configuration

The plugin will automatically:
- Publish configuration files to `config/database-tools.php`
- Publish view files to `resources/views/vendor/database-tools/`
- Publish migration files to `database/migrations/`
- Register necessary routes and middleware

### Database Configuration

Configure database tools in the published config file:

```php
// config/database-tools.php
return [
    'backup' => [
        'enabled' => true,
        'path' => storage_path('backups/database'),
        'retention_days' => 30,
    ],
    'import' => [
        'max_file_size' => '10MB',
        'allowed_extensions' => ['csv', 'xlsx', 'json'],
    ],
    'export' => [
        'chunk_size' => 1000,
        'timeout' => 300,
    ],
    'permissions' => [
        'admin_only' => true,
        'allowed_roles' => ['admin', 'database_manager'],
    ],
];
```

### Environment Variables

Add these to your `.env` file if needed:

```env
DB_TOOLS_BACKUP_ENABLED=true
DB_TOOLS_BACKUP_PATH=storage/backups/database
DB_TOOLS_MAX_FILE_SIZE=10MB
```

## Usage

### Accessing Database Tools

1. Navigate to your Filament admin panel
2. Look for the "Database Tools" menu item
3. Choose the tool you want to use

### Database Backup

1. **Create Backup**: Generate a new database backup
2. **Schedule Backups**: Set up automatic backup schedules
3. **Download Backups**: Download backup files locally
4. **Restore Backups**: Restore from previous backups
5. **Manage Retention**: Configure backup retention policies

### Schema Management

1. **View Tables**: Browse all database tables and their structure
2. **Modify Schema**: Add, modify, or remove columns
3. **Create Tables**: Build new tables with custom schemas
4. **Drop Tables**: Safely remove unused tables
5. **View Relationships**: Explore table relationships and foreign keys

### Data Import/Export

1. **Import Data**: Upload CSV, Excel, or JSON files
2. **Export Data**: Download table data in various formats
3. **Bulk Operations**: Perform operations on large datasets
4. **Data Validation**: Validate imported data before insertion
5. **Error Handling**: Manage import/export errors gracefully

### Query Optimization

1. **Query Analysis**: Analyze slow queries and bottlenecks
2. **Index Suggestions**: Get recommendations for new indexes
3. **Performance Monitoring**: Track query execution times
4. **Query History**: Review and optimize previous queries

## Troubleshooting

### Common Issues

- **Permission denied**: Ensure the user has database management rights
- **Backup failures**: Check disk space and write permissions
- **Import timeouts**: Adjust chunk size and timeout settings
- **Memory limits**: Large operations may exceed PHP memory limits

### Debug Steps

1. Check the plugin configuration:
```bash
php artisan config:show database-tools
```

2. Verify routes are registered:
```bash
php artisan route:list | grep database-tools
```

3. Test database connectivity:
```bash
php artisan tinker
# Test database connection manually
```

4. Check backup directory permissions:
```bash
ls -la storage/backups/database
```

5. Clear caches:
```bash
php artisan optimize:clear
```

6. Check logs for errors:
```bash
tail -f storage/logs/laravel.log
```

### Performance Optimization

- Use smaller chunk sizes for large imports
- Schedule backups during low-traffic periods
- Monitor disk space for backup storage
- Use appropriate indexes for frequently queried columns

## Security Considerations

### Access Control

- **Role-based permissions**: Restrict access to authorized users only
- **Database privileges**: Use dedicated database users with limited permissions
- **Audit logging**: Track all database operations and changes
- **Backup security**: Secure backup files and access

### Best Practices

- Never expose database tools to public users
- Regularly review and update user permissions
- Encrypt sensitive backup files
- Monitor and log all database changes
- Use read-only database users when possible

## Uninstall

### 1. Remove Plugin Registration

Remove the plugin from your panel provider:
```php
// remove ->plugin(\Filaforge\DatabaseTools\DatabaseToolsPlugin::make())
```

### 2. Roll Back Migrations (Optional)

```bash
php artisan migrate:rollback
# or roll back specific published files if needed
```

### 3. Remove Published Assets (Optional)

```bash
rm -f config/database-tools.php
rm -rf resources/views/vendor/database-tools
```

### 4. Remove Package and Clear Caches

```bash
composer remove filaforge/database-tools
php artisan optimize:clear
```

### 5. Clean Up Backups (Optional)

```bash
rm -rf storage/backups/database
```

## Support

- **Documentation**: [GitHub Repository](https://github.com/filaforge/database-tools)
- **Issues**: [GitHub Issues](https://github.com/filaforge/database-tools/issues)
- **Discussions**: [GitHub Discussions](https://github.com/filaforge/database-tools/discussions)

## Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

## License

This plugin is open-sourced software licensed under the [MIT license](LICENSE).

---

**Made with ❤️ by the Filaforge Team**
