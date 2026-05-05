# WordPress.org Theme Directory Standards

## File Requirements
Every theme must include:
- style.css with valid theme headers
- index.php (fallback template)
- functions.php
- screenshot.png (1200x900, no external branding, shows actual theme)
- readme.txt (standard WordPress format)

## Coding Standards
- Follow WordPress PHP Coding Standards
- Prefix all functions with theme slug: `vagra_msp_` or `vagra_legal_`
- Prefix all CSS classes with theme slug: `.vagra-msp-` or `.vagra-legal-`
- Prefix all hooks with theme slug
- Use `wp_enqueue_style()` and `wp_enqueue_script()` — never hardcode in templates
- All strings must be translatable: `__()`, `_e()`, `esc_html__()`, `esc_html_e()`
- Text domain must match theme slug

## Security
- Escape all output: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`
- Sanitize all input: `sanitize_text_field()`, `absint()`, `wp_kses()`
- Use nonces for form submissions
- No direct database queries — use WP_Query, get_posts, WP API
- No eval(), exec(), base64_decode() in theme code
- No external HTTP requests without user consent and fallback

## Template Hierarchy
Use WordPress template hierarchy correctly:
- front-page.php → static front page
- home.php → blog posts page
- single.php → single post
- page.php → single page
- archive.php → post archives
- category.php → category archives (optional)
- 404.php → not found
- search.php → search results (optional)
- header.php, footer.php, sidebar.php → partials

## Theme Features to Register
```php
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('custom-logo');
add_theme_support('html5', [...]);
add_theme_support('automatic-feed-links');
add_theme_support('customize-selective-refresh-widgets');
```

## Navigation Menus
Register at minimum:
- primary (header)
- footer

## Widget Areas
Register at minimum:
- sidebar-1 (main sidebar)
- footer-1 (footer widgets)

## Customizer
Use the Customizer API for theme options. No custom admin pages.
Sections to add:
- Theme Colors (if allowing override of design tokens)
- AI Chat Settings (API key, enable/disable, system prompt override)
- Footer Settings (copyright text, social links)

## Demo Content
- Must NOT auto-install content
- Use the "starter content" feature or recommend One Click Demo Import plugin
- demo-content.xml must be valid WordPress eXtended RSS
- No real company names or copyrighted content in demos

## Theme Check Requirements
These must pass with zero errors:
- Theme Check plugin (latest version)
- Plugin Check plugin (latest version)
- No deprecated functions
- No direct file includes without get_template_part() or locate_template()
- No hardcoded links
- No missing text domains

## Translation
- Include a .pot file in /languages/ directory
- All user-facing strings wrapped in translation functions
- Text domain matches theme slug exactly
