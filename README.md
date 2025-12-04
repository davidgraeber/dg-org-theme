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

**Configure WordPress:**
- Copy `wp-config-sample.php` to your WordPress installation as reference or base for configuration
- Set up your database credentials in `wp-config.php`
- For multisite testing, use the included database dump files (`.sql`) to restore a pre-configured multisite instance

**Activate plugins and theme (in order):**
1. **Activate Advanced Custom Fields Pro plugin first** — required by theme
2. Then activate the "Whatever" theme

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
2. Clone theme to `/public/wp-content/themes/wtvr/`
3. Activate Advanced Custom Fields Pro plugin first
4. Then activate "Whatever" theme

### Database for Testing

The repository includes SQL database dumps for testing the multisite configuration:
- `dgorg.sql` — Database export for testing

### Configuration

Use `wp-config-sample.php` as a reference for WordPress configuration. The file includes:
- Database connection settings
- Security keys and salts
- Multisite configuration (commented by default)
- Debug logging options

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
