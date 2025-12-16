# Contributing to DG Org Theme

Thank you for your interest in contributing! Please follow these guidelines.

# Quick Start

1. Fork this repository and clone your fork locally.
2. Set up a local WordPress environment (Docker, Local, MAMP, etc.) and place or symlink the theme
   into `/wp-content/themes/`.
3. Activate required plugins before activating the theme:
   - **Advanced Custom Fields Pro** (required — activate ACF first, then the theme)

## Setup Local Development

### Prerequisites
- PHP 8.1+
- WordPress 6.8.3+
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
- Advanced Custom Fields Pro 5.9.5+ 

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
- [ ] Compatible with WordPress 6.8.3+
- [ ] ACF fields display correctly
- [ ] Responsive design maintained
- [ ] No console JavaScript errors


# Development Workflow

## Branch Structure
- `main` — production (protected)
- `dev` — staging/integration (protected)
- `feature/*` — feature branches
- `bugfix/*` — fixes

Contributors should fork and open PRs targeting `dev`.

## Creating a Branch
```bash
git checkout dev
git pull origin dev
git checkout -b feature/your-feature-name
```

## Commit Messages
Use conventional prefixes: `feat:`, `fix:`, `docs:`, `refactor:`, `style:`, `test:`.

# Pull Requests

- Target branch: `dev`
- One logical change per PR
- Include description, related issues, and QA steps
- Request reviewers and wait for approval before merging

PR checklist:
- [ ] Branch up to date with `dev`
- [ ] ACF JSON updated if relevant
- [ ] No debug output

# Testing & Quality

Before opening a PR verify:
- No PHP errors or warnings
- No JS console errors
- ACF fields load and save
- Responsive layout
- Visual checks in major browsers

Automated checks (if configured) should run on PRs.

# ACF & Database

- ACF is required and must be activated before the theme.
- ACF JSON files live in `acf-json/` — commit changes to field groups.
- Use provided SQL dumps for testing multisite if needed.

# Multisite

This theme is built with multisite support in mind (uses `switch_to_blog()`/`restore_current_blog()` for cross-site content) -- some features expect multisite data. For multisite testing, import the provided dumps and enable multisite in your local `wp-config.php`.  

---

# Questions

If you need help: open an Issue, or contact maintainers.

```

