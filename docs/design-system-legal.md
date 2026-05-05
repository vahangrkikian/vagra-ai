# Legal Theme Design System

## Typography
- **Headings:** Playfair Display (400, 700) — conveys authority and tradition
- **Body:** Inter (300, 400, 500, 700) — modern, highly readable
- **Google Fonts URL:** https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;700&display=swap

## Color Palette
| Token | Hex | Usage |
|-------|-----|-------|
| --vagra-primary | #1B3A5C | CTA buttons, links, active states (navy — trust) |
| --vagra-primary-hover | #152E49 | Button hover, link hover |
| --vagra-accent | #C9A84C | Highlights, borders, premium indicators (gold) |
| --vagra-dark | #1A1A2E | Headings, dark text, footer background |
| --vagra-muted | #6B7B8D | Secondary text, descriptions, meta |
| --vagra-light | #F5F6F8 | Section backgrounds, card backgrounds |
| --vagra-white | #FFFFFF | Page background, card surfaces |
| --vagra-success | #2E7D5B | Positive indicators (case won, available) |
| --vagra-warning | #D4A030 | Attention, consultation urgency |
| --vagra-danger | #C0392B | Error states, urgent notices |

## Spacing Scale
4px / 8px / 16px / 24px / 32px / 48px / 64px (same as MSP)

## Border Radius
- Default: 8px (sharper than MSP — conveys precision)
- Small: 4px (tags, badges)
- Large: 12px (hero sections, feature blocks)

## Shadows
- Default: 0 2px 8px rgba(26,26,46,0.08)
- Large: 0 8px 24px rgba(26,26,46,0.12)

## Container
Max width: 1200px, center-aligned, 16px horizontal padding

## Component Patterns

### Buttons
- Primary: navy bg (#1B3A5C), white text, 8px radius, 14px 28px padding
- Secondary: transparent bg, navy border, navy text
- Accent: gold border (#C9A84C), navy text — for premium actions
- Hover: darken bg to #152E49

### Cards
- White background, 8px radius, 24px padding, default shadow
- Optional: gold top border (2px) for featured items
- Hover state: large shadow

### Hero Section
- Full-width, dark navy gradient or professional office image
- Heading: Playfair Display 700, 44px desktop / 30px mobile
- Subheading: Inter 400, 18px, white or light
- CTA button centered or left-aligned

### Practice Area Grid
- 3 columns desktop, 2 tablet, 1 mobile
- Each card: icon (scale of justice, gavel, etc. as SVG), title, short description
- Gold top border on hover
- 24px gap between cards

### Attorney Grid
- 3-4 columns desktop, 2 tablet, 1 mobile
- Photo placeholder (circle or rounded square), name, title, specialization
- Link to individual attorney page

### Case Results Bar
- Dark background (#1A1A2E)
- Large numbers in gold (#C9A84C): "$10M+ Recovered", "500+ Cases Won", "20+ Years"
- Roboto or Inter bold for numbers

### Testimonial Section
- Light background
- Quote marks in gold
- Client name (first name + last initial only), case type
- Carousel or grid layout

### CTA Section
- Navy background
- White heading, gold accent line
- "Schedule Your Free Consultation" — white button with gold border
