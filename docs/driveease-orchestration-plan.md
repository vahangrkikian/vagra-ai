# Orchestration Plan — DriveEase Car Rental Theme Delivery

## Overview
This plan delivers the `driveease` WordPress theme (car rental booking platform) through four phases with approval gates. The theme converts a static HTML/CSS/JS prototype into a fully functional WordPress theme with Custom Post Types, booking system, availability management, and AI chat. Agents work autonomously between gates. Founders review at each gate.

## Design Source
All prototypes live at `C:/OSPanel/domains/vagraAI/DriveEase/`. Four HTML files contain the complete UI:
- `car-rental-template.html` — homepage (fleet grid, hero, booking modal, chatbot)
- `car-a1.html` / `car-a2.html` — car detail pages (gallery, specs, sidebar calculator)
- `contact.html` — contact form + branch locations

## Agents
1. **Theme Architect** (lead) — PHP templates, CSS, theme infrastructure, CPT registration, WP compliance
2. **WP Admin Specialist** — Booking system backend, admin dashboard, email notifications
3. **AI Integration Specialist** — Chat widget (adapted from vagra-msp pattern), JS interactivity
4. **Demo Content Writer** — Sample cars, branches, testimonials, demo import XML

---

## Phase 0: Foundation (→ Gate 0)

### 0.1 — Theme Architect: Create theme scaffold
- Create `wp-content/themes/driveease/` directory structure
- `style.css` with WordPress theme headers + CSS from `DriveEase/car-rental-template.html` `<style>` block
- `functions.php`: DRIVEEASE_VERSION, driveease_setup(), driveease_scripts(), menu/widget registration
- All functions prefixed `driveease_`, text domain `driveease`
- Register nav menus: primary, footer
- Register widget areas: sidebar-1, footer-1, footer-2, footer-3

### 0.2 — Theme Architect: Register CPT 'car' and taxonomy
- CPT `driveease_car` with supports: title, editor, thumbnail, excerpt
- Taxonomy `car_category` (Economy, Sedan, SUV, Luxury, Compact, Minivan)
- Meta fields (registered via `register_post_meta`):
  - `_car_year` (string) — model year
  - `_car_price_per_day` (number) — base USD price
  - `_car_seats` (integer) — passenger count
  - `_car_doors` (integer)
  - `_car_transmission` (string) — Manual/Automatic
  - `_car_fuel_type` (string) — Petrol/Diesel/Electric/Hybrid
  - `_car_engine` (string) — e.g. "1.6L Turbo"
  - `_car_mileage_limit` (string) — "Unlimited" or "300km/day"
  - `_car_trunk_capacity` (string) — e.g. "420L"
  - `_car_air_conditioning` (boolean)
  - `_car_gps_included` (boolean)
  - `_car_bluetooth` (boolean)
  - `_car_usb_charging` (boolean)
  - `_car_cruise_control` (boolean)
  - `_car_backup_camera` (boolean)
  - `_car_gallery` (array) — attachment IDs for gallery images
  - `_car_featured` (boolean) — show on homepage
  - `_car_availability_status` (string) — Available/Rented/Maintenance

### 0.3 — Theme Architect: Register CPT 'booking'
- CPT `driveease_booking` with supports: title (auto-generated reference)
- Not public (admin-only), no archive
- Meta fields:
  - `_booking_reference` (string) — auto "DE-XXXXXX"
  - `_booking_car_id` (integer) — linked car post ID
  - `_booking_pickup_location` (string)
  - `_booking_dropoff_location` (string)
  - `_booking_pickup_date` (string) — ISO datetime
  - `_booking_dropoff_date` (string) — ISO datetime
  - `_booking_customer_name` (string)
  - `_booking_customer_email` (string)
  - `_booking_customer_phone` (string)
  - `_booking_driver_license` (string)
  - `_booking_extras` (array) — selected extras with prices
  - `_booking_total_price` (number)
  - `_booking_currency` (string) — USD/EUR/AMD
  - `_booking_status` (string) — Pending/Confirmed/Active/Completed/Cancelled
  - `_booking_payment_status` (string) — Pending/Paid/Refunded

### 0.4 — Theme Architect: Register CPT 'branch'
- CPT `driveease_branch` with supports: title, editor, thumbnail
- Meta fields:
  - `_branch_address` (string)
  - `_branch_phone` (string)
  - `_branch_email` (string)
  - `_branch_hours_weekday` (string) — e.g. "08:00–20:00"
  - `_branch_hours_weekend` (string) — e.g. "09:00–18:00"
  - `_branch_is_24h` (boolean)
  - `_branch_latitude` (string)
  - `_branch_longitude` (string)

### 0.5 — Theme Architect: Core templates
- `index.php`, `header.php`, `footer.php`, `404.php`, `page.php`, `sidebar.php`
- Verify theme activates without errors

**Gate 0 Deliverable:** Theme activates in WordPress. CPTs visible in admin (Cars, Bookings, Branches). No frontend styling yet — just structural activation.

**Gate 0 Review:** Founders activate theme at vagraai.local, verify admin CPTs exist, no PHP errors.

---

## Phase 1: Templates & UI (→ Gate 1)

### 1.1 — Theme Architect: Header and footer
- `header.php` — fixed dark navbar with backdrop blur, logo (`Drive<span>Ease</span>`), wp_nav_menu('primary'), language switcher (EN/HY), currency selector (USD/EUR/AMD), mobile hamburger
  - Port from: `DriveEase/car-rental-template.html` lines 1–50 (nav markup)
- `footer.php` — dark footer with 4 columns (About, Quick Links, Branches, Contact), social icons, copyright
  - Port from: `DriveEase/car-rental-template.html` footer section

### 1.2 — Theme Architect: Homepage template
- `front-page.php` sections in order:
  1. Hero with background image + overlay gradient + booking search widget (pickup/dropoff location + dates)
  2. Fleet grid — WP_Query for `driveease_car` where `_car_featured = true`, rendered as `.car-card` with data attributes for filtering
  3. Category filter buttons (All, Economy, Sedan, SUV, Luxury, Compact, Minivan) from `car_category` taxonomy
  4. "Why DriveEase" section — 4 service cards (Wide Selection, Best Prices, 24/7 Support, Easy Booking)
  5. "How It Works" — 3-step process cards
  6. Testimonials section
  7. Footer
- Port from: `DriveEase/car-rental-template.html`

### 1.3 — Theme Architect: Car detail template
- `single-driveease_car.php` sections:
  1. Breadcrumb (Home > Fleet > Car Name)
  2. Gallery with main image + thumbnail switcher (from `_car_gallery` meta)
  3. Vehicle specs grid (from meta fields: seats, doors, transmission, fuel, engine, mileage, trunk, A/C)
  4. Included features checklist (GPS, Bluetooth, USB, cruise control, backup camera)
  5. Sticky sidebar: price per day, date inputs, extras checkboxes, total calculator, "Book Now" button
  6. "Similar Vehicles" — WP_Query same `car_category`, exclude current, limit 2
- Port from: `DriveEase/car-a1.html`

### 1.4 — Theme Architect: Fleet archive template
- `archive-driveease_car.php` — fleet grid with category filter (same layout as homepage fleet section but full-page)

### 1.5 — Theme Architect: Contact page template
- `page-contact.php` (Template Name: Contact):
  1. Contact form (name, email, phone, subject, message) — submits via AJAX to `admin-ajax.php`
  2. Contact info cards (phone, email, HQ address, hours)
  3. Branch location cards — WP_Query for `driveease_branch` with address, hours, map placeholder
- Port from: `DriveEase/contact.html`

### 1.6 — Theme Architect: Booking modal template part
- `template-parts/booking-modal.php` — 3-step wizard:
  - Step 1: Rental details (pickup/dropoff location select from branches, dates)
  - Step 2: Personal info (name, email, phone, license)
  - Step 3: Extras & payment (GPS $8, Child Seat $12, Wi-Fi $6, Insurance $18 + card form)
  - Confirmation screen with reference number
- Included via `get_template_part()` in footer

### 1.7 — Theme Architect: Chat widget template part
- `template-parts/driveease-chat.php` — floating chatbot widget (bottom-right)
- Port from: existing HTML chatbot markup in all 4 prototype files

**Gate 1 Deliverable:** All pages render with correct layout, responsive design, colors match prototype exactly. Fleet pulls from WP_Query. Car detail shows real meta data. Booking modal opens but doesn't submit yet. No broken styles.

**Gate 1 Review:** Founders browse all pages, compare visual match to HTML prototypes, check mobile, verify no console errors.

---

## Phase 2: Interactive & Backend (→ Gate 2)

### 2.1 — Theme Architect: Enqueue & localize all JS
- Split JS into: `assets/js/main.js` (nav, filters, gallery), `assets/js/booking.js` (modal wizard), `assets/js/i18n.js` (translations), `assets/js/currency.js` (conversion), `assets/js/chat.js` (chatbot)
- `wp_localize_script` passing: ajax_url, nonce, branch list, car prices, translations

### 2.2 — WP Admin Specialist: Booking AJAX endpoint
- `wp_ajax_nopriv_driveease_book` / `wp_ajax_driveease_book`
- Validate all fields, check availability (no overlapping dates for same car), create booking post, generate reference, send confirmation email via `wp_mail()`
- Return JSON: success + reference number, or error message

### 2.3 — WP Admin Specialist: Availability REST API
- `GET /wp-json/driveease/v1/availability/{car_id}?month=YYYY-MM`
- Returns array of booked date ranges for that car
- Used by frontend to disable unavailable dates in date picker

### 2.4 — WP Admin Specialist: Admin meta boxes
- Car edit screen: grouped meta box for all car fields (specs, features, pricing, gallery)
- Booking edit screen: read-only summary + status dropdown
- Branch edit screen: address, hours, coordinates fields

### 2.5 — AI Integration Specialist: JavaScript interactivity
- i18n system with `data-i18n` attributes, localStorage persistence
- Multi-currency conversion (USD/EUR/AMD), localStorage persistence
- Fleet category filtering (JS filter on data attributes)
- Booking modal 3-step wizard with validation + AJAX submit
- Car detail gallery thumbnail switching
- Sidebar price calculator (dynamic total = price × days + extras)
- Contact form AJAX submission
- Chatbot with keyword-based responses

### 2.6 — AI Integration Specialist: Chat widget backend
- `inc/class-driveease-chat.php` — REST API for AI chat (adapt from vagra-msp pattern)
- Rate limiting via transients
- System prompt for car rental context

**Gate 2 Deliverable:** Booking flow works end-to-end (select car → fill form → submit → get reference → email sent). Availability prevents double-booking. All JS interactions work. Chat responds.

**Gate 2 Review:** Founders test full booking flow, verify email receipt, test availability blocking, check all interactive elements.

---

## Phase 3: Admin & Content (→ Gate 3)

### 3.1 — WP Admin Specialist: Admin dashboard
- Custom admin columns for Bookings: reference, car, customer, dates, status, total
- Dashboard widget: today's pickups, today's returns, pending count
- Quick status transitions (Pending → Confirmed → Active → Completed)
- CSV export for bookings

### 3.2 — WP Admin Specialist: Email templates
- Booking confirmation email (HTML template with reference, dates, car, total)
- Booking reminder (1 day before pickup)
- Booking cancellation email
- Use `wp_mail()` with HTML content type

### 3.3 — Demo Content Writer: Sample data
- 12 sample cars (matching prototype: A1, A2, B1, B2, C1, C2, D1, D2, E1, E2, F1, F2)
- 4 branch locations (City Center, Airport, North District, Harbor)
- 3 sample testimonials
- Demo import XML via standard WordPress format
- `demo-content/demo-content.xml`, `demo-content/customizer.json`

### 3.4 — Theme Architect: Theme polish & compliance
- `screenshot.png` (1200×900)
- `readme.txt` (WordPress.org format)
- Theme Check plugin validation
- Accessibility audit (focus states, ARIA labels, keyboard navigation)
- Performance: lazy loading images, minified CSS/JS
- Translation template: `languages/driveease.pot`

**Gate 3 Deliverable:** Complete theme with working admin, sample data importable, emails functional, WordPress.org compliant, translation-ready.

**Gate 3 Review:** Founders do full walkthrough: import demo, make booking, check admin, verify emails, run Theme Check.

---

## Design System Quick Reference

| Token | Value |
|-------|-------|
| **Accent** | `#e85d26` (orange) |
| **Accent Dark** | `#c94d1a` (hover) |
| **Dark** | `#1a1a2e` (navy) |
| **Light BG** | `#f7f7f9` |
| **Gray** | `#6b7280` |
| **Border** | `#e5e7eb` |
| **Radius** | `12px` |
| **Transition** | `.25s ease` |
| **Font** | Inter 300–800 |
| **Container** | 1200px max, 20px padding |
| **Breakpoints** | 960px, 600px |
| **Nav height** | 68px |
| **Card shadow** | `0 4px 24px rgba(0,0,0,.08)` |

## i18n
- English (en) + Armenian (hy)
- Client-side switching via `data-i18n` attributes + localStorage (`de_lang`)
- 150+ translation keys defined in JS

## Multi-Currency
- USD (base), EUR (×0.92), AMD (×387)
- Client-side conversion, localStorage (`de_curr`)
- All prices stored in USD in database
