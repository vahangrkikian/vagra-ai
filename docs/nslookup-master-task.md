# Master Task — nslookup.am WordPress Theme

## Title
Deliver nslookup.am DNS Tool WordPress theme with React islands, live DNS lookup, and AI chat

## Description

You are the **Theme Architect**, lead agent for the nslookup.am project. Your job is to deliver a complete WordPress theme (`vagra-nslookup`) that recreates the cinematic Apple-style design prototypes as a production WordPress theme with React interactive components.

### What is nslookup.am?
A free web-based DNS propagation and record lookup tool. It belongs to the same product family as spf-checker.org, dmarc-checker.org, bimi-checker.org, and dkim-checker.org. The site must cross-link to all sister sites.

**Brand promise:** Free, instant, no-signup DNS propagation & record lookup across 30+ global resolvers. Supported record types: A, AAAA, CNAME, MX, NS, TXT, SPF, DKIM, DMARC, SOA, PTR, CAA, SRV.

**Architecture:** WordPress PHP templates (SEO/structure) + React islands (interactive tools). Vite compiles React source to static bundles committed to the repo.

### Context Files (read ALL before starting)
- `C:/OSPanel/domains/vagraAI/docs/nslookup-orchestration-plan.md` — phased delivery plan with 4 approval gates
- `C:/OSPanel/domains/vagraAI/docs/nslookup-agent-roles.md` — your role and specialist roles
- `C:/OSPanel/domains/vagraAI/docs/wordpress-standards.md` — WordPress.org compliance rules

### Design Prototypes (read BEFORE writing any code)
- `C:/OSPanel/domains/vagraAI/nslookup/chats/chat1.md` — full design conversation with intent
- `C:/OSPanel/domains/vagraAI/nslookup/project/Homepage.html` — homepage shell
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/tokens.css` — design tokens (colors, fonts, spacing, shadows, motion)
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/site.css` — component CSS classes
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/cinematic.css` — cinematic animation system
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/components.jsx` — TopNav, Footer, WorldMap, HeroTool
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/sections.jsx` — Hero, HowItWorks, WhyUse, RecordTypes, FAQ, ExploreMore, Footer
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-home.jsx` — cinematic homepage (CineHero, CineMarquee, CineStatement, CineGlobe, CineWhy, CineFinal)
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-parts.jsx` — shared: CineSubHero, CineFinalCTA, useCineReveal
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-ns.jsx` — NS Lookup page
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-prop.jsx` — Propagation Checker page
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-tools.jsx` — Other DNS Tools page
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-blog.jsx` — Blog listing
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-post.jsx` — Blog post
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-about.jsx` — About page
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-contact.jsx` — Contact page
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-faq.jsx` — FAQ page
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-legal.jsx` — Privacy/Terms layout
- `C:/OSPanel/domains/vagraAI/nslookup/project/shared/page-cine-404.jsx` — 404 page

### Pattern Reference (existing themes)
- `C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-msp/functions.php` — setup, enqueue, widget pattern
- `C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-msp/header.php` — header template pattern
- `C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-msp/footer.php` — footer template pattern
- `C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-msp/front-page.php` — homepage template pattern
- `C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-msp/inc/class-vagra-chat.php` — chat class pattern

### Environment
- WordPress 6.9.4 installed at C:/OSPanel/domains/vagraAI/
- Site URL: vagraai.local
- WP-CLI available
- Node.js available (for Vite build)
- vagra-msp and vagra-legal themes already exist as references
- Theme goes in: `wp-content/themes/vagra-nslookup/`

### Execution Rules
1. Follow `nslookup-orchestration-plan.md` exactly — Phase 1 → Gate 1 → Phase 2 → Gate 2 → Phase 3 → Gate 3 → Phase 4 → Gate 4
2. At each gate, **STOP** and report status. List what was completed, what works, what doesn't. Wait for human approval before proceeding.
3. When you need specialist work, create sub-issues and assign to the appropriate agent role (see `nslookup-agent-roles.md`)
4. All theme code goes in `C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-nslookup/`
5. Follow WordPress coding standards — prefix `vagra_nsl_`, text domain `vagra-nslookup`, escape, sanitize, translate
6. Do not install plugins. Do not modify wp-config.php. Do not touch the database directly (except via WP-CLI).
7. **Pixel-perfect match** to the cinematic prototypes. Read the HTML/CSS source directly — all dimensions, colors, and layout rules are in the code.

### Design System Quick Reference
- **Primary:** #4F46E5 (Indigo) | **Accent:** #0EA5C4 (Cyan)
- **Fonts:** Inter (UI) + JetBrains Mono (code/DNS records)
- **Dark hero bg:** #0B0D14 | **Cinematic accents:** #A5B4FC, #67E8F9, #C4B5FD
- **Radii:** 4px–999px | **Shadows:** 5 levels (xs through xl)
- **Motion:** cubic-bezier(0.22, 1, 0.36, 1), durations 140ms/240ms/420ms
- **Container:** 1200px max, 24px padding
- **Breakpoints:** <980px mobile (burger nav), 1200px+ desktop

### React Island Mount Points
These `<div>` IDs in PHP templates are hydrated by React:

| Mount ID | Template | React Component |
|----------|----------|-----------------|
| `nsl-hero-tool` | front-page.php | HeroTool (DNS lookup + WorldMap) |
| `nsl-marquee` | front-page.php | CineMarquee |
| `nsl-cli` | front-page.php | CineCLI |
| `nsl-globe` | front-page.php | CineGlobe |
| `nsl-ns-tool` | page-ns-lookup.php | NSTool |
| `nsl-prop-tool` | page-propagation.php | PropTool + WorldMap |
| `nsl-contact-form` | page-contact.php | ContactForm |

### Phase 1 Checklist (do this first)
- [ ] Create `vagra-nslookup/` theme directory with full scaffold
- [ ] Merge tokens.css + site.css + cinematic.css into style.css
- [ ] Build functions.php (setup, enqueue, menus, widgets)
- [ ] Build header.php (sticky TopNav, wp_nav_menu, mobile burger, CTA)
- [ ] Build footer.php (dark footer, sister links, wp_nav_menu, copyright)
- [ ] Build 7 template parts (cine-sub-hero, cine-final-cta, cine-stats, cine-features, faq-accordion, sister-tools, record-types-grid)
- [ ] Build front-page.php (cinematic homepage with all React mount points)
- [ ] Build page-ns-lookup.php
- [ ] Build page-propagation.php
- [ ] Build page-tools.php
- [ ] Build page-about.php, page-contact.php, page-faq.php, page-privacy.php, page-terms.php
- [ ] Build 404.php (NXDOMAIN themed)
- [ ] Build archive.php, single.php (cinematic blog templates)
- [ ] Build page.php, index.php, sidebar.php, searchform.php (fallbacks)
- [ ] Build assets/js/main.js (scroll reveal, mobile menu, card mouse-tracking, reduced motion)
- [ ] Create WordPress pages via WP-CLI
- [ ] Activate theme and verify all pages render at vagraai.local
- [ ] **STOP — Report Gate 1 status and wait for approval**

### After Gate 1 Approval
Proceed to Phase 2 per orchestration-plan. Create sub-issues for:
- **Frontend Specialist:** Vite setup + all React island components
- **DNS Backend Specialist:** DNS lookup REST API class

### After Gate 2 Approval
Proceed to Phase 3. Create sub-issues for:
- **AI Integration Specialist:** Chat component adapted from vagra-msp

### After Gate 3 Approval
Proceed to Phase 4. Create sub-issues for:
- **Demo Content Writer:** Blog posts, page content, demo import files

### Success Criteria
1. Theme passes WordPress.org Theme Check with zero errors
2. Theme passes Plugin Check with zero errors
3. DNS lookup returns real results for any valid domain
4. Propagation check queries 30+ resolvers and displays results on world map
5. AI chat responds correctly to 10 DNS-focused test queries
6. Demo import works in under 2 minutes on a fresh WordPress install
7. PageSpeed score > 90 on front page with demo content
8. All 12 pages visually match the cinematic prototypes
9. All sister site cross-links (SPF/DKIM/DMARC/BIMI) work
10. Responsive: works on mobile (burger menu, stacked layout, touch-friendly)
11. Respects `prefers-reduced-motion` — all animations disabled
