# InspectDatabaseBundle

A Symfony bundle that provides console commands to inspect and analyze your database structure.

This package is inspired by [Laravel commands](https://laravel.com/docs/12.x/database#inspecting-your-databases) and [Laravel Console List Columns package](https://github.com/romanzipp/Laravel-Console-List-Columns).

## Features

- 📊 **Database overview**: Get a complete list of all tables in your database
- 🔍 **Table inspection**: Detailed information about table columns, types, constraints, and indexes
- ⚡ **Fast and lightweight**: Uses Doctrine DBAL for efficient database introspection
- 🎨 **Beautiful output**: Clean, formatted console output using Symfony Console components

## Installation

Install the bundle via Composer:

```bash
composer require yamous/inspect-database-bundle
```

If you're using Symfony Flex, the bundle will be automatically registered. Otherwise, add it to your `config/bundles.php`:

```php
<?php

return [
    // ...
    Yamous\InspectDatabaseBundle\InspectDatabaseBundle::class => ['all' => true],
];
```

## Usage

### Show all database tables

```bash
bin/console yamous:database:show
```

This command displays:
- Information about database connexion
- List of all tables in your database with basic information

### Show detailed table information

```bash
bin/console table:show <tableName>
```

This command displays detailed information about a specific table:

#### Column Information
- Column name
- Data type (VARCHAR, INTEGER, etc.)
- Length and precision
- Nullable
- Default value
- Auto-increment
- Comment

#### Index Information  
- Index names
- Columns included in each index
- Index types (PRIMARY, UNIQUE, etc.)

## License

This bundle is released under the MIT License. See the [LICENSE](LICENSE.md) file for details.

## Support

If you encounter any issues or have questions, please [open an issue](https://github.com/mryamous/pontos/issues) on GitHub.