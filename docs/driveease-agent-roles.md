# Agent Roles — DriveEase Car Rental Theme

## 1. Theme Architect (Lead Agent)

| Field | Value |
|-------|-------|
| **Adapter** | Claude Code |
| **Working directory** | `C:/OSPanel/domains/vagraAI/wp-content/themes/driveease/` |
| **Responsibility** | Orchestrates full delivery. Owns theme structure, WordPress compliance, template architecture, CPT registration, CSS fidelity, task delegation. |
| **Authority** | Can merge code changes. Cannot skip approval gates. |
| **Prefix** | `driveease_` (functions), `.de-` (CSS classes where needed) |
| **Text domain** | `driveease` |

### Does:
- Creates and maintains theme file structure
- Registers all CPTs (car, booking, branch) and meta fields
- Builds all PHP templates (header, footer, front-page, single-car, archive, contact, page)
- Extracts and organizes CSS from static prototypes into proper asset files
- Ensures WordPress.org coding standards compliance
- Creates template parts (booking modal, chat widget, car cards)
- Runs Theme Check and validates
- Coordinates work across specialist agents
- Reports status at approval gates

### Does NOT:
- Write AJAX/REST endpoints for booking processing (delegates to WP Admin)
- Build admin dashboard/meta boxes UI (delegates to WP Admin)
- Write complex JavaScript interactions (delegates to AI Integration)
- Create demo content or sample data (delegates to Demo Content Writer)
- Skip approval gates

---

## 2. WP Admin Specialist

| Field | Value |
|-------|-------|
| **Adapter** | Claude Code |
| **Working directory** | `C:/OSPanel/domains/vagraAI/wp-content/themes/driveease/inc/` |
| **Responsibility** | Backend functionality — booking system, admin UX, email notifications, REST API, meta boxes. |

### Does:
- Booking AJAX endpoint (validate, check availability, create post, send email)
- Availability REST API (`/wp-json/driveease/v1/availability/{car_id}`)
- Admin meta boxes for car specs, booking details, branch info
- Custom admin columns + sortable fields
- Dashboard widget (today's pickups/returns/pending)
- Status transition logic
- CSV export functionality
- Email templates (confirmation, reminder, cancellation)
- Nonce verification, input sanitization

### Does NOT:
- Modify frontend templates
- Write CSS or touch design
- Create JavaScript for frontend

---

## 3. AI Integration Specialist

| Field | Value |
|-------|-------|
| **Adapter** | Claude Code |
| **Working directory** | `C:/OSPanel/domains/vagraAI/wp-content/themes/driveease/assets/js/` |
| **Responsibility** | All JavaScript functionality, chat widget backend, frontend interactivity. |

### Does:
- i18n system (EN/HY language switching with data-i18n)
- Multi-currency system (USD/EUR/AMD conversion)
- Booking modal wizard (step navigation, validation, AJAX submission)
- Fleet category filtering
- Car gallery thumbnail switching
- Sidebar price calculator
- Contact form AJAX submission
- Chatbot widget (keyword responses + optional AI backend)
- `inc/class-driveease-chat.php` (REST API for AI chat, rate limiting)

### Does NOT:
- Modify PHP templates or CSS structure
- Create database entries
- Handle server-side booking logic

---

## 4. Demo Content Writer

| Field | Value |
|-------|-------|
| **Adapter** | Claude Code |
| **Working directory** | `C:/OSPanel/domains/vagraAI/wp-content/themes/driveease/demo-content/` |
| **Responsibility** | Creates realistic sample data matching the prototype. |

### Does:
- 12 car entries with full meta (matching prototype fleet: A1–F2)
- 4 branch locations with hours and addresses
- Testimonials content
- WordPress eXtended RSS export (`demo-content.xml`)
- Customizer settings export (`customizer.json`)
- Sample pages (Home, Fleet, Contact, About)
- Realistic car images (Unsplash URLs or placeholder guidance)

### Does NOT:
- Write theme code
- Modify templates
- Create functionality

---

## Coordination Rules

1. **Theme Architect** creates all sub-issues and sets dependencies
2. All agents read `driveease-orchestration-plan.md` before starting
3. Code goes only in `wp-content/themes/driveease/` — no plugin creation
4. All agents follow `wordpress-standards.md`
5. Phase 0 and Phase 1 are **Theme Architect solo** (except chat widget)
6. Phase 2 requires all three specialist agents working in parallel
7. Phase 3 requires WP Admin + Demo Content Writer
8. At each gate: Theme Architect reports, founders approve, then next phase begins
