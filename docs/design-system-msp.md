# MSP Cybersecurity Design System

## Source
Derived from the MLP (MSP DMARC Marketing Playbook) production design system.

## Typography
- **Headings:** Poppins (400, 500, 600, 700)
- **Body:** Roboto (300, 400, 500, 700)
- **Google Fonts URL:** https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap

## Color Palette
| Token | Hex | Usage |
|-------|-----|-------|
| --vagra-primary | #3366FF | CTA buttons, links, active states |
| --vagra-primary-hover | #2952CC | Button hover, link hover |
| --vagra-dark | #2B3674 | Headings, dark text, footer background |
| --vagra-muted | #68769F | Secondary text, descriptions, meta |
| --vagra-light | #F4F7FE | Section backgrounds, card backgrounds |
| --vagra-white | #FFFFFF | Page background, card surfaces |
| --vagra-success | #05CD99 | Positive indicators, checkmarks |
| --vagra-warning | #FFCE20 | Alerts, attention indicators |
| --vagra-danger | #EE5D50 | Error states, threat indicators |

## Spacing Scale
4px / 8px / 16px / 24px / 32px / 48px / 64px

## Border Radius
- Default: 16px (cards, buttons, inputs)
- Small: 8px (tags, badges)
- Large: 24px (hero sections, feature blocks)

## Shadows
- Default: 0 4px 6px -1px rgba(43,54,116,0.1), 0 2px 4px -2px rgba(43,54,116,0.1)
- Large: 0 10px 15px -3px rgba(43,54,116,0.1), 0 4px 6px -4px rgba(43,54,116,0.1)

## Container
Max width: 1200px, center-aligned, 16px horizontal padding

## Component Patterns

### Buttons
- Primary: blue bg (#3366FF), white text, 16px radius, 12px 24px padding
- Secondary: transparent bg, blue border, blue text
- Hover: darken bg to #2952CC

### Cards
- White background, 16px radius, 24px padding, default shadow
- Hover state: large shadow

### Hero Section
- Full-width, dark gradient or image background
- Heading: Poppins 700, 48px desktop / 32px mobile
- Subheading: Roboto 400, 18px, muted color on dark bg use white
- CTA button centered or left-aligned

### Service Grid
- 3 columns desktop, 2 tablet, 1 mobile
- Each card: icon (SVG placeholder), title, short description
- 24px gap between cards

### Social Proof Bar
- Light background (#F4F7FE)
- Logo row with grayscale filter, centered
- "Trusted by X+ MSPs" heading above

### CTA Section
- Primary blue background
- White heading and text
- White-outlined or solid white button
