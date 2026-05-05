# AI Chat Component Specification

## Architecture
The AI chat component is a shared module used by both themes, styled via CSS custom properties so it adapts to each theme's design system.

## Files
```
template-parts/ai-chat.php    — PHP template rendering the chat widget HTML
assets/js/vagra-chat.js       — Chat UI logic (vanilla JS, no framework)
assets/css/vagra-chat.css      — Chat widget styles using CSS custom properties
inc/class-vagra-chat.php       — PHP class for configuration, settings, REST API proxy
inc/chat-prompts/{slug}.txt    — Default system prompts per theme
```

## Frontend (vagra-chat.js)

### Widget Structure
```html
<div class="vagra-chat" id="vagra-chat">
  <button class="vagra-chat__toggle" aria-label="Open chat">
    <svg><!-- chat icon --></svg>
  </button>
  <div class="vagra-chat__window" aria-hidden="true">
    <div class="vagra-chat__header">
      <span class="vagra-chat__title">Ask us anything</span>
      <button class="vagra-chat__close" aria-label="Close chat">&times;</button>
    </div>
    <div class="vagra-chat__messages" role="log" aria-live="polite">
      <!-- messages render here -->
    </div>
    <form class="vagra-chat__input-form">
      <input type="text" class="vagra-chat__input" placeholder="Type your question..." />
      <button type="submit" class="vagra-chat__send" aria-label="Send">
        <svg><!-- send icon --></svg>
      </button>
    </form>
  </div>
</div>
```

### Behavior
- Toggle button fixed to bottom-right corner (24px from edges)
- Click toggle → window slides up with CSS transition
- Messages alternate: user (right-aligned) and assistant (left-aligned)
- Typing indicator while waiting for response (three-dot animation)
- Chat history stored in sessionStorage (cleared on tab close)
- Max 50 messages in history before oldest are removed
- Input auto-focuses when window opens
- Enter key sends, Shift+Enter for newline
- Accessible: ARIA roles, keyboard navigation, screen reader announcements

### API Communication
- POST to WordPress REST API: `/wp-json/vagra/v1/chat`
- Request body: `{ "message": "user text", "history": [...previous messages] }`
- Response: `{ "reply": "assistant text" }`
- Error handling: show friendly message, retry button
- No streaming in v1 (full response only)

## Backend (class-vagra-chat.php)

### REST API Endpoint
```php
register_rest_route('vagra/v1', '/chat', [
    'methods'  => 'POST',
    'callback' => [$this, 'handle_chat'],
    'permission_callback' => '__return_true', // public endpoint
]);
```

### Configuration (Customizer)
- **Enable/Disable:** checkbox, default enabled
- **API Key:** password field, stored encrypted in wp_options
- **System Prompt Override:** textarea, falls back to inc/chat-prompts/{slug}.txt
- **Chat Title:** text field, default "Ask us anything"
- **Disclaimer Text:** textarea (for legal theme: "This is not legal advice...")

### API Proxy Logic
1. Receive message + history from frontend
2. Load system prompt (custom or default from file)
3. Build messages array: system prompt + history + new message
4. Call Claude API (messages endpoint)
5. Return assistant response
6. Rate limiting: max 20 requests per session per hour (tracked via transient + IP hash)
7. No chat data stored in database. No logging of conversations.

### Security
- Nonce verification on REST endpoint
- Input sanitization on all fields
- API key never exposed to frontend
- Rate limiting to prevent abuse
- No PII stored server-side
- CORS headers restricted to same-origin

## System Prompts

### MSP Cybersecurity (vagra-msp.txt)
```
You are a friendly cybersecurity advisor for an MSP company. You help website visitors understand managed security services, email security (DMARC, DKIM, SPF), endpoint protection, and network monitoring.

Rules:
- Answer service questions clearly and helpfully
- Explain security concepts in plain language, avoid jargon
- If asked about pricing, say: "Pricing depends on your specific needs. I'd recommend scheduling a free security assessment so our team can give you an accurate quote."
- If asked for technical support, say: "For existing client support, please contact our helpdesk directly at [support email]. I'm here to help new visitors learn about our services."
- When a visitor shows buying intent (asks about getting started, wants a quote, compares services), ask for their name, email, and company size so the team can follow up.
- Keep responses concise — 2-3 sentences for simple questions, up to a paragraph for detailed explanations.
- Never make up specific statistics, certifications, or guarantees.
```

### Legal (vagra-legal.txt)
```
You are a professional intake assistant for a law firm. You help website visitors understand the firm's practice areas and guide them toward scheduling a consultation.

Rules:
- IMPORTANT: Begin every conversation with: "Please note: I'm an AI assistant. I can provide general information about our practice areas, but nothing I say constitutes legal advice. For legal counsel specific to your situation, please schedule a free consultation."
- Answer questions about practice area overviews, general legal processes, and firm information
- Never provide legal advice, case assessments, or specific legal recommendations
- Never ask for or discuss case details in chat — direct them to a private consultation
- If asked about fees, say: "Fee structures vary by case type. We offer free initial consultations where we can discuss your situation and applicable fees in detail."
- When a visitor wants to schedule, collect: name, email, general case type (dropdown or free text), and preferred contact method
- Maintain a professional, empathetic tone — many visitors are in stressful situations
- Keep responses concise and clear
- Never make up case results, attorney credentials, or success rates
```

## Styling (vagra-chat.css)

The chat widget uses CSS custom properties from the parent theme, so it automatically adapts:
- `--vagra-primary` → send button, user message bubbles
- `--vagra-dark` → header background, assistant message text
- `--vagra-muted` → placeholder text, timestamps
- `--vagra-light` → assistant message bubbles
- `--vagra-white` → window background
- `--vagra-radius` → message bubbles, input field, window corners
- `--vagra-font-body` → all chat text
- `--vagra-font-heading` → chat title

## What Is NOT in v1
- No streaming responses (full response only)
- No file upload in chat
- No conversation export
- No multi-language auto-detection (uses site language)
- No analytics or tracking
- No WebSocket — REST polling only
- No chat-to-email transcript
