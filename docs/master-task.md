# Master Task — Copy this into Paperclip as the orchestration issue

## Title
Deliver MSP Cybersecurity + Legal WordPress themes with AI chat and demo content

## Description

You are the Theme Architect, lead agent for vagra.ai. Your job is to deliver two complete WordPress themes ready for WordPress.org submission.

### Context Files (read ALL before starting)
- C:/OSPanel/domains/vagraAI/docs/product-spec.md — what ships
- C:/OSPanel/domains/vagraAI/docs/orchestration-plan.md — phased delivery plan with 3 approval gates
- C:/OSPanel/domains/vagraAI/docs/agent-roles.md — your role and specialist roles
- C:/OSPanel/domains/vagraAI/docs/design-system-msp.md — MSP theme design tokens
- C:/OSPanel/domains/vagraAI/docs/design-system-legal.md — Legal theme design tokens
- C:/OSPanel/domains/vagraAI/docs/wordpress-standards.md — WordPress.org compliance rules
- C:/OSPanel/domains/vagraAI/docs/ai-chat-spec.md — AI chat component specification

### Environment
- WordPress 6.9.4 installed at C:/OSPanel/domains/vagraAI/
- Site URL: vagraai.local
- WP-CLI available
- MSP theme scaffold already exists at wp-content/themes/vagra-msp/ (style.css with design tokens, functions.php, basic templates)
- Legal theme does NOT exist yet — create it

### Execution Rules
1. Follow the orchestration-plan.md exactly — Phase 1, then Gate 1, then Phase 2, then Gate 2, then Phase 3, then Gate 3
2. At each gate, STOP and report status. List what was completed, what works, what doesn't. Wait for human approval before proceeding.
3. When you need specialist work (AI chat component, demo content), create sub-issues and assign to the appropriate agent role
4. All code goes in C:/OSPanel/domains/vagraAI/wp-content/themes/vagra-msp/ or vagra-legal/
5. Test everything with WP-CLI commands where possible
6. Follow WordPress coding standards — prefix, escape, sanitize, translate
7. Do not install plugins. Do not modify wp-config.php. Do not touch the database directly.

### Phase 1 Checklist (do this first)
- [ ] Complete MSP front-page.php (hero, 6 service cards, social proof, CTA)
- [ ] Add front page CSS to MSP style.css
- [ ] Set MSP static front page via WP-CLI
- [ ] Create vagra-legal/ theme with full scaffold
- [ ] Build Legal front-page.php (hero, 6 practice areas, attorney spotlight, case results, testimonials, CTA)
- [ ] Build inner page templates for both themes (services/practice areas, about, contact)
- [ ] Build headers and footers for both themes
- [ ] Verify both themes render at vagraai.local
- [ ] STOP — Report Gate 1 status and wait for approval

### After Gate 1 Approval
Proceed to Phase 2 per orchestration-plan.md. Create sub-issues for AI Integration Specialist.

### After Gate 2 Approval
Proceed to Phase 3 per orchestration-plan.md. Create sub-issues for Demo Content Writer.
