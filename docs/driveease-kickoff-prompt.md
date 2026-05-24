# DriveEase — Theme Architect Kick-Off Prompt
> Copy this entire block into Paperclip as the Theme Architect's first issue.

---

## Title
[ORCHESTRATOR] DriveEase — Plan all work and create agent tasks

## Description

You are the **Theme Architect**, lead orchestrator for the DriveEase car rental WordPress theme project.

**Your first job is NOT to write code.** Your first job is to:

1. Read all context files listed below
2. Create sub-issues (tasks) for every agent, for every phase
3. Set dependencies between tasks
4. Then start your own Phase 0 work

### Step 1: Read these files (in order)
```
C:/OSPanel/domains/vagraAI/docs/driveease-orchestration-plan.md
C:/OSPanel/domains/vagraAI/docs/driveease-agent-roles.md
C:/OSPanel/domains/vagraAI/docs/wordpress-standards.md
C:/OSPanel/domains/vagraAI/docs/ai-chat-spec.md
C:/OSPanel/domains/vagraAI/DriveEase/car-rental-template.html
C:/OSPanel/domains/vagraAI/DriveEase/car-a1.html
C:/OSPanel/domains/vagraAI/DriveEase/car-a2.html
C:/OSPanel/domains/vagraAI/DriveEase/contact.html
```

### Step 2: Create these sub-issues

Create one issue per task below. Each issue must include:
- **Title** — short, starts with agent name in brackets
- **Assigned to** — the agent name
- **Blocked by** — which issues must complete first
- **Description** — what to build, which source files to read, what the output files are, acceptance criteria

---

#### PHASE 0 — Foundation (Theme Architect solo)

**Issue 0.1: [Theme Architect] Scaffold theme directory + style.css + functions.php**
- Assigned to: Theme Architect
- Blocked by: nothing
- Description:
  - Create `wp-content/themes/driveease/` directory
  - Create `style.css`: WordPress theme header (Theme Name: DriveEase, Theme URI, Author: vagra.ai, Description: Car rental booking theme with multi-language and multi-currency support, Version: 1.0.0, Text Domain: driveease, Requires at least: 6.0, Tested up to: 6.9, Requires PHP: 7.4)
  - Extract CSS from `DriveEase/car-rental-template.html` `<style>` block into `assets/css/main.css`
  - Extract car detail CSS from `DriveEase/car-a1.html` into `assets/css/single-car.css`
  - Extract contact CSS from `DriveEase/contact.html` into `assets/css/contact.css`
  - Create `functions.php`:
    - Define `DRIVEEASE_VERSION` constant
    - `driveease_setup()` on `after_setup_theme`: add_theme_support (title-tag, post-thumbnails, html5, custom-logo, customize-selective-refresh-widgets), register_nav_menus (primary, footer)
    - `driveease_scripts()` on `wp_enqueue_scripts`: enqueue Google Fonts (Inter 300-800), Font Awesome 6.5.0, main.css, conditional single-car.css / contact.css, main.js
    - `driveease_widgets_init()`: register sidebar-1, footer-1, footer-2, footer-3
  - Create `inc/` directory for classes
  - Prefix all functions `driveease_`, text domain `driveease`
  - Output: `style.css`, `functions.php`, `assets/css/main.css`, `assets/css/single-car.css`, `assets/css/contact.css`

**Issue 0.2: [Theme Architect] Register CPT 'driveease_car' with meta fields + taxonomy**
- Assigned to: Theme Architect
- Blocked by: 0.1
- Description:
  - Create `inc/class-driveease-cars.php`
  - Register CPT `driveease_car`:
    - Labels: Car/Cars
    - Public: true, has_archive: true (slug: `fleet`)
    - Supports: title, editor, thumbnail, excerpt
    - Menu icon: `dashicons-car`
    - Rewrite slug: `car`
  - Register taxonomy `car_category`:
    - Hierarchical: true
    - Default terms: Economy, Sedan, SUV, Luxury, Compact, Minivan
    - Rewrite slug: `car-category`
  - Register all meta fields via `register_post_meta('driveease_car', ...)`:
    - `_car_year` — string, show_in_rest: true
    - `_car_price_per_day` — number, show_in_rest: true
    - `_car_seats` — integer, show_in_rest: true
    - `_car_doors` — integer, show_in_rest: true
    - `_car_transmission` — string (Manual/Automatic), show_in_rest: true
    - `_car_fuel_type` — string (Petrol/Diesel/Electric/Hybrid), show_in_rest: true
    - `_car_engine` — string, show_in_rest: true
    - `_car_mileage_limit` — string, show_in_rest: true
    - `_car_trunk_capacity` — string, show_in_rest: true
    - `_car_air_conditioning` — boolean, show_in_rest: true
    - `_car_gps_included` — boolean, show_in_rest: true
    - `_car_bluetooth` — boolean, show_in_rest: true
    - `_car_usb_charging` — boolean, show_in_rest: true
    - `_car_cruise_control` — boolean, show_in_rest: true
    - `_car_backup_camera` — boolean, show_in_rest: true
    - `_car_gallery` — array of attachment IDs, show_in_rest: true (use schema for array)
    - `_car_featured` — boolean, show_in_rest: true
    - `_car_availability_status` — string (Available/Rented/Maintenance), show_in_rest: true
  - Include class in functions.php
  - Output: `inc/class-driveease-cars.php`

**Issue 0.3: [Theme Architect] Register CPT 'driveease_booking' with meta fields**
- Assigned to: Theme Architect
- Blocked by: 0.1
- Description:
  - Create `inc/class-driveease-bookings.php`
  - Register CPT `driveease_booking`:
    - Labels: Booking/Bookings
    - Public: false, show_ui: true, show_in_menu: true
    - Supports: title (auto-generated)
    - Menu icon: `dashicons-calendar-alt`
    - Capability type: post
  - Register all meta fields via `register_post_meta('driveease_booking', ...)`:
    - `_booking_reference` — string
    - `_booking_car_id` — integer
    - `_booking_pickup_location` — string
    - `_booking_dropoff_location` — string
    - `_booking_pickup_date` — string (ISO datetime)
    - `_booking_dropoff_date` — string (ISO datetime)
    - `_booking_customer_name` — string
    - `_booking_customer_email` — string
    - `_booking_customer_phone` — string
    - `_booking_driver_license` — string
    - `_booking_extras` — string (JSON serialized array)
    - `_booking_total_price` — number
    - `_booking_currency` — string (USD/EUR/AMD)
    - `_booking_status` — string (Pending/Confirmed/Active/Completed/Cancelled)
    - `_booking_payment_status` — string (Pending/Paid/Refunded)
  - Auto-generate title on save: "DE-XXXXXX — Customer Name"
  - Include class in functions.php
  - Output: `inc/class-driveease-bookings.php`

**Issue 0.4: [Theme Architect] Register CPT 'driveease_branch' with meta fields**
- Assigned to: Theme Architect
- Blocked by: 0.1
- Description:
  - Create `inc/class-driveease-branches.php`
  - Register CPT `driveease_branch`:
    - Labels: Branch/Branches
    - Public: true, has_archive: false
    - Supports: title, editor, thumbnail
    - Menu icon: `dashicons-location`
    - Rewrite slug: `branch`
  - Register meta fields:
    - `_branch_address` — string, show_in_rest: true
    - `_branch_phone` — string, show_in_rest: true
    - `_branch_email` — string, show_in_rest: true
    - `_branch_hours_weekday` — string, show_in_rest: true
    - `_branch_hours_weekend` — string, show_in_rest: true
    - `_branch_is_24h` — boolean, show_in_rest: true
    - `_branch_latitude` — string, show_in_rest: true
    - `_branch_longitude` — string, show_in_rest: true
  - Include class in functions.php
  - Output: `inc/class-driveease-branches.php`

**Issue 0.5: [Theme Architect] Core template files**
- Assigned to: Theme Architect
- Blocked by: 0.1
- Description:
  - Create minimal templates that load correctly:
    - `index.php` — fallback (loop with article list)
    - `header.php` — `<!DOCTYPE html>`, wp_head(), navbar placeholder
    - `footer.php` — footer placeholder, wp_footer()
    - `404.php` — styled 404 page
    - `page.php` — generic page template
    - `sidebar.php` — dynamic_sidebar('sidebar-1')
  - Verify: theme activates without errors via WP-CLI `wp theme activate driveease`
  - Output: 6 template files

---

#### PHASE 1 — Templates & UI (Theme Architect solo)

**Issue 1.1: [Theme Architect] Header template — navbar with i18n + currency**
- Assigned to: Theme Architect
- Blocked by: 0.5
- Description:
  - `header.php`: Full navbar from `DriveEase/car-rental-template.html` lines 1-50:
    - Fixed position, dark background with backdrop-filter blur
    - Logo: `Drive<span>Ease</span>` linking to home_url()
    - `wp_nav_menu('primary')` with walker for `.nav-links` class
    - Language switch buttons (EN | HY) with `data-i18n` integration
    - Currency dropdown (USD/EUR/AMD) with `.curr-wrap` markup
    - Mobile hamburger button + `.mobile-menu` panel
    - CTA button "Book Now" linking to booking modal trigger
  - All text strings wrapped in `esc_html__('...', 'driveease')`
  - Output: `header.php`

**Issue 1.2: [Theme Architect] Footer template**
- Assigned to: Theme Architect
- Blocked by: 0.5
- Description:
  - `footer.php`: Dark footer from prototype:
    - 4-column grid: About (logo + description), Quick Links (wp_nav_menu 'footer'), Our Branches (WP_Query driveease_branch, list names), Contact Info (phone, email)
    - Social icons row (Facebook, Instagram, Twitter, LinkedIn)
    - Copyright bar with year
    - Include `get_template_part('template-parts/booking-modal')`
    - Include `get_template_part('template-parts/driveease-chat')`
    - `wp_footer()` before closing `</body>`
  - Port from: `DriveEase/car-rental-template.html` footer section
  - Output: `footer.php`

**Issue 1.3: [Theme Architect] Homepage template (front-page.php)**
- Assigned to: Theme Architect
- Blocked by: 1.1, 1.2
- Description:
  - `front-page.php` — homepage matching `DriveEase/car-rental-template.html`:
    1. **Hero section**: full-width background image, gradient overlay, heading "Premium Car Rental", subtitle, inline booking search form (pickup location dropdown from branches, pickup date, dropoff date, "Search" button that opens modal)
    2. **Fleet section**: `.section-label` "Our Fleet" + `.section-title`, category filter buttons from `car_category` taxonomy terms, then car grid:
       ```php
       $cars = new WP_Query(['post_type' => 'driveease_car', 'posts_per_page' => 12, 'meta_key' => '_car_featured', 'meta_value' => '1']);
       ```
       Each car rendered as `.car-card` with `data-category`, `data-name`, `data-price` attributes. Card shows: thumbnail, category badge, title, class+year, price/day, "Details" link to single car, "Book" button triggers modal.
    3. **Why DriveEase section**: 4 cards (icon + title + text) — Wide Selection, Best Prices, 24/7 Support, Easy Booking
    4. **How It Works section**: 3 numbered steps — Choose a Car, Pick Date & Location, Drive Away
    5. **Testimonials section**: 3 testimonial cards (quote, name, rating stars)
  - All section markup must match prototype CSS classes exactly
  - Output: `front-page.php`

**Issue 1.4: [Theme Architect] Single car template (single-driveease_car.php)**
- Assigned to: Theme Architect
- Blocked by: 1.1, 1.2
- Description:
  - `single-driveease_car.php` — car detail page matching `DriveEase/car-a1.html`:
    1. **Breadcrumb bar**: Home > Fleet > {car title}
    2. **Gallery section**: `.main-img-wrap` with featured image + `.thumbs` row from `_car_gallery` meta. First image = main, rest = thumbnails. Click thumbnail swaps main image (JS handled separately).
    3. **Detail layout** (2-column: `.detail-main` + `.sidebar`):
       - Main column:
         - Car title + category badge + year
         - **Specs grid** (2-col): Seats, Doors, Transmission, Fuel Type, Engine, Mileage Limit, Trunk, A/C — all from meta fields
         - **Included features**: checkmark list of boolean meta fields that are true (GPS, Bluetooth, USB, Cruise Control, Backup Camera)
       - Sidebar (`.sticky`):
         - Price display: `$XX/day` from `_car_price_per_day`
         - Date inputs: pickup date, dropoff date
         - Extras checkboxes: GPS Navigation $8/day, Child Seat $12/day, Wi-Fi Hotspot $6/day, Premium Insurance $18/day
         - Total calculator display
         - "Book This Car" button → opens modal pre-filled with this car
    4. **Similar vehicles**: WP_Query same `car_category`, exclude current post, limit 2, render as mini car cards
  - Output: `single-driveease_car.php`

**Issue 1.5: [Theme Architect] Fleet archive template**
- Assigned to: Theme Architect
- Blocked by: 1.1, 1.2
- Description:
  - `archive-driveease_car.php`:
    - Hero banner: "Our Fleet" title + subtitle
    - Category filter buttons (same as homepage)
    - Full car grid (all cars, not just featured)
    - Pagination via `the_posts_pagination()`
  - Reuse same `.car-card` markup as homepage
  - Output: `archive-driveease_car.php`

**Issue 1.6: [Theme Architect] Contact page template**
- Assigned to: Theme Architect
- Blocked by: 1.1, 1.2
- Description:
  - `page-contact.php` (Template Name: Contact) matching `DriveEase/contact.html`:
    1. **Contact form**: name, email, phone, subject (dropdown: General, Booking Issue, Fleet Question, Feedback), message textarea, submit button. Form action via AJAX.
    2. **Contact info cards**: 4 cards (Phone, Email, Head Office, Working Hours) with icons
    3. **Branch cards section**: WP_Query `driveease_branch`, each card shows: title, address, phone, hours (weekday + weekend), 24h badge if applicable, map placeholder div
    4. **Success notification banner** (hidden by default, shown on submit)
  - Output: `page-contact.php`

**Issue 1.7: [Theme Architect] Booking modal template part**
- Assigned to: Theme Architect
- Blocked by: 0.4
- Description:
  - `template-parts/booking-modal.php`:
    - `.modal-overlay` + `.modal` container
    - Step indicator (3 dots/labels: Rental Details, Personal Info, Extras & Payment)
    - **Step 1 — Rental Details**:
      - Car display (thumbnail + name + price, auto-filled if opened from car page)
      - Pickup location: `<select>` populated from `driveease_branch` posts
      - Dropoff location: same select
      - Pickup date: `<input type="date">`
      - Dropoff date: `<input type="date">`
    - **Step 2 — Personal Info**:
      - Full name, Email, Phone, Driver's License number
      - All with `.form-group` + `.field-error` pattern
    - **Step 3 — Extras & Payment**:
      - Extras checkboxes: GPS ($8/day), Child Seat ($12/day), Wi-Fi ($6/day), Premium Insurance ($18/day)
      - Price summary (base + extras × days = total)
      - Payment form: Card number (16 digits), Expiry (MM/YY), CVV
    - **Confirmation screen**: checkmark icon, "Booking Confirmed!", reference number, summary
    - Close button (X) on modal
  - Branch data passed via `wp_localize_script` or inline `<script>` with PHP data
  - Output: `template-parts/booking-modal.php`

**Issue 1.8: [Theme Architect] Chat widget template part**
- Assigned to: Theme Architect
- Blocked by: 0.1
- Description:
  - `template-parts/driveease-chat.php`:
    - `.chat-widget` floating button (bottom-right corner, bounce animation)
    - `#chat-panel`: header bar (title + close button), messages container, input row (text input + send button)
    - Quick reply buttons row (on homepage: "Book a car", "View rates", "Our branches", "What's included")
    - Markup matches prototype chatbot exactly
  - Output: `template-parts/driveease-chat.php`

---

#### PHASE 2 — Interactive & Backend (Multi-agent)

**Issue 2.1: [Theme Architect] Enqueue and localize all JavaScript**
- Assigned to: Theme Architect
- Blocked by: 1.3, 1.4, 1.6
- Description:
  - Update `functions.php` `driveease_scripts()`:
    - Enqueue `assets/js/i18n.js` — i18n translations object
    - Enqueue `assets/js/currency.js` — currency conversion
    - Enqueue `assets/js/main.js` — nav, fleet filtering, gallery
    - Enqueue `assets/js/booking.js` — modal wizard, AJAX submit (depends on main.js)
    - Enqueue `assets/js/chat.js` — chatbot widget
    - Conditional: `assets/js/contact.js` on contact page only
  - `wp_localize_script('driveease-main', 'driveease_data', [...])` passing:
    - `ajax_url` → admin_url('admin-ajax.php')
    - `nonce` → wp_create_nonce('driveease_nonce')
    - `branches` → array of branch posts (id, title, address)
    - `currency_rates` → ['USD' => 1, 'EUR' => 0.92, 'AMD' => 387]
    - `i18n` → translation strings array (from PHP for SSR fallback)
    - `is_single_car` → boolean
    - `car_data` → if single car: {id, name, price, category} (for modal pre-fill)
  - Output: updated `functions.php`

**Issue 2.2: [WP Admin] Booking AJAX endpoint + availability check**
- Assigned to: WP Admin Specialist
- Blocked by: 0.3, 0.4
- Description:
  - Create `inc/class-driveease-booking-handler.php`:
    - Hook `wp_ajax_driveease_submit_booking` + `wp_ajax_nopriv_driveease_submit_booking`
    - Verify nonce
    - Sanitize all inputs (sanitize_text_field, sanitize_email, absint)
    - **Availability check**: WP_Query bookings for same car_id where dates overlap (pickup < existing_dropoff AND dropoff > existing_pickup) and status not Cancelled
    - If unavailable: return JSON error "Car not available for selected dates"
    - If available: create `driveease_booking` post, set all meta, generate reference (DE- + 6 random alphanumeric)
    - Send confirmation email via `wp_mail()` to customer
    - Return JSON: `{success: true, reference: 'DE-XXXXXX'}`
  - Output: `inc/class-driveease-booking-handler.php`

**Issue 2.3: [WP Admin] Availability REST API endpoint**
- Assigned to: WP Admin Specialist
- Blocked by: 0.3
- Description:
  - In booking handler class, register REST route:
    - `GET /wp-json/driveease/v1/availability/(?P<car_id>\d+)`
    - Optional param: `month` (YYYY-MM)
    - Returns array of `{start: 'YYYY-MM-DD', end: 'YYYY-MM-DD'}` for booked periods
    - Only returns bookings with status: Pending, Confirmed, Active
  - Output: REST route in `inc/class-driveease-booking-handler.php`

**Issue 2.4: [WP Admin] Admin meta boxes for Car, Booking, Branch**
- Assigned to: WP Admin Specialist
- Blocked by: 0.2, 0.3, 0.4
- Description:
  - Create `inc/class-driveease-admin.php`:
  - **Car meta box** ("Car Details"):
    - Specs section: year, seats, doors, transmission (dropdown), fuel type (dropdown), engine, mileage limit, trunk capacity
    - Features section: checkboxes for A/C, GPS, Bluetooth, USB, Cruise Control, Backup Camera
    - Pricing: price per day (number input), availability status (dropdown)
    - Gallery: media uploader for multiple images (store as comma-separated IDs)
    - Featured: checkbox
  - **Booking meta box** ("Booking Details"):
    - Read-only display: reference, car (link to car edit), customer name/email/phone, license, pickup/dropoff locations + dates, extras list, total, currency
    - Editable: status dropdown, payment status dropdown
  - **Branch meta box** ("Branch Details"):
    - Address, phone, email, weekday hours, weekend hours, 24h checkbox, lat/lng
  - All fields with proper nonce, sanitize on save
  - Output: `inc/class-driveease-admin.php`

**Issue 2.5: [AI Integration] JavaScript — i18n + currency + nav + filtering**
- Assigned to: AI Integration Specialist
- Blocked by: 2.1
- Description:
  - Create `assets/js/i18n.js`:
    - Translation dictionary (150+ keys) for EN and HY
    - `setLang(lang)` function: update all `[data-i18n]` elements, save to localStorage `de_lang`
    - Auto-apply saved language on page load
  - Create `assets/js/currency.js`:
    - `setCurrency(curr)` function: update all `[data-price]` elements with converted values
    - `fmtP(usdAmount, currency)` — format price with correct symbol/locale
    - Save to localStorage `de_curr`, auto-apply on load
  - Create `assets/js/main.js`:
    - Mobile hamburger toggle
    - Currency dropdown open/close
    - Fleet category filtering: click `.filter-btn` → show/hide `.car-card` by `data-category`
    - Smooth scroll for anchor links
    - Car detail gallery: click `.thumb` → swap `.main-img-wrap img` src
    - Sidebar price calculator: listen to date inputs + extras checkboxes → compute total
  - Port from: `DriveEase/car-rental-template.html` lines 662-948 and `DriveEase/car-a1.html` lines 367-461
  - Output: `assets/js/i18n.js`, `assets/js/currency.js`, `assets/js/main.js`

**Issue 2.6: [AI Integration] JavaScript — booking modal wizard**
- Assigned to: AI Integration Specialist
- Blocked by: 2.1, 2.2
- Description:
  - Create `assets/js/booking.js`:
    - Open modal: triggered by "Book Now" buttons, pre-fill car data if from single car page
    - Step navigation: Next/Back buttons, validate current step before advancing
    - Step 1 validation: all fields required, dropoff date > pickup date
    - Step 2 validation: name required, valid email, phone required, license required
    - Step 3: extras selection updates price summary dynamically
    - Payment form: card number formatting (groups of 4), expiry MM/YY, CVV 3 digits
    - Submit via `fetch()` to `driveease_data.ajax_url` with action `driveease_submit_booking`
    - On success: show confirmation step with reference number
    - On error: show inline error message
    - Close modal: X button or overlay click
    - Fetch availability on car selection: disable booked dates in date inputs
  - Port from: `DriveEase/car-rental-template.html` booking modal JS (lines 824-913)
  - Output: `assets/js/booking.js`

**Issue 2.7: [AI Integration] JavaScript — contact form + chatbot**
- Assigned to: AI Integration Specialist
- Blocked by: 2.1
- Description:
  - Create `assets/js/contact.js`:
    - Form validation (per-field errors)
    - AJAX submit to `admin-ajax.php` action `driveease_contact`
    - Show success banner on completion
    - Reset form after success
  - Create `assets/js/chat.js`:
    - Toggle chat panel open/close
    - Send message on Enter or button click
    - Typing indicator animation
    - Keyword-based responses: "book" → booking info, "price/rate" → pricing info, "branch/location" → branch list, "include" → included features
    - Quick reply buttons (homepage only)
    - Timestamp on messages
    - Auto-scroll to latest message
  - Port from: prototype chatbot JS
  - Output: `assets/js/contact.js`, `assets/js/chat.js`

**Issue 2.8: [AI Integration] Chat widget backend class**
- Assigned to: AI Integration Specialist
- Blocked by: 0.1
- Description:
  - Create `inc/class-driveease-chat.php` (adapt from `vagra-msp/inc/class-vagra-chat.php`):
    - Register REST route: `POST /wp-json/driveease/v1/chat`
    - Rate limiting: 20 requests/minute per IP (transient-based)
    - System prompt for car rental context (stored in `inc/chat-prompts/driveease.txt`)
    - Proxy to Claude API if API key configured in Customizer
    - Fallback to keyword-based responses if no API key
    - Customizer settings: enable/disable, API key, custom system prompt
  - Output: `inc/class-driveease-chat.php`, `inc/chat-prompts/driveease.txt`

---

#### PHASE 3 — Admin & Content (Multi-agent)

**Issue 3.1: [WP Admin] Admin dashboard enhancements**
- Assigned to: WP Admin Specialist
- Blocked by: 2.2, 2.4
- Description:
  - Update `inc/class-driveease-admin.php`:
  - **Custom columns for Bookings list**:
    - Reference, Car (linked), Customer, Pickup Date, Dropoff Date, Status (color-coded badge), Total
    - Sortable by date and status
  - **Quick actions**: row actions to change status (Confirm, Complete, Cancel)
  - **Dashboard widget** (`wp_dashboard_setup`):
    - Today's Pickups count + list
    - Today's Returns count + list
    - Pending Bookings count
    - This week's revenue total
  - **CSV Export**: admin page under Bookings menu, filter by date range, export all booking fields
  - Output: updated `inc/class-driveease-admin.php`

**Issue 3.2: [WP Admin] Email notification templates**
- Assigned to: WP Admin Specialist
- Blocked by: 2.2
- Description:
  - Create `inc/class-driveease-emails.php`:
  - **Booking Confirmation**: HTML email with logo, reference number, car name, dates, pickup location, extras, total price, contact info
  - **Booking Reminder**: sent 1 day before pickup (needs wp-cron event), includes pickup location, car details, reference
  - **Booking Cancellation**: sent when status changed to Cancelled, includes reference and refund info
  - All emails use `wp_mail()` with `text/html` content type
  - Template uses inline CSS for email client compatibility
  - Hook into booking status changes to trigger appropriate email
  - Output: `inc/class-driveease-emails.php`

**Issue 3.3: [Demo Content] Create demo import data**
- Assigned to: Demo Content Writer
- Blocked by: 2.4
- Description:
  - Create `demo-content/demo-content.xml` (WordPress eXtended RSS):
    - **12 Cars** matching prototype fleet:
      - Economy: Car Model A1 ($45/day), Car Model A2 ($52/day)
      - Sedan: Car Model B1 ($65/day), Car Model B2 ($75/day)
      - SUV: Car Model C1 ($89/day), Car Model C2 ($99/day)
      - Luxury: Car Model D1 ($149/day), Car Model D2 ($179/day)
      - Compact: Car Model E1 ($38/day), Car Model E2 ($44/day)
      - Minivan: Car Model F1 ($110/day), Car Model F2 ($125/day)
    - Each car with full meta: seats (4-8), doors (2-5), transmission, fuel, engine, features
    - **4 Branches**: City Center, Airport Terminal 1, North District, Harbor — with hours, address, coordinates
    - **Pages**: Home (front page), Fleet, Contact (with contact template), About
    - **3 Testimonials** (can be page or custom content)
    - **Primary menu**: Home, Fleet, About, Contact
  - Create `demo-content/customizer.json`: static front page setting, menus
  - Create `inc/demo-import.php`: one-click demo import handler in admin (Appearance > Import Demo)
  - Output: `demo-content/demo-content.xml`, `demo-content/customizer.json`, `inc/demo-import.php`

**Issue 3.4: [Theme Architect] Final polish + WordPress.org compliance**
- Assigned to: Theme Architect
- Blocked by: 3.1, 3.2, 3.3
- Description:
  - Create `screenshot.png` (1200×900) — can use placeholder or describe for design
  - Create `readme.txt` in WordPress.org format:
    - Description, installation steps, FAQ, changelog, credits
  - Create `languages/driveease.pot` — translation template from all `__()` calls
  - Run Theme Check validation, fix any issues
  - Accessibility: ensure focus-visible states, ARIA labels on interactive elements, keyboard navigation for modal
  - Performance: add `loading="lazy"` to images, ensure no render-blocking scripts
  - Final visual QA: compare every page to prototype HTML, fix any CSS mismatches
  - Output: `screenshot.png`, `readme.txt`, `languages/driveease.pot`

---

### Step 3: Set dependencies and start Phase 0

After creating all issues:
1. Set `blocked_by` relationships as specified above
2. Begin working on **Issue 0.1** immediately
3. Once 0.1 is done, work on 0.2, 0.3, 0.4, 0.5 in parallel
4. Report at **Gate 0** when all Phase 0 issues are complete

---

### Environment
- WordPress 6.9 installed at `C:/OSPanel/domains/vagraAI/`
- Site URL: vagraai.local
- WP-CLI available
- Theme goes in: `wp-content/themes/driveease/`
- Prototype source: `C:/OSPanel/domains/vagraAI/DriveEase/` (4 HTML files, read-only)
- Pattern reference: `wp-content/themes/vagra-msp/` (existing working theme)

### Execution Rules
1. Follow `driveease-orchestration-plan.md` exactly — Phase 0 → Gate 0 → Phase 1 → Gate 1 → Phase 2 → Gate 2 → Phase 3 → Gate 3
2. At each gate, **STOP** and report status. List what was completed, what works, what doesn't. Wait for human approval before proceeding.
3. When you need specialist work, create sub-issues and assign to the appropriate agent role (see `driveease-agent-roles.md`)
4. All theme code goes in `C:/OSPanel/domains/vagraAI/wp-content/themes/driveease/`
5. Follow WordPress coding standards — prefix `driveease_`, text domain `driveease`, escape all output, sanitize all input, use nonces
6. Do not install plugins. Do not modify wp-config.php. Do not touch the database directly.
7. **Pixel-perfect match** to the HTML prototypes. Read the source HTML/CSS directly — all dimensions, colors, and layout rules are in the code. Do not break any styles.
8. Preserve ALL existing UI: responsive breakpoints (960px, 600px), animations, hover effects, modal behavior, chatbot widget, i18n, multi-currency.
