# Elementor Integration Process for Vagra.ai Themes

Reusable step-by-step guide for adding Elementor visual builder support to any theme in the vagra.ai portfolio. Based on the working pattern from `vagra-nslookup`.

---

## Overview

Each theme supports **dual-mode rendering**: PHP templates (default) and Elementor (optional). When Elementor is active and a page is built with it, the theme renders Elementor content. Otherwise, it falls back to native PHP templates.

**Reference implementation:** `vagra-nslookup` theme + `vagra-nslookup-core` plugin.

---

## Step 1: Identify Theme Sections (Widgets)

Audit the theme's front-page and key page templates. Each visual section becomes a custom Elementor widget.

**Example for a Legal theme:**
| Template Section | Widget Name | Widget Class |
|-----------------|-------------|--------------|
| Hero banner | `vagra_legal_hero` | `Hero` |
| Practice Areas grid | `vagra_legal_practice_areas` | `Practice_Areas` |
| Attorney profiles | `vagra_legal_attorneys` | `Attorneys` |
| Testimonials | `vagra_legal_testimonials` | `Testimonials` |
| Stats/counters | `vagra_legal_stats` | `Stats` |
| CTA section | `vagra_legal_cta` | `CTA` |
| Contact form | `vagra_legal_contact` | `Contact_Form` |

---

## Step 2: Add Elementor Detection to Page Templates

In each page template that should support Elementor, add the detection block at the top (after `get_header` check but before PHP rendering):

```php
// front-page.php, page-about.php, etc.
if ( defined( 'ELEMENTOR_VERSION' )
     && \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) {
    get_header();
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    get_footer();
    return;
}
```

This ensures:
- Elementor pages render via Elementor
- Non-Elementor pages use the existing PHP template
- No changes to the PHP template rendering path

---

## Step 3: Create Elementor Integration Class in Core Plugin

File: `wp-content/plugins/{theme}-core/inc/class-{theme}-elementor.php`

```php
<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Vagra_{Theme}_Elementor {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            return;
        }
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_styles' ] );
    }

    public function register_categories( $elements_manager ) {
        $elements_manager->add_category( '{theme-slug}', [
            'title' => __( '{Theme Name}', '{theme-text-domain}' ),
            'icon'  => 'eicon-site-logo',
        ] );
    }

    public function register_widgets( $widgets_manager ) {
        require_once {PLUGIN}_DIR . 'inc/elementor/class-widget-base.php';

        $widgets = [ 'hero', 'features', 'stats', 'testimonials', 'cta' ];
        foreach ( $widgets as $w ) {
            require_once {PLUGIN}_DIR . 'inc/elementor/widgets/' . $w . '.php';
        }

        // Register each widget instance
        $widgets_manager->register( new \Vagra{Theme}\Widgets\Hero() );
        // ... etc
    }

    public function editor_styles() {
        wp_enqueue_style(
            '{theme}-elementor-editor',
            {PLUGIN}_URL . 'assets/css/elementor-editor.css',
            [], '1.0.0'
        );
    }
}
```

Load it conditionally in the main plugin file:

```php
add_action( 'plugins_loaded', function () {
    if ( did_action( 'elementor/loaded' ) ) {
        require_once {PLUGIN}_DIR . 'inc/class-{theme}-elementor.php';
        Vagra_{Theme}_Elementor::instance();
    }
} );
```

---

## Step 4: Create Widget Base Class

File: `wp-content/plugins/{theme}-core/inc/elementor/class-widget-base.php`

```php
<?php
namespace Vagra{Theme}\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit;

abstract class {Theme}_Widget_Base extends \Elementor\Widget_Base {
    public function get_categories() {
        return [ '{theme-slug}' ];
    }
}
```

---

## Step 5: Create Individual Widgets

File: `wp-content/plugins/{theme}-core/inc/elementor/widgets/hero.php`

Each widget follows this pattern:

```php
<?php
namespace Vagra{Theme}\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit;

class Hero extends {Theme}_Widget_Base {

    public function get_name() { return 'vagra_{theme}_hero'; }
    public function get_title() { return __( 'Hero', '{text-domain}' ); }
    public function get_icon() { return 'eicon-header'; }

    protected function register_controls() {
        $this->start_controls_section( 'content_section', [
            'label' => __( 'Content', '{text-domain}' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'title', [
            'label'   => __( 'Title', '{text-domain}' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Default Title', '{text-domain}' ),
        ] );

        // Add more controls...

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        // Output section HTML using $s['title'], etc.
        ?>
        <section class="{theme}-hero">
            <h1><?php echo esc_html( $s['title'] ); ?></h1>
        </section>
        <?php
    }
}
```

**Common control types:**
- `TEXT` — single line text
- `TEXTAREA` — multi-line text
- `WYSIWYG` — rich text editor
- `URL` — link with target options
- `MEDIA` — image/file selector
- `REPEATER` — repeating field groups
- `SELECT` — dropdown
- `COLOR` — color picker
- `ICONS` — icon selector

---

## Step 6: Create Elementor JSON Demo Content

For each page that should be Elementor-editable, export or create a JSON structure.

Directory: `wp-content/themes/{theme}/demo-content/elementor/`

**JSON structure:**
```json
[
  {
    "id": "unique-id",
    "elType": "section",
    "settings": { "layout": "full_width" },
    "elements": [
      {
        "id": "col-id",
        "elType": "column",
        "settings": { "_column_size": 100 },
        "elements": [
          {
            "id": "widget-id",
            "elType": "widget",
            "widgetType": "vagra_{theme}_hero",
            "settings": {
              "title": "Default Hero Title",
              "subtitle": "Default subtitle text"
            }
          }
        ]
      }
    ]
  }
]
```

**Tip:** Build the page in Elementor editor first, then export via:
1. Elementor > Tools > Export Kit, or
2. Copy `_elementor_data` from `wp_postmeta` table

---

## Step 7: Update Demo Import Handler

File: `wp-content/themes/{theme}/inc/demo-import.php`

Add Elementor demo variant and after-import handler:

```php
// Add Elementor demo option
function {theme}_ocdi_import_files() {
    $demos = array(
        array(
            'import_file_name'             => __( 'Classic — PHP Templates', '{text-domain}' ),
            'local_import_file'            => get_template_directory() . '/demo-content/demo-content.xml',
            'local_import_customizer_file' => get_template_directory() . '/demo-content/customizer.json',
        ),
    );

    if ( did_action( 'elementor/loaded' ) ) {
        $demos[] = array(
            'import_file_name'             => __( 'Elementor — Visual Builder', '{text-domain}' ),
            'local_import_file'            => get_template_directory() . '/demo-content/demo-content.xml',
            'local_import_customizer_file' => get_template_directory() . '/demo-content/customizer.json',
            'import_notice'                => __( 'Converts key pages to Elementor.', '{text-domain}' ),
        );
    }

    return $demos;
}

// After import: inject Elementor data
function {theme}_ocdi_after_import( $selected_import ) {
    // ... set front page, menus ...

    $import_name = $selected_import['import_file_name'] ?? '';
    if ( stripos( $import_name, 'Elementor' ) !== false && did_action( 'elementor/loaded' ) ) {
        $dir = get_template_directory() . '/demo-content/elementor/';
        $pages = [
            'Home'    => 'home.json',
            'About'   => 'about.json',
            'Contact' => 'contact.json',
        ];
        $ver = defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.0.0';

        foreach ( $pages as $title => $json ) {
            $page = get_page_by_title( $title );
            $file = $dir . $json;
            if ( $page && file_exists( $file ) ) {
                $data = json_decode( file_get_contents( $file ), true );
                if ( is_array( $data ) ) {
                    update_post_meta( $page->ID, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
                    update_post_meta( $page->ID, '_elementor_edit_mode', 'builder' );
                    update_post_meta( $page->ID, '_wp_page_template', 'elementor_header_footer' );
                    update_post_meta( $page->ID, '_elementor_version', $ver );
                    update_post_meta( $page->ID, '_elementor_css', '' );
                }
            }
        }

        if ( class_exists( '\Elementor\Plugin' ) ) {
            \Elementor\Plugin::$instance->files_manager->clear_cache();
        }
    }
}
```

---

## Step 8: Add Elementor Badge on Showcase

In `wp-content/themes/vagra-showcase/front-page.php`, add the theme slug to the Elementor badge condition:

```php
<?php if ( in_array( $t['slug'], array( 'nslookup', 'legal', '{new-theme}' ), true ) ) : ?>
    <span class="theme-card-compat">...</span>
<?php endif; ?>
```

---

## Step 9: Recommend Elementor in TGM

In `wp-content/themes/{theme}/inc/tgm-init.php`, add Elementor to recommended plugins:

```php
array(
    'name'     => 'Elementor',
    'slug'     => 'elementor',
    'required' => false,
),
```

---

## File Structure Checklist

```
wp-content/themes/{theme}/
  inc/demo-import.php          [MODIFY] — add Elementor demo variant
  front-page.php               [MODIFY] — add Elementor detection
  page-about.php               [MODIFY] — add Elementor detection
  page-contact.php             [MODIFY] — add Elementor detection
  demo-content/
    elementor/                 [CREATE]
      home.json                [CREATE] — Elementor page data
      about.json               [CREATE]
      contact.json             [CREATE]

wp-content/plugins/{theme}-core/
  {theme}-core.php             [MODIFY] — load Elementor class
  inc/
    class-{theme}-elementor.php [CREATE] — integration class
    elementor/
      class-widget-base.php    [CREATE] — base widget
      widgets/
        hero.php               [CREATE]
        features.php           [CREATE]
        stats.php              [CREATE]
        testimonials.php       [CREATE]
        cta.php                [CREATE]
  assets/css/
    elementor-editor.css       [CREATE] — editor styles

wp-content/themes/vagra-showcase/
  front-page.php               [MODIFY] — add badge
```

---

## Verification

1. Activate Elementor plugin on the sub-site
2. Go to Appearance > Import Demo Data
3. Select "Elementor — Visual Builder" variant
4. Verify pages render correctly
5. Open each page in Elementor editor — widgets should be editable
6. Verify PHP template fallback still works when Elementor is deactivated
7. Check showcase site shows Elementor badge
