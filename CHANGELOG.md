# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-01-XX

### Added
- Initial release of Filaforge Database Tools
- Combined database viewer and query builder functionality
- Toggle interface between viewer and query modes
- Header navigation buttons for easy switching
- Database connection selection
- Table browsing and data viewing
- SQL query execution with security restrictions
- Preset queries for common operations
- Real-time query results display
- Error handling and user notifications
- Responsive design with dark mode support
- Comprehensive language support
- Pagination for large datasets
- Column filtering and sorting
- Security features (SELECT-only queries)

### Features
- **Database Viewer Mode**:
  - Browse database tables
  - View table contents with pagination
  - Dynamic column detection
  - Table structure information
  - Connection management

- **Query Builder Mode**:
  - Custom SQL query execution
  - Preset query templates
  - Results formatting and display
  - Error handling and validation
  - Query history management

- **Unified Interface**:
  - Tab-based navigation
  - Consistent design language
  - Responsive layout
  - Dark mode compatibility

### Technical
- Built with FilamentPHP 4.x
- Laravel 12.x compatibility
- Spatie Package Tools integration
- Livewire components
- Tailwind CSS styling
- Asset management integration

### Security
- SELECT queries only restriction
- Database connection validation
- User permission considerations
- Input sanitization

## [Unreleased]

### Planned
- Export functionality for query results
- Query history and favorites
- Advanced table filtering
- Database schema visualization
- Performance optimization tools
- Multi-database support
- Query templates library
- User role-based access control
