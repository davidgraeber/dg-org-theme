# Whatever (DG Org Wordpress Theme)

Contributors: automattic  
Tags: custom-background, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready

Requires WP: 6.8.3  
Requires PHP: 8.1  
License: GNU General Public License v2 or later  
License URI: [LICENSE](LICENSE)

## Description

A starter WordPress theme called "Whatever".

## Installation

1. In your WP admin panel go to Appearance → Themes and click Add New.  
2. Click Upload Theme, choose the theme ZIP file and click Install Now.  
3. Click Activate to use the theme immediately.

Alternatively copy the theme folder to `/wp-content/themes/` and activate from Appearance → Themes.

### For Developers

See [CONTRIBUTING.md](/CONTRIBUTING.md) for detailed setup instructions.

**Quick setup:**
```bash
git clone https://github.com/davidgraeber/dg-org-theme
cd dg-org-theme
```

**Configure WordPress (local/dev):**
- Install WordPress locally (Docker, Local, MAMP, etc.)
- Place or symlink the theme into `/wp-content/themes/<THEME NAME>/`
- Set your database credentials in `wp-config.php` or use the provided Docker environment
- For multisite testing, import the provided database dump (see Database for Testing)

**Activate plugins and theme (order):**
1. **Activate Advanced Custom Fields Pro** (ACF) first — required by theme
2. Activate the "Whatever" theme

## Requirements

- WordPress 6.8.3+
- PHP 8.1+
- Advanced Custom Fields Pro (required)

## Features

- Dynamic post type creation via ACF
- Multi-language support
- Book management with translations
- People directory
- Custom archive layouts
- PhotoSwipe image gallery integration
- Lazy loading images (lazysizes)
- ScrollMagic animations
- Multisite support

## Project Structure

```
dg-org-theme/
├── acf-json/              # ACF field group configurations
├── fonts/                 # Custom fonts
├── img/                   # Images and SVGs
├── inc/                   # Theme functionality
│   ├── classes/          # PHP classes (namespace: Whatever)
│   ├── custom-fields/    # ACF field definitions
│   ├── admin-interface/  # Admin customizations
│   └── ...
├── js/                    # JavaScript files
│   ├── global.js         # Global variables
│   ├── media.js          # Slider initialization
│   ├── main.js           # Main theme script
│   └── ls/               # lazysizes plugins
├── lib/                   # Third-party libraries
│   ├── photoswipe/       # Image gallery library
│   └── icons/            # Icon fonts
├── languages/             # Translation files
├── template-parts/        # Reusable template components
├── functions.php          # Theme setup and hooks
├── header.php             # Header template
├── footer.php             # Footer template
├── style.css              # Main stylesheet
└── correction-styles.css  # Style overrides

```

## Key Files

- **`functions.php`** - Main theme setup, script/style enqueuing, custom post types
- **`inc/customizer.php`** - Theme customizer and ACF options
- **`inc/post-types.php`** - Dynamic post type registration
- **`inc/acf-functions.php`** - ACF-related utilities

## Development

### Local Development Server

**Using Local:**
1. Create new WordPress site
2. Clone theme to `/public/wp-content/themes/<THEME NAME>/`
3. Activate Advanced Custom Fields Pro plugin first
4. Then activate "Whatever" theme

### Database for Testing

The repository includes a database dump for testing the multisite configuration:
- `dgorg.sql.zip` — Database export for testing (ZIP containing `dgorg.sql`).

To use the dump:

```bash
unzip dgorg.sql.zip          # extracts dgorg.sql
# then import with mysql or phpMyAdmin, for example:
mysql -u root -p your_db_name < dgorg.sql
```

Or use phpMyAdmin to upload the `dgorg.sql` file (increase upload limits if needed).

### Configuration

Use `wp-config-sample.php` as a reference for WordPress configuration. The file includes:
- Database table prefix
- Debugging constants (e.g. `WP_DEBUG`)
- Multisite-related constants (e.g. `WP_ALLOW_MULTISITE`, `MULTISITE`, `SUBDOMAIN_INSTALL`, domain/path/site IDs)

### Code Standards

- Follow WordPress coding standards
- Use ACF for all custom fields
- Use PHP namespace `Whatever\` for classes
- Autoloading via `inc/autoloader.php`

### Building/Compiling

If using build tools:
```bash
npm run dev      # Development
npm run build    # Production
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## Multisite Support

This theme is configured for WordPress Multisite with blog relationships:
- Blog ID 1: Main site
- Blog ID 3: Estate/translations site

Functions handle `switch_to_blog()` and `restore_current_blog()` for cross-site content access.

## License

GNU General Public License v2 or later - See [LICENSE](LICENSE)

## Credits

- Based on [Underscores](https://underscores.me/)
- [normalize.css](https://necolas.github.io/normalize.css/)
- [PhotoSwipe](http://photoswipe.com/)
- [ScrollMagic](http://scrollmagic.io/)
- [lazysizes](https://github.com/aFarkas/lazysizes)
- Built for [davidgraeber.org](https://davidgraeber.org)
