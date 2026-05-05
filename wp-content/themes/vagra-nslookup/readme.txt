=== Vagra NSLookup ===
Contributors: vagraai
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A cinematic dark WordPress theme for DNS lookup and propagation checking tools. Features React Islands architecture for interactive tool panels.

== Description ==

Vagra NSLookup is a purpose-built WordPress theme for DNS lookup and propagation checking websites. It features a cinematic dark design inspired by Apple-style product pages, with smooth animations, glassmorphism effects, and a fully responsive layout.

**Key Features:**

* DNS Lookup Tool — Query 13 DNS record types (A, AAAA, CNAME, MX, NS, TXT, SRV, SOA, PTR, CAA, DNSKEY, DS, NAPTR) against multiple resolvers
* DNS Propagation Checker — Check DNS propagation across 30+ global resolvers with a visual world map
* AI Chat Assistant — Built-in DNS assistant powered by Claude API for answering DNS questions
* React Islands Architecture — Interactive React components hydrated on static PHP templates for optimal SEO and performance
* Cinematic Dark Theme — Apple-style hero sections with CSS word reveal, gradient accents, and floating chip animations
* WordPress Customizer Integration — Brand colors, typography, chat settings, and DNS tool configuration
* Fully Responsive — Mobile-first design with glassmorphism navigation and touch-friendly interactions
* Accessibility Ready — ARIA labels, keyboard navigation, reduced motion support
* Translation Ready — All strings internationalized with `vagra-nslookup` text domain

**Page Templates:**

* Homepage with hero tool, marquee, CLI animation, globe, features, stats, FAQ, and blog teaser
* NS Lookup tool page
* DNS Propagation Checker page
* Other DNS Tools hub page
* About, Contact, FAQ, Privacy Policy, Terms of Service pages
* Blog archive and single post templates
* Custom 404 page with mock terminal

**Sister Tool Integration:**

Cross-links to SPF Checker, DKIM Checker, DMARC Checker, and BIMI Checker sites.

== Installation ==

1. Upload the `vagra-nslookup` folder to `/wp-content/themes/`
2. Activate the theme through the 'Themes' menu in WordPress
3. Create the required pages (Home, NS Lookup, DNS Propagation Checker, Other DNS Tools, About, Contact, FAQ, Privacy Policy, Terms of Service)
4. Set the Home page as the static front page under Settings > Reading
5. Configure theme options under Appearance > Customize > nslookup.am Settings
6. (Optional) Add your Anthropic API key in the Customizer or Settings page to enable the AI chat assistant

== Building React Components ==

The theme uses Vite to build React island components:

1. Navigate to the theme directory
2. Run `npm install`
3. Run `npm run build`

Built files output to `assets/js/dist/`.

== Frequently Asked Questions ==

= Does this theme require any plugins? =

No plugins are required. The DNS lookup, propagation checking, and AI chat features are all built into the theme.

= How do I enable the AI chat assistant? =

Go to Appearance > Customize > nslookup.am Settings > AI Chat, enable the widget, and enter your Anthropic API key.

= Can I customize the colors? =

Yes. Go to Appearance > Customize > nslookup.am Settings > Brand Colors to change the primary (indigo) and accent (cyan) colors.

= Is the DNS lookup actually functional? =

Yes. The theme includes a PHP DNS lookup class that uses `dns_get_record()` with a `dig` fallback. It queries real DNS servers and returns real results.

== Changelog ==

= 1.0.0 =
* Initial release
* DNS Lookup tool with 13 record types
* DNS Propagation Checker with 30+ global resolvers
* AI Chat assistant with DNS persona
* React Islands architecture
* Cinematic dark theme with animations
* WordPress Customizer integration
* Full accessibility support

== Resources ==

* Inter font — SIL Open Font License, https://github.com/rsms/inter
* JetBrains Mono font — SIL Open Font License, https://github.com/JetBrains/JetBrainsMono
* React — MIT License, https://github.com/facebook/react
* Vite — MIT License, https://github.com/vitejs/vite
