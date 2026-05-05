# Orchestration Plan — vagra.ai Theme Delivery

## Overview
This plan delivers two WordPress themes (MSP Cybersecurity + Legal) through three phases with approval gates. Agents work autonomously between gates. Founders review at each gate.

## Agents
1. **Theme Architect** (lead) — templates, CSS, theme infrastructure, WP compliance
2. **AI Integration Specialist** — chat component (shared across both themes)
3. **Demo Content Writer** — copy, demo import files, blog posts

## Phase 1: Front Pages (→ Gate 1)

### 1.1 — Theme Architect: Complete MSP front page
- Build front-page.php with hero, 6 service cards, social proof bar, CTA section
- Add all front page CSS to style.css
- Set up WordPress static front page via WP-CLI
- Verify renders correctly at vagraai.local

### 1.2 — Theme Architect: Scaffold Legal theme
- Create vagra-legal/ theme directory in wp-content/themes/
- style.css with Legal design tokens (Playfair Display/Inter, #1B3A5C/#C9A84C/#1A1A2E/#6B7B8D, 8px radius)
- functions.php, all core templates, template parts (same structure as MSP)
- front-page.php with hero, 6 practice area cards, attorney spotlight, case results bar, testimonials, CTA

### 1.3 — Theme Architect: Inner pages for both themes
- MSP: services.php (single service detail), about page template, contact page template
- Legal: practice-area.php (single practice area detail), attorneys.php (team grid), attorney-single.php (individual profile), about page template, contact page template
- Blog templates: archive.php, category.php for both themes
- search.php for both themes

### 1.4 — Theme Architect: Header and footer for both themes
- MSP header: logo, primary nav, CTA button
- MSP footer: 3-column widget area, footer nav, copyright
- Legal header: logo, primary nav, phone number, CTA button
- Legal footer: 4-column (about, practice areas, contact info, newsletter), footer nav, copyright, bar association disclaimer

**Gate 1 Deliverable:** Both themes render front pages and inner pages in browser. No AI chat, no demo content. Just templates + CSS.

**Gate 1 Review:** Founders open vagraai.local, switch between themes, check all pages render. Visual quality check. Go/no-go.

---

## Phase 2: AI Chat Integration (→ Gate 2)

### 2.1 — AI Integration Specialist: Build shared chat component
- template-parts/ai-chat.php
- assets/js/vagra-chat.js (vanilla JS, full implementation per ai-chat-spec.md)
- assets/css/vagra-chat.css
- inc/class-vagra-chat.php (REST API proxy, Customizer settings, rate limiting)

### 2.2 — AI Integration Specialist: MSP chat configuration
- inc/chat-prompts/vagra-msp.txt (system prompt)
- Integrate ai-chat.php into MSP footer.php
- Test with Claude API key
- Verify 10 test queries:
  1. "What services do you offer?"
  2. "What is DMARC?"
  3. "How much does email security cost?"
  4. "I need help with my current setup" (support redirect)
  5. "We're a 50-person company looking for endpoint protection"
  6. "What's the difference between DKIM and SPF?"
  7. "Can you do a security audit?"
  8. "I want to get started" (lead capture flow)
  9. "Do you work with healthcare companies?"
  10. "What compliance frameworks do you support?"

### 2.3 — AI Integration Specialist: Legal chat configuration
- inc/chat-prompts/vagra-legal.txt (system prompt)
- Integrate ai-chat.php into Legal footer.php
- Verify disclaimer appears first message
- Test with Claude API key
- Verify 10 test queries:
  1. "What areas of law do you practice?"
  2. "I was in a car accident last week"
  3. "How much do you charge?"
  4. "Can you give me legal advice about my custody case?" (must decline)
  5. "I need to form an LLC"
  6. "What should I bring to a consultation?"
  7. "I want to schedule a meeting" (lead capture flow)
  8. "How long does a personal injury case take?"
  9. "Do you offer payment plans?"
  10. "What's the statute of limitations in my state?" (must decline specific advice)

### 2.4 — Theme Architect: Customizer integration
- AI Chat settings section in both themes
- API key field (stored encrypted)
- Enable/disable toggle
- System prompt override textarea
- Chat title override
- Disclaimer text field (Legal theme)

**Gate 2 Deliverable:** AI chat works on both themes. Responds appropriately to test queries. Customizer settings functional.

**Gate 2 Review:** Founders test chat on both themes, verify responses, check Customizer controls. Go/no-go.

---

## Phase 3: Demo Content + WordPress.org Submission (→ Gate 3)

### 3.1 — Demo Content Writer: MSP demo content
- "ShieldNet MSP" company profile
- 6 service page copies
- About page copy with team (4 members)
- Contact page with fictional address
- 3 blog posts (email security tips, DMARC explainer, incident response checklist)
- 3 client testimonials
- All content in demo-content/demo-content.xml

### 3.2 — Demo Content Writer: Legal demo content
- "Morrison & Associates" firm profile
- 6 practice area page copies
- 4 attorney profile bios
- About page with firm history
- Contact page with 2 fictional office locations
- 3 blog posts (car accident guide, estate planning intro, business formation guide)
- 5 case results (anonymized)
- 4 client testimonials
- All content in demo-content/demo-content.xml

### 3.3 — Theme Architect: Demo import system
- inc/demo-import.php for both themes
- Uses recommended plugin pattern (suggests One Click Demo Import)
- customizer.json export for both themes
- widgets.json export for both themes
- Test: fresh WordPress install → activate theme → import demo → verify all pages

### 3.4 — Theme Architect: WordPress.org submission prep
- screenshot.png for both themes (1200x900)
- readme.txt for both themes
- .pot translation files in /languages/
- Run Theme Check — fix all errors
- Run Plugin Check — fix all errors
- Final escaping/sanitization audit
- Verify PageSpeed > 90 on front page

**Gate 3 Deliverable:** Both themes complete with demo content, passing Theme Check and Plugin Check. Ready for WordPress.org submission.

**Gate 3 Review:** Founders do full walkthrough — fresh install, demo import, all pages, chat, PageSpeed. Ship/no-ship decision.

---

## Timeline Estimate
- Phase 1: ~1 week of agent work
- Phase 2: ~1 week of agent work
- Phase 3: ~1 week of agent work
- Buffer for gate reviews and fixes: 1 week
- Total: ~4 weeks to submission-ready

## Budget Estimate
- Theme Architect: ~$50 (primary workload)
- AI Integration: ~$30
- Demo Content: ~$20
- Total: ~$100 for full delivery
