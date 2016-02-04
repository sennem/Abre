# Abre

Abre is an open platform that helps school districts provide easily authenticated, role-based access to web-based systems.

## Installation

After you clone the repo project, customize the configuration.php file to match your server settings. You will need to create your database and tables to match.

## Documentation

### Server Configuration

Update configuration.php to set organizational policies and settings.

### Core Functions

**encrypt** - Encrypts a string using the key defined in configuration.php file.

**decrypt** - Decrypts a string using the key defined in configuration.php file.

**finduserid** - Returns a the user ID of a given email.