<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Database Tools Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the Database Tools plugin.
    | You can customize these settings according to your needs.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection
    |--------------------------------------------------------------------------
    |
    | The default database connection to use when the plugin loads.
    | This should match one of your configured database connections.
    |
    */
    'default_connection' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Allowed Query Types
    |--------------------------------------------------------------------------
    |
    | Array of allowed SQL query types for security purposes.
    | Only these query types will be allowed to execute.
    |
    */
    'allowed_query_types' => [
        'SELECT',
        'SHOW',
        'DESCRIBE',
        'EXPLAIN',
    ],

    /*
    |--------------------------------------------------------------------------
    | Maximum Results Limit
    |--------------------------------------------------------------------------
    |
    | Maximum number of results to return from queries to prevent
    | performance issues with large datasets.
    |
    */
    'max_results' => env('DATABASE_TOOLS_MAX_RESULTS', 1000),

    /*
    |--------------------------------------------------------------------------
    | Default Page Size
    |--------------------------------------------------------------------------
    |
    | Default number of records to show per page in the table viewer.
    |
    */
    'default_page_size' => env('DATABASE_TOOLS_DEFAULT_PAGE_SIZE', 50),

    /*
    |--------------------------------------------------------------------------
    | Available Page Sizes
    |--------------------------------------------------------------------------
    |
    | Array of available page sizes for pagination.
    |
    */
    'available_page_sizes' => [10, 25, 50, 100, 250, 500],

    /*
    |--------------------------------------------------------------------------
    | Preset Queries
    |--------------------------------------------------------------------------
    |
    | Array of preset queries that users can select from.
    | These should be safe, read-only queries.
    |
    */
    'preset_queries' => [
        'users_10' => [
            'label' => 'Users (10 records)',
            'query' => 'SELECT * FROM users LIMIT 10',
            'description' => 'Get the first 10 users from the users table',
        ],
        'users_count' => [
            'label' => 'Total Users Count',
            'query' => 'SELECT COUNT(*) as total FROM users',
            'description' => 'Count total number of users',
        ],
        'users_today' => [
            'label' => 'Users Created Today',
            'query' => 'SELECT * FROM users WHERE DATE(created_at) = CURDATE()',
            'description' => 'Get users created today',
        ],
        'show_tables' => [
            'label' => 'Show All Tables',
            'query' => 'SHOW TABLES',
            'description' => 'Display all tables in the current database',
        ],
        'table_info' => [
            'label' => 'Table Information',
            'query' => 'SELECT TABLE_NAME, TABLE_ROWS, DATA_LENGTH, INDEX_LENGTH FROM information_schema.tables WHERE table_schema = DATABASE()',
            'description' => 'Get detailed information about all tables',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Security-related configuration options.
    |
    */
    'security' => [
        /*
        |--------------------------------------------------------------------------
        | Enable Query Logging
        |--------------------------------------------------------------------------
        |
        | Whether to log all executed queries for audit purposes.
        |
        */
        'log_queries' => env('DATABASE_TOOLS_LOG_QUERIES', false),

        /*
        |--------------------------------------------------------------------------
        | Log Channel
        |--------------------------------------------------------------------------
        |
        | The log channel to use for query logging.
        |
        */
        'log_channel' => env('DATABASE_TOOLS_LOG_CHANNEL', 'daily'),

        /*
        |--------------------------------------------------------------------------
        | Require Authentication
        |--------------------------------------------------------------------------
        |
        | Whether users must be authenticated to use the database tools.
        |
        */
        'require_auth' => env('DATABASE_TOOLS_REQUIRE_AUTH', true),

        /*
        |--------------------------------------------------------------------------
        | Allowed User Roles
        |--------------------------------------------------------------------------
        |
        | Array of user roles that are allowed to access the database tools.
        | Leave empty to allow all authenticated users.
        |
        */
        'allowed_roles' => env('DATABASE_TOOLS_ALLOWED_ROLES', []),
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Settings
    |--------------------------------------------------------------------------
    |
    | User interface configuration options.
    |
    */
    'ui' => [
        /*
        |--------------------------------------------------------------------------
        | Default Active Tab
        |--------------------------------------------------------------------------
        |
        | The default tab to show when the plugin loads.
        | Options: 'viewer', 'query'
        |
        */
        'default_tab' => env('DATABASE_TOOLS_DEFAULT_TAB', 'viewer'),

        /*
        |--------------------------------------------------------------------------
        | Show Help Information
        |--------------------------------------------------------------------------
        |
        | Whether to show help information and guidelines in the interface.
        |
        */
        'show_help' => env('DATABASE_TOOLS_SHOW_HELP', true),

        /*
        |--------------------------------------------------------------------------
        | Enable Dark Mode
        |--------------------------------------------------------------------------
        |
        | Whether to enable dark mode support in the interface.
        |
        */
        'dark_mode' => env('DATABASE_TOOLS_DARK_MODE', true),
    ],
];
