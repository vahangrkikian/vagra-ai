# vagra.ai — Setup Instructions for Claude Code

> This file is a step-by-step guide for Claude Code to clone and set up the vagra.ai project on a new device.
> When asked to set up the project, follow every step below in order.

## Prerequisites

Before starting, verify that the following are available on the machine:
- Git (`git --version`)
- PHP 7.4+ (`php -v`)
- MySQL or MariaDB (`mysql --version` or check for mysqldump)
- A local web server (OSPanel, XAMPP, MAMP, WAMP, or similar)

If any prerequisite is missing, inform the user and help them install it before continuing.

---

## Step 1: Clone the repository

```bash
cd <web-server-sites-directory>
git clone https://github.com/vahangrkikian/vagra-ai.git vagraAI
cd vagraAI
```

**For OSPanel**, the sites directory is typically `C:\OSPanel\domains\`.

---

## Step 2: Download WordPress core files

The repo does NOT include WordPress core files (they are gitignored). You must download them.

**Option A — WP-CLI (if available):**
```bash
wp core download --skip-content
```

**Option B — Manual download:**
1. Download the latest WordPress from https://wordpress.org/latest.zip
2. Extract and copy the following INTO the project root (vagraAI/):
   - `wp-admin/` (entire directory)
   - `wp-includes/` (entire directory)
   - All root PHP files: `index.php`, `wp-activate.php`, `wp-blog-header.php`, `wp-comments-post.php`, `wp-cron.php`, `wp-links-opml.php`, `wp-load.php`, `wp-login.php`, `wp-mail.php`, `wp-settings.php`, `wp-signup.php`, `wp-trackback.php`, `xmlrpc.php`
   - `license.txt`, `readme.html`
3. Do NOT overwrite `wp-content/` — our themes and plugins are already in the repo.

**Option C — Using curl/PowerShell:**
```bash
# Linux/Mac
curl -O https://wordpress.org/latest.zip && unzip latest.zip
cp -r wordpress/wp-admin ./
cp -r wordpress/wp-includes ./
cp wordpress/*.php ./
cp wordpress/license.txt wordpress/readme.html ./
rm -rf wordpress latest.zip
```

```powershell
# Windows PowerShell
Invoke-WebRequest -Uri https://wordpress.org/latest.zip -OutFile latest.zip
Expand-Archive latest.zip -DestinationPath .
Copy-Item -Recurse wordpress\wp-admin .\wp-admin
Copy-Item -Recurse wordpress\wp-includes .\wp-includes
Copy-Item wordpress\*.php .\
Copy-Item wordpress\license.txt, wordpress\readme.html .\
Remove-Item -Recurse wordpress, latest.zip
```

---

## Step 3: Create the database

Find the MySQL/MariaDB binary and run:

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS vagraai CHARACTER SET utf8 COLLATE utf8_general_ci;"
```

If MySQL requires a password, use: `mysql -u root -p`

Then import the database dump:

```bash
mysql -u root vagraai < vagraai-database.sql
```

The dump file `vagraai-database.sql` is in the project root.

**For OSPanel**, mysqldump/mysql binaries are at:
`C:\OSPanel\modules\database\<MySQL-or-MariaDB-version>\bin\mysql.exe`

---

## Step 4: Create wp-config.php

```bash
cp wp-config-sample-local.php wp-config.php
```

Then edit `wp-config.php` and update these values:

| Setting       | OSPanel default | Other stacks         |
|---------------|-----------------|----------------------|
| `DB_NAME`     | `vagraai`       | `vagraai`            |
| `DB_USER`     | `root`          | your MySQL user      |
| `DB_PASSWORD` | `` (empty)      | your MySQL password  |
| `DB_HOST`     | `localhost`     | `localhost` or `127.0.0.1` |

**Generate fresh authentication salts** — replace the placeholder lines with output from:
https://api.wordpress.org/secret-key/1.1/salt/

You can fetch them programmatically:
```bash
curl -s https://api.wordpress.org/secret-key/1.1/salt/
```

---

## Step 5: Configure the web server

### OSPanel
1. Open OSPanel settings → Domains
2. Add a new domain pointing to the `vagraAI` folder
3. Restart the web server module

### XAMPP
- Create a virtualhost in `httpd-vhosts.conf` or place the project in `htdocs/vagraAI`

### Generic
- Point your web server's document root to the `vagraAI/` directory
- Ensure PHP is enabled and MySQL is running

---

## Step 6: Verify the setup

1. Open the site in a browser: `http://vagraai/` (or whatever domain you configured)
2. Access WP admin: `http://vagraai/wp-admin/`
3. Check that themes are available under Appearance → Themes:
   - vagra-msp
   - vagra-legal
   - vagra-nslookup
   - carvice

---

## Step 7: Configure Git for collaboration

```bash
git config user.name "Your Name"
git config user.email "your@email.com"
```

### Branching workflow
- `main` — stable code, always deployable
- Create feature branches for new work: `git checkout -b feature/<theme>-<description>`
- Push branches and create Pull Requests for review before merging to main

---

## Project structure (what's in the repo)

```
vagraAI/
├── .gitignore                  # Git exclusions
├── .htaccess                   # Apache rewrite rules
├── README.md                   # Project overview
├── SETUP.md                    # This file
├── demos.html                  # Theme demo showcase page
├── vagraai-database.sql        # Full database export
├── wp-config-sample-local.php  # Config template (copy to wp-config.php)
├── docs/                       # Project documentation & specs
├── wp-content/
│   ├── mu-plugins/             # Must-use plugins
│   ├── plugins/theme-check/    # Theme Check plugin
│   └── themes/
│       ├── vagra-msp/          # MSP theme
│       ├── vagra-legal/        # Legal theme
│       ├── vagra-nslookup/     # DNS lookup theme
│       └── carvice/            # Car service marketplace theme
```

## What is NOT in the repo (gitignored)

- `wp-admin/`, `wp-includes/` — WordPress core (download fresh)
- `wp-config.php` — contains secrets (create from template)
- `wp-content/uploads/` — media files
- `Carmaster/`, `nslookup/` — reference projects (not needed to run)
- `node_modules/` — install via `npm install` if needed

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| White screen / 500 error | Check that `wp-config.php` exists and DB credentials are correct |
| "Error establishing database connection" | Verify MySQL is running and `vagraai` database exists |
| Themes not showing | Check `wp-content/themes/` has the theme folders |
| Missing styles/broken layout | Ensure `.htaccess` is present and `mod_rewrite` is enabled |
| Permission errors | On Linux/Mac: `chmod -R 755 .` and `chmod -R 775 wp-content` |
