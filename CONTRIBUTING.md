# Contributing to DG Org Theme

Thank you for your interest in contributing! Please follow these guidelines.

## Setup Local Development

### Prerequisites
- PHP 7.4+
- WordPress 5.4+
- Composer (optional, for ACF Pro)
- Git

### Installation Steps

1. **Fork** the repository on GitHub and **clone it locally**
   ([help](https://help.github.com/articles/fork-a-repo)).

2. **Install dependencies:**
```bash
composer install  # if using ACF Pro
npm install       # for frontend build tools (if applicable)
```

3. **Set up WordPress locally:**
- Install WordPress locally using MAMP, LAMP, Docker, or Local by Flywheel
- Navigate to `/wp-content/themes/` and symlink or copy the theme folder
- Activate the "Whatever" theme in WordPress admin

4. **Activate required plugins:**
- Advanced Custom Fields Pro 5.9.5+ (configure ACF license in `wp-config.php`)

## Development Workflow

### Branch Structure
- **`main`** - Production-ready code (protected branch)
- **`dev`** - Staging/development branch (integration branch)
- **`feature/*`** - Feature branches (e.g., `feature/book-translations`)
- **`bugfix/*`** - Bug fix branches (e.g., `bugfix/archive-filter`)

### Creating a Feature Branch

```bash
# Update dev branch
git checkout dev
git pull origin dev

# Create feature branch from dev
git checkout -b feature/your-feature-name
```

### Making Changes

1. Make your changes locally
2. Test thoroughly in your local WordPress environment
3. Keep commits focused and descriptive:
```bash
git add .
git commit -m "feat: add translation filter to book archive"
```

### Creating a Pull Request

1. Go to GitHub/Bitbucket and create a Pull Request
2. Target: `dev` branch
3. Include description of changes
4. Request review from team members
5. Ensure all checks pass

### Code Review & Merge

- Wait for approval from at least one team member
- Address any comments/requests
- Once approved, merge to `dev` branch
- Delete feature branch after merge

## Testing Checklist

Before submitting PR:
- [ ] Feature works in local environment
- [ ] No PHP errors/warnings in error log
- [ ] Compatible with WordPress 5.4+
- [ ] ACF fields display correctly
- [ ] Responsive design maintained
- [ ] No console JavaScript errors

## Common Tasks

### Syncing with latest dev
```bash
git fetch origin
git rebase origin/dev
```

### Updating ACF JSON files
- ACF JSON auto-syncs to `acf-json/` folder
- Commit these changes with your feature

### Database Considerations
- Use ACF field groups for any new data structures
- Update `acf-json/` files in your commits

## Questions?

- Check existing GitHub Issues
- Open a new Issue for bugs or suggestions
- Contact team leads for guidance
