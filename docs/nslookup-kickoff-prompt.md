# nslookup.am — Theme Architect Kick-Off Prompt
> Copy this entire block into Paperclip as the Theme Architect's first issue.

---

## Title
[ORCHESTRATOR] nslookup.am — Plan all work and create agent tasks

## Description

You are the **Theme Architect**, lead orchestrator for the nslookup.am WordPress theme project.

**Your first job is NOT to write code.** Your first job is to:

1. Read all context files listed below
2. Create sub-issues (tasks) for every agent, for every phase
3. Set dependencies between tasks
4. Then start your own Phase 1 work

### Step 1: Read these files (in order)
```
C:/OSPanel/domains/vagraAI/docs/nslookup-orchestration-plan.md
C:/OSPanel/domains/vagraAI/docs/nslookup-agent-roles.md
C:/OSPanel/domains/vagraAI/docs/nslookup-master-task.md
C:/OSPanel/domains/vagraAI/nslookup/chats/chat1.md
C:/OSPanel/domains/vagraAI/nslookup/README.md
```

### Step 2: Create these sub-issues

Create one issue per task below. Each issue must include:
- **Title** — short, starts with agent name in brackets
- **Assigned to** — the agent name
- **Blocked by** — which issues must complete first
- **Description** — what to build, which source files to read, what the output files are, acceptance criteria

---

#### PHASE 1 — Theme Foundation (Theme Architect solo)

**Issue 1.1: [Theme Architect] Scaffold theme + merge CSS**
- Assigned to: Theme Architect
- Blocked by: nothing
- Description:
  - Create `wp-content/themes/vagra-nslookup/` directory
  - Create `style.css`: WordPress theme header + merge content from `nslookup/project/shared/tokens.css`, `site.css`, `cinematic.css`
  - Create `functions.php`: `VAGRA_NSL_VERSION`, `vagra_nsl_setup()`, `vagra_nsl_scripts()`, register menus (primary, footer), register widget areas (sidebar-1, footer-1)
  - Follow patterns from `wp-content/themes/vagra-msp/functions.php`
  - Prefix all functions `vagra_nsl_`, text domain `vagra-nslookup`
  - Output: `style.css`, `functions.php`

**Issue 1.2: [Theme Architect] Header and footer templates**
- Assigned to: Theme Architect
- Blocked by: 1.1
- Description:
  - `header.php`: Sticky glassmorphism TopNav, `wp_nav_menu('primary')`, mobile burger, "Check DNS" CTA button. Port from `nslookup/project/shared/components.jsx` TopNav component — convert JSX to PHP.
  - `footer.php`: Dark footer with logo + tagline, Other Tools column (SPF/DKIM/DMARC/BIMI links), Company column, Discover More column, `wp_nav_menu('footer')`, copyright. Include `get_template_part('template-parts/ai-chat')`. Port from `sections.jsx` Footer component.
  - Output: `header.php`, `footer.php`

**Issue 1.3: [Theme Architect] Reusable template parts**
- Assigned to: Theme Architect
- Blocked by: 1.1
- Description:
  - `template-parts/cine-sub-hero.php` — dark cinematic hero for sub-pages. Accepts `$args['eyebrow']`, `$args['title']`, `$args['lede']`, `$args['crumb']`. Port from `page-cine-parts.jsx` CineSubHero.
  - `template-parts/cine-final-cta.php` — dark CTA band. Accepts `$args['heading']`, `$args['sub']`, `$args['cta_text']`, `$args['cta_url']`. Port from `page-cine-parts.jsx` CineFinalCTA.
  - `template-parts/cine-stats.php` — stat strip: 30+ resolvers, 6 continents, 13 record types, $0.
  - `template-parts/cine-features.php` — 4-card feature grid (Instant Results, Global Coverage, Free to Use, No Setup) with mouse-tracking gradient glow via `--mx`/`--my` CSS vars.
  - `template-parts/faq-accordion.php` — FAQ using `<details>`/`<summary>`. Accepts `$args['items']` array of `['q' => ..., 'a' => ...]`.
  - `template-parts/sister-tools.php` — cross-link cards to spf-checker.org, dkim-checker.org, dmarc-checker.org, bimi-checker.org.
  - `template-parts/record-types-grid.php` — 13 DNS record types (A, AAAA, CNAME, MX, NS, TXT, SPF, DKIM, DMARC, SOA, PTR, CAA, SRV) with descriptions. SPF/DKIM/DMARC link to sister sites.
  - `template-parts/content-none.php` — no results found fallback.
  - Output: 8 files in `template-parts/`

**Issue 1.4: [Theme Architect] Homepage template**
- Assigned to: Theme Architect
- Blocked by: 1.2, 1.3
- Description:
  - `front-page.php` — the most complex page. Sections in order:
    1. Cinematic dark hero (CSS-only word reveal, gradient accents, floating chips) — static PHP
    2. `<div id="nsl-hero-tool"></div>` — React mount (empty in Phase 1)
    3. `<div id="nsl-marquee"></div>` — React mount
    4. Statement section ("One query. Thirty answers.") — static PHP with `.cine-big-head`
    5. `<div id="nsl-cli"></div>` — React mount
    6. `get_template_part('template-parts/cine-features')`
    7. `get_template_part('template-parts/cine-stats')`
    8. `<div id="nsl-globe"></div>` — React mount
    9. Why Use section — static PHP, 4-item grid
    10. `get_template_part('template-parts/record-types-grid')`
    11. `get_template_part('template-parts/faq-accordion')` with 12 FAQ items
    12. Blog teaser — `WP_Query` for latest 4 posts
    13. `get_template_part('template-parts/cine-final-cta')`
  - Port from: `page-cine-home.jsx`
  - Output: `front-page.php`

**Issue 1.5: [Theme Architect] Tool page templates**
- Assigned to: Theme Architect
- Blocked by: 1.2, 1.3
- Description:
  - `page-ns-lookup.php` — CineSubHero + `<div id="nsl-ns-tool">` mount + "how to read records" explainer + 5-item NS FAQ + sister-tools + CineFinalCTA. Port from `page-cine-ns.jsx`.
  - `page-propagation.php` — CineSubHero + `<div id="nsl-prop-tool">` mount + propagation explainer + flush-DNS table + 5-item FAQ + sister-tools + CineFinalCTA. Port from `page-cine-prop.jsx`.
  - `page-tools.php` — CineSubHero + 12-card tool hub grid (live/coming-soon status) + sister-tools + CineFinalCTA. Port from `page-cine-tools.jsx`.
  - Output: 3 files

**Issue 1.6: [Theme Architect] Content page templates**
- Assigned to: Theme Architect
- Blocked by: 1.2, 1.3
- Description:
  - `page-about.php` — CineSubHero + manifesto pull quote + 4-principle cards + stat band + team section + CineFinalCTA. Port from `page-cine-about.jsx`.
  - `page-contact.php` — CineSubHero + `<div id="nsl-contact-form">` mount + sidebar info (email, status) + CineFinalCTA. Port from `page-cine-contact.jsx`.
  - `page-faq.php` — CineSubHero + 4-category FAQ accordion (Getting Started, DNS Records, Propagation, Advanced) + CineFinalCTA. Port from `page-cine-faq.jsx`.
  - `page-privacy.php` — CineSubHero + `the_content()` + CineFinalCTA. Port from `page-cine-privacy.jsx`.
  - `page-terms.php` — CineSubHero + `the_content()` + CineFinalCTA. Port from `page-cine-terms.jsx`.
  - Output: 5 files

**Issue 1.7: [Theme Architect] Blog + error templates**
- Assigned to: Theme Architect
- Blocked by: 1.2, 1.3
- Description:
  - `archive.php` — CineSubHero + WordPress loop with cinematic blog card grid (gradient poster thumbnails, tag badge, title, read time). Port from `page-cine-blog.jsx`.
  - `single.php` — dark article hero (post title, meta, author) + `the_content()` with `nsl-article-body` class + inline CTA + CineFinalCTA. Port from `page-cine-post.jsx`.
  - `404.php` — full dark hero with giant gradient "404", mock terminal with NXDOMAIN dig output, search form, quick-link chips. Port from `page-cine-404.jsx`.
  - `page.php`, `index.php` — generic fallbacks
  - `sidebar.php`, `searchform.php` — standard WP partials
  - Output: 7 files

**Issue 1.8: [Theme Architect] Vanilla JavaScript**
- Assigned to: Theme Architect
- Blocked by: 1.1
- Description:
  - `assets/js/main.js`:
    - Scroll reveal: IntersectionObserver watching `.reveal` / `.reveal-scale`, adds `.in` class. Threshold 0.12, rootMargin '0px 0px -8% 0px'.
    - Mobile menu: toggle burger, aria-expanded, body scroll lock.
    - Feature card mouse tracking: mousemove on `.cine-feature` sets `--mx`/`--my` CSS custom properties.
    - Reduced motion: check `prefers-reduced-motion`, add `[data-reduced-motion]` to `<html>`.
    - Header scroll: add `.nsl-header--scrolled` class on scroll > 20px.
  - Follow pattern from `vagra-msp/assets/js/main.js`
  - Output: `assets/js/main.js`

**Issue 1.9: [Theme Architect] Create WordPress pages + activate theme**
- Assigned to: Theme Architect
- Blocked by: 1.4, 1.5, 1.6, 1.7, 1.8
- Description:
  - Create pages via WP-CLI: Home, NS Lookup (slug: ns-lookup), DNS Propagation Checker (slug: propagation), Other DNS Tools (slug: tools), About, Contact, FAQ, Privacy Policy (slug: privacy), Terms of Service (slug: terms)
  - Set static front page via `wp option update show_on_front page`
  - Create primary and footer navigation menus
  - Activate theme: `wp theme activate vagra-nslookup`
  - Verify all pages render at vagraai.local
  - **STOP — Report Gate 1 status**

---

#### PHASE 2 — Interactive Tools (after Gate 1 approval)

**Issue 2.1: [Frontend Specialist] Vite build pipeline**
- Assigned to: Frontend Specialist
- Blocked by: Gate 1
- Description:
  - Create `package.json`: devDependencies react, react-dom, vite, @vitejs/plugin-react
  - Create `vite.config.js`: input `src/index.js`, output `assets/js/dist/`, fixed filenames nsl-islands.js + nsl-shared.js (react+react-dom manual chunk)
  - `npm install && npm run build` to verify
  - Output: `package.json`, `vite.config.js`, `assets/js/dist/`

**Issue 2.2: [Frontend Specialist] Shared React components**
- Assigned to: Frontend Specialist
- Blocked by: 2.1
- Description:
  - `src/shared/scroll-reveal.js` — useReveal hook. Port from `page-cine-parts.jsx` useCineReveal.
  - `src/shared/world-map.jsx` — SVG dot-grid map with animated pings. Port from `components.jsx` WorldMap.
  - `src/shared/cine-globe.jsx` — rotating globe with arcs, traveling dots, active location cycling. Port from `page-cine-home.jsx` CineGlobe.
  - `src/shared/cine-marquee.jsx` — infinite scroll strip. Port from `page-cine-home.jsx` CineMarquee.
  - `src/shared/cine-cli.jsx` — terminal typing effect. Port from `page-cine-home.jsx` CineCLI.
  - Output: 5 files in `src/shared/`

**Issue 2.3: [Frontend Specialist] Island components + orchestrator**
- Assigned to: Frontend Specialist
- Blocked by: 2.2
- Description:
  - `src/index.js` — island hydration orchestrator: scans for `<div id="nsl-*">`, lazy loads matching component, creates React root.
  - `src/islands/hero-tool.jsx` — 13 record type pills, domain input, resolver dropdown, "Check DNS" button, result table, embedded WorldMap. Calls `POST /vagra-nsl/v1/lookup`. Port from `components.jsx` HeroTool.
  - `src/islands/ns-tool.jsx` — compact NS lookup, result table with copy/CSV/JSON export. Calls `POST /vagra-nsl/v1/lookup` with type=NS. Port from `page-cine-ns.jsx`.
  - `src/islands/prop-tool.jsx` — domain + type input, world map, 30+ row table with filter chips (All/Failed/Mismatched). Calls `POST /vagra-nsl/v1/propagation`. Port from `page-cine-prop.jsx`.
  - `src/islands/contact-form.jsx` — topic pills, multi-step form, success state. Port from `page-cine-contact.jsx`.
  - All tool components read `window.nslConfig.restUrl` and `window.nslConfig.nonce` (localized by WordPress).
  - Run `npm run build`, commit `assets/js/dist/`
  - Output: 6 files in `src/`, built output in `assets/js/dist/`

**Issue 2.4: [DNS Backend Specialist] DNS lookup REST API**
- Assigned to: DNS Backend Specialist
- Blocked by: Gate 1
- Description:
  - `inc/class-vagra-nsl-dns.php`:
    - Route `POST /vagra-nsl/v1/lookup`: accepts `{domain, type, resolver?}`, returns `{success, results: [{resolver, name, location, records, status, responseTime}]}`
    - Route `POST /vagra-nsl/v1/propagation`: accepts `{domain, type}`, queries 30+ resolvers, returns all results
    - Uses `dns_get_record()` primary, `dig` fallback (check `function_exists('exec')`)
    - Resolver registry: 30+ IPs with name, location, country (Google, Cloudflare, Quad9, OpenDNS, regional resolvers)
    - Input validation: sanitize hostname, whitelist record types
    - Rate limiting: 60 req/hour per IP via WordPress transients
    - No `exec()` if disabled by host
  - Read `vagra-msp/inc/class-vagra-chat.php` for REST route + rate limiting pattern
  - Output: `inc/class-vagra-nsl-dns.php`

**Issue 2.5: [Theme Architect] Wire React scripts into WordPress**
- Assigned to: Theme Architect
- Blocked by: 2.3, 2.4
- Description:
  - Update `functions.php` enqueue:
    - `wp_enqueue_script('vagra-nsl-shared', .../dist/nsl-shared.js)` on tool pages
    - `wp_enqueue_script('vagra-nsl-islands', .../dist/nsl-islands.js, ['vagra-nsl-shared'])`
    - `wp_localize_script('vagra-nsl-islands', 'nslConfig', ['restUrl' => rest_url('vagra-nsl/v1/'), 'nonce' => wp_create_nonce('wp_rest')])`
    - Conditional: only on `is_front_page()` or `is_page(['ns-lookup','propagation','contact'])`
  - Load `inc/class-vagra-nsl-dns.php` in functions.php
  - Test: enter a real domain, verify DNS results return
  - **STOP — Report Gate 2 status**

---

#### PHASE 3 — AI Chat + Polish (after Gate 2 approval)

**Issue 3.1: [AI Integration Specialist] Chat component**
- Assigned to: AI Integration Specialist
- Blocked by: Gate 2
- Description:
  - Adapt from vagra-msp. Read these pattern files first:
    - `vagra-msp/inc/class-vagra-chat.php`
    - `vagra-msp/assets/js/vagra-chat.js`
    - `vagra-msp/assets/css/vagra-chat.css`
    - `vagra-msp/template-parts/ai-chat.php`
  - Create:
    - `inc/class-vagra-nsl-chat.php` — REST route `vagra-nsl/v1/chat`, rate limit 20/hr, Claude API proxy
    - `inc/chat-prompts/vagra-nsl.txt` — DNS assistant persona (can answer DNS concepts, cannot give network config advice)
    - `template-parts/ai-chat.php` — chat widget styled for cinematic dark theme
    - `assets/js/vagra-chat.js` — vanilla JS chat (session storage, typing indicator)
    - `assets/css/vagra-chat.css` — uses `--nsl-*` tokens
  - Verify 10 test queries (listed in orchestration plan)
  - Output: 5 files

**Issue 3.2: [Theme Architect] Customizer + admin**
- Assigned to: Theme Architect
- Blocked by: Gate 2
- Description:
  - `inc/customizer.php`: panel "nslookup.am Settings", sections for Brand Colors, Typography, AI Chat (API key, enable/disable, title, prompt override), DNS Tool settings
  - `inc/class-vagra-nsl-admin.php`: admin settings page for API key management
  - `assets/css/editor-style.css`: match front-end article typography
  - Output: 3 files

**Issue 3.3: [Theme Architect] Accessibility + performance audit**
- Assigned to: Theme Architect
- Blocked by: 3.1, 3.2
- Description:
  - Verify `prefers-reduced-motion` disables all animations
  - Audit ARIA labels: tool forms, FAQ accordions, mobile menu, chat widget
  - Add `loading="lazy"` to below-fold images
  - Verify `<title>` and meta descriptions on all templates
  - Cross-browser test: Chrome, Firefox, Safari, Edge
  - Run Lighthouse, target 90+ performance
  - **STOP — Report Gate 3 status**

---

#### PHASE 4 — Demo Content + Submission (after Gate 3 approval)

**Issue 4.1: [Demo Content Writer] Blog posts + page content**
- Assigned to: Demo Content Writer
- Blocked by: Gate 3
- Description:
  - 6 blog posts (educational, real value):
    1. "DNS Propagation Explained: Why Changes Take Time"
    2. "A Complete Guide to DNS Record Types"
    3. "How to Troubleshoot DNS Issues"
    4. "Understanding TTL: Time to Live in DNS"
    5. "SPF, DKIM, and DMARC: Email Authentication DNS Records"
    6. "nslookup vs dig vs host: Command-Line DNS Tools Compared"
  - Page content: About (mission, principles, team), Contact (form intro, email addresses), FAQ (40+ questions in 4 categories), Privacy Policy, Terms of Service
  - Tool hub descriptions for 12 DNS tools
  - Output: content drafts in demo-content/ directory

**Issue 4.2: [Demo Content Writer] Demo import files**
- Assigned to: Demo Content Writer
- Blocked by: 4.1
- Description:
  - `demo-content/demo-content.xml` — WordPress eXtended RSS (all pages + posts)
  - `demo-content/customizer.json` — theme settings export
  - `demo-content/widgets.json` — widget configuration
  - `inc/demo-import.php` — one-click import handler (recommends OCDI plugin)
  - Output: 4 files

**Issue 4.3: [Theme Architect] WordPress.org submission prep**
- Assigned to: Theme Architect
- Blocked by: 4.2
- Description:
  - `screenshot.png` (1200x900) showing cinematic homepage
  - `readme.txt` in WordPress standard format
  - `/languages/vagra-nslookup.pot` translation file
  - Run Theme Check — fix all errors
  - Run Plugin Check — fix all errors
  - Final escaping/sanitization audit
  - Verify all strings use text domain `vagra-nslookup`
  - Verify PageSpeed > 90
  - **STOP — Report Gate 4 status (Ship/No-Ship)**

---

### Step 3: Set dependencies
After creating all issues, verify the dependency chain:
```
1.1 → 1.2, 1.3, 1.8
1.2 + 1.3 → 1.4, 1.5, 1.6, 1.7
1.4 + 1.5 + 1.6 + 1.7 + 1.8 → 1.9 (Gate 1)
Gate 1 → 2.1, 2.4
2.1 → 2.2 → 2.3
2.3 + 2.4 → 2.5 (Gate 2)
Gate 2 → 3.1, 3.2
3.1 + 3.2 → 3.3 (Gate 3)
Gate 3 → 4.1
4.1 → 4.2 → 4.3 (Gate 4)
```

### Step 4: Start your own Phase 1 work
Once all issues are created, begin working on Issue 1.1. Follow the dependency chain.
