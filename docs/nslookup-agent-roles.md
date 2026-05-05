# nslookup.am Agent Roles

## Theme Architect (Lead Agent)
**Adapter:** Claude Code
**Responsibility:** Orchestrates the full delivery pipeline. Owns WordPress theme structure, PHP templates, CSS design system, template hierarchy, and task delegation.
**Working directory:** C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-nslookup/
**Can delegate to:** Frontend Specialist, DNS Backend Specialist, AI Integration Specialist, Demo Content Writer
**Approval authority:** Can merge code changes. Cannot skip approval gates.

### What this agent does:
- Creates and maintains the vagra-nslookup theme directory structure
- Merges design tokens (tokens.css + site.css + cinematic.css) into style.css
- Builds all PHP templates: header.php, footer.php, front-page.php, all page-*.php, archive.php, single.php, 404.php
- Builds reusable template parts: cine-sub-hero.php, cine-final-cta.php, cine-stats.php, cine-features.php, faq-accordion.php, sister-tools.php, record-types-grid.php
- Creates functions.php with setup, enqueue, widget areas, menu registration
- Writes main.js (vanilla JS: scroll reveal, mobile menu, card mouse-tracking, reduced-motion)
- Ensures WordPress.org Theme Directory compliance
- Coordinates work across specialist agents
- Reports status at each approval gate

### What this agent does NOT do:
- Build React components (delegates to Frontend Specialist)
- Build the DNS lookup API (delegates to DNS Backend Specialist)
- Build the AI chat component (delegates to AI Integration Specialist)
- Write demo content copy (delegates to Demo Content Writer)
- Make design decisions without referencing the prototype files in nslookup/project/

### Source files to reference:
- `nslookup/project/shared/tokens.css` — design tokens
- `nslookup/project/shared/site.css` — component CSS classes
- `nslookup/project/shared/cinematic.css` — cinematic animations
- `nslookup/project/shared/components.jsx` — TopNav and Footer (convert JSX to PHP)
- `nslookup/project/shared/sections.jsx` — homepage sections (convert JSX to PHP)
- `nslookup/project/shared/page-cine-parts.jsx` — CineSubHero, CineFinalCTA (convert to template parts)
- `nslookup/project/shared/page-cine-home.jsx` — homepage cinematic layout
- `nslookup/project/shared/page-cine-*.jsx` — all page-specific cinematic layouts
- `wp-content/themes/vagra-msp/functions.php` — pattern reference for WP setup

---

## Frontend Specialist
**Adapter:** Claude Code
**Responsibility:** Builds React island components and the Vite build pipeline. Owns all JSX source code in `src/` and the compiled output in `assets/js/dist/`.
**Working directory:** C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-nslookup/
**Reports to:** Theme Architect

### What this agent does:
- Sets up Vite build: package.json, vite.config.js, @vitejs/plugin-react
- Creates the island hydration orchestrator (src/index.js) that detects mount-point `<div>` elements and lazy-loads the correct React component
- Ports interactive components from JSX prototypes to production React:
  - `src/shared/world-map.jsx` — SVG dot-grid world map with animated resolver pings
  - `src/shared/cine-globe.jsx` — animated globe with arc connectors, traveling dots, pulsing rings
  - `src/shared/cine-marquee.jsx` — infinite horizontal scroll of DNS record types
  - `src/shared/cine-cli.jsx` — terminal typing moment with blinking cursor
  - `src/shared/scroll-reveal.js` — useReveal IntersectionObserver hook
  - `src/islands/hero-tool.jsx` — homepage interactive DNS lookup panel (record type pills, domain input, resolver dropdown, live result table with WorldMap)
  - `src/islands/ns-tool.jsx` — NS Lookup tool page (compact tool card, result table with copy/CSV/JSON export)
  - `src/islands/prop-tool.jsx` — DNS Propagation Checker (world map propagation, per-city results with filter chips)
  - `src/islands/contact-form.jsx` — multi-step contact form with topic pills
- Connects tool components to the DNS REST API via `fetch()` using `nslConfig.restUrl` and `nslConfig.nonce` (localized by WordPress)
- Runs `npm run build` to produce `assets/js/dist/nsl-shared.js` and `assets/js/dist/nsl-islands.js`
- Commits built files to the repo (theme works without a build step in production)

### What this agent does NOT do:
- Modify PHP templates (except adding `<div id="nsl-*">` mount points if missing)
- Write CSS (uses classes from style.css built by Theme Architect)
- Build the DNS backend API (delegates to DNS Backend Specialist)
- Make design decisions (pixel-perfect match of prototypes)

### Source files to reference:
- `nslookup/project/shared/components.jsx` — WorldMap, HeroTool, RESOLVERS data
- `nslookup/project/shared/page-cine-home.jsx` — CineGlobe, CineMarquee, CineCLI, CineStatement
- `nslookup/project/shared/page-cine-ns.jsx` — NS Lookup tool component
- `nslookup/project/shared/page-cine-prop.jsx` — Propagation tool component
- `nslookup/project/shared/page-cine-contact.jsx` — Contact form component
- `nslookup/project/shared/page-cine-parts.jsx` — useCineReveal hook

### Mount point contract (agreed with Theme Architect):
| Mount ID | Page | Component |
|----------|------|-----------|
| `nsl-hero-tool` | front-page.php | HeroTool (DNS lookup + WorldMap) |
| `nsl-marquee` | front-page.php | CineMarquee |
| `nsl-cli` | front-page.php | CineCLI |
| `nsl-globe` | front-page.php | CineGlobe |
| `nsl-ns-tool` | page-ns-lookup.php | NSTool |
| `nsl-prop-tool` | page-propagation.php | PropTool + WorldMap |
| `nsl-contact-form` | page-contact.php | ContactForm |

---

## DNS Backend Specialist
**Adapter:** Claude Code
**Responsibility:** Builds the DNS lookup REST API that powers the interactive tool components.
**Working directory:** C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-nslookup/inc/
**Reports to:** Theme Architect

### What this agent does:
- Builds `inc/class-vagra-nsl-dns.php` — WordPress REST API endpoint
  - Route: `POST /vagra-nsl/v1/lookup`
  - Accepts: `{ domain: string, type: string, resolver?: string }`
  - Supported types: A, AAAA, CNAME, MX, NS, TXT, SPF, DKIM, DMARC, SOA, PTR, CAA, SRV
  - Uses PHP `dns_get_record()` as primary method
  - Falls back to `shell_exec('dig ...')` when available for types not supported by PHP
  - For propagation fanout: queries 30+ public resolver IPs (Google, Cloudflare, Quad9, OpenDNS, plus regional resolvers across 6 continents)
  - Rate limiting: 60 requests/hour per IP via WordPress transients
  - Input validation: sanitize domain (check valid hostname), whitelist record types
  - Returns JSON: `{ results: [{ resolver, name, location, ip, ttl, status, responseTime }] }`
- Builds `POST /vagra-nsl/v1/propagation` — multi-resolver fanout endpoint
  - Queries all 30+ resolvers for a single domain+type
  - Returns per-resolver results with location data
- Hardcodes a resolver registry with metadata (name, IP, location, country)
- Ensures no `exec()` or `shell_exec()` is used when disabled by the host (checks `function_exists` + `ini_get('disable_functions')`)

### What this agent does NOT do:
- Modify any file outside `inc/class-vagra-nsl-dns.php`
- Make external HTTP requests to third-party DNS APIs (uses native PHP/system DNS only)
- Store any user data beyond rate-limit transients
- Build frontend components

### API contract (agreed with Frontend Specialist):
```
POST /wp-json/vagra-nsl/v1/lookup
Headers: X-WP-Nonce: {nonce}
Body: { "domain": "example.com", "type": "A", "resolver": "8.8.8.8" }
Response: {
  "success": true,
  "results": [{
    "resolver": "8.8.8.8",
    "name": "Google Public DNS",
    "location": "Ashburn, US",
    "records": [{ "ip": "93.184.216.34", "ttl": 3600, "type": "A" }],
    "status": "ok",
    "responseTime": 24
  }]
}

POST /wp-json/vagra-nsl/v1/propagation
Headers: X-WP-Nonce: {nonce}
Body: { "domain": "example.com", "type": "A" }
Response: {
  "success": true,
  "results": [ ...30+ resolver entries... ]
}
```

---

## AI Integration Specialist
**Adapter:** Claude Code
**Responsibility:** Builds the AI chat component for the nslookup.am theme. Adapts the shared vagra chat engine with DNS-specific persona.
**Working directory:** C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-nslookup/
**Reports to:** Theme Architect

### What this agent does:
- Adapts `inc/class-vagra-nsl-chat.php` from vagra-msp pattern
  - REST route: `vagra-nsl/v1/chat`
  - Rate limiting: 20 requests/hour per IP
  - Claude API proxy with configurable model
- Creates `inc/chat-prompts/vagra-nsl.txt` — DNS assistant persona:
  - Can answer: DNS concepts, record types, propagation, how to use the tool, troubleshooting common DNS issues
  - Cannot answer: specific network configuration advice, pricing for paid DNS services
  - Tone: technical-but-approachable, matching the sister sites
- Builds `template-parts/ai-chat.php` styled for the cinematic dark theme
- Adapts `assets/js/vagra-chat.js` (vanilla JS, same pattern as vagra-msp)
- Adapts `assets/css/vagra-chat.css` using `--nsl-*` design tokens
- Customizer integration: API key, enable/disable, system prompt override, chat title

### What this agent does NOT do:
- Modify theme templates outside of chat integration points
- Make design decisions (follows --nsl-* design tokens from style.css)
- Bundle external dependencies

### Source files to reference:
- `wp-content/themes/vagra-msp/inc/class-vagra-chat.php` — pattern reference
- `wp-content/themes/vagra-msp/assets/js/vagra-chat.js` — JS pattern reference
- `wp-content/themes/vagra-msp/assets/css/vagra-chat.css` — CSS pattern reference
- `wp-content/themes/vagra-msp/template-parts/ai-chat.php` — markup reference

---

## Demo Content Writer
**Adapter:** Claude Code
**Responsibility:** Creates all demo content for the nslookup.am theme — blog posts, page content, and demo import files.
**Working directory:** C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-nslookup/
**Reports to:** Theme Architect

### What this agent does:
- Writes 6 blog posts with real educational value:
  1. "DNS Propagation Explained: Why Changes Take Time"
  2. "A Complete Guide to DNS Record Types"
  3. "How to Troubleshoot DNS Issues"
  4. "Understanding TTL: Time to Live in DNS"
  5. "SPF, DKIM, and DMARC: Email Authentication DNS Records"
  6. "nslookup vs dig vs host: Command-Line DNS Tools Compared"
- Writes page content for: About, Contact, FAQ (40+ questions), Privacy Policy, Terms of Service
- Creates demo-content/demo-content.xml (WordPress eXtended RSS)
- Creates demo-content/customizer.json
- Creates demo-content/widgets.json
- Creates inc/demo-import.php (one-click import handler)

### What this agent does NOT do:
- Modify PHP templates or CSS
- Create images (uses placeholder references only)
- Write content that contradicts DNS RFCs or is technically inaccurate
