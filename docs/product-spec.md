# vagra.ai Product Spec v0.1

## Mission
Ship two AI-powered WordPress niche themes (MSP Cybersecurity, Legal) to WordPress.org, proving that narrow niche-AI themes with native chat outperform generic chatbot plugins in their respective markets.

## What Ships

Two WordPress themes, each with:
- Full front page template (niche-specific sections)
- Inner page templates (About, Services/Practice Areas, Contact)
- Native AI chat component (template part + JS widget, not a plugin)
- One-click demo import (XML + Customizer settings + widget data)
- Trilingual-ready structure (English primary, Armenian/Russian as translation-ready)
- WordPress.org Theme Directory compliant (Theme Check + Plugin Check passing)

## Theme 1: Vagra MSP Cybersecurity

### Target User
Small-to-mid MSP/MSSP businesses (1-50 employees) who need a professional site within 48 hours.

### Pages
- **Front Page:** Hero with security shield visual, 6 service cards (DMARC/DKIM/SPF, Email Security, Endpoint Protection, Network Monitoring, Incident Response, Security Awareness Training), social proof bar, CTA "Free Security Assessment"
- **Services:** Individual service detail template
- **About:** Team/company story with trust signals (certifications, partnerships)
- **Contact:** Form + office info + map placeholder
- **Blog/Resources:** Standard post listing with cybersecurity category taxonomy

### AI Chat Behavior
- Persona: Friendly MSP security advisor
- Can answer: service questions, basic security concepts, qualification questions ("What's your current email security setup?")
- Cannot answer: pricing (defers to human), technical support for existing clients
- Lead capture: collects name + email + company size when visitor shows buying intent
- System prompt ships with theme as a configurable file

### Design System (MLP tokens — already implemented)
- Fonts: Poppins (headings), Roboto (body)
- Primary: #3366FF, Dark: #2B3674, Muted: #68769F
- Border radius: 16px
- Component library: buttons, cards, hero, service grid, CTA blocks, guarantee box

### Demo Content
One complete demo: "ShieldNet MSP" — fictional MSP company with:
- 6 service pages with realistic copy
- 3 blog posts (email security tips, DMARC explainer, incident response checklist)
- Team section with 4 placeholder members
- Testimonials from 3 fictional clients
- All images from placeholder service (no copyrighted assets)

---

## Theme 2: Vagra Legal

### Target User
Small-to-mid law firms (solo practitioners to 20-attorney firms) who need a professional, trust-building site.

### Pages
- **Front Page:** Hero with professional imagery, practice area cards (6 areas), attorney spotlight, case results/stats bar, testimonial section, CTA "Free Consultation"
- **Practice Areas:** Individual practice area detail template (e.g., Personal Injury, Family Law, Criminal Defense, Business Law, Immigration, Estate Planning)
- **Attorneys:** Team grid with individual attorney profile pages
- **About:** Firm story, values, awards/recognitions
- **Contact:** Form + office locations + map placeholder
- **Blog/Resources:** Legal insights with practice area category taxonomy

### AI Chat Behavior
- Persona: Professional intake assistant
- Can answer: practice area overviews, office hours, general legal process questions ("What happens after I file a personal injury claim?")
- Cannot answer: legal advice (explicit disclaimer), case-specific questions, pricing
- Lead capture: collects name + email + case type + brief description
- Disclaimer: "This is not legal advice. For legal counsel, please schedule a consultation."
- System prompt ships with theme as a configurable file

### Design System
- Fonts: Playfair Display (headings — conveys authority/tradition), Inter (body — clean readability)
- Primary: #1B3A5C (navy — trust/authority), Accent: #C9A84C (gold — prestige), Dark: #1A1A2E, Muted: #6B7B8D
- Border radius: 8px (sharper than MSP — conveys precision)
- Component library: inherits vagra base components, reskinned with legal tokens

### Demo Content
One complete demo: "Morrison & Associates" — fictional mid-size law firm with:
- 6 practice area pages with realistic copy
- 4 attorney profiles with bios and specializations
- 3 blog posts (what to do after a car accident, understanding estate planning, business formation guide)
- Case results section with 5 anonymized outcomes
- Testimonials from 4 fictional clients
- All images from placeholder service

---

## Shared Architecture

### AI Chat Component
Both themes share the same AI chat engine, skinned differently per theme:
- `template-parts/ai-chat.php` — renders the chat widget
- `assets/js/vagra-chat.js` — chat UI logic (vanilla JS, no framework)
- `assets/css/vagra-chat.css` — chat styling using theme's CSS custom properties
- `inc/class-vagra-chat.php` — PHP handler for chat configuration
- Chat backend: configurable API endpoint (Claude API default, user provides own key)
- System prompt: `/inc/chat-prompts/{theme-slug}.txt` — editable by theme user
- No data stored on external servers. Chat history stays in browser session.

### Theme Structure (both themes follow)
```
vagra-{slug}/
  style.css              (theme headers + design tokens)
  functions.php          (setup, enqueue, widget areas)
  index.php
  front-page.php
  page.php
  single.php
  archive.php
  404.php
  header.php
  footer.php
  sidebar.php
  searchform.php
  template-parts/
    content.php
    content-single.php
    content-page.php
    content-none.php
    ai-chat.php
  inc/
    class-vagra-chat.php
    customizer.php
    demo-import.php
    chat-prompts/{slug}.txt
  assets/
    css/vagra-chat.css
    js/main.js
    js/vagra-chat.js
    images/
  demo-content/
    demo-content.xml
    customizer.json
    widgets.json
```

### WordPress.org Compliance Requirements
- No external API calls without user consent (chat is opt-in, user provides API key)
- No bundled plugins (demo import uses built-in WordPress importer or recommended plugin pattern)
- Prefix all functions/classes/hooks with `vagra_msp_` or `vagra_legal_`
- Escape all output, sanitize all input
- Translation-ready with .pot file
- screenshot.png at 1200x900
- readme.txt with required sections
- GPL v2 or later license
- Must pass Theme Check plugin
- Must pass Plugin Check plugin

### What Is NOT in v1
- No Gutenberg blocks (classic theme, not block theme)
- No page builder dependency (no Elementor, no WPBakery)
- No WooCommerce integration
- No multilingual plugin bundling (translation-ready only)
- No admin panel beyond Customizer
- No premium/freemium split — both themes are fully free on WordPress.org
- No user accounts or registration features

---

## Success Criteria
1. Both themes pass WordPress.org Theme Check with zero errors
2. Both themes pass Plugin Check with zero errors
3. Demo import works in under 2 minutes on a fresh WordPress install
4. AI chat responds correctly to 10 test queries per niche
5. PageSpeed score > 90 on front page with demo content
6. Both themes submitted to WordPress.org within 3 months of project start

## Open Questions
- [ ] Claude API key management: should the theme use wp_options or a separate config file?
- [ ] Demo images: which placeholder service? (Unsplash API, local bundled, or generated?)
- [ ] Should the chat widget be closeable/minimizable or always visible?
- [ ] Legal disclaimer handling: footer banner, chat preamble, or both?
