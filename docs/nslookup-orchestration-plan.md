# Orchestration Plan — nslookup.am Theme Delivery

## Overview
This plan delivers the vagra-nslookup WordPress theme (DNS propagation & record lookup tool) through four phases with approval gates. The theme uses a **React Islands architecture** — WordPress PHP templates for SEO/structure, React components for interactive tool panels. Agents work autonomously between gates. Founders review at each gate.

## Design Source
All prototypes live at `C:/OSPanel/domains/vagraAI/nslookup/project/`. The cinematic (Apple-style) versions are the target — files in the project root (not `/v1/`). Read the chat transcript at `nslookup/chats/chat1.md` for design intent.

## Agents
1. **Theme Architect** (lead) — PHP templates, CSS, vanilla JS, theme infrastructure, WP compliance
2. **Frontend Specialist** — React island components, Vite build pipeline
3. **DNS Backend Specialist** — DNS lookup REST API
4. **AI Integration Specialist** — chat component (adapted from vagra-msp)
5. **Demo Content Writer** — blog posts, page content, demo import

---

## Phase 1: Theme Foundation (→ Gate 1)

### 1.1 — Theme Architect: Create theme scaffold
- Create `wp-content/themes/vagra-nslookup/` directory structure
- `style.css` with WordPress theme headers + merged CSS from:
  - `nslookup/project/shared/tokens.css` (design tokens)
  - `nslookup/project/shared/site.css` (component classes)
  - `nslookup/project/shared/cinematic.css` (animations/motion)
- `functions.php`: VAGRA_NSL_VERSION, vagra_nsl_setup(), vagra_nsl_scripts(), menu/widget registration
- All functions prefixed `vagra_nsl_`, text domain `vagra-nslookup`

### 1.2 — Theme Architect: Header and footer
- `header.php` — sticky TopNav with glassmorphism, wp_nav_menu('primary'), mobile burger, "Check DNS" CTA button
  - Port from: `nslookup/project/shared/components.jsx` → TopNav component
- `footer.php` — dark footer with logo, sister tool links (SPF/DKIM/DMARC/BIMI checkers), wp_nav_menu('footer'), RFC links, copyright
  - Port from: `nslookup/project/shared/sections.jsx` → Footer component

### 1.3 — Theme Architect: Reusable template parts
- `template-parts/cine-sub-hero.php` — dark cinematic hero for sub-pages (eyebrow, h1, lead text, breadcrumb)
  - Port from: `page-cine-parts.jsx` → CineSubHero
- `template-parts/cine-final-cta.php` — dark closing CTA band (large heading, dual buttons)
  - Port from: `page-cine-parts.jsx` → CineFinalCTA
- `template-parts/cine-stats.php` — stat strip (30+ resolvers, 6 continents, 13 types, $0)
- `template-parts/cine-features.php` — 4-card feature grid with mouse-tracking gradient glow
- `template-parts/faq-accordion.php` — FAQ using `<details>`/`<summary>` (pure CSS animation)
- `template-parts/sister-tools.php` — cross-link cards to SPF/DKIM/DMARC/BIMI checker sites
- `template-parts/record-types-grid.php` — 13 DNS record type grid (A through SRV)

### 1.4 — Theme Architect: Homepage template
- `front-page.php` — the most complex template:
  1. Cinematic dark hero section (CSS word reveal, gradient accents, floating chips) — static PHP
  2. `<div id="nsl-hero-tool"></div>` — React island mount point
  3. `<div id="nsl-marquee"></div>` — React island mount point
  4. Statement section ("One query. Thirty answers.") — static PHP
  5. `<div id="nsl-cli"></div>` — React island mount point
  6. Feature cards grid — `get_template_part('template-parts/cine-features')`
  7. Stat strip — `get_template_part('template-parts/cine-stats')`
  8. `<div id="nsl-globe"></div>` — React island mount point
  9. Why Use section — static PHP
  10. Record Types grid — `get_template_part('template-parts/record-types-grid')`
  11. FAQ accordion — `get_template_part('template-parts/faq-accordion')`
  12. Blog teaser — WP_Query for latest 4 posts
  13. Final CTA — `get_template_part('template-parts/cine-final-cta')`
  - Port from: `page-cine-home.jsx`

### 1.5 — Theme Architect: All page templates
- `page-ns-lookup.php` — CineSubHero + `<div id="nsl-ns-tool">` mount + explainer + FAQ + CineFinalCTA
  - Port from: `page-cine-ns.jsx`
- `page-propagation.php` — CineSubHero + `<div id="nsl-prop-tool">` mount + explainer + FAQ + CineFinalCTA
  - Port from: `page-cine-prop.jsx`
- `page-tools.php` — CineSubHero + 12-card tool hub grid + sister tools + CineFinalCTA
  - Port from: `page-cine-tools.jsx`
- `page-about.php` — CineSubHero + manifesto + principles grid + stat band + team + CineFinalCTA
  - Port from: `page-cine-about.jsx`
- `page-contact.php` — CineSubHero + `<div id="nsl-contact-form">` mount + sidebar info + CineFinalCTA
  - Port from: `page-cine-contact.jsx`
- `page-faq.php` — CineSubHero + 4-category FAQ accordion + CineFinalCTA
  - Port from: `page-cine-faq.jsx`
- `page-privacy.php` — CineSubHero + the_content() + CineFinalCTA
  - Port from: `page-cine-privacy.jsx`
- `page-terms.php` — CineSubHero + the_content() + CineFinalCTA
  - Port from: `page-cine-terms.jsx`
- `404.php` — full dark hero with giant 404, mock terminal, search form, quick links
  - Port from: `page-cine-404.jsx`
- `archive.php` — CineSubHero + WordPress loop with cinematic blog card grid
  - Port from: `page-cine-blog.jsx`
- `single.php` — dark article hero + the_content() with nsl-article-body class + CineFinalCTA
  - Port from: `page-cine-post.jsx`
- `page.php`, `index.php`, `sidebar.php`, `searchform.php` — standard WP fallbacks

### 1.6 — Theme Architect: Vanilla JavaScript
- `assets/js/main.js`:
  - Scroll reveal: IntersectionObserver watching `.reveal` / `.reveal-scale`, adding `.in` class
  - Mobile menu: toggle `.nsl-nav-mobile` on burger click with aria-expanded
  - Feature card mouse tracking: mousemove sets `--mx`/`--my` CSS vars for gradient glow
  - Reduced motion: check `prefers-reduced-motion`, skip animations
  - Counter animations for stat strip numbers

**Gate 1 Deliverable:** Theme activates in WordPress. All pages render with correct layout, cinematic dark heroes, animations, responsive behavior. React mount points exist as empty `<div>` elements (tools not functional yet). No DNS lookup, no chat.

**Gate 1 Review:** Founders activate theme at vagraai.local, browse all pages, verify visual match to prototypes, check mobile. Go/no-go.

---

## Phase 2: Interactive Tools (→ Gate 2)

### 2.1 — Frontend Specialist: Vite build pipeline
- Create `package.json` with dev dependencies: react, react-dom, vite, @vitejs/plugin-react
- Create `vite.config.js`:
  - Input: `src/index.js`
  - Output: `assets/js/dist/` with fixed filenames (nsl-islands.js, nsl-shared.js)
  - Manual chunks: react + react-dom in `nsl-shared.js`
- Run initial `npm install` and `npm run build` to verify pipeline

### 2.2 — Frontend Specialist: Shared React components
- `src/shared/scroll-reveal.js` — useReveal hook (IntersectionObserver, threshold 0.12)
- `src/shared/world-map.jsx` — SVG dot-grid world map with animated resolver pings, radial gradients, staggered appearance
  - Port from: `components.jsx` → WorldMap
- `src/shared/cine-globe.jsx` — animated SVG globe with rotating rings, arc connectors, traveling dot particles, pulsing ping rings, active location cycling
  - Port from: `page-cine-home.jsx` → CineGlobe
- `src/shared/cine-marquee.jsx` — infinite horizontal scroll of DNS record types/features
  - Port from: `page-cine-home.jsx` → CineMarquee
- `src/shared/cine-cli.jsx` — terminal typing moment with green prompt, cyan answers, blinking cursor
  - Port from: `page-cine-home.jsx` → CineCLI

### 2.3 — Frontend Specialist: Island components
- `src/index.js` — island hydration orchestrator:
  - Scans DOM for mount-point `<div id="nsl-*">` elements
  - Lazy-loads only the needed component via dynamic `import()`
  - Creates React root and renders
- `src/islands/hero-tool.jsx` — homepage DNS tool panel:
  - 13 record type pills (A → SRV) with SPF/DKIM/DMARC linking to sister sites
  - Domain input with placeholder "nslookup.am"
  - Resolver dropdown (Authoritative, Google, Cloudflare, Quad9, OpenDNS)
  - "Check DNS" button
  - Live result table with status dots, IPs, TTLs, response times
  - Embedded WorldMap with animated resolver pings
  - Connects to `POST /vagra-nsl/v1/lookup` API
  - Port from: `components.jsx` → HeroTool
- `src/islands/ns-tool.jsx` — NS Lookup tool:
  - Compact tool card (domain + resolver dropdown)
  - Result table with copy/CSV/JSON export buttons
  - Connects to `POST /vagra-nsl/v1/lookup` with type=NS
  - Port from: `page-cine-ns.jsx`
- `src/islands/prop-tool.jsx` — Propagation checker:
  - Domain + record type input
  - World map with per-resolver results
  - 30+ row result table with filter chips (All / Failed / Mismatched)
  - Connects to `POST /vagra-nsl/v1/propagation`
  - Port from: `page-cine-prop.jsx`
- `src/islands/contact-form.jsx` — multi-step contact form:
  - Topic pills (General, Bug Report, Feature Request, Partnership)
  - Name, email, subject, message fields with focus animations
  - Success state
  - Submits via standard form action or REST API
  - Port from: `page-cine-contact.jsx`

### 2.4 — DNS Backend Specialist: DNS lookup API
- `inc/class-vagra-nsl-dns.php`:
  - Register REST routes: `/vagra-nsl/v1/lookup` and `/vagra-nsl/v1/propagation`
  - Input validation: sanitize domain hostname, whitelist record types
  - `dns_get_record()` primary method with `dig` fallback (check `function_exists('exec')`)
  - Resolver registry: 30+ public DNS resolvers with name, IP, location, country
  - Propagation fanout: parallel queries via `curl_multi` or sequential fallback
  - Rate limiting: 60 requests/hour per IP via WordPress transients
  - Response format matching the API contract in agent-roles.md

### 2.5 — Theme Architect: Wire React into WordPress
- Update `functions.php` enqueue:
  - `wp_enqueue_script('vagra-nsl-shared', .../dist/nsl-shared.js)` — on pages with tools
  - `wp_enqueue_script('vagra-nsl-islands', .../dist/nsl-islands.js)` — depends on shared
  - `wp_localize_script()` to pass `nslConfig` (restUrl, nonce) to JS
  - Conditional loading: only on front-page, ns-lookup, propagation, contact pages

**Gate 2 Deliverable:** DNS lookup tools are functional. Enter a domain, get real DNS results. World map animates with resolver pings. Globe rotates with arc connectors. Marquee scrolls. CLI types. Contact form submits. All tools use the REST API.

**Gate 2 Review:** Founders test DNS lookup for real domains, check propagation results, verify animations, test on mobile. Go/no-go.

---

## Phase 3: AI Chat + Polish (→ Gate 3)

### 3.1 — AI Integration Specialist: Chat component
- Adapt from vagra-msp:
  - `inc/class-vagra-nsl-chat.php` — REST route `vagra-nsl/v1/chat`, rate limiting, Claude API proxy
  - `template-parts/ai-chat.php` — chat widget markup styled for cinematic dark theme
  - `assets/js/vagra-chat.js` — vanilla JS chat UI (session storage, typing indicator, keyboard support)
  - `assets/css/vagra-chat.css` — chat styles using `--nsl-*` design tokens

### 3.2 — AI Integration Specialist: DNS chat persona
- `inc/chat-prompts/vagra-nsl.txt` — system prompt:
  - Persona: Helpful DNS assistant
  - Can answer: DNS concepts, record types, propagation timing, how to use the tool, troubleshooting
  - Cannot answer: specific network config advice, server administration, pricing for services
  - Links to sister tools when relevant (SPF → spf-checker.org, etc.)
- Verify 10 test queries:
  1. "What is DNS propagation?"
  2. "What's the difference between A and AAAA records?"
  3. "My domain isn't resolving, what should I check?"
  4. "How do I set up DMARC?"
  5. "What is TTL and how does it affect propagation?"
  6. "How do I check DNS records from the command line?"
  7. "What's the difference between nslookup and dig?"
  8. "How long does DNS propagation take?"
  9. "Can you help me configure my DNS server?" (must redirect)
  10. "Is this tool free?"

### 3.3 — Theme Architect: Customizer integration
- `inc/customizer.php`:
  - Panel: "nslookup.am Settings"
  - Section: Brand Colors — primary (indigo), accent (cyan) overrides
  - Section: Typography — font override options
  - Section: AI Chat — API key, enable/disable, title, system prompt override
  - Section: DNS Tool — default resolver, max concurrent queries toggle
- `inc/class-vagra-nsl-admin.php` — admin settings page for API key management

### 3.4 — Theme Architect: Accessibility + performance polish
- Verify all pages respect `prefers-reduced-motion`
- Audit ARIA labels on interactive elements (tool forms, FAQ accordions, mobile menu)
- Add `loading="lazy"` to below-fold images
- Verify `<title>` tags and meta descriptions on all templates
- Editor styles: `assets/css/editor-style.css` matching front-end article typography
- Test cross-browser: Chrome, Firefox, Safari, Edge

**Gate 3 Deliverable:** AI chat works with DNS-focused persona. Customizer settings functional. Accessibility and performance polished. Theme is feature-complete.

**Gate 3 Review:** Founders test chat, verify Customizer controls, run Lighthouse. Go/no-go.

---

## Phase 4: Demo Content + Submission (→ Gate 4)

### 4.1 — Demo Content Writer: Blog posts and page content
- 6 blog posts with real educational value (see agent-roles.md for full list)
- Page content for: About, Contact, FAQ (40+ questions across 4 categories), Privacy, Terms
- Content for the "Other DNS Tools" hub page (12 tool descriptions)

### 4.2 — Demo Content Writer: Demo import files
- `demo-content/demo-content.xml` — WordPress eXtended RSS with all pages and posts
- `demo-content/customizer.json` — theme customizer settings
- `demo-content/widgets.json` — widget area configuration
- `inc/demo-import.php` — one-click import handler (recommends OCDI plugin)

### 4.3 — Theme Architect: WordPress.org submission prep
- `screenshot.png` (1200x900) showing the cinematic homepage
- `readme.txt` in WordPress standard format
- `/languages/vagra-nslookup.pot` translation file
- Run Theme Check — fix all errors
- Run Plugin Check — fix all errors
- Final escaping/sanitization audit of all template files
- Verify all strings wrapped in `__()` / `esc_html__()` with text domain `vagra-nslookup`
- Verify PageSpeed > 90 on front page with demo content

### 4.4 — Theme Architect: Create WordPress pages via WP-CLI
```bash
wp option update show_on_front page
wp post create --post_type=page --post_title='Home' --post_status=publish
wp post create --post_type=page --post_title='NS Lookup' --post_name='ns-lookup' --post_status=publish
wp post create --post_type=page --post_title='DNS Propagation Checker' --post_name='propagation' --post_status=publish
wp post create --post_type=page --post_title='Other DNS Tools' --post_name='tools' --post_status=publish
wp post create --post_type=page --post_title='About' --post_name='about' --post_status=publish
wp post create --post_type=page --post_title='Contact' --post_name='contact' --post_status=publish
wp post create --post_type=page --post_title='FAQ' --post_name='faq' --post_status=publish
wp post create --post_type=page --post_title='Privacy Policy' --post_name='privacy' --post_status=publish
wp post create --post_type=page --post_title='Terms of Service' --post_name='terms' --post_status=publish
```

**Gate 4 Deliverable:** Theme complete with demo content, passing Theme Check and Plugin Check, ready for WordPress.org submission.

**Gate 4 Review:** Founders do full walkthrough — fresh install, activate theme, import demo, browse all pages, test DNS tools, test chat, check PageSpeed. Ship/no-ship decision.

---

## Timeline Estimate
- Phase 1: ~1.5 weeks (largest phase — 12 templates + full CSS)
- Phase 2: ~1.5 weeks (React components + DNS backend)
- Phase 3: ~1 week (chat + polish)
- Phase 4: ~1 week (demo content + submission prep)
- Buffer for gate reviews and fixes: 1 week
- **Total: ~6 weeks to submission-ready**

## Budget Estimate
- Theme Architect: ~$60 (largest workload — templates, CSS, coordination)
- Frontend Specialist: ~$40 (React islands, Vite, 7 components)
- DNS Backend Specialist: ~$20 (single API class, well-scoped)
- AI Integration Specialist: ~$25 (adapted from vagra-msp, smaller scope)
- Demo Content Writer: ~$20 (blog posts, page content, import files)
- **Total: ~$165 for full delivery**

## Dependencies Between Agents

```
Phase 1:  Theme Architect (solo)
              |
          Gate 1 ✓
              |
Phase 2:  Theme Architect ←→ Frontend Specialist ←→ DNS Backend Specialist
          (mount points)      (React components)      (REST API)
              |                    |                       |
          Gate 2 ✓ (all three must complete)
              |
Phase 3:  AI Integration Specialist + Theme Architect (polish)
              |
          Gate 3 ✓
              |
Phase 4:  Demo Content Writer + Theme Architect (submission)
              |
          Gate 4 ✓ → Ship
```
