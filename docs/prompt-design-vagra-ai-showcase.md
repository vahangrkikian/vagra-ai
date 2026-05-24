# Design Prompt — vagra.ai Theme Showcase & Marketplace Website

---

## CONTEXT

You are designing the **vagra.ai showcase website** — the public-facing marketing site where visitors discover, preview, and acquire vagra.ai's niche WordPress themes. This is NOT one of the themes themselves — this is the **platform homepage** that sells all 7 themes.

vagra.ai's positioning: **"AI-powered niche WordPress themes that know your industry."** Unlike Avada (1 theme, 113 demos) or Astra (1 theme, 300+ starter templates), vagra.ai ships **purpose-built themes** — each one designed from scratch for a single vertical, with a native AI concierge that speaks the industry's language.

---

## COMPETITIVE LANDSCAPE ANALYSIS

### What the market leaders do (and what we learn from them):

**Avada (1M+ users, #1 ThemeForest all-time)**
- Hero: Bold stat-driven ("1,050,000+ satisfied users") + single CTA
- Core pattern: Interactive tabbed feature explorer → filterable demo grid (113+ sites by industry)
- Conversion: Single price point ($69), no subscription complexity
- Weakness: Generic multipurpose — "everything for everyone" = nothing for anyone specifically

**Divi by Elegant Themes (800K+ customers)**
- Hero: Position as ecosystem/platform, not just a theme
- Core pattern: Role-based navigation (agencies / freelancers / business owners / store owners)
- Conversion: Membership model ($249 lifetime / $89/yr) creating exclusivity
- Weakness: Heavy, opinionated builder — locks users into Divi ecosystem

**Astra (900K+ active installs)**
- Hero: "Fast, Lightweight & Customizable" + active install count as trust signal
- Core pattern: Starter Templates library as primary CTA (300+ templates browsable by niche)
- Conversion: Freemium + annual ($49-249/yr), ecosystem cross-sell (Schema Pro, CartFlows)
- Weakness: Starter templates are skins on one theme — not truly niche-optimized

**ThemeForest Marketplace**
- Card design: 590x300 thumbnail + title + author + category + price + reviews + sales count
- Trust signals: "78.7M items sold", weekly updated rankings
- Pattern: Category sidebar filtering + time-based sorting

**Niche Theme Success Factors (WPMayor Top 20 analysis):**
- Industry-specific built-in tools (booking, menu builders, property listings, donation forms)
- Ready-to-go layouts requiring only content swap
- Prices $49-79 on ThemeForest
- 24/7 support as differentiator
- Top niches: Spa, Non-Profit, Education, Real Estate, Dental, Legal, Restaurant, HVAC, Plumbing

---

## VAGRA.AI'S DIFFERENTIATION

What no competitor does — and what vagra.ai leads with:

1. **Native AI concierge per vertical** — Not a chatbot plugin bolted on. A domain-expert assistant trained for each industry (legal intake, security advisor, hotel concierge, DNS expert, auto advisor, travel guide, rental agent).

2. **One theme = one niche** — Not 300 starter templates on one bloated theme. Seven purpose-built themes, each with its own design system, CPTs, booking flows, and domain logic.

3. **WordPress.org free + Pro upgrades** — Not locked behind a $69 paywall. Free core themes with premium AI/booking features.

4. **Performance by design** — No jQuery, no page builders, no bloat. Vanilla JS, CSS custom properties, semantic HTML. PageSpeed 90+ out of the box.

---

## DESIGN BRIEF

### Brand Identity

**Name:** vagra.ai
**Tagline:** "AI-powered WordPress themes that know your industry."
**Tone:** Confident, technical, understated. Not flashy — competent. Think Vercel/Linear/Stripe, not ThemeForest carnival.

**Color System:**
```
Primary:     #0B0D14 (near-black — authority, technical depth)
Surface:     #111318 (card backgrounds)
Elevated:    #1A1D25 (hover states, modals)
Border:      #2A2D35 (subtle dividers)
Muted:       #6B7280 (secondary text)
Body:        #D1D5DB (primary text on dark)
Bright:      #F9FAFB (headings, emphasis)
Accent:      #6366F1 (indigo — links, CTAs, active states)
Accent-soft: #818CF8 (hover, secondary accent)
Gold:        #D4AF37 (premium badge, highlights)
Success:     #10B981 (active/live indicators)
```

**Typography:**
```
Headings:  Inter (weight 600-700) or Geist Sans — clean, geometric, modern
Body:      Inter (weight 400-500) — universally readable
Mono:      JetBrains Mono — code snippets, technical details
Scale:     clamp() for fluid sizing, 1.2 minor-third ratio
```

**Visual Language:**
- Dark mode default (light mode secondary)
- Subtle gradients (not flat, not skeuomorphic)
- Glassmorphism for elevated cards (backdrop-blur, semi-transparent borders)
- Micro-animations on scroll (translateY + opacity, 600ms ease-out)
- Accent glow on interactive elements (box-shadow with accent color at 15% opacity)
- Grid-based layouts with generous whitespace (80-120px section padding)
- No stock photography — SVG illustrations, theme screenshots, live previews

---

## PAGE STRUCTURE

### Page 1: Homepage (vagra.ai)

**Section 1 — Hero (above fold)**
```
Layout: Full-width dark, centered text, subtle animated background (grid pattern or particle field)

Content:
- Eyebrow: "7 niches. 7 themes. 7 AI concierges."
- H1: "WordPress themes that know your industry."
- Subtitle: "Purpose-built themes with native AI assistants for cybersecurity firms, law offices, hotels, car services, DNS tools, tourism, and car rental. Free on WordPress.org."
- Primary CTA: "Explore Themes" (scrolls to theme grid)
- Secondary CTA: "See AI in action" (scrolls to demo)
- Trust bar: "7 themes · 6 verticals · PageSpeed 90+ · WordPress.org compliant · GPL-2.0"
```

**Section 2 — Theme Showcase Grid**
```
Layout: 2-3 column responsive grid, each card is a theme preview

Each theme card:
┌─────────────────────────────────┐
│  [Live screenshot / SVG hero]   │
│                                 │
│  Niche pill: "Cybersecurity"    │
│  Theme name: "Vagra MSP"       │
│  One-liner: "Security services  │
│  that sell themselves."         │
│                                 │
│  AI badge: "AI: Security Advisor│
│  ● Live"                        │
│                                 │
│  [Preview]  [Details →]         │
└─────────────────────────────────┘

Cards for all 7 themes:
1. Vagra MSP — Cybersecurity (blue)
2. Vagra Legal — Law Firm (navy/gold)
3. Vagra NSLookup — DNS Tools (indigo/cyan)
4. Carvice — Car Service (dark/blue)
5. DriveEase — Car Rental (green)
6. TourVice — Tourism (warm earth)
7. Meridian — Hotel (navy/gold)

Filter tabs above grid: All | Business | Tools | Automotive | Hospitality
```

**Section 3 — The AI Difference**
```
Layout: Split — left text, right interactive demo

Left:
- Eyebrow: "Not a chatbot plugin."
- H2: "An AI concierge that speaks your industry."
- Body: "Every vagra.ai theme ships with a domain-trained AI assistant. 
  The legal theme won't give legal advice — it captures intake. 
  The hotel theme books rooms. 
  The MSP theme explains DMARC to prospects."
- Bullet points:
  ✓ Trained per vertical — not generic
  ✓ Captures leads — name, email, intent
  ✓ No data stored on server — sessionStorage only
  ✓ Your API key — your control
  ✓ Customizer: edit system prompt without code

Right:
- Interactive chat demo switcher
  - Tabs: "Hotel" | "Legal" | "MSP" | "DNS"
  - Live chat widget preview showing sample conversation
  - E.g., Hotel tab shows: "What rooms have a view?" → concierge response
```

**Section 4 — How It Works (3-step)**
```
Layout: 3 columns, each with icon + heading + description

1. [Download icon] "Install free from WordPress.org"
   "Each theme is GPL-licensed and free. Install it like any WordPress theme."

2. [Wand icon] "One-click demo import"  
   "Import rooms, services, team members, and pages in 30 seconds. Just replace the content."

3. [Key icon] "Add your AI key"
   "Paste your Claude API key in the Customizer. Your concierge is live in under a minute."
```

**Section 5 — Performance & Standards**
```
Layout: Stats bar (horizontal, dark section with accent borders)

[90+]          [0]           [GPL-2.0]       [EN/AM/RU]      [6.9+]
PageSpeed      Theme Check   Licensed        Multilingual    WP Compatible
Score          Errors        & Free          Ready           & Tested
```

**Section 6 — Testimonials / Social Proof**
```
Layout: 3-column card grid (or carousel on mobile)

Each card:
- Quote text
- Author name + role + company type
- Star rating

(Use realistic fictional testimonials until real ones exist)
```

**Section 7 — Pricing**
```
Layout: Centered, clean table or card comparison

Free (WordPress.org):
- Full theme + all templates
- AI chat widget (BYOK — bring your own key)
- Demo content import
- Community support

Pro ($49/year per theme):
- Premium page templates
- Priority support
- Extended demo content packs
- Advanced Customizer options
- White-label option

Agency ($199/year — all themes):
- All 7 themes, Pro features
- Unlimited sites
- Priority support
- Early access to new themes
- White-label + remove credit
```

**Section 8 — FAQ**
```
Layout: Accordion (details/summary)

Q: "Is this really free?"
A: "Yes. The core themes are GPL-2.0 and free on WordPress.org. Pro features are optional."

Q: "Do I need an API key for the AI chat?"
A: "Yes — you bring your own Claude API key. This means you control costs and data."

Q: "Can I use these for client sites?"
A: "Absolutely. GPL license means unlimited use. Agency plan adds white-label support."

Q: "How is this different from Starter Templates?"
A: "Starter templates are skins on one generic theme. Each vagra.ai theme is purpose-built with industry-specific CPTs, booking systems, and AI behavior."

Q: "What about updates and support?"
A: "Free themes get updates via WordPress.org. Pro users get priority support and early updates."
```

**Section 9 — Final CTA**
```
Layout: Full-width dark section with accent gradient border top

H2: "Your industry deserves more than a starter template."
CTA: "Get Started — Free" → links to theme grid or WordPress.org
Secondary: "View on GitHub" → open source repo
```

**Footer:**
```
4-column layout:
1. vagra.ai logo + tagline + social links (GitHub, X, LinkedIn)
2. Themes: MSP, Legal, NSLookup, Carvice, DriveEase, TourVice, Meridian
3. Resources: Documentation, Changelog, Support, Blog, Status
4. Company: About Ethiuni, Contact, Careers, Press Kit

Bottom bar: "© 2026 Ethiuni. All themes GPL-2.0-or-later." + Privacy + Terms
```

---

### Page 2: Individual Theme Page (e.g., vagra.ai/themes/meridian)

```
Structure:
1. Theme hero — full-width screenshot/preview + theme name + niche + one-liner
2. Live Preview iframe with device switcher bar (Desktop / Tablet / Mobile)
3. Features grid — 6-8 cards showing key capabilities (Rooms CPT, Booking Wizard, AI Concierge, etc.)
4. Screenshots carousel — 4-6 annotated screenshots of key pages
5. AI Chat demo — live interactive preview of the theme's AI persona
6. Tech specs — WP version, PHP version, file size, PageSpeed score, supported plugins
7. Demo content preview — "What you get" list (X rooms, Y pages, Z menu items)
8. Download / Buy CTA
9. Related themes — "Also explore" horizontal scroll of other themes
```

---

### Page 3: Live Preview (vagra.ai/preview/meridian)

```
Structure:
- Top bar (40px height, dark):
  Left: vagra.ai logo + theme name
  Center: Device switcher icons (Desktop / Tablet / Mobile)
  Right: "Buy Now" CTA + Close (X)

- Main area: Full iframe of the theme's demo site
- Optional: Left sidebar panel (collapsible) showing:
  - Theme info (name, version, price)
  - Demo page navigation (Home, Rooms, About, etc.)
  - Color scheme switcher (if theme supports it)
```

---

## INTERACTIVE PATTERNS

### Demo Bar (Live Preview Toolbar)
Inspired by ThemeForest's LivePreview pattern but elevated:
- Sticky top bar wrapping an iframe
- Device switcher with smooth width transitions (not just responsive breakpoints — actual device frame mockups)
- Page navigator dropdown for jumping between demo pages
- "Buy Now" always visible with price
- Share button (copy link)

### Theme Card Hover
- Subtle scale(1.02) + shadow elevation
- Screenshot parallax tilt (subtle, 2-3 degrees max)
- Accent border glow appears on hover
- "Preview" button slides in from bottom

### Chat Demo Widget
- Embedded in the "AI Difference" section
- Tab switcher changes the chat context (Hotel / Legal / MSP / DNS)
- Pre-loaded with 2-3 sample messages showing the AI persona
- User can type a real message (optional — connects to demo API or shows "sign up to try")
- Typing indicator animation when "AI is responding"

### Scroll Animations
- Sections fade in on scroll (translateY: 30px → 0, opacity: 0 → 1)
- Staggered delay for grid items (each card 80ms after the previous)
- Stats counter animation (numbers count up from 0 when section enters viewport)
- Subtle parallax on hero background elements

---

## RESPONSIVE STRATEGY

```
Desktop (1200px+):   3-col theme grid, side-by-side sections, full nav
Tablet (768-1199px): 2-col theme grid, stacked sections, hamburger nav
Mobile (< 768px):    1-col everything, bottom sticky CTA bar, simplified hero
```

Mobile-specific:
- Bottom sticky bar: "Explore Themes" CTA always accessible
- Swipeable theme cards (horizontal scroll)
- Chat demo: full-screen modal on tap
- Collapsed FAQ by default
- Simplified stats (2x2 grid instead of 5-col row)

---

## TECHNICAL IMPLEMENTATION NOTES

Build this as a WordPress theme itself (`vagra-showcase`) on the main `vagraai.local` site:

- Static front page with all sections
- `front-page.php` for the homepage
- `page-theme-single.php` template for individual theme pages
- `page-preview.php` template for live preview iframe wrapper
- CSS custom properties matching the brand system above
- Vanilla JS for scroll animations, device switcher, chat demo
- No page builder dependency — hand-coded templates
- Preconnect Google Fonts (Inter), lazy-load screenshots
- Structured data (JSON-LD) for SoftwareApplication schema per theme

---

## WHAT SUCCESS LOOKS LIKE

A visitor lands on vagra.ai and within 10 seconds understands:
1. **What this is** — WordPress themes for specific industries
2. **Why it's different** — Native AI, not generic, free core
3. **How to get started** — Download free, import demo, add API key

The design should feel like **Vercel meets WordPress** — technical credibility with approachable warmth. Not a ThemeForest listing page. Not a generic theme shop. A curated collection of purpose-built tools, each one the best in its vertical.

---

## REFERENCE MOOD BOARD

**Aesthetic inspiration (not copy — synthesize):**
- Vercel.com — dark hero, clean grid, technical confidence
- Linear.app — glassmorphism, micro-animations, dark mode excellence
- Stripe.com — gradient accents, clear hierarchy, developer trust
- Raycast.com — command palette UX, theme previews, keyboard-first
- Cal.com — open source positioning, clean pricing, GitHub badge

**WordPress-specific inspiration (what to improve upon):**
- Avada.com — demo grid filtering (adopt), but cleaner presentation
- WPAstra.com — starter templates browsing (adopt category system), but with real niche depth
- flavor starter theme — FSE-first lightweight approach (adopt performance focus)
- ThemeForest cards — sales/review trust signals (adopt), but less cluttered

---

## DELIVERABLES

When implementing this design:
1. `vagra-showcase` theme in `wp-content/themes/vagra-showcase/`
2. `style.css` with complete design token system
3. `front-page.php` with all 9 sections
4. `page-theme-single.php` for individual theme pages
5. `page-preview.php` for live preview iframe
6. `assets/js/showcase.js` — scroll animations, device switcher, chat demo, counter animation
7. `assets/css/showcase.css` — component styles
8. `screenshot.png` (1200x900)
9. Demo content for the showcase site itself
