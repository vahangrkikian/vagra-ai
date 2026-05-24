# Master Task — DriveEase Car Rental WordPress Theme

## Title
Deliver DriveEase WordPress theme — car rental booking platform with multi-language, multi-currency, and AI chat

## Description

You are the **Theme Architect**, lead agent for the DriveEase project. Your job is to deliver a complete WordPress theme (`driveease`) that converts the static HTML prototype into a production WordPress theme with Custom Post Types, booking system, availability management, and AI chat.

### What is DriveEase?
A car rental booking platform for the Armenian market. Customers browse available vehicles, select dates and extras, complete booking, and receive confirmation. The business manages fleet, branches, and bookings through WordPress admin.

**Brand promise:** Easy, affordable car rental with multi-language (EN/HY) and multi-currency (USD/EUR/AMD) support. Professional fleet with 6 categories, 4 branch locations, online booking with real-time availability.

**Architecture:** WordPress PHP templates + vanilla JavaScript (no React, no build step). All interactivity via vanilla JS with AJAX calls to WordPress backend.

### Context Files (read ALL before starting)
- `C:/OSPanel/domains/vagraAI/docs/driveease-orchestration-plan.md` — phased delivery plan with 4 approval gates
- `C:/OSPanel/domains/vagraAI/docs/driveease-agent-roles.md` — your role and specialist roles
- `C:/OSPanel/domains/vagraAI/docs/wordpress-standards.md` — WordPress.org compliance rules
- `C:/OSPanel/domains/vagraAI/docs/ai-chat-spec.md` — chat component spec (adapt for car rental)

### Design Prototypes (read BEFORE writing any code)
- `C:/OSPanel/domains/vagraAI/DriveEase/car-rental-template.html` — homepage (hero, fleet grid, booking modal, chatbot, i18n, currency)
- `C:/OSPanel/domains/vagraAI/DriveEase/car-a1.html` — car detail page (gallery, specs, sidebar calculator, similar cars)
- `C:/OSPanel/domains/vagraAI/DriveEase/car-a2.html` — second car detail (same template, different data)
- `C:/OSPanel/domains/vagraAI/DriveEase/contact.html` — contact form + branch cards

### Pattern Reference (existing themes)
- `C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-msp/functions.php` — setup, enqueue, widget pattern
- `C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-msp/header.php` — header template pattern
- `C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-msp/footer.php` — footer template pattern
- `C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-msp/inc/class-vagra-chat.php` — chat class pattern

### Environment
- WordPress 6.9 installed at C:/OSPanel/domains/vagraAI/
- Site URL: vagraai.local
- WP-CLI available
- vagra-msp, vagra-legal, vagra-nslookup themes already exist as references
- Theme goes in: `wp-content/themes/driveease/`

### Execution Rules
1. Follow `driveease-orchestration-plan.md` exactly — Phase 0 → Gate 0 → Phase 1 → Gate 1 → Phase 2 → Gate 2 → Phase 3 → Gate 3
2. At each gate, **STOP** and report status. List what was completed, what works, what doesn't. Wait for human approval before proceeding.
3. When you need specialist work, create sub-issues and assign to the appropriate agent role
4. All theme code goes in `C:/OSPanel/domains/vagraAI/wp-content/themes/driveease/`
5. Follow WordPress coding standards — prefix `driveease_`, text domain `driveease`, escape, sanitize, translate
6. Do not install plugins. Do not modify wp-config.php. Do not touch the database directly.
7. **Pixel-perfect match** to the HTML prototypes. Read the source directly — all CSS is embedded in the HTML files.
8. Do NOT break any existing styles. Preserve responsive design, animations, hover effects exactly.

### Design System Quick Reference
- **Accent:** #e85d26 (orange) | **Accent Dark:** #c94d1a (hover)
- **Dark:** #1a1a2e (navy) | **Light BG:** #f7f7f9 | **Gray:** #6b7280
- **Border:** #e5e7eb | **Radius:** 12px | **Transition:** .25s ease
- **Font:** Inter 300–800 (Google Fonts)
- **Icons:** Font Awesome 6.5.0
- **Container:** 1200px max, 20px padding
- **Breakpoints:** 960px (tablet), 600px (mobile)
- **Nav height:** 68px, fixed, backdrop-filter blur(12px)
- **Card shadow:** 0 4px 24px rgba(0,0,0,.08)

### Theme File Structure (target)
```
wp-content/themes/driveease/
├── style.css                       # WordPress theme header (minimal CSS here)
├── functions.php                   # Setup, enqueues, includes
├── header.php                      # Dark navbar, lang/currency, mobile menu
├── footer.php                      # 4-col footer, includes modal + chat
├── front-page.php                  # Homepage (hero, fleet, why, how, testimonials)
├── single-driveease_car.php        # Car detail (gallery, specs, sidebar, similar)
├── archive-driveease_car.php       # Fleet grid with filters
├── page-contact.php                # Contact form + branches
├── page.php                        # Generic page fallback
├── 404.php                         # Not found
├── index.php                       # Ultimate fallback
├── sidebar.php                     # Widget area
├── screenshot.png                  # 1200×900
├── readme.txt                      # WP.org format
├── assets/
│   ├── css/
│   │   ├── main.css               # All shared CSS (from prototype <style>)
│   │   ├── single-car.css         # Car detail page CSS
│   │   ├── contact.css            # Contact page CSS
│   │   └── admin.css              # Admin panel styles
│   └── js/
│       ├── i18n.js                # EN/HY translation system
│       ├── currency.js            # USD/EUR/AMD conversion
│       ├── main.js                # Nav, gallery, filtering, calculator
│       ├── booking.js             # Modal wizard + AJAX submit
│       ├── chat.js                # Chatbot widget
│       └── contact.js             # Contact form AJAX
├── template-parts/
│   ├── booking-modal.php          # 3-step booking wizard
│   ├── driveease-chat.php         # Chat widget markup
│   └── content-none.php           # No results fallback
├── inc/
│   ├── class-driveease-cars.php       # CPT + meta registration
│   ├── class-driveease-bookings.php   # Booking CPT + meta
│   ├── class-driveease-branches.php   # Branch CPT + meta
│   ├── class-driveease-booking-handler.php  # AJAX + REST + availability
│   ├── class-driveease-admin.php      # Meta boxes + admin columns + dashboard
│   ├── class-driveease-emails.php     # Email notifications
│   ├── class-driveease-chat.php       # AI chat REST API
│   ├── chat-prompts/driveease.txt     # Chat system prompt
│   └── demo-import.php               # Demo content importer
├── demo-content/
│   ├── demo-content.xml           # WXR with 12 cars, 4 branches, pages
│   └── customizer.json            # Theme settings
└── languages/
    └── driveease.pot              # Translation template
```

### CPT & Meta Field Reference

**driveease_car** (slug: `car`, archive: `fleet`):
| Meta Key | Type | Values |
|----------|------|--------|
| _car_year | string | "2024" |
| _car_price_per_day | number | 45 |
| _car_seats | integer | 5 |
| _car_doors | integer | 4 |
| _car_transmission | string | Manual / Automatic |
| _car_fuel_type | string | Petrol / Diesel / Electric / Hybrid |
| _car_engine | string | "1.6L Turbo" |
| _car_mileage_limit | string | "Unlimited" / "300km/day" |
| _car_trunk_capacity | string | "420L" |
| _car_air_conditioning | boolean | true/false |
| _car_gps_included | boolean | true/false |
| _car_bluetooth | boolean | true/false |
| _car_usb_charging | boolean | true/false |
| _car_cruise_control | boolean | true/false |
| _car_backup_camera | boolean | true/false |
| _car_gallery | array | [attachment_id, ...] |
| _car_featured | boolean | true/false |
| _car_availability_status | string | Available / Rented / Maintenance |

**driveease_booking** (admin-only, no public archive):
| Meta Key | Type | Values |
|----------|------|--------|
| _booking_reference | string | "DE-A3X9K2" |
| _booking_car_id | integer | post ID |
| _booking_pickup_location | string | branch name |
| _booking_dropoff_location | string | branch name |
| _booking_pickup_date | string | "2026-05-15T10:00" |
| _booking_dropoff_date | string | "2026-05-18T10:00" |
| _booking_customer_name | string | |
| _booking_customer_email | string | |
| _booking_customer_phone | string | |
| _booking_driver_license | string | |
| _booking_extras | string | JSON: [{"name":"GPS","price":8},...]|
| _booking_total_price | number | 189 |
| _booking_currency | string | USD / EUR / AMD |
| _booking_status | string | Pending/Confirmed/Active/Completed/Cancelled |
| _booking_payment_status | string | Pending / Paid / Refunded |

**driveease_branch** (slug: `branch`):
| Meta Key | Type | Values |
|----------|------|--------|
| _branch_address | string | "12 Main Boulevard" |
| _branch_phone | string | "+374 XX XXX XXX" |
| _branch_email | string | "city@driveease.am" |
| _branch_hours_weekday | string | "08:00–20:00" |
| _branch_hours_weekend | string | "09:00–18:00" |
| _branch_is_24h | boolean | true/false |
| _branch_latitude | string | "40.1792" |
| _branch_longitude | string | "44.4991" |
