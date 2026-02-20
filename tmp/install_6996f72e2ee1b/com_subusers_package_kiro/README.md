# COM_SUBUSERS - Joomla Component Package

## Description
This is an installable Joomla component package for com_subusers - a role-based user management system.

**Version:** 1.0.0  
**Author:** Techjoomla  
**License:** GNU General Public License version 2 or later

## Package Contents

This package includes:
- Administrator component files
- Site (frontend) component files (minimal structure)
- Language files (en-GB)
- Media files (images)
- SQL installation/uninstallation scripts
- Installation script (script.php)

## Installation Instructions

### Method 1: Manual File Copy (Recommended since terminal is not working)

1. **Copy Administrator Files:**
   ```
   cp -r administrator/components/com_subusers/* com_subusers_package/administrator/
   ```

2. **Copy Language Files:**
   ```
   cp administrator/language/en-GB/en-GB.com_subusers.ini com_subusers_package/languages/administrator/en-GB/
   cp administrator/language/en-GB/en-GB.com_subusers.sys.ini com_subusers_package/languages/administrator/en-GB/
   ```

3. **Copy Media Files:**
   ```
   cp -r administrator/components/com_subusers/assets/images/* com_subusers_package/media/images/
   ```

4. **Create ZIP Package:**
   ```
   cd com_subusers_package
   zip -r ../com_subusers_v1.0.0.zip .
   cd ..
   ```

### Method 2: Using Build Script

If you have terminal access, you can use the provided build script:

```bash
chmod +x build_package.sh
./build_package.sh
```

Or use the Python script:

```bash
python3 build_subusers_package.py
```

## Package Structure

```
com_subusers_package/
├── subusers.xml                    # Main manifest file
├── script.php                      # Installation script
├── administrator/                  # Backend component files
│   ├── subusers.php
│   ├── controller.php
│   ├── access.xml
│   ├── config.xml
│   ├── controllers/
│   ├── helpers/
│   ├── includes/
│   ├── libraries/
│   ├── models/
│   ├── sql/
│   ├── tables/
│   ├── views/
│   └── assets/
├── site/                           # Frontend component files
│   ├── subusers.php
│   ├── controller.php
│   ├── router.php
│   ├── controllers/
│   ├── helpers/
│   ├── models/
│   └── views/
├── languages/                      # Language files
│   ├── administrator/
│   │   └── en-GB/
│   │       ├── en-GB.com_subusers.ini
│   │       └── en-GB.com_subusers.sys.ini
│   └── site/
│       └── en-GB/
│           └── en-GB.com_subusers.ini
└── media/                          # Media files
    └── images/
        ├── s_com_subusers.png
        ├── l_com_subusers.png
        ├── s_users.png
        ├── s_roles.png
        ├── s_actions.png
        └── s_mappings.png
```

## Installing in Joomla

1. Create the ZIP package using one of the methods above
2. Log in to your Joomla administrator panel
3. Go to Extensions → Install/Uninstall
4. Click "Browse" and select the `com_subusers_v1.0.0.zip` file
5. Click "Upload & Install"

## Features

The component provides:
- User management with role-based access control
- Role management
- Action management
- Role-Action mappings
- Organization management

## Database Tables

The component creates the following database tables:
- `#__subusers_users`
- `#__subusers_roles`
- `#__subusers_actions`
- `#__subusers_mappings`

## Requirements

- Joomla 3.x or higher
- PHP 7.2 or higher
- MySQL 5.6 or higher

## Support

For support and questions, contact: contact@techjoomla.com

## License

GNU General Public License version 2 or later; see LICENSE.txt
