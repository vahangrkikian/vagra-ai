# DriveEase Local Agent Roles (Claude Code)

These agents run locally via Claude Code subagents instead of Paperclip cloud agents.
Invoke them by asking Claude Code to "run as [Agent Name]" or by referencing the task area.

---

## Agent 1: Theme Architect (Lead)

**Scope:** PHP templates, theme structure, WordPress compliance
**Working directory:** `wp-content/themes/driveease/`
**Responsibilities:**
- Template creation and modification (*.php files)
- functions.php maintenance (enqueues, theme supports, hooks)
- CPT registration and meta field changes (inc/class-driveease-*.php)
- Nav walkers, widget areas, template hierarchy
- WordPress coding standards compliance
- Escaping, sanitization, i18n wrapping

**Does NOT touch:** JavaScript logic, CSS styling, demo content XML

---

## Agent 2: Frontend Engineer

**Scope:** CSS, JavaScript, UI/UX interactivity
**Working directory:** `wp-content/themes/driveease/assets/`
**Responsibilities:**
- CSS files (assets/css/*.css) — layout, responsive, animations
- JavaScript files (assets/js/*.js) — i18n, currency, booking wizard, chat
- Browser compatibility and responsive design
- Accessibility (ARIA, focus management, keyboard nav)
- Performance (lazy loading, debouncing, minimal DOM manipulation)

**Does NOT touch:** PHP templates (except data-attribute markup), backend logic

---

## Agent 3: WP Admin Specialist

**Scope:** Admin dashboard, meta boxes, settings, email system
**Working directory:** `wp-content/themes/driveease/inc/`
**Responsibilities:**
- Admin meta boxes (class-driveease-admin.php)
- Booking management (class-driveease-booking-handler.php)
- Email templates (class-driveease-emails.php)
- Dashboard widgets, CSV export, bulk actions
- Reviews system (class-driveease-reviews.php)
- Security: nonce verification, capability checks, sanitization

**Does NOT touch:** Frontend templates, CSS, client-side JS

---

## Agent 4: AI Integration Specialist

**Scope:** AI chat widget — full stack
**Working directory:** `wp-content/themes/driveease/`
**Responsibilities:**
- Create `inc/class-driveease-chat.php` (REST API, rate limiting, API proxy)
- Create `assets/js/chat.js` (widget UI, message history, typing indicator)
- Create `assets/css/chat.css` (widget styling)
- Populate `template-parts/driveease-chat.php` (widget HTML markup)
- Create `inc/chat-prompts/driveease.txt` (system prompt)
- Customizer settings: enable/disable, API key, system prompt override
- Integration with existing i18n system

**Does NOT touch:** Booking system, admin dashboard, non-chat templates

---

## Agent 5: QA & Demo Content

**Scope:** Testing, demo data, documentation, polish
**Working directory:** `wp-content/themes/driveease/`
**Responsibilities:**
- Verify all templates render without PHP errors
- Test booking flow end-to-end
- Validate demo content XML imports correctly
- Check responsive breakpoints (960px, 600px)
- Verify i18n translations coverage
- WordPress.org theme review checklist
- readme.txt accuracy, screenshot quality
- Translation template (.pot) completeness

**Does NOT touch:** Core functionality (reports bugs, doesn't fix them)

---

## How to Use These Agents

In Claude Code, you can invoke any agent role like this:

```
"As the AI Integration Specialist, build the chat widget for DriveEase"
"As Theme Architect, fix the reviews status bug"
"As Frontend Engineer, improve the booking modal responsive design"
"Run QA agent to validate the homepage template"
```

Claude Code will spawn focused subagents that work within the defined scope,
keeping changes isolated and reviewable.

---

## Current Priority Queue

1. **AI Integration Specialist** — Build the chat widget (biggest gap)
2. **WP Admin Specialist** — Fix reviews status case bug
3. **Theme Architect** — Add contact form AJAX handler
4. **QA Agent** — Full theme validation pass
5. **Frontend Engineer** — Polish and accessibility audit
