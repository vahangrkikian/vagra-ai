# Carmaster (Carvice) — Multi-Vector Analysis & Paperclip Agent Implementation Plan

## Project Identity

| Field | Value |
|-------|-------|
| **Name** | Carvice (folder: Carmaster) |
| **Type** | Car service marketplace — connects car owners with service centers, individual specialists, and official dealers |
| **Market** | Armenia, Russia, Kazakhstan |
| **Language** | Armenian (UI strings in `src/lib/strings.ts`), with Cyrillic font support |
| **Current State** | UI prototype — no backend, no API, no database |
| **Source** | Next.js 16 + React 19 + TypeScript + Tailwind CSS 4 |

---

## 1. MULTI-VECTOR ANALYSIS

### Vector 1: Technology Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| Framework | Next.js (App Router, Turbopack) | 16.2.4 |
| UI Library | React (Server Components) | 19.2.4 |
| Language | TypeScript (strict) | 5.x |
| Styling | Tailwind CSS + PostCSS | 4.x |
| Font | Inter (Google Fonts, Latin + Cyrillic) | — |
| Images | Unsplash CDN (parameterized URLs) | — |
| Linting | ESLint 9 (core-web-vitals + TS) | 9.x |

**Verdict:** Modern, bleeding-edge stack. Excellent for prototyping, but needs full rewrite for WordPress target.

### Vector 2: Architecture

```
src/
├── app/                    # Next.js App Router (file-based routing)
│   ├── layout.tsx          # Root layout (Header + Footer wrapper)
│   ├── page.tsx            # Home (hero, categories, providers, AI bar)
│   ├── globals.css         # CSS variables + Tailwind imports
│   ├── auth/
│   │   ├── sign-in/page.tsx    # Login form + 5 social auth buttons
│   │   └── sign-up/page.tsx    # 4-tab registration (user/individual/company/dealer)
│   ├── provider/
│   │   └── [id]/page.tsx       # Dynamic provider detail (gallery, reviews, sidebar)
│   └── search/
│       └── page.tsx            # Stub — "coming soon"
├── components/
│   ├── layout/
│   │   ├── Header.tsx          # Nav, search, region/language selectors
│   │   └── Footer.tsx          # Multi-column footer
│   └── ui/
│       ├── AIAssistantBar.tsx   # Fixed bottom AI input bar
│       ├── CategoryCard.tsx     # Colorful gradient category tiles
│       ├── ChatWidget.tsx       # Expandable chat widget
│       ├── ProviderCard.tsx     # Provider listing card
│       ├── ProviderCTAButtons.tsx # Call/Message/Request buttons
│       └── ServiceFilterPills.tsx # Toggle filter buttons
└── lib/
    ├── data.ts             # Mock data (10 providers, 6 categories, 11 service types)
    ├── strings.ts          # Armenian i18n string constants
    └── types.ts            # TypeScript interfaces
```

**Total codebase:** ~18 source files, ~1,300 lines of code.

**Key patterns:**
- Server Components by default, `"use client"` only where state is needed
- Data layer is hardcoded mock objects (no API calls)
- Components are single-responsibility, reusable
- No error handling, no loading states, no validation

### Vector 3: Data Model

```typescript
// From src/lib/types.ts
ServiceCategory    { id, name, icon, color }          // 6 categories
ServiceType        { id, name }                        // 11 service types  
CarBrand           { id, name }                        // for dealer filtering
Provider {
  id, name, type (center|individual|dealer),
  rating, reviewCount, address, phone, bio,
  categories[], serviceTypes[], images[],
  socials { website, instagram, facebook, telegram, whatsapp, tiktok },
  promocode?, representedBrand?
}
```

**WordPress mapping:**
- `Provider` → Custom Post Type `carvice_provider`
- `ServiceCategory` → Custom Taxonomy `carvice_service_cat`
- `ServiceType` → Custom Taxonomy `carvice_service_type`
- `CarBrand` → Custom Taxonomy `carvice_brand`
- Reviews → Custom comment type or separate CPT
- Provider images → Post thumbnails + ACF gallery field

### Vector 4: Pages & UX Flow

| Page | Sections | Complexity |
|------|----------|------------|
| **Home** | Hero with car image, 6 category cards (gradient), service filter pills, top service centers (5 cards), top specialists (5 cards), AI assistant bar (fixed) | HIGH |
| **Sign In** | Email/phone + password form, 5 social login buttons (Facebook, VK, Google, Mail.ru, OK) | MEDIUM |
| **Sign Up** | 4-tab form: User (simple), Individual Specialist (full profile + categories + services + photo + social + bio), Company (org info + employee photos + categories), Dealer (brand + shop photo + categories) | VERY HIGH |
| **Provider Detail** | Hero banner (dealers), breadcrumb bar, main photo + gallery, service categories, service pills, CTA buttons, chat widget, bio, address/map, promo code, reviews with rating breakdown, sidebar with related providers | VERY HIGH |
| **Search** | Stub only | NONE |

### Vector 5: Design System

```css
/* Extracted from globals.css */
--color-primary: #242424          /* Dark gray */
--color-accent: #1a73e8           /* Google Blue */
--color-accent-hover: #1557b0
--color-surface: #ffffff
--color-surface-hover: #f5f5f5
--color-card-active: rgba(196, 196, 196, 0.56)
--color-card-border: rgba(36, 36, 36, 0.2)
--color-muted: #6b7280
--color-star: #f59e0b             /* Amber for ratings */
--radius-sm: 6px
--radius-md: 12px
--radius-lg: 20px
--max-width: 1440px
--side-padding: 200px
```

**Category color palette:** 6 unique gradient backgrounds (blue, green, orange, red, purple, yellow) with custom SVG icons per category.

**Font:** Inter (300-700 weights, Latin + Cyrillic subsets).

### Vector 6: What's Missing (Production Gaps)

| Gap | Severity | Notes |
|-----|----------|-------|
| No backend/API | CRITICAL | All data is hardcoded mock |
| No authentication | CRITICAL | Forms are UI-only |
| No database | CRITICAL | No data persistence |
| No form validation | HIGH | No client or server validation |
| No error handling | HIGH | No try/catch, no error boundaries |
| No image upload | HIGH | Uses Unsplash placeholder URLs |
| No map integration | MEDIUM | "View on Map" buttons non-functional |
| No chat backend | MEDIUM | ChatWidget has mock messages only |
| No SEO (schema, OG, sitemap) | MEDIUM | Only basic meta title/description |
| No tests | MEDIUM | Zero test coverage |
| No i18n framework | LOW | Strings file exists but no switching logic |
| No accessibility (ARIA live, skip nav) | LOW | Partial — semantic HTML is good |

### Vector 7: WordPress Conversion Assessment

**Conversion difficulty: MEDIUM-HIGH**

What translates directly:
- Design system (CSS variables) → WordPress `style.css`
- Page layouts → PHP templates
- Component structure → `template-parts/`
- Data model → Custom Post Types + Taxonomies + ACF

What needs full rewrite:
- React state management → vanilla JS or Alpine.js
- Next.js routing → WordPress template hierarchy
- Server Components → PHP template rendering
- Mock data → WP_Query + get_posts
- Social auth → WordPress auth + OAuth plugins
- Chat widget → PHP + JS (same pattern as vagra.ai AI chat spec)

---

## 2. PAPERCLIP AGENT IMPLEMENTATION PLAN

### Agent Roster (Carmaster-specific)

Based on the established vagra.ai agent hierarchy, adapted for this project:

| # | Agent | Role | Adapter | Budget |
|---|-------|------|---------|--------|
| 1 | **Theme Architect** (Lead) | WordPress theme structure, templates, CSS, CPTs, taxonomies | Claude Code | $50/mo |
| 2 | **WP Admin Specialist** | Admin panel, provider management UI, registration forms, settings | Claude Code | $30/mo |
| 3 | **AI Integration Specialist** | Chat widget (shared component from vagra.ai), AI assistant bar | Claude Code | $30/mo |
| 4 | **Frontend Specialist** | Interactive JS components — filter pills, gallery, map, review forms | Claude Code | $30/mo |
| 5 | **Demo Content Writer** | Armenian demo content — providers, categories, reviews, copy | Claude Code | $20/mo |
| 6 | **ekzupery** | Design review at gates — "can anything be removed?" | Claude Code | $10/mo |

**Hierarchy:**
```
Theme Architect (Lead)
├── WP Admin Specialist
├── AI Integration Specialist  
├── Frontend Specialist
└── Demo Content Writer

ekzupery — independent reviewer at gates
```

### Phase Structure (3 Phases, 4 Gates)

```
Phase 0: Foundation        → Gate 0 (scaffold review)
Phase 1: Templates & UI    → Gate 1 (visual review)
Phase 2: Interactive + AI  → Gate 2 (functional review)
Phase 3: Content & Polish  → Gate 3 (ship review)
```

---

### Phase 0: Foundation (Theme Architect solo)

**Goal:** WordPress theme scaffold with data architecture.

**Tasks:**
- [ ] Create `wp-content/themes/carvice/` directory
- [ ] `style.css` with theme header + design tokens from Carmaster globals.css
- [ ] `functions.php` — enqueue styles/scripts, theme supports, text domain
- [ ] Register Custom Post Type: `carvice_provider` (center, individual, dealer subtypes via meta)
- [ ] Register Taxonomies: `carvice_service_cat`, `carvice_service_type`, `carvice_brand`
- [ ] ACF field groups (or custom meta boxes):
  - Provider: type, phone, rating, address, bio, socials (7 fields), promocode, represented_brand, gallery
  - Review: rating (1-5), linked provider
- [ ] Core template files: `index.php`, `header.php`, `footer.php`, `sidebar.php`, `404.php`, `functions.php`
- [ ] `template-parts/` directory structure matching component breakdown
- [ ] Set up vagraai.local/carvice or dedicated local domain
- [ ] Verify theme activates without errors

**Gate 0 Deliverable:** Theme activates, CPTs visible in admin, taxonomies registered. No frontend yet.

**Gate 0 Review:** Founders verify admin panel shows Providers CPT with correct fields. ekzupery reviews: is the data model minimal and correct?

---

### Phase 1: Templates & UI (Theme Architect + WP Admin Specialist)

**Goal:** All pages render with correct layout and styling. No interactivity.

#### 1.1 — Theme Architect: Home Page
- [ ] `front-page.php` with:
  - Hero section (dark bg, car image, Armenian headline from strings.ts)
  - 6 category cards (gradient backgrounds, SVG icons) — `template-parts/category-card.php`
  - Service filter pills section (static, no JS yet) — `template-parts/filter-pills.php`
  - Top Service Centers grid (WP_Query on carvice_provider where type=center) — `template-parts/provider-card.php`
  - Top Specialists grid (WP_Query where type=individual)
  - AI assistant bar placeholder (static)
- [ ] Responsive CSS: desktop-first, 2/3/6 column grids matching Carmaster breakpoints

#### 1.2 — Theme Architect: Provider Detail Page
- [ ] `single-carvice_provider.php` with:
  - Hero banner (dealers only — conditional on provider type)
  - Top bar: back link, name, type badge, rating
  - Main content (65%): featured image + gallery thumbnails, category icons, service pills, CTA buttons (static), bio, address, promo code section
  - Sidebar (35%): rating breakdown chart, social links, related providers (4 random)
  - Reviews section: rating distribution, review cards, write-review form (static)

#### 1.3 — Theme Architect: Auth Pages
- [ ] `page-login.php` — template for sign-in
  - Email/phone + password form
  - 5 social buttons (Facebook, VK, Google, Mail.ru, Odnoklassniki)
- [ ] `page-register.php` — template for sign-up
  - 4-tab layout: User / Individual / Company / Dealer
  - Full form fields per tab matching Carmaster sign-up page

#### 1.4 — Theme Architect: Header & Footer
- [ ] `header.php`: logo, navigation, search bar, region selector, language selector, auth buttons
- [ ] `footer.php`: multi-column layout, company info, nav links, social links, copyright

#### 1.5 — WP Admin Specialist: Provider Management
- [ ] Custom admin columns for Providers list (type, rating, category, phone)
- [ ] Meta box layout for provider editing (organized fieldsets)
- [ ] Bulk import capability (WP-CLI command or admin page) for demo providers

**Gate 1 Deliverable:** All pages render with correct layout. Static HTML + CSS only. No JS interactivity.

**Gate 1 Review:** Founders browse all pages in browser. Compare side-by-side with Carmaster Next.js prototype. Visual quality check. ekzupery asks: "Can any section be removed without losing value?"

---

### Phase 2: Interactive Components + AI (Frontend Specialist + AI Integration Specialist)

**Goal:** All interactive elements work. AI chat functional.

#### 2.1 — Frontend Specialist: Filter & Search
- [ ] `assets/js/carvice-filters.js` — service filter pills with AJAX provider filtering
- [ ] `assets/js/carvice-gallery.js` — image gallery with thumbnail navigation on provider detail
- [ ] `assets/js/carvice-tabs.js` — tab switching on registration page (4 tabs)
- [ ] `assets/js/carvice-reviews.js` — review form submission, star rating input
- [ ] REST API endpoints for:
  - `GET /wp-json/carvice/v1/providers?service_type=X` (filtered provider list)
  - `POST /wp-json/carvice/v1/reviews` (submit review)

#### 2.2 — Frontend Specialist: Maps & Contact
- [ ] Map integration (OpenStreetMap/Leaflet — no API key needed) for provider address
- [ ] "Choose on Map" in registration forms
- [ ] Click-to-call on phone buttons (`tel:` links)
- [ ] WhatsApp/Telegram deep links from social buttons

#### 2.3 — AI Integration Specialist: Chat Widget
- [ ] Port `template-parts/ai-chat.php` from vagra.ai shared component
- [ ] `assets/js/carvice-chat.js` — expandable/collapsible chat widget
- [ ] `assets/css/carvice-chat.css` — themed with Carvice design tokens
- [ ] `inc/class-carvice-chat.php` — REST API proxy to Claude, rate limiting, Customizer settings
- [ ] System prompt: car service concierge for Armenia — helps users find the right provider, explains service categories, answers car maintenance questions in Armenian
- [ ] AI Assistant Bar (bottom bar): quick action chips + free-text input, feeds into chat

#### 2.4 — AI Integration Specialist: Chat Test Matrix
Test 10 queries:
1. "Ինչ delays- delays-delays delays- delays" (What services do you offer?)
2. "Ուր կարող եdelays-delays-delays" (Where can I change oil?)
3. "Ինdelays-delays-delays" (How much does body repair cost?)
4. "Մdelays-delays-delays" (My engine makes a weird noise)
5. "Օdelays-delays-delays" (Air conditioning doesn't work)
6. Price range question
7. Emergency/towing question
8. Dealer vs independent shop comparison
9. Specific car brand question
10. Out-of-scope question (graceful redirect)

#### 2.5 — WP Admin Specialist: Registration & Auth
- [ ] Custom registration flow (wp_create_user + custom fields)
- [ ] Provider self-registration: individual specialist, company, dealer
- [ ] Social login integration (OAuth for VK, Google — Facebook/Mail.ru/OK as stretch goals)
- [ ] Profile editing page for registered providers

**Gate 2 Deliverable:** Filters work, chat responds, reviews submit, maps show locations, registration creates real accounts.

**Gate 2 Review:** Founders test each interactive element. AI chat Q&A check (Armenian). ekzupery reviews: "Does the chat add value or is it a distraction on this page?"

---

### Phase 3: Demo Content & Polish (Demo Content Writer + all agents)

**Goal:** Ship-ready with realistic content.

#### 3.1 — Demo Content Writer: Provider Content
- [ ] 10 demo providers (matching Carmaster mock data):
  - 4 service centers (Armenian names, Yerevan addresses)
  - 3 individual specialists (realistic bios, specialties)
  - 3 official dealers (Toyota, BMW, Mercedes — Armenian market)
- [ ] 6 service categories with Armenian names and descriptions
- [ ] 11 service types with Armenian labels
- [ ] 30 demo reviews (distributed across providers, 1-5 star range, Armenian text)

#### 3.2 — Demo Content Writer: Page Content
- [ ] Home page hero copy (Armenian, compelling)
- [ ] Footer content (company description, links)
- [ ] AI assistant bar chip labels in Armenian
- [ ] 404 page copy
- [ ] About page content (if needed)

#### 3.3 — Demo Content Writer: Import Package
- [ ] `demo-content/demo-content.xml` (WordPress eXtended RSS with all providers, reviews, pages)
- [ ] `demo-content/customizer.json` (theme settings)
- [ ] `demo-content/widgets.json` (widget configuration)
- [ ] One-click import via WP-CLI: `wp import demo-content/demo-content.xml`

#### 3.4 — Theme Architect: Polish
- [ ] Cross-browser testing (Chrome, Firefox, Safari, Edge)
- [ ] Mobile responsive testing (375px, 768px, 1024px, 1440px)
- [ ] Performance audit (Lighthouse target: 85+ on all scores)
- [ ] SEO: JSON-LD schema for LocalBusiness, Service, AggregateRating
- [ ] SEO: Open Graph + Twitter Card meta tags
- [ ] SEO: sitemap.xml generation
- [ ] Accessibility: skip nav, ARIA live on chat, alt text audit
- [ ] i18n: all user-facing strings wrapped in `__()` / `_e()` with `carvice` text domain
- [ ] Theme Check plugin: zero required errors

**Gate 3 Deliverable:** Complete theme with demo content installed, all pages functional, AI chat working, ready for demo.

**Gate 3 Review:** Full walkthrough — home → filter → provider detail → review → chat → registration. ekzupery final review: "Is this the simplest version that delivers the full experience?" Founders: go/no-go for public demo.

---

## 3. MASTER TASK (Copy into Paperclip)

### Title
Deliver Carvice WordPress theme — car service marketplace with AI chat for Armenian market

### Description

You are the Theme Architect, lead agent for the Carvice project. Your job is to deliver a complete WordPress theme that converts the existing Next.js prototype (C:/OSPanel/domains/vagraAI/Carmaster/) into a production WordPress theme.

### Context Files (read ALL before starting)
- C:/OSPanel/domains/vagraAI/docs/carmaster-analysis.md — this document (analysis + implementation plan)
- C:/OSPanel/domains/vagraAI/docs/wordpress-standards.md — WordPress.org compliance rules
- C:/OSPanel/domains/vagraAI/docs/ai-chat-spec.md — AI chat component specification (reuse from vagra.ai)
- C:/OSPanel/domains/vagraAI/Carmaster/src/ — reference Next.js prototype (DO NOT modify, only reference)

### Design Reference Files (extract design tokens from these)
- C:/OSPanel/domains/vagraAI/Carmaster/src/app/globals.css — CSS variables, color palette
- C:/OSPanel/domains/vagraAI/Carmaster/src/lib/strings.ts — Armenian UI strings
- C:/OSPanel/domains/vagraAI/Carmaster/src/lib/data.ts — mock data structure (provider schema)
- C:/OSPanel/domains/vagraAI/Carmaster/src/lib/types.ts — TypeScript interfaces → data model

### Environment
- WordPress installed at C:/OSPanel/domains/vagraAI/
- Site URL: vagraai.local
- WP-CLI available
- Theme directory: wp-content/themes/carvice/
- PHP 8.1, MySQL via OpenServer

### Execution Rules
1. Follow the 4-phase plan in carmaster-analysis.md exactly — Phase 0 → Gate 0 → Phase 1 → Gate 1 → Phase 2 → Gate 2 → Phase 3 → Gate 3
2. At each gate, STOP and report status. List what was completed, what works, what doesn't. Wait for human approval.
3. Create sub-issues for specialist agents (WP Admin, AI Integration, Frontend, Demo Content) as needed
4. All code goes in C:/OSPanel/domains/vagraAI/wp-content/themes/carvice/
5. The Next.js prototype at Carmaster/ is READ-ONLY reference — never modify it
6. Follow WordPress coding standards — prefix with `carvice_`, escape output, sanitize input, use text domain `carvice`
7. Do not install plugins. Do not modify wp-config.php.
8. Reuse the AI chat component pattern from vagra.ai (ai-chat-spec.md) — adapt for car service niche

### Phase 0 Checklist (do this first)
- [ ] Create wp-content/themes/carvice/ with style.css (theme header + design tokens)
- [ ] functions.php — register CPT `carvice_provider`, taxonomies, theme supports
- [ ] Core template files: index.php, header.php, footer.php, 404.php
- [ ] Verify theme activates and CPT appears in admin
- [ ] STOP — Report Gate 0 status and wait for approval

### After Gate 0 Approval
Proceed to Phase 1 per carmaster-analysis.md. Build all page templates.

### After Gate 1 Approval
Proceed to Phase 2. Create sub-issues for Frontend Specialist and AI Integration Specialist.

### After Gate 2 Approval
Proceed to Phase 3. Create sub-issues for Demo Content Writer.

---

## 4. DESIGN SYSTEM REFERENCE (for style.css)

```css
/* Carvice Design Tokens — extracted from Carmaster Next.js prototype */

:root {
  /* Colors */
  --carvice-primary: #242424;
  --carvice-primary-light: #4a4a4a;
  --carvice-accent: #1a73e8;
  --carvice-accent-hover: #1557b0;
  --carvice-surface: #ffffff;
  --carvice-surface-hover: #f5f5f5;
  --carvice-card-active: rgba(196, 196, 196, 0.56);
  --carvice-card-border: rgba(36, 36, 36, 0.2);
  --carvice-muted: #6b7280;
  --carvice-star: #f59e0b;

  /* Category Gradients */
  --carvice-cat-body: linear-gradient(135deg, #3b82f6, #1d4ed8);
  --carvice-cat-engine: linear-gradient(135deg, #22c55e, #15803d);
  --carvice-cat-electrical: linear-gradient(135deg, #f97316, #c2410c);
  --carvice-cat-chassis: linear-gradient(135deg, #ef4444, #b91c1c);
  --carvice-cat-wheels: linear-gradient(135deg, #8b5cf6, #6d28d9);
  --carvice-cat-interior: linear-gradient(135deg, #eab308, #a16207);

  /* Spacing & Layout */
  --carvice-radius-sm: 6px;
  --carvice-radius-md: 12px;
  --carvice-radius-lg: 20px;
  --carvice-max-width: 1440px;
  --carvice-side-padding: 200px;

  /* Font */
  --carvice-font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}
```

## 5. DATA MODEL QUICK REFERENCE

### Custom Post Type: `carvice_provider`

| Meta Key | Type | Notes |
|----------|------|-------|
| `_carvice_provider_type` | select | `center` / `individual` / `dealer` |
| `_carvice_phone` | text | |
| `_carvice_rating` | float | 1.0 - 5.0 (computed from reviews) |
| `_carvice_review_count` | int | (computed) |
| `_carvice_address` | text | |
| `_carvice_bio` | textarea | |
| `_carvice_gallery` | gallery | Multiple images |
| `_carvice_social_website` | url | |
| `_carvice_social_instagram` | url | |
| `_carvice_social_facebook` | url | |
| `_carvice_social_telegram` | text | |
| `_carvice_social_whatsapp` | text | |
| `_carvice_social_tiktok` | url | |
| `_carvice_promocode` | text | Centers/dealers only |
| `_carvice_represented_brand` | text | Dealers only |

### Taxonomies

| Taxonomy | Slug | Attached To |
|----------|------|-------------|
| Service Category | `carvice_service_cat` | `carvice_provider` |
| Service Type | `carvice_service_type` | `carvice_provider` |
| Car Brand | `carvice_brand` | `carvice_provider` |
