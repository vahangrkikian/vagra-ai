# vagra.ai

AI-powered WordPress niche themes platform by **Ethiuni** (Vahan G. & Vahan H.).

## Themes

| Theme | Directory | Description |
|-------|-----------|-------------|
| **vagra-msp** | `wp-content/themes/vagra-msp/` | Managed Service Provider theme |
| **vagra-legal** | `wp-content/themes/vagra-legal/` | Law firm / legal services theme |
| **vagra-nslookup** | `wp-content/themes/vagra-nslookup/` | DNS lookup tool site theme |
| **carvice** | `wp-content/themes/carvice/` | Car service marketplace theme |

## Project Structure

```
vagraAI/
├── wp-content/
│   ├── themes/           # Our custom themes (tracked)
│   ├── plugins/          # Custom plugins (tracked)
│   └── mu-plugins/       # Must-use plugins (tracked)
├── docs/                 # Project documentation
├── demos.html            # Theme demo showcase
├── vagraai-database.sql  # Database export
├── wp-config-sample-local.php  # Config template
└── .htaccess             # Apache config
```

> WordPress core files (`wp-admin/`, `wp-includes/`, `wp-*.php`) are **not tracked** -- install WordPress fresh.
> Reference projects (`Carmaster/`, `nslookup/`) are excluded from git.

## Setup (New Developer)

### 1. Prerequisites
- [OSPanel](https://ospanel.io/) (or any local PHP/MySQL stack)
- PHP 7.4+, MySQL 5.7+ / MariaDB 10.4+
- Git

### 2. Clone & Install WordPress
```bash
git clone https://github.com/vahangrkikian/vagra-ai.git vagraAI
cd vagraAI

# Download WordPress core files
# Option A: WP-CLI
wp core download --skip-content

# Option B: Manual
# Download from wordpress.org, extract wp-admin/, wp-includes/, and root PHP files into this folder
```

### 3. Database
```bash
# Create the database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS vagraai;"

# Import the dump
mysql -u root vagraai < vagraai-database.sql
```

### 4. Configuration
```bash
cp wp-config-sample-local.php wp-config.php
# Edit wp-config.php with your DB credentials and generate fresh salts:
# https://api.wordpress.org/secret-key/1.1/salt/
```

### 5. Point your web server
Configure OSPanel (or your stack) to serve this directory as `vagraai` (or your preferred domain).

Default WP admin: `http://vagraai/wp-admin/`

## Documentation

Detailed specs and plans live in `/docs/`:
- `master-task.md` -- Overall project plan
- `product-spec.md` -- Product specification
- `design-system-msp.md` / `design-system-legal.md` -- Design systems
- `agent-roles.md` -- AI agent definitions
- `orchestration-plan.md` -- Development orchestration

## Git Workflow

- **main** -- stable, deployable code
- Feature branches: `feature/<theme>-<description>`
- Keep `vagraai-database.sql` updated when schema changes
- Never commit `wp-config.php` (contains secrets)
