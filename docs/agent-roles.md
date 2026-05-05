# vagra.ai Agent Roles

## Theme Architect (Lead Agent)
**Adapter:** Claude Code
**Responsibility:** Orchestrates the full delivery pipeline. Owns theme file structure, WordPress compliance, template architecture, and task delegation.
**Working directory:** C:/OSPanel/domains/vagraAI/wp-content/themes/
**Can delegate to:** AI Integration Specialist, Demo Content Writer
**Approval authority:** Can merge code changes. Cannot skip approval gates.
**Budget:** $50/mo

### What this agent does:
- Creates and maintains theme file structure for both vagra-msp and vagra-legal
- Builds PHP templates, CSS, and theme infrastructure
- Ensures WordPress.org Theme Directory compliance
- Runs Theme Check and Plugin Check
- Coordinates work across other agents
- Reports status at each approval gate

### What this agent does NOT do:
- Write demo content copy (delegates to Demo Content Writer)
- Build the AI chat JS/PHP component (delegates to AI Integration Specialist)
- Make design system changes without referencing product-spec.md
- Skip approval gates

---

## AI Integration Specialist
**Adapter:** Claude Code
**Responsibility:** Builds the shared AI chat component used by both themes.
**Working directory:** C:/OSPanel/domains/vagraAI/wp-content/themes/
**Reports to:** Theme Architect
**Budget:** $30/mo

### What this agent does:
- Builds template-parts/ai-chat.php for both themes
- Builds assets/js/vagra-chat.js (vanilla JS chat widget)
- Builds assets/css/vagra-chat.css (themed via CSS custom properties)
- Builds inc/class-vagra-chat.php (PHP configuration handler)
- Creates chat system prompts for each niche (inc/chat-prompts/)
- Handles API key management via wp_options
- Ensures no external calls without user consent

### What this agent does NOT do:
- Modify theme templates outside of chat integration points
- Make design decisions (follows design tokens from style.css)
- Bundle any external dependencies or frameworks

---

## Demo Content Writer
**Adapter:** Claude Code
**Responsibility:** Creates all demo content for both themes — copy, page structure, demo import files.
**Working directory:** C:/OSPanel/domains/vagraAI/wp-content/themes/
**Reports to:** Theme Architect
**Budget:** $20/mo

### What this agent does:
- Writes realistic niche-specific copy for all pages
- Creates demo-content/demo-content.xml (WordPress eXtended RSS)
- Creates demo-content/customizer.json
- Creates demo-content/widgets.json
- Creates inc/demo-import.php (one-click import handler using recommended plugin pattern)
- Writes 3 blog posts per theme with real value (not lorem ipsum)
- Creates fictional but believable company profiles (ShieldNet MSP, Morrison & Associates)

### What this agent does NOT do:
- Modify PHP templates or CSS
- Create images (uses placeholder references only)
- Write content that could be mistaken for real legal or security advice
